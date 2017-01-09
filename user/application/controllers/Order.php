<?php 
use \Library\safe;
use \Library\tool;
use \Library\JSON;
use \Library\url;
use \Library\checkRight;

class OrderController extends UcenterBaseController{

	public function init(){
		parent::init();
        $this->order = new \nainai\order\Order();
        $this->free = new \nainai\order\FreeOrder();
		$this->deposit = new \nainai\order\DepositOrder();
		$this->store = new \nainai\order\StoreOrder();
		$this->entrust = new \nainai\order\EntrustOrder();
	}

	//取消合同
	public function cancelContractAction(){
		$order_id = safe::filter($this->_request->getParam('order_id'),'int');
		$res = $this->deposit->sellerDeposit($order_id,false,$this->user_id);
		if($res['success'] == 1){
			$this->success('已取消合同');
		}else{
			$this->error($res['info']);
		}
		return false;
	}
	
	//买家支付尾款
	public function buyerRetainageAction(){
		if(IS_POST){
			$order_id = safe::filterPost('order_id','int');
			$type = safe::filterPost('payment');//线上or线下
			$account = safe::filterPost('account');//支付方式
			$proof = safe::filterPost('imgproof');
			
			$user_id = $this->user_id;

			$res = $this->order->buyerRetainage($order_id,$user_id,$type,$proof,$account);

			if($res['success'] == 1){
				$title = $type == 'offline' ? '已上传支付凭证' : '已支付尾款';
				$info = $type == 'offline' ? '请等待卖家确认凭证' : '合同已生效，可申请提货';
				
				die(json::encode(tool::getSuccInfo(1,$title,url::createUrl('/contract/buyerlist'))));
				//$this->redirect(url::createUrl('/Order/payRetainageSuc')."/title/$title/info/$info");
			}else{
				die(json::encode($res));
			}
			return false;
		}else{
			$order_id = safe::filter($this->_request->getParam('order_id'),'int');
			$data = $this->order->contractDetail($order_id);

			$data['topay_retainage'] = number_format(floatval($data['amount']) - floatval($data['pay_deposit']),2);


			$seller = $data['type'] == 1 ? $data['seller_id'] : $data['user_id'];

			$bankinfo = $this->order->userBankInfo($seller);

			$data['seller'] = $seller;

			$this->getView()->assign('show_online',in_array($data['mode'],array(\nainai\order\Order::ORDER_DEPOSIT,\nainai\order\Order::ORDER_STORE,\nainai\order\Order::ORDER_PURCHASE,\nainai\order\Order::ORDER_ENTRUST)) ? 1 : 0);
			$this->getView()->assign('total_amount',$data['mode'] == \nainai\order\Order::ORDER_FREE ? 1 : 0);
			$this->getView()->assign('bankinfo',$bankinfo);
			$this->getView()->assign('data',$data);
		}
	}
	
	/**
	 * 通知买方开户
	 */
	public function banckNoticeAction(){
		$id = safe::filter($this->_request->getParam('tar_id'),'int');
		$mess = new \nainai\message($id);
		$res = $mess->send('newbankaccount');
		if($res['code'] == 1){
			$this->success('已通知卖方开户');
		}else{
			$this->error('通知失败');
		}
	}

	//支付尾款成功
	public function payRetainageSucAction(){
		$this->getView()->assign('title',safe::filter($this->_request->getParam('title')));
		$this->getView()->assign('info',safe::filter($this->_request->getParam('info')));
	}

	//确认线下支付凭证页面
	public function confirmProofPageAction(){
		$order_id = intval($this->_request->getParam('order_id'));
		$info = $this->order->contractDetail($order_id);
		
		$info['show_deposit'] = in_array($info['mode'],nainai\order\Order::ORDER_DEPOSIT,nainai\order\Order::ORDER_STORE) ? 1 : 0;
		$info['proof_thumb'] = \Library\Thumb::get($info['proof'],400,400);
		$info['pay_retainage'] = $info['amount'] - $info['pay_deposit'];
		$info['is_free'] = $info['mode'] == nainai\order\Order::ORDER_FREE ? 1 : 0;
		$this->getView()->assign('data',$info);
	}
	
	//卖家确认买方线下支付凭证
	public function confirmProofAction(){
		$order_id = safe::filterPost('order_id','int');
		$type = true;
		$user_id = $this->user_id;
		$res = $this->order->confirmProof($order_id,$user_id,$type);
		die(json::encode($res));
	}

	//扣减货款页面
	public function verifyQaulityPageAction(){
		$order_id = safe::filter($this->_request->getParam('order_id'),'int',0);	
		$order_info = $this->order->orderInfo($order_id);
		$this->getView()->assign('max_reduce',$order_info['pay_deposit']);
		$this->getView()->assign('order_id',$order_id);
	}

	//提货完成后买家确认订单货物质量
	public function verifyQaulityAction(){
		if(IS_POST){
			$order_id = safe::filterPost('order_id');
			$info = $this->order->orderInfo($order_id);
			$amount = $info['amount'];
			$reduce_amount = safe::filterPost('amount','floatval');
			$reduce_amount = (!$reduce_amount || $reduce_amount > $amount || $reduce_amount < 0) ? 0 : $reduce_amount;
			if(!$reduce_amount){
				die(json::encode(tool::getSuccInfo(0,'扣减金额错误')));
			}
			$reduceData['reduce_amount'] = $reduce_amount;
			$reduceData['reduce_remark'] = safe::filterPost('remark');
			$res = $this->order->verifyQaulity($order_id,$this->user_id,$reduceData);
			if($res['success']==1){
				$res['info'] = '已扣减'.$reduce_amount;
				$res['returnUrl'] = url::createUrl('/Contract/buyerlist');
			}
			die(json::encode($res));
		}else{
			$order_id = safe::filter($this->_request->getParam('order_id'));
			$res = $this->order->verifyQaulity($order_id,$this->user_id);
			if($res['success'] == 1)
				$this->success('已确认货物质量',url::createUrl('/Contract/buyerlist'));
			else
				$this->error($res['info']);
		}

		return false;
	}

	//显示合同信息
	public function sellerVerifyPageAction(){
		$order_id = safe::filter($this->_request->getParam('order_id'));
		$info = $this->order->contractDetail($order_id,'seller');
		$this->getView()->assign('info',$info);	
	}

	//卖家确认质量 
	public function sellerVerifyAction(){
		$reduce = safe::filter($this->_request->getParam('reduce'));
		$order_id = safe::filter($this->_request->getParam('order_id'));
		$disagree = safe::filter($this->_request->getParam('disagree'));
		
		if(!$reduce){
			$res = $this->order->sellerVerify($order_id,$this->user_id,$disagree ? false : true);
			
			if($res['success'] == 1){
				$suc_info = $disagree ? '已驳回扣款请求' : '已确认货物质量';
				$this->success($suc_info,url::createUrl('/Contract/sellerlist'));
			}else {
				$this->error($res['info']);
			}
			return false;
		}else{
			$info = $this->order->orderInfo($order_id);
			$this->getView()->assign('data',$info);	
		}
	}

	//买家确认合同结束
	public function contractCompleteAction(){
		$order_id = safe::filter($this->_request->getParam('order_id'));
		$res = $this->order->contractComplete($order_id,$this->user_id);
		if($res['success'] == 1){
			$credit = new \nainai\CreditConfig();
			$order = new \nainai\order\Order();
			$orderInfo = $order->orderInfo($order_id);
			$credit->changeUserCredit($orderInfo['user_id'],'contract',$orderInfo['amount']);
			$this->success('合同已结束',url::createUrl("/Contract/buyerlist"));
		}
		else
			$this->error($res['info']);
		return false;
	}
}
