<?php

namespace nainai\fund;

use \Library\M;
use \Library\searchQuery;
use \Library\Tool;

class DealTotal extends \nainai\Abstruct\ModelAbstract{

	/**
	 * 获取那次日结的统计数据
	 * @param  date $date 日期
	 * @return array
	 */
	public function getLastList(){
		$lists = array();
		$sql = 'SELECT a.* FROM (SELECT * FROM deal_total order by create_time desc) as a   group by user_id';
		$list = $this->model->query($sql);
		if ( ! empty($list)) {
			foreach ($list as $key => $value) {
				$lists[$value['user_id']] = $value;
			}
		}
		return $lists;
	}

	public function getList(){
		$Q = new searchQuery($this->tableName . ' as a');
		$Q->fields = 'a.*, u.username,u.type, b.bank_name';
		$Q->join = 'LEFT JOIN user as u ON a.user_id=u.id LEFT JOIN user_bank as b ON u.id=b.user_id';
		$Q->order = 'create_time desc';

		return $Q->find();
	}

}