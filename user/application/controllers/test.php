<?php 

/**
 * 保证金摘牌控制器
 */
use \Library\safe;
use \Library\tool;
use \Library\JSON;
use \Library\url;
use \Library\checkRight;
use \Library\M;

class testController extends  UcenterBaseController{

	public function indexAction(){

	}

	public function uploadAction(){

	}



	public function formAction(){
		$a = 'abcdddd';
		echo substr($a,0,-2);exit;

	}


	public function accInitAction(){
		$acc = new \nainai\fund\zx();
		$res = $acc->acountInit(67,1000,'');

		var_dump($res);
	}

	public function freeAction(){
		$acc = new \nainai\fund\zx();
		$res = $acc->freezeTrans(67,date('Y-m-d H:i:s',strtotime('2016-7-21')));
		var_dump($res);
	}

}