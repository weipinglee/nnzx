<?php 

/**
 * 采购订单
 */
use \Library\safe;
use \Library\tool;
use \Library\JSON;
use \Library\url;
use \Library\checkRight;

class PurchaseOrderController extends OrderController{
	
	//选定一个报价，生成订单
	public function geneOrderAction(){
		$id = safe::filter($this->_request->getParam('id'),'int');
		$purchase = new \nainai\offer\PurchaseReport();
		$info = $purchase->purchaseDetail($id);
		$this->getView()->assign('data',$info);
	}


	public function geneOrderHandleAction(){
		if(IS_POST){
			$id = safe::filterPost('id','int');
			$account = safe::filterPost('account','int');
			$order = new \nainai\order\PurchaseOrder();
			
			$res = $order->purchaseOrder($id,0,$account);
			die(json::encode($res));
		}
		return false;
	}

}