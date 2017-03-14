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
use \Library\ad;
class ArticleController extends AppBaseController{

	protected function init(){
		parent::init();
		$this->article = new \nainai\Article();
	}
	
	//文章列表
	public function arcListAction(){
		$page = safe::filterPost('page','int','1');
		$user_id = safe::filterPost('user_id','int');
		$cate_id = safe::filterPost('id','int',0);

		$update_time = safe::filterPost('update_time','trim');
		$keyword = safe::filterPost('keyword','trim');
		
		$where = array('status'=>1,'is_del'=>0,'is_ad'=>0);
		
		// $update_time = date('Y-m-d H:i:s',time());
		$order = 'update_time desc';
		$fields = 'a.id,a.name,a.create_time,a.update_time,a.user_id,a.type,a.user_type,a.keywords,a.is_ad';
		if($cate_id > 0) {
			//某一分类文章列表  根据更新时间排序
			$arccate = new \nainai\category\ArcCate();
			$children = $arccate->getChildren($cate_id,1);
			foreach ($children as $key => $value) {
				$tmp .= $value['id'].",";
			}
			$where = array_merge($where,array('cate_id'=>array('in',rtrim($tmp,','))));
			$size = 10;
			$slide = 0;
		}else{
			//推荐列表
			$where = array_merge($where,array('recommend'=>1));
			$size = $page == 1 ? 15 : 10;
			$slide = 1;
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

		$arcList = $this->article->arcList($page,$where,$order,$fields,$size,$user_id);

		foreach ($arcList as $key => &$value) {
			unset($value['content']);
			unset($value['ori_covers']);
			unset($value['create_time']);
			unset($value['cover_pic']);
			unset($value['user_id']);
			unset($value['type']);
			unset($value['user_type']);
			$value['cover'] = $value['cover'] && $value['cover'][0] ? $value['cover'] : array();
			$value['create_time'] = date('y/m/d H:i',strtotime($value['create_time']));
			if(isset($value['cover'][0]) && count($slides) < 5 && $page == 1 && $cate_id == 0) {
				$tmp = $value;
				$tmp['cover'] = $tmp['cover'][0];
				$slides []= $tmp;
				unset($arcList[$key]);
			}
		}
		$this->article->where = array();
		$where['is_ad'] = 1;
		$ads = $this->article->arcList($page,$where,$order,$fields,1);
		
		if(isset($ads[0])){
			array_splice($arcList, rand(1,5),0,$ads);
		}

		$res = tool::getSuccInfo(1,$arcList);
		if($cate_id == 0) $res['slides'] = $slides;
		
		
		die(json::encode($res));
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

	public function adAction(){
		$ad = ad::getAdData('appindex');
		$img = isset($ad[0]['content']) ? Thumb::getOrigImg($ad[0]['content']) : url::getHost().'/views/pc/images/no_pic.png';
		die(json::encode(array('img'=>$img,'url'=>$ad[0]['link'])));
	}
	public function aaAction(){
		phpinfo();
	}
	
	public function hotKeywordsAction(){
		$keywords = Keyword::hotKeywords();
		// var_dump($keywords);
	}
}