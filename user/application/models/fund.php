<?php
/**
 * 出入金管理类
 * User: weipinglee
 * Date: 2016/5/10 0010
 * Time: 下午 1:27
 */
use \Library\M;
use \Library\tool;
class fundModel extends \nainai\user\UserBank{

    CONST OFFLINE = 1;//线下入金类型编码
    CONST DIRECT  = 2;//支付宝
    CONST UNION   = 3;//银联

    CONST OFFLINE_APPLY = 0;
    CONST OFFLINE_FIRST_OK = 2;//初审通过
    CONST OFFLINE_FIRST_NG = 3;//初审驳回
    CONST OFFLINE_FINAL_OK = 1;//终审通过，入金成功
    CONST OFFLINE_FINAL_NG = 4;//终审驳回
    //提现状态
    private static $fundOutStatusText=array(
        0=>'申请提现',
        2=>'初审通过',
        3=>"初审驳回",
        4=>'终审驳回',
        5=>'终审通过',
        1=>'出金完成'
    );
    /**
     *
     * @param $user_id
     * @param $data
     * @return bool
     */
    public function fundOutApply($user_id,$data){

        $fundModel = \nainai\fund::createFund(1);
        $userFund = $fundModel->getActive($user_id);
        $amount = $data['amount'];
        $withdrawRequest = new M('withdraw_request');
        if ($userFund != 0 && $userFund >= $amount) {
            $check = $withdrawRequest->validate($this->outFundRules,$data);
            if(false == $check)
                 return tool::getSuccInfo(0,$withdrawRequest->getError());

            $withdrawRequest->beginTrans();
            $id=$withdrawRequest->data($data)->add();

            //冻结资金
            $fundModel->freeze($user_id, $amount, '提现冻结,金额：'.$amount);

            $res = $withdrawRequest->commit();
            if($res){
                $userLog=new \Library\userLog();
                $userLog->addLog(['action'=>'提现操作','content'=>'申请提现'.$data['amount'].'元']);
                return tool::getSuccInfo('1','','',$id);

            }
            else{
                return tool::getSuccInfo(0,'提现失败');
            }

        } else {

            return tool::getSuccInfo(0,'账户资金不足');
        }
    }


    /**
     * 插入更新开户信息
     * @param $data
     * @return \Library\查询结果|string
     */
    public function bankUpdate($data){
        $userBank=new M('user_bank');
        $data['status'] = self::BANK_APPLY;
        if($userBank->validate($this->bankRules,$data)){
            $res = $userBank->insertUPdate($data,$data);
        }
        else{
            $res = $userBank->getError();
        }

        if(is_int($res)){
            $userLog=new \Library\userLog();
            $userLog->addLog(['action'=>'编辑开户信息操作','content'=>'编辑了卡号为'.$data['card_no'].'的开户信息']);
            return tool::getSuccInfo();
        }
        else{
            return tool::getSuccInfo(0,is_string($res)?$res : '操作失败');
        }
    }
    public function getFundInList($user_id,$cond,$page=1){
        if($user_id) {
            $fundInObj = new \Library\Query('recharge_order as r');
            $where = 'is_del=0 and user_id= :user_id';
            $cond['user_id']=$user_id;
            if (isset($cond['begin'])&&$cond['begin']!=""){
                $where.=' and create_time > :begin' ;
            }else{
                unset($cond['begin']);
            }
            if(isset($cond['end'])&&$cond['end']!=""){
                $where.=' and create_time < :end';
            }else{
                unset($cond['end']);
            }
            if(isset($cond['no'])&&$cond['no']!=''){
                $where.=' and order_no= :no';
            }else{
                unset($cond['no']);
            }
            $fundInObj->where=$where;
            $fundInObj->bind=$cond;
            $fundInObj->page = $page;
            $fundInList=$fundInObj->find();
            $pageBar=$fundInObj->getPageBar();
            return [$fundInList,$pageBar];

        }
    }
    public static function getPayType($payID){
        switch(intval($payID)){
            case self::OFFLINE : {
                return '线下';
            }
                break;
            case self::DIRECT : {
                return '支付宝即时到账';
            }
                break;
            case self::UNION : {
                return '银联支付';
            }
                break;

            default : {
                return '未知';
            }
                break;
        }
    }
    /**
     * 线下入金订单状态获取
     * @param int $status 状态
     * @return string 状态文字
     */
    public static function getOffLineStatustext($status){
        switch(intval($status)){
            case self::OFFLINE_APPLY : {
                return '申请入金';
            }
                break;
            case self::OFFLINE_FIRST_OK : {
                return '初审通过';
            }
                break;
            case self::OFFLINE_FIRST_NG : {
                return '初审驳回';
            }
                break;
            case self::OFFLINE_FINAL_OK : {
                return '入金成功';
            }
                break;
            case self::OFFLINE_FINAL_NG : {
                return '终审驳回';
            }
                break;

            default : {
                return '未知';
            }
                break;
        }
    }
    public static function getFundOutStatusText($status){
            return self::$fundOutStatusText[$status];

    }
    public function getFundOutList($user_id,$cond,$page=1){
        if($user_id) {
            $fundInObj = new \Library\Query('withdraw_request as r');
            $where = 'is_del=0 and user_id= :user_id';
            $cond['user_id']=$user_id;
            if (isset($cond['begin'])&&$cond['begin']!=""){
                $where.=' and create_time > :begin' ;
            }else{
                unset($cond['begin']);
            }
            if(isset($cond['end'])&&$cond['end']!=""){
                $where.=' and create_time < :end';
            }else{
                unset($cond['end']);
            }
            if(isset($cond['no'])&&$cond['no']!=''){
                $where.=' and request   _no= :no';
            }else{
                unset($cond['no']);
            }
            $fundInObj->where=$where;
            $fundInObj->bind=$cond;
            $fundInObj->page = $page;
            $fundInList=$fundInObj->find();
            $pageBar=$fundInObj->getPageBar();
            return [$fundInList,$pageBar];

        }
    }

    public function transfer($user_id, $to_user, $data){
        $model = new M('user_account');
        $model->beginTrans();
        $agen = new \nainai\fund\agentAccount();
        $res = $agen->transfer($user_id, $to_user, $data);
        if ($res) {
            $userLog=new \Library\userLog();
            $userLog->addLog(['action'=>'转账操作','content'=>'转账给用户 '.$data['username'].' ,转账金额：'.$data['amount'].'元']);
            $model->commit();
           return tool::getSuccInfo('1','转账成功','',$id);
        }else{
            $model->rollback();
            return tool::getSuccInfo('1','转账失败！','',$id);
        }
    }

}