<?php
/**
 * @name SamplePlugin
 * @desc Yaf定义了如下的6个Hook,插件之间的执行顺序是先进先Call
 * @see http://www.php.net/manual/en/class.yaf-plugin-abstract.php
 * @author root
 */
class SamplePlugin extends Yaf\Plugin_Abstract {

	public function routerStartup(\Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		$static = new \nainai\statistics();
		$static->createStatistics();

	}

	public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		//开闭市控制
		$market = new \nainai\market();
		$res = $market->checkCanOper($request);
		if(!$res){
			if(IS_AJAX || IS_POST){
				die(\Library\json::encode(\Library\tool::getSuccInfo(0,'现在已闭市，无法操作')));
			}
			else{
				$response->setRedirect(\Library\url::createUrl("/oper/error?info=现在已闭市，无法操作"));
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
