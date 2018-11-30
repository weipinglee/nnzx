<?php

use \Library\url;
use \Library\safe;
use \Library\tool;
use \Library\json;
use \member\agentModel;
/**
 * 代理商
 */
class AgentController extends InitController{

	/**
	 * 代理商列表
	 */
	public function agentListAction(){
		$page = safe::filterGet('page', 'int', 0);
		$startDate = safe::filterGet('startDate');
		$endDate = safe::filterGet('endDate');
		$username = safe::filterGet('username');

		$where = ' 1 ';
		$bind = array();

		if (!empty($startDate)) {
			$where .= ' AND create_time>=:startDate';
			$bind['startDate'] = $startDate . ' 00:00:00';
		}

		if (!empty($endDate)) {
			$where .= ' AND create_time<=:endDate';
			$bind['endDate'] = $endDate . ' 23:59:59';
		}

		if (!empty($username)) {
			$where .= ' AND username like "%'.$username.'%"';
		}

		$agentModel = new agentModel();
		$agentData = $agentModel->getAgentList($page, $where, $bind);

		$this->getView()->assign('agentData', $agentData['list']);
		$this->getView()->assign('pageHtml', $agentData['pageHtml']);
	}

	/**
	 * 添加代理商
	 */
	public function addAgentAction(){
		if (IS_POST) {
			$agentData = array(
				'id' => safe::filterPost('id', 'int', 0),
				'username' => safe::filterPost('username'),
				'mobile' => safe::filterPost('mobile'),
				'email' => safe::filterPost('email'),
				'company_name' => safe::filterPost('company'),
				'area' => safe::filterPost('area', 'int'),
				'contact' => safe::filterPost('contactName'),
				'contact_phone' => safe::filterPost('contacttel'),
				'address' => safe::filterPost('contactAddress'),
				'status' => safe::filterPost('status', 'int'),
				'create_time' => \Library\time::getDateTime()
			);

			$agentModel = new agentModel();
			$returnData = $agentModel->update($agentData);

			die(json::encode($returnData));
		}else{
			$id = $this->getRequest()->getParam('id');
			$id = Safe::filter($id, 'int', 0);

			if (intval($id) > 0) {
				$agentModel = new agentModel();
				$agentData = $agentModel->getAgentDetail($id);
				$this->getView()->assign('agentData', $agentData);
			}
		}

	}



	/**
	 * 删除代理商
	 */
	public function deleteAgentAction(){
		$id = $this->getRequest()->getParam('id');
		$id = safe::filter($id, 'int', 0);

		$agentModel = new agentModel();
		$returnData = $agentModel->delete($id);

		die(json::encode($returnData));

	}

	/**
	 * 更换代理商状态
	 */
	public function ajaxUpdateAgentStatusAction(){
		$id = $this->getRequest()->getParam('id');
		$status = safe::filterPost('status','int',0);
		$id = safe::filter($id, 'int', 0);


		$agentData = array(
			'status' => $status,
			'id'     => $id
		);

		$agentModel = new agentModel();
		$returnData = $agentModel->update($agentData);

		die(json::encode($returnData));

	}
}