<?php

namespace nainai\user;

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;


/**
 * 开票信息的api
 * @author zengmaoyong <zengmaoyong@126.com>
 * @copyright 2016-05-27
 * @package  user
 */

class UserInvoice extends \nainai\Abstruct\ModelAbstract {

	public $pk = 'user_id';

	/**
	 * 添加开票验证规程
	 * @var array
	 */
	protected $Rules = array(	

	    array('title','s{2,30}','发票抬头格式不正确'),
        array('tax_no','/^[a-zA-Z0-9_]{6,40}$/','纳税人识别号格式不正确'),
        array('address','/^[\S]{2,120}$/','地址格式不正确'),
        array('phone','/^[0-9\-]{6,15}$/','电话格式不正确'),
        array('bank_name','s{2,20}','银行名称格式不正确'),
        array('bank_no','s{6,20}','银行卡号格式不正确')
	);

	public function __construct(){
		parent::__construct();
		$this->user_invoice = new M('user_invoice');
		$this->order_invoice = new M('order_invoice');
	}

	
	/**
	 * 根据用户id获取相应发票信息
	 * @param  int $user_id 用户id
	 */
	public function userInvoiceInfo($user_id){
		
		return $this->user_invoice->where(array('user_id'=>$user_id))->getObj();
	}

	/**
	 * 获取订单发票
	 * @param  int  $order_id 订单id
	 */
	public function orderInvoiceInfo($order_id){
		$res = $this->order_invoice->where(array('order_id'=>$order_id))->getObj();
		if($res){
			$res['image'] = \Library\Thumb::get($res['image'],180,180);
		}
		return $res;
	}

	/**
	 * 生成发票信息
	 * @param  array $data 发票信息数组
	 */
	public function geneInvoice($data){
		$order = new \nainai\order\Order();
		$order_info = $order->orderInfo($data['order_id']);
		if($order_info['user_id']){
			$res = $this->order_invoice->data($data)->add() ? true : false;
			if($res === true){
				$mess = new \nainai\message($order_info['user_id']);
				$content = '合同'.$order_info['order_no'].',卖家已开具并邮寄发票。请注意查收。';
				return true;
			}else{
				return $res;
			}
		}else{
			return false;
		}
	}



}