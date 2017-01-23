<?php
/**
 * 用户认证处理类
 * User: weipinglee
 * Date: 2016/3/11
 * Time: 22:55
 */
namespace nainai\cert;
use conf\searchConfig;
use \Library\M;
use Library\searchQuery;
use \Library\Time;
use \Library\Query;
use \Library\Thumb;
use \Library\log;
use \Library\tool;
class certificate{

    const CERT_BEFORE  =  -1; //表示从未发起认证,不存在认证数据
    const CERT_INIT    =   0; //未发起认证,修改资料后为此状态
    const CERT_APPLY   =   1; //发起申请认证
    const CERT_FIRST_OK=4;  //初审通过
    const CERT_SUCCESS =   2; //后台确认认证通过
    const CERT_FAIL    =   3; //后台拒绝认证

    protected static $certType = '';
    public static $certTable = array(
        'deal'=>'dealer',
        'store'=>'store_manager'

    );

    public static $certText = array(
        'deal'=>'交易商认证',
        'store'=>'仓库管理员认证'
    );

    public static $certRoleText = array(
        'deal'=>'交易商',
        'store'=>'仓库'
    );

    protected static $certClass = array(
        'deal'=>'certDealer',
        'store'=>'certStore'
    );

    /**
     * @var array 认证类型对应信誉操作类型
     */
    protected static $creditConf = array(
        'deal' => 'cert_dealer',
        'store'=> 'cert_store'
    );

    /**
     * @var array 重新认证操做信誉参数类型
     */
    protected static $creditCancelConf = array(
        'deal' => 'cancel_cert_dealer',
        'store' => 'cancel_cert_store'
    );

    protected static $status_text = array(
        self::CERT_BEFORE => '未申请认证',
        self::CERT_INIT => '认证失效,需重新认证',
        self::CERT_APPLY => '等待后台审核',
        self::CERT_SUCCESS => '认证成功',
        self::CERT_FAIL => '后台审核驳回',
        self::CERT_FIRST_OK=>'初审通过'
    );

    protected static $certFields = array();


    protected $user_type = '';
    protected $user_id  ;

    public function __construct($user_id=0,$user_type=''){
        $this->user_type = $user_type==1 ? 1 : 0;
        $this->user_id   = $user_id  ;
    }

    /**
     * 获取状态信息
     * @param $status
     * @return string
     */
    public static function getStatusText($status){
        return isset(self::$status_text[$status]) ? self::$status_text[$status] : '未知';
    }
    /**
     * 验证其他的认证是否会失效
     * @param array $oldData 旧的数据
     * @param array $accData 账户数据（公司、个人表数据）
     * @return array 需要重新认证的类型数组
     */
    public function checkOtherCert($accData){
        $user_id = $this->user_id;
        $certType = self::$certType;
        $certClass = self::$certClass;
        unset($certClass[$certType]);
        $reCertType = array();//需要重新认证的类型
        $oldData = $this->getCertDetail($user_id);//包括user、个人/企业表的数据

        if(!empty($certClass)){
            foreach($certClass as $type=>$class){
                $classObj = '\nainai\cert\\'.$class;
                $fields = $classObj::$certFields[$this->user_type];

                foreach($fields as $f){
                    if(isset($oldData[$f]) && isset($accData[$f]) && $oldData[$f]!=$accData[$f]){
                        $reCertType[] = $type;
                        break;
                    }

                }

            }
        }
        return $reCertType;


    }
    /**
     * 获取用户认证状态
     */
    public function getCertStatus($user_id,$cert_type){
        $certM = new M(self::$certTable[$cert_type]);
        $status_data = $certM->where(array('user_id'=>$user_id))->getObj();
        $status_data['status'] = empty($status_data) ? self::CERT_BEFORE : $status_data['status'];
        return $status_data;
    }


    /**
     * 插入认证数据
     * @param string $certType 认证类型
     * @param array $accData 账户数据（个人、公司表数据)
     * @param array $certData 认证数据
     */
    public function createCertApply($certType,$accData,$certData){
        $user_id = $this->user_id;
        $certModel = new M(self::$certTable[$certType]);

        $status = self::CERT_APPLY;
        $update = $insert = $certData;
        $prev_cert = $certModel->where(array('user_id'=>$user_id))->getObj();

        $up = false;//是否更新了认证数据
        if(!empty($prev_cert)){//如果之前认证过
            if(!empty($certData)){
                foreach($certData as $k=>$v){
                    if($prev_cert[$k]!=$certData[$k]){
                        $up = true;
                    }
                }
            }
        }
        else{
            $up = true;

        }


        $insert['status'] = $status;
        $insert['user_id'] = $user_id;
        $insert['apply_time'] = time::getDateTime();
        $insert['message'] = ' ';
        $update['status'] = $status;
        $update['user_id'] = $user_id;
        $update['apply_time'] = time::getDateTime();
        $certModel->insertUpdate($insert,$update);//更新或插入认证数据


        if($this->user_type==1)
            $accTable = 'company_info';
        else $accTable = 'person_info';
        $accRes = $certModel->table($accTable)->data($accData)->where(array('user_id'=>$user_id))->update();

        if($up==false  && $accRes==0){//未更新数据
            return false;
        }else{
            $credit = new \nainai\CreditConfig();
            $credit->changeUserCredit($user_id,self::$creditCancelConf[$certType]);

            return true;
        }

    }

    /**
     * 后台审核认证
     * @param int $user_id 用户id
     * @param int $result 审核结果 0：驳回 1：通过
     * @param string $info 驳回原因或成功提示信息
     * @param string $type 认证类型
     */
    protected function certVerify($user_id,$result=1,$info='',$type='deal'){
        $table = self::getCertTable($type);
        $certModel = new M($table);
        $certModel->beginTrans();
        $status = $result==1 ? self::CERT_SUCCESS : ($result==2?self::CERT_FIRST_OK:self::CERT_FAIL);

        $certModel->data(array('status'=>$status,'message'=>$info,'verify_time'=>Time::getDateTime()))->where(array('user_id'=>$user_id))->update();

        $this->chgCertStatus($user_id,$certModel);
        $log = new log();
        $log->addLog(array('id'=>$user_id,'pk'=>'user_id','type'=>'check','check_text'=>self::$status_text[$status],'table'=>$table));

        if($status==self::CERT_SUCCESS){//增加信誉值
            $credit = new \nainai\CreditConfig();
            $credit->changeUserCredit($user_id,self::$creditConf[$type]);
        }
        $res = $certModel->commit();
        if($res===true){
            $mess = new \nainai\message($user_id);
            $res = $mess->send($table, $status);
            return tool::getSuccInfo();
        }
        return tool::getSuccInfo(0,'操作失败');
    }

    /**
     *认证复原，status改为0，需重新认证
     * @param array $reCert 重新认证的类型数组
     *
     */
    public function certInit($reCert){
        $tables = self::$certTable;
        $user_id = $this->user_id;

        $m = new M('');
        foreach($tables as $k=> $val){
            if(!in_array($k,$reCert))
                continue;
            $m->table($val);
            $m->data(array('status'=>self::CERT_INIT))->where(array('user_id'=>$user_id))->update();
        }

    }

    /**
     *
     * @param $user_id
     * @param $obj
     */
    protected function chgCertStatus($user_id,&$obj=null){
        $obj = new M('user');
        $obj->data(array('cert_status'=>1))->where(array('id'=>$user_id))->update();
    }

    /**
     * 获取申请认证用户列表
     * @param string $type 认证类型
     * @param int $page 页码
     * @param string $status 狀態
     */
    public function certApplyList($type,$condition,$status=1){
        if(!isset($type))return array();
        $table = self::getCertTable($type);
        $Q = new searchQuery($table.' as c');
        $Q->join = 'left join user as u on u.id = c.user_id';
        $Q->fields = 'u.id,u.type,u.username,u.mobile,u.email,u.status as user_status,u.create_time,c.*';

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
     * 获取认证类型相对应的表
     * @param string $type
     */
    protected function getCertTable($type){
        $table = '';
        if(isset(self::$certTable[$type]))
            return self::$certTable[$type];
        return $table;
    }

    /**
     * 获取申请认证的详细信息
     * @param int $id 用户id
     * @param string $certType 认证类型 如果为空，不获取认证表数据
     */
    protected function getCertDetail($id=0,$certType=''){
        $userModel = new M('user');
        if($id==0)$id=$this->user_id;
        $userData = $userModel->fields('username,type,mobile,email')->where(array('id'=>$id,'pid'=>0))->getObj();

        if(!empty($userData)){
            $userDetail = $userData['type']==1 ? $this->getCompanyInfo($id) : $this->getPersonInfo($id);
            if($certType!=''){
                $userCert   = $userModel->table($this->getCertTable($certType))->fields('status as cert_status,apply_time,verify_time,admin_id,message')->where(array('user_id'=>$id))->getObj();
                if(!empty($userCert)){
                    $userCert['cert_status_text'] = self::getStatusText($userCert['cert_status']);
                }
                return array_merge($userData,$userDetail,$userCert);
            }
            return $userDetail;

        }
        return array();

    }

    /**
     * 获取用户信息(企业或个人）
     * @param $user_id
     */
    protected function getPersonInfo($user_id){
        $um = new M('person_info');
        $result = $um->where(array('user_id'=>$user_id))->getObj();
        $result['identify_front_thumb'] = Thumb::get($result['identify_front'],180,180);
        $result['identify_back_thumb'] = Thumb::get($result['identify_back'],180,180);
        $result['identify_front_orig'] = Thumb::getOrigImg($result['identify_front']);
        $result['identify_back_orig'] = Thumb::getOrigImg($result['identify_back']);
        return $result;
    }

    /**
     * 获取用户信息(企业或个人）
     * @param $user_id
     */
    protected function getCompanyInfo($user_id){
        $um = new M('company_info');
        $result = $um->where(array('user_id'=>$user_id))->getObj();
        $result['cert_oc_thumb'] = Thumb::get($result['cert_oc'],180,180);
        $result['cert_bl_thumb'] = Thumb::get($result['cert_bl'],180,180);
        $result['cert_tax_thumb'] = Thumb::get($result['cert_tax'],180,180);

        $result['cert_oc_orig'] = Thumb::getOrigImg($result['cert_oc']);
        $result['cert_bl_orig'] = Thumb::getOrigImg($result['cert_bl']);
        $result['cert_tax_orig'] = Thumb::getOrigImg($result['cert_tax']);
        return $result;
    }


    /**
     * 验证角色认证是否通过
     * @param $user_id
     */
    public function checkCert($user_id){
        $obj = new M('');
        $result = array();
        foreach(self::$certTable as $type=>$table){
            $status = $obj->table($table)->where(array('user_id'=>$user_id))->getField('status');
            $result[$type] = $status==self::CERT_SUCCESS ? 1 : ($status==self::CERT_FIRST_OK?1:0);
        }
        return $result;
    }
    /*
 * 验证角色属于什么状态
 * */
    public function getUserCertStatus($user_id){
        $status=$this->checkCert($user_id);
        $result=array();
        foreach($status as $k=>$v){
            if($v==1){
                $result[]=self::$certRoleText[$k];
            }
        }
        return $result;
    }
}