<?php
/**
 * @date 2015-9-13 
 * @author zhengyin <zhengyin.name@gmail.com>
 * @blog http://izhengyin.com
 *
 */

class MessageController extends  CliController{
	
	public function init(){
		parent::init();
		$this->displayError();
		$this->setMemoryLimit('1024M');
		$this->setTimeLimt(-1);
	}
	
	public function runAction(){
		
		while (true){
			echo date('Y-m-d H:i:s').PHP_EOL;
			sleep(1);
		}
		exit;
	}
}