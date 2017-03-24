<?php


/**
 * @author panduo
 * @date 2016-12-26 15:47:41
 * @brief 耐耐网资讯类型管理
 */
namespace nainai\category;
use Library\Query;
use Library\M;
class ArcType{


	//注释参看 lib\nainai\category\ArcCate.php


	public function typelist($page = 0,$device='pc',$where=array(),$fields=''){
		$where_str = '';
		$index = 0;
		if($where && is_array($where)){
			foreach ($where as $key => $value) {
				$where_str .= 'c.'.$key.'='.$value.' and ';
			}
		}
		$reModel = new Query('article_type as c');
        $reModel->fields = $fields ? $fields:'c.*';
        $reModel->order = 'sort asc';
        $reModel->where = $where_str.' c.status <= 1 and c.is_del = 0';
        if($page>0) $reModel->page = $page;
        $list = $reModel->find();

        if($page>0 && $device == 'pc'){
        	$reBar = $reModel->getPageBar();
        }
        
        return $page > 0 && $device == 'pc' ? array($list,$reBar) : $list;
	}

	//递归获取分类树
	public function typeTree($list,$pid=0,$level=1){
		$arr = array();
		foreach ($list as $key => $value) {
			unset($list[$key]);
			if($value['pid'] == $pid){
				$value['level'] = $level ++;
				$value['_child'] = $this->typeTree($list,$value['id'],$level);
				$arr []= $value;
			}
		}
		return $arr;
	}
	
	//顺序分类树
	public function typeFlow($list,$pid=0,$include_self=0,$level=1,$repeat=3,&$arr=array()){

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
				$this->typeFlow($list,$value['id'],$include_self,$level+1,$repeat,$arr);
			}
		}
		return $arr;
	}

	public function getChildren($type=0,$include_self=0){
		$list = $this->typelist();
		return $this->typeFlow($list,$type,$include_self);
	}

	public function parentType($id){
		$model = new M('article_type');
		return $model->where(array('id'=>$id))->getField('pid');
	}

	public function typeFlowHtml($pid = 0,$id=0,$top=0){
		$list = $this->typelist();
		//排除当前分类与其子分类 TODO
		$typeFlow = $this->typeFlow($list,0,0,1,1);

		$html = $top ? '<option value="0">顶级分类</option>' : '';
		foreach ($typeFlow as $key => $value) {

			if($value['id'] == $id) continue;
			$is_select = $value['id'] == $pid ? 'selected = selected' : '';
			$html .= "<option value='{$value['id']}' {$is_select}>{$value['level_name']}</option>";
		}
		return $html;
	}
}