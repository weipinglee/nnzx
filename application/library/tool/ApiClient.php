<?php
namespace  tool;
class ApiClient
{
	private static $signs = array(
		'csacascdasdasdasdw22',
	);
	public $server;
	
	private $callBack;
	private $callNum=0;
	public function __construct($server)
	{
		$this->server = $server;
	}
	
	/**
	 * 取得签名
	 * @param  $params 接口调用时的参数
	 */
	protected function getSign($params)
	{
		ksort($params);
		$signStr = '';
		foreach($params as $key => $val)
		{
			if(empty($val)) continue;
			$signStr .= $key.'='.$val.'&';
		}
		$signStr = rtrim($signStr,'&');
		return md5($signStr.self::$signs[mt_rand(0,count(self::$signs)-1)]);
	}
	/**
	 * 调用服务端接口
	 * @param  $server		Api server
	 * @param  $api			接口
	 * @param  $params		参数
	 * @param  $callBack	回调
	 * @param  $openSign	开启签名
	 */	
	public function call($api,$params,$callBack=null,$openSign=true)
	{
		if($openSign){
			$params['sign'] = $this->getSign($params);
		}
		if($callBack === null){
			$client = new \Yar_Client($this->server);
			return $client->$api($params);
		}
		$this->callNum ++;
		$this->callBack = $callBack;
		return \Yar_Concurrent_Client::call($this->server,$api,$params,array($this, 'ApiClientCallBack'));
	}
	/**
	 * 执行并发调用
	 */
	public function loop()
	{
		return \Yar_Concurrent_Client::loop(); 
	}
	
	/**
	 * 注册魔术方法
	 * @param  $method
	 * @param  $params
	 */
	public function __call($method,$params)
	{
		$params = current($params);
		$params['sign'] = $this->getSign($params);
		$client = new \Yar_Client($this->server);
		return $client->$method($params);
	}
	
	/**
	 * 并发调用回调
	 * @param  $retval
	 * @param  $callinfo
	 */
	public function ApiClientCallBack($retval,$callinfo)
	{
		if($callinfo === null){
			return $this->callBack($retval,$callinfo);
		}
		static $data = array();
		$data[$callinfo['method']] = $retval;
		if(count($data) == $this->callNum){
			$fn = $this->callBack;
			return $fn($data,$callinfo);
		}
	}
}