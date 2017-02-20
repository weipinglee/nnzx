<?php
/**
 * @file session.php
 * @brief session机制处理类
 * @date 2016-03-1
 * @version 1.0
 */

/**
 * @brief Session 处理类
 * @class Session
 * @note
 */
namespace Library;
class session
{
	//session前缀
	private static $pre='nn_';

	//获取配置的前缀
	private static function getPre()
	{
		return self::$pre;
	}

	/*
	 * 在某个session字段里添加数据，已存在则不添加
	 * @$name str  session键名
	 * @$value str 加入的值
	 */
	public static function add($name,$value=''){
		self::$pre = self::getPre();
		if(!isset($_SESSION[self::$pre.$name]) || !is_array($_SESSION[self::$pre.$name]))$_SESSION[self::$pre.$name] = array();
		if(!in_array($value,$_SESSION[self::$pre.$name])){
			array_unshift($_SESSION[self::$pre.$name],$value);
		}
	}

	/**
	 * 在某个session字段里合并数据
	 * @$name str  session键名
	 * @$value array 加入的值
	 */
	public static function merge($name,$value){
		self::$pre = self::getPre();
		if(!isset($_SESSION[self::$pre.$name]) || !is_array($_SESSION[self::$pre.$name]))$_SESSION[self::$pre.$name] = array();
		$_SESSION[self::$pre.$name] = array_merge($_SESSION[self::$pre.$name],$value);
	}
	
	/**
	 * @brief 设置session数据
	 * @param string $name 字段名
	 * @param mixed $value 对应字段值
	 */
	public static function set($name,$value='')
	{
		self::$pre = self::getPre();
		$_SESSION[self::$pre.$name]=$value;
	}
    /**
     * @brief 获取session数据
     * @param string $name 字段名
     * @return mixed 对应字段值
     */
	public static function get($name)
	{	
		self::$pre  = self::getPre();
		return isset($_SESSION[self::$pre.$name])?$_SESSION[self::$pre.$name]:null;

	}
    /**
     * @brief 清空某一个Session
     * @param mixed $name 字段名
     */
	public static function clear($name)
	{
		self::$pre = self::getPre();
		if(isset($_SESSION[self::$pre.$name]))
			unset($_SESSION[self::$pre.$name]);
	}
    /**
     * @brief 清空所有Session
     */
	public static function clearAll()
	{
		return session_destroy();
	}



}