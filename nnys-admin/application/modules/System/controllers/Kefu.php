<?php
/**
 * @name KefuController
 * @author weipinglee
 * @desc 客服添加管理控制器（客服是一种特殊的管理员）
 */
use \Library\safe;
use \Library\url;
use \Library\json;
use \Library\cache\driver;
use \Library\tool;
class KefuController extends InitController {

	private $adminModel,$rbacModel;
	private $kefuModel = '';
	public function init(){
		parent::init();
		$this->adminModel = new AdminModel();
		$this->rbacModel = new RbacModel();
		$this->kefuModel = new kefuModel();

		//echo $this->getViewPath();
	}

    /**
     * 后台管理员添加页面
     * @return 
     */
	public function kefuAddAction(){
		//权限验证 TODO
		if(IS_POST){
			$adminData['id']        = safe::filterPost('admin_id','int',0);
			$adminData['name'] 	    = safe::filterPost('admin-name');
			$pass = safe::filterPost('admin-pwd');
			if($adminData['id']==0 || $pass!=''){
				$adminData['password']  = $pass;
			}


			$adminData['email']     = safe::filterPost('admin-email');
			$adminData['role']      = $this->kefuModel->getKefuRole();
			if($adminData['role']==0)
				die(json::encode(tool::getSuccInfo(0,'操作失败')));
			$adminData['status']    = 0;

			$kefuData = array();
			$kefuData['ser_name'] = safe::filterPost('ser_name');
			$kefuData['phone']    = safe::filterPost('phone');
			$kefuData['qq']       = safe::filterPost('qq');
			$res = $this->kefuModel->addKefu($adminData,$kefuData);
			die(json::encode($res));

		}
		else{
			$id = $this->getRequest()->getParam('id');
			$id = safe::filter($id,'int',0);
			if($id){
				$data = $this->kefuModel->getKefuData($id);
				$this->getView()->assign('data',$data);
			}
		}


	}

	/**
	 * 客服列表
	 */
	public function kefuListAction(){
		$page = safe::filterGet('page','int',1);
		if($page){
			$data = $this->kefuModel->getKefuList($page);
			$this->getView()->assign('data',$data['data']);
			$this->getView()->assign('bar',$data['bar']);
		}
		else
			return false;
	}

	/**
	 * 删除客服
	 */
	public function delAction(){
		if(IS_POST){
			$id = $this->getRequest()->getParam('id');
			$id=safe::filter($id,'int',0);
			if($id){
				$res = $this->kefuModel->delKefu($id);
				die(json::encode($res));
			}
			die(json::encode(tool::getSuccInfo(0,'操作错误')));
		}
		return false;

	}


}