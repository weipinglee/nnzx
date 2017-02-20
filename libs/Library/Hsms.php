<?php
namespace Library;
use Library\url;
use Library\tool;
/**
 * @brief 短信发送接口
 * @version 3.3
 */

 /**
 * @class Hsms
 * @brief 短信发送接口
 */
class Hsms
{
	private static $smsInstance = null;

	public static function getSmsInstance(){
		
		//单例模式
		if(self::$smsInstance != NULL && is_object(self::$smsInstance))
		{
			return self::$smsInstance;
		}
		
		$platform = self::getPlatForm();
		switch($platform)
		{
			case "jianzhou":
				{
					$classFile = __DIR__.'/hsms/jianzhou.php';
					if(file_exists($classFile)){
						require $classFile;
						return self::$smsInstance = new \Library\hsms\jianzhou();
					}else{
						echo 2;
					}

					
				}
			case "zhutong":
				{

					$classFile = __DIR__.'/hsms/zhutong.php';
					require($classFile);
					return self::$smsInstance = new \Library\hsms\zhutong();
				}
				break;
	
			default:
				{
					$classFile =  __DIR__.'/hsms/haiyan.php';
					require($classFile);
					return self::$smsInstance = new \Library\hsms\haiyan();
				}
		}
	}

	/**
	 * @brief 获取config用户配置
	 * @return array
	 */
	private static function getPlatForm()
	{
		$siteConfigObj = tool::getGlobalConfig('sms');

		// var_dump($siteConfigObj['platform']);
		return $siteConfigObj['platform'];
	}

	/**
	 * @brief 发送短信
	 * @param string $mobile
	 * @param string $content
	 * @return success or fail
	 */
	public static function send($mobile,$content)
	{
		self::$smsInstance = self::getSmsInstance();

		if(preg_match('/^\d{11}$/',$mobile) && $content) {
			$ip = tool::getIp();
			if ($ip) {
				$mobileKey = md5($mobile . $ip);
				$sendTime = \Library\session::get($mobileKey);
				if ($sendTime && time() - $sendTime < 60) {
					return false;
				}
				\Library\session::set($mobileKey, time());
				return self::$smsInstance->send($mobile, $content);
			}
		}
		return false;
	}
}

/**
 * @brief 短信抽象类
 */
abstract class hsmsBase
{
	//短信发送接口
	abstract public function send($mobile,$content);

	//短信发送结果接口
	abstract public function response($result);

	//短信配置参数
	abstract public function getParam();
}