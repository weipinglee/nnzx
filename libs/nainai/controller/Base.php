<?php

namespace nainai\controller;
use \Library\checkRight;
use \Library\url;

/**
 * 用户中心的抽象基类
 */
class Base extends \Yaf\Controller_Abstract{

	protected $certType = null;

	protected $menuList;

	//认证页面方法，检测到未认证跳转到该位置
	private static $certPage = array(
		'deal'=>'dealcert',
		'store'=>'storecert'
	); 

	 protected function init(){
		$right = new checkRight();
		$right->checkLogin($this);//未登录自动跳到登录页

		 if(isset($this->user_id) && $this->user_id>0){
			 $this->getView()->assign('login',1);
			 $this->getView()->assign('username',$this->username);
			 $this->getView()->assign('usertype',$this->user_type);
			 
			 $MenuModel = new \nainai\user\Menu();
			 $this->menuList = $MenuModel->getUserMenuList($this->user_id,$this->cert,$this->user_type);
			 $controllerName = $this->_request->getControllerName();
			 $actionName = $this->_request->getActionName();
			 $url = $controllerName.'/'.$actionName;
			 $navi = $MenuModel->getMenuNavi($this->menuList, $url);
			 $this->getView()->assign('navi', $navi);
                    		//判断是否有操作菜单的权限
			 $hand = FALSE;
			 if ($url == 'Oper/success' || $url == 'Oper/error' ) {
			 	$hand = TRUE;
			 }else{
			 	foreach ($this->menuList as $list) {
				 	if ($list['subacc_show'] == 0 OR stripos($list['menu_url'],$url) > 0) {
				 		$hand = TRUE;
				 		break;
				 	}
				 }
			 }
			 if ($hand == FALSE) {
			 	if(IS_AJAX || IS_POST){
			 	}else{
			 		// $this->error('无权限操作！');exit();
			 	}
			 }
		 }else $this->getView()->assign('login',0);
		  //需要认证的方法未认证则跳转到认证页面
	   if($this->certType!==null  && (!isset($this->cert[$this->certType]) || $this->cert[$this->certType]==0))
	   {
		   $url = url::createUrl('/ucenter/'.self::$certPage[$this->certType].'@user');
		   if(IS_AJAX){
			   die(\Library\json::encode(\Library\tool::getSuccInfo(0,'请先进行相关的资质认证',$url)));
			
		   }else{
			   $this->redirect($url);exit;

		   }
	   }

			$model = new \nainai\system\DealSetting();
			$deal = $model->getsetting();
			$this->getView()->assign('deal', $deal);

    }

	protected function success($info = '操作成功！',$redirect = ''){
		if(isset($redirect)){
			$redirect = str_replace('%','||',urlencode($redirect));
		}

		$this->redirect(url::createUrl("/Oper/success?info={$info}&redirect={$redirect}"));
	}

	protected function error($info = '操作失败！',$redirect = ''){

		if(isset($redirect)){
			$redirect = str_replace('%','||',urlencode($redirect));
		}
		$this->redirect(url::createUrl("/Oper/error?info={$info}&redirect={$redirect}"));
	}

	protected function confirm($info = '确认此项操作？',$redirect = ''){

		if(isset($redirect)){
			$redirect = str_replace('%','||',urlencode($redirect));
		}
		$this->redirect(url::createUrl("/Oper/confirm?info={$info}&redirect={$redirect}"));
	}



}
