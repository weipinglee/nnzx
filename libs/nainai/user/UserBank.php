<?php
/**
 * 用户资金管理类
 * User: Administrator
 * Date: 2016/6/21 0021
 * Time: 下午 2:05
 */
namespace nainai\user;
use \Library\M;
use \Library\tool;
class UserBank
{

    protected $table = 'user_bank';
    const BANK_APPLY = 0; //开户申请状态
    const BANK_OK = 1; //开户审核通过
    const BANK_NG = 2; //开户审核驳回

    public static $status_text = array(
        self::BANK_APPLY => '开户申请,等待审核',
        self::BANK_OK => '审核通过',
        self::BANK_NG => '审核驳回',

    );
    
    public static $message_text = array(
        self::BANK_APPLY => '',
        self::BANK_OK => '',
        self::BANK_NG => 1,  //显示审核意见

    );
    protected $outFundRules = array(
        array('id', 'number', 'id错误', 0, 'regex'),
        array('user_id', 'number', '', 0, 'regex'),
        array('request_no', 'require', '不为空'),
        array('amount', 'currency', '货币错误', 0, 'regex'),
        // array('note','mobile','手机号码错误',2,'regex'),
    );

//开户信息规则
    protected $bankRules = array(
        array('user_id', 'number', ''),
        array('bank_name', '/\S{2,50}/i', '请填写开户银行'),
        array('card_type', array(1, 2), '卡类型错误', 0, 'in'),
        array('card_no', '/^[0-9a-zA-Z]{15,22}$/i', '请填写银行账号'),
        array('true_name', '/.{2,20}/', '请填写开户名'),
        array('identify_no', '/^\d{14,17}(\d|x)$/i', '身份证号码错误'),
        array('proof', '/^[a-zA-Z0-9_@\.\/]+$/', '请上传打款凭证')

    );


    public function getCardType()
    {
        return array(
            1 => '借记卡',
            2 => '信用卡'
        );
    }

    /**
     * 获取用户开户信息
     * @param $user_id
     * @return mixed
     */
    public function getBankInfo($user_id){
        $userBank=new M('user_bank');
        return $userBank->where(array('user_id'=>$user_id))->getObj();
    }

    /**
     * 获取用户开户信息
     * @param $user_id
     * @return mixed
     */
    public function getActiveBankInfo($user_id){
        $userBank=new M('user_bank');
        return $userBank->where(array('user_id'=>$user_id,'status'=>self::BANK_OK))->getObj();
    }


    /**
     * 判断用户开户信息是否审核通过
     */
    public function checkBank($user_id){
        $data = $this->getBankInfo($user_id);
        if(!empty($data) && $data['status']==self::BANK_OK){
            return true;//审核通过
        }
        return false;
    }

}