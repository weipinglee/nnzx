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

class DepositController extends OrderController{

	//卖家支付保证金
	public function sellerDepositAction(){
		if(IS_POST){
			$order_id = safe::filterPost('order_id','int');
			$payment = safe::filterPost('payment','int');
			$user_id = $this->user_id;
			$pay = true;
			$res = $this->deposit->sellerDeposit($order_id,$pay,$user_id,$payment);
			if($res['success'] == 1)
				die(json::encode(tool::getSuccInfo(1,'保证金支付成功',url::createUrl('/contract/sellerdetail?id='.$order_id))));
			else
				die(json::encode(tool::getSuccInfo(0,$res['info'])));
			return false;
		}else{
			$order_id = safe::filter($this->getRequest()->getParam('order_id'),'int');
			$data = $this->deposit->contractDetail($order_id,'seller');
			$sys_percent_obj = new M('scale_offer');//后台配置保证金基数比例
			$sys_percent = $sys_percent_obj->where(array('id'=>1))->getField('deposite');
			//获取当前用户等级保证金比例
			$user = new \nainai\member();
			$user_percent = $user->getUserGroup($this->user_id);//当前用户id
			if($user_percent === false){
				$this->error('用户错误');
			}
			
			$percent = floatval($sys_percent) * floatval($user_percent['caution_fee']);
			$data['seller_percent'] = $percent / 100;
			$data['seller_deposit'] = number_format($data['amount'] * $percent / 10000,2);
			$this->getView()->assign('data',$data);
		}
	}

	//发起委托费支付宝支付请求
	public function entrustAlipayAction(){
		$order_id = safe::filter($this->_request->getParam('order_id'));
		$order_info = $this->order->orderInfo($order_id);
		$offer_info = $this->order->offerInfo($order_info['offer_id']);
		//创建支付宝链接
		$pay = new \Library\payment\directAlipay\DirectAlipay(2);
		$pay->callbackUrl = url::createUrl("/EntrustOrder/alipayEntrust?order_id=$order_id&user_id={$this->user_id}@user");
		$obj = new \nainai\system\EntrustSetting();
		$percent = $obj->getRate($offer_info['cate_id']);
		
		$seller_deposit = $percent['type'] == 0 ? number_format($order_info['amount'] * $percent['value'] / 100,2) : $percent['value'];

		$alipay_info = \Library\payment::getPaymentById(2,'config_param');
		$alipay_info = json::decode($alipay_info);
		$payData = array(
			'M_OrderNO' => $order_info['order_no'].'xx',
			'M_Amount'  => $seller_deposit,
			'M_PartnerId' => $alipay_info['M_PartnerId'],
			'M_PartnerKey' => $alipay_info['M_PartnerKey'],
			'M_Email'=>$alipay_info['M_Email'],
			'R_Name'=>'耐耐网订单委托费'
		);
		$sendData = $pay->getSendData($payData);

		$pay->doPay($sendData);
	}

	//卖家支付委托金
	public function sellerEntrustDepositAction(){
		if(IS_POST){
			$order_id = safe::filterPost('order_id','int');
			$payment = safe::filterPost('payment','int');
			$user_id = $this->user_id;
			$pay = true;

			$res = $this->entrust->sellerDeposit($order_id,$pay,$user_id,$payment);
			if($res['success'] == 1)
				die(json::encode(tool::getSuccInfo(1,'委托金支付成功',url::createUrl('/contract/sellerdetail?id='.$order_id))));
			else
				die(json::encode(tool::getSuccInfo(0,$res['info'])));
			
		}else{
			$order_id = safe::filter($this->getRequest()->getParam('order_id'),'int');
			$data = $this->entrust->contractDetail($order_id,'seller');
			$obj = new \nainai\system\EntrustSetting();

			$percent = $obj->getRate($data['cate_id']);
			// $percent = $this->order->entrustFee($order_id);
			if (empty($percent)) {
				$percent['value'] = 0;
			}
			$member = new \nainai\member();
			$is_vip = $member->is_vip($this->user_id);

			$data['seller_percent'] = $percent['value'];
			$data['type'] = $percent['type'];
			$data['seller_deposit'] = $is_vip ? 0 : ($percent['type'] == 0 ? number_format($data['amount'] * $percent['value'] / 100,2) : $percent['value']);
			$this->getView()->assign('data',$data);
		}
	}

	//支付保证金成功页面
	public function sucAction(){}

}