<?php
/**
 * 交易商认证管理类
 * author: weipinglee
 * Date: 2016/4/27 0027
 * Time: 下午 3:35
 */

namespace nainai\cert;
use \Library\M;
use Library\searchQuery;
use \Library\Time;
use \Library\Query;
use \Library\Thumb;
use \Library\log;
use \Library\JSON;
class certStore extends certificate{


    protected static $certType = 'store';
    //认证需要的字段,0个人用户，1企业用户
    protected static $certFields = array(

        0=>array(
            'true_name',
            'identify_no',
            'identify_front',
            'identify_back'
        ),
        1=>array(
            'company_name',
            'area',
            'address',
            'legal_person',
            'contact',
            'contact_phone',
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
     * 申请认证
     * @param array  $accData 账户数据（个人、公司表数据）
     * @param array $certData 认证数据 （认证表的数据）
     */
    public function certStoreApply($accData,$certData=array()){

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
            return \Library\tool::getSuccInfo();
        }

        else{
            return \Library\tool::getSuccInfo(0, is_string($res)?$res : '申请失败');
        }

    }


    /**
     * 获取认证详细信息
     */
    public function getDetail($id=0){
        $userModel = new M('user');
        if($id==0)$id=$this->user_id;
        $certType = self::$certType;
        $userData = $userModel->fields('username,type,mobile,email')->where(array('id'=>$id,'pid'=>0))->getObj();

        if(!empty($userData)){
            $userDetail = $userData['type']==1 ? $this->getCompanyInfo($id) : $this->getPersonInfo($id);
            $userCert   = $userModel->table($this->getCertTable($certType))->fields('status as cert_status,apply_time,verify_time,admin_id,message,store_id')->where(array('user_id'=>$id))->getObj();
            if(isset($userCert['cert_status'])){
                 $userCert['cert_status_text'] = $this->getStatusText($userCert['cert_status']);
            }
            $store = array();
            if(isset($userCert['store_id'])){
                   $store = $userModel->table('store_list')->where(array('id'=>$userCert['store_id'],'status'=>1))->getObj();
               }
                return array(array_merge($userData,$userDetail,$userCert),$store);
        }
        return array();
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

    private function getList($condition,$status){
        $type = self::$certType;
        $table = self::getCertTable($type);
        $Q = new searchQuery($table.' as c');
        $Q->join = 'left join user as u on u.id = c.user_id left join store_list as s on c.store_id = s.id';
        $Q->fields = 'u.id,u.type,u.username,u.mobile,u.email,u.status as user_status,u.create_time,c.*,s.name as store_name';

        $Q->where = 'c.status in('.$status.')';
        $data = $Q->find(\nainai\member::getType());
        
        foreach ($data['list'] as $key => &$value) {
            $value['status_text'] = \nainai\cert\certDealer::getStatusText($value['status']);
            if ($value['type'] != '') {
                $value['type_text'] = \nainai\member::getType($value['type']);
            }else{
                $value['type_text'] = '';
            }
        }
        
        $Q->downExcel($data['list'], $condition['type'], $condition['name']);
        return $data;
    }
    /**
     * 获取申请认证用户列表
     * @param int $page 页码
     */
    public function certList($condition){
        return $this->getList($condition,self::CERT_APPLY);
    }

    //获取交易商已认证列表
    public function certedList($condition){
        return $this->getList($condition,self::CERT_INIT.','.self::CERT_SUCCESS.','.self::CERT_FAIL );
    }

    /**
     * 获取用户认证的仓库
     * @param int $user_id
     */
    public function getUserStore($user_id){
        $obj = new M(self::$certTable[self::$certType]);
        $store_id = $obj->where(array('user_id'=>$user_id,'status'=>self::CERT_SUCCESS))->getField('store_id');
        return $store_id;
    }



}