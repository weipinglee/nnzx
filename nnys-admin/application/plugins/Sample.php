<?php
/**
 * @name SamplePlugin
 * @desc Yaf定义了如下的6个Hook,插件之间的执行顺序是先进先Call
 * @see http://www.php.net/manual/en/class.yaf-plugin-abstract.php
 * @author root
 */
use \Library\url;
use \Library\adminrbac\rbac;
use \Library\session;
use \Library\tool;
use \Library\JSON;
class SamplePlugin extends Yaf\Plugin_Abstract {

	public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

	}

	public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		//RBAC权限控制
		$user_info = session::get(tool::getConfig(array('rbac','user_session')));

		if((!isset($user_info) || !$user_info) && (strtolower($request->controller) != 'login')){
			echo '<script type="text/javascript" >window.parent.location.href="'.url::createUrl("/login/login").'"</script>';
			exit;
			$response->setRedirect(url::createUrl("/login/login"));
		}
		$rbac = new rbac($request);

		$auth = rbac::AccessDecision($request->module,$request->controller,$request->action);
		
		if($auth === false){
			// if($request->isXmlHttpRequest())
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
				die(JSON::encode(tool::getSuccInfo(0,'无操作权限')));
			}else{
				$response->setRedirect(url::createUrl("/index/index/noaccess"));
			}
		}
		//生成权限菜单
		// if(strtolower($request->controller) == 'index' && strtolower($request->action) == 'index'){
		// 	rbac::accessMenu();
		// }

		//开闭市控制
		$market = new \nainai\market();
		$res = $market->checkCanOper($request);

		if(!$res){
			if(IS_AJAX || IS_POST){
				die(\Library\json::encode(\Library\tool::getSuccInfo(0,'现在已闭市，无法操作')));
			}

		}
		
	}

	public function dispatchLoopStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		
	}	

	public function preDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function postDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

	}

	public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		//echo $request->getActionName();
	}
}
