<?php 

/**
 * 委托报盘摘牌控制器
 */
use \Library\safe;
use \Library\tool;
use \Library\JSON;
use \Library\url;
use \Library\checkRight;
//http://localhost/nn2/user/entrustorder/alipayentrust/order_id/185/user_id/53?buyer_email=18672344722&buyer_id=2088612817847435&exterface=create_direct_pay_by_user&is_success=T&notify_id=RqPnCoPT3K9%252Fvwbh3InZcXK%252FpBteEQA7dJbh%252BmNEaYH2ptiVRGG7MUzL%252BmgGwqPxXed%252B&notify_time=2016-12-27+16%3A34%3A48&notify_type=trade_status_sync&out_trade_no=20161226135121079&payment_type=1&seller_email=nnw%40nainaiwang.com&seller_id=2088121869989852&subject=nnys&total_fee=0.11&trade_no=2016122721001004430298360554&trade_status=TRADE_SUCCESS&sign=c1bd1b928d2182eeca42334587f209f0&sign_type=MD5
class EntrustOrderController extends OrderController{
	//支付宝支付委托费用回调函数
	public function alipayEntrustAction(){
		//TODO  支付宝回调验证
		//从URL中获取支付方式
        $payment_id      = safe::filterGet('id', 'int',2);
        $paymentInstance = \Library\Payment::createPaymentInstance($payment_id);

        if(!is_object($paymentInstance))
        {
            die(json::encode(\Library\tool::getSuccInfo(0,'支付方式不存在')) ) ;
        }
        
        //初始化参数
        $money   = '';
        $message = '支付失败';
        $orderNo = '';

        //执行接口回调函数
        $callbackData = array_merge($_POST,$_GET);
        unset($callbackData['controller']);
        unset($callbackData['action']);
        unset($callbackData['_id']);
        $return = $paymentInstance->callback($callbackData,$payment_id,$money,$message,$orderNo);
        
        //支付成功
        if($return){
			$order_id = safe::filter($this->_request->getParam('order_id'));
			$user_id = safe::filter($this->_request->getParam('user_id'));
			$entrust = new \nainai\order\EntrustOrder();
			$res = $entrust->sellerDeposit($order_id,true,$user_id,\nainai\order\Order::PAYMENT_ALIPAY);
			$this->success('委托费用支付成功！',url::createUrl('/Contract/sellerList@user'));
		}else{
			echo 'xxx';
		}

		exit;
	}
}