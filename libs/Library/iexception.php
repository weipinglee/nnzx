<?php
/**
 * @file exception_class.php
 * @brief 异常处理
 * @author 
 * @date 2011-07-22
 * @version 0.1
 */
namespace Library;
class IException extends \Exception
{
	private static $logPath = false;
	private static $debugMode = false;

	/**
	 * 构造函数
	 * @param string $message
	 * @param mixed $code
	 */
	public function __construct($message = null, $code = 0)
	{
		$bt = debug_backtrace();
		$info = reset($bt);
		if($info !== false)
		{
			$this->message = $message;
			$this->code = $code;
			$this->file = $info['file'];
			$this->line = $info['line'];
		}
		$this->backtrace = $bt;
	}

	/**
	 * 直接输出异常信息，不用catch
	 */
	public static function phpException($e)
	{
		if( !($e instanceof IException) && $e instanceof \Exception  )
		{
			if( self::$debugMode )
			{
				echo $e->getMessage();
			}
			self::logError($e->getMessage());
			return;
		}
		$e->show();
	}

	public static function phpError($errno,$errstr,$errfile=false,$errline=false,$errcontext=false)
	{
		$errfile = self::pathFilter($errfile);
		$re  = "<ERROR_INFO>\n";
		$re .= "errID:{$errno}\n";
		$re .= "errStr:{$errstr}\n";
		$re .= "errFile:{$errfile}\n";
		$re .= "errLine:{$errline}\n";
		$re .= "errTime:".date("y-m-d H:i:s")."\n";
		$re .= "<\ERROR_INFO>\n";

		self::logError($re);
		if( self::$debugMode )
		{
			die($re);
		}
	}



	public function show()
	{
		$bt = $this->getTrace();
		$re = "<ERROR_INFO>\n";
		$re .= sprintf("Mess: %s\n",$this->getMessage());
		$re .= sprintf("Line: %s\n",$this->getLine());
		$re .= sprintf("File: %s\n",self::pathFilter( $this->getFile() ) );
		$re .= sprintf("##Debug_backtrace:##\n");
		foreach($bt as $value)
		{
			$value['file'] = isset($value['file']) ? self::pathFilter($value['file']) : '';
			$re .= sprintf("\tFunc:%-15s\tClass:%-15s\tType:%-5s\tLine:%-5s\tFile:%s\n" ,
				isset($value['function'])?$value['function']: "" ,
				isset($value['class'])?$value['class']:"",
				isset($value['type'])?$value['type']:"",
				isset($value['line'])?$value['line']:"",
				$value['file'] );
		}
		$re .= "</ERROR_INFO>\n";

		if( ! $this instanceof IHttpException )
			self::logError($re);

		if( self::$debugMode )
		{
			die($re);
		}
	}

	public static function setLogPath($path)
	{
		self::$logPath = $path;
	}

	public static function setDebugMode($mode)
	{
		self::$debugMode = $mode;
	}

	public static function logError($str)
	{
		if( self::$logPath)
		{
			$dir = dirname( self::$logPath  );
			if( !file_exists(self::$logPath) && !file_exists( $dir ) )
			{
				$b = mkdir($dir,0777,true);
				if(!$b)
				{
					return;
				}
			}
			$fp = fopen(self::$logPath,"ab");
			if($fp !== false)
			{
				fwrite($fp,$str);
			}
		}
	}
}


class IHttpException extends IException
{
	/**
	 * @brief 获取控制器
	 * @return object 控制器对象
	 */
	public function getController()
	{
		return IWeb::$app->controller;
	}

	/**
	 * @brief 报错 [适合在逻辑(非视图)中使用,此方法支持数据渲染]
	 * @param string $httpNum   HTTP错误代码
	 * @param array  $errorData 错误数据
	 */
	public function show()
	{
		$httpNum = $this->getCode();
		$errorData = $this->getMessage();
		$controller = $this->getController();

		//初始化页面数据
		$showData   = array(
			'title'   => null,
			'heading' => null,
			'message' => null,
		);

		if(is_array($errorData))
		{
			$showData['title']   = isset($errorData['title'])   ? $errorData['title']   : null;
			$showData['heading'] = isset($errorData['heading']) ? $errorData['heading'] : null;
			$showData['message'] = isset($errorData['message']) ? urlencode($errorData['message']) : null;
		}
		else
		{
			$showData['message'] = urlencode($errorData);
		}

		//检查用户是否定义了error处理类
		$config = isset( IWeb::$app->config['exception_handler'] ) ? IWeb::$app->config['exception_handler'] : 'Error' ;
		$flag = class_exists($config);
		if( $flag && method_exists($config,"error{$httpNum}") )
		{
			$errorObj = new $config(IWeb::$app,'error');
			call_user_func(array($errorObj,'error'.$httpNum),$errorData);
		}
		//是系统内置的错误机制
		else if(file_exists(IWEB_PATH.'web/view/'.'error'.$httpNum.$controller->extend))
		{
			$controller->render(IWEB_PATH.'web/view/'.'error'.$httpNum,$showData);
		}
		//输出错误信息
		else
		{
			$controller->renderText($showData['message']);
		}
		exit;
	}
}

