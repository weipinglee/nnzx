<?php

use \Library\json;
use \Library\url;
use \Library\Safe;
use \Library\Thumb;
use \Library\tool;
use \Library\PlUpload;
use \nainai\offer\product;
use \nainai\offer\PurchaseOffer;
/**
 * 保险管理
 * @author maoyong
 * @copyright 2016-07-19
 */
class CategoryController extends AppBaseController{

	protected function init(){
		parent::init();
		$this->cate = new \nainai\category\ArcCate();
	}
	
	//分类滑动列表
	public function cateListAction(){
		$page = safe::filterPost('page','int');
		$user_id = safe::filterPost('user_id');
		$cateList = $this->cate->cateList($page,$user_id,DEVICE_TYPE,array('pid'=>0),'c.id,c.name');
		array_unshift($cateList,array('id'=>0,'name'=>'推荐'));
		die(json::encode(tool::getSuccInfo(1,$cateList)));
	}

	

}