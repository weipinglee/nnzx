<?php
/**
 * @date 2016-3-21
 * 后台会员管理
 *
 */
use \Library\M;
use \Library\Query;
use \Library\tool;
class MemberModel extends baseModel{


	/**
	 *获取用户列表
     */
	public function getList(){
		$Q = new \Library\searchQuery('user as u');
		$Q->join = 'left join agent as a on u.agent = a.id left join admin_yewu as ye on u.yewu = ye.admin_id LEFT JOIN company_info as c ON u.id=c.user_id LEFT JOIN person_info as p ON u.id=p.user_id';
		$Q->fields = 'u.*,a.username as agent_name,ye.ser_name, c.company_name, p.true_name';
		$Q->order = 'u.id asc';
		$Q->where = ' FIND_IN_SET(u.status, :s)';
		$model = new \nainai\user\User();
		$Q->bind = array('s' => $model::NOMAL . ',' . $model::LOCK);
		$data = $Q->find($this->getYewuList());
		$member = new \nainai\member();
		foreach ($data['list'] as $key => $value) {
			$data['list'][$key]['user_rank'] = $member->getUserGroup($value['id']);
		}
		$Q->downExcel($data['list'],'user', '会员列表');

		return $data;
	}

	/**
	 *
	 * @param $offer_id
	 * @param $kefu_id
	 */
	public function addYewu($offer_id,$kefu_id){
		if($offer_id && $kefu_id){
			$mem = new M('user');
			$mem->beginTrans();
			$mem->where(array('id'=>$offer_id))->data(array('yewu'=>$kefu_id))->update();
			$log  = new \Library\log();
			$log->addLog(array('content'=>'为用户'.$offer_id.'绑定业务员'.$kefu_id));
			$res = $mem->commit();
			if($res===true){
				return tool::getSuccInfo();
			}
			return tool::getSuccInfo(0,'绑定失败');
		}
		else{
			return tool::getSuccInfo(0,'操作错误');
		}
	}

	public function getOnLine($page=1){
		$queryObj=new \Library\searchQuery('user as u');
		$queryObj->join=' left join user_session as s on s.session_id=u.session_id left join company_info as c on u.id=c.user_id left join person_info as p on p.user_id=u.id';
		$queryObj->fields='u.*,c.company_name,p.true_name';
		$queryObj->where='s.session_expire>:time';
		$queryObj->bind=array('time'=>time());
		$queryObj->page=$page;
		$OnLineList=$queryObj->find();
		$OnLineList['search']['down'] = null;
		$OnLineList['search']['likes'] = null;
		$OnLineList['search']['select'] = null;
		return $OnLineList;
	}

	public function getYewuList(){
		$return = array();
		$mem = new M('admin_yewu');
		$list = $mem->fields('admin_id, ser_name')->select();
		if (!empty($list)) {
			foreach ($list as $key => $value) {
				$return[$value['admin_id']] = $value['ser_name'];
			}
		}

		return $return;
	}

}