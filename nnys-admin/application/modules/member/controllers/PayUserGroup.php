<?php 

/**
 * 会员分组控制器
 */
use \Library\safe;
use \nainai\certificate;
use \Library\Thumb;
use \nainai\subRight;
use \Library\tool;
use \Library\JSON;
use \Library\url;
class PayUsergroupController extends Yaf\Controller_Abstract{

	private $usergroupModel;
	public function init(){
		$this->usergroupModel = new PayUserGroupModel();
		$this->getView()->setLayout('admin');
		//echo $this->getViewPath();
	}

	/**
	 * 获取角色分组列表
	 * @return 
	 */
	public function groupListAction(){
		$page = safe::filterGet('page','int');
		$pageData = $this->usergroupModel->getList($page);
		$this->getView()->assign('data',$pageData['data']);
		$this->getView()->assign('bar',$pageData['bar']);
	}

	/**
	 * 新增页面
	 */
	public function groupAddAction(){
		if(IS_AJAX){
			$usergroupData['group_name'] = safe::filterPost('group_name');
			$usergroupData['icon']     = tool::setImgApp(safe::filterPost('imgfile2'));
			$usergroupData['create_time']    = date("Y-m-d H:i:s",time());
            $res = $this->usergroupModel->usergroupUpdate($usergroupData);
            echo JSON::encode($res);
            return false;
		}
	}

	/**
	 * 修改页面
	 */
	public function groupEditAction(){
		if(IS_AJAX){
			$usergroupData['id'] = safe::filterPost('id','int');
			$usergroupData['group_name']  = safe::filterPost('group_name');
			$usergroupData['icon'] = tool::setImgApp(safe::filterPost('imgfile2'));
			$res = $this->usergroupModel->usergroupUpdate($usergroupData);
			
            echo JSON::encode($res);
            return false;
		}else{
			//输出页面
			$id = intval($this->_request->getParam('id'));
			$usergroupInfo = $this->usergroupModel->getusergroupInfo($id);
			if($usergroupInfo && isset($usergroupInfo['icon']))
				$usergroupInfo['icon_thumb'] = Thumb::get($usergroupInfo['icon'],180,180);
			$this->getView()->assign('info',$usergroupInfo);
		}
	}

	/**
	 * 删除角色分组
	 */
	public function groupDelAction(){
		$id = intval($this->_request->getParam('id'));
		$res = $this->usergroupModel->groupDel($id);
		die(JSON::encode($res));
	}

	/**
	 * 设置数据状态
	 */
	public function setStatusAction(){
		if(IS_AJAX){
			$usergroupData['status'] = intval(safe::filterPost('status'));
			$usergroupData['id'] = intval($this->_request->getParam('id'));
			$res = $this->usergroupModel->usergroupUpdate($usergroupData);

            echo JSON::encode($res);
            return false;
		}
		return false;
	}

	/**
	 * 给用户组分配菜单
	 */
	public function allocationUserMenuAction(){

		if (IS_POST) {
			$usergroupData = array(
				'menu_ids' => serialize(Safe::filterPost('menuIds', 'int')),
				'id' => Safe::filterPost('id', 'int')
			);
			$res = $this->usergroupModel->usergroupUpdate($usergroupData);

			if ($res['success'] == 1) {
				$this->redirect('groupList');
			}else{
				echo $res['info'];
			}
			exit();
		}
		
		$id = $this->_request->getParam('id');
		$id = Safe::filter($id, 'int', 0);

		if (intval($id) <= 0) {
			$this->redirect('groupList');
		}

		$usergroupInfo = $this->usergroupModel->getusergroupInfo($id);
		$usergroupInfo['menu_ids'] = unserialize($usergroupInfo['menu_ids']);

		$menuModel = new \nainai\user\Menu();
		$menuList = $menuModel->getMenuList();
		$menuList = $menuModel::getTreeList($menuList);

		$this->getView()->assign('usergroupInfo', $usergroupInfo);
		$this->getView()->assign('lists', $menuModel::$treeList);
		$this->getView()->assign('icon', $menuModel->getIcon());
	}


}
 ?>