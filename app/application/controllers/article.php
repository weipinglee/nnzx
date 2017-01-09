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
class ArticleController extends AppBaseController{

	protected function init(){
		parent::init();
		$this->article = new \nainai\Article();
	}
	
	//文章列表
	public function arcListAction(){
		$page = safe::filterPost('page','int');
		$user_id = safe::filterPost('user_id','int');
		$cate_id = safe::filterPost('id','int');
		$keyword = safe::filterPost('keyword','trim');
		
		$where = array('is_del'=>0);
		if($cate_id>0) $where = array_merge($where,array('cate_id'=>$cate_id));
		if($keyword){
			if(strpos($keyword,' ')){
				$keyword = explode(' ', $keyword);
			}else{
				$keyword = array($keyword);
			}
			$where = array_merge($where,array('name' => array($keyword,'like')));
		}
		
		$arcList = $this->article->arcList($page,$where,'a.id,a.name,a.create_time,a.user_id,a.type',$user_id,0,DEVICE_TYPE);
		foreach ($arcList as $key => &$value) {
			$value['create_time'] = date('y/m/d H:i',strtotime($value['create_time']));
		}
		die(json::encode(tool::getSuccInfo(1,$arcList)));
	}

	public function arcInfoAction(){
		$article_id = safe::filterPost('id','int');
		$arcInfo = $this->article->arcInfo($article_id);
		die(json::encode(tool::getSuccInfo(1,$arcInfo)));
	}

}