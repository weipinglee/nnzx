<?php

/**
 * 耐耐观点
 */
use \nainai\category\ArcType;
use Library\safe;
use \nainai\Article;
use \nainai\category\ArcCate;
use \nainai\system\slide;
class GuandianController extends InitController {
	
	public function init(){
		parent::init();
		$this->article = new Article();
	}

	//观点页展示
	public function indexAction(){
		$page = safe::filterget('page','int',1);
		$type = safe::filter($this->_request->getParam('type'));
		if($type){
			$where = array('type'=>$type,'recommend'=>0,'include_child'=>1);
			//主体内容列表
			$data = $this->article->arcList($page,$where,'','',5);
			$this->getView()->assign('data',$data[0]);
			$this->getView()->assign('pageBar',$data[1]);
			
			$where['recommend'] = 1;
			//推荐观点列表
			$recommend_list = $this->article->arcList($page,$where,'','',6);
			$this->getView()->assign('recommend_list',$recommend_list[0]);
			// var_dump($children);
			$this->getView()->assign('type',$type);
			// echo '<pre>';var_dump($data);
		}
	}
}