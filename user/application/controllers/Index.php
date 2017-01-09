<?php
/**
 * 用户中心
 * User: weipinglee
 * Date: 2016/3/4 0004
 * Time: 上午 9:35
 */
use \Library\checkRight;
use \Library\photoupload;
use \Library\json;
use \Library\url;
use \Library\safe;
use \Library\Thumb;
use \Library\tool;
use \Library\PlUpload;
use \Library\Captcha;

class IndexController extends UcenterBaseController {


    /**
     * 个人中心首页
     */
    public function indexAction(){
		  header('Location:'.url::createUrl('/ucenterindex/index'));
    }
    

    public function testAction(){
    	json::encode(tool::getSuccInfo(1,'hello,world'));
    }

}