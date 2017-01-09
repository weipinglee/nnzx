<?php
/**
 * 子账户权限
 * User: weipinglee
 * Date: 2016/3/23
 * Time: 17:18
 */
namespace nainai;
use \Library\M;
use \Library\tool;
use \Library\Query;
class subRight{

    protected $roleRules = array(
        array('name','/^[a-zA-Z0-9_\x{4e00}-\x{9fa5}]{2,20}$/u','角色名使用非法字符',0,'regex'),

    );


    /**
     * 获取子账户权限列表
     */
    public function getSubRights(){
        $subModel = new M('subuser_right');
        $data = $subModel->limit()->select();
        return $this->generateTree($data);

    }

    /**
     * 添加角色
     * @param array $roleData 角色数组 包括权限id
     */
    public function addRole($roleData){
        $m = new M('subuser_role');

        $m->data(array('name'=>$roleData['name'],'note'=>$roleData['note'],'status'=>$roleData['status']));
        if($m->validate($this->roleRules)){
            $m->beginTrans();
            $role_id = $m->add(1);
            $role_right_data = array();
            if(!empty($roleData['right_ids'])){
                foreach($roleData['right_ids'] as $key=>$v){
                    if(!is_numeric($v))continue;
                    $role_right_data[$key]['role_id'] = $role_id;
                    $role_right_data[$key]['right_id'] = $v;
                }
                $m->table('subuser_role_right');
                $m->data($role_right_data)->adds(1);
            }
             $res = $m->commit();
        }
        else{
                $res = $m->getError();

        }
        if($res===true){
            $resInfo = tool::getSuccInfo();
        }
        else{
            $resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
        }
        return $resInfo;

    }

    /**
     * 更新角色
     * @param $roleData
     * @return array
     */
    public function updateRole($roleData){
        $m = new M('subuser_role');
        $m->data(array('name'=>$roleData['name'],'note'=>$roleData['note'],'status'=>$roleData['status']));
        if($m->validate($this->roleRules)){
            $m->beginTrans();
            $id = $roleData['id'];
            unset($m->id);
            $m->where(array('id'=>$id))->update(1);//更新角色表

            //获取角色权限表未更改前数据
            $m->table('subuser_role_right');

            $role_right_data = array();//现在的角色权限表数据
            $m->where(array('role_id'=>$id))->delete(1);
            if(!empty($roleData['right_id'])){
                foreach($roleData['right_id'] as $key=>$v){
                    if(!is_numeric($v))continue;
                    $role_right_data[$key]['role_id'] = $id;
                    $role_right_data[$key]['right_id'] = $v;
                }


                $m->data($role_right_data)->adds(1);
            }


            $res = $m->commit();
        }
        else{
            $res = $m->getError();

        }
        if($res===true){
            $resInfo = tool::getSuccInfo();
        }
        else{
            $resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
        }
        return $resInfo;
    }

    /**
     * 获取会员角色列表
     * @param int $page 页码
     * @return array
     */
    public function getRoleList($page){
        $Q = new Query('subuser_role');
        $Q->page = $page;
        $data = $Q->find();
        $pageBar =  $Q->getPageBar();
        return array('data'=>$data,'bar'=>$pageBar);
    }

    /**
     * 获取角色数据
     * @param int $id 角色id
     *
     */
    public function getRoleData($id){
        $roleModel = new M('subuser_role');
        $roleData = $roleModel->where(array('id'=>$id))->getObj();
        if(!empty($roleData)){
            $roleModel->table('subuser_role_right');
            $roleData['right'] = $roleModel->where(array('role_id'=>$id))->getFields('right_id');

            return $roleData;
        }
        return array();
    }

    /**
     * 删除角色
     * @param int $id 角色id
     */
    public function delRoleData($id){
        $roleModel = new M('subuser_role_right');
        $roleModel->beginTrans();
        $roleModel->where(array('role_id'=>$id))->delete();
        $roleModel->table('subuser_role')->where(array('id'=>$id))->delete(1);
        return $roleModel->commit();
    }
    /**
     * 获取递归数组
     * @param array $items
     * @param int $id
     * @return array
     */
    private  function generateTree($items,$id=0){
          $tree = array();
        foreach($items as $key=>$item){
           if( $item['pid']==$id){
               $tree[$item['id']] = $item;
               unset($items[$key]);
               $tree[$item['id']]['child'] = $this->generateTree($items,$item['id']);

           }

        }
        return $tree;
    }
}
