<?php
use \nainai\category\ArcType;
use Library\safe;
use \nainai\Article;
use \nainai\system\slide;
class ShujuController extends InitController {
	
	public function init(){
		parent::init();
		$this->article = new Article();
	}

	public function indexAction(){
		$type = safe::filter($this->_request->getParam('type'));
		if($type){
			$model = new ArcType();
			$list = $model->typelist();
			
			$children = $model->typeFlow($list,$type);
			foreach ($children as $key => $value) {
				$data[$value['id']] = $this->article->arcList(1,array('type'=>$value['id']));
			}
			$main_data = $this->article->arcList(1,array('type'=>$type));
			$this->getView()->assign('data',$data);
			$this->getView()->assign('main_data',$main_data);

			echo '<pre>';var_dump($data);
			// var_dump($children);
			$this->getView()->assign('type',$children);
		}
	}
}