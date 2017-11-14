<?php


/**
 * @author panduo
 * @date 2016-12-26 15:47:41
 * @brief 耐耐网资讯分类管理
 */
namespace nainai;
use Library\Query;
use Library\Thumb;
use Library\M;
use nainai\Keyword;
use Library\tool;
use Library\url;
use \nainai\category\ArcCate;
use \nainai\category\ArcType;
class Article{

	const TYPE_USER = 1;//前台用户发布
	const TYPE_ADMIN = 2;//后台管理员发布

	/**
	 * 设置关键字搜索字段排序
	 * @param string &$fields 查询字段
	 * @param array $keyword 关键字数组
	 */
	public function setKeywordField(&$fields,$keyword){
		$keyword_info = Keyword::keywordInfo($keyword);
		$tmp = ',((';
		$keyword_filter = '';
		foreach ($keyword as $key => $value) {

			$title_score = 100;//100为标题相关度权重
			$tmp .= "(LENGTH(a.name) - LENGTH( REPLACE(a.name,'{$value}','')))/LENGTH('{$value}')+";	
			$keyword_score = isset($keyword_info[$value]) ? $keyword_info[$value]['search_num']*$keyword_info[$value]['base_score'] : 0.5;//0.5为新关键字权重
			//已存关键字权重默认为1 可由后台设置
			$keyword_filter .= "((LENGTH(ifnull(keywords,'')) - LENGTH( REPLACE(ifnull(keywords,''),'{$value}','')))/LENGTH('{$value}'))*{$keyword_score}+";
			
		}
		$where['keywords'] = array('like',$keyword);
		if($where) $this->where = $where;
		//根据关键字在标题与文章关键字中出现的频率和权重来对文章列表进行排序
		$fields .= rtrim($tmp,'+').")*{$title_score}+".rtrim($keyword_filter,'+').') as sign';

	}

	/**
	 * 处理where条件数组
	 * @param  array $where 条件数组	
	 * @return  string 条件字符串
	 */
	private function handleWhere($where){
		$where_str = '';
		if(!isset($where['is_del'])) $where['is_del'] = 0;
		if(!isset($where['status'])) $where['status'] = array('lte',1);
		if(!isset($where['is_ad'])) $where['is_ad'] = 0;

		//where数组中cate_id/tyoe 可与include_child同时使用  形如：array('cate_id'=>1,'include_child'=>1)
		//如设置include_child则表示查询此分类及其下所有子分类
		if(isset($where['include_child'])){
			unset($where['include_child']);
			if(isset($where['cate_id'])){

				$cate_id = $where['cate_id'];
				unset($where['cate_id']);
				$m = new ArcCate();
				$child = $m->getChildren($cate_id,1);

				foreach ($child as $key => $value) {
					$tmp []= $value['id'];
				}
				if(isset($tmp)) $where ['cate_id'] = array('in',$tmp);
			}
			if(isset($where['type'])){
				$type = $where['type'];
				unset($where['type']);
				$m = new ArcType();
				$child = $m->getChildren($type,1);

				foreach ($child as $key => $value) {
					$tmp []= $value['id'];
				}
				if(isset($tmp)) $where ['type'] = array('in',$tmp);
			}
		}
		if($where && is_array($where)){
			//若where数组中包含keywords 则keywords应与文章关键字与文章标题匹配
			if(isset($where['keywords']) && isset($where['name'])){
				$keywords = $where['keywords'];
				$keywords[]= 'or';
				$name = $where['name'];
				unset($where['keywords']);
				unset($where['name']);
				$where_str = '('.$this->switchWhere(array('keywords'=>$keywords,'name'=>$name)).') and ';
			}
			$where_str .= $this->switchWhere($where);		
			// var_dump($where_str);
		}
		return $where_str;
	}
	
	/**
	 * 解析处理where数组
	 * @param  array $where 条件数组
	 * @return string  条件字符串
	 */
	public function switchWhere($where){
		foreach ($where as $key => $value) {
			$key = (strpos($key,'.') ? '' : 'a.').$key;
			//操作符
			$oper = is_array($value) && isset($value[1]) ? $value[0] : '=';
			//逻辑  and或or
			$logic = is_array($value) && isset($value[2]) ? " ".$value[2]." " : ' and ';

			switch ($oper) {
				case 'like':
					if(is_array($value[1])){
						$tmp = ' (';
						foreach ($value[1] as $k => $v) {
							$tmp .= $key." like '%{$v}%' or ";
						}
						$tmp = rtrim($tmp,'or ').') '.$logic;	
						
					}else{
						$tmp = $key." like '%{$value[1]}%' ".$logic;
					}
					$where_str .= $tmp;
					break;
				case 'neq':
					$where_str .= $key.'!='.$value[1].$logic;
					break;
				case '=':
					$where_str .= $key.'='.$value.$logic;
					break;
				case 'gt':
					$where_str .= $key.">'".$value[1]."' ".$logic;
					break;
				case 'gte':
					$where_str .= $key.">='".$value[1]."' ".$logic;
					break;
				case 'lt':
					$where_str .= $key."<'".$value[1]."' ".$logic;
					break;
				case 'lte':
					$where_str .= $key."<='".$value[1]."' ".$logic;
					break;
				case 'in':
					$tmp = is_array($value[1]) ? "'".implode("','",$value[1])."'" : $value[1];
					$where_str .= $key." in (".$tmp.") ".$logic;
					break;
				default:
					break;
			}
			
		}
		$where_str = rtrim($where_str,' '.$logic.' ');
		return $where_str;
	}

	/**
	 * 获取文章列表
	 * @param  int $page      页数
	 * @param  array   $where     条件数组
	 * @param  string  $order     排序条件
	 * @param  string  $fields    查询值域
	 * @param  int $user_id   获取指定用户收藏文章列表
	 * @param  int $author_id 获取指定作者发布文章列表(前台)
	 * @param  string  $device    设备
	 * @param  int  $pageSize 每页显示数
	 * @return array
	 */
	public function arcList($page = 1,$where=array(),$order='',$fields='',$pageSize=10,$user_id = 0,$author_id = 0,$device=DEVICE_TYPE){
		if($this->where && $where) $where = array_merge($this->where,$where);

		$where_str = $this->handleWhere($where);
		if(!$order) $order = 'a.update_time desc';
		$index = 0;
		

		$reModel1 = new Query('article as a');
		$bind = array();


        //若设置了作者id 则获取指定作者发布文章列表(前台)
        if(intval($author_id)>0){
        	$where = 'a.user_id=:author_id and a.user_type='.\nainai\Article::TYPE_USER;
        	$bind = array_merge($bind,array('author_id'=>intval($author_id)));
        	
        }

		$reModel1->where = $where_str;
		$reModel1->bind = $bind;
		$reModel1->fields = 'a.id';
		$reModel1->group = 'a.id';
		$reModel1->order = 'a.update_time desc';
		$reModel1->page = $page;
		if($pageSize>0) $reModel1->pagesize=$pageSize;
		$res = $reModel1->find();
		$where_ids = '';
		if(!empty($res)){
			foreach($res as $val){
				$where_ids .= $where_ids=='' ?  $val['id'] :  ','.$val['id'];
			}
		}


		if($where_ids=='')
			return array();
		$reModel = new Query('article as a');
		$reModel->distinct = 1;
		$trade_db = tool::getGlobalConfig('nn');
		$reModel->join = 'left join article_content as ac on a.id = ac.article_id left join article_cover as aco on aco.article_id = a.id left join '.$trade_db.'.user as u on a.user_id = u.id left join article_category as cc on a.cate_id=cc.id left join article_type as at on a.type=at.id';
        $reModel->fields = ($fields ? $fields:'a.*').",GROUP_CONCAT(aco.url) as cover,u.username as author,cc.name as cate_name,ac.content,at.name as type_name";
        $reModel->where = 'a.id in ('.$where_ids.')';
		$reModel->order = $order;
		$reModel->group = 'a.id';
        $list = $reModel->find();
        
        if($page>0 && $device == 'pc'){
        	$reBar = $reModel1->getPageBar();
        }
        foreach ($list as $key => &$value) {
        	$value['author'] = $value['user_type'] == \nainai\Article::TYPE_ADMIN ? '耐耐资讯' : ($value['author'] ? $value['author']:'佚名');
        	$value['create_time'] = date('Y-m-d',strtotime($value['create_time']));

        	$value['short_content'] = mb_substr(strip_tags(htmlspecialchars_decode($value['content'])),0,80,'utf-8').'...';
        	
        	
        	if(isset($value['cover'])){
        		// $thumbs[$key] = Thumb::get($value['img'],180,180);
          //       $photos[$key] = Thumb::getOrigImg($value['img']);
          		$covers = explode(',',$value['cover']);
          		$value['ori_covers'] = $covers;
          		$tmp = array();
          		foreach ($covers as $k => $v) {
          			$tmp []= Thumb::get($v,180,180);	
          		}
          		$value['cover'] = $tmp;
        	}else{
        		$value['cover'] = array();
        	}
        	$value['cover_pic'] = isset($value['cover'][0]) ? $value['cover'][0] : "/views/pc/images/no_pic.png";
        }
        //若设备为pc且当前页大于0  则显示分页
        return $page > 0 && $device == 'pc' ? array($list,$reBar) : $list;
	}

	/**
	 * 获取文章详情
	 * @param  int $article_id 文章id
	 * @param  int $user_id  当前用户id
	 * @return array
	 */
	public function arcInfo($article_id,$user_id = 10){
		$article_id = intval($article_id);
		if(!$article_id || $article_id <= 0) return array();
		
		$arcList = $this->arcList(0,array('id'=>$article_id,'is_ad'=>array('gte',0)),'','a.*',1);
		
		if(!$arcList) return array();
		$arcInfo = $arcList[0];
		$arcInfo['ori_keywords'] = $arcInfo['keywords'];
		$keywords = Keyword::check($user_id,$arcInfo);
		$arcInfo['keywords'] = $keywords;
		
		$arcInfo['keywords_str'] = implode(',',$keywords);
		
		// if(DEVICE_TYPE != 'pc')
		//相关推荐文章列表
			$arcInfo['comArcList'] = $this->comArcList($arcInfo,$user_id);

		//上一篇与下一篇
		$arcInfo['siblings'] = $this->siblingArticle($arcInfo);
		$this->viewsNumAdd($arcInfo);
		return $arcInfo;
	}

	public function arcids($cate_id=0){
		
	}

	/**
	 * 文章点击+1
	 * @param  array $arcInfo 文章详情数组
	 */
	public function viewsNumAdd($arcInfo){
		$model = new M('article');
		@$model->where(array('id'=>$arcInfo['id']))->data(array('collect_num'=>$arcInfo['collect_num']+1))->update();
	}

	/**
	 * 获取相邻文章
	 * @param  array $arcInfo 文章数组
	 * @return array
	 */
	public function siblingArticle($arcInfo){
		$m = new M('article');

		$where = array('cate_id'=>$arcInfo['cate_id']);
		$ids = $m->where($where)->order('id asc')->fields('id')->select();
		$ids = array_column($ids,'id');

		$key = array_search($arcInfo['id'],$ids);
		if($key == 0){
			$data['pre']['href'] = 'javascript:;';
			$data['pre']['title'] = '没有了';
		}
		if($key == count($ids)-1){
			$data['next']['href'] = 'javascript:;';
			$data['next']['title'] = '没有了';
		}
		if(!isset($data['pre'])){
			$id = $ids[$key-1];
			$title = $m->where(array('id'=>$id))->getField('name');

			$data['pre']['href'] = url::createUrl('/detail/index?id='.$id);
			$data['pre']['title'] = $title;
		}
		if(!isset($data['next'])){
			$id = $ids[$key+1];

			$title = $m->where(array('id'=>$id))->getField('name');

			$data['next']['href'] = url::createUrl('/detail/index?id='.$id);
			$data['next']['title'] = $title;	
		}
		
		return $data;
	}

	/**
	 * 文章热度更新		
	 * @param  int $article_id 文章id
	 * @return 
	 */
	public function arcScore($article_id){

	}

	/**
	 * 特定文章相关推荐列表
	 * @param  array $arcInfo 文章信息数组
	 * @param  int $size 文章数
	 * @return array
	 */
	public function comArcList($arcInfo,$user_id = 0,$size = 3){
		if(!$arcInfo) return array();
		//获取用户常用关键字
		$fav_keywords = Keyword::userFavKeywords($user_id);

		$user_fields = 'a.*';
		$order = 'sign desc,update_time desc';
		$where = array('id'=>array('neq',$arcInfo['id']),'is_del'=>0,'status'=>1);
		if($fav_keywords) {
			$this->setKeywordField($user_fields,$fav_keywords);
			//用户热搜关键字文章列表
			$userarcList = $this->arcList(1,$where,$order,$user_fields,10);
			$userarcList = DEVICE_TYPE == 'pc' ? $userarcList[0] : $userarcList;
			
		}else{
			$userarcList = array();
		}
		
		//当前文章关键字
		$arc_keywords = $arcInfo['keywords'];

		$arc_fields = 'a.*';
		$where = array('id'=>array('neq',$arcInfo['id']));//'cate_id'=>$arcInfo['cate_id'],
		if($arc_keywords) {
			$this->setKeywordField($arc_fields,$arc_keywords);
			//文章关键字排序文章列表
			$arcList = $this->arcList(1,$where,$order,$arc_fields,10);
			$arcList = DEVICE_TYPE == 'pc' ? $arcList[0] : $arcList;
		}else{
			$arcList = array();
		}
		$list = array_merge(array_slice($arcList,0,$size),array_slice($userarcList, 0,$size));
		
		$ids = array();
		foreach ($list as $key => $value) {
			
			if(in_array($value['id'],$ids)) unset($list[$key]);
			$ids []= $value['id'];
		}
		return $list;
	}


}