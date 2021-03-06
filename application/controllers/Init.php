<?php

use Library\safe;
use nainai\category\ArcType;
use nainai\category\ArcCate;
use nainai\system\friendlyLink;
class InitController extends Yaf\Controller_Abstract {
	public function init(){
		$type_id = safe::filter($this->_request->getParam('type'),'int',0);

		//类型列表
		$typemodel = new ArcType();
		$typelist = $typemodel->typelist(0,'pc',array('pid'=>0));

		//分类列表
		$catemodel = new ArcCate();
		$catelist = $catemodel->cateList(0,0,'pc',array('pid'=>0));

		//友情链接
		$fl = new friendlyLink();
		$fllist = $fl->getfrdLinkList();

		$this->getView()->assign('cates',$catelist);
		$this->getView()->assign('fl',$fllist[0]);
		$this->getView()->assign('type_id',$type_id);
		
		$this->getView()->assign('typelist',array_slice($typelist,0,3));
		$this->getView()->setLayout('layout');
	}
}
