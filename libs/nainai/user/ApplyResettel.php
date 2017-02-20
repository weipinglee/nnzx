<?php
namespace nainai\user;

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;
use Library\searchQuery;
use \Library\Thumb;

/**
 * 菜单操作对应的api
 * @author maoyong.zeng <zengmaoyong@126.com>
 * @copyright 2016年08月13日
 */
class ApplyResettel extends \nainai\Abstruct\ModelAbstract {

	const APPLY = 0;
	const APPLY_OK = 1;
	const APPLY_NO = 2;
	const APPLY_END = 3;

	protected $Rules = array(
	    array('mobile','require','必须输入手机号')
	);

	protected static $userType = array(
	        0=>'个人',
	        1=>'企业'
	    );

	public function getStatusTxt($status){
		switch ($status) {
			case self::APPLY:
				return '申请';
			case self::APPLY_OK:
				return '审核通过';
			case self::APPLY_NO:
				return '审核驳回';
			case self::APPLY_END:
				return '重置手机号成功';
			default:
				return '未知';
		}
	}

	public function getList($condition=array()){
		$Q = new searchQuery($this->tableName . ' as r');
		$Q->join = ' LEFT JOIN user as u ON r.uid=u.id';
		$Q->fields = 'r.*, u.username';

		$Q->where = ' r.status IN ('. $condition['status'] .')';

		$data = $Q->find();

		foreach ($data['list'] as $key => &$value) {
			$value['status_txt'] = $this->getStatusTxt($value['status']);
		}
		return $data;
	}

	public function getdetail($id){

		$res = array();
		if (intval($id) > 0) {
			$Q = new Query($this->tableName . ' as r');
			$Q->join = ' LEFT JOIN user as u ON r.uid=u.id';
			$Q->fields = 'r.*, u.username';
			$Q->where = ' r.id = :id';
			$Q->bind = array('id' => $id);

			$res = $Q->getObj();
			$res['status_txt'] = $this->getStatusTxt($res['status']);
			$res['ident_img_orig'] = Thumb::getOrigImg($res['ident_img']);
			$res['apply_img_orig'] = Thumb::getOrigImg($res['apply_img']);
			$res['ident_img'] = Thumb::get($res['ident_img'], 150,150);
			$res['apply_img'] = Thumb::get($res['apply_img'], 150,150);
		}

		return $res;
	}



}