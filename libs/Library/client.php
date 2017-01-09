<?php
/**
 * @file client_class.php
 * @brief 获取客户端数据信息
 * @author 
 * @date 2010-12-2
 * @version 0.6
 */

/**
 * @class IClient
 * @brief IClient 获取客户端信息
 */
namespace Library;
class Client
{
	const PC     = 'pc';
	const MOBILE = 'mobile';

	/**
	 * @brief 获取客户端ip地址
	 * @return string 客户端的ip地址
	 */
	public static function getIp()
	{
	    $realip = NULL;
	    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	    {
	    	$ipArray = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	    	foreach($ipArray as $rs)
	    	{
	    		$rs = trim($rs);
	    		if($rs != 'unknown')
	    		{
	    			$realip = $rs;
	    			break;
	    		}
	    	}
	    }
	    else if(isset($_SERVER['HTTP_CLIENT_IP']))
	    {
	    	$realip = $_SERVER['HTTP_CLIENT_IP'];
	    }
	    else
	    {
	    	$realip = $_SERVER['REMOTE_ADDR'];
	    }

	    preg_match("/[\d\.]{7,15}/", $realip, $match);
	    $realip = isset($match[0]) ? $match[0] : false;
	    return $realip;
	}

	/**
	 * @brief 获取客户端浏览的上一个页面的url地址
	 * @return string 客户端上一个访问的url地址
	 */
	public static function getPreUrl()
	{
		return $_SERVER['HTTP_REFERER'];
	}



	/**
	 * @brief 获取客户设备类型
	 * @return string pc,mobile
	 */
	public static function getDevice()
	{
		if(isset($_GET['client'])){
			$client =  $_GET['client']==self::PC? self::PC : self::MOBILE;
			Session::set('client',$client);
			return $client;
		}
		else if($client=session::get('client')){
			return $client;
		}
		$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$mobileList = array('Android','iPhone','phone');

		foreach($mobileList as $val)
		{
			if(stripos($agent,$val) !== false)
			{
				return self::MOBILE;
			}
		}
		return self::PC;
	}
	/**
	 * @brief 支持返回的客户端
	 * @return 客户端平台
	 */
	public static function supportClient()
	{
		return array(self::PC,self::MOBILE);
	}

	/**
	 * @brief 判断客户端请求是否为ajax方式
	 * @return boolean
	 */
	public static function isAjax()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? true : false;
	}

	/**
	 * @brief 判断客户端是否为微信
	 * @return boolean
	 */
	public static function isWechat()
	{
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false )
		{
			return true;
		}
		return false;
	}
}