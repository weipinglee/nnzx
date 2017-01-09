<?php
/**
 * 子账户权限
 */
namespace nainai;
use \Library\M;
use \Library\tool;
use \Library\Query;
use \Library\Session;
class subAccount{

	/**
	 * 权限认证
	 * @param string $controller 控制器名
	 * @param string $action     动作名
	 */
	public static function AccessDecision($controller = '',$action = ''){
		$controller = strtolower($controller);
		$action = strtolower($action);
		$user_session = session::get('login');
		$access = false;
		$MenuModel = new \nainai\user\Menu();
    		$menuList = $MenuModel->getUserMenuList($user_session['user_id']);
	    	if($menuList === true){
	    		$access = true;
	    	}else{
		    	if($controller == 'oper' ||($controller == 'ucenter' && $action == 'index')){
		    		$access = true;
		       	}else{
			    	foreach ($menuList as $key => $value) {
			    		if(stripos($value['url'],$controller.'/'.$action)){
			    			$access = true;
			    			break;
			    		}
			    	}
			}
		}
	    	return $access;
	}

}