<?php
/**
 * @author panduo
 * @date 2016-4-25
 * @brief 仓单订单表 暂只支持余额支付
 *
 */
namespace nainai\order;
use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;
class StoreOrder extends Order{
	
	public function __construct(){
		parent::__construct(parent::ORDER_STORE);
	}

	/**
	 * 买方预付定金(全款或定金)
	 * @param array $info 订单信息数组
	 * @param int $type 0:定金1:全款 默认定金支付
	 * @param int $user_id 当前session用户id
	 */
	public function buyerDeposit($order_id,$type,$user_id,$payment=self::PAYMENT_AGENT){
		$info = $this->orderInfo($order_id);
		$offerInfo = $this->offerInfo($info['offer_id']);
		if(is_array($info) && isset($info['contract_status']) && isset($offerInfo)){
			if($info['contract_status'] != self::CONTRACT_NOTFORM)
				return tool::getSuccInfo(0,'合同状态有误');
			if($info['user_id'] != $user_id)
				return tool::getSuccInfo(0,'订单买家信息有误');
			$orderData['id'] = $order_id;
			$orderData['buyer_deposit_payment'] = $payment;
			if($type == 0){
				//定金支付
				$orderData['contract_status'] = self::CONTRACT_BUYER_RETAINAGE;//合同状态置为等待买方支付尾款
				$pay_deposit = $this->payDeposit($info);
				if(is_float($pay_deposit)){
					$orderData['pay_deposit'] = $pay_deposit;
				}else{
					return tool::getSuccInfo(0,$pay_deposit);
				}
			}else{
				//全款
				$orderData['contract_status'] = self::CONTRACT_EFFECT;//合同状态置为已生效
				$amount = floatval($info['amount']);
				if($amount>0){
					$orderData['pay_deposit'] = $amount;
				}else{
					return tool::getSuccInfo(0,'无效订单');
				}
			}


				$upd_res = $this->orderUpdate($orderData);
				if($upd_res['success'] == 1){
					//冻结买方帐户资金 
					$account = $this->base_account->get_account($payment);
					if(!is_object($account)) return tool::getSuccInfo(0,$account);
					$note_id = isset($info['order_no']) ? $info['order_no'] : $order_id;
					$note_type = $type==0 ? '订金' : '全款';
					$pay_account = $type == 0 ? $pay_deposit : $info['amount'];
					$note = '合同'.$note_id.$note_type.'支付 '.$pay_account;
					$acc_res = $account->freeze($info['user_id'],$orderData['pay_deposit'],$note);
					if($acc_res === true){
						$mess = new \nainai\message($info['user_id']);
						$content = $type == 0 ? '(合同'.$info['order_no'].'已支付定金,请您及时支付尾款)' : '(合同'.$info['order_no'].'已生效,您可以申请提货了)';
						$content .= "<a href='".url::createUrl('/contract/buyerDetail?id='.$order_id.'@user')."'>跳转到合同详情页</a>";
						$mess->send('common',$content);

						$mess_seller = new \nainai\message($offerInfo['user_id']);
						$content = $type == 0 ? '合同'.$info['order_no'].',买方已支付定金,等待其支付尾款' : '合同'.$info['order_no'].'已支付全款,等待其提货申请';
						$mess_seller->send('common',$content);
						$log_res = $this->payLog($order_id,$user_id,0,'买方支付预付款--'.($type == 0 ? '定金' : '全款'));
						$res = $log_res === true ? true : $log_res;
					}else{
						$res = $acc_res;
					}	
				}else{
					$res = $upd_res['info'];
				}
		}else{
			$res = '无效订单id';
		}
		return $res === true ? array_merge(tool::getSuccInfo(),array('amount'=>$info['amount'],'pay_deposit'=>$orderData['pay_deposit'])) : tool::getSuccInfo(0,$res ? $res : '未知错误');
	}


}




