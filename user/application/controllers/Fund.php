<?php
/*
 *充值类
 * author：wzd
 * Date:2016/4/30
 */

//use Library\payments\payment;
use \Library\M;
use \Library\Payment;
use \Library\safe;
use \Library\JSON;
use \Library\Session;
use \Library\url;
use \Library\tool;

class FundController extends UcenterBaseController {

	protected  $certType = 'deal';
	public function indexAction() {

		$where = array();
		$cond['begin'] = safe::filterGet('begin');
		$cond['end'] = safe::filterGet('end');
		$cond['day'] = safe::filterGet('day','int',7);
		$cond['no'] = safe::filterGet('Sn');

		if($cond['begin'] || $cond['end']){
			$where = array('begin'=>$cond['begin'],'end'=>\Library\time::getDateTime('',strtotime($cond['end'])+24*3600-1));
		}
		else if($cond['day']){
			$where['begin'] = \Library\time::getDateTime('',time()-$cond['day']*24*3600);
		}

		if($cond['no'])
			$where['no'] = $cond['no'];
		$fundObj = \nainai\fund::createFund(1);

		$active = $fundObj->getActive($this->user_id);
		$freeze = $fundObj->getFreeze($this->user_id);
		$flowData = $fundObj->getFundFlow($this->user_id,$where);

		$this->getView()->assign('freeze',$freeze);
		$this->getView()->assign('active',$active);
		$this->getView()->assign('flow',$flowData);
		$this->getView()->assign('cond',$cond);
		//$obj = new \nainai\fund();
	}

	//绑定出金银行卡
	public function outcardAction(){
		$t = new M('fund_outcard');
		$where = array('user_id'=>$this->user_id);
		if(IS_POST){
			$data['no'] = safe::filterPost('no');
			$data['name'] = safe::filterPost('name');
			$data['bank_name'] = safe::filterPost('bank_name');

			
			$b_ext = $t->where($where)->getObj();
			if($b_ext){
				//update
				$res = $t->where($where)->data($data)->update();
			}else{
				$data['user_id'] = $this->user_id;
				$data['create_time'] = date('Y-m-d H:i:s');
				$res = $t->data($data)->add();
			}
			die(json::encode(intval($res)>0 ? tool::getSuccinfo():tool::getSuccinfo(0,'操作失败')));
			return false;
		}else{
			$bank = $t->where($where)->getObj();
			$bank = $bank ? $bank : array();

			$this->getView()->assign('bank',$bank);
		}
	}

	//中信银行签约账户
	public function zxAction(){

		$page = safe::filterGet('page','int',1);
		$startDate = safe::filterGet('startDate','trim','');
		$endDate = safe::filterGet('endDate','trim','');
 
		$zx = new \nainai\fund\zx();
		$check_sign = $zx->signStatus();
		if($check_sign !== true) {echo "<script>alert('".$check_sign.",无法交易');history.back();</script>";;exit;}
		$data = $zx->attachAccountInfo($this->user_id);

		$balance = $zx->attachBalance($this->user_id);
		
		// $details = $zx->attachTransDetails($this->user_id,$startDate,$endDate);
		$details = $zx->attachOperDetails($this->user_id,$page,$startDate,$endDate);
		
		if(!$details['row'][1]){
			if(count($details['row'])>0){
				$details['row']['TRANTYPE_TEXT'] = $zx->getTransType($details['row']['tranType']);
				$details['row']['tranAmt'] = floatval($details['row']['tranAmt']) - floatval($details['row']['pdgAmt']);
				$details['row'] = array($details['row']);
				$tmp = (array)$details['row']['memo'];
				$details['row']['memo'] = $tmp[0];
			}

		}else{
			foreach ($details['row'] as $key => &$value) {
				$value = (array)$value;
				$value['tranAmt'] = floatval($value['tranAmt']) - floatval($value['pdgAmt']);
				$value['TRANTYPE_TEXT'] = $zx->getTransType($value['tranType']);
				$tmp = (array)$value['memo'];
				$value['memo'] = $tmp[0];
			}
		}
		$page_format = $zx->pageFormat($page,count($details['row']));
		$this->getView()->assign('page_format',$page_format);

		$this->getView()->assign('page',$page);
		$this->getView()->assign('balance',$balance);
		$this->getView()->assign('no',$data['no']);
		$this->getView()->assign('flow',$details['row']);
		
		$this->getView()->assign('startDate',$startDate);
		$this->getView()->assign('endDate',$endDate);
		// echo '<pre>';var_dump($details['row']);exit;

	}

	//开通中信附属账户
	public function zxpageAction(){
		$zx = new \nainai\fund\zx();
		if(IS_POST){
			$data = array(
				'user_id'=>$this->user_id,
				'name'=>safe::filterPost('name'),
				'legal'=>safe::filterPost('legal'),
				'id_card'=>safe::filterPost('id_card'),
				'address'=>safe::filterPost('address'),
				'contact_phone'=>safe::filterPost('contact_phone'),
				'contact_name'=>safe::filterPost('contact_name'),
				'mail_address'=>safe::filterPost('mail_address'),
			);
			$res = $zx->geneAttachAccount($data);
			
			die(JSON::encode($res));
			return false;
		}else{
			$data = $zx->attachAccountInfo($this->user_id);
			$this->getView()->assign('info',$data);
		}
	}

	public function zxtxAction(){
		$t = new M('user_bank');
		$bank = $t->where(array('user_id'=>$this->user_id))->getObj();
		if(!$bank){
			$this->error('未设置开户信息',url::createUrl('/fund/bank@user'));
		}
		$this->getView()->assign('bank',$bank);
	}

	public function zxtxHandleAction(){
		if(IS_POST){
			$data['num'] = safe::filterPost('num');
			$data['user_id'] = $this->user_id;
			$zx  = new \nainai\fund\zx();
			$res = $zx->out($data);
			die(JSON::encode($res));
		}
		return false;
	}

	//处理充值操作
	public function doFundInAction() {

		$payment_id = safe::filterPost('payment_id', 'int');
		$recharge = safe::filterPost('recharge', 'float');
        $sign = safe::filterPost('sign', 'int');
        if (!isset($recharge) || $recharge <= 0  || $recharge > 99999999) {
			die(json::encode(\Library\tool::getSuccInfo(0,'金额不正确')) ) ;
		}
        //在线充值
        if (isset($payment_id) && $payment_id != '') {
            if($sign)
            {	
                $paymentInstance = Payment::createPaymentInstance($payment_id);
                $paymentRow = Payment::getPaymentById($payment_id);

                //account:充值金额; paymentName:支付方式名字
                $reData = array('account' => $recharge, 'paymentName' => $paymentRow, 'payType' => $payment_id);

                $sendData = $paymentInstance->getSendData(Payment::getPaymentInfo($payment_id, 'recharge', $reData));
                $paymentInstance->doPay($sendData);
            }
            else
            {
                $sendData['payment_id'] = $payment_id;
                $sendData['recharge'] = $recharge;
                echo json_encode($sendData);exit;
            }
        }
		//线下支付
		else {
			$payment_id = 1;
			//处理图片
			$proof = safe::filterPost('imgfile1');

			if ($proof) {

				$rechargeObj = new M('recharge_order');
				$reData = array(
					'user_id' => $this->user_id,
					'order_no' => Payment::createOrderNum(),
					//资金
					'amount' => $recharge,
					'create_time' => \Library\time::getDateTime(),
					'proot' => \Library\Tool::setImgApp($proof),
					'status' => '0',
					//支付方式
					'pay_type' => $payment_id,
				);

				$r_id = $rechargeObj->data($reData)->add();
				if($r_id){
					$adminMsg=new \nainai\AdminMsg();
					$content='新添加了一笔线下入金需要审核';
					$adminMsg->createMsg('fundinfirst',$r_id,$content);
					$userLog=new \Library\userLog();
					$userLog->addLog(['action'=>'线下充值操作','content'=>'充值了'.$recharge.'元']);
					die(json::encode(\Library\tool::getSuccInfo()));
				}

			} else {
				die(json::encode(\Library\tool::getSuccInfo(0,'请上传凭证')));
				//请上传支付凭证

			}
		}
		return false;
	}
	//充值视图
	public function czAction() {
		$where = array();
		$cond['begin'] = safe::filterGet('begin');
		$cond['end'] = safe::filterGet('end');
		$cond['day'] = safe::filterGet('day','int',7);
		$cond['no'] = safe::filterGet('Sn');
		if($cond['begin'] || $cond['end']){
			$where = array('begin'=>$cond['begin'],'end'=>$cond['end']);
		}
		else if($cond['day']){
			$where['begin'] = \Library\time::getDateTime('',time()-$cond['day']*24*3600);
		}

		if($cond['no'])
			$where['no'] = $cond['no'];

		$fund = \nainai\fund::createFund(1);
		$total = $fund->getActive($this->user_id) + $fund->getFreeze($this->user_id);
		$fundObj=new fundModel();
		$page=safe::filterGet('page','int');
		$flow=$fundObj->getFundInList($this->user_id,$where,$page);
		foreach($flow[0] as $k=>$v){
			$flow[0][$k]['pay_type']=$fundObj::getPayType($v['pay_type']);
			$flow[0][$k]['status']=$fundObj::getOffLineStatustext($v['status']);
		}
		$configs = \nainai\configs::getConfigsByType('jiesuan');
		$this->getView()->assign('pageBar',$flow[1]);
		$this->getView()->assign('cond',$cond);
		$this->getView()->assign('flow',$flow[0]);
		$this->getView()->assign('acc',$configs);
		$this->getView()->assign('total',$total);

	}

	//提现视图
	public function txAction() {
		$fund = new fundModel();
		$res = $fund->checkBank($this->user_id);
		if(!$res){
			$this->redirect('bank');
			exit;
		}
		$where = array();
		$cond['begin'] = safe::filterGet('begin');
		$cond['end'] = safe::filterGet('end');
		$cond['day'] = safe::filterGet('day','int',7);
		$cond['no'] = safe::filterGet('Sn');
		if($cond['begin'] || $cond['end']){
			$where = array('begin'=>$cond['begin'],'end'=>$cond['end']);
		}
		else if($cond['day']){
			$where['begin'] = \Library\time::getDateTime('',time()-$cond['day']*24*3600);
		}

		if($cond['no'])
			$where['no'] = $cond['no'];
		$fundObj=new fundModel();
		$page=safe::filterGet('page','int');
		$fundOutList=$fundObj->getFundOutList($this->user_id,$where,$page);

		foreach($fundOutList[0] as $k=>$v){
			$fundOutList[0][$k]['status']=fundModel::getFundOutStatusText($v['status']);
		}

		$fundObj = \nainai\fund::createFund(1);

		$active = $fundObj->getActive($this->user_id);

		$this->getView()->assign('active',$active);
		$this->getView()->assign('pageBar',$fundOutList[1]);
		$this->getView()->assign('flow',$fundOutList[0]);
		$token =  \Library\safe::createToken();
		$this->getView()->assign('token',$token);
	}
	//提现提交处理
	public function dofundOutAction() {
		$user_id = $this->user_id;
		$token = safe::filterPost('token');
		if(!safe::checkToken($token))
			return false;
		//提现申请表
		$data = array(
			'user_id' => $user_id,
			'request_no' => self::createRefundNum(),
			'amount' => safe::filterPost('amount', 'float'),
			'note' => safe::filterPost('note'),
			'create_time' => \Library\Time::getDateTime(),
		);
		$fundModel = new fundModel();
		$res = $fundModel->fundOutApply($user_id,$data);
		if($res['success']==1){
			$adminmsg=new \nainai\AdminMsg();
			$content='编号为'.$user_id.'的用户有一笔提现需要处理';
			$adminmsg->createMsg('fundoutfirst',$res['id'],$content);

		}
		die(json::encode($res));

	}
	//退款订单
	public static function createRefundNum() {
		return 'gold_' . date('YmdHis') . rand(100000, 999999);
	}

	/**
	 * [bankAction 添加开户信息]
	 * @return    [type]      [description]
	 */
	public function bankAction(){
		$fundModel = new fundModel();
		if(IS_POST||IS_AJAX){
			if ($this->pid == 0) {
				$user_id = $this->user_id;
			}else{
				$user_id = $this->pid;
			}
			$data=array(
				'user_id'=>$user_id,
				'bank_name'=>safe::filterPost('bank_name'),
				'card_type'=>safe::filterPost('card_type'),
				'card_no'=>safe::filterPost('card_no'),
				'true_name'=>safe::filterPost('true_name'),
				'apply_time' => \Library\time::getDateTime(),
				'proof'=>\Library\tool::setImgApp(safe::filterPost('imgfile2'))
			);

			$ident = safe::filterPost('identify');
			if($ident){
				$data['identify_no'] = $ident;
			}

			$res = $fundModel->bankUpdate($data);
			if($res['success']==1){
				$title = '开户审核';
				$content = '用户姓名为'.$data['true_name'].'的开户需要审核';

				$adminMsg = new \nainai\adminMsg();
				$adminMsg->createMsg('checkbankdetail',$data['user_id'],$content,$title);
			}
			die(json::encode($res));
		}
		else{//获取数据
			if ($this->pid == 0) {
				$data = $fundModel->getbankInfo($this->user_id);
			}else{
				$data = $fundModel->getbankInfo($this->pid);
			}
			
			if(!empty($data)){
				$data['proof_thumb'] = \Library\thumb::get($data['proof'],180,180);
				$this->getView()->assign('bank',$data);
				$status = fundModel::$status_text[$data['status']];
                $data['message'] = fundModel::$message_text[$data['status']] ? $data['message'] : '';
			}
			else
				$status = '未申请';
			$this->getView()->assign('status',$status);
			$this->getView()->assign('user_type',$this->user_type);
			$type = $fundModel->getCardType();
			$this->getView()->assign('type',$type);
		}
	}

	/**
	 * [upload ajax上传]
	 * @return    [type]      [description]
	 */
	public function uploadAction(){

		//调用文件上传类
		$photoObj = new \Library\photoupload();
		$photoObj->setThumbParams(array(180,180));
		$photo = current($photoObj->uploadPhoto());

		if($photo['flag'] == 1)
		{
			$result = array(
				'flag'=> 1,
				'img' => $photo['img'],
				'thumb'=> $photo['thumb'][1]
			);
		}
		else
		{
			$result = array('flag'=> $photo['flag'],'error'=>$photo['errInfo']);
		}
		echo json::encode($result);

		return false;
	}

    //支付回调
    public function rechargeCallbackAction(){
        //从URL中获取支付方式
        $payment_id      = safe::filterGet('id', 'int');
        $paymentInstance = Payment::createPaymentInstance($payment_id);

        if(!is_object($paymentInstance))
        {
            die(json::encode(\Library\tool::getSuccInfo(0,'支付方式不存在')) ) ;
        }
        
        //初始化参数
        $money   = '';
        $message = '支付失败';
        $orderNo = '';
        
        //执行接口回调函数
        $callbackData = array_merge($_POST,$_GET);
        unset($callbackData['controller']);
        unset($callbackData['action']);
        unset($callbackData['_id']);
        $return = $paymentInstance->callback($callbackData,$payment_id,$money,$message,$orderNo);
        //支付成功
        if($return){
            $recharge_no = str_replace('recharge','',$orderNo);
            
            $rechargeObj = new M('recharge_order');
            $rechargeRow = $rechargeObj->getObj('recharge_no = "'.$recharge_no.'"');
            if(empty($rechargeRow))
            {
                die(json::encode(\Library\tool::getSuccInfo(0,'充值失败')) ) ;
            }
            $dataArray = array(
                'status' => 1,
            );
            
            $rechargeObj->data($dataArray);
            $result = $rechargeObj->data($dataArray)->where('recharge_no = "'.$recharge_no.'"')->update();
            
            if(!$result)
            {
                die(json::encode(\Library\tool::getSuccInfo(0,'充值失败')) ) ;
            }

            $money   = $rechargeRow['account'];
            $user_id = $this->user_id;
            $agenA = new \nainai\fund\agentAccount();
            $res = $agenA->in($user_id, $money);
            if($res)
            {
				$userLog=new \Library\userLog();
				$userLog->addLog(['action'=>'充值操作','content'=>'充值了'.$money.'元']);
                die(json::encode(\Library\tool::getSuccInfo(1,'充值成功',url::createUrl('/fund/doFundIn'))));
                exit;
            }
            die(json::encode(\Library\tool::getSuccInfo(0,'充值失败')) ) ;
        }
        else
        {
            die(json::encode(\Library\tool::getSuccInfo(0,'充值失败')) ) ;
        }
    }

    public function subaccindexAction(){
    	$id = $this->_request->getParam('id');
	$id = Safe::filter($id, 'int', 0);
	if (intval($id) <= 0) {
		$this->error('错误的访问方式');
	}
    	$where = array();
	$cond['begin'] = safe::filterGet('begin');
	$cond['end'] = safe::filterGet('end');
	$cond['day'] = safe::filterGet('day','int',7);
	$cond['no'] = safe::filterGet('Sn');

	if($cond['begin'] || $cond['end']){
		$where = array('begin'=>$cond['begin'],'end'=>\Library\time::getDateTime('',strtotime($cond['end'])+24*3600-1));
	}
	else if($cond['day']){
		$where['begin'] = \Library\time::getDateTime('',time()-$cond['day']*24*3600);
	}

	if($cond['no'])
		$where['no'] = $cond['no'];
	$fundObj = \nainai\fund::createFund(1);

	$active = $fundObj->getActive($id);
	$freeze = $fundObj->getFreeze($id);
	$flowData = $fundObj->getFundFlow($id,$where);

	$this->getView()->assign('freeze',$freeze);
	$this->getView()->assign('uid',$id);
	$this->getView()->assign('active',$active);
	$this->getView()->assign('flow',$flowData);
	$this->getView()->assign('cond',$cond);
    }

    /**
     * 转账
     */
    public function zzAction(){
    	$fundObj = \nainai\fund::createFund(1);

	$active = $fundObj->getActive($this->user_id);
    	if (IS_POST) {
    		$token = safe::filterPost('token');
		if(!safe::checkToken($token))
			 die(json::encode(\Library\tool::getSuccInfo(0,'转账失败')) ) ;
		$to_user = safe::filterPost('uid', 'int');
		if (intval($to_user) < 1) {
			die(json::encode(\Library\tool::getSuccInfo(0,'错误的用户！')) ) ;
		}
		$user = new \nainai\user\User();
		$info = $user->getUser($to_user, 'pid, username');
		if ($info['pid'] != $this->user_id) {
			die(json::encode(\Library\tool::getSuccInfo(0,'不是该账户的子账户！')) ) ;
		}
		$data = array(
			'amount' => safe::filterPost('amount', 'float'),
			'note' => '转账备注：' . safe::filterPost('note'),
			'username' => $info['username']
		);
		if (intval($data['amount']) <= 0 OR bccomp($active, $data['amount']) == -1) {
			die(json::encode(\Library\tool::getSuccInfo(0,'转账失败,转账金额不正确！')) ) ;
		}
		
		$fundModel = new fundModel();
		$res = $fundModel->transfer($this->user_id, $to_user, $data);
		exit(json::encode($res));
    	}
    	$id = $this->_request->getParam('id');
	$id = Safe::filter($id, 'int', 0);
	if (intval($id) <= 0) {
		$this->error('错误的访问方式');
	}

	$this->getView()->assign('active',$active);
	$this->getView()->assign('uid',$id);
	$token =  \Library\safe::createToken();
	$this->getView()->assign('token',$token);
    }

    public function zztxAction(){
    	$fundObj = \nainai\fund::createFund(1);
    	
    	if (IS_POST) {
    		$token = safe::filterPost('token');
		if(!safe::checkToken($token))
			 // die(json::encode(\Library\tool::getSuccInfo(0,'转账失败')) ) ;
		$to_user = safe::filterPost('uid', 'int');
		$active = $fundObj->getActive($to_user);
		if (intval($to_user) < 1) {
			die(json::encode(\Library\tool::getSuccInfo(0,'错误的用户！')) ) ;
		}
		$user = new \nainai\user\User();
		$info = $user->getUser($to_user, 'pid, username');
		if ($info['pid'] != $this->user_id) {
			die(json::encode(\Library\tool::getSuccInfo(0,'不是该账户的子账户！')) ) ;
		}
		$data = array(
			'amount' => safe::filterPost('amount', 'float'),
			'note' => '转账备注：' . safe::filterPost('note'),
			'username' => $info['username']
		);
		if (intval($data['amount']) <= 0 OR bccomp($active, $data['amount']) == -1) {
			die(json::encode(\Library\tool::getSuccInfo(0,'转账失败,转账金额不正确！')) ) ;
		}
		
		$fundModel = new fundModel();
		$res = $fundModel->transfer($to_user, $this->user_id, $data);
		exit(json::encode($res));
    	}
    	$id = $this->_request->getParam('id');
	$id = Safe::filter($id, 'int', 0);
	
	if (intval($id) <= 0) {
		$this->error('错误的访问方式');
	}
	$active = $fundObj->getActive($id);
	$this->getView()->assign('active',$active);
	$this->getView()->assign('uid',$id);
	$token =  \Library\safe::createToken();
	$this->getView()->assign('token',$token);
    }

}
?>