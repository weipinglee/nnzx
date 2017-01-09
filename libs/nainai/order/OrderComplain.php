<?php
namespace nainai\order;

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;
use \Library\Thumb;
use \Library\searchQuery;

/**
 * 申述的对应数据操作api
 * @author maoyong <[<zengmaoyong@126.com>]>
 * @copyright 2016-05-27
 * @package  order
 */
class OrderComplain extends \nainai\Abstruct\ModelAbstract{

	/**
	 * 买方角色
	 */
	const BUYCOMPLAIN = 1; 
	/**
	 * 卖方角色
	 */
	const SELLCOMPLAIN = 2;
	/**
	 * 申述角色
	 * @var array
	 */
	protected $complainType = array(
		self::BUYCOMPLAIN => '买方申述',
		self::SELLCOMPLAIN => '卖方申述'
	);

	/**
	 * 申述状态,申请
	 */
	const APPLYCOMPLAIN = 1; 
	/**
	 * 申述状态,不处理请
	 */
	const DONTCOMPLAIN = 2; 
	/**
	 * 申述状态,介入处理
	 */
	const INTERVENECOMPLAIN = 3;
	/**
	 * 申述状态,介入处理完成
	 */
	const CONFERCOMPLAIN = 4; 
	/**
	 * 申述状态,买方违约
	 */
	const BUYBREAKCOMPLAIN = 5; 
	/**
	 * 申述状态,卖方违约
	 */
	const SELLBREAKCOMPLAIN = 6;

	/**
	 * 申述状态对应的数组
	 * @var array
	 */
	protected $complainStatus = array(
		self::APPLYCOMPLAIN => '申请',
		self::DONTCOMPLAIN => '不处理申述',
		self::INTERVENECOMPLAIN => '介入处理申述',
		self::CONFERCOMPLAIN => '介入处理申述协商通过',
		self::BUYBREAKCOMPLAIN => '处理完成(买方违约)',
		self::SELLBREAKCOMPLAIN => '处理完成(卖方违约)'
	);
	
	/**
	 * 验证申述规则
	 * @var array
	 */
	protected $Rules = array(
		array('order_id', 'number', '必须选择合同!'),
		array('title', 'require', '请填写申述标题'),
		array('detail', 'require','请填写申述内容!'),
		array('proof', 'require','请上传申述凭证!')
	);


	/**
	 * 获取申述角色
	 * @return [Array] 
	 */
	public function getComplainType(){
		return $this->complainType;
	}

	/**
	 * 获取申述状态
	 * @return [Array] 
	 */
	public function getComplainStatus(){
		return $this->complainStatus;
	}

	/**
	 * 获取申述列表
	 * @param  [Int] $page   
	 * @param  [Int] $pagesize  
	 * @param  array  $condition [查询条件,where是sql，bind对应的绑定数据]
	 * @return [Array]            
	 */
	public function getComplainList( $condition = array()){
		$query = new \Library\searchQuery('order_complain as a');
		$query->fields = 'a.id, a.title, a.type, a.proof, a.status, a.apply_time, b.order_no, b.id as oid, c.username, p.name';
		$query->join = 'LEFT JOIN order_sell as b ON a.order_id=b.id LEFT JOIN user as c ON a.user_id=c.id LEFT JOIN product_offer as o ON b.offer_id=o.id LEFT JOIN products as p ON o.product_id=p.id ';

		// $query->order = 'apply_time desc';

		if (!empty($condition)) {
			$query->where = $condition['where'];
			$query->bind = $condition['bind'];
		}

		$types = $this->getComplainType();
		$status = $this->getComplainStatus();

        		$lists = $query->find($types);
        		
        		foreach ($lists['list'] as $k => &$list) {
        			$list['type'] = $types[$list['type']];
        			$list['status'] = $status[$list['status']];
        			$list['proof'] = unserialize($list['proof']);
        			if (!empty($list['proof'])) {
        				foreach ($list['proof'] as  $key => $value) {
	        				$list['proof'][$key] = Thumb::get($value,100,100);
	        			}
        			}
        		}
        		return $lists;
	}

	/**
	 * 获取申述详情
	 * @param  [Int] $id [申述id]
	 * @return [Array]
	 */
	public function getComplainDetail($id){
		if (intval($id) > 0) {
			$query = new Query('order_complain as a');
			$query->fields = 'a.*, b.order_no, b.id as oid, c.username';
			$query->join = 'LEFT JOIN order_sell as b ON a.order_id=b.id LEFT JOIN user as c ON a.user_id=c.id';
			$query->where = 'a.id=:id';
			$query->bind = array('id' => $id);

			$detail = $query->getObj();
	        		$types = $this->getComplainType();
	        		$status = $this->getComplainStatus();

	        		$detail['type'] = $types[$detail['type']];
        			$detail['statuscn'] = $status[$detail['status']];
        			$detail['proof'] = unserialize($detail['proof']);

        			if (!empty($detail['proof'])) {
        				foreach ($detail['proof'] as  $key => $value) {
	        				$detail['proof'][$key] = Thumb::get($value,100,100);
							$detail['img'][$key] = $value;
	        			}
        			}
        			
        			return $detail;
		}

		return array();
	}

	/**
	 * 获取合同信息
	 * @access public
	 * @param  [Int] $orderId [合同id]
	 * @return [Array] 
	 */
	public function getContract($orderId, $type=1){
		$detail = array();
		if (intval($orderId) > 0) {
			$query = new  Query('order_sell as a ');
			switch ($type) {
				case 1:
					$query->fields = 'a.id, a.order_no, a.user_id, a.amount, c.name as pname, c.attribute, c.quantity, c.user_id as sell_user, d.name as cname, b.product_id';
					break;
				case 2:
					$query->fields = 'a.id, a.user_id, c.user_id as sell_user';
					break;
			}
			
			$query->join = 'LEFT JOIN product_offer as b ON a.offer_id=b.id LEFT JOIN products as c ON b.product_id=c.id LEFT JOIN product_category as d ON c.cate_id=d.id';
			$query->where = 'a.id = :id ';

			$query->bind = array('id' => $orderId);
			$detail = $query->getObj();

			$detail['attribute'] = unserialize($detail['attribute']);
			$attrIds = array_keys($detail['attribute']);

			$productModel = new \nainai\offer\product();
			$detail['photos'] = $productModel->getProductPhoto($detail['product_id']);
			$detail['attrs'] = $productModel->getHTMLProductAttr($attrIds);

			return $detail;
		}

		return $detail;
	}

	/**
	 * 会员中心获取用户的合同
	 * @param $orderId
	 * @param $user_id
	 * @return array
	 */
	public function getUcenterContract($orderId,$user_id){
		$detail = array();
		if (intval($orderId) > 0) {
			$query = new  Query('order_sell as a ');
			$query->fields = 'a.id, a.order_no,a.contract_status, a.user_id, a.amount, c.name as pname, c.attribute, c.quantity, c.user_id as sell_user, d.name as cname, b.product_id,b.user_id as offer_user,b.type as offer_type';


			$query->join = 'LEFT JOIN product_offer as b ON a.offer_id=b.id LEFT JOIN products as c ON b.product_id=c.id LEFT JOIN product_category as d ON c.cate_id=d.id';
			$query->where = 'a.id = :id AND a.user_id=:user_id';

			$query->bind = array('id' => $orderId,'user_id'=>$user_id);
			$detail = $query->getObj();
			if(empty($detail)){
				$query->where = 'a.id = :id AND b.user_id=:user_id';
				$detail = $query->getObj();
				if(!empty($detail))
					$detail['type'] = 'sell';
			}
			else{
				$detail['type'] = 'buy';
			}

			if(empty($detail)){
				return array();
			}
			$detail['attribute'] = unserialize($detail['attribute']);
			$attrIds = array_keys($detail['attribute']);

			$productModel = new \nainai\offer\product();
			$detail['photos'] = $productModel->getProductPhoto($detail['product_id']);
			$detail['attrs'] = $productModel->getHTMLProductAttr($attrIds);

			return $detail;
		}

		return $detail;
	}

	/**
	 * 申诉第一次审核
	 * @param array $complainData 申诉数据 status为1：介入处理，status为0：不通过
	 */
	public function firstCheck($complainData,$order_id){
		if(!empty($complainData) ){
			$obj = new M('order_complain');
			$status = $obj->where(array('id'=>$complainData['id']))->getField('status');
			if($status!=self::APPLYCOMPLAIN)
				return tool::getSuccInfo(0,'该状态不能审核');
			$order = new M('order_sell');
			$obj->beginTrans();
			if($complainData['status']==1){//介入处理
				$complainData['status'] = self::INTERVENECOMPLAIN;
				$order->data(array('is_lock'=>1))->where(array('id'=>$order_id))->update();
			}
			else{
				$complainData['status'] = self::DONTCOMPLAIN;

			}

			if($obj->data($complainData)->validate($this->Rules)){
				$id=$complainData['id'];
				unset($complainData['id']);
				$obj->data($complainData)->where(array('id'=>$id))->update();
				$log = new \Library\log();
				$log->addLog(array('table'=>'order_complain','id'=>$id,'type'=>'check','check_text'=>$this->complainStatus[$complainData['status']]));
				$res = $obj->commit();
			}
			else{
				$obj->rollBack();
				$res = $obj->getError();
			}

			if($res===true){
				return tool::getSuccInfo();
			}
			else
				return tool::getSuccInfo(0,is_string($res)?$res : '系统繁忙');

		}
		return tool::getSuccInfo(0,'审核失败');
	}

	/**
	 * 申诉第一次审核
	 * @param array $complainData 申诉数据 status为1：介入处理，status为0：不通过
	 */
	public function secondCheck($complainData,$order_id){
		if(!empty($complainData) ){
			$obj = new M('order_complain');
			$status = $obj->where(array('id'=>$complainData['id']))->getField('status');
			if($status!=self::INTERVENECOMPLAIN)
				return tool::getSuccInfo(0,'该状态不能审核');
			$order = new M('order_sell');

			$obj->beginTrans();
			if($complainData['status']==self::CONFERCOMPLAIN){//协商通过
				$order->data(array('is_lock'=>0))->where(array('id'=>$order_id))->update();//合同解锁
				$res1=true;
			}
			else if($complainData['status']==self::BUYBREAKCOMPLAIN){//买方违约
				$order = new Order();
				$res1 = $order->buyerBreakContract($order_id);
			}
			else{//卖方违约
				$order = new Order();
				$res1 = $order->sellerBreakContract($order_id);
			}

			if($res1===true && $obj->data($complainData)->validate($this->Rules)){
				$id=$complainData['id'];
				unset($complainData['id']);
				$obj->data($complainData)->where(array('id'=>$id))->update();
				$log = new \Library\log();
				$log->addLog(array('table'=>'order_complain','id'=>$id,'type'=>'check','check_text'=>$this->complainStatus[$complainData['status']]));

				$res = $obj->commit();
			}
			else{
				$obj->rollBack();
				$res = $obj->getError();
			}

			if($res===true){
				return tool::getSuccInfo();
			}
			else{
				$res .= $res1;
				return tool::getSuccInfo(0,is_string($res)?$res  : '系统繁忙');
			}

		}
		return tool::getSuccInfo(0,'审核失败');
	}



}
