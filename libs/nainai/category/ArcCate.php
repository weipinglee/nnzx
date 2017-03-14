<?php


/**
 * @author panduo
 * @date 2016-12-26 15:47:41
 * @brief 耐耐网资讯分类管理
 */
namespace nainai\category;
use Library\Query;
class ArcCate{
	//获取文章分类列表
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
        if($page>0) $reModel->page = $page;
        $list = $reModel->find();

        foreach ($list as $key => &$value) {
        	if($device == 'pc')
        		$value['icon'] = \Library\Thumb::get($value['icon'],180,180);
        }
        if($page>0 && $device == 'pc'){

        	$reBar = $reModel->getPageBar();
        }
        
        
        
        return $page > 0 && $device == 'pc' ? array($list,$reBar) : $list;
	}

	//递归获取分类树
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

	//顺序分类树
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

	public function getChildren($cate_id=0,$include_self=0){
		$list = $this->cateList();
		return $this->cateFlow($list,$cate_id,$include_self);
	}

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