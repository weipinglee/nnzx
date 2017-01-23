<?php
namespace Library;
class photoupload{

	private $thumbWidth  = array();  //缩略图宽度
	private $thumbHeight = array();  //缩略图高度
	private $thumbKey    = array();  //缩略图返回键名

	private $dir = 'upload';

	//构造函数
	function __construct($dir = '')
	{
		//设置默认路径地址
		if($dir == '')
		{
			$dir = $this->hashDir();
		}

		$this->setDir($dir);
	}

	/**
	 * @brief 获取图片散列目录
	 * @return string
	 */
	public  function hashDir()
	{
		$dir = $this->dir.'/'.date('Y/m/d');
		return $dir;
	}

	/**
	 * @brief 设置上传的目录
	 * @param string $dir
	 */
	public function setDir($dir)
	{
		$this->dir = $dir;
	}
	/**
	* @brief 生成$fileName文件的缩略图,位置与$fileName相同
	* @param string  $fileName 要生成缩略图的目标文件
	* @param int     $width    缩略图宽度
	* @param int     $height   缩略图高度
	* @param string  $extName  缩略图文件名附加值
	* @param string  $saveDir  缩略图存储目录
	*/
	public static function thumb($fileName,$width,$height,$extName = '_thumb',$saveDir = '')
	{
		return Thumb::get($fileName,$width,$height);
	}


	/**
	 * 设置缩略图参数
	 * @param array $arr array(array(witdh,height),array()) or array(width,height)
     */
	public function setThumbParams($arr){
		if(is_array($arr) && !empty($arr)){
			foreach ($arr as $key=>$val) {
				if(is_array($val)){
					$this->thumbWidth[] = $arr[$key][0];
					$this->thumbHeight[] = $arr[$key][1];
					$this->thumbKey[] = $key;
				}
				else {
					$this->thumbWidth[] = $arr[0];
					$this->thumbHeight[] = $arr[1];
					$this->thumbKey[] = 1;
					break;
				}
			}

		}
	}

	/**
	* 图片上传
	* @param boolean $isForge 是否伪造数据提交
	*/
	public function uploadPhoto($isForge = false){
		//图片上传
		$filesize =\Library\tool::getConfig(array('application','uploadsize'));
		if(!$filesize)
			$filesize = 2048;
		$upObj = new Upload($filesize,array('jpg','gif','png','jpeg'));

		$upObj->isForge = $isForge;
		$upObj->setDir($this->dir);
		$upState = $upObj->execute();
		//检查上传状态
		foreach($upState as $key => $rs)
		{
			if(count($_FILES[$key]['name']) > 1)
			$isArray = true;
			else
			$isArray = false;
			foreach($rs as $innerKey => $val)
			{
				if($val['flag']==1)
				{
					//上传成功后图片信息
					$fileName = $val['dir'].$val['name'];

					$rs[$innerKey]['img'] = $fileName;
					$rs[$innerKey]['name'] = $val['name'];

					if($this->thumbWidth && $this->thumbHeight && $this->thumbKey)
					{
						//重新生成系统中不存在的此宽高的缩略图
						foreach($this->thumbKey as $thumbKey_key => $thumbKey_val)
						{
						$thumbExtName = 'thumb_'.$this->thumbWidth[$thumbKey_key].'_'.$this->thumbHeight[$thumbKey_key];
						$thumbName    = $this->thumb($fileName,$this->thumbWidth[$thumbKey_key],$this->thumbHeight[$thumbKey_key],$thumbExtName,'thumb');
						$rs[$innerKey]['thumb'][$this->thumbKey[$thumbKey_key]] = $thumbName;
						}
					}
				}
				else{
					$rs[$innerKey]['errInfo'] = upload::errorMessage($val['flag']);
				}

				if($isArray == true)
				{
					$photoArray[$key] = $rs;
				}
				else
				{
					$photoArray[$key] = $rs[0];
				}
			}
		}
		return $photoArray;

	}

}