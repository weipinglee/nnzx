<?php 

/**
 * 管理员登录状态控制器
 */

use \Library\safe;
use \Library\json;
class LoginController extends InitController{//Yaf\Controller_Abstract {

	private $loginModel = '';
	public function init(){
		parent::init();
		$this->loginModel = new loginModel();
	}
	/**
	 * 显示登录页面
	 * @return [type] [description]
	 */
	public function loginAction(){
		//$memc = new \Library\cache\driver\Memcached();
	}

	/**
	 * 处理登录逻辑
	 * @return [type] [description]
	 */
	public function loginHandlerAction(){
		$name = safe::filterPost('admin-name');
		$pwd = safe::filterPost('admin-pwd');

		$res = $this->loginModel->login($name,$pwd);
		die(json::encode($res));
		return false;
	}

	/**
	 * 登出
	 */
	public function logoutAction(){
		$res = $this->loginModel->logout();
		if($res['success'] == 1){
			$this->forward('index','login','login');
		}else{
			//跳转到错误页面
		}
		return false;
	}
}
 ?>