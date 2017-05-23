<?php

/**
 * 点击’更多‘跳转列表页
 */
use \nainai\category\ArcType;
use Library\safe;

use \nainai\Article;
use \nainai\category\ArcCate;
class MoreController extends InitController {
	
	public function init(){
		parent::init();
		$this->article = new Article();
	}

	//'更多'列表页展示
	public function indexAction(){
		$page = safe::filterget('page','int',1);
		$type = safe::filter($this->_request->getParam('type'));//文章类型id
		$id = safe::filter($this->_request->getParam('id'),'int',0);//分类id
		if($type){

			$model = new ArcType();
			$ptype = $model->parentType($type);

			$list = $model->typelist();
			$list = $model->typeFlow($list,$ptype);
			$where = array('include_child'=>1);
			if($id) $where['cate_id'] = $id;
			foreach ($list as $key => $value) {
				$where ['type'] = $value['id'];
				if($value['id'] != $type){
					//主体内容
					$data[] = array_merge($this->article->arcList(1,$where,'','',5),array('name'=>$value['name'],'id'=>$value['id']));
					// $data[]['name'] = $value['name'];
				}else{
					//侧边栏数据
					$main_data = $this->article->arcList($page,$where,'','',5);
					$bread = $value['name'];
				}
			}
			$catemodel = new ArcCate();
			$catelist = $catemodel->cateList(0,0,'pc',array('pid'=>0));
			$this->getView()->assign('cates',$catelist);
			// echo '<pre>';var_dump($data);exit;
			$this->getView()->assign('data',$data);
			$this->getView()->assign('main_data',$main_data[0]);
			$this->getView()->assign('pageBar',$main_data[1]);
			

			// var_dump($children);
			$this->getView()->assign('type',$type);
			$this->getView()->assign('id',$id);
			$this->getView()->assign('bread',$bread);
			// echo '<pre>';var_dump($data);
		}
	}
}