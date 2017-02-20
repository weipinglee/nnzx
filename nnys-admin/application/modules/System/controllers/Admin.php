<?php
/**
 * @name AdminController
 * @author panduo
 * @desc 后台管理员控制器
 */
use \Library\safe;
use \Library\url;
use \Library\json;
use \Library\cache\driver;
use \Library\tool;
class AdminController extends InitController {

	private $adminModel,$rbacModel;
	public function init(){
		parent::init();
		$this->adminModel = new AdminModel();
		$this->rbacModel = new RbacModel();
		//echo $this->getViewPath();
	}

	/**
	 * [adminListAction 获取后台管理员列表]
	 * @return void 
	 */
	public function adminListAction(){
		$page = safe::filterGet('page','int');
		$name = safe::filterGet('name');
		$pageData = $this->adminModel->getList($page,$name);
		$this->getView()->assign('data',$pageData['data']);
		$this->getView()->assign('bar',$pageData['bar']);
		$this->getView()->assign('name',$name);
	}

    /**
     * 后台管理员添加页面
     * @return 
     */
	public function adminAddAction(){
		//权限验证 TODO
		if(IS_AJAX){
			$adminData['name'] 	    = safe::filterPost('admin-name');
			$adminData['password']  = safe::filterPost('admin-pwd');
			$adminData['email']     = safe::filterPost('admin-email');
			$adminData['role']      = safe::filterPost('admin-role','int');
			$adminData['last_ip']   = $_SERVER['REMOTE_ADDR'];
			$adminData['last_time'] = $adminData['create_time'] = date('Y-m-d H:i:s');
			$adminData['status']    = 0;
            $res = $this->adminModel->adminUpdate($adminData);
            echo JSON::encode($res);
            return false;
		}
		$this->getView()->assign('admin_roles',$this->rbacModel->roleList(1,10000,'status=0')['data']);
		//$this->getView()->display('/adminUpdate.tpl');
	}

	/**
	 * 修改页面及逻辑
	 * @return [type] [description]
	 */
	public function adminUpdateAction(){
		if(IS_AJAX){
			$adminData['name']  = safe::filterPost('admin-name');
			$adminData['id']    = safe::filterPost('admin-id');
			$adminData['email'] = safe::filterPost('admin-email');
			$adminData['role'] = safe::filterPost('admin-role','int');
			$res = $this->adminModel->adminUpdate($adminData);

            echo JSON::encode($res);
            return false;
		}else{
			//输出页面
			$id = intval($this->_request->getParam('id'));
			$admin_info = $this->adminModel->getAdminInfo($id);
			$this->getView()->assign('admin_roles',$this->rbacModel->roleList(1,10000)['data']);
			$this->getView()->assign('info',$admin_info);
		}
	}

	/**
	 * 修改管理员密码
	 * @param int password
	 * @return [type] [description]
	 */
	public function adminPwdAction(){
		//密码加盐TODO
		if(IS_AJAX){
			$adminData['id'] = safe::filterPost("admin-id");
			$adminData['password'] = sha1(safe::filterPost("admin-pwd"));
			$res = $this->adminModel->adminUpdate($adminData);

	        echo JSON::encode($res);
	        return false;
	    }else{
	    	$id = intval($this->_request->getParam('id'));
			$admin_info = $this->adminModel->getAdminInfo($id);
			$this->getView()->assign('info',$admin_info);
	    }
	}

	public function comadminPwdAction(){
		if(IS_AJAX){
			$adminData['id'] = safe::filterPost("admin-id");
			$adminData['password'] = sha1(safe::filterPost("admin-pwd"));
			$ori_password = sha1(safe::filterPost("ori-pwd"));

			$info = $this->adminModel->getAdminInfo($adminData['id']);
			if($info['password'] != $ori_password)
				die(json::encode(tool::getSuccInfo(0,'原密码错误')));
			$res = $this->adminModel->adminUpdate($adminData);

	        echo JSON::encode($res);
	        return false;
	    }else{
	    	$id = intval($this->_request->getParam('id'));
			$admin_info = $this->adminModel->getAdminInfo($id);
			$this->getView()->assign('info',$admin_info);
	    }
	}

	/**
	 * 设置数据状态
	 */
	public function setStatusAction(){
		if(IS_AJAX){
			$adminData['status'] = intval(safe::filterPost('status'));
			$adminData['id'] = intval($this->_request->getParam('id'));
			$res = $this->adminModel->adminUpdate($adminData);

            echo JSON::encode($res);
            return false;
		}
		return false;
	}

	//获取管理员操作记录
	public function logListAction(){
		$page = safe::filterGet('page','int');
		$name = safe::filterGet('name');
		$pageData = $this->adminModel->logList($page,$name);

		$this->getView()->assign('data',$pageData);
		$this->getView()->assign('name',$name);
	}
}