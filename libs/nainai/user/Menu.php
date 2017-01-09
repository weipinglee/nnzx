<?php
namespace nainai\user;

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;

/**
 * 菜单操作对应的api
 * @author maoyong.zeng <zengmaoyong@126.com>
 * @copyright 2016年05月30日
 */
class Menu extends \nainai\Abstruct\ModelAbstract {

	protected $menuTable = 'menu';
	protected $menuRoleTable = 'menu_role';
	/**
	 * 添加菜单验证规程
	 * @var array
	 */
	protected $Rules = array(
	    array('menu_zn','require','必须菜单的中文名称'),
	    array('menu_url','require','请正确填写url', 2)
	);

	protected $publicRole = 'public';

	/**
	 * 菜单的列表
	 * @var array
	 */
	static public $treeList = array(); 

	/**
	 * 导航栏分类的
	 * @var string
	 */
	public $category = null;

	/**
	* 分类的修饰图形
	* @var array
	*/
	private $_icon = array( 0 => '', 1=>'│', 2=>'├', 3=>'└');

	public function getIcon(){
		return $this->_icon;
	}

	/**
	 * 获取菜单列表
	 * @return [Array] 
	 */
	public function getMenuList(){
		return $this->model->fields('id, menu_zn, pid,status,menu_url, position, subacc_show')->order('pid asc, sort desc')->select();
	}
	

	/**
	 * 无限级分类
	 * @access public 
	 * @param Array $data     //数据库里获取的结果集 
	 * @param Int $pid             
	 * @param Int $level       //第几级分类
	 * @return Array $treeList   
	 */
	static public function getTreeList(&$data,$pid = 0,$level = 0) {
	    foreach ($data as $key => $value){
	        if($value['pid']==$pid){
	            $value['level'] = $level;
	            self::$treeList []=$value;
	            unset($data[$key]);
	            self::getTreeList($data,$value['id'],$level+1);
	        } 
	    }
	    return self::$treeList ;
	}

	/**
	 * 获取菜单分类的option数据
	 * @access public
	 * @param  integer $selectId [默认选择的导航栏id]
	 * @param  integer $pid       [导航栏父类id]
	 * @param  integer $level    [分类的等级，根据等级从分类修饰图形获取图形]
	 * @return Boolean 是否获取成功
	 */
	public function getGuideCategoryOption($selectId = 0, $pid = 0, $level=-1){
		$list = $this->model->fields('id, menu_zn, pid')->where('pid=:id AND status=1')->bind(array('id'=>$pid))->order('pid asc, sort desc')->limit('100')->select();
		if (empty($list)) {
			return false;
		}

		$level ++;
		foreach ($list as $array) {
			$this->category .= '<option value="'.$array['id'].'"';
			if (intval($selectId) >0 && $array['id'] == $selectId) {
				$this->category .= 'SELECTED="SELECTED"';
			}
			$this->category .=  '>' . str_repeat('&nbsp;&nbsp;', $level) .  $this->_icon[$level] . $array['menu_zn'] . '</option>';
			$this->getGuideCategoryOption($selectId, $array['id'], $level);
		}

		return true;
	}

	/**
	 * 获取用户的菜单数据列表
	 * @param  [Int] $uid [用户id]
	 * @param array 用户认证数据
	 * @return [Array]      [菜单数据列表]
	 */
	public function getUserMenuList($uid,$cert=array(),$user_type=1){
		$menuList = array();
		if (intval($uid) > 0) {
			$userPur = array();
			//获取各个认证角色的角色id
			$roleIds = array();
			if(!empty($cert)){
				$user = $this->model->table('user')->where(array('id'=>$uid))->fields('gid,pid')->getObj();

				if($user['pid'] != 0){//子账户权限
					if ( ! empty($user['gid'])) {
						$userPur = unserialize($user['gid']);
					}
				}else{
					$roleIds['public'] = $this->publicRole;
					$where = 'cert in (:public';
					if(isset($cert['deal']) && $cert['deal']==1){//交易商认证特殊处理，根据个人还是企业获取不同的菜单
						$roleIds['deal'] = 'deal_'.$user_type;
						$where .= ',:deal';
						unset($cert['deal']);
					}
					foreach($cert as $key=>$val){
						if($val==1){
							$roleIds[$key] = $key;
							$where .= ',:'.$key;
						}

					}

					$where .= ')';
					$right = $this->model->table($this->menuRoleTable)->where($where)->bind($roleIds)->getFields('purview');
					foreach($right as $k=>$v){
						if ( ! empty($v)) {
							$userPur = array_merge($userPur,unserialize($v));
						}
						
					}
				}
			}
			
			if ( $userPur != '' ) {
				$menuList = $this->model->table('menu')->fields('id, menu_zn, pid, menu_url,status, position, subacc_show')->where('FIND_IN_SET(id, :ids)')->bind(array('ids' => implode(',', $userPur)))->order('pid asc, sort asc')->select();

				foreach($menuList as $k=>$v){
					if($v['menu_url']!='')
						$menuList[$k]['menu_url'] = \Library\url::createUrl($menuList[$k]['menu_url']);
					// $menuList[$k]['url'] = $menuList[$k]['menu_url'];
				}
			}
		}

		return $menuList;
	}

	/**
         * 生成的菜单数据格式
         * @var name [<菜单名称>]
         * @var url   [<菜单url>]
         * @var controller 控制器名称
         * @var list [<子菜单的数据，key和父级菜单一致>]
         */
	public $menu = array();

	public $actions = array();

	/**
	 * 生成菜单数据格式
	 * @param  [Array]  &$menuList 菜单数据列表
	 * @param  integer $pid       [上级菜单id]
	 * @param int $is_show 是否显示隐藏菜单
	 * @return [Array]             菜单格式数据
	 */
	public function createTreeMenu(&$menuList, $pid=0, $is_show=0, $position=0){
		$menu = array($pid => array());
		foreach ($menuList as $key => $list) {
			if ($list['position'] != $position && $is_show == 0) {
				continue;
			}
			$id = $list['id'];
    			$urlpath = parse_url($list['menu_url']);
			$urlpath = array_reverse(explode('/', $urlpath['path']));

    			if (count($urlpath) > 1) {
    				$controllerName = strtolower($urlpath[1]);
    			}else{
    				$controllerName = $list['id'];
    			}
                
    			//生成头菜单对应的子菜单数据格式
    			if ($list['pid'] == $pid && $pid > 0) {
    				$this->actions[$pid][] = strtolower($urlpath[0]);
    				if ($list['status'] == 0 && $is_show == 0) {
    					continue;
    				}
    				$menu[$id] = array('url' => $list['menu_url'], 'title' => $list['menu_zn'], 'id'=>$list['id'],  'list' => '');
    				unset($menuList[$key]);
    				//获取菜单对应的子菜单数据列表
    				$menu[$id]['list'] = $this->createTreeMenu($menuList, $id, $is_show);
    				if (!empty($menu[$id]['list'][$id])) {
    					$menu[$pid] = array_merge($menu[$pid], $menu[$id]['list'][$id]);
    				}
    				$menu[$id]['action'] = isset($this->actions[$id]) ? $this->actions[$id] : array();
    				$menu[$id]['action'][] = strtolower($urlpath[0]);
    				array_push($menu[$pid], $controllerName);
    				unset($menu[$id]['list'][$id]);
    			}

    			//头部菜单加入到菜单格式中
    			if ($pid == 0 && $list['pid'] == $pid) {
    				if ($list['status'] == 0 && $is_show == 0) {//菜单不显示
    					continue;
    				}
    				$menu = array('url' => $list['menu_url'], 'title' => $list['menu_zn'], 'id'=>$list['id'], 'action'=>strtolower($urlpath[0]), 'list' => array(), 'controller' => array());
    				
    				unset($menuList[$key]);
    				//获取菜单对应的子菜单数据列表
    				$menu['list'] = $this->createTreeMenu($menuList, $menu['id'], $is_show);
    				if (!empty($menu['list'][$id])) { //将子菜单的控制器名统一加入到头菜单中，以作标示是否被选中
    					$menu['controller'] = array_merge($menu['controller'], $menu['list'][$id]);
    				}
    				array_push($menu['controller'], $controllerName);
    				$menu['controller'] = array_unique($menu['controller']);		
    				unset($menu['list'][$id]);
    				$this->menu[$controllerName] = $menu;
    			}
    		}

    		if ($pid > 0 && !empty($menu)) { //如果是子菜单数据，就返回到上级菜单中
    			return $menu;
    		}
	}

	/**
	 * 将菜单格式数据，生成HTML中展示的菜单数据
	 * @return [Array.top] [头菜单数据]
	 * @return [Array.left] [左侧菜单数据]
	 */
	public function createHtmlMenu($controllerName){
		$menu = array('top' => array(), 'left' => array());
		$controllerName = strtolower($controllerName);
		foreach ($this->menu as $controller => $list) {
                         $list['isSelect'] = 0;
			//判断当前访问的控制器是否是这个头菜单，或者对应的子菜单的链接
			if (!empty($list['controller']) && in_array($controllerName, $list['controller'])) {
				$list['isSelect'] = 1;
				array_unshift($list['list'], array('title' => $list['title']));
				$menu['left'] = $list['list'];
			}

			unset($list['list']);
			$menu['top'][$controller] = $list; 
		}
		return $menu;
	}

	public $navi;
	/**
	 * 获取菜单的导航信息
	 * @param  Array  &$menuList 菜单数组
	 * @param  string  $url       当前url
	 * @param  integer $id        菜单id
	 * @return string             菜单导航链接
	 */
	public function getMenuNavi(&$menuList, $url, $id = 0){
		$navi = '<p>';
		foreach ($menuList as $list) {
		 	if (stripos($list['menu_url'],$url) > 0) {
		 		$this->navi[] = $list;
		 		$this->getMenuNavi($menuList, '', $list['pid']);
		 		break;
		 	}

		 	if ($list['id'] == $id) {
		 		$this->navi[] = $list;
		 		return true;
		 	}
		 }
		 if ($id == 0) {
		 	if ( ! empty($this->navi) ) {
		 		$this->navi = array_reverse($this->navi);
			 	$count = count($this->navi);
				 foreach ($this->navi as $key => $value) {
				 	$navi .= '<a href="'. $value['menu_url'] .'">' .$value['menu_zn']. '</a>';
				 	if (++$key < $count) {
				 		$navi .= '>';
				 	}
				 }
		 	}
		 }
		 $navi .= '</p>';
		 return $navi;
	}



}