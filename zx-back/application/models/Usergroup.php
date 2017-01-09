<?php
/**
 * 会员角色分组
 */

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\Thumb;
class UsergroupModel{

	//模型对象实例
	private $usergroup;

	protected $table = 'user_group';
	public function __construct(){
		$this->usergroup = new M($this->table);
	}
	/**
	 * 会员分组规则
	 * @var array
	 */
	protected $usergroupRules = array(
		array('id','number','id错误',0,'regex'),
		array('group_name','/^\S{2,20}$/','分组名格式错误',0,'regex'),
		array('credit','number','信誉值分界线格式错误',0,'regex'),
		array('caution_fee','/^([1-9][0-9]?|100)$/','保证金比率格式错误',0,'regex'),
		array('free_fee','/^([1-9][0-9]?|100)$/','自由报盘费用比率格式错误',0,'regex'),
		//array('depute_fee','/^([1-9][0-9]?|100)$/','委托报盘手续费比率格式错误',0,'regex'),
		// array('create_time','date','创建时间格式错误',1,'regex'),
	);

	/**
	 * 获取用户角色分组列表
	 * @param  int $page 当前页index
	 * @return array
	 */
	public function getList($page){
		$Q = new Query('user_group');
		$Q->page = $page;
		$Q->pagesize = 5;
		$Q->order = "create_time desc";
		$data = $Q->find();
		$pageBar =  $Q->getPageBar();
		foreach ($data as $key => &$value) {
			if(isset($value['icon']))
				$value['icon_thumb'] = Thumb::get($value['icon'],180,180);
		}
		return array('data'=>$data,'bar'=>$pageBar);
	}
	
	/**
	 * 新增或编辑用户角色分组
	 * @param  array 操作数据数组
	 * @return mixed
	 */
	public function usergroupUpdate($data){
		$usergroup = $this->usergroup;
		$log = new \Library\log();
		if($usergroup->data($data)->validate($this->usergroupRules)){
			if(isset($data['id']) && $data['id']>0){
				$id = $data['id'];
				if(isset($data['group_name']) && $this->existUsergroup(array('group_name'=>$data['group_name'],'id'=>array('neq',$id))))
					return tool::getSuccInfo(0,'分组名已存在');

				//编辑
				unset($data['id']);
				$res = $usergroup->where(array('id'=>$id))->data($data)->update();
				$res = is_int($res) && $res>0 ? true : ($usergroup->getError() ? $usergroup->getError() : '数据未修改');
				$log->addLog(array('id'=>$id,'type'=>'update','table'=>$this->table));
			}else{
				if($this->existUsergroup(array('group_name'=>$data['group_name'])))
					return tool::getSuccInfo(0,'分组名已存在');
				$usergroup->beginTrans();
				$aid = $usergroup->add();


				$log->addLog(array('id'=>$aid,'type'=>'add','table'=>$this->table));

				//权限添加TODO
				$res = $usergroup->commit();
			}
		}else{
			$res = $usergroup->getError();
		}
	
		
		if($res===true){
			$resInfo = tool::getSuccInfo();
		}
		else{
			$resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;
	}

	/**
	 * 验证分组名是否已存在
	 * @param array $usergroupData 分组数据
	 * @return bool  存在 true 否则 false
     */
	public function existUsergroup($usergroupData){
		$data = $this->usergroup->fields('id')->where($usergroupData)->getObj();
		if(empty($data))
			return false;
		return true;
	}

	/**
	 * 根据id获取管理员信息
	 * 
	 * @param  int $id 管理员id
	 * @return array  管理员信息
	 */
	public function getusergroupInfo($id){
		$info = $this->usergroup->where(array('id'=>$id))->getObj();
		return $info ? $info : array();
	}

	/**
	 * 删除角色分组
	 * @param  int $id 角色分组id
	 */
	public function groupDel($id){
		$usergroup = $this->usergroup;
		if(($id = intval($id))>0){
			try {
				$usergroup->beginTrans();

				$usergroup->where(array('id'=>$id))->delete();

				$res = $usergroup->commit();
			} catch (PDOException $e) {
				$usergroup->rollBack();
				$res = $e->getMessage();
			}
			
		}else{
			$res = '参数错误';
		}

		if($res===true){
			$resInfo = tool::getSuccInfo();
		}
		else{
			$resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;		
	}
}