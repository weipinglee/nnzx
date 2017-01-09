<?php
namespace nainai\user;

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;

/**
 * 菜单角色操作对应的api
 * @author maoyong.zeng <zengmaoyong@126.com>
 * @copyright 2016年05月30日
 */
class MenuRole extends \nainai\Abstruct\ModelAbstract {

	/**
	 * 添加菜单角色验证规程
	 * @var array
	 */
	protected $Rules = array(
	    array('name','require','必须输入菜单角色的中文名称', 2)
	);

	/**
	 * 获取用户角色分组列表
	 * @param  int $page 当前页index
	 * @return array
	 */
	public function getList($page){
		$Q = new Query('menu_role');
		$Q->page = $page;
		$Q->pagesize = 5;
		$data = $Q->find();
		$pageBar =  $Q->getPageBar();
		return array('data'=>$data,'bar'=>$pageBar);
	}

	/**
	 * 获取用户组列表
	 * @access public
	 * @return [Array]
	 */
	public function getRoleList(){
		return $this->model->fields('id, name')->select();
	}


}