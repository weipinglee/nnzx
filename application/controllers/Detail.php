<?php
/**
 * 文章详情
 */

use Library\safe;

use \nainai\article;
use \nainai\keyword;
use Library\url;
class DetailController extends InitController {
	
	public function init(){
		parent::init();
		$this->article = new article();
	}


	//详情页展示
	public function indexAction(){
		$id = safe::filter($this->_request->getParam('id'),'int',0);
		$arcInfo = $this->article->arcInfo($id);
		
		if($arcInfo){
			$arcInfo['content'] = htmlspecialchars_decode($arcInfo['content']);//xss
			$this->getView()->assign('info',$arcInfo);
		}else{
			$this->redirect(url::createUrl('/index/index'));
		}
		//获取热门搜索关键字列表
		$keywords = Keyword::hotKeywords(20);
		$this->getView()->assign('keywords',$keywords);
	}
}