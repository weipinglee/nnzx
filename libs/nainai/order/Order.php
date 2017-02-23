<?php
/**
 * @author panduo
 * @date 2016-5-2
 * @brief 合同订单基类
 *
 */
namespace nainai\order;
use Library\cache\driver\Memcache;
use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;
use \search\adminQuery;
use \Library\Time;
class Order{

	//合同制状态常量
	const CONTRACT_NOTFORM = 0;//合同未形成
	const CONTRACT_SELLER_DEPOSIT = 1;//合同等待卖家缴纳保证金
	const CONTRACT_CANCEL = 2;//卖家未按时支付保证金合同作废
	const CONTRACT_BUYER_RETAINAGE = 3;//卖家支付保证金后等待接受尾款
	const CONTRACT_EFFECT = 4;//支付完成合同生效
	const CONTRACT_DELIVERY_COMPLETE = 5; //提货量超过80%，提货完成
	const CONTRACT_VERIFY_QAULITY = 6;//买家已确认货物质量（保证金/仓单） 提货
	const CONTRACT_SELLER_VERIFY = 7; //卖家确认  包含买方扣减款项
	const CONTRACT_COMPLETE = 8;//合同完成

	//订单类型常量定义 
	const ORDER_PURCHASE = 0;//采购报盘
	const ORDER_FREE = 1;//自由报盘订单
	const ORDER_DEPOSIT = 2;//保证金报盘订单

	const ORDER_ENTRUST = 3;//委托报盘
	const ORDER_STORE = 4;//仓单报盘订单

	const PAYMENT_AGENT = 1;//代理账户
	const PAYMENT_BANK = 2;//银行签约账户
	const PAYMENT_TICKET = 3;//票据账户
	const PAYMENT_ALIPAY = 4;//支付宝

	protected $order_table;//订单表名
	protected $offer_table;//报盘表
	protected $product_table = 'products';//商品表
	protected $order;//订单表M对象
	protected $order_type;//订单表类型
	protected $offer;//报盘表
	protected $account;//用户资金类
	protected $products;//商品表
	protected $paylog;//日志
	protected $mess;//消息表
	protected $user_invoice;//用户发票类
	protected $zx;//中信银行签约类
	protected $base_account;
	protected $delivery;
	/**
	 * 规则
	 */
	protected $orderRules = array(
		array('id','number','id错误',0,'regex'),
		array('offer_id','number','报盘id错误',0,'regex'),
		array('user_id','number','买方id错误',0,'regex'),
	);


	public function __construct($order_type = 0){
		$this->order_type = $order_type;
		$this->order_table = 'order_sell';
		$this->offer_table = 'product_offer';
		$this->order = new M($this->order_table);
		$this->offer = new M('product_offer');
		$this->products = new M('products');
		$this->paylog = new M('pay_log');
		$this->account = new \nainai\fund\agentAccount();
		$this->base_account = new \nainai\fund\account();
		$this->user_invoice = new \nainai\user\UserInvoice();
		$this->zx = new \nainai\fund\zx();
		$this->delivery = new \nainai\delivery\Delivery();
	}	

	/**
	 * 判断报盘是否存在或通过审核
	 * @param  int $offer_id 报盘id
	 * @return boolean  true:通过 false:未通过
	 */
	public function offerExist($offer_id){
		$res = $this->offer->where(array('id'=>$offer_id))->fields('status,is_del,expire_time')->getObj();

		return !empty($res) && $res['status'] == 1 && $res['is_del'] == 0 && time() < strtotime($res['expire_time'])? true : false;
	}

	/**
	 * 判断订单是否为申述状态
	 */
	public function orderComplain($order_id){
		$complain = new M('order_complain');
		$status = $complain->where(array('order_id'=>$order_id))->getfield('status');
		return in_array($status,array(\nainai\order\OrderComplain::APPLYCOMPLAIN,\nainai\order\OrderComplain::INTERVENECOMPLAIN)) ? true : false;
	}

	/**
	 * 买方违约	
	 * @param  int $order_id 订单id
	 * @return boolean  状态
	 */
	public function buyerBreakContract($order_id){
		$info = $this->orderInfo($order_id);
		$offerInfo = $this->offerInfo($info['offer_id']);
		$delivery = new \nainai\delivery\Delivery();
		$deposit_title = $info['pay_deposit'] == $info['amount'] ? '货款' : '定金';
		$seller = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $offerInfo['user_id'] : $info['user_id'];
		$buyer = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $info['user_id'] : $offerInfo['user_id'];
		$pay_deposit = number_format($info['pay_deposit'],2);
		if($pay_deposit <= floatval($info['amount'] * 0.1)){
			//定金小于总货款10%
			$pay_break = $pay_deposit;
			$pay_title = '该合同全部'.$deposit_title;
		}else{
			$pay_break = floatval($info['amount']) * 0.1;
			$pay_title = '该合同总货款的10%';
		}
		$pay_break = number_format($pay_break,2);
		try {
			$this->order->data(array('id'=>$order_id,'contract_status'=>self::CONTRACT_CANCEL))->update();
			
			$account_deposit = $this->base_account->get_account($info['buyer_deposit_payment']);
			$account_retainage = $this->base_account->get_account($info['retainage_payment']);
			$account_seller_deposit = $this->base_account->get_account($info['seller_deposit_payment']);
			
			$product_left = $delivery->orderNumLeft($order_id,false,true);

			$res = $this->productsFreezeRelease($offerInfo,$product_left);

			$credit = new \nainai\CreditConfig();
            $credit->changeUserCredit($info['user_id'], 'buyer_break');

			$mess_buyer = new \nainai\message($buyer);
			$content = '合同'.$info['order_no'].',申诉结果为：买方违约，合同终止。根据交易规则，将扣除您'.$pay_title.'给卖方,请您关注资金动态。';
			$mess_buyer->send('common',$content);

			$mess_seller = new \nainai\message($seller);
			$content = '合同'.$info['order_no'].',申诉结果为：买方违约，合同终止。根据交易规则，买方将支付您'.$pay_title.',请您关注资金动态。';
			$mess_seller->send('common',$content);
			// $mess->send('breakcontract',$order_id);
			//买方支付卖方违约金 
			if(is_object($account_deposit)){
				$res = $account_deposit->freezePay($buyer,$seller,$pay_break,'申诉,买方违约,支付卖方'.$pay_title.','.$pay_break,$pay_deposit);
				if($res === true){
					$deposit_left = $pay_deposit-$pay_break;
					$res = $pay_break == $pay_deposit ? true : $account_deposit->freezeRelease($buyer,$deposit_left,'申诉,买方违约,解冻剩余'.$deposit_title.$deposit_left);
				}
			}else{
				$res = '无效定金支付方式';
			}

			if(is_object($account_retainage) && $res === true){
				$res = $info['pay_retainage'] ? $account_retainage->freezeRelease($buyer,$info['pay_retainage'],'申诉,买方违约,解冻尾款'.number_format($info['pay_retainage'],2)) : true;
			}

			if(is_object($account_seller_deposit) && $res === true){
				$res = $info['seller_deposit'] ? $account_seller_deposit->freezeRelease($seller,$info['seller_deposit'],'申诉,买方违约,解冻保证金'.number_format($info['seller_deposit'],2)) : true;
			}
		} catch (\PDOException $e) {

			$res = $e->getMessage(); 
		}
		return $res ;
	}

	/**
	 * 卖方违约	
	 * @param  int $order_id 订单id
	 * @return boolean  状态
	 */
	public function sellerBreakContract($order_id){
		$info = $this->orderInfo($order_id);
		$offerInfo = $this->offerInfo($info['offer_id']);
		$deposit_title = $info['pay_deposit'] == $info['amount'] ? '货款' : '定金';
		$delivery = new \nainai\delivery\Delivery();
		try {
			$seller = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $offerInfo['user_id'] : $info['user_id'];
			$buyer = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $info['user_id'] : $offerInfo['user_id'];
			$mess_buyer = new \nainai\message($buyer);
			$mess_seller = new \nainai\message($seller);

			$account_deposit = $this->base_account->get_account($info['buyer_deposit_payment']);
			$account_retainage = $this->base_account->get_account($info['retainage_payment']);
			$account_seller_deposit = $this->base_account->get_account($info['seller_deposit_payment']);

			if($info['mode'] == self::ORDER_DEPOSIT || $info['mode'] == self::ORDER_PURCHASE){
				$seller_deposit = floatval($info['seller_deposit']);
				// $res = $this->account->freezePay($offerInfo['user_id'],$info['user_id'],$seller_deposit * 0.1);
				
				//解冻未提货货物
				$product_left = $delivery->orderNumLeft($order_id,false,true);
				$this->productsFreezeRelease($offerInfo,$product_left);

				$credit = new \nainai\CreditConfig();
                $credit->changeUserCredit($offerInfo['user_id'], 'seller_break');
		
				$content = '合同'.$info['order_no'].',申诉结果为：卖方违约，合同终止。根据交易规则，卖方将支付您该合同保证金的10%,请您关注资金动态。';
				$mess_buyer->send('common',$content);
				
				$content = '合同'.$info['order_no'].',申诉结果为：卖方违约，合同终止。根据交易规则，将扣除您该合同保证金10%给买方,请您关注资金动态。';
				$mess_seller->send('common',$content);
				//将卖方保证金支付10%支付给买方 解冻货物
				if(is_object($account_seller_deposit)){
					$res = $seller_deposit ? $account_seller_deposit->freezePay($seller,$buyer,$seller_deposit*0.1,'申诉,卖方违约,支付买方保证金10%,'.number_format($seller_deposit*0.1,2),$seller_deposit) : true;
					if (is_string($res)) {
						return $res;
					}else{
						$res = $seller_deposit ? $account_seller_deposit->freezeRelease($seller,$seller_deposit*0.9,'申诉,卖方违约,解冻剩余保证金,'.number_format($seller_deposit*0.9,2)) : true;
					}
				}else{
					$res = '无效保证金支付方式';
				}
			}else{
				$content = '合同'.$info['order_no'].',申诉结果为：卖方违约，合同终止。';
				$mess_buyer->send('common',$content);
				$mess_seller->send('common',$content);

			}
			$res = (bool)$this->order->data(array('id'=>$order_id,'contract_status'=>self::CONTRACT_CANCEL))->update();
			//解冻买方货款   线下支付？？？
			if(is_object($account_deposit) && $res === true){
				$res = $account_deposit->freezeRelease($buyer,$info['pay_deposit'],'申诉,卖方违约,解冻'.$deposit_title.number_format($info['pay_deposit'],2));
			}

			if(is_object($account_retainage) && $res === true){
				$res = $info['pay_retainage'] ? $account_retainage->freezeRelease($buyer,$info['pay_retainage'],'申诉,卖方违约,解冻尾款'.number_format($info['pay_retainage'],2)) : true;
			}
		} catch (\PDOException $e) {

			$res = $e->getMessage();
		}
		return !empty($res) ? $res : '未知错误';
	}	

	/**
	 * 新增或更新订单数据
	 * @param  object $order 订单表对象	
	 * @param  array $data  订单数据
	 * @return array $res  返回结果信息
	 */
	public function orderUpdate($data){
		$order = $this->order;
		if($order->data($data)->validate($this->orderRules)){
			if(isset($data['id']) && $data['id']>0){
				$id = $data['id'];
				//编辑
				unset($data['id']);
				$res = $order->where(array('id'=>$id))->data($data)->update();
				$res = $res>0 ? true : ($order->getError() ? $order->getError() : '数据未修改');
			}else{
				while($this->existOrderData($order,array('order_no'=>$data['order_no']))){
					$data['order_no'] = tool::create_uuid();
				}
				$order_id = $order->data($data)->add();
				$this->payLog($order_id,$data['user_id'],0,'买方下单');
				$res = true;
			}
		}else{
			$res = $order->getError();
		}
		
		if($res === true){
			$resInfo = tool::getSuccInfo();
			if(isset($order_id)){
				$resInfo['order_id'] = $order_id;
			}
		}else{
			$resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;
	}

	/**
	 * 验证订单数据是否已存在
	 * @param object $order 订单表对象
	 * @param array $orderData 订单数据
	 * @return bool  存在 true 否则 false
     */
	private function existOrderData($order,$orderData){
		$data = $order->fields('id')->where($orderData)->getObj();
		if(empty($data))	
			return false;
		return true;
	}


	//生成摘牌订单
	public function geneOrder($orderData){
		$check_payment = 0;
		if(in_array($orderData['mode'],array(self::ORDER_FREE,self::ORDER_ENTRUST))){
			$orderData['contract_status'] = self::CONTRACT_BUYER_RETAINAGE;
		}else{
			$check_payment = 1;
			$orderData['contract_status'] = self::CONTRACT_NOTFORM;	
		}
		if($orderData['mode'] != self::ORDER_PURCHASE){
			$offer_exist = $this->offerExist($orderData['offer_id']);
			if($offer_exist === false) return tool::getSuccInfo(0,'报盘不存在或未通过审核');
		}

		$offer_info = $this->offerInfo($orderData['offer_id']);
		if($offer_info['user_id'] == $orderData['user_id']){
			return tool::getSuccInfo(0,'买方卖方为同一人');
		}
		
		if(isset($offer_info['price']) && $offer_info['price']>0){
			$product_valid = $this->productNumValid($orderData['num'],$offer_info);
			if($product_valid !== true)
				return tool::getSuccInfo(0,$product_valid);
			$orderData['amount'] = $offer_info['price'] * $orderData['num'];
			
			//判断用户买家余额是否足够
			if($check_payment){
				//获取摘牌所需定金数额
				$pay_deposit = $this->payDepositCom($orderData['offer_id'],$orderData['amount']);
				$user_id = isset($orderData['buyer_id']) ? $orderData['buyer_id'] : $orderData['user_id'];//采购买家与正常相反
				switch ($orderData['payment']) {
					case self::PAYMENT_AGENT:
						//代理账户
						$balance = $this->account->getActive($user_id);
						break;
					case self::PAYMENT_BANK:
						//银行签约账户
						$balance = $this->zx->attachBalance($user_id);

						$balance = $balance['KYAMT'];
						break;
					case self::PAYMENT_TICKET:
						//票据账户
						break;
					default:
						return tool::getSuccInfo(0,'参数错误');
						break;
				}
				if(floatval($balance) < $pay_deposit){
					return tool::getSuccInfo(0,'账户余额不足');
				}
			}

			unset($orderData['payment']);

			$upd_res = $this->orderUpdate($orderData);

			$pro_res = $this->productsFreeze($offer_info,$orderData['num']);
			if($pro_res != true) return tool::getSuccInfo(0,$pro_res);
			
			$res = isset($res) ? tool::getSuccInfo(0,$res) : $upd_res;
		}else{
			$res = tool::getSuccInfo(0,'无效报盘');
		}

		return $res;
	}

	/**
	 * 根据订单id获取报盘用户的id
	 * @param  int $order_id 订单id
	 * @return int:用户id string:错误信息
	 */
	protected function sellerUserid($order_id){
		$query = new Query($this->order_table.' as o');
		$query->join = 'left join product_offer as po on po.id = o.offer_id';
		$query->fields = 'po.user_id';
		$query->where = 'o.id=:id';
		$query->bind = array('id'=>intval($order_id));
		$res = $query->getObj();
		$user_id = intval($res['user_id']);
		return $user_id ? $user_id : '用户不存在';
	}

	//根据订单id获取订单内容	
	public function orderInfo($order_id){
		return empty($order_id) ? array() : $this->order->where(array('id'=>$order_id))->fields()->getObj();
	}

	//根据报盘id获取相应信息
	public function offerInfo($offer_id){
		$query = new Query('product_offer as po');
		$query->join = 'left join user as u on po.user_id = u.id left join products as p on po.product_id = p.id';
		$query->where = " po.id = :id";
		$query->bind = array('id'=>$offer_id);
		$query->fields = "po.*,u.username,p.name as product_name,p.cate_id";
		$res = $query->getObj();
		return $res ? $res : array();
	}

	/**
	 * 买家支付尾款
	 * @param  int  $order_id 订单id
	 * @param  int  $user_id  当前操作用户id
	 * @param  string  $payment  线上/线下支付
	 * @param  string  $proof    线下支付凭证图片
	 * @param  int $account  线上支付方式
	 * @return array  操作信息
	 */
	public function buyerRetainage($order_id,$user_id,$payment='online',$proof = '',$account=0){
		if($this->orderComplain($order_id)) return tool::getSuccInfo(0,'申述处理中');
		$info = $this->orderInfo(intval($order_id));
		$offerInfo = $this->offerInfo($info['offer_id']);
		$is_entrust = $info['mode'] == self::ORDER_ENTRUST ? 1 : 0;
		if(is_array($info) && isset($info['contract_status'])){
			$seller = $this->sellerUserid($order_id);
			$buyer = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? intval($info['user_id']) : $seller;
			$seller = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $seller : intval($info['user_id']);
			if($info['contract_status'] == self::CONTRACT_BUYER_RETAINAGE || $info['contract_status'] == self::CONTRACT_NOTFORM){
				if($buyer != $user_id)
					return tool::getSuccInfo(0,'订单买家信息有误');

				$amount = floatval($info['amount']);
				$buyerDeposit = floatval($info['pay_deposit']);
				$retainage = $amount - $buyerDeposit;
				$sim_oper = in_array($info['mode'],array(self::ORDER_FREE));
				if($retainage>0){
					try {
						$this->order->beginTrans();
						$orderData['id'] = $order_id;
						$orderData['retainage_payment'] = $account;
						$payment = $sim_oper ? 'offline' : $payment;
						//自由与委托报盘只接受线下凭证
						$mess = new \nainai\message($seller);
						// var_dump($retainage);exit;
						if($payment == 'online'){
							//冻结买家帐户余额
							$orderData['pay_retainage'] = $retainage;
							$orderData['contract_status'] = $is_entrust ? self::CONTRACT_COMPLETE : self::CONTRACT_EFFECT;//payment为1  合同状态置为生效 委托报盘则置为已完成
							// $orderData['retainage_clientid'] = $account == self::PAYMENT_BANK ? $clientID : '';
							$upd_res = $this->orderUpdate($orderData);
							if($upd_res['success'] == 1){
								$log_res = $this->payLog($order_id,$user_id,0,'买家线上支付尾款');
								
								// $mess->send('buyerRetainage',$info['order_no']);
								$mess_buyer = new \nainai\message($buyer);
								if($is_entrust == 1){
									$content = '(合同'.$info['order_no'].'买家已支付尾款，合同已结束，请您关注资金动态。交收流程请您在线下进行操作。)';
								}else{
									$jump_url = "<a href='".url::createUrl('/contract/buyerDetail?id='.$order_id.'@user')."'>跳转到合同详情页</a>";
									$content = '(合同'.$info['order_no'].'已生效，您可以申请提货了。)'.$jump_url;
								}
								$mess_buyer->send('common',$content);
								$res = $log_res;
							}else{
								$res = $upd_res['info'];
							}
							if($res === true && $is_entrust == 0){
								$note = '支付合同'.$info['order_no'].'尾款 '.number_format($retainage,2);
								$account = $this->base_account->get_account($account);
								if(!is_object($account)) return tool::getSuccInfo(0,$account);
								$acc_res = $account->freeze($buyer,$retainage,$note);
							}elseif($is_entrust == 1){
								$res = $this->entrustComplete($info,$buyer,$seller,$payment,$account);
							}

							if($res === true) $res = $this->order->commit();
						}elseif($payment == 'offline'){
							$orderData['proof'] = $proof;
							$upd_res = $this->orderUpdate($orderData);
							if($upd_res['success'] == 1){
								$jump_url = "<a href='".url::createUrl('/contract/sellerDetail?id='.$order_id.'@user')."'>跳转到合同详情页</a>";
								$content = $sim_oper ? '(合同'.$info['order_no'].',买方已支付货款,请您及时进行凭证确认,并关注资金动态。)'.$jump_url:'(合同'.$info['order_no'].',买家已支付尾款。请您及时确认并关注资金动态)'.$jump_url;
								$mess->send('common',$content);
								$log_res = $this->payLog($order_id,$user_id,0,'买家上传线下支付凭证');
								$res = $log_res === true ? $this->order->commit() : $log_res;
							}else{
								$res = $upd_res['info'];
							}
						}else{
							$this->order->rollBack();
							$res = '无效支付方式';
						}	
					} catch (PDOException $e) {
						$res = $e->getMessage();
						$this->order->rollBack();
					}
				}else{
					$res = '合同金额有误';
				}
			}else{
				$res = '合同状态有误';
			}
		}else{
			$res = '无效订单';
		}

		return $res === true ? tool::getSuccInfo() : tool::getSuccInfo(0,$res ? $res : '未知错误');
	}

	/**
	 * 卖家确认买家线下支付凭证
	 * @param  int  $order_id 订单id
	 * @param  int  $user_id  session中用户id
	 * @param  boolean $confirm  true:确认收款 false:未收款 买家需重新上传凭证
	 * @return array  结果信息数组
	 */
	public function confirmProof($order_id,$user_id,$confirm = true){
		if($this->orderComplain($order_id)) return tool::getSuccInfo(0,'申述处理中');
		$info = $this->orderInfo($order_id);
		$offerInfo = $this->offerInfo($info['offer_id']);

		try {
			$this->order->beginTrans();
			if(is_array($info) && isset($info['contract_status'])){
				$sim_oper = in_array($info['mode'],array(self::ORDER_ENTRUST,self::ORDER_FREE));
				if(!$sim_oper && $info['contract_status'] != self::CONTRACT_BUYER_RETAINAGE){
					return tool::getSuccInfo(0,'合同状态有误');
				}
				$seller_tmp = $this->sellerUserid($order_id);
				$seller = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $seller_tmp : intval($info['user_id']);
				$buyer  = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? intval($info['user_id']) : $seller_tmp;

				if($seller != $user_id)
					return tool::getSuccInfo(0,'订单卖家信息有误');

				if(empty($info['proof'])){
					return tool::getSuccInfo(0,'无效支付凭证');
				}
				$orderData['id'] = $order_id;
				//发送提示信息买家  
				$mess_seller = new \nainai\message($seller);
				$mess_buyer = new \nainai\message($buyer);
				if($confirm === true){
					//卖家确认收款
					
					$order_type = $info['mode'] != self::ORDER_FREE && $info['mode'] != self::ORDER_ENTRUST;
					//合同状态置为生效
					$orderData['contract_status'] = $order_type ? self::CONTRACT_EFFECT : self::CONTRACT_COMPLETE;
					$orderData['end_time'] = $order_type ? NULL : date('Y-m-d H:i:s',time());
					$log_res = $this->payLog($order_id,$user_id,1,'卖家确认线下支付凭证');
					
					if($sim_oper){
						$content = '合同'.$info['order_no'].'卖家已确认收款,合同完成。交收流程请您在线下进行操作。';
						$mess_buyer->send('common',$content);
						$content = '合同'.$info['order_no'].'，合同已完成。交收流程请您在线下进行操作。';
						$mess_seller->send('common',$content);
					}else{
						$jump_url = "<a href='".url::createUrl('/contract/buyerDetail?id='.$order_id.'@user')."'>跳转到合同详情页</a>";
						$content = '(合同'.$info['order_no'].'已生效，您可以申请提货了。)'.$jump_url;
						$mess_buyer->send('common',$content);
					}
				}elseif($confirm === false){
					//删除之前上传proof
					$orderData['proof'] = null;
					$log_res = $this->payLog($order_id,$user_id,1,'线下支付凭证无效');
					
				}else{
					$res = '参数错误';
				}

				if($info['mode'] == self::ORDER_ENTRUST){
					$tmp = $this->entrustComplete($info,$buyer,$seller);
					if($tmp !== true) $res = $tmp;
				}

				if(!isset($res)){
					
					$upd_res = $this->orderUpdate($orderData);
					if($upd_res['success'] == 1){
						$pdo_res = $order_type ? true : $this->productsFreezeToSell($offerInfo,$info['num']);
						if($pdo_res === true){
							$res = $log_res === true ? $this->order->commit() : $log_res;	
						}else{
							$res = $pdo_res;
						}
						
					}else{
						$this->order->rollBack();
						$res = $upd_res['info'];
					}
				}

			}else{
				$res = '无效订单id';
			}

			$res = $res ? $res : $this->order->commit();
		}catch(Exception $e){
			$this->order->rollBack();
			$res = $e->getMessage();
		}
		return $res === true ? tool::getSuccInfo() : tool::getSuccInfo(0,$res ? $res : '未知错误');
	}

	/**
	 * 委托报盘摘牌流程结束，解冻支付与支付委托金	
	 * @param  array $info 订单信息
	 * @param  int $buyer  买家id
	 * @param  int $seller  卖家id
	 * @param  string $payment 支付方式(线上/线下)
	 * @param  string $account 支付方式为线上时的尾款支付渠道
	 * @return mixed  
	 */
	public function entrustComplete($info,$buyer,$seller,$payment='offline',$account=''){
		$amount = floatval($info['amount']);
		$buyerDeposit = floatval($info['pay_deposit']);
		$retainage = $amount - $buyerDeposit;
		if($retainage > 0){
			if($info['seller_deposit'] > 0){
				if($info['retainage_payment'] != self::PAYMENT_ALIPAY){
					$note = '合同'.$info['order_no'].'完成,解冻平台委托金 '.$info['seller_deposit'];
					$fre_res = $this->account->freezeRelease($seller,$info['seller_deposit'],$note);
					
					if($fre_res === true){
						$note = '合同'.$info['order_no'].'完成,支付给平台委托金 '.$info['seller_deposit'];

						$pay_res = $this->account->payMarket($seller,$info['seller_deposit'],$note);

						if($pay_res !== true ) $res = $pay_res;
					}else{
						$res = $fre_res;
					}
				}else{
					//记录支付宝支付记录  TODO
				}
			}
			$account_deposit = $this->base_account->get_account($info['buyer_deposit_payment']);
			if(is_object($account_deposit) && !$res){
				//尾款线下支付
				$note = '合同'.$info['order_no'].'完成,支付定金'.$info['pay_deposit'];
				$fpay_res = $account_deposit->freezePay($buyer,$seller,$info['pay_deposit'],$note);
				if($fpay_res !== true ) $res = $fpay_res;
			}else{
				$res = $res ? $res : '无效定金支付方式';
			}

			if($payment == 'online'){
				//线上支付，直接将尾款部分进行转账操作
				$account_retainage = $this->base_account->get_account($account);
				if(is_object($account_retainage) && !$res){
					$note = '支付合同'.$info['order_no'].'尾款 '.number_format($retainage,2);
					$tmp = $account_retainage->transfer($buyer,$seller,array('amount'=>$retainage,'note'=>$note));
					if($tmp !== true) $res = $tmp;
				}else{
					$res = $res ? $res : '无效定金支付方式';
				}
			}
		}else{
			$res = '无效尾款金额';
		}

		return isset($res) ? $res : true;
	}

	/**
	 * 根据订单id计算买方定金数额
	 * @param  array $info 订单信息数组
	 * @return float:定金数值 string:报错信息
	 */
	final protected function payDeposit($info){
		if(isset($info['offer_id']) && isset($info['amount'])){
			$amount = $info['amount'];
			if(($amount = floatval($amount)) > 0){
				//获取保证金比率
				$preFee = $this->payDepositCom($info['offer_id'],$amount);

				if($preFee===false){
					return '无效定金';
				}
				else{
					return $preFee;
				}

			}
			return '无效订单';
		}else{
			return '参数错误';
		}
	}

	//获取买方定金数额（通用）
	public function payDepositCom($offer_id,$amount){
		if(($amount = floatval($amount)) > 0){
			//获取保证金比率
			$query = new Query('products as p');
			$query->join = 'left join product_offer as po on po.product_id = p.id ';
			$query->fields = 'p.cate_id';
			$query->where = 'po.id=:offer_id';
			$query->bind = array('offer_id'=>$offer_id);
			$res = $query->getObj();
			$cate_id = $res['cate_id'];

			$percent = $this->getCatePercent($cate_id);
			if($percent>0 && $percent<100){
				//能否等于0或者100
				return ($percent/100)*$amount;
			}
			return false;
		}
		return false;
	}

	/**
	 * 获取分类首付款比率
	 */
	public function getCatePercent($id,$obj=null){
		if($obj==null)
			$obj = new M('product_category');
		static $percent = 0;
		$res = $obj->where(array('id'=>$id))->fields('percent,pid')->getObj();
		if($res['percent']==0 && $res['pid']!=0){
			$percent = $this->getCatePercent($res['pid'],$obj);
		}
		else
			$percent = $res['percent'];

		return $percent;

	}

	/**
	 * 查看产品数量是否合规
	 * @param  array $product 产品信息数组
	 * @return true:可以下单 string:错误信息
	 */
	public function productNumValid($num,$offer_info,$product=array()){
		$res = $this->productNumLeft($offer_info['product_id'],$product);
		if($offer_info['divide'] == \nainai\offer\product::UNDIVIDE && bccomp($num,$res['quantity'],2) != 0)
			return '此商品不可拆分';

		if(bccomp($num,$res['left'],2) > 0){//精确比较到小数点后两位，
			return '商品存货不足';
		}

		if(bccomp($offer_info['minimum'],$res['left'],2) < 0 && bccomp($num,$offer_info['minimum'],2) <0){
			return '小于最小起订量';
		}
		//剩余量小于等于最小起订量且购买量不等于剩余量
		if(bccomp($offer_info['minimum'],$res['left'],2) >= 0 && bccomp($num,$res['left'],2) != 0){
			return '剩余量已不足最小起订量，购买量必须等于剩余量';
		}

		return true;
	}

	/**
	 * 获取商品剩余可购数量
	 * @param  int $product_id 商品id
	 * @return array 
	 */
	public function productNumLeft($product_id,$product = array()){
		$product = $product ? $product : $this->products->where(array('id'=>$product_id))->getObj();
		$quantity = floatval($product['quantity']); //商品总数量
		$sell = floatval($product['sell']); //商品已售数量
		$freeze = floatval($product['freeze']);//商品已冻结数量
		$product_left = $quantity-$sell-$freeze;//商品剩余数量
		return array('quantity'=>$quantity,'sell'=>$sell,'freeze'=>$freeze,'left'=>$product_left);
	}

	/**
	 * 买家支付定金后冻结相应数量的商品
	 * @param  array $offer_info 报盘信息数组
	 * @param  float $num  商品数目
	 * @return true:冻结成功 string:报错信息
	 */
	final public function productsFreeze($offer_info,$num){
		$num = floatval($num);
		if($offer_info && is_array($offer_info) && $num > 0){
			$product = $this->products->where(array('id'=>$offer_info['product_id']))->getObj();

			if($product){
				$product_valid = $this->productNumValid($num,$offer_info,$product);
				if($product_valid !== true)
					return $product_valid;
				$res = $this->products->where(array('id'=>$product['id']))->data(array('freeze'=>floatval($product['freeze'])+$num))->update();
				return is_int($res) && $res>0 ? true : ($this->products->getError() ? $this->products->getError() : '数据未修改');
			}
			return '无效产品';
		}
		return '无效报盘';
	}
	/**
	 * 合同作废 将冻结的商品数量恢复
	 * @param  array $offer_info 报盘信息数组
	 * @param  float $num  商品数目
	 * @return true:解冻成功 string:报错信息
	 */
	final protected function productsFreezeRelease($offer_info,$num){
		$num = floatval($num);
		if($offer_info && is_array($offer_info) && $num > 0){
			$product = $this->products->where(array('id'=>$offer_info['product_id']))->getObj();
			$freeze = floatval($product['freeze']);//已冻结商品数量
			if($freeze >= $num){
				$res = $this->products->where(array('id'=>$product['id']))->data(array('freeze'=>($freeze-$num)))->update();
				return is_int($res) && $res>0 ? true : ($this->products->getError() ? $this->products->getError() : '数据未修改');
			}else{
				return '冻结商品数量有误';
			}
		}else{
			return '无效报盘';
		}
	}

	/**
	 * 合同完成 将冻结的商品数量清理 转为已销售数量
	 * @param  array $offer_info 报盘信息数组
	 * @param  float $num  商品数目
	 * @return true:解冻成功 string:报错信息
	 */
	final protected function productsFreezeToSell($offer_info,$num){
		$num = floatval($num);
		if($offer_info && is_array($offer_info) && $num > 0){
			$product = $this->products->where(array('id'=>$offer_info['product_id']))->getObj();
			$freeze = floatval($product['freeze']);//已冻结商品数量
			$sell = floatval($product['sell']);//已冻结商品数量
			if($freeze >= $num){
				$res = $this->products->where(array('id'=>$product['id']))->data(array('freeze'=>($freeze-$num),'sell'=>($sell+$num)))->update();
				return is_int($res) && $res>0 ? true : ($this->products->getError() ? $this->products->getError() : '数据未修改');
			}else{
				return '冻结商品数量有误';
			}
		}else{
			return '无效报盘';
		}
	}

	/**
	 * 订单日志记录
	 * @param  int $order_id  订单id
	 * @param  int $user_id   操作用户id
	 * @param  int $user_type 操作用户身份 0:买家 1:卖家
	 * @param  string $remark 备注
	 * @return array $res     返回结果信息
	 */
	final protected function payLog($order_id,$user_id,$user_type,$remark){
		$res = $this->paylog->data(array('pay_type'=>$this->order_table,'order_id'=>intval($order_id),'user_id'=>intval($user_id),'user_type'=>$user_type,'remark'=>$remark,'create_time'=>date('Y-m-d H:i:s',time())))->add();
		$err = $this->paylog->getError();
		return  intval($res) > 0 ? true : (!empty($err) ? $err : '日志记录失败');
	}

	/**
	 * 买方确认货物质量
	 * @param  int $order_id 订单id
	 * @param  int $user_id 当前用户id
	 * @param  array $reduceData 扣减货款数据 默认为空
	 * @return array  $res   返回结果
	 */
	public function verifyQaulity($order_id,$user_id,$reduceData = array()){
		if($this->orderComplain($order_id)) return tool::getSuccInfo(0,'申述处理中');
		$order = $this->orderInfo($order_id);
		if($order && in_array($order['mode'],array(self::ORDER_DEPOSIT,self::ORDER_STORE,self::ORDER_PURCHASE))){
			if($order['contract_status'] == self::CONTRACT_DELIVERY_COMPLETE){
				$offerInfo = $this->offerInfo($order['offer_id']);
				$buyer = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $order['user_id'] : $offerInfo['user_id'];
				$seller = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $offerInfo['user_id'] : $order['user_id'];
				if($reduceData['reduce_amount'] >= $order['pay_deposit'])
					return tool::getSuccInfo(0,'扣减货款不能超过或等于定金数额'.$order['pay_deposit']);
				if($buyer != $user_id)
					return tool::getSuccInfo(0,'操作用户错误');
				$orderData['contract_status'] = self::CONTRACT_VERIFY_QAULITY;//状态置为买家已确认质量
				$orderData['id'] = $order_id;

				try {
					$this->order->beginTrans();
					if(!empty($reduceData)){
						$orderData = array_merge($orderData,$reduceData);
					}
					$res = $this->orderUpdate($orderData);
					//更新合同状态
					if($res['success'] == 1){
						$log_res = $this->payLog($order_id,$user_id,0,'买家确认提货质量'.($reduceData['reduce_amount'] ? "（扣减款项：{$reduceData['reduce_amount']})" : ''));
						if($log_res === true){
							$mess = new \nainai\message($seller);
							$jump_url = "<a href='".url::createUrl('/contract/sellerDetail?id='.$order_id.'@user')."'>跳转到合同详情页</a>";
							$content = '(合同'.$order['order_no'].',买方已进行质量确认,请您及时核实信息。)'.$jump_url;
							$mess->send('common',$content);
							$this->order->commit();
							return tool::getSuccInfo();
						}else{
							$error = $log_res;
						}
					}else{
						$error = $res['info'];
					}
				}catch(PDOException $e) {
					$this->order->rollBack();
					$error = $e->getMessage();
				}
			}else{
				$error = '合同状态有误';
			}
		}else{
			$error = '无效订单';
		}

		return tool::getSuccInfo(0,$error);
	}

	/**
	 * 卖家确认买家扣减货款信息
	 * @param  int $order_id 订单Id
	 * @param  int $user_id  当前用户
	 * @param  boolean $agree 是否同意
	 * @return array 结果数组
	 */
	public function sellerVerify($order_id,$user_id,$agree = true){
		if($this->orderComplain($order_id)) return tool::getSuccInfo(0,'申述处理中');
		$order = $this->orderInfo($order_id);
		if($order && in_array($order['mode'],array(self::ORDER_DEPOSIT,self::ORDER_STORE,self::ORDER_PURCHASE))){
			if($order['contract_status'] == self::CONTRACT_VERIFY_QAULITY || $order['contract_status'] == self::CONTRACT_DELIVERY_COMPLETE){
				$orderData['id'] = $order_id;
				if($agree === false && floatval($order['reduce_amount'])){
					//卖家不同意扣减
					$orderData['contract_status'] = self::CONTRACT_DELIVERY_COMPLETE;
					$orderData['reduce_amount'] = NULL;
					$orderData['reduce_remark'] = NULL;
					return $this->orderUpdate($orderData);
				}
				$offerInfo = $this->offerInfo($order['offer_id']);
				$buyer  = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $order['user_id'] : $offerInfo['user_id'];
				$seller = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $offerInfo['user_id'] : $order['user_id'];
				if($seller != $user_id)
					return tool::getSuccInfo(0,'操作用户错误');
				
				$orderData['contract_status'] = self::CONTRACT_SELLER_VERIFY;//状态置为卖家已确认质量
				

				try {
					$this->order->beginTrans();
					$res = $this->orderUpdate($orderData);
					if($res['success'] == 1){
						//将订单款 减去扣减款项 后的60%支付给卖方
						$reduce_amount = floatval($order['reduce_amount']); 
						$amount = $order['proof'] ? $order['pay_deposit'] - $reduce_amount: ($order['amount'] - $reduce_amount);
						$amount = floatval($amount*0.6) ;

						$res = $this->payLog($order_id,$user_id,0,'卖家确认提货质量'.($reduce_amount ? "（扣减款项：$reduce_amount)" : ''));
						
						if($res === true){
							$account_deposit = $this->base_account->get_account($order['buyer_deposit_payment']);
							$account_retainage = $this->base_account->get_account($order['retainage_payment']);
							$cond =  $order['pay_retainage'] ? is_object($account_deposit) && is_object($account_retainage) : is_object($account_deposit);

							if($cond){
								$deposit_intro = $order['pay_deposit'] == $order['amount'] ? '货款' : '定金';
								$note = '卖方确认质量合格'.$order['order_no'].'解冻支付'.$deposit_intro.'的60% '.number_format(($order['pay_deposit']-$order['reduce_amount'])*0.6,2).($reduce_amount ? '(扣减货款'.$reduce_amount.')' : '');

								$deposit_res = $account_deposit->freezePay($buyer,$seller,($order['pay_deposit']-$order['reduce_amount'])*0.6,$note,$order['pay_deposit']);

								if($deposit_res !== true) {
									$error = $deposit_res;
								}else{
									$note = '卖方确认质量合格'.$order['order_no'].'解冻支付尾款的60% '.number_format($order['pay_retainage']*0.6,2);	
									$retainage_res = $order['pay_retainage'] ? $account_retainage->freezePay($buyer,$seller,$order['pay_retainage']*0.6,$note,$order['pay_retainage']) : true;
									$error = $retainage_res === true ? '' : $retainage_res;

									$mess_seller = new \nainai\message($seller);
									$content = '(合同'.$order['order_no'].',买方已进行质量确认,您将收到该合同60%的货款。请您关注资金动态)';
									$mess_seller->send('common',$content);

									$mess_buyer = new \nainai\message($buyer);
									$jump_url = "<a href='".url::createUrl('/contract/buyerDetail?id='.$order_id.'@user')."'>跳转到合同详情页</a>";
									$content = '(合同'.$order['order_no'].',卖方已进行质量确认,该合同的60%货款将支付给卖方。请您及时关注资金动态，并进行合同确认)'.$jump_url;
									$mess_buyer->send('common',$content);
								}
							}else{
								$error = '无效支付方式';
							}

							if(!$error){
								$this->order->commit();
								return tool::getSuccInfo();
							}
						}else{
							$error = $log_res;
						}
					}else{
						$error = $res['info'];
					}
				}catch(PDOException $e) {
					$this->order->rollBack();
					$error = $e->getMessage();
				}
			}else{
				$error = '合同状态有误';
			}
		}else{
			$error = '无效订单';
		}

		return tool::getSuccInfo(0,$error);
	}

	/**
	 * 买方确认合同完成
	 * @param  int $order_id 订单id
	 * @param  int $user_id 当前用户
	 * @return array  $res   返回结果信息
	 */
	public function contractComplete($order_id,$user_id){
		if($this->orderComplain($order_id)) return tool::getSuccInfo(0,'申述处理中');
		$order = $this->orderInfo($order_id);
		if($order && in_array($order['mode'],array(self::ORDER_DEPOSIT,self::ORDER_STORE,self::ORDER_PURCHASE))){
			if($order['contract_status'] == self::CONTRACT_SELLER_VERIFY){
				$offerInfo = $this->offerInfo($order['offer_id']);
				$buyer  = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $order['user_id'] : $offerInfo['user_id'];
				$seller = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $offerInfo['user_id'] : $order['user_id'];
				if($buyer != $user_id)
					return tool::getSuccInfo(0,'操作用户错误');

				$orderData['contract_status'] = self::CONTRACT_COMPLETE;
				$orderData['end_time'] = date('Y-m-d H:i:s',time());
				$orderData['id'] = $order_id;

				try {	
					$this->order->beginTrans();
					$res = $this->orderUpdate($orderData);
					if($res['success'] == 1){
						//支付剩余货款 减去扣减款项 后的40%
						$reduce_amount = floatval($order['reduce_amount']);

						$amount = $order['proof'] ? ($order['pay_deposit'] - $reduce_amount) : ($order['amount'] - $reduce_amount);
						$amount = floatval($amount*0.4) ;

						//若$reduce_amount 大于0 则将此扣减项返还买方账户
						$reduce_amount = floatval($order['reduce_amount']); 
						
						$res = $this->payLog($order_id,$user_id,0,'买家确认合同,合同结束'.($reduce_amount > 0 ? "(返还扣减项:$reduce_amount)" : ''));
						//商品表中冻结商品解冻 添加到已销售
						$this->productsFreezeToSell($offerInfo,$order['num']);

						$account_deposit = $this->base_account->get_account($order['buyer_deposit_payment']);
						$account_retainage = $this->base_account->get_account($order['retainage_payment']);
						$account_seller_deposit = $this->base_account->get_account($order['seller_deposit_payment']);
						$cond =  $order['pay_retainage'] ? is_object($account_deposit) && is_object($account_retainage): is_object($account_deposit);
						$cond = $order['seller_deposit'] ? $cond && is_object($account_seller_deposit) : $cond;
						if($cond){
							$note = '买方确认合同完成'.$order['order_no'].'解冻卖方保证金 '.$order['seller_deposit'];
							$r1 = $order['seller_deposit'] ? $account_seller_deposit->freezeRelease($seller,$order['seller_deposit'],$note) : true;
							
							if($r1 === true){
								$deposit_intro = $order['pay_deposit'] == $order['amount'] ? '货款' : '定金';
								$note = '买方确认合同完成'.$order['order_no'].'解冻支付'.$deposit_intro.'的40% '.number_format(($order['pay_deposit']-$reduce_amount)*0.4,2).($reduce_amount ? '(扣减货款'.$reduce_amount.')' : '');
								$r2 = $account_deposit->freezePay($buyer,$seller,($order['pay_deposit']-$reduce_amount)*0.4,$note,0.4*$order['pay_deposit']+0.6*$reduce_amount);
								
								if($r2 !== true){
									$error = $r2;
								}else{
									$note = '买方确认合同完成'.$order['order_no'].'解冻支付尾款的40% '.number_format($order['pay_retainage']*0.4,2);
									$r3 = $order['pay_retainage'] ? $account_retainage->freezePay($buyer,$seller,$order['pay_retainage']*0.4,$note) : true;	
									if($r3 !== true){
										$error = $r3;
									}else{
										$note = '买方确认合同完成'.$order['order_no'].'解冻扣减货款 '.$reduce_amount;
										$r4 = $reduce_amount > 0 ? $account_deposit->freezeRelease($buyer,$reduce_amount,$note) : true;			
										$error = $r4 === true ? '' : $r4;

										$mess_seller = new \nainai\message($seller);
										$content = '(合同'.$order['order_no'].',买方已确认合同,您将收到该合同剩余的货款。请您关注资金动态)';
										$mess_seller->send('common',$content);

										$mess_buyer = new \nainai\message($buyer);
										$content = '(合同'.$order['order_no'].'已完成.该合同剩余的货款将支付给卖方。请您及时关注资金动态)';
										$mess_buyer->send('common',$content);

										//信誉值增加
										$configs_credit = new \nainai\CreditConfig();
										$a = $configs_credit->changeUserCredit($seller,'cert_contract',$order['amount']);
										$configs_credit = new \nainai\CreditConfig();
										$b = $configs_credit->changeUserCredit($buyer,'cert_contract',$order['amount']);
										

									}
								}
							}else{
								$error = $r1;
							}
						}else{
							$error = '无效支付方式';
						}
						
						if(!$error){
							$this->order->commit();
							return tool::getSuccInfo();
						}
						
					}else{
						$error = $res['info'];
					}
				} catch (PDOException $e) {
					$error = $e->getMessage();
					$this->order->rollBack();
				}
			}else{
				$error = '合同状态有误';
			}
		}else{
			$error = '无效订单';
		}
		
		return tool::getSuccInfo(0,$error);
	}

	/**
	 * 获取所有合同列表
	 * @param  int $page 分页
	 */
	public function memberContractList($page,$where=''){
		$query = new \Library\searchQuery('order_sell as do');
		$query->join  = 'left join product_offer as po on do.offer_id = po.id left join user as u on u.id = do.user_id left join user as u2 on po.user_id = u2.id left join products as p on po.product_id = p.id left join company_info as ci on do.user_id = ci.user_id left join product_category as pc on p.cate_id = pc.id left join store_products as sp on sp.product_id = p.id left join store_list as sl on sp.store_id = sl.id left join person_info as pi on pi.user_id = do.user_id';
		if($where)$query->where = $where;
		$query->fields = 'po.type,u2.username as po_username,po.mode,u.username as do_username,do.*,p.name as product_name,p.img,p.unit,ci.company_name,pc.percent,sl.name as store_name,pi.true_name';
		// $query->bind  = array_merge($bind,array('user_id'=>$user_id));

		 $query->order = "do.id desc";
		$data = $query->find();
		$this->adminContractStatus($data['list']);
		$product = new \nainai\offer\product();
		foreach ($data['list'] as $key => &$value) {
			$value['type_txt'] = $product->getMode($value['type']);
			$value['mode_txt'] = $product->gettype($value['mode']);
			$value['account'] = number_format(floatval($value['amount']) - floatval($value['reduce_amount']),2);
			$value['amount'] = number_format(floatval($value['amount']),2);
			$value['num'] = number_format(floatval($value['num']),2);
			$value['buyer_name'] = $value['mode'] == \nainai\offer\product::TYPE_SELL ? $value['do_username'] : $value['po_username'];

			$value['seller_name'] = $value['mode'] == \nainai\offer\product::TYPE_SELL  ? $value['po_username'] : $value['do_username'];

		}
		$query->downExcel($data['list'], 'order_sell', '合同列表');
		// tool::pre_dump($data['list'][0]);exit;
		// tool::pre_dump($data);
		return $data;
	}

	/**
	 * 获取用户所有销售合同信息(含商品信息与买家信息)
	 * @param  int $user_id 卖家id
	 */
	public function sellerContractList($user_id,$page){
		$query = new \Library\searchQuery('order_sell as do');
		$query->join  = 'left join product_offer as po on do.offer_id = po.id
						left join user as u on u.id = do.user_id
						left join products as p on po.product_id = p.id
						left join company_info as ci1 on do.user_id = ci1.user_id
						left join company_info as ci2 on po.user_id = ci2.user_id
						left join product_category as pc on p.cate_id = pc.id
						left join store_products as sp on sp.product_id = p.id
						left join store_list as sl on sp.store_id = sl.id
						left join person_info as pi on pi.user_id = do.user_id';
		$query->where = '((po.user_id = :user_id and po.type = '.\nainai\offer\product::TYPE_SELL.') or (do.user_id = :seller_id and po.type = '.\nainai\offer\product::TYPE_BUY.'))';
		$query->fields = 'u.username,do.*,p.name as product_name,po.type,p.img,p.unit,ci1.company_name as do_company_name,ci2.company_name as po_company_name,pc.percent,sl.name as store_name,pi.true_name';
		// $query->bind  = array_merge($bind,array('user_id'=>$user_id));
		$query->bind  = array('user_id'=>$user_id,'seller_id'=>$user_id);
		$query->page  = $page;
		$query->pagesize = 5;
		 $query->order = "do.id desc";
		$data = $query->find();

		foreach ($data['list'] as $key => &$value) {
			$value['company_name'] = $value['type'] == \nainai\offer\product::TYPE_BUY ? $value['po_company_name'] : $value['do_company_name'];
		}
		$this->sellerContractStatus($data['list']);
		// tool::pre_dump($data);
		return $data;
	}

	// /**
	//  * 合同详情
	//  * @param  int $id 订单id
	//  * @param  boolean $is_seller 默认为购买合同
	//  * @return array   结果数组
	//  */
	// public function contractDetail($id,$is_seller = false){
	// 	$query = new Query('order_sell as do');
	// 	$query->join  = 'left join product_offer as po on do.offer_id = po.id left join user as u on u.id = do.user_id left join products as p on po.product_id = p.id';
	// 	$query->fields = 'do.*,p.name,po.price,do.amount,p.unit';
	// 	$query->where = 'do.id=:id';
	// 	$query->bind = array('id'=>$id);
	// 	$res = array($query->getObj());
	// 	// var_dump($res);
	// 	$this->sellerContractStatus($res);
	// 	return $res[0];
	// }

	/**
	 * 用户购买合同列表
	 * @param  int $user_id 当前登录用户Id
	 * @param  int $page    当前页
	 * @param  array  $where  条件数组
	 * @return array          列表数组
	 */
	public function buyerContractList($user_id,$page){
		$query = new \Library\searchQuery('order_sell as do');
		$query->join  = 'left join product_offer as po on do.offer_id = po.id left join user as u on u.id = do.user_id left join products as p on po.product_id = p.id left join company_info as ci1 on do.user_id = ci1.user_id left join company_info as ci2 on po.user_id = ci2.user_id left join product_category as pc on p.cate_id = pc.id left join store_products as sp on sp.product_id = p.id left join store_list as sl on sp.store_id = sl.id left join person_info as pi on pi.user_id = do.user_id';
		$query->where = '((do.user_id = :user_id and po.type = '.\nainai\offer\product::TYPE_SELL.') or (po.user_id = :buyer_id and po.type = '.\nainai\offer\product::TYPE_BUY.'))';
		$query->fields = 'po.type,u.username,do.*,p.name as product_name,p.img,p.unit,ci1.company_name as do_company_name,ci2.company_name as po_company_name,pc.percent,sl.name as store_name,pi.true_name';
		// $query->bind  = array_merge($bind,array('user_id'=>$user_id));
		$query->bind  = array('user_id'=>$user_id,'buyer_id'=>$user_id);
		$query->page  = $page;
		$query->pagesize = 5;
		 $query->order = "do.id desc ";
		$data = $query->find();

		foreach ($data['list'] as $key => &$value) {
			$value['company_name'] = $value['type'] == \nainai\offer\product::TYPE_BUY ? $value['do_company_name'] : $value['po_company_name'];
		}

		$this->buyerContractStatus($data['list']);
		return $data;

	}

	/**
	 * 合同预览
	 * @param  int $offer_id 报盘id
	 * @param  float $num  商品数量
	 * @return array  信息数组
	 */
	public function contractReview($offer_id,$num,$user_id = ''){
		$query = new Query('product_offer as po');
		$query->join = 'left join products as p on po.product_id = p.id';
		$query->fields = 'po.type,po.user_id as offer_user,po.price,p.name,po.product_id,po.accept_area,po.other,p.cate_id,p.produce_area,p.unit';
		$query->where = 'po.id = :id';
		$query->bind = array('id'=>$offer_id);
		$res = $query->getObj();	

		$res['num'] = $num;
		$res['amount'] = $res['price']*$num;
		$user = $this->contractUserInfo($user_id);
		$offer_user = $this->contractUserInfo($res['offer_user']);
		if($res['type'] == \nainai\offer\product::TYPE_BUY){
			$res['userinfo'] = $user;
			$res['buyer_name'] = $offer_user['type'] == 0 ? $offer_user['true_name'] : $offer_user['company_name'];
			$res['seller_name'] = $user['type'] == 0 ? $user['true_name'] : $user['company_name'];
		}else{
			$res['userinfo'] = $offer_user;
			$res['buyer_name'] = $user['type'] == 0 ? $user['true_name'] : $user['company_name'];
			$res['seller_name'] = $offer_user['type'] == 0 ? $offer_user['true_name'] : $offer_user['company_name'];
		}
		return $res;
	}

	/**
	 * 合同详情
	 * @param  int $id 订单id
	 * @param  string $identity buyer为购买合同 seller 为销售
	 * @return array   结果数组
	 */
	public function contractDetail($id,$identity = 'buyer'){
		$query = new Query('order_sell as do');
		$query->join  = 'left join product_offer as po on do.offer_id = po.id left join user as u on u.id = do.user_id left join products as p on po.product_id = p.id left join product_category as pc on p.cate_id = pc.id';
		$query->fields = 'do.*,po.type,po.other,p.name,po.price,do.amount,p.unit,po.product_id,po.accept_area,p.cate_id,p.img,p.produce_area,pc.name as cate_name,po.user_id as seller_id';
		$query->where = 'do.id=:id';
		$query->bind = array('id'=>$id);
		$res = $query->getObj();
		if(empty($res)){
			return array();
		}

		$res['img_thumb'] = \Library\thumb::get($res['img'],50,50);

		if($res['mode'] == self::ORDER_STORE){
			$query = new Query('store_list as s');
			$query->join = 'left join store_products as sp on s.id = sp.store_id';
			$query->where = 'sp.product_id = :product_id';
			$query->bind = array('product_id'=>$res['product_id']);
			$query->fields = 's.name as store_name,s.area,s.address';
			$data = $query->getObj();
			$res['store_name'] = $data['store_name'];
			$res['store_area'] = $data['area'];
			$res['store_address'] = $data['address'];
		}else{
			$res['store_name'] = '-';
		}

		$buyer_id = $res['type'] == \nainai\offer\product::TYPE_SELL ? $res['user_id'] : $res['seller_id'];
		$seller_id = $res['type'] == \nainai\offer\product::TYPE_SELL ? $res['seller_id'] : $res['user_id'];

		$buyer_info = $this->contractUserInfo($buyer_id);
		$seller_info = $this->contractUserInfo($seller_id);
		$res['buyer_name'] = $buyer_info['type'] == 0 ? $buyer_info['true_name'] : $buyer_info['company_name'];
		$res['seller_name'] = $seller_info['type'] == 0 ? $seller_info['true_name'] : $seller_info['company_name'];
		$res['buyer_phone'] = $buyer_info['type'] == 0 ? $buyer_info['mobile'] : $buyer_info['contact_phone'];
		
		$res = array($res);

		
		if($identity == 'seller'){
			$this->sellerContractStatus($res);
			$res[0]['userinfo'] = $buyer_info;
			
		}elseif($identity == 'buyer'){
			$this->buyerContractStatus($res);
			$res[0]['userinfo'] = $seller_info;
		}
		
		
		$res[0]['pay_log'] = $this->paylog->where(array('order_id'=>$id))->fields('remark,create_time')->order('create_time asc')->select();
		$res[0]['delivery_status'] = $this->deliveryStatus($id);
		return $res[0];
	}

	/**
	 * 获取某一订单当前提货配送状态
	 * @param  int $order_id 订单id
	 * @return string  状态文字
	 */
	public function deliveryStatus($order_id){
		$delivery = new \nainai\delivery\Delivery();
		$query = new Query('order_sell as o');
		$query->join = 'left join product_delivery as pd on o.id = pd.order_id';
		$query->where = 'o.id = :id';
		$query->bind = array('id'=>$order_id);
		$query->fields = 'pd.status,o.mode';
		$res = $query->find();

		$status_txt = in_array($res[0]['mode'],array(self::ORDER_FREE,self::ORDER_ENTRUST)) ? '线下交收' : '未提货';
		foreach ($res as $key => $value) {
			switch ($value['status']) {
				case $delivery::DELIVERY_AGAIN:
					$status_txt = '提货中';
					break;
				case $delivery::DELIVERY_COMPLETE:
					$status_txt = '提货完成';
					break;
				default:
					break;
			}

			if($status_txt == '提货完成') break;
		}

		return $status_txt;
	}

	/**
	 * 获取订单对应的发票信息
	 * @param  array $orderInfo 订单信息数组
	 * @return array 发票信息数组
	 */
	public function orderInvoiceInfo($orderInfo){
		if($orderInfo['invoice'] == 1){
			$offerInfo = $this->offerInfo($orderInfo['offer_id']);
			$buyer = $offerInfo['type'] == \nainai\offer\product::TYPE_SELL ? $orderInfo['user_id'] : $offerInfo['user_id']  ;
			$invoice_info = $this->user_invoice->userInvoiceInfo($buyer);
			$invoice_info['order_invoice'] = $this->user_invoice->orderInvoiceInfo($orderInfo['id']);
			return $invoice_info;
		}else{
			return array();
		}
	}

	/**
     * 根据订单id获取对应委托金比例
     * @param  int $order_id 订单id
     * @return float 
     */
    public function entrustFee($order_id){
     	$query = new Query('order_sell as o');
     	$query->join = 'left join product_offer as po on o.offer_id = po.id left join products as p on p.id = po.product_id left join entrust_setting as e on e.cate_id = p.cate_id';
     	$query->fields = 'e.type,e.value';
     	$query->where = 'e.status=1 and o.id=:id';
     	$query->bind = array('id'=>$order_id);
     	$res = $query->getObj();
     	return $res ? $res : array();
    }

	/**
	 * 获取销售合同状态
	 * @param  array &$data 销售合同订单数组
	 */
	private function sellerContractStatus(&$data){
		foreach ($data as $key => &$value) {
			//根据合同状态得出对应操作
			$contract_status = $value['contract_status'];
			$href = '';
			$confirm = 0;
			switch ($contract_status) {
				case self::CONTRACT_NOTFORM:
					$title = '等待买方付款';
					break;	
				case self::CONTRACT_SELLER_DEPOSIT:
					$title = in_array($value['mode'],array(self::ORDER_DEPOSIT,self::ORDER_PURCHASE)) ? '支付保证金' : '支付委托金';
					$href  = in_array($value['mode'],array(self::ORDER_DEPOSIT,self::ORDER_PURCHASE)) ? url::createUrl('/Deposit/sellerDeposit?order_id='.$value['id']) : url::createUrl('/Deposit/sellerEntrustDeposit?order_id='.$value['id']);
					break;
				case self::CONTRACT_CANCEL:
					$title = '合同已作废';
					break;
				case self::CONTRACT_EFFECT:
					$title = '合同生效,提货流程中';
					$href = url::createUrl("/delivery/deliselllist");
					$action []= array('action'=>$title,'url'=>$href);
					break;
				case self::CONTRACT_BUYER_RETAINAGE:
					if(empty($value['proof'])){
						$title = $value['mode'] == self::ORDER_FREE ? '等待支付全款' : '等待支付尾款';
					}else{
						$title = '确认线下凭证';
						$href  = url::createUrl('/Order/confirmProofPage?order_id='.$value['id']);
					}
					break;
				case self::CONTRACT_DELIVERY_COMPLETE:
					$title = '提货已完成';
					$delivery_time = $this->delivery->deliveryCompleteTime($value['id']);
					$_after_time = time::_after_time($delivery_time,30);
					if($_after_time === true){
						$title = '强制质量合格';
						$href = url::createUrl("/Order/sellerVerify?order_id={$value['id']}");
						// $action []= array('action'=>'质量合格','confirm' => 1,'url'=>url::createUrl("/Order/cancelContract?order_id={$value['id']}"));
						$confirm = 1;
					}

					break;
				case self::CONTRACT_VERIFY_QAULITY:
					if(empty($value['reduce_amount'])) {
						$title = '质量合格';
						$href = url::createUrl("/Order/sellerVerifyPage?order_id={$value['id']}");
					}else{
						$title = '确认质量';
						$href = url::createUrl("/Order/sellerVerify?order_id={$value['id']}&reduce=1");
					}
					break;
				case self::CONTRACT_SELLER_VERIFY:
					$title = '等待买方确认合同';
					break;
				case self::CONTRACT_COMPLETE:
					$title = '合同已完成';
					break;
				default:
					$title = '无效状态';
					break;
			}

			$value['action'] = $title;
			$value['action_href'] = $href;
			$value['confirm'] = $confirm;
		}
	}

	/**
	 * 获取购买合同状态
	 * @param  array &$data 购买合同订单数组
	 */
	private function buyerContractStatus(&$data){
		foreach ($data as $key => &$value) {
			$action = array();
			//根据合同状态得出对应操作
			$contract_status = $value['contract_status'];
			$href = '';
			switch ($contract_status) {
				case self::CONTRACT_NOTFORM:
					$title = '未支付定金';
					break;
				case self::CONTRACT_SELLER_DEPOSIT:   
					$title = in_array($value['mode'],array(self::ORDER_DEPOSIT,self::ORDER_PURCHASE)) ? '等待卖家支付保证金' : '等待卖家支付委托金';
					$action []= array('action'=>$title);
					$_after_time = time::_after_time($value['pay_deposit_time'],3600);
					if($_after_time === true){
						$action []= array('action'=>'取消合同','confirm' => 1,'url'=>url::createUrl("/Order/cancelContract?order_id={$value['id']}"));
					}

					// else{
					// 	$action []= array('action'=>$_after_time.'可以取消合同');
					// }
					break;
				case self::CONTRACT_BUYER_RETAINAGE:
					if(empty($value['proof'])){
						$title = $value['mode'] == self::ORDER_FREE ? '支付全款' : '支付尾款';
						$href = url::createUrl("/Order/buyerRetainage?order_id={$value['id']}");
						$action []= array('action'=>$title,'url'=>$href);
					}else{
						$title = '等待确认线下支付凭证';
					}
					break;
				case self::CONTRACT_CANCEL:
					$title = '合同已被取消';
					break;
				case self::CONTRACT_EFFECT:
					//判断是否可以提货
					$delivery = new \nainai\delivery\Delivery;
					$left = $delivery->orderNumLeft($value['id']);
					if(is_float($left) && $left > 0.2){
						$title = '提货';
						$href = url::createUrl("/delivery/newDelivery?order_id={$value['id']}");
						$action []= array('action'=>$title,'url'=>$href);
					}else{
						$title = '提货列表';
						$href = url::createUrl("/delivery/deliBuyList");
						$action []= array('action'=>$title,'url'=>$href);
					}
					break;
				case self::CONTRACT_COMPLETE:
					$title = '合同已完成';
					break;
				case self::CONTRACT_DELIVERY_COMPLETE:
					$title = '确认提货质量';
					$action []= array('action'=>'质量合格','url'=>url::createUrl("/Order/verifyQaulity?order_id={$value['id']}"),'confirm'=>1);
					$action []= array('action'=>'扣减货款','url'=>url::createUrl("/Order/verifyQaulityPage?order_id={$value['id']}"));
					break;
				case self::CONTRACT_VERIFY_QAULITY:
					$title = $value['reduce_amount'] ? '扣减货款' : '质量合格';
					break;
				case self::CONTRACT_SELLER_VERIFY:
					$title = '确认合同结束';
					$href = url::createUrl("/Order/contractComplete?order_id={$value['id']}");
					$action []= array('action'=>$title,'url'=>$href,'confirm'=>1);
					break;
				default:
					$title = '未知状态';
					break;
			}
			$value['title'] = $title;
			$value['action'] = $action;
			$value['action_href'] = $href;
		}
	}

	/**
	 * 获取管理员合同状态
	 * @param  array &$data 购买合同订单数组
	 */
	public function adminContractStatus(&$data){
		foreach($data as $key => &$value) {
			$contract_status = $value['contract_status'];
			switch ($contract_status) {
				case self::CONTRACT_NOTFORM:
					$title = '买方未支付定金';
					break;
				case self::CONTRACT_SELLER_DEPOSIT:
					$title = '等待卖方支付保证金';
					break;
				case self::CONTRACT_BUYER_RETAINAGE:
					$title = '等待买方支付尾款';
					break;
				case self::CONTRACT_CANCEL:
					$title = '合同已被取消';
					break;
				case self::CONTRACT_EFFECT:
					$title = '合同已生效';
					break;
				case self::CONTRACT_DELIVERY_COMPLETE:
					$title = '提货完成,待买方确认质量';
					break;
				case self::CONTRACT_VERIFY_QAULITY:
					$title = '等待卖方确认质量';
					break;
				case self::CONTRACT_SELLER_VERIFY:
					$title = '等待买方确认合同';
					break;
				case self::CONTRACT_COMPLETE:
					$title = '合同已完成';
					break;
				default:
					$title = '未知状态';
					break;
			}
			$value['title'] = $title;
		}
	}

	/**
	 * 获取用户详细信息
	 * @param  int $user_id 用户id
	 * @param  int $is_seller 0为买家 1为卖家 
	 * @return array    信息数组
	 */
	public function contractUserInfo($user_id,$is_seller = 0){
		$mem = new \nainai\member();
		return $mem->getUserDetail($user_id);
	}

	/**
	 * 获取用户开户行信息
	 * @param  int $user_id 用户id
	 * @return array     信息数组
	 */
	public function userBankInfo($user_id){
		$bank = new \nainai\user\UserBank();
		return $bank->getActiveBankInfo($user_id);
	}

	/**
	 * 判断一个合同是否可申诉
	 * @param $data 数组 包含mode和contract_status两个字段
	 */
	public function canComplain($data){
		if(isset($data['mode']) && isset($data['contract_status'])){
			if(in_array($data['mode'],array(self::ORDER_DEPOSIT,self::ORDER_STORE,self::ORDER_PURCHASE))){
				if($data['contract_status']!=0 && $data['contract_status']!=8)
					return 1;
			}

		}
		return 0;
	}

	/**
	 * 获取最新完成的交易合同(首页数据）
	 * @param $num
	 */
	public function getNewComplateTrade($num){
		$memcache=new Memcache();
		$res=$memcache->get('newComplateTrade');
		if($res){
			return unserialize($res);
		}
		$Q = new Query($this->order_table .' as o');
		$Q->join = ' left join '.$this->offer_table.' as of on o.offer_id=of.id
					 left join '.'products'.' as p on of.product_id = p.id
					 left join user as u on u.id = of.user_id';
		$Q->fields = 'u.username,of.type,p.name,p.unit,o.num,o.create_time';
		$Q->where = 'o.contract_status='.self::CONTRACT_COMPLETE;
		$Q->order=' o.create_time desc';
		$Q->limit = $num;
		$Q->cache = 'm';
		$data = $Q->find();
		$memcache->set('newComplateTrade',serialize($data));
		return $data;


	}

	/**
	 * 获取规定之间内的成交量
	 * @param  String $date 选择获取的时间，now，yesterday
	 * @return Array.num       成交量
	 */
	public function getOrderTotal($date='all'){
		$memcache=new Memcache();
		$orderTotal=$memcache->get('orderTotal'.$date);
		if($orderTotal){
			return unserialize($orderTotal);
		}
		$model = new M('order_sell');
		$where = ' contract_status IN (' .implode(',', array(self::CONTRACT_EFFECT, self::CONTRACT_DELIVERY_COMPLETE, self::CONTRACT_VERIFY_QAULITY, self::CONTRACT_SELLER_VERIFY, self::CONTRACT_COMPLETE)). ')';
		$bind = array();

		switch ($date) {
			case 'today':
				$where .= ' AND create_time>=:date';
				$bind['date'] = \Library\Time::getDateTime('Y-m-d') . ' 00:00:00';
				break;
			case 'yesterday':
				$where .= ' AND create_time BETWEEN :starDate AND :endDate';
				$date = \Library\Time::getDateTime('Y-m-d', strtotime('-1 Days'));
				$bind['starDate'] = $date . ' 00:00:00';
				$bind['endDate'] = $date . ' 23:59:59';
				break;
			case 'all' :
			default:
				break;
		}

		$orderTotal=$model->fields('count(id) as num')->where($where)->bind($bind)->getObj();
		$memcache->set('orderTotal'.$date,serialize($orderTotal));
		return $orderTotal;
	}


}