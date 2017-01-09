<?php 
use Library\Safe;

class InitController extends Yaf\Controller_Abstract{

	protected $pagesize = 1;

	public function init(){
		$this->getView()->setLayout('admin');
		$admin_info = admintool\admin::sessionInfo();
		$this->admin_id = $admin_info['id'];
	}





}
?>

