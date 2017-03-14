<?php
use \nainai\system\slide;
use \nainai\category\ArcType;
use Library\safe;
use \nainai\Article;
use \nainai\category\ArcCate;
class IndexController extends InitController {
	
	public function init(){
		parent::init();
		$this->article = new Article();
	}

	public function indexAction(){
		$type = new ArcType();
		$typelist = $type->typelist(0,'pc',array('pid'=>0));
		$where = array('type'=>$typelist[0]['id'],'include_child'=>1);
		$page = safe::filterGet('page','int',1);
		$main_data = $this->article->arcList($page,$where,'','',10);	
		foreach ($typelist as $key => $value) {
			if($key == 0) continue;
			$where['type'] = $value['id'];
			$data[]= array_merge($this->article->arcList(1,$where,'','',4),array('name'=>$value['name'],'id'=>$value['id']));
		}
		// echo '<pre>';var_dump($data);
		$this->getView()->assign('data',$data);
		$this->getView()->assign('main_data',$main_data);

	}
}