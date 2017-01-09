<?php
/**
 * @date 2015-9-13 
 * @author zhengyin <zhengyin.name@gmail.com>
 * @blog http://izhengyin.com
 * /opt/app/php-5.5/bin/php cli.php request_uri="/cli/Failtask/run"  >> /tmp/cli/failtask.log
 */

class FailtaskController extends CliController{
	public function init(){
		parent::init();
	}
	
	public function runAction(){
		echo date('Y-m-d H:i:s').' 处理失败任务！'.PHP_EOL;
		exit;
	}
}