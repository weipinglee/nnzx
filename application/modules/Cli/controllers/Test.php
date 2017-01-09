<?php
/**
 * Cli 测试程序
 * @date 2015-9-13 
 * @author zhengyin <zhengyin.name@gmail.com>
 * @blog http://izhengyin.com
 */

class TestController extends Yaf\Controller_Abstract{
	
	
	public function init(){
		//echo $this->getViewPath();
	}

	public function indexAction(){
		$param = $this->getRequest()->getParams();
		print_r($param);
		print_r($_GET);


	}

	public function showAction(){
		echo 'test show';
		return false;
	}
	/**
	 * 运行测试程序
	 */
	public function runAction(){
		$params = $this->getRequest()->getParams();
		$name = isset($params['name'])?$params['name']:'';
		if(!$name) exit('Enter your name.'.PHP_EOL);
		echo date('Y-m-d H:i:s').': Hello '.$name.PHP_EOL;
		return false;
	}
}
