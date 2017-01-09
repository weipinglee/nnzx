<?php 

/**
 * 后台权限控制相关
 * @author panduo
 * 2016-4-8
 */
use \Library\safe;
use \Library\url;
use \Library\json;
class RbacController extends InitController{

	private $rbacModel ;
	public function init(){
		parent::init();
		$this->rbacModel = new RbacModel();
	}
	/**
	 * 显示角色列表
	 */
	public function roleListAction(){
		$page = safe::filterGet('page','int');
		$pageData = $this->rbacModel->roleList($page);
		$this->getView()->assign('data',$pageData['data']);
		$this->getView()->assign('bar',$pageData['bar']);
	}

	/**
	 * 添加角色
	 */
	public function roleAddAction(){
		if(IS_AJAX){
			$roleData['name'] 	 = safe::filterPost('role-name');
			$roleData['remark']  = safe::filterPost('role-remark');
			$roleData['status']  = 0;
            $res = $this->rbacModel->roleUpdate($roleData);
            echo JSON::encode($res);
            return false;
		}
	}

	/**
	 * 设置数据状态
	 */
	public function setStatusAction(){
		if(IS_AJAX){
			$roleData['status'] = intval(safe::filterPost('status'));
			$roleData['id'] = intval($this->_request->getParam('id'));
			$res = $this->rbacModel->roleUpdate($roleData);

            echo JSON::encode($res);
            return false;
		}
		return false;
	}

	/**
	 * 编辑角色			
	 * @return [type] [description]
	 */
	public function roleUpdateAction(){
		if(IS_AJAX){
			$roleData['name']  = safe::filterPost('role-name');
			$roleData['id']    = safe::filterPost('role-id');
			$roleData['remark'] = safe::filterPost('role-remark');
			$res = $this->rbacModel->roleUpdate($roleData);

            echo JSON::encode($res);
            return false;
		}else{
			$id = intval($this->_request->getParam('id'));
			$info = $this->rbacModel->roleInfo($id);
			$this->getView()->assign("info",$info);
		}
	}

	/**
	 * 删除角色
	 * @return [type] [description]
	 */
	public function roleDelAction(){
		$id = intval($this->_request->getParam('id'));
		$res = $this->rbacModel->roleDel($id);

		echo JSON::encode($res);
        return false;
	}


	/**
	 * 添加新节点
	 * @return [type] [description]
	 */
	public function nodeAddAction(){
		if(IS_POST){
			//新增权限节点
			$data['module_name'] = safe::filterPost('module');
			if(safe::filterPost('controller'))
				$data['controller_name'] = safe::filterPost('controller');
			if(safe::filterPost('action'))
				$data['action_name'] = safe::filterPost('action');
			$data['module_title'] = safe::filterPost('module_title');
			if(safe::filterPost('controller_title'))
				$data['controller_title'] = safe::filterPost('controller_title');
			if(safe::filterPost('action_title'))
				$data['action_title'] = safe::filterPost('action_title');
			$res = $this->rbacModel->nodeAdd($data);
			echo JSON::encode($res);exit;
		}else{
			//显示权限节点添加列表,取出所有模块列表
			$modules = $this->rbacModel->moduleList();
			$this->getView()->assign('modules',$modules);
		}
	}

	/**
	 * 删除节点
	 */
	public function nodeDelAction(){
		$node_id = safe::filterPost('node_id');

		$res = $this->rbacModel->nodeDel($node_id);
		echo JSON::encode($res);exit;
	}

	/**
	 * 获取指定模块下控制器列表
	 * @return [type] [description]
	 */
	public function controllerListAction(){
		if(!IS_AJAX) return false;
		$module_name = safe::filterPost('module');
		if(!$module_name) return false;
		
		$controllers = $this->rbacModel->controllerList($module_name,true);
		echo JSON::encode($controllers);
		return false;
	}

	/**
	 * 用于ajax获取控制器下方法列表
	 * @return [type] [description]
	 */
	public function actionListAction(){
		if(!IS_AJAX) return false;
		$module_name = safe::filterPost('module');
		$controller_name = safe::filterPost('controller');
		if(!($controller_name && $module_name)) return false;

		error_reporting(E_ERROR);
		$actions = $this->rbacModel->actionList($module_name,$controller_name,true);
		echo JSON::encode($actions);
		return false;
	}

	/**
	 * 获取action的标题
	 * @return [type] [description]
	 */
	public function actionTitleAction(){
		if(!IS_AJAX) return false;
		$module_name = safe::filterPost('module');
		$controller_name = safe::filterPost('controller');
		$action_name = safe::filterPost('action');
		if(!($controller_name && $module_name && $action_name)) return false;

		$action_title = $this->rbacModel->actionTitle($module_name,$controller_name,$action_name);
		echo JSON::encode($action_title);
		return false;
	}

	/**
	 * 角色已授权列表
	 * @return [type] [description]
	 */
	public function accessListAction(){
		$role_id = safe::filterGet('role_id','int');
		//获取节点树
		$tree = $this->rbacModel->nodeTree(); 
		$access_array = isset($role_id) && $role_id>0 ?  $this->rbacModel->accessArray($role_id) : array();
		//获取用户角色列表
		$admin_roles = $this->rbacModel->roleList(1,100000);
		$this->getView()->assign('node_tree',$tree);
		$this->getView()->assign('access_array',$access_array);
		$this->getView()->assign('role_id',$role_id);
		$this->getView()->assign('admin_roles',$admin_roles['data']);
	}

	/**
	 * 角色授权
	 */
	public function AccessAddAction(){
		$role_id = safe::filterPost('role_id','int');
		$node_id = safe::filterPost('node_id');
		$res = $this->rbacModel->accessAdd($role_id,is_array($node_id) ? $node_id : array());
		echo JSON::encode($res);
		return false;
	} 
}

 ?>