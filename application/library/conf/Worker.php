<?php
/**
 *  Worker 配置
 *  @date 2015-8-6
 *  @author zhengyin <zhengyin@kongfz.com>
 *  [DESC]
 *  	配置系统Worker启动数，脚本路径，执行命令等
 */
namespace conf;
final class Worker{
	public static $data = array(
			
			'message'=>array(
				'process'=>'request_uri=/cli/Message/run',
				'num'=>'10',
				'log'=> 'message.log'
			),
			
	);
}