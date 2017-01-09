<?php
/**
 * author:weipinglee
 * @date 2016-5-20
 * 模型基类
 *
 */
use \Library\M;
use \Library\Query;
use \Library\tool;
class baseModel{

	protected $pk  = 'id';
	protected $table = '';
	protected $rules = array();
	protected $where = '';
	protected $model = '';

	protected $log = '';

	public function __construct($obj=''){
		$this->log = new \Library\log();
		if($obj!='')
			$this->model = $obj;
	}
	/**
	 *
	 * @param string $table
	 */
	public function getRules($table=''){
		return $this->rules;
	}

	public function getTable($table=''){
		if($table=='')
			return $this->table;
		else return $this->table[$table];
	}

	public function setTable($table){
		$this->table = $table;
	}

	public function where($where){
		$this->where = $where;
		return $this;
	}
	/**
	 * [__call 默认或调用CRUD的操作，最好以add，get，update，delete开头的方法名称]
	 * @param  [Array] $method [方法名称]
	 * @param  [Array] $args   [参数]
	 * @return [mixed]         [根据对应操作返回对应数据]
	 */
	public function __call($method, $args){
		$methodArr = preg_split("/(?=[A-Z])/", $method);
		if(!isset($methodArr[1])){
			$methodArr[1] = '';
		}
		if($this->model!=''){
			$model = $this->model;
			$tableName = $model->table();
		}
		else{
			$tableName = $this->getTable(strtolower($methodArr[1]));
			$model = new M($tableName);
		}

		$log  = array();
		$log['table'] = $tableName;
		$model->beginTrans();
		$rules = $this->getRules(strtolower($methodArr[1]));
		$args = $args[0];
		switch ($methodArr[0]) {
			case 'add':
				$res = null;
				if ($model->validate($rules, $args)) {
					$new_id = $model->data($args)->add();
					$res = $new_id ? 1 : 0;
					$log['type'] = 'add';
					$log['id'] = $new_id;
				}else{
					$res = $model->getError();
				}
			break;
			case 'update':
				if($model->validate($rules,$args)){
					if($this->where!=''){
						$log['content'] = '更新了数据表'.$tableName;
						$res = $model->data($args)->where($this->where)->update() ;
					}
					else if(isset($args[$this->pk]) && $args[$this->pk]>0){//存在主键且大于0则更新
						$id = $args[$this->pk];
						unset($args[$this->pk]);
						$res = $model->data($args)->where($this->pk . '=:id')->bind(array('id'=>$id))->update() ;
						$log['type'] = 'update';
						$log['id'] = $id;
					}
					else{
						$new_id =  $model->data($args)->add();
						$res = $new_id ? 1:0;
						$log['type'] = 'add';
						$log['id'] = $new_id;
					}
				}else{
					$res = $model->getError();
				}
			break;

			case 'delete'://删除数据
				$log['type'] = 'delete';

				if(!is_array($args)){
					$log['id'] = $args;
					$res =  $model->where($this->pk . '=:id')->bind(array('id'=>$args))->delete();
				}
				else{
					$res =  $model->where($args)->delete();
				}
			break;

			case 'get'://获取一条数据
				if (intval($args) > 0) {
					return $model->where($this->pk . '=:id')->bind(array('id'=>$args))->getObj();
				}
				return array();
				break;

			default:
				throw new Exception("Unknow Method", 1);exit();
				break;
		}

		//插入更新删除返回提示
		if(is_int($res)){
			$logObj = new \Library\log();
			$logObj->addLog($log);
			$res = $model->commit();
			if($res===true){
				return tool::getSuccInfo();
			}
			else
				return tool::getSuccInfo(0,'操作失败');

		}
		else{
			$model->rollBack();
			return tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}

	}






}