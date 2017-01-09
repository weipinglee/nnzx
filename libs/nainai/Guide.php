<?php

namespace nainai;

use \Library\M;
use \Library\Query;
use \Library\Tool;

class Guide extends \nainai\Abstruct\ModelAbstract{
	
   /**
     * 添加导航验证规程
     * @var array
     */
    protected $Rules = array(
        array('name','require','必须填写导航名'),
        array('type','int','请选择导航类型'),
        array('pid','int','请选择上级分类'),
    );

    /**
     * 导航栏分类的
     * @var string
     */
    public $category = null;

    /**
     * 分类的修饰图形
     * @var array
     */
    private $_icon = array('│','├','└');

    /**
     * 获取导航栏列表
     * @param  [Int]  $page     [分页]
     * @param  [Int]  $pagesize [分页]
     * @param  integer $type     [导航栏类型]
     * @return [Array.list]            [导航栏列表数据]
     * @return [Array.pageHtml]            [导航栏分页数据]
     */
    public function getGuideList($page, $pagesize, $type=0){
    	$query = new Query('guide');
    	$query->fields = 'id, name, link, sort';
    	$query->page = $page;
    	$query->pagesize = $pagesize;
    	$query->order = 'sort desc';
    	$query->where = 'type=:type';
    	$query->bind = array('type' => $type);
    	$guideList = $query->find();
    	
    	return array('list' => $guideList, 'pageHtml' => $query->getPageBar());
    }

    /**
     * 获取导航栏分类的option数据
     * @param  integer $selectId [默认选择的导航栏id]
     * @param  integer $type     [导航栏类型]
     * @param  integer $pid       [导航栏父类id]
     * @param  integer $level    [分类的等级，根据等级从分类修饰图形获取图形]
     * @return Boolean 是否获取成功
     */
    public function getGuideCategoryOption($selectId = 0, $type=0, $pid = 0, $level=-1){
    	$list = $this->model->fields('id, name, pid')->where('type=:type AND pid=:id')->bind(array('type'=>$type, 'id'=>$pid))->select();
    	if (empty($list)) {
    		return false;
    	}
   	$level ++;
    	foreach ($list as $array) {
    		$this->category .= '<option value="'.$array['id'].'"';
    		if (intval($selectId) >0 && $array['id'] == $selectId) {
    			$this->category .= 'SELECTED="SELECTED"';
    		}
    		$this->category .=  '>' . str_repeat('&nbsp;&nbsp;', $level) .  $this->_icon[$level] . $array['name'] . '</option>';
    		$this->getGuideCategoryOption($selectId, $type, $array['id'], $level);
    	}

    	return true;
    }

}