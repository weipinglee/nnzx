<?php
/**
 * @brief 动态生成缩略图类
 */
namespace Library;

class Thumb
{
	//缩略图路径
	public static $thumbDir = "_thumb";

	/**
	 * @brief 获取缩略图物理路径
	 */
	public static function getThumbDir()
	{

		return self::$thumbDir;
	}

	/**
	 * @brief 生成缩略图
	 * @param string $imgSrc 图片路径
	 * @param int $width 图片宽度
	 * @param int $height 图片高度
	 * @return string WEB图片路径名称
	 */
    public static function get($imgSrc,$width=100,$height=100)
    {
    	if($imgSrc == '')
    	{
    		return '';
    	}

		//商品物理实际路径
		$imgArr = explode('@',$imgSrc);
		$preThumb      = "{$width}_{$height}_";
		if(count($imgArr)>1){
			$sourcePath = tool::getGlobalConfig(array('rootDir',$imgArr[1])).'/'.trim($imgArr[0],'/');
			// var_dump(tool::getGlobalConfig(array('rootDir','admin')));exit;
			$thumbFileName = $preThumb.basename($imgArr[0]);//缩略图文件名
			$url = url::getConfigHost($imgArr[1]);
			$cur_url = url::getBaseUrl();

			// if(strpos($cur_url, 'nzgw') !== false){
			// 	$url = 'http://info.nainaiwang.com/nzgw/nnys-admin';
			// }
		}else{
			$sourcePath = trim($imgSrc,'/');
			$thumbFileName = $preThumb.basename($imgSrc);
			$url = url::getBaseUrl();
		}
		//缩略图目录
		$thumbDir    = self::getThumbDir().'/';
		
		$webThumbDir = self::$thumbDir.'/';
		// var_dump($sourcePath);
		// var_dump(is_file($sourcePath));exit;
		if(is_file($thumbDir.$thumbFileName) == false && is_file($sourcePath))
		{
			Image::thumb($sourcePath,$width,$height,$preThumb,$thumbDir);
		}
		return $url.'/'.$webThumbDir.$thumbFileName;
    }

	/**
	 * 获取原图地址
	 * @param $imgSrc
	 * @return string
	 */
	public static function getOrigImg($imgSrc,$make=1){
		if($imgSrc=='')
			return '';
		$imgArr = explode('@',$imgSrc);
		if(count($imgArr)>1){
			$sourcePath = tool::getGlobalConfig(array('host',$imgArr[1])).'/'.trim($imgArr[0],'/');

		}else{
			$sourcePath = url::getBaseUrl().'/'.trim($imgSrc,'/');
		}
//		if($make==1){
//			$imgData = getimagesize($sourcePath);
//			return self::get($imgSrc,$imgData[0],$imgData[1]);
//		}

		return $sourcePath;
	}

}
?>
