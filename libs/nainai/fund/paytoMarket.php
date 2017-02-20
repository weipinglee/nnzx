<?php
/**
 * 支付到市场
 * author: panduo
 * Date: 2016/8/16
 */

namespace nainai\fund;
use \Library\M;
use Library\searchQuery;
use \Library\Time;
use \Library\tool;
use \Library\Safe;
use \Library\Query;
class paytoMarket{

	const STORE_FEE = 1;
	const OFFER_FEE = 2;

	public function __construct(){
		$this->table = new M('payto_market');
	}
	
	public function paytoMarket($user_id,$offer_type,$charge_type,$offer_id,$num,$remark='',$order_no=''){
		$payData['user_id'] = $user_id;
		$payData['offer_type'] = $offer_type;
		$payData['charge_type'] = $charge_type;
		$payData['offer_id'] = $offer_id;
		$payData['num'] = $num;
		$payData['remark'] = $remark;
		$payData['order_no'] = $order_no;
		$payData['create_time'] = date('Y-m-d H:i:s',time());

		$res = $this->table->data($payData)->add();
		return $res ? true : $this->table->getError();
	}

	public function paylist($page=1){
		$query = new searchQuery('payto_market as p');
		$query->join = 'left join user as u on p.user_id = u.id';
		$query->fields = 'p.*,u.username';
		$query->page = $page;
		$query->order = 'p.create_time desc';
		$res = $query->find();
		$product = new \nainai\offer\product();
		foreach ($res['list'] as $key => &$value) {
			$value['charge_type_text'] = $this->getCharge(intval($value['charge_type']));
			$value['mode_text'] = $product->getMode($value['offer_type']);
		}
		$query->downExcel($res['list'], 'payto_market', '收费明细');
		return $res;
	}

	public function detail($id){
		$res = $this->table->where(array('id'=>$id))->getObj();
		$res['charge_type_text'] = $this->getCharge($res['charge_type']);
		return $res;
	}

	public function getCharge($charge_type){
		switch ($charge_type) {
			case self::STORE_FEE:
				$txt = '仓库管理费';
				break;
			case self::OFFER_FEE:
				$txt = '报盘费用';
				break;
			default:
				$txt = '未知';
				break;
		}
		return $txt;
	}
}