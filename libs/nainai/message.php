<?php 
/**
 * 用户消息通知类
 * author :wangzhande
 * Date :2015/5/12
 */
namespace nainai;
use \Library\M;
use \Library\Query;
class message{
	//用户id 
	private $user_id="";
	//通知类型
	private static $type=array(
		'common',
		'orderPay',
		'fundOut',
		'depositPay',
		'newbankaccount',
		'breakcontract',
		'fundInOk',
		'fundInFail',
		'fundOutOk',
		'fundOutFail',
		'accountOk',
		'accountFail',
		'register',
		'dealer',
		'store_manager',
		'ApplyResetpay',
		'ApplyResettel',
		'offer',
		'store',
        'common',
		'credentials',
		'repcredentials',
		'delivery_check'
	);
	/**
	 * [__construct 构造方法]
	 * @param     [type]      $user_id 用户id
	 */
	public function __construct($user_id){
		$this->user_id=$user_id;
	}
	private $messCode=array(
		'sendOk'=>array('code'=>1,'info'=>'发送成功'),
		'sendWrong'=>array('code'=>0,'info'=>'发送失败'),
		'typeWrong'=>array('code'=>0,'info'=>'类型不存在')
		);
	/**
	 * [send  发送消息]
	 * @param   $type    通知类型
	 * @param   $param 订单id,
	 * @return    [type]             [description]
	 */

	public function send($type,$param=0){
		if(in_array($type, self::$type)){
			$mess=call_user_func(array(__CLASS__,$type),$param);
			$mess['user_id']=$this->user_id;
			$mess['send_time']= \Library\Time::getDateTime();
			$messObj=new M('message');
			if($messObj->data($mess)->add()){
				return $this->messCode['sendOk'];
			}else{
				return $this->messCode['sendWrong'];
			}


		}else{
			return $this->messCode['typeWrong'];
		}
	}

	public function common($content){
		$title = '提醒';
		return array(
			'title'=>$title,
			'content'=>$content);
	}

	/**
	 * [order_pay 支付通知]
	 * @param     [type]      $order_id 
	 * @return    [type]                [内容]
	 */
	public function orderPay($order_id){
		$title='支付通知';
		$message="您的订单".$order_id."已经形成,请在多少时间内支付 <a href='?order_id={$order_id}'></a>";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function credentials(){
		$title='交易提醒';
		$message='有用户购买您的商品，由于您未完善资质信息，此交易暂不能进行。为保证您的正常交易，请您及时完善资质信息进行认证';
		return array(
			'title'=>$title,
			'content'=>$message
		);
	}

	public function repcredentials(){
		$title='交易提醒';
		$message='有用户选择您的报价，由于您未完善资质信息，此交易暂不能进行。为保证您的正常交易，请您及时完善资质信息进行认证';
		return array(
			'title'=>$title,
			'content'=>$message
		);
	}
	
	public function breakcontract($order_id){
		$title="违约";
		$message="您的订单".$order_id."已被判为违约";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function depositPay($order_id){
		$title="保证金支付";
		$message="合同".$order_id."已支付";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function buyerRetainage($order_id){
		$title="尾款通知";
		$message="您的订单".$order_id."买家已支付尾款";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function buyerProof($order_id){
		$title="请确认支付凭证";
		$message="您的订单".$order_id."买家已上传支付凭证";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function newbankaccount(){
		$title = '开户提醒';
		$message='有买家要通过线下支付货款，请尽快开户';
		return array(
			'title'=>$title,
			'content'=>$message);
	}

	public function fundInOk(){
		$title='入金审核结果';
		$message='您好，你的入金申请已通过审核，请您关注资金动态';
		return array(
			'title'=>$title,
			'content'=>$message
			);
	}
	public function fundInFail(){
		$title='入金审核结果';
		$message='很遗憾，您的入金申请未通过审核';
		return array(
			'title'=>$title,
			'content'=>$message
		);
	}
	public function fundOutOk(){
		$title='出金审核结果';
		$message='审核通过：您好，您的出金申请已通过审核，已向您打款，请您关注资金动态。';
		return array(
			'title'=>$title,
			'content'=>$message
		);
	}
	public function fundOutFail(){
		$title='出金审核结果';
		$message='未通过认证：很遗憾，您的出金申请未通过审核。';
		return array(
			'title'=>$title,
			'content'=>$message
		);
	}
	public function accountOk(){
		$title='开户审核结果';
		$message='审核通过：您好，您的开户申请已通过审核。';
		return array(
			'title'=>$title,
			'content'=>$message
		);
	}
	public function accountFail()
	{
		$title = '开户审核结果';
		$message = '通过认证：很遗憾，您的开户申请未通过审核。';
		return array(
			'title' => $title,
			'content' => $message
		);
	}
	//注册
	public function register(){
		$title = '注册提醒';
		$message='（您好，您已注册成功。为了您更好的交易，请及时进行认证。 ）<a href=" ' .\Library\url::createUrl('/ucenter/dealcert'). ' ">点击消息，跳转到认证界面！</a>';
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function dealer($status){
		$title = '交易商认证提醒';
		if ($status == 2) {
			$message = '您好，您已成功认证交易商。';
		}elseif($status==4){
			$message='您好，您申请的交易商认证已通过初审,请您及时完善您的信息，以免影响您的交易';
		}
		else{
			$message = '很遗憾，您申请的交易商认证未通过审核，您可以修改相关信息再次进行申请';
		}
		return array(
			'title'=>$title,
			'content'=>$message);
	}

	public function store_manager($status){
		$title = '仓库管理员认证提醒';
		if ($status == 2) {
			$message = '您好，您已成功认证仓库管理员。';
		}else{
			$message = '很遗憾，您申请的仓库管理员认证未通过审核，您可以修改相关信息再次进行申请';
		}
		return array(
			'title'=>$title,
			'content'=>$message);
	}

	public function ApplyResetpay($status){
		$title = '提醒';
		if ($status == 0) {
			$message = '很遗憾，您的忘记支付密码申诉未能通过审核。您可以修改相关信息再次进行申诉，或联系客服解决。';
		}else{
			$message = '您好，您的忘记支付密码申诉已通过审核。新密码已于短信的形式发送到你的手机，为了资金安全请您及时进行修改。';
		}
		return array(
			'title'=>$title,
			'content'=>$message);

	}

	public function ApplyResettel($param){
		$title = '提醒';
		if ($param['status'] == 0) {
			$message = '很遗憾，您的修改手机号申诉未能通过审核。您可以修改相关信息再次进行申诉，或联系客服解决。';
		}else{
			$message = '您修改手机号的申诉已通过审核，已将'.$param['mobile'].'修改为新的手机号。';
		}
		return array(
			'title'=>$title,
			'content'=>$message);

	}

	public function offer($param){
		$title = '报盘审核';

		if ($param['type'] == \nainai\offer\product::TYPE_BUY) {
			if ($param['status'] == \nainai\offer\product::OFFER_OK) {
				$message = '您好，您的“' .$param['name']. '”报盘信息已通过审核。<a href="' .\Library\url::createUrl('/purchase/lists@user'). '">跳转到采购列表</a>';
			}else{
				$message = '很遗憾，您的“' .$param['name']. '”报盘信息未通过审核。<a href="' .\Library\url::createUrl('/purchase/lists@user'). '">跳转到采购列表</a>';
			}
		}else{
			if ($param['mode'] == \nainai\offer\product::FREE_OFFER) {
				if ($param['status'] == \nainai\offer\product::OFFER_OK) {
					$message = '您好，您的“' .$param['name']. '”报盘信息已通过审核。已收取您' .$param['offer_fee']. '元的报盘费。<a href="' .\Library\url::createUrl('/managerdeal/productlist@user'). '">跳转到销售列表</a>';
				}else{
					$message = '很遗憾，您的“' .$param['name']. '”报盘信息未通过审核。<a href="' .\Library\url::createUrl('/managerdeal/productlist@user'). '">跳转到销售列表</a>';
				}
			}else {
				if ($param['status'] == \nainai\offer\product::OFFER_OK) {
					$message = '您好，您的“' .$param['name']. '”报盘信息已通过审核。<a href="' .\Library\url::createUrl('/managerdeal/productlist@user'). '">跳转到销售列表</a>';
				}else{
					$message = '很遗憾，您的“' .$param['name']. '”报盘信息未通过审核。<a href="' .\Library\url::createUrl('/managerdeal/productlist@user'). '">跳转到销售列表</a>';
				}
			}
		}
		
		return array(
			'title'=>$title,
			'content'=>$message);
	}

	public function store($param){
		$title = '仓单审核';
		if ($param['type'] == 'check') {
			if ($param['status'] == \nainai\store::USER_AGREE) {
				$message = '您好，”'.$param['name'].'”仓单，卖家已经审核通过<a href="' .\Library\url::createUrl('/managerstore/applystorelist'). '">跳转到仓单列表页</a>';
			}else{
				$message = '很遗憾，“'.$param['name'].'”仓单 卖家审核未通过。<a href="' .\Library\url::createUrl('/managerstore/applystorelist'). '">跳转到仓单列表页</a>';
			}
		}elseif ($param['type'] == 'admin_check') {
			if ($param['status'] == \nainai\store::MARKET_AGREE) {
				$message = '您好，”'.$param['name'].'”仓单，平台已经审核通过，您可以进行仓单报盘了<a href="' .\Library\url::createUrl('/managerdeal/storeproductlist@user'). '">跳转到仓单列表页</a>';
			}elseif ($param['status'] == \nainai\store::MARKET_AGAIN) {
				$message = '您好，”'.$param['name'].'”仓单，平台需要重新审核，请您耐心等待审核结果.';
			}else{
				$message = '很遗憾，“'.$param['name'].'”仓单 后台审核未通过，您可以联系仓库管理员修改相关信息再次进行签发。<a href="' .\Library\url::createUrl('/managerdeal/storeproductlist@user'). '">跳转到仓单列表页</a>';
			}
		}elseif ($param['type'] == 'for_sign') {
			if ($param['status'] == \nainai\store::MARKET_AGREE) {
				$message = '您好，”'.$param['name'].'”仓单，平台已经审核通过<a href="' .\Library\url::createUrl('/managerstore/applystorelist@user'). '">跳转到仓单列表页</a>';
			}elseif ($param['status'] == \nainai\store::MARKET_AGAIN) {
				$message = '您好，”'.$param['name'].'”仓单，平台需要重新审核，请您耐心等待审核结果.';
			}else{
				$message = '很遗憾，“'.$param['name'].'”仓单 后台审核未通过。<a href="' .\Library\url::createUrl('/managerstore/applystorelist@user'). '">跳转到仓单列表页</a>';
			}
		}
		else{
			$message = '您好，”'.$param['name'].'”仓单，仓库管理员已经进行签发，请您及时进行确认.<a href="' .\Library\url::createUrl('/managerdeal/storeproductlist'). '">跳转到仓单列表页</a>';
		}
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function delivery_check($param){
		$title = '出库审核';
		$message = ' 您好！您合同号为'.$param['order_no'].'的商品，出库审核时被市场驳回，原因为:'.$param['msg'].'；如有疑问请致电XXX-XXX';
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	/**
	 * [fundOut 提现通知]
	 * @param     [type]      $order_id [订单id]
	 * @return    [type]                [通知内容]
	 */
	public function fundOut($order_id){
		$title='提现通知';
		$message='您的提现订单号为：'.$order_id;
		return array(
			'title'=>$title,
			'content'=>$message
			);

	}
	/**
	 * [isReadMessage 获取已读消息]
	 */
	public function isReadMessage(){
		$messObj=new Query('message');
		$messObj->fields='id,title,content,send_time';
		$messObj->where='user_id = :user_id and write_time is NOT NULL';
		$messObj->bind=array('user_id'=>$this->user_id);
		return $messObj->find();

	}
	/**
	 * [getNeedmessage 获取未读信息]
	 * @return    [type]      [description]
	 */
	public function getNeedMessage(){
		$messObj=new Query('message');
		$messObj->fields='id,title,content,send_time';
		$messObj->where='user_id = :user_id and write_time is NULL';
		$messObj->bind=array('user_id'=>$this->user_id);
		return $messObj->find();
	}
	//获取未读消息的总数
	public function getCountMessage(){
		$res=$this->getNeedMessage();
		return count($res);

	}
	/**
	 * [writeMess 写入阅读时间]
	 * @param     [type]      $message_id [消息id]
	 * @return    [type]                  [description]
	 */
	public function writeMess($message_id){
		$messObj=new M('message');
		$where=array('id'=>$message_id);
		$data['write_time']=\Library\Time::getDateTime();
		return $messObj->where($where)->data($data)->update();
	}

	/**
	 * 获得所有消息
	 * @param int $page
	 * @return array
     */
	public function getAllMessage($page=1){
		$messObj=new Query('message');
		$messObj->where='user_id= :user_id';
		$messObj->bind=array('user_id'=>$this->user_id);
		$messObj->order='send_time desc';
		$messObj->page=$page;
		$messInfo=$messObj->find();
		$bar=$messObj->getPageBar();
		return array($messInfo,$bar);
	}

	/**
	 * 批量删除消息
	 * @param $ids
     */
	public function batchDel($ids){
		$messObj=new M('message');
		$where='id in ('.$ids.')';
		return $messObj->where($where)->delete();
	}

	/**
	 * 单个删除消息
	 * @param $id
	 * @return mixed
     */
	public function delMessage($id){
		$messObj=new M('message');
		$where=array('id'=>$id);
		return $messObj->where($where)->delete();

	}
}

?>