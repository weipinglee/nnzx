<?php 

use \Library\M;
use \Library\tool;
use \Library\session;
class loginModel{
	/**
	 * 登录处理方法
	 * @return [type] [description]
	 */
	private $admin;
	private $admin_log;
	public function __construct(){
		$this->admin = new M('admin'); 
		$this->admin_log = new AdminModel();
	}
	public function login($name,$pwd){
		$user = $this->admin->where(array('name'=>$name))->fields('password,name,id,role,session_id,status')->getObj();
		if(isset($user['password']) && sha1($pwd) === $user['password']){
			if($user['status'] == 1 && $name != 'admin'){
				$resInfo = tool::getSuccInfo(0,'此用户被禁用');
			}elseif((isset($user['status']) && $user['status'] == 0) || $name == 'admin'){
				try {
					$this->admin->beginTrans();
					if($user['session_id'] != session_id()){
						//若session_id不同 则删除原session
						$admin_session = new M('admin_session');
						$admin_session->where(array('session_id'=>$user['session_id']))->delete();
					}
					$ip = \Library\client::getIp();
					$data = array('last_ip'=>$ip,'session_id' => session_id());
					
					//写入管理员表session与ip信息
					$this->admin->where(array('id'=>$user['id']))->data($data)->update();
						
					//写入管理员登录日志
					//$this->admin_log->adminLog($user['id'],$ip);

					$resInfo = tool::getSuccInfo();
					//获取用户分组
					$rbacModel = new RbacModel();
					$role_name = admintool\admin::is_admin($user['id']) ? '超级管理员' : $rbacModel->adminRole($user['role']);
					session::set(tool::getConfig('rbac')['user_session'],array('id'=>$user['id'],'name'=>$user['name'],'role'=>$role_name));
					// $adminRiskModel=new adminRiskModel();
					//检查登录地址
					// $adminRiskModel->checkAdminAdd(['admin_id'=>$user['id'],'ip'=>$ip]);
					$this->admin->commit();
				} catch (PDOException $e) {
					$this->admin->rollBack();
					$resInfo = tool::getSuccInfo(0,$e->getMessage());
				}
			}else{
				$resInfo = tool::getSuccInfo(0,'用户状态错误');
			}
		}else{	
			$resInfo = tool::getSuccInfo(0,'用户名或密码错误');
		}
		return $resInfo;
	}

	/**
	 * 登出
	 * @return [type] [description]
	 */
	public function logout(){
		Session::set(tool::getConfig('rbac')['user_session'],array());
		return tool::getSuccInfo();
	}
}
 ?>
