<?php
use \nainai\category\ArcType;
use Library\safe;
use \nainai\Article;
use \nainai\category\ArcCate;
class HangyeController extends InitController {
	
	public function init(){
		parent::init();
		$this->article = new Article();
	}

	public function indexAction(){
		$page = safe::filterget('page','int',1);
		$type = safe::filter($this->_request->getParam('type'));
		$id = safe::filter($this->_request->getParam('id'),'int',0);
		if($type){
			$where = array('type'=>$type,'include_child'=>1);
			if($id) $where['cate_id'] = $id;
			$data = $this->article->arcList($page,$where,'','',5);
			$catemodel = new ArcCate();
			$catelist = $catemodel->cateList(0,0,'pc',array('pid'=>0));

			
			$this->getView()->assign('data',$data[0]);
			$this->getView()->assign('cates',$catelist);
			$this->getView()->assign('pageBar',$data[1]);
			
			// var_dump($children);
			$this->getView()->assign('type',$type);
			$this->getView()->assign('id',$id);
			// echo '<pre>';var_dump($data);
		}
	}
}