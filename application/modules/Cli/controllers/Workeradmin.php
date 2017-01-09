<?php
/**
 *  Worker 管理脚本
 *  @date 2015-9-13 
 *  @author zhengyin <zhengyin.name@gmail.com>
 *  @blog http://izhengyin.com
 *  [DESC]
 *  	管理worker的启动，停止，重载等
 *  	执行方式: /opt/app/php-5.5/bin/php cli.php request_uri="/cli/WorkerAdmin/run/name/{name}/cmd/{cmd}"
 *  	 	  {name} 根据 conf\Worker 配置
 *  		  {cmd} start , restart stop 
 */
use conf\Worker;
class WorkerAdminController extends CliController{
	
	const PHP_BIN = '/opt/app/php-5.5/bin/php';
	
	private static $process;
	
	private static $log;
	
	private static $num;
	
	private static $cmds = array('start','restart','stop');
	
	private static $logDir = '';
	
	private static $cliPath = '';
	
	public function init(){
	
		parent::init();
		
		self::$logDir = '/tmp/process/';
		
		if(!is_dir(self::$logDir)){
			mkdir(self::$logDir,0777,true);
		}
		
		self::$cliPath = APPLICATION_PATH.'/cli/cli.php';
	}
	
	/**
	 * @param Array $argv
	*/
	public  function runAction(){
	
		$params = $this->getRequest()->getParams();
		
		$name = isset($params['name'])?$params['name']:'';
		$cmd = isset($params['cmd'])?$params['cmd']:'';
	
		//worker不存在
		if(!isset(Worker::$data[$name])){
			echo 'Worker:'.$name." not exists\n";
			echo chr(7);
			exit;
		}
		//取得相应的进程配置
		self::$process = self::$cliPath.' '.Worker::$data[$name]['process'];
		self::$num = Worker::$data[$name]['num'];
		self::$log = self::$logDir.Worker::$data[$name]['log'];
	
		
		//cmd 不正确
		if(!in_array($cmd, self::$cmds)){
			echo "usage: ".self::$process." ".implode('|', self::$cmds)." [num]\n";
			echo chr(7);
			exit;
		}
	
		self::$cmd();
		exit;
	}
	/**
	 * 启动
	 */
	private static function start(){
		if(self::$num<1){
			echo "start num is invalid\n";
			echo chr(7);
			exit;
		}else{
			for ($i=0;$i<self::$num;$i++){
				self::runWorker();
			}
			echo "start done\n";
		}
	}
	/**
	 * 重启
	 */
	private static function restart(){
		$count = 0;
		$pids = self::getWorkerPids();
		for($i=0;$i<count($pids);$i++){
			self::killWorker($pids[$i]);
			
			//杀掉老进程后，新启一个进程
			if($count <self::$num){
				self::runWorker();
			}
			
			$count++;
			
			//缓冲1秒，避免瞬间杀死worker后，照成脚本无法工作
			sleep(1);
		}
		//最后检查下，是否达到了需要的启动数量
		if($count <self::$num){
			for($n=0;$n<self::$num-$count;$n++){
				self::runWorker();
			}
		}
		echo "restart done\n";
	}
	/**
	 * 停止
	 */
	private static function stop(){
		$pids = self::getWorkerPids();
		for ($i=0;$i<count($pids);$i++){
			self::killWorker($pids[$i]);
			//缓冲1秒，避免瞬间杀死worker后，照成脚本无法工作
			sleep(1);
		}
		echo "stop done\n";
	}
	/**
	 * 运行一个 worker
	 */
	private static function runWorker(){
		$cmd = sprintf("%s %s >> %s &",self::PHP_BIN,self::$process,self::$log);
		echo $cmd.PHP_EOL;
		shell_exec($cmd);
	}
	/**
	 * 杀死一个 worker
	 */
	private static function killWorker($pid){
		`kill -9 $pid`;
		echo "kill {$pid} done \n";
	}
	/**
	* 获取正在运行的worker pid
	*/
	private static function getWorkerPids(){
	
		$cmd = 'ps aux | grep '.str_replace(self::$cliPath,'',self::$process).' | grep -v grep | grep -v WorkerAdmin | awk \'{print $2}\'';
		$result = shell_exec($cmd);
		$pids = array_filter(explode("\n", $result));
		return $pids;
	}
	
}