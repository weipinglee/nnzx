<?php 

/**
 * 仓单提货
 */
use \Library\safe;
use \Library\tool;
use \Library\JSON;
use \Library\url;
use \Library\checkRight;

class StoreDeliveryController extends DeliveryController{

	//显示仓库费用
	public function storeFeesPageAction(){
		$delivery_id = safe::filter($this->_request->getParam('id'));
		$store = new \nainai\delivery\StoreDelivery();
		$storeInfo = $store->storeFees($delivery_id);
		$delivery_info = $store->deliveryInfo($delivery_id);

		$storeInfo['delivery_amount'] = number_format($storeInfo['delivery_num'] * $storeInfo['price'],2);
		$this->getView()->assign('info',$storeInfo);
		$this->getView()->assign('delivery_info',$delivery_info);
	}

	//卖家支付仓库管理费用
	public function storeFeesAction(){
		$delivery_id = safe::filterPost('id','int');
		$user_id = $this->user_id;
		if($delivery_id){
			$store = new \nainai\delivery\StoreDelivery();
			$res = $store->payStoreFees($delivery_id,$user_id);
			die(json::encode($res));
		}

	}
		
}