<?php
use \nainai\category\ArcType;
use Library\safe;

use \nainai\Article;
use \nainai\category\ArcCate;
use \nainai\keyword;
use Library\url;
class DetailController extends InitController {
	
	public function init(){
		parent::init();
		$this->article = new Article();
	}

	public function indexAction(){
		$id = safe::filter($this->_request->getParam('id'),'int',0);
		$arcInfo = $this->article->arcInfo($id);
		
		if($arcInfo){
			$arcInfo['content'] = htmlspecialchars_decode($arcInfo['content']);//xss
			$this->getView()->assign('info',$arcInfo);
		}else{
			$this->redirect(url::createUrl('/index/index'));
		}
		$keywords = Keyword::hotKeywords(20);
		$this->getView()->assign('keywords',$keywords);
	}
}