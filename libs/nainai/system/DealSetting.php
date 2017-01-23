<?php

namespace nainai\system;

use \Library\M;
use \Library\searchQuery;
use \Library\Tool;

class DealSetting extends \nainai\Abstruct\ModelAbstract{
	public $pk = 'date';

	protected $Rules = array(
	        array('weeks','require','必须选择周期'),
	        array('start_time','require','必须选择开市时间'),
	        array('end_time','require','必须选择闭市时间'),
	);

	/**
	 * 获取最新的日结配置
	 */
	public function getsetting(){
		$where = 'date <=:date';
		$bind = array('date' => date('Y-m-d', time()));
		return $this->model->where($where)->bind($bind)->order('date desc')->getObj();
	}

}