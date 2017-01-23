<?php

use \Library\json;
use \Library\url;
use \Library\Safe;
use \Library\Thumb;
use \Library\tool;
use \Library\PlUpload;
use \nainai\offer\product;
use \nainai\offer\PurchaseOffer;
use \nainai\keyword;
class ArticleController extends AppBaseController{

	protected function init(){
		parent::init();
		$this->article = new \nainai\Article();
	}
	
	//文章列表
	public function arcListAction(){
		$page = safe::filterPost('page','int');
		$user_id = safe::filterPost('user_id','int');
		$cate_id = safe::filterPost('id','int');
		$update_time = safe::filterPost('update_time','trim');
		$keyword = safe::filterPost('keyword','trim');
		$where = array('is_del'=>0,'status'=>'1');
		// $update_time = date('Y-m-d H:i:s',time());
		$order = 'update_time desc';
		$fields = 'a.id,a.name,a.create_time,a.update_time,a.user_id,a.type,a.keywords';
		if($cate_id > 0) {
			//某一分类文章列表  根据更新时间排序
			$where = array_merge($where,array('cate_id'=>$cate_id));
		}else{
			//推荐列表
		}
		if($keyword){
			//文章标题相关度与关键字热度排序
			$keyword = Keyword::commonUse($keyword);
			$this->article->setKeywordField($fields,$keyword);
			$where = array_merge($where,array('name' => array('like',$keyword)));		
			$order = 'sign desc,update_time desc';
		}
		if($update_time){
			$where = array_merge($where,array('update_time'=>array('gt',$update_time)));
			$page = 1;
		}
		$arcList = $this->article->arcList($page,$where,$order,$fields,10,$user_id);
		foreach ($arcList as $key => &$value) {
			$value['cover'] = $value['cover'] && $value['cover'][0] ? $value['cover'] : array();
			
			$value['create_time'] = date('y/m/d H:i',strtotime($value['create_time']));
		}
		die(json::encode(tool::getSuccInfo(1,$arcList)));
	}

	public function arcInfoAction(){
		// $article_id = safe::filterPost('id','int');
		$article_id = safe::filter($this->_request->getParam('id'),'int');
		$arcInfo = $this->article->arcInfo($article_id);
		if($arcInfo){
			$arcInfo['content'] = htmlspecialchars_decode($arcInfo['content']);//xss
			$this->getView()->assign('info',$arcInfo);
		}else{
			echo '不存在的id';
			return false;
		}
	}
	public function aaAction(){
		phpinfo();
	}

	public function hotKeywordsAction(){
		$keywords = Keyword::hotKeywords();
		var_dump($keywords);
	}
}