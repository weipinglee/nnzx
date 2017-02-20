<?php
/**
 * @file time_class.php
 * @brief 时间处理
 * @author 
 * @date 2010-12-02
 * @version 0.6
 */

/**
 * @class ITime
 * @brief ITime 时间处理类
 * @note
 */

namespace Library;
class Time
{
	/**
	 * @brief 获取当前时间
	 * @param String  $format  返回的时间格式，默认返回当前时间的时间戳
	 * @return String $time    时间
	 */
	public static function getNow($format='')
	{
		if($format)
		{
			return self::getDateTime($format);
		}
		return self::getTime();
	}

	/**
	 * @brief  根据指定的格式输出时间
	 * @param  String  $format 格式为年-月-日 时:分：秒,如‘Y-m-d H:i:s’
	 * @param  String  $time   输入的时间
	 * @return String  $time   时间
	 */
	public static function getDateTime($format='',$time='')
	{
		$time   = $time   ? $time   : time();
		$format = $format ? $format : 'Y-m-d H:i:s';
		return date($format,$time);
	}

	/**
	 * @brief  根据输入的时间返回时间戳
	 * @param  $time String 输入的时间，格式为年-月-日 时:分：秒,如2010-01-01 00:00:00
	 * @return $time Int 指定时间的时间戳
	 */
	public static function getTime($time='')
	{
		if($time)
		{
			return strtotime($time);
		}
		return time();
	}

	/**
	 * @brief 获取第一个时间与第二个时间之间相差的秒数
	 * @param $first_time  String 第一个时间 格式为英文时间格式，如2010-01-01 00:00:00
	 * @param $second_time String 第二个时间 格式为英文时间格式，如2010-01-01 00:00:00
	 * @return $difference Int 时间差，单位是秒
	 * @note  如果第一个时间早于第二个时间，则会返回负数
	 */
	public static function getDiffSec($first_time,$second_time='')
	{
		$second_time = $second_time ? $second_time : self::getDateTime();
		$difference  = strtotime($first_time) - strtotime($second_time);
		return $difference;
	}

	/**
	 *
	 * @param $first_time
	 * @param string $second_time
	 */
	public static function getDiffDays($first_time,$second_time=''){
		$datetime1 = new \DateTime($first_time);
		$second_time = $second_time ? $second_time : self::getDateTime();
		$datetime2 = new \DateTime($second_time);
		$interval = $datetime1->diff($datetime2);
		return $interval->days;

	}

	function _after_time($time = '',$total=0){ 
		if($total < 0 || !$time) return false;
	    $ttime = self::getDiffSec($time); 
	    $ttime += $total;

	    if($ttime < 0) return true;
	    if($ttime >= 0 && $ttime < 60){ 
	        return $ttime.'秒后'; 
	    }    
	    if($ttime > 60 && $ttime <120){ 
	        return '1分钟后'; 
	    } 
	     
	    $i = floor($ttime / 60);                            //分 
	    $h = floor($ttime / 60 / 60);                       //时 
	    $d = floor($ttime / 86400);                         //天 
	    $m = floor($ttime / 2592000);                       //月 
	    $y = floor($ttime / 60 / 60 / 24 / 365);            //年 
	    if($i < 30){ 
	        return $i.'分钟后'; 
	    } 
	    if($i > 30 && $i < 60){ 
	        return '一小时后'; 
	    } 
	    if($h>=1 && $h < 24){ 
	        return $h.'小时后'; 
	    } 
	    if($d>=1 && $d < 30){ 
	        return $d.'天后'; 
	    }    
	    if($m>=1 && $m < 12){        
	        return $m.'个月后'; 
	    } 
	    if($y){ 
	        return $y.'年后'; 
	    }    
	    return true; 
	     
	} 

}