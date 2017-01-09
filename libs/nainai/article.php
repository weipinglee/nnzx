<?php


/**
 * @author panduo
 * @date 2016-12-26 15:47:41
 * @brief 耐耐网资讯分类管理
 */
namespace nainai;
use Library\Query;
use Library\Thumb;
class Article{

	const TYPE_USER = 1;//前台用户发布
	const TYPE_ADMIN = 2;//后台管理员发布

	/**
	 * 获取文章列表
	 * @param  int $page      页数
	 * @param  array   $where     条件数组
	 * @param  string  $fields    查询值域
	 * @param  int $user_id   获取指定用户收藏文章列表
	 * @param  int $author_id 获取指定作者发布文章列表(前台)
	 * @param  string  $device    设备
	 * @param  int  $pageSize 每页显示数
	 * @return array
	 */
	public function arcList($page = 1,$where=array(),$fields='',$user_id = 0,$author_id = 0,$device='pc',$pageSize=0){
		$where_str = '';
		$index = 0;
		if($where && is_array($where)){
			foreach ($where as $key => $value) {
				$key = (strpos($key,'.') ? '' : 'a.').$key;

				$oper = is_array($value) && isset($value[1]) ? $value[1] : '=';
				
				switch ($oper) {
					case 'like':
						if(is_array($value[0])){
							$tmp = ' (';
							foreach ($value[0] as $k => $v) {
								$tmp .= $key." like '%{$v}%' or ";
							}
							$tmp = rtrim($tmp,'or ').') and ';	
							
						}else{
							$tmp = $key." like '%{$value}%' and ";
						}
						
						$where_str .= $tmp;
						break;
					case '=':
						$where_str .= $key.'='.$value.' and ';
						break;
					default:
						break;
				}
			}
		}
		// var_dump($where_str);
		$reModel = new Query('article as a');
		$reModel->join = 'left join article_content as ac on a.id = ac.article_id left join article_cover as aco on aco.article_id = a.id left join user as u on a.user_id = u.id';
		$bind = array();
        if(intval($user_id)>0){
        	$reModel->join .= 'left join user_favcate as uf on uf.cate_id = c.id';
        	$where = 'uf.user_id=:user_id and';
        	$bind = array_merge($bind,array('user_id'=>intval($user_id)));
        }
        if(intval($author_id)>0){
        	$where = 'a.user_id=:author_id and a.type='.\nainai\Article::TYPE_USER;
        	$bind = array_merge($bind,array('author_id'=>intval($author_id)));
        	
        }
        if($pageSize>0) $reModel->pagesize=$pageSize;

        $reModel->bind = $bind;
        $reModel->group = 'a.id';
        $reModel->fields = ($fields ? $fields:'a.*').",GROUP_CONCAT(url) as cover,u.username as author";
        $reModel->where = $where_str.' a.status <= 1 and a.is_del = 0';
        $reModel->page = $page;
        $list = $reModel->find();
        if($page>0 && $device == 'pc'){
        	$reBar = $reModel->getPageBar();
        }
        foreach ($list as $key => &$value) {
        	$value['author'] = $value['type'] == \nainai\Article::TYPE_ADMIN ? '耐耐资讯' : ($value['author'] ? $value['author']:'佚名');
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
        }
        return $page > 0 && $device == 'pc' ? array($list,$reBar) : $list;
	}

	/**
	 * 获取文章详情
	 * @param  int $article_id 文章id
	 * @return array
	 */
	public function arcInfo($article_id){
		$article_id = intval($article_id);
		if(!$article_id || $article_id <= 0) return array();
		$arcList = $this->arcList(0,array('id'=>$article_id),'a.*,ac.content',0,0,DEVICE_TYPE,1);
		return $arcList[0];
	}

	/**
	 * 文章热度更新		
	 * @param  int $article_id 文章id
	 * @return 
	 */
	public function arcScore($article_id){

	}





}