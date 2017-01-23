<?php
namespace  Library\hsms;
use Library\tool;
require_once('jz/nusoap-for-php5.3.php');
class jianzhou extends \Library\hsmsBase{
	
	private static $submitUrl = "http://www.jianzhou.sh.cn/JianzhouSMSWSServer/services/BusinessService";
	
	/**
	 * @brief 获取config用户配置
	 * @return array
	 */
	public function getParam()
	{
		//如果后台没有设置的话，这里手动配置也可以
		$siteConfigObj = tool::getGlobalConfig('sms');
	
		return array(
				'account'   => $siteConfigObj['account'],
				'password'  => $siteConfigObj['password'],
				'sign'      => $siteConfigObj['sign']
		);
	}
	
	/**
	 * @brief 获取短信对象
	 * @return nusoap_client
	 */
	private static function getObj(){
		$url = self::$submitUrl.'?wsdl';
		$client = new \nusoap_client($url, true);
		$client->soap_defencoding = 'utf-8';
		$client->decode_utf8      = false;
		$client->xml_encoding     = 'utf-8';
		return $client;
	}
	
	/**
	 * 
	 * @param int $mobile
	 * @param str $content
	 */
	public function send($mobile,$content){
		$config = self::getParam();
		
		$obj = self::getObj();
		$params = array(
				'account' => $config['account'],
				'password' => $config['password'],
				'destmobile' => $mobile,
				'msgText' => $content.$config['sign']
		);
		$result = $obj->call('sendBatchMessage', $params, self::$submitUrl);
		$err = $obj->getError();
		if ($err) {
			return false;
		} else {
			return $result['sendBatchMessageReturn'];
		}
	}
	
	/**
	 * @brief 解析结果
	 * @param $result 发送结果
	 * @return string success or fail
	 */
	public function response($result)
	{
		if(strpos($result,'<returnstatus>Success</returnstatus>'))
		{
			return 'success';
		}
		else
		{
			return 'fail';
		}
	}
	
	
	
	
}