<?php 

/**
 * 会员分组控制器
 */
use \Library\safe;
use \nainai\certificate;
use \Library\thumb;
use \nainai\subRight;
use \Library\tool;
use \Library\json;
use \Library\url;
class UsergroupController extends Yaf\Controller_Abstract{

	private $usergroupModel;
	public function init(){
		$this->usergroupModel = new UsergroupModel();
		$this->payusergroupModel = new PayUserGroupModel();
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
			$usergroupData['credit']    = safe::filterPost('credit','int');
			$usergroupData['icon']     = tool::setImgApp(safe::filterPost('imgfile2'));
			$usergroupData['caution_fee']      = safe::filterPost('caution_fee','int');
			$usergroupData['free_fee']      = safe::filterPost('free_fee','int');
			$usergroupData['depute_fee']      = safe::filterPost('depute_fee');
			$usergroupData['create_time']    = date("Y-m-d H:i:s",time());
            $res = $this->usergroupModel->usergroupUpdate($usergroupData);
            echo json::encode($res);
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
			$usergroupData['credit']    = safe::filterPost('credit','int');
			$usergroupData['icon'] = tool::setImgApp(safe::filterPost('imgfile2'));
			$usergroupData['caution_fee'] = safe::filterPost('caution_fee','int');
			$usergroupData['free_fee'] = safe::filterPost('free_fee','int');
			$usergroupData['depute_fee'] = safe::filterPost('depute_fee');
			$res = $this->usergroupModel->usergroupUpdate($usergroupData);

            echo json::encode($res);
            return false;
		}else{
			//输出页面
			$id = intval($this->_request->getParam('id'));
			$usergroupInfo = $this->usergroupModel->getusergroupInfo($id);
			if($usergroupInfo && isset($usergroupInfo['icon']))
				$usergroupInfo['icon_thumb'] = thumb::get($usergroupInfo['icon'],180,180);
			$this->getView()->assign('info',$usergroupInfo);
		}
	}

	/**
	 * 删除角色分组
	 */
	public function groupDelAction(){
		$id = intval($this->_request->getParam('id'));
		$res = $this->usergroupModel->groupDel($id);
		die(json::encode($res));
	}

	/**
	 * 设置数据状态
	 */
	public function setStatusAction(){
		if(IS_AJAX){
			$usergroupData['status'] = intval(safe::filterPost('status'));
			$usergroupData['id'] = intval($this->_request->getParam('id'));
			$res = $this->usergroupModel->usergroupUpdate($usergroupData);

            echo json::encode($res);
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
				'menu_ids' => serialize(json::filterPost('menuIds', 'int')),
				'id' => json::filterPost('id', 'int')
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
		$id = json::filter($id, 'int', 0);

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