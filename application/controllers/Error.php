<?php
/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 * @author root
 */
class ErrorController extends Yaf\Controller_Abstract {

	//从2.1开始, errorAction支持直接通过参数获取异常
	public function errorAction($exception) {
		$this->getView()->setLayout('');
		switch($exception->getCode()) {
			case 513:
			case 514:
			case 515:
			case 516:
			case 517:
			case 518:
				header( "HTTP/1.1 404 Not Found" );
				header( "Status: 404 Not Found" );
				break;
		}

	}
}
