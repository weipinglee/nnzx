<?php
/**
 * 基于RBAC的权限控制方法
 * @author panduo
 */

namespace Library\adminrbac;
class rbac
{
    private static $rbac_config = array();
    private static $dispatcher = '';
    public function __construct($dispatcher = ''){
        self::$rbac_config = \Library\tool::getConfig('rbac');
        self::$dispatcher = $dispatcher;
    }


    //用于检测用户权限的方法,并保存到Session中
    public static function saveAccessList($authId = null)
    {
        if (null === $authId) {
            $authId = $_SESSION['admin'];
        }

        // 如果使用普通权限模式，保存当前用户的访问权限列表
        // 对管理员开发所有权限
        if (!\admintool\admin::is_admin()) {
            $_SESSION['_ACCESS_LIST'] = self::getAccessList($authId);
        }

        return;
    }

    //检查当前操作是否需要认证
    public static function checkAccess()
    {
        //如果项目要求认证，并且当前模块需要认证，则进行权限认证
        if (self::$rbac_config['auth_on']) {
            $_module = array();
            $_controller['no'] = explode(',', strtolower(self::$rbac_config['no_auth_controller']));
            
            //检查当前操作是否需要认证
            if ((!empty($_controller['no']) && in_array(strtolower(self::$dispatcher->controller), $_controller['no'])) ) {

                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    
    //权限认证的过滤器方法
    public static function AccessDecision($module,$controller,$action)
    {
        //检查是否需要认证
        if (self::checkAccess()) {
            $accessList = array();
            //存在认证识别号，则进行进一步的访问决策
            $accessGuid = md5($module.$controller.$action);
            if (!\admintool\admin::is_admin()) {
                if (self::$rbac_config['auth_type'] == 2) {
                    //加强验证和即时验证模式 更加安全 后台权限修改可以即时生效
                    //通过数据库进行访问检查
                    // //var_dump(\Library\Session::get(self::$rbac_config['\Library\user_session']]['id']);
                    $auth_id = \Library\Session::get(self::$rbac_config['user_session']) ? \Library\Session::get(self::$rbac_config['user_session'])['id'] : 0;
                    $accessList = self::getAccessList($auth_id);

                    // echo $module.'-'.$controller.'-'.$action;
                } 
                // else {
                //     // 如果是管理员或者当前操作已经认证过，无需再次认证
                //     if (\Library\Session::get($accessGuid) === true) {
                //         return true;
                //     }
                //     //登录验证模式，比较登录后保存的权限访问列表
                //     $accessList = \Library\Session::get('_ACCESS_LIST');
                // }
                \Library\Session::set($accessGuid , true);
                if (!isset($accessList[strtoupper($module)][strtoupper($controller)][strtoupper($action)])) {
                    \Library\Session::set($accessGuid , false);
                    return false;
                }
                //\Library\Session::set('accessList',$accessList);
            } else {
                //管理员无需认证
                return true;
            }
        }
        return true;
    }

    //生成权限菜单
    public static function accessMenu(){
        $admin_info = \admintool\admin::sessionInfo();
        $menus = array();
        if(isset($admin_info)){
            $accessList = self::getAccessList($admin_info['id']);
            if(is_array($accessList)){
                foreach ($accessList as $k1=>$m) {
                    //$menus []= strtolower($k1);
                    foreach ($m as $k2=>$c) {
                        //$menus []= strtolower($k1.'/'.$k2);
                        foreach ($c as $k3=>$a) {
                            $menus []= strtolower($k1.'/'.$k2.'/'.$k3);
                        }
                    }
                }
            }
        }
        // \Library\Session::set('admin_menus' , $menus);
        return $menus;
    }

    /**
     * 取得当前认证号的所有权限列表
     * @param integer $authId 用户ID
     * @access public
     */
    public static function getAccessList($authId)
    {
        // Db方式权限数据
        $db    = new \Library\M('admin');
        $table = array('role' => 'admin_role', 'user' => 'admin', 'access' => 'admin_access', 'node' => 'admin_node');
        $sql   = "select node.id,node.name from " .
        $table['role'] . " as role," .
        $table['user'] . " as user," .
        $table['access'] . " as access ," .
        $table['node'] . " as node " .
        "where user.id='{$authId}' and user.role=role.id and ( access.role_id=role.id  or (access.role_id=role.pid and role.pid!=0 ) ) and role.status=0 and access.node_id=node.id and node.level=1 and node.status=0";
        $apps   = $db->query($sql,array(),"SELECT");
        $access = array();
        foreach ($apps as $key => $app) {
            $appId   = $app['id'];
            $appName = $app['name'];
            // 读取项目的模块权限
            $access[strtoupper($appName)] = array();
            $sql                          = "select node.id,node.name from " .
            $table['role'] . " as role," .
            $table['user'] . " as user," .
            $table['access'] . " as access ," .
            $table['node'] . " as node " .
            "where user.id='{$authId}' and user.role=role.id and ( access.role_id=role.id  or (access.role_id=role.pid and role.pid!=0 ) ) and role.status=0 and access.node_id=node.id and node.level=2 and node.pid={$appId} and node.status=0";
            $modules = $db->query($sql,array(),"SELECT");
            // 判断是否存在公共模块的权限
            $publicAction = array();
            foreach ($modules as $key => $module) {
                $moduleId   = $module['id'];
                $moduleName = $module['name'];
                if ('PUBLIC' == strtoupper($moduleName)) {
                    $sql = "select node.id,node.name from " .
                    $table['role'] . " as role," .
                    $table['user'] . " as user," .
                    $table['access'] . " as access ," .
                    $table['node'] . " as node " .
                    "where user.id='{$authId}' and user.role=role.id and ( access.role_id=role.id  or (access.role_id=role.pid and role.pid!=0 ) ) and role.status=1 and access.node_id=node.id and node.level=3 and node.pid={$moduleId} and node.status=1";
                    $rs = $db->query($sql,array(),"SELECT");
                    foreach ($rs as $a) {
                        $publicAction[$a['name']] = $a['id'];
                    }
                    unset($modules[$key]);
                    break;
                }
            }
            // 依次读取模块的操作权限
            foreach ($modules as $key => $module) {
                $moduleId   = $module['id'];
                $moduleName = $module['name'];
                $sql        = "select node.id,node.name from " .
                $table['role'] . " as role," .
                $table['user'] . " as user," .
                $table['access'] . " as access ," .
                $table['node'] . " as node " .
                "where user.id='{$authId}' and user.role=role.id and ( access.role_id=role.id  or (access.role_id=role.pid and role.pid!=0 ) ) and role.status=0 and access.node_id=node.id and node.level=3 and node.pid={$moduleId} and node.status=0";
                $rs     = $db->query($sql,array(),"SELECT");
                $action = array();
                foreach ($rs as $a) {
                    $action[$a['name']] = $a['id'];
                }
                // 和公共模块的操作权限合并
                $action += $publicAction;
                $access[strtoupper($appName)][strtoupper($moduleName)] = array_change_key_case($action, CASE_UPPER);
            }
        }
        return $access;
    }

}
