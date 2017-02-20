<?php
use \nainai\Article;
use Library\safe;
use \nainai\Keyword;
class SearchController extends InitController {
		
	public function init(){
		parent::init();
		$this->article = new Article();
	}

	public function indexAction(){
		$page = safe::filterget('page','int',1);
		$cate_id = safe::filterPost('id','int');
		$ori_keyword = safe::filter($this->_request->getParam('keyword'));

		$where = array('status'=>1,'is_del'=>0);

		// $update_time = date('Y-m-d H:i:s',time());
		$order = 'update_time desc';
		$fields = 'a.id,a.name,a.create_time,a.update_time,a.user_id,a.type,a.user_type,a.keywords';
		if($cate_id > 0) {
			//某一分类文章列表  根据更新时间排序
			$where = array_merge($where,array('cate_id'=>$cate_id));
		}else{
			//推荐列表
		}
		if($ori_keyword){
			//文章标题相关度与关键字热度排序
			$keyword = Keyword::commonUse($ori_keyword);
			$this->article->setKeywordField($fields,$keyword);
			$where = array_merge($where,array('name' => array('like',$keyword)));

			$order = 'sign desc,update_time desc';
		}
		$arcList = $this->article->arcList($page,$where,$order,$fields,10);

		$keywords = Keyword::hotKeywords(20);
		// foreach ($arcList as $key => &$value) {
		// 	$value['cover'] = $value['cover'] && $value['cover'][0] ? $value['cover'] : array();
		// 	$value['create_time'] = date('y/m/d H:i',strtotime($value['create_time']));
		// }
		// echo '<pre>';var_dump($arcList);
		$this->getView()->assign('keywords',$keywords);
		$this->getView()->assign('list',$arcList[0]);
		$this->getView()->assign('pageBar',$arcList[1]);
		$this->getView()->assign('keyword',$ori_keyword);
	}
}