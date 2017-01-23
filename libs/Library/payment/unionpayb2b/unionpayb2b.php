<?php
namespace Library\payment\unionpayb2b;
use \Library\payment;
use \Library\payment\paymentplugin;

/**
 * @brief 银联b2b
 * @note
 */
include_once(dirname(__FILE__)."/SDKConfig.php");
class unionpayb2b extends paymentPlugin {
	//支付插件名称
	public $name = '银联支付b2b';

	/**
	 * @see paymentplugin::getSubmitUrl()
	 */
	public function getSubmitUrl() {
		
	}

	/**
	 * @see paymentplugin::notifyStop()
	 */
	public function notifyStop() {
		echo "success";
	}
	/**
	 * 获取退款提交地址
	 */
	public function getRefundUrl() {

	}

	/**
	 * @see paymentplugin::callback()
	 */
	public function callback($callbackData,&$paymentId,&$money,&$message,&$orderNo)
	{
		if (isset ( $callbackData['signature'] ))
		{
			if (AcpService::validate ( $callbackData ))
			{
				
				if ($callbackData["respCode"] == "00"){
				    //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
				    $orderNo = $callbackData['orderId'];//订单号
					if(isset($callbackData['queryId'])){
						// $this->recordTradeNo($orderNo,$callbackData['queryId']);
					}
				    return 1;
				} else if ($callbackData["respCode"] == "03"
				 	    || $callbackData["respCode"] == "04"
				 	    || $callbackData["respCode"] == "05" ){
				    //后续需发起交易状态查询交易确定交易状态
				    //TODO
				    $message = "处理超时，请稍微查询";
				} else {
				    //其他应答码做以失败处理
				     //TODO
				     $message = "失败：" . $callbackData["respMsg"];
				}
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
	public function getSendData($payment) {
		// var_dump($payment);exit;
		header ( 'Content-type:text/html;charset=utf-8' );
		$params = array(
				
				//以下信息非特殊情况不需要改动
				'version' => '5.0.0',                 //版本号
				'encoding' => 'utf-8',				  //编码方式
				'txnType' => '01',				      //交易类型
				'txnSubType' => '01',				  //交易子类
				'bizType' => '000202',				  //业务类型
				'frontUrl' =>  $this->callbackUrl,//SDK_FRONT_NOTIFY_URL,  //前台通知地址
				'backUrl' => $this->serverCallbackUrl,//SDK_BACK_NOTIFY_URL,	  //后台通知地址
				'signMethod' => '01',	              //签名方法
				'channelType' => '07',	              //渠道类型，07-PC，08-手机
				'accessType' => '0',		          //接入类型
				'currencyCode' => '156',	          //交易币种，境内商户固定156
				
				//TODO 以下信息需要填写
				'merId' => '777290058110048',//$payment["M_merId"],		
				'orderId' => $payment["M_OrderNO"],	
				'txnTime' => date('YmdHis'),
				'txnAmt' => $payment["M_Amount"]*100,	
		// 		'reqReserved' =>'透传信息',        //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
				'reqReserved' =>  $payment['M_OrderId'] . ":" . $payment['M_Remark']
				//TODO 其他特殊用法：
				//【直接跳转发卡行网银】
				//（因测试环境所有商户号都默认不允许开通网银支付权限，所以要实现此功能需要使用正式申请的商户号去生产环境测试）：
				// 1）联系银联业务运营部门开通商户号的网银前置权限
				// 2）上送issInsCode字段，该字段的值参考《平台接入接口规范-第5部分-附录》（全渠道平台银行名称-简码对照表）
		  		//'issInsCode' => 'ABC',  //发卡机构代码
			);
		AcpService::sign ( $params );
		return $params;
	}

	public function refund($payment){
		$params = array(

		//以下信息非特殊情况不需要改动
		'version' => '5.0.0',		      //版本号
		'encoding' => 'utf-8',		      //编码方式
		'signMethod' => '01',		      //签名方法
		'txnType' => '04',		          //交易类型
		'txnSubType' => '00',		      //交易子类
		'bizType' => '000201',		      //业务类型
		'accessType' => '0',		      //接入类型
		'channelType' => '07',		      //渠道类型
		'backUrl' => $this->serverCallbackUrlForRefund, //后台通知地址
		
		//TODO 以下信息需要填写
		'orderId' => $payment['M_OrderNO'],	
		'merId' => '777290058110048',//$payment["M_merId"]
		'origQryId' => $payment["origQryId"], 
		'txnTime' => date('YmdHis'),	    
		'txnAmt' => $payment["M_Amount"],   
// 		'reqReserved' =>'透传信息',            //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
	);

		AcpService::sign ( $params ); // 签名
		$url = SDK_BACK_TRANS_URL;

		$result_arr = AcpService::post ( $params, $url);
		if(count($result_arr)<=0) { //没收到200应答的情况
			
			return '交易失败';
		}

		printResult ($url, $params, $result_arr ); //页面打印请求应答数据

		if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
			return "应答报文验签失败";
			
		}

		if ($result_arr["respCode"] == "00"){
		    //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
		    //TODO
		} else if ($result_arr["respCode"] == "03"
		 	    || $result_arr["respCode"] == "04"
		 	    || $result_arr["respCode"] == "05" ){
		    //后续需发起交易状态查询交易确定交易状态
		    //TODO
		    return "处理超时，请稍微查询";
		} else {
		    //其他应答码做以失败处理
		     //TODO
		     return "失败：" . $result_arr["respMsg"];
		}
	}

	public function doPay($params){
		$uri = SDK_FRONT_TRANS_URL;
		$html_form = AcpService::createAutoFormHtml( $params, $uri );
		echo $html_form;
	}

	/**
	 * @see paymentplugin::serverCallback()
	 */
	public function serverCallback($callbackData, &$paymentId, &$money, &$message, &$orderNo) {
		return $this->callback($callbackData, $paymentId, $money, $message, $orderNo);
	}


	/**
	 * @param 获取配置参数
	 */
	public function configParam() {
	}
}