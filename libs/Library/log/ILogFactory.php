<?php
/**
 * @file log_factory_class.php
 * @brief 日志接口文件
 * @date 2010-12-09
 * @version 0.6
 */

/**
 * @brief ILogFactory 日志工厂类，负责生成日志对象，由配制文件负责日志的存储设备
 * @class ILogFactory
 */
namespace Library\log;
use Library\IException;
class ILogFactory
{
    private static $log      = null;         //日志对象
    private static $logClass = array('file' => 'IFileLog' , 'db' => 'IDBLog');

    /**
     * @brief   生成日志处理对象，包换各种介质的日志处理对象,单例模式
     * @logType string $logType 日志类型
     * @return  object 日志对象
     */
    public static function getInstance($logType = '')
    {

		switch($logType){
			case 'db' : self::$log = new IDBLog();
				break;
			case 'file' : self::$log = new IFileLog();
				break;
			default:throw new IException('the log class is not exists',403);
		}


    	return self::$log;
    }

    private function __construct(){}
    private function __clone(){}
}