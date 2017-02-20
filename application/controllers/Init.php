<?php

use Library\safe;
use Library\tool;
use Library\M;
use Library\json;
use Library\Query;
use Library\Thumb;
use nainai\category\ArcType;
class InitController extends Yaf\Controller_Abstract {
	public function init(){
		$type = new ArcType();
		$typelist = $type->typelist(0,'pc',array('pid'=>0));
		$this->getView()->assign('typelist',$typelist);
		$this->getView()->setLayout('layout');
		// $this->getView()->assign('title','公益基金');
	}
}
