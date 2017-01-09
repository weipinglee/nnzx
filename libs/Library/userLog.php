<?php
/**
 * @class log
 * @brief 日志记录类
 */
namespace Library;
class userLog  extends \Library\log\baselog

{
	protected $tableName = 'user_log';

	protected $childAuthor = true;

	public function getAuthor(){
		$userData = session::get('login');//获取管理员信息
		if(isset($userData['user_id'])){
			return $userData['user_id'];
		}
		return false;
	}

	public function getChildAuthor(){
		$userData = session::get('login');//获取子账户管理员信息
		if(isset($userData['child_id'])){
			return $userData['child_id'];
		}
		return false;
	}



	public function getList($condition = array()){
	       $reModel = new searchQuery($this->tableName . ' as r');
	        //线上
	        $reModel->join = 'left join user as u on r.author = u.id';
	        $reModel->fields = 'r.*, u.username';
	        $reModel->order = 'datetime desc';
	        if (  isset($condition['pid'])) {
	        	$reModel->where = 'u.pid=:pid OR r.author=:pid';
	        	$reModel->bind = array('pid' => $condition['pid']);
	        }

	        $onlineInfo = $reModel->find();

	        $reModel->downExcel($onlineInfo['list'], 'user_log', '用户操作日志');

	        return $onlineInfo;
	}



}