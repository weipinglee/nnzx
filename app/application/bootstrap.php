<?php
/**
 * @name Bootstrap
 * @author root
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
use \Library\views\wittyAdapter;
use \Library\tool;
class Bootstrap extends \Yaf\Bootstrap_Abstract{

    public function _initConfig(Yaf\Dispatcher $dispatcher) {
		if(\Library\tool::getConfig('error')){
			error_reporting(E_ALL);
		}
		else{
			 error_reporting(E_ALL);
		}
		//把配置保存起来
		$this->config = Yaf\Application::app()->getConfig();
		\Yaf\Registry::set('config', $this->config);
		if(isset(Yaf\Registry::get("config")['application']['cookie_domain'])){
			$cookie_domain = Yaf\Registry::get("config")['application']['cookie_domain'];
			if($cookie_domain!='')
				ini_set("session.cookie_domain",$cookie_domain);
		}
		session_start();
		define('REQUEST_METHOD', strtoupper($dispatcher->getRequest()->getMethod()));
		define('IS_GET',        REQUEST_METHOD =='GET' ? true : false);
		define('IS_POST',       REQUEST_METHOD =='POST' ? true : false);
		define('IS_PUT',        REQUEST_METHOD =='PUT' ? true : false);
		define('IS_DELETE',     REQUEST_METHOD =='DELETE' ? true : false);
		define('IS_AJAX',       ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? true : false);
	}
	
	//注册本地类 所有相同前缀的类会加载到本地library路径
	public function _initLoader(Yaf\Dispatcher $dispatcher) {
		$loader = Yaf\Loader::getInstance();
		$loader->registerLocalNamespace(array('conf'));
	}
	public function _initPlugin(Yaf\Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new SamplePlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(Yaf\Dispatcher $dispatcher) {
		//注册路由
		$router = Yaf\Dispatcher::getInstance()->getRouter();
		$config_routes = Yaf\Registry::get("config")->routes;
		if(!empty($config_routes))
			$router->addConfig(Yaf\Registry::get("config")->routes);


	}
	
	public function _initView(Yaf\Dispatcher $dispatcher){
		$res = tool::getConfig()['witty'];
		$view = new wittyAdapter($res);
		$dispatcher->setView($view);

	}
}
