<?php
/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
use \Library\photoupload;
use \Library\json;
use \Library\Session;
use \Library\adminrbac\rbac;
class IndexController extends InitController {


	public function init(){
		parent::init();
		if (!\admintool\admin::is_admin()) {
			// $menus = \Library\Session::get('admin_menus');
			$menus = rbac::accessMenu();
			$this->getView()->assign('menus',JSON::encode($menus));
		}else{
			$this->getView()->assign('menus','admin');
		}
		
	}
	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/yar-demo/index/index/index/name/root 的时候, 你就会发现不同
     */
	public function indexAction() {
		// session_destroy();
		$admin_info = admintool\admin::sessionInfo();
		$this->getView()->assign('info',$admin_info);
	}

	public function welcomeAction(){
		
	}

	public function noaccessAction(){

	}

	/**
	 * ajax上传图片
	 * @return bool
	 */
	public function uploadAction(){

		//调用文件上传类
		$photoObj = new photoupload();
		$photoObj->setThumbParams(array(180,180));
		$photo = current($photoObj->uploadPhoto());

		if($photo['flag'] == 1)
		{
			$result = array(
				'flag'=> 1,
				'img' => $photo['img'],
				'thumb'=> $photo['thumb'][1]
			);
		}
		else
		{
			$result = array('flag'=> $photo['flag'],'error'=>$photo['errInfo']);
		}
		echo JSON::encode($result);

		return false;
	}




}
