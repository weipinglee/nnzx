<?php

/**
 * 行业内容
 */
use \nainai\category\ArcType;
use Library\safe;
use \nainai\Article;
use \nainai\category\ArcCate;
class HangyeController extends InitController {
	
	public function init(){
		parent::init();
		$this->article = new Article();
	}

	//行业页展示
	public function indexAction(){
		$page = safe::filterget('page','int',1);
		$type = safe::filter($this->_request->getParam('type'));
		$id = safe::filter($this->_request->getParam('id'),'int',0);
		if($type){
			$where = array('type'=>$type,'include_child'=>1);
			if($id) $where['cate_id'] = $id;
			//主体内容列表
			$main_data = $this->article->arcList($page,$where,'','',5);

			$catemodel = new ArcCate();
			$catelist = $catemodel->cateList(0,0,'pc',array('pid'=>0));
			
			$model = new ArcType();
			$list = $model->typelist();
			$children = $model->typeFlow($list,$type);
			
			//右侧边栏显示内容
			foreach ($children as $key => $value) {
				$tmp = $this->article->arcList(1,array('type'=>$value['id']),'','',6);

				$data[] = $tmp[0];
			}
			
			$this->getView()->assign('main_data',$main_data[0]);
			
			$this->getView()->assign('data',$data);
			$this->getView()->assign('cates',$catelist);
			$this->getView()->assign('pageBar',$main_data[1]);
			$this->getView()->assign('type',$children);
			$this->getView()->assign('id',$id);
			// echo '<pre>';var_dump($data);
		}
	}
}