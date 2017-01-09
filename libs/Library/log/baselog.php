<?php
/**
 * @class log
 * @brief 日志记录类
 */
namespace Library\log;
use \Library\time;
use \Library\Client;
use \Library\M;
class baselog
{

	private $logType = 'db';//默认日志类型
	private $log     = null;
	private $logInfo = array(
		'error'     => array('table' => 'log_error',    'cols' => array('file','line','content')),
		'sql'       => array('table' => 'log_sql',      'cols' => array('content','runtime')),
		'operation' => array('table' => 'admin_log','cols' => array('action','content')),
	);
	protected $tableName = 'admin_log';

	protected $childAuthor = false;

	//获取日志对象
	public function __construct($logType = 'db')
	{
		$this->logType = $logType;
    	$this->log = ILogFactory::getInstance($logType);
		$this->setLogTable($this->tableName);
	}

	public function setLogTable($tableName){
		$this->logInfo['operation']['table'] = $tableName;
	}

	//写入日志
	public function write($type,$logs = array())
	{
		$logInfo = $this->logInfo;
		if(!isset($logInfo[$type]))
		{
			return false;
		}

		switch($this->logType)
		{
			//文件日志
			case "file":
			{
				//设置路径
				$path     = 'log';
				$fileName = rtrim($path,'\\/').'/'.$type.'/'.date('Y/m').'/'.date('d').'.log';
				$this->log->setPath($fileName);

				$logs     = array_merge(array(Time::getDateTime()),$logs);
				return $this->log->write($logs);
			}
			break;

			//数据库日志
			case "db":
			{
				$content['datetime'] = time::getDateTime();
				$content['ip'] = Client::getIp();
				$content['author'] = $this->getAuthor();
				if($this->childAuthor)
					$content['child'] = $this->getChildAuthor();
				$tableName           = $logInfo[$type]['table'];

				foreach($logInfo[$type]['cols'] as $key => $val)
				{
					if(isset($logs[$val])){
						$content[$val] = $logs[$val];
					}
					else if(isset($logs[$key])){
						$content[$val] = $logs[$key];
					}
					else $content[$val] = '';
				}

				$this->log->setTableName($tableName);
				return $this->log->write($content);
			}
			break;

			default:
			return false;
			break;
		}
	}

	/**
	 * 添加后台操作日志
	 * @param array $logs
	 * 参数说明：
	 * array(
	 * 'id'=>$user_id,//计入日志的id(必填)
	 * 'check_text'=>'',//后台审核结果文字
	 * 'table'=>$table,//操作的数据表(必填)
	 * 'type'=>'',//取值为：add,update,delete,logicdel(逻辑删除),check(审核),(必填)
	 * 'pk'=>'user_id',//主键
	 * 'field'=>'',//将id转换成的字段
	 * 'action'=>'',//如果存在此字段，直接计入action
	 * 'content'=>''//如果存在此字段，直接计入content，（如果填入此字段，id，table,type不填）
	 * )
	 */
	public function addLog($args){
		//根据参数获取action和content
		$logs = array('action'=>'','content'=>'');
		//获取动作
		if(isset($args['action']) && $args['action']!='')
			$logs['action'] = $args['action'];
		else{//如果没有传递action,获取调用日志文件的类方法
			$class = debug_backtrace();
			foreach($class as $key=>$val){
				if(isset($val['function']) && isset($val['class']) && false !==strpos($val['function'],'Action') && false !==strpos($val['class'],'Controller')){
					$logs['action'] = str_replace('Controller','',$val['class']).'_'.str_replace('Action','',$val['function']);
					$logs['action'] = strtolower($logs['action']);
					break;
				}
			}
		}

		//获取content
		if(isset($args['content']) && $args['content']!='')//如果存在content,直接使用该值
			$logs['content'] = $args['content'];
		else{
			$pk = isset($args['pk'])?$args['pk']:'id';
			$pk_text = isset($args['id']) && $args['id']>0 ? $pk.'为'.$args['id'].'的' : '';
			if(isset($args['id']) && isset($args['field']) && $args['field']!=''){//存在映射字段
				$obj = new M($args['table']);
				$f = $obj->where(array($pk=>$args['id']))->getField($args['field']);
				if($f){
					$pk_text = $args['field'].'为'.$f.'的';
				}
			}
			$status_text = isset($args['check_text'])? $args['check_text'] : '';
			$content = $this->typeText[$args['type']].$pk_text.$this->getTableName($args['table']).$status_text;

			$logs['content'] = $content;
		}

		$this->write('operation',$logs);

	}

	/**
	 * 获取表名
	 * @param $table
	 * @return array
	 */
	protected function getTableName($table){
		$data = \Library\log\table::get();
		if(isset($data[$table]))
			return $data[$table];
		return $table;
	}

	protected $typeText = array(
		'add'=>'新增了',
		'update'=>'更新了',
		'delete'=>'删除了',
		'logicdel' => '删除了',
		'check'    => '审核',
	);

	protected function getChildAuthor(){
		return 0;
	}
}