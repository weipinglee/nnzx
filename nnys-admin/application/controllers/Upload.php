<?php
/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
use \Library\photoupload;
use \Library\json;
use \Library\Session;
use \Library\adminrbac\rbac;
class UploadController extends InitController {


/**
	 * ajax上传图片
	 * @return bool
	 */
	public function uploadAction(){
		
		//调用文件上传类
		$photoObj = new photoupload();
		$photoObj->setThumbParams(array(180,180));
		$photo = current($photoObj->uploadPhoto());

		if($photo['flag'] == 1)
		{
			$result = array(
				'flag'=> 1,
				'img' => $photo['img'],
				'thumb'=> $photo['thumb'][1]
			);
		}
		else
		{
			$result = array('flag'=> $photo['flag'],'error'=>$photo['errInfo']);
		}
		echo JSON::encode($result);

		return false;
	}

}