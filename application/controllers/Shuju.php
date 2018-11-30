<?php

/**
 * 数据页控制器
 */
use \nainai\category\ArcType;
use Library\safe;
use \nainai\article;
use \nainai\system\slide;
class ShujuController extends InitController {
	
	public function init(){
		parent::init();
		$this->article = new article();
	}

	//数据页展示
	public function indexAction(){
		//类型id
		$type = safe::filter($this->_request->getParam('type'));
		if($type){
			$model = new ArcType();
			$list = $model->typelist();

			$children = $model->typeFlow($list,$type);
			foreach ($children as $key => $value) {
				//主体数据
				$data[$value['id']] = $this->article->arcList(1,array('type'=>$value['id']),'','',6);
			}
			//侧边栏数据
			$main_data = $this->article->arcList(1,array('type'=>$type));
			$this->getView()->assign('data',$data);
			$this->getView()->assign('main_data',$main_data);

			// var_dump($children);
			$this->getView()->assign('type',$children);
		}
	}
}