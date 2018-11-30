<?php

use \Library\safe;
use \Library\url;
use \Library\json;
use \Library\tool;

class MenuController extends InitController {

	/**
	 * 菜单列表
	 */
	public function MenuListAction(){
		$menuModel = new \nainai\user\Menu();
		$menuList = $menuModel->getMenuList();
		$menuList = $menuModel::getTreeList($menuList);

		$this->getView()->assign('lists', $menuModel::$treeList);
		$this->getView()->assign('icon', $menuModel->getIcon());
	}

	/**
	 * 添加菜单
	 */
	public function addMenuAction(){
		$menuModel = new \nainai\user\Menu();
		if (IS_POST) {
			$menuData = array(
				'menu_zn' => safe::filterPost('name'),
				'menu_url' => safe::filterPost('url'),
				'pid' => safe::filterPost('pid', 'int'),
				'create_time' => \Library\Time::getDateTime(),
				'sort' => safe::filterPost('sort', 'int'),
				'status' => safe::filterPost('status', 'int'),
				'position' => safe::filterPost('position', 'int'),
				'subacc_show' => safe::filterPost('subacc_show', 'int'),
			);

			$returnData = $menuModel->addMenu($menuData);

			if ($returnData['success'] == 1) {
				$this->redirect('MenuList');
			}else{
				echo $returnData['info'];
			}
		}

		$menuModel->getGuideCategoryOption();
		$this->getView()->assign('category', $menuModel->category);
	}

	/**
	 * 修改菜单
	 */
	public function updateMenuAction(){
		if (IS_POST) {
			$id = safe::filterPost('id', 'int');
			if (intval($id) > 0) {
				$menuData = array(
					'menu_zn' => safe::filterPost('name'),
					'menu_url' => safe::filterPost('url'),
					'sort' => safe::filterPost('sort', 'int'),
					'status' => safe::filterPost('status', 'int'),
					'pid' => safe::filterPost('pid', 'int'),
					'position' => safe::filterPost('position', 'int'),
					'subacc_show' => safe::filterPost('subacc_show', 'int'),
				);
				$menuModel = new \nainai\user\Menu();
				$returnData = $menuModel->updateMenu($menuData, $id);

				if ($returnData === TRUE) {
					$this->redirect('MenuList');
				}
			}
			$this->redirect('MenuList');
		}

		$id = $this->getRequest()->getParam('id');
		$id = safe::filter($id, 'int', 0);

		if (intval($id) > 0) {
			$menuModel = new \nainai\user\Menu();
			$detail = $menuModel->getMenu($id);
			$menuModel->getGuideCategoryOption($detail['pid']);

			$this->getView()->assign('category', $menuModel->category);
			$this->getView()->assign('detail', $detail);
		}else{
			$this->redirect('MenuList');
		}

	}

	/**
	 * 删除菜单
	 */
	public function deleteMenuAction(){
		$id = $this->getRequest()->getParam('id');
		$id = safe::filter($id, 'int', 0);

		if (intval($id) > 0) {
			$condition = array(
				'where' => 'FIND_IN_SET(id, :ids)',
				'bind' => array('ids' => $id)
			);
			$menuModel = new \nainai\user\Menu();
			$res = $menuModel->deleteMenu($id);
			echo json::encode($res);exit();
		}

		echo json::encode(tool::getSuccInfo(0, 'Fail'));exit();
	}

	/**
	 * 菜单角色的列表
	 */
	public function menuRoleListAction(){
		$MenuRoleModel = new \nainai\user\MenuRole();
		$page = safe::filterGet('page','int');
		$pageData = $MenuRoleModel->getList($page);
		$this->getView()->assign('data',$pageData['data']);
		$this->getView()->assign('bar',$pageData['bar']);
	}

	/**
	 * 添加菜单角色
	 */
	public function RoleAddAction(){
		if (IS_POST) {
			$menuData = array(
				'name' => safe::filterPost('name'),
				'cert' => safe::filterPost('name_en'),
				'explanation' => safe::filterPost('comment')
			);

			$menuModel = new \nainai\user\MenuRole();
			$returnData = $menuModel->addMenuRole($menuData);

			if ($returnData['success'] == 1) {
				$this->redirect('menuRoleList');
			}else{
				echo $returnData['info'];
			}
			exit();
		}

	}

	/**
	 * 修改菜单角色
	 */
	public function RoleEditAction(){
		if (IS_POST) {
			$id = safe::filterPost('id', 'int');
			if (intval($id) > 0) {
				$menuData = array(
					'name' => safe::filterPost('name'),
					'cert' => safe::filterPost('name_en'),
					'explanation' => safe::filterPost('comment')
				);

				$menuModel = new \nainai\user\MenuRole();
				$returnData = $menuModel->updateMenuRole($menuData, $id);

				if ($returnData === TRUE) {
					$this->redirect('menuRoleList');
				}
			}
			$this->redirect('menuRoleList');
		}

		$id = $this->getRequest()->getParam('id');
		$id = safe::filter($id, 'int', 0);

		if (intval($id) > 0) {
			$menuModel = new \nainai\user\MenuRole();
			$detail = $menuModel->getMenuRole($id, 'id, cert,name, explanation');

			$this->getView()->assign('detail', $detail);
		}else{
			$this->redirect('menuRoleList');
		}

	}

	/**
	 * 删除菜单
	 */
	public function RoleDelAction(){
		$id = $this->getRequest()->getParam('id');
		$id = safe::filter($id, 'int', 0);

		if (intval($id) > 0) {
			$menuModel = new \nainai\user\MenuRole();
			if ($menuModel->deleteMenuRole($id) === TRUE) {
				echo json::encode(tool::getSuccInfo(1, 'Success'));exit();
			}
		}

		echo json::encode(tool::getSuccInfo(0, 'Fail'));exit();
	}

	/**
	 * 给用户组分配菜单
	 */
	public function allocationUserMenuAction(){

		if (IS_POST) {
			$usergroupData = array(
				'purview' => serialize(Safe::filterPost('node_id', 'int')),
			);
			$id = safe::filterPost('id', 'int');
			$menuModel = new \nainai\user\MenuRole();
			$res = $menuModel->updateMenuRole($usergroupData, $id);
			exit(json::encode($res));
		}
		
		$id = $this->_request->getParam('id');
		$id = safe::filter($id, 'int', 0);

		if (intval($id) <= 0) {
			$this->redirect('menuRoleList');
		}

		$menuModel = new \nainai\user\MenuRole();
		$roleInfo = $menuModel->getMenuRole($id);
		$roleInfo['purview'] = unserialize($roleInfo['purview']);

		$menuModel = new \nainai\user\Menu();
		$menuList = $menuModel->getMenuList();

		$menuModel->createTreeMenu($menuList, 0, 1);
		$this->getView()->assign('roleInfo', $roleInfo);
		$this->getView()->assign('lists', $menuModel->menu);
		$this->getView()->assign('icon', $menuModel->getIcon());
	}


}