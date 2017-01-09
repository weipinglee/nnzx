<?php
/**
 * @file  unionpay.php
 * @brief 银联在线支付接口
 * @date 2015-05-25
 * @version 0.1
 */

 /**
 * @class unionpay
 * @brief 银联在线支付接口
 */
namespace Library\payment\pay_unionpay;
include_once(dirname(__FILE__)."/common.php");
include_once(dirname(__FILE__)."/httpClient.php");
include_once(dirname(__FILE__)."/SDKConfig.php");
use Library\payment\paymentPlugin;
class unionpay extends paymentPlugin
{
	
    public $name 	= '银联在线支付';//插件名称

	/**
	 * @see paymentplugin::getSubmitUrl()
	 */
	public function getSubmitUrl()
	{
		return SDK_FRONT_TRANS_URL; //前台提交地址
	}
	
	/**
	 * @see paymentplugin::getRefundUrl()
	 */
	public function getRefundUrl(){
		return SDK_BACK_TRANS_URL;//后台提交地址
	}
	/**
	 * @see paymentplugin::notifyStop()
	 */
	public function notifyStop()
	{
		echo "success";
	}

	/**
	 * @see paymentplugin::callback()
	 */
	public function callback($callbackData,&$paymentId,&$money,&$message,&$orderNo)
	{
		if (isset ( $callbackData['signature'] ))
		{
			if (Common::verify ( $callbackData ))
			{
				$orderNo = $callbackData['orderId'];//订单号
				if(isset($callbackData['queryId'])){
					$this->recordTradeNo($orderNo,$callbackData['queryId']);
				}
				self::addTradeData($callbackData);//添加交易记录
				return 1;
			}
			else
			{
				$message = '签名不正确';
			}
		}
		else
		{
			$message = '签名为空';
		}
		return 0;
	}

	/**
	 * @see paymentplugin::serverCallback()
	 */
	public function serverCallback($callbackData,&$paymentId,&$money,&$message,&$orderNo)
	{
		if (isset ( $callbackData['signature'] ))
		{
			if (Common::verify ( $callbackData ))
			{
				$orderNo = $callbackData['orderId'];//订单号
				if(isset($callbackData['queryId'])){
					$this->recordTradeNo($orderNo,$callbackData['queryId']);
				}
				self::addTradeData($callbackData,1);//添加交易记录
				return 1;
			}
			else
			{
				$message = '签名不正确';
			}
		}
		else
		{
			$message = '签名为空';
		}
		return 0;
	}
	

	/**
	 * @see paymentplugin::getSendData()
	 */
	public function getSendData($payment)
	{
		Common::setCertPwd($payment['M_certPwd']);
		$return = array(
			'version' => '5.0.0',				//版本号
			'encoding' => 'utf-8',				//编码方式
			'certId' => Common::getSignCertId (),			//证书ID
			
			'txnType' => '01',				//交易类型     //可能是活的
			'txnSubType' => '01',				//交易子类 01消费
			'bizType' => '000201',				//业务类型
			'frontUrl' =>  $this->callbackUrl,//SDK_FRONT_NOTIFY_URL,  		//前台通知地址
			'backUrl' => $this->serverCallbackUrl,//SDK_BACK_NOTIFY_URL,		//后台通知地址
			'signMethod' => '01',		//签名方法
			'channelType' => '07',		//渠道类型，07-PC，08-手机
			'accessType' => '0',		//接入类型
			'merId' => $payment['M_merId'],	//商户代码，请改自己的测试商户号
			'currencyCode' => '156',	//交易币种
			'defaultPayType' => '0001',	//默认支付方式
			'txnTime' => date('YmdHis')	//订单发送时间
			//'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
		);
		if(IClient::getDevice()=='mobile'){
			$return['channelType'] = '08';
		}
		$return['orderId'] = $payment['M_OrderNO'];	//商户订单号
		$return['txnAmt'] = $payment['M_Amount']*100;		//交易金额，单位分
		$return['reqReserved'] = $payment['M_OrderId'].":".$payment['M_Remark'];	//订单发送时间'透传信息'; //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
		
		// 签名
		Common::sign ( $return );
		
        return $return;
	}

	/**
	 * 商品退款
	 */
	public function refund($payment)
	{
		Common::setCertPwd($payment['M_certPwd']);
		$return = array(
				'version' => '5.0.0',				//版本号
				'encoding' => 'utf-8',				//编码方式
				'certId' => Common::getSignCertId (),			//证书ID
				'txnType' => '04',				//交易类型     //可能是活的
				'txnSubType' => '00',				//交易子类 01消费
				'bizType' => '000201',				//业务类型 		//前台通知地址
				'backUrl' => $this->serverCallbackUrlForRefund,//SDK_BACK_NOTIFY_URL,		//后台通知地址
				'signMethod' => '01',		//签名方法
				'channelType' => '07',		//渠道类型，07-PC，08-手机
				'accessType' => '0',		//接入类型
				'merId' => $payment['M_merId'],	//商户代码，请改自己的测试商户号
				'txnTime'=>date('YmdHis')
				//'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
		);
	
		$return['orderId'] = $payment['M_OrderNO'];	//商户订单号
		$return['txnAmt'] = $payment['M_Amount']*100;		//交易金额，单位分
		$return['origQryId'] = $payment['M_Trade_NO'];

		Common::sign ( $return );
		$result = sendHttpRequest ( $return, SDK_BACK_TRANS_URL );
		$result_arr = Common::coverStringToArray ( $result );
		
		//print_r($result_arr);exit();
		if(Common::verify ( $result_arr )&&$result_arr['respCode']=='00'){//
			
			self::addTradeData($result_arr);
			return true;
		}
		return false;
	}
	/**
	 * 添加交易记录
	 * @param array $tradeData  返回的报文
	 * @param int   $asyn  0:同步处理 1：异步回调
	 */
	private static function addTradeData($tradeData,$asyn=0,$ids=0){
		$resArr = array(
				'trade_no' 	   => $tradeData['queryId'],
				'order_no'     => $tradeData['orderId'],
				'money'        => $tradeData['txnAmt']/100,
				'pay_type'     => 3,
				'trade_type'   => self::getTradeType(3,$tradeData['txnType']),
				'time'         => $tradeData['txnTime'],
				'order_ids'    => $ids,
		);
		if(isset($tradeData['accNo'])){
			$resArr['acc_no'] = substr($tradeData['accNo'],0,6);
		}
		$resArr['trade_status']=$asyn;
		$resArr['orig_trade_no'] = isset($tradeData['origQryId']) ? $tradeData['origQryId'] : '';
		self::addTrade($resArr);
		
	}
	/*
	 * @param 获取配置参数
	 */
	public function configParam()
	{
		$result = array(
			'M_merId'  => '商户代码',
			'M_certPwd' => '签名证书密码',
		);
		return $result;
	}
	
	
}
