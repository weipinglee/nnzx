<?php
/**
 * @class log
 * @brief 日志记录类
 */
namespace Library;
class Log extends \Library\log\baselog
{
	protected $tableName = 'admin_log';

	public function getAuthor(){
		$adminData = session::get('admin');//获取管理员信息
		if(isset($adminData['id'])){
			return $adminData['id'];
		}
		return false;
	}





}