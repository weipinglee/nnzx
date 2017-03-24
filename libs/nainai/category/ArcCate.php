<?php


/**
 * @author panduo
 * @date 2016-12-26 15:47:41
 * @brief 耐耐网资讯分类管理
 */
namespace nainai\category;
use Library\Query;
class ArcCate{
	/**
	 * 获取文章分类列表	
	 * @param  integer $page    当前页数
	 * @param  integer $user_id 用户id
	 * @param  string  $device  设备pc/app
	 * @param  array   $where   条件数组	
	 * @param  string  $fields  查询域
	 * @return array   列表数组
	 */
	public function cateList($page = 0,$user_id = 0,$device='pc',$where=array(),$fields=''){
		$where_str = '';
		$index = 0;
		if($where && is_array($where)){
			foreach ($where as $key => $value) {
				$where_str .= 'c.'.$key.'='.$value.' and ';
			}
		}
		$reModel = new Query('article_category as c');
        if(intval($user_id)>0){
        	$reModel->join = 'left join user_favcate as uf on uf.cate_id = c.id';
        	$where = 'uf.user_id=:user_id and';
        	$reModel->bind = array('user_id'=>$user_id);
        	
        }
        $reModel->fields = $fields ? $fields:'c.*';
        $reModel->where = $where_str.' c.status <= 1 and c.is_del = 0';
        $reModel->order = 'pid asc,sort asc';
        if($page>0) $reModel->page = $page;
        $list = $reModel->find();

        foreach ($list as $key => &$value) {
        	$value['icon'] = \Library\Thumb::getOrigImg($value['icon']);
        }
        if($page>0 && $device == 'pc'){
        	$reBar = $reModel->getPageBar();
        }
        
        //若设备为pc且当前页大于1 则显示分页
        return $page > 0 && $device == 'pc' ? array($list,$reBar) : $list;
	}

	/**
	 * 递归获取分类树	
	 * @param  array  $list   分类数组
	 * @param  integer $pid   上级分类id
	 * @param  integer $level 所属层级
	 * @return array  
	 */
	public function cateTree($list,$pid=0,$level=1){
		$arr = array();
		foreach ($list as $key => $value) {
			unset($list[$key]);
			if($value['pid'] == $pid){
				$value['level'] = $level ++;
				$value['_child'] = $this->cateTree($list,$value['id'],$level);
				$arr []= $value;
			}
		}
		return $arr;
	}

	/**
	 * 递归顺序分类树 用于下拉框展示
	 * @param  array  $list          分类数组
	 * @param  integer $pid          上级分类id
	 * @param  integer $include_self 是否包含顶级分类
	 * @param  integer $level        所属层级
	 * @param  integer $repeat       前缀重复次数
	 * @param  array   &$arr         辅助数组		
	 * @return array
	 */
	public function cateFlow($list,$pid=0,$include_self=0,$level=1,$repeat=3,&$arr=array()){
		foreach ($list as $key => $value) {
			if($include_self == 1){
				if($value['id'] == $pid){
					$value['level'] = $level-1;
					$arr []= $value;
				}
			}

			if($value['pid'] == $pid){
				unset($list[$key]);
				$value['level'] = $level;
				$value['level_name'] = $level == 1 ? $value['name'] : str_repeat("&emsp;",($level-1)*$repeat).'|-'.$value['name'];
				$arr []= $value;
				$this->cateFlow($list,$value['id'],$include_self,$level+1,$repeat,$arr);
			}
		}
		return $arr;
	}

	/**
	 * 获取指定分类所有子分类
	 * @param  integer $cate_id      分类id
	 * @param  integer $include_self 是否包含顶级分类
	 * @return array  分类数组
	 */
	public function getChildren($cate_id=0,$include_self=0){
		$list = $this->cateList();
		return $this->cateFlow($list,$cate_id,$include_self);
	}

	/**
	 * 返回html格式的下拉框内容
	 * @param  integer $id 分类id
	 * @return string  
	 */
	public function cateFlowHtml($id=0){
		$list = $this->cateList();
		$cateFlow = $this->cateFlow($list,0,0,1,1);
		$html = '<option value="0">顶级分类</option>';
		foreach ($cateFlow as $key => $value) {
			$is_select = $value['id'] == $id ? 'selected = selected' : '';
			$html .= "<option value='{$value['id']}' {$is_select}>{$value['level_name']}</option>";
		}
		return $html;
	}
}