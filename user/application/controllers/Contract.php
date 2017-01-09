<?php
/**
 * 卖方合同管理
 * @author: panduo 
 * @Date: 2016-04-28 10:20:57
 */
use \Library\json;
use \Library\url;
use \Library\Safe;
use \Library\Thumb;
use \Library\tool;
use \Library\PlUpload;

class ContractController extends UcenterBaseController{



	public function sellerListAction(){
		$user_id = $this->user_id;
		$order = new \nainai\order\Order();
		$page = safe::filterGet('page','int',1);

		$list = $order->sellerContractList($user_id,$page);
		$this->getView()->assign('data',$list);
	}


	public function storeListAction(){
		$user_id = $this->user_id;
		$store = new \nainai\order\StoreOrder();
		// $page = $this->_request->getParam('page');
		$page = safe::filterGet('page','int',1);
		$name = safe::filterPost('name');
		$where = array();
		if(!empty($name)){
			$where []= array(" and p.name = :name ",array('name'=>$name));
		}
		$list = $store->storeContractList($user_id,$page,$where);
		$this->getView()->assign('data',$list['data']);
		$this->getView()->assign('page',$list['bar']);
	}


	public function sellerDetailAction(){
		$id = safe::filter($this->_request->getParam('id'),'int');
		$order = new \nainai\order\Order();
		$info = $order->contractDetail($id,'seller');
		// tool::pre_dump($info);
		$invoice = $order->orderInvoiceInfo($info);
		$info['complain'] = $order->canComplain($info);
		//判断是否可以购买保险
		if ($info['contract_status'] == $order::CONTRACT_EFFECT && !empty($info['risk'])) {
			$info['insurance'] = 1;
		}
		
		$this->getView()->assign('show_delivery',in_array($info['mode'],array(\nainai\order\Order::ORDER_DEPOSIT,\nainai\order\Order::ORDER_STORE,\nainai\order\Order::ORDER_PURCHASE)) ? true : false);
		$this->getView()->assign('info',$info);
		$this->getView()->assign('invoice',$invoice);
	}

	//购买合同列表
	public function buyerListAction(){
		$user_id = $this->user_id;
		$order = new \nainai\order\Order();
		$page = safe::filterGet('page','int',1);

		$list = $order->buyerContractList($user_id,$page);
		$this->getView()->assign('data',$list);
	}

	//购买合同详情
	public function buyerDetailAction(){
		$id = safe::filter($this->_request->getParam('id'),'int');
		$order = new \nainai\order\Order();
		$info = $order->contractDetail($id);
		$info['complain'] = $order->canComplain($info);

		
		$invoice = $order->orderInvoiceInfo($info);
		$this->getView()->assign('invoice',$invoice);
		$this->getView()->assign('show_delivery',in_array($info['mode'],array(\nainai\order\Order::ORDER_DEPOSIT,\nainai\order\Order::ORDER_STORE,\nainai\order\Order::ORDER_PURCHASE)) ? true : false);

		$this->getView()->assign('info',$info);
	}
	//开具订单发票
	public function geneOrderInvoiceAction(){
		$user_invoice = new \nainai\user\UserInvoice();

		$invoiceData['order_id'] = safe::filterPost('order_id','int');
		$invoiceData['post_company'] = safe::filterPost('post_company');
		$invoiceData['post_no'] = safe::filterPost('post_no');
		$invoiceData['image'] = tool::setImgApp(safe::filterPost('imgimage'));
		$invoiceData['create_time'] = date('Y-m-d H:i:s',time());
		$res = $user_invoice->geneInvoice($invoiceData);
		die(JSON::encode($res === true ? tool::getSuccInfo() : tool::getSuccInfo(0,'开具发票失败')));
		return false;
	}

	//合同详情
	public function contractAction(){
		$this->getView()->setLayout('');
		$order = new \nainai\order\Order();
		$product = new \nainai\offer\product();
		$order_id = safe::filter($this->_request->getParam('order_id'));
		
		if($order_id){
			$order_info = $order->contractDetail($order_id);			
		}else{
			$offer_id = safe::filter($this->_request->getParam('offer_id'));
			$num = safe::filter($this->_request->getParam('num'));
			$order_info = $order->contractReview($offer_id,$num,$this->user_id);
		}
		$product_cate = array_reverse($product->getParents($order_info['cate_id']));
		foreach ($product_cate as $key => $value) {
			$tmp .= $value['name'].'/';
		}
		$aa = $product->getProductDetails($order_info['product_id']);
		$order_info['attrs'] = $aa['attrs'];
		$order_info['product_cate'] = rtrim($tmp,'/');
		
		// echo '<pre>';var_dump($order_info);exit;
		
		$this->getView()->assign('info',$order_info);
	}

	/**
	 * 申述合同
	 */
	public function complainContractAction(){
		$complainModel = new \nainai\order\OrderComplain();

		$this->backUrl = url::createUrl('/Contract/complainList');
		$this->goUrl = url::createUrl('/Contract/complainContract');

		if (IS_POST) {
			$order_id = Safe::filterPost('orderId', 'int');

			$ContractData = $complainModel->getContract($order_id, 2);
			if (empty($ContractData)) {//没有这合同直接跳转
				die(json::encode(tool::getSuccInfo(0,'无效的合同')));
			}

			$img = Safe::filterPost('imgData');
			if(!empty($img)){
				foreach($img as $k=>$v){
					$img[$k] = tool::setImgApp($v);
				}
			}
			$type = Safe::filterPost('type');
			$user_id = Safe::filterPost('user_id','int');
			$offer_user = Safe::filterPost('offer_user','int');
			$buyer_id = $type == \nainai\offer\product::TYPE_SELL ? $user_id : $offer_user;
			$seller_id = $type == \nainai\offer\product::TYPE_SELL ? $offer_user : $user_id;
			if($buyer_id == $this->user_id){
				$complain_type = \nainai\order\OrderComplain::BUYCOMPLAIN;
			}elseif($seller_id == $this->user_id){
				$complain_type = \nainai\order\OrderComplain::SELLCOMPLAIN;
			}else{
				die(json::encode(tool::getSuccInfo(0,'请不要申诉与你无关的合同')));
			}
			
			// //判断是否是当前买方或者卖方申请的
			// switch ($complain_type) {
			// 	case \nainai\order\OrderComplain::BUYCOMPLAIN:
			// 		if ($this->user_id != $buyer_id) {
			// 			die(json::encode(tool::getSuccInfo(0,'请不要申请不是你购买的合同')));
			// 		}
			// 		break;
			// 	case \nainai\order\OrderComplain::SELLCOMPLAIN:
			// 		if ($this->user_id != $seller_id) {
			// 			die(json::encode(tool::getSuccInfo(0,'请不要申请不是你销售的合同')));
			// 		}
			// 		break;
			// }

			$complainData = array(
				'order_id' => $order_id ,
				'user_id' => $this->user_id,
				'title' => Safe::filterPost('title'),
				'detail' => Safe::filterPost('content'),
				'proof' => serialize($img),
				'apply_time' => \Library\Time::getDateTime(),
				'type' => $complain_type, //判断合同userid和申请人是否为同一人，来选择是买方申述，还是卖方申述
				'status' => \nainai\order\OrderComplain::APPLYCOMPLAIN
			);

			$returnData = $complainModel->addOrderComplain($complainData);

			die(json::encode($returnData));
		}
		else{
			$id = Safe::filterGet('id', 'int');

			if (intval($id) > 0) {
				$ContractData = array();
				$ContractData = $complainModel->getUcenterContract($id,$this->user_id);
				if (empty($ContractData)) {//没有这合同直接跳转
					$this->error('无效的合同！');
				}

				//获取卖方和卖方的中文名
				$userModel = new \nainai\user\User();
				$ContractData['usercn']  = $userModel->getUser($ContractData['user_id'], 'username');
				if ($ContractData['user_id'] == $ContractData['sell_user']) {
					$ContractData['sellcn'] = $ContractData['usercn'];
				}else{
					$ContractData['sellcn'] = $userModel->getUser($ContractData['sell_user'], 'username');
				}

				//上传图片插件
				$plupload = new PlUpload(url::createUrl('/ManagerDeal/swfupload'));

				//注意，js要放到html的最后面，否则会无效
				$this->getView()->assign('plupload',$plupload->show());
				$this->getView()->assign('ContractData', $ContractData);
			}else{
				$this->error('无效的合同！');
			}
		}

	}

	/**
	 * 申述列表
	 */
	public function complainListAction(){
		$page = Safe::filterGet('page', 'int', 0);

		$condition = array(
			'where' => 'a.user_id =:user_id',
			'bind' => array('user_id' => $this->user_id)
		);

		$complainModel = new \nainai\order\OrderComplain();
		$complainList = $complainModel->getComplainList($condition);

		$this->getView()->assign('data', $complainList);
	}

	/**
	 * 申述详情
	 */
	public function ComplainDetailAction(){
		$id = $this->getRequest()->getParam('id');
		$id = Safe::filter($id, 'int', 0);

		if (intval($id) > 0) {
			$complainModel = new \nainai\order\OrderComplain();
			$complainDetail = $complainModel->getComplainDetail($id);

			$this->getView()->assign('complainDetail', $complainDetail);
		}else{
			$this->redirect('complainList');
		}
	}




}