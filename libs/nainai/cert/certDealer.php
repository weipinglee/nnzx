<?php
/**
 * 交易商认证管理类
 * author: weipinglee
 * Date: 2016/4/27 0027
 * Time: 下午 3:35
 */

namespace nainai\cert;
use \Library\M;
use \Library\Time;
use \Library\Query;
use \Library\Thumb;
use \Library\log;
use \Library\JSON;
class certDealer extends certificate{


    protected static $certType = 'deal';
    //认证需要的字段,0个人用户，1企业用户
    protected static $certFields = array(

        0=>array(
            'true_name',
            'identify_no',
            'identify_front',
            'identify_back',
            'area',
            'address'
        ),
        1=>array(
            'company_name',
            'area',
            'address',
            'legal_person',
            'contact',
            'contact_phone',
            'cert_oc',//组织机构代码证
            'cert_bl',
            'cert_tax'
        )
    );

    /**
     * 验证规则：
     * array(字段，规则，错误信息，条件，附加规则，时间）
     * 条件：0：存在字段则验证 1：必须验证 2：不为空时验证
     *
     */
    private $rules = array(
        array('user_id','number','用户id错误'),//默认是正则
    );



    /**
     *获取认证资料
     * @param $user_id
     */
    public function getCertData($user_id=0){
        return $this->getCertDetail($user_id,self::$certType);


    }



    /**
     * 认证交易商
     * @param array  $accData 账户数据（个人、公司表数据）
     * @param array $certData 认证数据 （认证表的数据）
     */
    public function certDealApply($accData,$certData=array()){

        //检验公司个人信息是否符合规则
        $m = new \UserModel();
        if($this->user_type==1){
           $check = $m->checkCompanyInfo($accData);
        }
        else
            $check = $m->checkPersonInfo($accData);
        $certObj = new M(self::$certTable[self::$certType]);

        if($check===true ){
            //检验其他的认证是否需要重新认证
            $reCertType = $this->checkOtherCert($accData);
            $certObj->beginTrans();
            if(!empty($reCertType))//若果重新认证的类型不为空，对其初始化
                $this->certInit($reCertType);

            if($this->createCertApply(self::$certType,$accData,$certData)){
                $this->chgCertStatus($this->user_id,$certObj);//更改用户表认证状态
                $res = $certObj->commit();
            }
            else{
                $certObj->rollBack();
                return \Library\Tool::getSuccInfo(0,'未修改数据');
            }


        }
        else{
            $res = $check;
        }

        if($res===true){
            return \Library\Tool::getSuccInfo();
        }

        else{
            return \Library\Tool::getSuccInfo(0,is_string($res) ? $res : '申请失败');

        }

    }

    //获取交易商待认证列表
    public function certList($condition){
       return parent::certApplyList(self::$certType,0,self::CERT_APPLY, $condition);
    }

    //获取交易商已认证列表
    public function certedList($condition){
        return parent::certApplyList(self::$certType,$condition,self::CERT_INIT.','.self::CERT_SUCCESS.','.self::CERT_FAIL.','.self::CERT_FIRST_OK, $condition);
    }

    /**
     * 获取认证详细信息
     */
    public function getDetail($id){
        return $this->getCertDetail($id,self::$certType);
    }

    /**
     * 交易商审核
     * @param int $user_id 用户id
     * @param int $result 审核结果 1：通过，0：驳回
     * @param string $info 意见
     */
    public function verify($user_id,$result=1,$info=''){
        return $this->certVerify($user_id,$result,$info,self::$certType);
    }


}