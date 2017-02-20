<?php

/**
 * 短信发送工厂类
 * @author wplee
 *
 */


class hsmsFactory{
	
	//短信发送对象
	public static $instance = NULL;
	
	
	public static function getHsms()
	{
		//单例模式
		if(self::$instance != NULL && is_object(self::$instance))
		{
			return self::$instance;
		}
		
		$platform = self::getPlatForm();
		switch($platform)
		{
			case "jianzhou":
				{
					$classFile = IWeb::$app->getBasePath().'plugins/hsms/jz/lib/nusoap.php';
					require $classFile;
					$client = new nusoap_client('http://www.jianzhou.sh.cn/JianzhouSMSWSServer/services/BusinessService?wsdl', true);
					$client->soap_defencoding = 'utf-8';
					$client->decode_utf8      = false;
					$client->xml_encoding     = 'utf-8';
				}
			case "zhutong":
				{
					$classFile = IWeb::$app->getBasePath().'plugins/hsms/zhutong.php';
					require($classFile);
					self::$smsInstance = new zhutong();
				}
				break;
		
			default:
				{
					$classFile = IWeb::$app->getBasePath().'plugins/hsms/haiyan.php';
					require($classFile);
					self::$smsInstance = new haiyan();
				}
		}
		self::$smsInstance = $client;
		return self::$smsInstance;
	}
	
	/**
	 * @brief 获取config用户配置
	 * @return array
	 */
	private static function getPlatForm()
	{
		$siteConfigObj = new Config("site_config");
		return $siteConfigObj->sms_platform;
	}
}