<?php
/**
 * @author panduo
 * @date 2016-4-25
 * @brief 保证金订单表 暂只支持余额支付
 *
 */
namespace nainai\order;
use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;

class DepositOrder extends Order{
	
	public function __construct(){
		parent::__construct(parent::ORDER_DEPOSIT);
	}

	/**
	 * 买方预付定金(全款或定金) 需要在外部加事务
	 * @param array $info 订单信息数组
	 * @param int $type 0:定金1:全款 默认定金支付
	 * @param int $user_id 当前session用户id
	 * @param int $payment 用户支付方式 默认代理账户
	 */
	public function buyerDeposit($order_id,$type,$user_id,$payment=self::PAYMENT_AGENT){
		$info = $this->orderInfo($order_id);
		$offerInfo = $this->offerInfo($info['offer_id']);
		if(is_array($info) && isset($info['contract_status'])){
			$buyer = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? intval($info['user_id']) : intval($offerInfo['user_id']);
			$seller = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? intval($offerInfo['user_id']) : intval($info['user_id']);
			if($info['contract_status'] != self::CONTRACT_NOTFORM)
				return tool::getSuccInfo(0,'合同状态有误');
			if($buyer != $user_id)
				return tool::getSuccInfo(0,'订单买家信息有误');
			$orderData['id'] = $order_id;
			$orderData['contract_status'] = self::CONTRACT_SELLER_DEPOSIT;//合同状态置为等待卖方保证金支付
			$orderData['buyer_deposit_payment'] = $payment;
			$orderData['pay_deposit_time'] = date('Y-m-d H:i:s',time());
			if($type == 0){
				//定金支付
				$pay_deposit = $this->payDeposit($info);
				if(is_float($pay_deposit)){
					$orderData['pay_deposit'] = $pay_deposit;
				}else{
					return tool::getSuccInfo(0,$pay_deposit);
				}
			}else{
				//全款
				$amount = floatval($info['amount']);
				if($amount>0){
					$orderData['pay_deposit'] = $amount;
				}else{
					return tool::getSuccInfo(0,'无效订单');
				}
			}
			$clientID = tool::create_uuid($buyer);
			$orderData['buyer_deposit_clientid'] = $payment == self::PAYMENT_BANK ? $clientID : '';

			$upd_res = $this->orderUpdate($orderData);
			if($upd_res['success'] == 1){

				$log_res = $this->payLog($order_id,$buyer,0,'买方支付预付款--'.($type == 0 ? '定金' : '全款'));
				$res = $log_res === true ? true : $log_res;
				if($res === true){
					//冻结买方帐户资金  payment=1 余额支付
					$note_id = isset($info['order_no']) ? $info['order_no'] : $order_id;
					$note_type = $type==0 ? '订金' : '全款';
					$pay_account = $type == 0 ? $pay_deposit : $info['amount'];
					$note = '合同'.$note_id.$note_type.'支付 '.$pay_account;

					// $mess_seller = new \nainai\message($seller);
					// // $mess->send('depositPay',$info['order_no']);
					// $content = '合同'.$info['order_no'].'已支付'.$note_type.',报价方将在60分钟内';

					$mess_buyer = new \nainai\message($buyer);
					$content = '合同'.$info['order_no'].'已支付'.$note_type.',报价方将在60分钟内支付保证金,超过时间之后,您可以取消合同';
					$mess_buyer->send('common',$content);

					$mess_seller = new \nainai\message($seller);
					$jump_url = "<a href='".url::createUrl('/contract/sellerDetail?id='.$order_id.'@user')."'>跳转到合同详情页</a>";
					$content = '合同'.$info['order_no'].',需要支付保证金,请您及时进行支付。如果60分钟之后您未进行支付,买方有可能会取消合同.'.$jump_url;
					$mess_seller->send('common',$content);

					$account = $this->base_account->get_account($payment);
					
					if(!is_object($account)) return tool::getSuccInfo(0,$account);
					$res = $account->freeze($buyer,$orderData['pay_deposit'],$note);

				}

			}else{
				$res = $upd_res['info'];
			}

		}else{
			$res = '无效订单id';
		}

		return $res === true ? array_merge(tool::getSuccInfo(),array('amount'=>$info['amount'],'pay_deposit'=>$orderData['pay_deposit'])) : tool::getSuccInfo(0,$res ? $res : '未知错误');
	}

	/**
	 * 卖方支付保证金
	 * @param  int  $order_id 订单id
	 * @param  boolean $pay      卖方是否支付保证金 若未支付则取消合同 同时扣除卖方信誉值
	 * @param  int $user_id session中用户id
	 * @param  int $payment 支付方式 默认代理账户
	 * @return array   结果信息数组
	 */
	public function sellerDeposit($order_id,$pay = true,$user_id,$payment=self::PAYMENT_AGENT){
		if($this->orderComplain($order_id)) return tool::getSuccInfo(0,'申述处理中');
		$info = $this->orderInfo($order_id);
		$offerInfo = $this->offerInfo($info['offer_id']);
		if(is_array($info) && isset($info['contract_status'])){
			$orderData['id'] = $order_id;
			$tmp = $this->sellerUserid($order_id);
			if($offerInfo['type'] == \nainai\offer\product::TYPE_SELL){
				$seller = $tmp;
				$buyer = intval($info['user_id']);
			}else{
				$seller = intval($info['user_id']);
				$buyer = $tmp;
			}
			$mess_buyer = new \nainai\message($buyer);
			$mess_seller = new \nainai\message($seller);

			if($info['contract_status'] != self::CONTRACT_SELLER_DEPOSIT)
				return tool::getSuccInfo(0,'合同状态有误');
			if(($pay === true && $seller != $user_id) || ($pay === false && $buyer != $user_id))
				return tool::getSuccInfo(0,'订单用户信息有误');
			try {
				$this->order->beginTrans();
				if($pay === false){
					//未支付 合同取消
					
					$account = $this->base_account->get_account($info['buyer_deposit_payment']);
					if(!is_object($account)) return tool::getSuccInfo(0,$account);

					$orderData['contract_status'] = self::CONTRACT_CANCEL;
					$upd_res = $this->orderUpdate($orderData);
					
					//扣除信誉值
					// $configs_credit = new \nainai\CreditConfig();
					// $cre_res = $configs_credit->changeUserCredit($seller,'cancel_contract',$info['pay_deposit']);
					
					//将商品数量解冻
					$pro_res = $this->productsFreezeRelease($this->offerInfo($info['offer_id']),$info['num']);

					$log_res = $this->payLog($order_id,$user_id,1,'买方取消合同,合同作废,扣除信誉值');

					$res = $upd_res['success'] == 1  && $pro_res === true && $log_res === true ? true : $upd_res['info'].$pro_res.$log_res;

					if($res === true){
						//将买方冻结资金解冻
						$note = '卖方未支付合同'.$info['order_no'].'保证金 退还定金 '.$info['pay_deposit'];
						$res = $acc_res = $account->freezeRelease($buyer,floatval($info['pay_deposit']),$note);

						$content = '合同'.$info['order_no'].'已取消。根据交易规则，已退还您支付的预付款。请您关注资金动态。';
						$mess_buyer->send('common',$content);

						$content = '合同'.$info['order_no'].',由于您未及时支付保证金，买方已取消合同';
						$mess_seller->send('common',$content);
					}
					
				}elseif($pay === true){
					//卖方支付保证金
					
					if(is_int($seller)){
						//获取卖方保证金数值 
						$sys_percent_obj = new M('scale_offer');//后台配置保证金基数比例
						$sys_percent = $sys_percent_obj->where(array('id'=>1))->getField('deposite');

						//获取当前用户等级保证金比例
						$user = new \nainai\member();
						$user_percent = $user->getUserGroup($seller);
						if($user_percent['caution_fee'] === false) return tool::getSuccInfo(0,'用户等级未知');
						$percent = (floatval($sys_percent) * floatval($user_percent['caution_fee'])) / 10000;
						$seller_deposit = number_format(floatval($info['amount'] * $percent),2);
						//冻结卖方帐户保证金
						$note = '支付合同'.$info['order_no'].'保证金 '.$seller_deposit;	

						$orderData['seller_deposit_payment'] = $payment;
						$orderData['seller_deposit'] = $seller_deposit;
						//判断此订单是否支付全款
						if($info['amount'] === $info['pay_deposit']){
							//全款 合同生效 等待提货
							$orderData['contract_status'] = self::CONTRACT_EFFECT;
						}else{
							//定金 等待支付尾款
							$orderData['contract_status'] = self::CONTRACT_BUYER_RETAINAGE;
						}

						$upd_res = $this->orderUpdate($orderData);

						if($upd_res['success'] == 1){
							$log_res = $this->payLog($order_id,$user_id,1,'卖方支付保证金');
							//信誉值增加
							$configs_credit = new \nainai\CreditConfig();
							$cre_res = $configs_credit->changeUserCredit($seller,'cert_margin',$seller_deposit);
							
							$res = ($cre_res && $log_res === true) ? true : $log_res.$cre_res;
						}else{
							$res = $upd_res['info'];
						}
						if($res === true){
							$account = $this->base_account->get_account($payment);
							// var_dump($account);exit;
							if(!is_object($account)) return tool::getSuccInfo(0,$account);
							$res = $account->freeze($seller,$seller_deposit,$note);
							
							$jump_url = "<a href='".url::createUrl('/contract/buyerDetail?id='.$order_id.'@user')."'>跳转到合同详情页</a>";
							$content = '合同'.$info['order_no'].'报价方已支付保证金,请您及时支付尾款。'.$jump_url;
							$mess_buyer->send('common',$content);
						}
					}else{
						$res = $seller;
					}
				}else{
					$res = '参数错误';
				}
				$res = $res === true ? $this->order->commit() : $res;
				
			} catch (\PDOException $e) {
				$res = $e->getMessage();
				$this->order->rollBack();
			}
		}else{
			$res = '无效订单id';
		}
		return $res === true ? tool::getSuccInfo() : tool::getSuccInfo(0,$res ? $res : '未知错误');
	}


}




