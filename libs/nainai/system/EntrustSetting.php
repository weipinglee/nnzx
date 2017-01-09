<?php

namespace nainai\system;

use \Library\M;
use \Library\searchQuery;
use \Library\Tool;

class EntrustSetting extends \nainai\Abstruct\ModelAbstract{

	protected $Rules = array(
	        array('cate_id','require','必须选择分类'),
	        array('value','require','必须填写费率值'),
	);

	public function getList(){
		$query = new searchQuery($this->tableName. ' as a');
		$query->fields = 'a.*, b.name';
		$query->join = 'LEFT JOIN product_category as b ON a.cate_id=b.id';

		return $query->find();
	}

	public function getcatelist(){
		$query = new \Library\Query($this->tableName);
		$query->fields = 'cate_id';
		$query->group = 'cate_id';
		$data = $query->find();
		$ids = array();
		foreach ($data as $key => $value) {
			$ids[] = $value['cate_id'];
		}
		return $ids;
	}

	public function getDetail($id){
		$data = array();
		if ($id > 0) {
			$query = new \Library\Query($this->tableName.' as a');
			$query->fields = 'a.*, b.name';
			$query->join = 'LEFT JOIN product_category as b ON a.cate_id=b.id';
			$query->where = ' a.id=:id';
			$query->bind = array('id' => $id);
			$data = $query->find();
		}
		return $data;
	}

	public function getRate($cate_id = 0){
		$where = array('status' => 1);
		
		if (intval($cate_id) > 0) {
			
			$where['cate_id'] = $cate_id;
			$rate = $this->getEntrustSetting($where, 'type, cate_id, value');
			
			if (empty($rate)) {
				// $rate = array('type' => 1, 'value' => 0);
				$cate = new M('product_category');
				$cate_id = $cate->where(array('id'=>$cate_id))->getField('pid');
				$rate = $this->getRate($cate_id);
			}
		}
		
		return $rate;
	}


}