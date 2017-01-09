<?php
/**
 * 信誉值配置项模型
 */
namespace config;
use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\Thumb;
class ConfcreditModel{

	//模型对象实例
	private $confcredit;
	public function __construct(){
		$this->confcredit = new M('configs_credit');
	}
	/**
	 * 会员分组规则
	 * @var array
	 */
	protected $confcreditRules = array(
		array('name','/^[a-zA-Z_]{2,30}$/','配置名格式错误',0,'regex'),
		array('name_zh','/^[\x{4e00}-\x{9fa5}]+$/u','中文配置名格式错误',0,'regex'),
		array('type','/^[0|1]$/','配置类型格式错误',0,'regex'),
		array('sign','/^[0|1]$/','处理方式格式错误',0,'regex'),
		array('value','double','参数值格式错误',0,'regex'),
		array('note','/^\W{0,100}$/','配置解释格式错误',0,'regex'),
		// array('create_time','date','创建时间格式错误',1,'regex'),
	);

	/**
	 * 获取用户角色分组列表
	 * @param  int $page 当前页index
	 * @return array
	 */
	public function getList($page){
		$Q = new Query('configs_credit');
		$Q->page = $page;
		$Q->pagesize = 5;

		$Q->order = "sort asc";

		$data = $Q->find();
		$pageBar =  $Q->getPageBar();
		return array('data'=>$data,'bar'=>$pageBar);
	}
	
	/**
	 * 新增或编辑
	 * @param  array 操作数据数组
	 * @return mixed
	 */
	public function confcreditUpdate($data){
		$confcredit = $this->confcredit;
		if($confcredit->data($data)->validate($this->confcreditRules)){
			if(isset($data['ori_name'])){
				$ori_name = $data['ori_name'];
				if(isset($data['name']) && $data['name'] != $ori_name && $this->existconfcredit(array('name'=>$data['name'])))
					return tool::getSuccInfo(0,'配置名已存在');

				//编辑
				unset($data['ori_name']);
				$res = $confcredit->where(array('name'=>$ori_name))->data($data)->update();
				$res = is_int($res) && $res>0 ? true : ($confcredit->getError() ? $confcredit->getError() : '数据未修改');
			}else{
				if(isset($data['name']) && $this->existconfcredit(array('name'=>$data['name'])))
					return tool::getSuccInfo(0,'配置名已存在');
				$confcredit->beginTrans();
				$aid = $confcredit->add();
				$res = $confcredit->commit();
			}
		}else{
			$res = $confcredit->getError();
		}
	
		
		if($res===true){
			$log = new \Library\log();
			$log->addLog(array('table'=>'信誉参数配置','type'=>'update','id'=>$data['name'],'pk'=>'name'));
			$resInfo = tool::getSuccInfo();
		}
		else{
			$resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;
	}

	/**
	 * 验证配置名是否已存在
	 * @param array $confcreditData 配置数据
	 * @return bool  存在 true 否则 false
     */
	public function existconfcredit($confcreditData){
		$data = $this->confcredit->fields('name')->where($confcreditData)->getObj();
		if(empty($data))
			return false;
		return true;
	}

	/**
	 * 根据name获取配置项信息
	 * 
	 * @param  string $name 
	 * @return array  信息
	 */
	public function getconfcreditInfo($name){
		$info = $this->confcredit->where(array('name'=>$name))->getObj();
		return $info ? $info : array();
	}

	/**
	 * 删除
	 * @param  string $name 
	 */
	public function creditDel($name){
		$confcredit = $this->confcredit;
		if(($name = trim($name))){
			try {
				$confcredit->beginTrans();

				$confcredit->where(array('name'=>$name))->delete();

				$res = $confcredit->commit();
			} catch (PDOException $e) {
				$confcredit->rollBack();
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