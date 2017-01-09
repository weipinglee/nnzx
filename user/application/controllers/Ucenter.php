<?php
/**
 * 用户中心
 * User: weipinglee
 * Date: 2016/3/4 0004
 * Time: 上午 9:35
 */
use \Library\checkRight;
use \Library\photoupload;
use \Library\json;
use \Library\url;
use \Library\safe;
use \Library\Thumb;
use \Library\tool;
use \Library\PlUpload;
use \Library\Captcha;

class UcenterController extends UcenterBaseController {


    /**
     * 个人中心首页
     */
    public function indexAction(){
		  header('Location:'.url::createUrl('/ucenterindex/index'));
    }
    
    public function baseInfoAction(){
        $userModel = new UserModel();
        $userData = $userModel->getUserInfo($this->user_id);
        $this->getView()->assign('user',$userData);
    }

    public function baseEditAction(){
        $userModel = new UserModel();
        $userData = $userModel->getUserInfo($this->user_id);
        $this->getView()->assign('user',$userData);
    }

    /**
     * 支付密码管理
     */
    public function paysecretAction(){
        $userModel = new UserModel();
        $userInfo = $userModel->getUserInfo($this->user_id);
        if(IS_POST){
            $oper = safe::filterPost('oper','trim');
            $callback = safe::filterPost('callback','trim');
            $userData['id'] = $this->user_id;
            $error = '';
            switch ($oper) {
                case 'add':
                    $pay_secret = safe::filterPost('pay_secret');
                    if(!$pay_secret || !ctype_alnum($pay_secret))
                        $error = '密码格式有误';
                    $re_secret = safe::filterPost('re_secret');
                    if($re_secret != $pay_secret)
                        $error = '两次输入的密码不一致';
                    $userData['pay_secret'] = md5($pay_secret);
                    $info = '新增支付密码成功';
                    break; 
                case 'edit':
                    $ori_secret = safe::filterPost('ori_secret');
                    $new_secret = safe::filterPost('new_secret');
                    $re_secret = safe::filterPost('re_secret');
                    if($re_secret != $new_secret)
                        $error = '两次输入的密码不一致';
                    if($userInfo['pay_secret'] != md5($ori_secret))
                        $error = '原始密码错误';
                    $userData['pay_secret'] = md5($new_secret);
                    $info = '更新支付密码成功';
                    break;
                default:
                    $error = '未知操作';
                    break;
            }
            $res = empty($error) ? $userModel->updateUserInfo($userData) : tool::getSuccInfo(0,$error);
            if($callback){
                $res['returnUrl'] = $callback;
            }
            if($res['success']==1){
                $res['info'] = $info;
                $userLog=new \Library\userLog();
                $userLog->addLog(['action'=>'支付密码编辑','content'=>'编辑了支付密码']);
            }
            die(JSON::encode($res));
        }else{
            $callback = safe::filterGet('callback');

            $this->getView()->assign('pay_secret',$userInfo['pay_secret']);
            $this->getView()->assign('callback',$callback);
        }
    }

    //用户是否设置支付密码
    public function hasPaySecretAction(){
        $pass = safe::filterPost('password');
        $member = new \nainai\member();
        die(json::encode(tool::getSuccInfo(1,(int)$member->validPaymentPassword($pass))));
    }

    public function dobaseAction(){
        $data = array();
        $data['id'] = $this->user_id;
        $data['username'] = safe::filterPost('username');
        $data['email'] = safe::filterPost('email');

        $userModel = new UserModel();
        $res = $userModel->updateUserInfo($data);
        if($res['success']==1){
            $userLog=new \Library\userLog();
            $userLog->addLog(['action'=>'基本信息编辑','content'=>'编辑了基本信息']);
        }
       die(json::encode($res));
    }
    /**
     * 基本信息修改
     */
    public function infoAction(){
        $user_id = $this->user_id;
        $userModel = new userModel();
        if($this->user_type==0){
            $user_data = $userModel->getPersonInfo($user_id);
            if($user_data['birth']==0)$user_data['birth'] = '';
            if($user_data['head_photo']!='')
                $user_data['head_photo_thumb'] = Thumb::get($user_data['head_photo'],180,180);
            if($user_data['identify_front']!='')
             $user_data['identify_front_thumb'] = Thumb::get($user_data['identify_front'],180,180);
            if($user_data['identify_back']!='')
            $user_data['identify_back_thumb'] = Thumb::get($user_data['identify_back'],180,180);

        }
        else{
            $user_data = $userModel->getCompanyInfo($user_id);
            if($user_data['head_photo']!='')
                $user_data['head_photo_thumb'] = Thumb::get($user_data['head_photo'],180,180);
            if($user_data['cert_bl']!='')
                $user_data['cert_bl_thumb'] = Thumb::get($user_data['cert_bl'],180,180);
            if($user_data['cert_oc']!='')
                $user_data['cert_oc_thumb'] = Thumb::get($user_data['cert_oc'],180,180);
            if($user_data['cert_tax']!='')
                $user_data['cert_tax_thumb'] = Thumb::get($user_data['cert_tax'],180,180);

        }

        $this->getView()->assign('user',$user_data);
        $this->getView()->assign('type',$this->user_type);
        $this->getView()->assign('id',$user_id);


    }

    /**
     * 修改密码页面
     *
     */
    public function passwordAction(){
        $this->getView()->assign('id',$this->user_id);
    }

    /**
     * 修改密码动作
     */
    public function chgPassAction(){
        $user_id = $this->user_id;
        $pass = array('old_pass'=>$_POST['old_pass'],'password'=>$_POST['new_pass'],'repassword'=>$_POST['new_repass']);

        $userModel = new userModel();
        $res = $userModel->changePass($pass,$user_id);
        if($res['success']==1){
            $userLog=new \Library\userLog();
            $userLog->addLog(['action'=>'修改密码操作','content'=>'修改了密码 ']);
        }
       echo JSON::encode($res);
        return false;
    }

    /**
     * ajax上传图片
     * @return bool
     */
    public function uploadAction(){

            //调用文件上传类
            $photoObj = new photoupload();
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

    /**
     * 修改用户信息
     */
    public function personUpdateAction(){
        if(!IS_POST || !isset($_POST['id'])){
            $this->redirect('index');
            return false;
        }

        $userData['user_id'] = safe::filterPost('id','int');
        if($this->user_id == $userData['user_id']){
            $userData['username'] = safe::filterPost('username');
            $userData['email'] = safe::filterPost('email','email');
            $userData['head_photo'] = tool::setImgApp(safe::filterPost('imgfile3'));
            $personData['true_name'] = safe::filterPost('true_name');
            $personData['sex'] = safe::filterPost('sex','int',0);
            $personData['birth'] = safe::filterPost('birth','date');
            $personData['education'] = safe::filterPost('education','int');
            $personData['qq'] = safe::filterPost('qq');
            $personData['zhichen'] = safe::filterPost('zhichen');
            $personData['identify_no'] = safe::filterPost('identify_no');
            $personData['identify_front'] = tool::setImgApp(safe::filterPost('imgfile1'));
            $personData['identify_back'] = tool::setImgApp(safe::filterPost('imgfile2'));

            $um = new userModel();
            $res = $um->personUpdate($userData,$personData);
            if(isset($res['success']) && ($res['success']==1 || $res['success']==2)){
                if($res['success']==1){//数据发生变化，更改认证状态
                    $certObj = new \nainai\certificate();
                    $certObj->certInit($this->user_id);
                        $userLog=new \Library\userLog();
                        $userLog->addLog(['action'=>'基本信息编辑','content'=>'编辑了基本信息']);

                }
                $this->redirect('info');
            }
            else{
                echo $res['info'];
            }

        }
        return false;
    }

    /**
     * 修改企业用户信息
     */
    public function companyUpdateAction(){
        if(!IS_POST || !isset($_POST['id']))
            $this->redirect('index');
        $userData['user_id'] = $_POST['id'];
        if($this->user_id == $userData['user_id']){
            $userData['username'] = safe::filterPost('username');
            $userData['email'] = safe::filterPost('email','email');
            $userData['head_photo'] = tool::setImgApp(safe::filterPost('imgfile4'));

            $companyData['company_name'] = safe::filterPost('company_name');
            $companyData['area'] = safe::filterPost('area','/\d{4,6}/');
            $companyData['address'] = safe::filterPost('address');
            $companyData['category'] = safe::filterPost('category','int');
            $companyData['nature'] = safe::filterPost('nature','int');
            $companyData['legal_person'] = safe::filterPost('legal_person');
            $companyData['reg_fund'] = safe::filterPost('reg_fund','float');
            $companyData['contact'] = safe::filterPost('contact');
            $companyData['contact_duty'] = safe::filterPost('contact_duty','int');
            $companyData['contact_phone'] = safe::filterPost('contact_phone','/^\d+$/');
            $companyData['check_taker'] = safe::filterPost('check_taker');
            $companyData['check_taker_phone'] = safe::filterPost('check_taker_phone','/^\d+$/');
            $companyData['check_taker_add'] = safe::filterPost('check_taker_add');
            $companyData['deposit_bank'] = safe::filterPost('deposit_bank');
            $companyData['bank_acc'] =safe::filterPost('bank_acc','/^\d+$/');
            $companyData['tax_no'] = safe::filterPost('tax_no');
            $companyData['qq'] = safe::filterPost('qq','/^\d{4,20}$/');
            $companyData['cert_bl'] = tool::setImgApp(safe::filterPost('imgfile1'));
            $companyData['cert_oc'] = tool::setImgApp(safe::filterPost('imgfile2'));
            $companyData['cert_tax'] = tool::setImgApp(safe::filterPost('imgfile3'));

            //  print_r($personData);exit;
            $um = new userModel();
            $res = $um->companyUpdate($userData,$companyData);

            if(isset($res['success']) && ($res['success']==1 || $res['success']==2)){
                if($res['success']==1){//数据发生变化，更改认证状态
                    $certObj = new \nainai\certificate();
                    $certObj->certInit($this->user_id);
                        $userLog=new \Library\userLog();
                        $userLog->addLog(['action'=>'企业信息编辑','content'=>'编辑了企业信息']);
                }
                $this->redirect('info');
            }
            else{
                echo $res['info'];
            }

        }
        return false;
    }


    /**
     * 交易商认证页面
     *
     */
    public function dealCertAction(){
        if (intval($this->pid) == 0) {
            $cert = new certDealerModel($this->user_id,$this->user_type);
            $certData = $cert->getCertData($this->user_id);
            $certShow = $cert->getCertShow($this->user_id);
        }else{
            $cert = new certDealerModel($this->pid,$this->user_type);
            $certData = $cert->getCertData($this->pid);
            $certShow = $cert->getCertShow($this->pid);
        }

        $this->getView()->assign('certData',$certData);
        $this->getView()->assign('certShow',$certShow);
        $this->getView()->assign('userType',$certData['type']);
    }
    /**
     * 仓库认证
     */
    public function storeCertAction(){
        $cert = new certStoreModel($this->user_id,$this->user_type);
        $store = nainai\store::getStoretList();

        $certData = $cert->getDetail();
        $certData = $certData[0];
        if(isset($certData['store_id'])){
            $this->getView()->assign('store_id',$certData['store_id']);
        }

        $certShow = $cert->getCertShow();
        $this->getView()->assign('store',$store);
        $this->getView()->assign('userType',$certData['type']);
        $this->getView()->assign('certData',$certData);
        $this->getView()->assign('certShow',$certShow);

    }


    /**
     *交易商认证处理
     *
     */
    public function doDealCertAction(){

        if(IS_AJAX){
            $user_id = $this->user_id;

            $accData = array();

            if($this->user_type==1){
                $accData['company_name'] = safe::filterPost('company_name');
                $accData['legal_person'] = safe::filterPost('legal_person');
                $accData['contact'] = safe::filterPost('contact');
                $accData['contact_phone'] = safe::filterPost('phone');
                $accData['area'] = safe::filterPost('area');
                $accData['address'] = safe::filterPost('address');
                $accData['cert_bl'] = Tool::setImgApp(safe::filterPost('imgfile1'));
                $accData['cert_tax'] = Tool::setImgApp(safe::filterPost('imgfile2'));
                $accData['cert_oc'] = Tool::setImgApp(safe::filterPost('imgfile3'));
                $accData['business'] = safe::filterPost('zhuying');
            }
            else{
                $accData['true_name'] = safe::filterPost('name');
                $accData['area'] = safe::filterPost('area');
                $accData['address'] = safe::filterPost('address');
                $accData['identify_no'] = safe::filterPost('no');
                $accData['identify_front'] = Tool::setImgApp(safe::filterPost('imgfile1'));
                $accData['identify_back'] = Tool::setImgApp(safe::filterPost('imgfile2'));
            }

            $cert = new \nainai\cert\certDealer($user_id,$this->user_type);

            $res = $cert->certDealApply($accData);
            if($res['success']==1){
                $userLog=new \Library\userLog();
                $userLog->addLog(['action'=>'交易商申请','content'=>'进行了交易商申请']);
            }
            die(json::encode($res));
        }
        return false;

    }

    /**
     * 仓储认证处理
     * @return bool
     */
    public function doStoreCertAction(){
        if(IS_AJAX){
            $user_id = $this->user_id;

            $accData = array();

            if($this->user_type==1){
                $accData['company_name'] = Safe::filterPost('company_name');
                $accData['legal_person'] = Safe::filterPost('legal_person');
                $accData['contact'] = Safe::filterPost('contact');
                $accData['contact_phone'] = Safe::filterPost('phone');
                $accData['area'] = Safe::filterPost('area');
                $accData['address'] = Safe::filterPost('address');

            }
            else{
                $accData['true_name'] = Safe::filterPost('true_name');
                $accData['area'] = Safe::filterPost('area');
                $accData['address'] = Safe::filterPost('address');
            }

            $cert = new \nainai\cert\certStore($user_id,$this->user_type);
            $certData = array('store_id'=>safe::filterPost('store_id','int',0));
            if($certData['store_id']){
                $res = $cert->certStoreApply($accData,$certData);
                if($res['success']==1){
                    $userLog=new \Library\userLog();
                    $userLog->addLog(['action'=>'仓库认证','content'=>'进行了仓库认证']);
                }
                echo JSON::encode($res);
            }



        }
        return false;
    }

    /**
     * 添加子账户页面
     */
    public function subAccAction(){

        $arr = $this->getRequest()->getParams();
        $uid = safe::filter($arr['uid'],'int','');
        $user_data = array(
            'id'      => $uid,
            'username'=>'',
            'email'   => '',
            'mobile'  => '',
            'head_photo' => '',
            'status'     => 1,

        );
        if($uid){

            $userModel = new UserModel();
            $user_data = $userModel->getUserInfo($uid,$this->user_id);

            if(empty($user_data))
                $this->redirect('subAccList');
            if($user_data['head_photo']!='')
            $user_data['head_photo_thumb'] = Thumb::get($user_data['head_photo'],180,180);
        }


        $this->getView()->assign('user',$user_data);

    }



    /**
     * 子账户添加处理
     */
    public function doSubAccAction(){
        if(IS_POST){
            $userModel = new UserModel();
            $user_data = $userModel->getUserInfo($this->user_id);

            $data = array();
            $data['pid'] = $this->user_id;
            $data['username'] = safe::filterPost('username');
            $data['mobile'] = safe::filterPost('mobile','/^\d+$/');
            $data['email']    = safe::filterPost('email','email');
            $data['password'] = safe::filterPost('password','/^\S{6,20}$/');
            $data['repassword'] = safe::filterPost('repassword','/^\S{6,20}$/');
            $data['head_photo'] = tool::setImgApp(safe::filterPost('imgfile1'));
            $data['create_time'] = \Library\Time::getDateTime();
            $data['status']     = \nainai\user\USER::NOMAL;
            $data['type'] = $user_data['type'];
            $data['credit'] = 0;
            $data['cert_status'] = $user_data['cert_status'];
            $data['agent'] = $user_data['agent'];
            $data['agent_pass'] = $user_data['agent_pass'];
            $data['session_id'] = '';
            $data['gid'] = '';
            $data['pay_secret'] = $user_data['pay_secret'];
            $data['yewu'] = $user_data['yewu'];
            $data['login_ip'] = 0;
            $data['user_no'] = '';

            $userModel = new UserModel();
            if($data['user_id']==0)//新增子账户
                 $res = $userModel->subAccReg($data);
            else{//更新子账户
                if($data['password'] == ''){//账户密码为空则不修改密码
                    unset($data['password']);
                    unset($data['repassword']);
                }

                $res = $userModel->subAccUpdate($data);
            }
            if($res['success']==1){
                $userLog=new \Library\userLog();
                $userLog->addLog(['action'=>'添加子账户','content'=>'添加了子账户:' . $data['username']]);
            }
            die(json::encode($res));
        }
        return false;
    }


        /**
         * [开票信息管理]
         */
        public function invoiceAction(){
            $invoiceModel = new \nainai\user\UserInvoice();
            if (IS_POST) {
                if ($this->pid == 0) {
                    $user_id = $this->user_id;
                }else{
                    $user_id = $this->pid;
                }
                $invoiceData = array(
                    'user_id'=> $user_id,
                    'title' => Safe::filterPost('title'),
                    'tax_no' => Safe::filterPost('tax_no'),
                    'address' => Safe::filterPost('address'),
                    'phone' => Safe::filterPost('tel'),
                    'bank_name' => Safe::filterPost('bankName'),
                    'bank_no' => Safe::filterPost('bankAccount')
                );
                
                $returnData = $invoiceModel->insertupdateUserInvoice($invoiceData,$invoiceData);
                if($returnData['success']==1){
                    $userLog=new \Library\userLog();
                    $userLog->addLog(['action'=>'开票信息编辑','content'=>'编辑了开票信息']);
                }
                die(json::encode($returnData));
            }
            else{
                if ($this->pid == 0) {
                    $invoiceData = $invoiceModel->getUserInvoice($this->user_id);
                }else{
                    $invoiceData = $invoiceModel->getUserInvoice($this->pid);
                }
                
                $this->getView()->assign('data',$invoiceData);
            }
        }


    //=================================================================================

    //修改手机号码部分

    //==================================================================================



    /**
     * [mobileEditAction 用户手机修改界面]
     */
    public function mobileEditAction(){
      /*  $this->getView()->setLayout('ucenter');*/
        $userId=$this->user_id;
        $userObj=new UserModel();
        $userInfo=$userObj::getUserInfo($userId);
        $this->getView()->assign('userInfo',$userInfo);

    }
    //获取旧手机验证码
    public function getOldMobileCodeAction(){
        if(IS_AJAX||IS_POST){
            $code=safe::filterPost('mobileCode');

            $userObj=new UserModel();
            $res = $userObj->getOldMobileCode($this->user_id,$code);

            die(JSON::encode($res));
        }else{
            return false;
        }

    }
    //获取新手机验证码
    public function getNewMobileCodeAction(){
        if(IS_AJAX||IS_POST){

            $userObj=new UserModel();
            $mobile=safe::filterPost('mobile','/^\d+$/');
            $code=safe::filterPost('mobileCode');
            $res=$userObj->getNewMobileCode($this->user_id,$code,$mobile);
            die(JSON::encode($res));
        }else{
            return false;
        }

    }
    //初次检查手机验证码
    public function checkMobileCodeAction(){
        if(IS_POST||IS_AJAX) {
            $code = safe::filterPost('mobileCode', 'int');
            $userObj = new UserModel();
            $res = $userObj->checkMobileFirst($this->user_id,$code);
            die(JSON::encode($res));
        }else{
            return false;
        }
    }
    //验证第一步是否通过
    private function checkFirstStep(){
        $userObj=new UserModel();
        return $userObj->checkFirst($this->user_id);
    }
    //更换新手机
    public function MobileNewAction(){
        $firstCheck = $this->checkFirstStep();
        if($firstCheck){
            $userId=$this->user_id;
            $userObj=new UserModel();
            $userInfo=$userObj::getUserInfo($userId);
            $this->getView()->assign('userInfo',$userInfo);
        }else{
            $this->redirect('mobileEdit');
            return false;
        }


    }
    //手机修改成功
    public function MobileSuccessAction(){
        if(IS_POST||IS_AJAX){
            $userObj=new UserModel();
            $code=safe::filterPost('mobileCode');
            $newMobile= safe::filterPost('mobile','/^\d+$/');
            $res = $userObj->checkMobileSecond($this->user_id,$code,$newMobile);
            if($res['success']==1){
                $userLog=new \Library\userLog();
                $userLog->addLog(['action'=>'修改手机号','content'=>'修改了新的手机号'.$newMobile]);
            }
            die(json::encode($res));
        }else{
            $userObj=new UserModel();
            $userInfo=$userObj->getUserInfo($this->user_id);
            $checkRes=\Library\session::get('mobileValidRes2');
            if($checkRes['mobile']==$userInfo['mobile']&&time()-$checkRes['time']<1800){
                //清除验证结果
                \Library\session::clear('mobileValidRes2');
                $this->getView()->assign('userInfo',$userInfo);
            }else{
                //var_dump($_SESSION);
                $this->forward('mobileEdit');
                return false;
            }
        }

    }
    /**
     * 获取仓库详情
     */
    public function ajaxGetStoreAddressAction(){
        $id = Safe::filterPost('id', 'int');
        if (intval($id) > 0) {
            $store = new \nainai\offer\storeOffer();
            $detail = $store->getStoreListDetail($id);
        }
        exit(JSON::encode($detail));
    }


    public function shopinfoAction(){
        if (IS_POST) {
                $logoData = Safe::filterPost('imgData');
                $mapData = Safe::filterPost('map');

                $shopData = array(
                    'company_id' => $this->user_id,
                    'products' => Safe::filterPost('type'),
                    'tel' => Safe::filterPost('tel'),
                    'info' => Safe::filterPost('info'),
                    'logo_url' => $logoData[0],
                    'map_url' => $mapData[0],
                    'create_time' => \Library\Time::getDateTime()
                );
                $qaData = Safe::filterPost('qa');
                $imData = Safe::filterPost('im');

                $model = new \nainai\user\ShopInfo();
                $res = $model->insertShopInfo($shopData, $qaData, $imData);

                echo JSON::encode($res);exit();
        }

        $shopModel = new \nainai\user\ShopInfo();
        $shopData = $shopModel->getShopInfo($this->user_id);
        $shopData['logo_url'] = \Library\Thumb::get($shopData['logo_url'], 180, 180);
        $shopData['map_url'] = \Library\Thumb::get($shopData['map_url'], 180, 180);
        $companyModel = new \nainai\user\CompanyInfo();
        $companyInfo = $companyModel->getCompanyInfo($this->user_id);
        $photoModel = new \nainai\user\ShopPhotos();
        $photosList = $photoModel->getPhotosLists($this->user_id);


         $logoPlupload = new PlUpload(url::createUrl('/ManagerDeal/swfupload'), array('multi_selection'=>false));
         $qaPlupload = new PlUpload(url::createUrl('/ManagerDeal/swfupload'), array('browse_button'=>'pickfiles1', 'imgContainer'=>'showimg', 'uploadfiles'=>'uploadfiles1', 'save'=>'qa'));
         $imPlupload = new PlUpload(url::createUrl('/ManagerDeal/swfupload'), array('browse_button'=>'pickfiles2', 'imgContainer'=>'showimgs', 'uploadfiles'=>'uploadfiles2', 'save' => 'im'));
         $mapPlupload = new PlUpload(url::createUrl('/ManagerDeal/swfupload'), array('browse_button'=>'pickfiles3', 'imgContainer'=>'showimg1', 'uploadfiles'=>'uploadfiles3', 'save' => 'map', 'multi_selection'=>false));

        $this->getView()->assign('shopData',$shopData);
        $this->getView()->assign('companyInfo',$companyInfo);
        $this->getView()->assign('photosList',$photosList);
        $this->getView()->assign('logoplupload',$logoPlupload->show());
        $this->getView()->assign('qaPlupload',$qaPlupload->show());
        $this->getView()->assign('imPlupload',$imPlupload->show());
        $this->getView()->assign('mapPlupload',$mapPlupload->show());
    }

    /**
     * 支付密码step1
     */
    public function paysecretsAction(){
        $resetModel = new \nainai\user\ApplyResetpay();
        $info = $resetModel->getApplyResetpay(array('uid' => $this->user_id, 'status' => $resetModel::APPLY), 'id');
        if (intval($info['id']) > 0) {
            $this->redirect('paysecretend');
        }

        $model = new UserModel();
        $info = $model->getUserInfo($this->user_id);

        $this->getView()->assign('info', $info);
    }

    //获取手机验证码
    public function getMobileCodeAction(){
        if (IS_POST || IS_AJAX) {
            $mobile = safe::filterPost('mobile');
            $code = safe::filterPost('code');
            $captchaObj = new captcha();
            if (!$captchaObj->check($code)) {
                die(JSON::encode(\Library\tool::getSuccInfo(0, '验证码错误')));
            }
            $userObj = new UserModel();
            $info = $userObj->getUserInfo($this->user_id);
            if ($info['mobile'] != $mobile) {
                die(JSON::encode(\Library\tool::getSuccInfo(0, '验证码手机不一致')));
            }
            $res = $userObj->getForgetMobileCode($mobile, $this->user_id);
            die(JSON::encode($res));
        }
        exit(JSON::encode(tool::getSuccInfo(0, 'Error Request')));
    }

    public function checkpayMobileCodeAction(){
        $code = safe::filterPost('code');
        $uid = safe::filterPost('uid');
        $mobile = safe::filterPost('mobile');

        if (empty($uid) || empty($code)) {
            exit(json::encode(tool::getSuccInfo(0, 'Error Request')));
        }

        $model = new UserModel();
        $info = $model->getPasswordInfo($uid);
        if (time() - strtotime($info['apply_time']) > 15*60) {
            exit(json::encode(tool::getSuccInfo(0, '过期的验证')));
        }
        

        if ($info['pay_code'] == $code) {
            $model->clearPassword($uid);
            $info = $model->getUserInfo($this->user_id);
            if ($info['type'] == 1) {
                $url = url::createUrl('/ucenter/paysecretcompany');
            }else{
                $url = url::createUrl('/ucenter/paysecretperson');
            }
            exit(json::encode(tool::getSuccInfo(1, 'success', $url)));
        }else{
            exit(json::encode(tool::getSuccInfo(0, '验证码错误')));
        }
    }

    public function paysecretpersonAction(){
         if (IS_POST || IS_AJAX) {
            $model = new UserModel();
            $resetModel = new \nainai\user\ApplyResetpay();
            $info = $model->getUserInfo($this->user_id);
            $data = array(
                'name' => safe::filterPost('name'),
                'ident_no' => safe::filterPost('no'),
                'ident_img' => Tool::setImgApp(safe::filterPost('imgfile1')),
                'apply_img' => Tool::setImgApp(safe::filterPost('imgfile2')),
                'apply_time' => \Library\Time::getDateTime(),
                'uid' => $this->user_id,
                'status' => $resetModel::APPLY,
                'type' => 0,
                'mobile' => $info['mobile']
            );
            $res = $resetModel->addApplyResetpay($data);
            if ($res['success']) {
                $res['info'] = '操作成功！';
            }
           $res['returnUrl'] = url::createUrl('/ucenter/paysecretend');
            exit(json::encode($res));
        }

        $resetModel = new \nainai\user\ApplyResetpay();
        $info = $resetModel->getApplyResetpay(array('uid' => $this->user_id, 'status' => $resetModel::APPLY), 'id');
        if (intval($info['id']) > 0) {
            $this->redirect('paysecretend');
        }
    }

    public function paysecretcompanyAction(){
        if (IS_POST || IS_AJAX) {

            $model = new UserModel();
            $resetModel = new \nainai\user\ApplyResetpay();
            $info = $model->getUserInfo($this->user_id);
            $data = array(
                'company_name' => safe::filterPost('company_name'),
                'legal_person' => safe::filterPost('legal_person'),
                'ident_img' => Tool::setImgApp(safe::filterPost('imgfile1')),
                'apply_img' => Tool::setImgApp(safe::filterPost('imgfile2')),
                'apply_time' => \Library\Time::getDateTime(),
                'uid' => $this->user_id,
                'status' => $resetModel::APPLY,
                'type' => 1,
                'mobile' => $info['mobile']
            );
            $res = $resetModel->addApplyResetpay($data);
            if ($res['success']) {
                $res['info'] = '操作成功！';
            }
           $res['returnUrl'] = url::createUrl('/ucenter/paysecretend');
            exit(json::encode($res));
        }

        $resetModel = new \nainai\user\ApplyResetpay();
        $info = $resetModel->getApplyResetpay(array('uid' => $this->user_id, 'status' => $resetModel::APPLY), 'id');
        if (intval($info['id']) > 0) {
            $this->redirect('paysecretend');
        }
    }

    public function paysecretendAction(){

    }

    /**
     * 子账户列表
     */
    public function subaccListAction(){
        $model = new \nainai\user\User();
        $data = $model->getSubaccList($this->user_id);
        $this->getView()->assign('data',$data);
    }

    /**
     * 子账户权限控制
     */
    public function subaccpowAction(){
            if (IS_POST) {
            $data = array(
                'gid' => serialize(Safe::filterPost('menuIds', 'int')),
            );
            $id = Safe::filterPost('id', 'int');
            $model = new \nainai\user\User();
            $res = $model->updateUser($data, $id);
            exit(json::encode($res));
        }
        $id = $this->_request->getParam('id');
        $id = Safe::filter($id, 'int', 0);
        if (intval($id) <= 0) {
            $this->error('错误的访问方式');
        }
        $userModel = new \nainai\user\User();
        $info = $userModel->getUser($id, 'id, gid');
        $info['gid'] = unserialize($info['gid']);

        $menuModel = new \nainai\user\Menu();
        $menuList = $menuModel->getUserMenuList($this->user_id,$this->cert,$this->user_type);

        foreach ($menuList as $key => $list) {
            if (isset($list['subacc_show']) && $list['subacc_show'] == 0) {
                unset($menuList[$key]);
            }
        }
        $menuList = $menuModel->createTreeMenu($menuList, 0, 1);
        $this->getView()->assign('lists', $menuModel->menu);
        $this->getView()->assign('roleInfo', $info);
    }

    /**
     * 子账户操作记录
     */
    public function subacclogAction(){
        $model = new \Library\userLog();
        $data = $model->getList(array('pid' => $this->user_id));

        $this->getView()->assign('data', $data);
    }

    public function modifytelAction(){
        $model = new UserModel();
        $info = $model->getUserInfo($this->user_id);

        if ($info['type'] == 0) {
            $url = url::createUrl('/ucenter/modifypersontel');
        }else{
            $url = url::createUrl('/ucenter/ modifycompanytel');
        }
        $this->redirect($url);
    }

    public function modifypersontelAction(){
         if (IS_POST || IS_AJAX) {
            $mobile = safe::filterPost('mobile');
            $model = new UserModel();
            $user_id = $model->getMobileUserInfo($mobile);
            if (intval($user_id) > 0) {
               exit(json::encode(\Library\tool::getSuccInfo(0, '手机号已存在')));
            }
            $resetModel = new \nainai\user\ApplyResettel();
            $info = $model->getUserInfo($this->user_id);
            $data = array(
                'name' => safe::filterPost('name'),
                'ident_no' => safe::filterPost('no'),
                'ident_img' => Tool::setImgApp(safe::filterPost('imgfile1')),
                'apply_img' => Tool::setImgApp(safe::filterPost('imgfile2')),
                'apply_time' => \Library\Time::getDateTime(),
                'uid' => $this->user_id,
                'status' => $resetModel::APPLY,
                'type' => 0,
                'mobile' => $info['mobile'],
                'new_mobile' =>  $mobile
            );
            $res = $resetModel->addApplyResettel($data);
            if ($res['success'] == 1) {
                $res['info'] = '操作成功！';
            }
           $res['returnUrl'] = url::createUrl('/ucenter/telend');
            exit(json::encode($res));
        }

         $resetModel = new \nainai\user\ApplyResettel();
        $info = $resetModel->getApplyResettel(array('uid' => $this->user_id, 'status' => $resetModel::APPLY), 'id');
        if (intval($info['id']) > 0) {
            $this->redirect('telend');
        }
    }

    public function modifycompanytelAction(){
        if (IS_POST || IS_AJAX) {
            $model = new UserModel();
            $mobile = safe::filterPost('mobile');
            $user_id = $model->getMobileUserInfo($mobile);
            if (intval($user_id) > 0) {
               exit(json::encode(\Library\tool::getSuccInfo(0, '手机号已存在')));
            }
            $resetModel = new \nainai\user\ApplyResettel();
            $info = $model->getUserInfo($this->user_id);
            $data = array(
                'company_name' => safe::filterPost('company_name'),
                'legal_person' => safe::filterPost('legal_person'),
                'ident_img' => Tool::setImgApp(safe::filterPost('imgfile1')),
                'apply_img' => Tool::setImgApp(safe::filterPost('imgfile2')),
                'apply_time' => \Library\Time::getDateTime(),
                'uid' => $this->user_id,
                'status' => $resetModel::APPLY,
                'type' => 1,
                'mobile' => $info['mobile'],
                'new_mobile' =>  $mobile
            );
            $res = $resetModel->addApplyResettel($data);
            if ($res['success']) {
                $res['info'] = '操作成功！';
            }
           $res['returnUrl'] = url::createUrl('/ucenter/telend');
            exit(json::encode($res));
        }

         $resetModel = new \nainai\user\ApplyResettel();
        $info = $resetModel->getApplyResettel(array('uid' => $this->user_id, 'status' => $resetModel::APPLY), 'id');
        if (intval($info['id']) > 0) {
            $this->redirect('telend');
        }
    }

    public function telendAction(){

    }

}