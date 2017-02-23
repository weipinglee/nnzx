<?php

namespace nainai\Abstruct;

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;

abstract class ModelAbstract{

	/**
	 * 表名
	 * @var null
	 */
	protected $tableName = null;

	/**
	 * 数据对象
	 * @var null
	 */
	protected $model = null;

	/**
	 * 验证规则
	 * @var array
	 */
	protected $Rules = array();

	/**
	 * 主键名
	 * @var string
	 */
	public $pk = 'id';

	/**
	 * 对象名称
	 * @var string
	 */
	protected $objName = '';

	/**
	 * 默认或创建当前类名转化为小写加_分割的对应数据库表名的数据库对象
	 */
	public function __construct(){
		if (is_null($this->tableName)) {
			$tableArr = preg_split("/(?=[A-Z])/", get_class($this));
			$tableName = '';
			$count = count($tableArr) - 1;

			foreach ($tableArr as $key => $value) {
				if ($key == 0) {
					continue;
				}

				$this->objName .= $value;

				if ($key == $count) {
					$tableName .= strtolower($value);
				}else{
					$tableName .= strtolower($value) . '_';
				}
			}

			$this->tableName = $tableName;
		}

		$this->model = new M($this->tableName);
	}

	/**
	 * [__call 默认或调用CRUD的操作，调用以add，get，update，delete加上类名的方法名称]
	 * @param  [Array] $method [方法名称]
	 * @param  [Array] $args   [参数]
	 * @return [mixed]         [根据对应操作返回对应数据]
	 */
	public function __call($method, $args){

		$methodArr = preg_split("/(?=[A-Z])/", $method);
		$operate = $methodArr[0];
		unset($methodArr[0]);

		if (implode('', $methodArr) != $this->objName) { //如果方法中的类名和类名不相等，就不掉用
			throw new \Exception("Unknow Method", 1);exit();
		}

		switch ($operate) {
			case 'add':
				$res = null;

				if ($this->model->validate($this->Rules, $args[0])) {
					$res = $this->model->data($args[0])->add(0);
				}else{
					$res = $this->model->getError();
				}
				
				if(intval($res) > 0){
					return Tool::getSuccInfo(1, $res);
				 }
				else{
						return Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
				 }
				break;
			case 'adds':
				$res = $this->model->data($args[0])->adds(0);
				
				if(intval($res) > 0){
					return Tool::getSuccInfo(1, $res);
				 }
				else{
						return Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
				 }
				break;


			case 'update':
			    	$res = null;
			    	if (intval($args[1]) > 0 && $this->model->validate($this->Rules, $args[0]))  {
			    		$res = $this->model->data($args[0])->where($this->pk . '=:id')->bind(array('id'=>$args[1]))->update();
			    	}else{
			    		$res = $this->model->getError();
			    	}

			    	if(intval($res) > 0 ){
			          	return Tool::getSuccInfo();
			         }
			        else{
			            	return Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
			         }

			    	return false;
				break;

			case 'delete':
				$res = null;
				if (!is_array($args[0]) && intval($args[0]) > 0) {
			    		$res = $this->model->where($this->pk . '=:id')->bind(array('id'=>$args[0]))->delete(0);

			    	}elseif (is_array($args[0])) {
			    		$condition = $args[0];
			    		$res = $this->model->where($condition['where'])->bind($condition['bind'])->delete(0);

			    	}
			    	if( ! is_null($res) ){
			          	return Tool::getSuccInfo();
			         }
			        else{
			            	return Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
			         }
				break;

			case 'get':
				$fields = isset($args[1]) ? $args[1] : '*';
				if (!is_array($args[0]) && intval($args[0]) > 0) {
					return $this->model->fields($fields)->where($this->pk . '=:id')->bind(array('id'=>$args[0]))->getObj();
			    }
				elseif (is_array($args[0])) {
					return $this->model->fields($fields)->where($args[0])->getObj();
				}
			    	return array();
				break;

			case 'insertupdate' : {
				if ($this->model->validate($this->Rules, $args[0])) {
					$res = $this->model->insertUpdate($args[0],$args[1]);
				}else{
					$res = $this->model->getError();
				}

				if(is_int($res))
					return Tool::getSuccInfo();
				else return Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');

			}
			break;
			case 'adds':
				$res = $this->model->data($args[0])->adds(0);
				
				if(intval($res) > 0){
					return Tool::getSuccInfo(1, $res);
				 }
				else{
						return Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
				 }
				break;
			
			default:
				throw new \Exception("Unknow Method", 1);exit();
				break;
		}
	}


}