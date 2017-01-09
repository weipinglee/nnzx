<?php
/**
 * @file dblog_class.php
 * @brief 数据库格式日志
 * @date 2010-12-3
 * @version 0.6
 */

/**
 * @class IDBLog
 * @brief 数据库格式日志
 */
namespace Library\log;
use Library\IException;
use Library\M;
class IDBLog implements ILog
{
	//记录的数据表名
	private $tableName = '';

	/**
	 * @brief 构造函数
	 * @param string $tableName 要记录的数据表
	 */
	public function __construct($tableName = '')
	{
		$this->tableName = $tableName;
	}

	/**
	 * @brief 向数据库写入log
	 * @param array  $logs log数据
	 * @return bool  操作结果
	 */
	public function write($logs = array())
	{
		if(!is_array($logs) || empty($logs))
		{
			throw new IException('the $logs parms must be array');
		}

		if($this->tableName == '')
		{
			throw new IException('the tableName is undefined');
		}

		$logObj = new M($this->tableName);
		$logObj->data($logs);
		$result = $logObj->add(1);

		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * @brief 设置要写入的数据表名称
	 * @param string $tableName 要记录的数据表
	 */
	public function setTableName($tableName)
	{
		$this->tableName = $tableName;
	}
}