<?php
/**
 * 会员操作类
 * author: weipinglee
 * Date: 2016/5/3 0003
 * Time: 下午 5:17
 */
namespace nainai;
use \Library\M;
class member{

    protected static $userType = array(
        0=>'个人',
        1=>'企业'
    );

    protected $table = 'user';

    /**
     * 获取会员类型
     * @param $type
     * @return string
     */
    public static function getType($type=''){
        if($type==''){
            return self::$userType;
        }
        return isset(self::$userType[$type]) ? self::$userType[$type] : '未知';
    }
 
    //获取企业所有性质
    public function getComNature(){
        return $compNature = array(
            1=>'国有企业',
            2=>'集体企业',
            3=>'联营企业',
            4=>'股份合作制企业',
            5=>'私营企业',
            6=>'个体户',
            7=>'合伙企业',
            8=>'有限责任公司',
            9=>'股份有限公司'
        );
    }

    //获取企业联系人职务
    public function getComDuty(){
        return array(
            1=>'负责人',
            2=>'高级管理',
            3=>'员工'
        );
    }

    /**
     * 获取所有企业类型，以后台商品大类算
     */
    public function getComType(){
        $product = new \nainai\offer\product();
        $cate = $product->getTopCate();
        $type = array();
        foreach($cate as $key=>$v){
            $type[$key]['id'] = $cate[$key]['id'];
            $type[$key]['name'] = $cate[$key]['name'];
        }
        return $type;
    }


    /**
     * 获取会员等级
     * @param int $user_id 会员id
     */
    public  function getUserGroup($user_id){

        $userObj = new M('user');
        $userData = $userObj->where(array('id'=>$user_id))->fields('credit,vip')->getObj();
        
        $credit = $userData['credit'];
        $vip = $userData['vip'];

        // if($vip == 1){
        //     $group['group_name'] = '收费会员';
        //     $group['caution_fee'] = 0;
        //     $group['free_fee'] = 0;
        //     $group['depute_fee'] = 0;
        //     $group['icon'] = '';

        //     return $group;
        // }else
        if($credit!==false){
            $group = $userObj->table('user_group')->where('credit <=:credit')->bind(array('credit'=>$credit))->fields('group_name,icon,caution_fee,free_fee,depute_fee')->order('credit DESC')->getObj();
           if(empty($group)){
               $group = $userObj->table('user_group')->fields('group_name,icon,caution_fee,free_fee,depute_fee')->order('credit asc')->getObj();

           }
            $group['icon'] = \Library\thumb::get($group['icon'],25,25);
            $group['vip'] = $vip;
            return $group;
        }
        else
            return false;
    }

    /**
     * 调整用户会员等级
     * @param  int $user_id 用户id
     * @param  mix $group  对应等级
     */
    public function groupUpd($user_id,$group){

        $member = new M('user');
        if(is_string($group) && (strpos($group,'vip') !== FALSE)){
            //调整为收费会员
            $level = intval(str_replace('vip', '', $group));
            $res = $member->where(array('id'=>$user_id))->data(array('vip'=>$level))->update();
        }elseif(intval($group) > 0){
            //获取对应等级会员的信誉值分界线
            $obj = new M('user_group');
            $credit = $obj->where(array('id'=>$group))->getField('credit');
            $res = $member->where(array('id'=>$user_id))->data(array('credit'=>$credit))->update();
            //日志TODO  记录调整前信誉值 方便恢复
        }else{
            $res = '会员等级格式错误';
        }
        return $res > 0 ? true : $res;
    }

    /**
     * 获取即将获取的会员组信誉值和当前信誉值得差值
     */
    public function getGroupCreditGap($user_id){
        $userObj = new M('user');
        $credit = $userObj->where(array('id'=>$user_id))->getField('credit');
        if($credit!==false){
            $group = $userObj->table('user_group')->where('credit >:credit')->bind(array('credit'=>$credit))->fields('credit')->order('credit ASC')->getObj();
           if(empty($group)){//已是最高级
               return 0;
           }
            else
            return $group['credit']-$credit;
        }
        else
            return 0;
    }

    /**
     * 获取所有代理商
     */
    public function getAgentList(){
        $agent = new M('agent');
        return $agent->where(array('status'=>1))->fields('id,company_name')->select();
    }

    /**
     * 获取会员详情
     * @param mixed $user_id 用户id 为整数时是user_id,为数组时是查询条件
     */
    public function getUserDetail($cond){
        if(is_array($cond))
            $where = $cond;
        else
            $where = array('id'=>$cond);;
        $userObj = new M($this->table);
        $detail = $userObj->fields('id,type,username,credit,mobile,vip,email,head_photo,pid,roles,status,agent,create_time,yewu')->where($where)->getObj();
        $product = new \nainai\offer\product();

        if(!empty($detail)){
            $user_id = $detail['id'];
            $detail['user_type'] = self::getType($detail['type']);
            if($detail['type']==1){
                $comObj = new M('company_info');
                $data = $comObj->where(array('user_id'=>$user_id))->getObj();
                $nature = $this->getComNature();
                $data['nature_text'] = isset($nature[$data['nature']]) ? $nature[$data['nature']] : '未知';
                $data['category'] =  $product->getCateName($data['category']);
            }
            else{
                $comObj = new M('person_info');
                $data = $comObj->where(array('user_id'=>$user_id))->getObj();
            }
            return array_merge($detail,$data);
        }
        return array();

    }

    public function is_vip($user_id){
        $user = new M($this->table);
        return $user->where(array('id'=>$user_id))->getField('vip') > 0 ? true : false;
    }

    /**
     * 验证支付密码
     * @param  string $password 支付密码
     * @return boolean    1:通过 2:密码未设置，0：密码错误
     */
    public function validPaymentPassword($password,$user_id = 0){
        if(!$password) return false;
        if(!($user_id = intval($user_id))){
            $user_session = \Library\session::get('login');
            $user_id = $user_session['user_id'];
        }
        $user = new M('user');
        $pay_secret = $user->where(array('id'=>$user_id))->getField('pay_secret');
        if($pay_secret==''){
            $url = \Library\url::createUrl('/ucenter/paysecret@user').'?callback='.$_SERVER['HTTP_REFERER'];
            IS_AJAX ? die(\Library\json::encode(\Library\tool::getSuccInfo(0,'请先设置支付密码',$url))) : die('<script type="text/javascript" >window.location.href="'.$url.'"</script>');
        }
        if(md5($password) == $pay_secret){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * 获取需要认证支付密码的路径集合
     */
    public function getSecretUrl(){
        return $secret_url = array(
            'ucenter/ind1ex','ucenter/xxxx','test/form','deposit/sellerdeposit',
            'managerdeal/dofreeoffer','purchaseorder/geneorderhandle',
        );
    }




}