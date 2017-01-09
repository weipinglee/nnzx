<?php

use \Library\url;
use \Library\Safe;
use \Library\Tool;
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
		$page = Safe::filterGet('page', 'int', 0);
		$startDate = Safe::filterGet('startDate');
		$endDate = Safe::filterGet('endDate');
		$username = Safe::filterGet('username');

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
				'id' => Safe::filterPost('id', 'int', 0),
				'username' => Safe::filterPost('username'),
				'mobile' => Safe::filterPost('mobile'),
				'email' => Safe::filterPost('email'),
				'company_name' => Safe::filterPost('company'),
				'area' => Safe::filterPost('area', 'int'),
				'contact' => Safe::filterPost('contactName'),
				'contact_phone' => Safe::filterPost('contacttel'),
				'address' => Safe::filterPost('contactAddress'),
				'status' => Safe::filterPost('status', 'int'),
				'create_time' => \Library\Time::getDateTime()
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
		$id = Safe::filter($id, 'int', 0);

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
		$id = Safe::filter($id, 'int', 0);


		$agentData = array(
			'status' => $status,
			'id'     => $id
		);

		$agentModel = new agentModel();
		$returnData = $agentModel->update($agentData);

		die(json::encode($returnData));

	}
}