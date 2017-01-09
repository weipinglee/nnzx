<?php
/**
 * @date 2015-9-13 
 * @author zhengyin <zhengyin.name@gmail.com>
 * @blog http://izhengyin.com
 *
 */
use \Library\M;
use \Library\Query;
use \Library\Time;
use \Library\session;
use \Library\tool;
class UserModel{

	//唯一字段
	protected $uniqueFields = array(
		'username'=>'用户名',
		'mobile'=>'手机号'
	);

	//注册时要初始化的数据表
	protected $initTables = array(
		'user_account'
	);

	/**
	 * 验证规则：
	 * array(字段，规则，错误信息，条件，附加规则，时间）
	 * 条件：0：存在字段则验证 1：必须验证 2：不为空时验证
	 *
	 */
	/**
	 * @var
	 */
	protected $userRules = array(
		array('id','number','id错误',0,'regex'),
		array('pid','number','',0,'regex'),
		array('username','/^[a-zA-Z][a-zA-Z0-9_]{2,29}$/','用户名格式错误'),
		array('password','/^\S{6,15}$/','密码格式错误',0,'regex',3),
		array('repassword','password','两次密码输入不同',0,'confirm'),
		array('type',array(0,1),'类型错误',0,'in'),
		array('head_photo','/^[a-zA-Z0-9_@\.\/]+$/','请正确上传头像',2,'regex'),
		array('mobile','mobile','手机号码错误',0,'regex'),
		array('email','email','邮箱格式错误',2,'regex'),
		array('agent','number','代理商选择错误'),
		//array('agent_pass','/^[a-zA-Z0-9]{6,30}$/','填写代理商密码')
	);

	protected $personRules = array(
		array('true_name','/.{2,20}/','真实姓名必填',0),//默认是正则
		array('sex',array(0,1),'性别错误',0,'in'),
		array('identify_no','/^\d{1,20}[a-zA-Z]?$/','请填写身份证号码'),
		array('identify_front','/^[a-zA-Z0-9_@\.\/]+$/','请上传图片'),
		array('identify_back','/^[a-zA-Z0-9_@\.\/]+$/','请上传图片'),
		array('birth','date','请正确填写生日',2,'regex'),
		array('education','number','请选择学历',2,'regex'),
		array('qq','/^\d+$/','请正确填写QQ号',2,'regex'),
		array('zhichen','require','填写职称',2,'regex')

	);

	protected $companyRules = array(
		array('company_name','s{2,30}','公司名称必填'),
		array('area','number','地区错误'),
		array('legal_person','zh{2,30}','法人填写错误'),
		array('reg_fund','double','注册资金格式错误'),
		array('category','number','企业分类错误'),
		array('nature','number','企业类型错误'),
		array('contact','require','请填写联系人'),
		array('contact_phone','mobile','填写正确的联系人手机号'),
		array('check_taker_phone','mobile','请正确填写收票人电话'),
		array('check_taker_add','require','请填写收票人地址'),
		array('deposit_bank','require','请填写开户银行'),
		array('bank_acc','number','请正确填写银行账号'),
		array('tax_no','require','请填写税号'),
		array('qq','number','请正确填写qq',2,'regex'),
		array('cert_bl','/^[a-zA-Z0-9_@\.\/]+$/','请上传图片'),
	/*	array('cert_oc','/^[a-zA-Z0-9_@\.\/]+$/','请上传图片'),
		array('cert_tax','/^[a-zA-Z0-9_@\.\/]+$/','请上传图片'),*/
		array('business','/.{1,100}/','请填写主营品种'),

	);




	static private  $userObj = '';

	public function __construct(){
		self::$userObj = new M('user');
	}

	/**
	 * 验证代理商密码是否正确
	 * @param $agentId
	 * @param $agentNo
	 */
	protected function checkAgentPass($agentId,$agentNo){
		if($agentId==0){//如果是市场，不需有密码
			return true;
		}
		else{
			$agent = new M('agent');
			$no = $agent->where(array('id'=>$agentId))->getField('serial_no');
			if($no==$agentNo){
				return true;
			}
			else return false;
		}
	}
	//个人用户注册
	public function userInsert(&$data){

		if(false===$this->checkAgentPass($data['agent'],$data['serial_no']))
			return $this->getSuccInfo(0,'代理商密码错误');

		$user = self::$userObj;
		if($user->data($data)->validate($this->userRules)){
			$exit = $this->existUser($data);
			if($exit!==false)
				return $exit;

			unset($user->repassword);
			unset($user->serial_no);
			$user->password = $data['password'] = sha1($data['password']);
			$user->beginTrans();
			$uID = $user->add();
			if(is_numeric($uID) ){
				$user->table('person_info')->data(array('user_id'=>$uID))->add();
			}
			foreach($this->initTables as $t){
				$user->table($t)->data(array('user_id'=>$uID))->add();
			}
			$res = $user->commit();

		}
		else{
			$res = $user->getError();
		}
		if($res===true){
			$data['id'] = $uID;
			$resInfo = $this->getSuccInfo(1, $uID);
		}
		else{
			$resInfo = $this->getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;
	}

	/**
	 * 统一格式返回操作成功/失败信息
	 * @param int $res 0:失败 1：成功
	 * @param string $info 错误信息
	 */
	private function getSuccInfo($res=1,$info='', $data=array()){
		return array('success'=>$res,'info'=>$info, 'data'=>$data);
	}



	/**
	 * 公司注册
	 * @param array $userData 用户数据
	 * @param array $companyData 公司数据
	 * @return string
	 */
	public function companyReg(&$userData,$companyData){

		if(false===$this->checkAgentPass($userData['agent'],$userData['serial_no']))
			return $this->getSuccInfo(0,'代理商密码错误');
		unset($userData['serial_no']);
		$user = self::$userObj;
		if($user->data($userData)->validate($this->userRules) && $user->validate($this->companyRules,$companyData)){
			$exit = $this->existUser($userData);
			if($exit!==false)
				return $exit;
			unset($user->repassword);

			$user->password = $userData['password'] = sha1($userData['password']);
			$user->beginTrans();
			$user_id = $user->add();
			$userData['id'] = $user_id;
			$companyData['user_id'] = $user_id;
			if($user_id)$user->table('company_info')->data($companyData)->add();
			foreach($this->initTables as $t){
				$user->table($t)->data(array('user_id'=>$user_id))->add();
			}
			$res = $user->commit();
		}
		else{
			$res =  $user->getError();
		}

		if(true === $res){//操作成功
			return $this->getSuccInfo();
		}else{
			return $this->getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}


	}


	/**
	 * 子账户注册
	 * @param $data
	 * @return array
	 */
	public function subAccReg($data){
		$user = self::$userObj;
		if($user->data($data)->validate($this->userRules)){
			$exit = $this->existUser($data);
			if($exit!==false)
				return $exit;
			unset($user->repassword);
			$user->password = $data['password'] = sha1($data['password']);
			$user->beginTrans();
			$res = $user->add(1);
			if (intval($res) > 0) {
				$insertCert = array('user_id' => $res, 'apply_time' => $data['create_time'], 'verify_time' => $data['create_time'], 'status' => 2, 'message' => '子账户创建，自动认证父账户信息！');
				$accountData = array(
					'user_id' => $res,
					'fund' => 0,
					'freeze' => 0,
					'ticket' => 0,
					'ticket_freeze' => 0,
					'credit' => 0
				);

				$user->table('user_account')->data($accountData)->add(1);
			}
			
		}
		else{
			$res = $user->getError();
		}
		if(is_numeric($res) && $res > 0){
			$user->commit();
			$resInfo = $this->getSuccInfo();
		}
		else{
			$user->rollback();
			$resInfo = $this->getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;
	}

	/**
	 * 子账户编辑
	 * @param $data
	 * @return array
	 */
	public function subAccUpdate($data){
		$user = self::$userObj;
		if($user->data($data)->validate($this->userRules)){
			$user_id = $data['user_id'];
			$exit = $this->existUser($data);
			if($exit!==false)
				return $exit;
			if(isset($data['password'])){
				unset($user->repassword);
				$user->password  = sha1($data['password']);
			}
			unset($user->user_id);unset($user->pid);


			$res = $user->where(array('id'=>$user_id,'pid'=>$data['pid']))->update();
		}
		else{
			$res = $user->getError();
		}
		if(is_numeric($res)){
			$resInfo = $this->getSuccInfo();
		}
		else{
			$resInfo = $this->getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;
	}


	/**
	 * 更新用户表数据
	 * @param $data
	 */
	public function updateUserInfo($data){
		$exit = $this->existUser($data);
		if($exit!==false)
			return $exit;
		if(!is_object(self::$userObj)){
			self::$userObj = new M('user');
		}
		$id = $data['id'];

		unset($data['id']);
		if(self::$userObj->validate($this->userRules,$data)){
			if(isset($data['password'])){
				$data['password']=sha1($data['password']);
			}
			$res = self::$userObj->where(array('id'=>$id))->data($data)->update();
		}
		else{
			$res = self::$userObj->getError();
		}
		if(is_int($res)){
			return \Library\tool::getSuccInfo();
		}
		else
			return \Library\tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，稍后再试');



	}
	/**验证用户是否已注册
	 * @param array $userData 用户数据
	 * @return bool  存在 返回数组 否则 false
     */
	public function existUser($data){
		if(!is_object(self::$userObj)){
			self::$userObj = new M('user');
		}

		$where = array();
		if(isset($data['id']))
			$where['id'] = array('neq'=>$data['id']);
		foreach($this->uniqueFields as $f=>$v){
			if(isset($data[$f])){
				$where = $f . '="'.$data[$f]. '" AND status IN ('.\nainai\user\User::NOMAL.','.\nainai\user\User::LOCK.')';
				$res = self::$userObj->fields('id')->where($where)->getObj();
				if(!empty($res))
					return tool::getSuccInfo(0,$v.'已存在');

			}
		}
		return false;
	}

	/**
	 * 验证用户名、密码是否正确
	 * @param string $userAcc 用户账户：用户名或 手机号
	 * @param string $password 密码（未加密）
	 */
	public function checkUser($userAcc,$password){

		$where = '(username=:username AND (password = :password OR password = :password1) OR mobile=:mobile AND (password = :password OR password = :password1)) AND status=:status';
		return self::$userObj->fields('id,username,mobile,password,type, pid')->where(array('username'=>$userAcc,'password'=>sha1($password)))->getObj();
		// return self::$userObj->fields('id,username,mobile,password,type, pid')->where($where)->bind(array('username'=>$userAcc,'password'=>sha1($password),'password1'=>base64_encode(md5($password,16)),'mobile'=>$userAcc, 'status' => \nainai\user\User::NOMAL))->getObj();
	}


	/**
	 * 个人用户认证信息验证
	 * @param array $data 个人用户数据
	 */
	public function checkPersonInfo($data){

		if(self::$userObj->validate($this->personRules,$data)){
			return true;
		}
		return self::$userObj->getError();


	}

	/**
	 * 企业用户认证信息验证
	 * @param array 企业用户数据
	 */
	public function checkCompanyInfo($data){
		if(self::$userObj->validate($this->companyRules,$data)){
			return true;
		}
		return self::$userObj->getError();
	}


	/**
	 *获取用户数据，仅user表
	 * @param int $user_id
	 * @param int $pid 父账户id
	 * @return array
     */
	public function getUserInfo($user_id,$pid=0){
		$um = self::$userObj;
		$where = $pid!=0 ? array('id'=>$user_id,'pid'=>$pid) : array('id'=>$user_id);
		return $um->fields('id,username,email,mobile,head_photo,status,pay_secret,type,agent,agent_pass,yewu,cert_status')->where($where)->getObj();
	}
	/**
	 * 获取个人用户信息
	 */
	public function getPersonInfo($user_id){
		$m = new Query('user as u');
		$m->join = 'left join person_info as p on u.id = p.user_id';
		$m->where = 'u.id='.$user_id.' and u.type=0';
		$m->limit = 1;
		$res = $m->getObj();
		return $res;
	}

	/**
	 * 获取企业用户信息
	 */
	public function getCompanyInfo($user_id){
		$m = new Query('user as u');
		$m->join = 'left join company_info as p on u.id = p.user_id';
		$m->where = 'u.id='.$user_id.' and u.type=1';
		$res = $m->getObj();
		return $res;
	}

	/**
	 * 个人用户更新信息
	 * @param array $userData 用户表数据
	 * @param array $personData 个人表数据
	 * @return array or string 操作结果
	 */
	public function personUpdate($userData,$personData){
		$user = new M('user');
		if($user->data($userData)->validate($this->userRules,2) && $user->validate($this->personRules,$personData,2)){
			$user_id = $userData['user_id'];
			if($this->existUser(array('id'=>array('neq',$user_id),'username'=>$userData['username']))){
				return $this->getSuccInfo(0,'用户名已注册');
			}
			$user->beginTrans();

			unset($userData['user_id']);
			if(($res1=$user->where(array('id'=>$user_id))->data($userData)->update()) !== false)
				$res2=$user->table('person_info')->where(array('user_id'=>$user_id))->data($personData)->update();
			if(false!==$res1 && isset($res2) && false !==$res2){//操作成功
				if($res1===0 && $res2===0){//更新成功，但数据未改变
					$user->commit();
					$res=2;
				}
				else $res=1;//此时事务不提交，后续还要更新认证状态
			}
			else{
				$res = '系统繁忙，请稍后再试';
			}
		}
		else{
			$res = $user->getError();
		}
		if(is_numeric($res)){//操作成功
			return $this->getSuccInfo($res);
		}else{
			return $this->getSuccInfo(0,$res);
		}
	}

	/**
	 * 企业用户信息更新
	 * @param array $userData 用户数据
	 * @param array $companyData 企业数据
	 */
	public function companyUpdate($userData,$companyData){
		$user = new M('user');
		if($user->data($userData)->validate($this->userRules,2) && $user->validate($this->companyRules,$companyData,2)){
			$user_id = $userData['user_id'];
			if($this->existUser(array('id'=>array('neq',$user_id),'username'=>$userData['username']))){
				return $this->getSuccInfo(0,'用户名已注册');
			}
			$user->beginTrans();

			unset($userData['user_id']);
			if(($res1=$user->where(array('id'=>$user_id))->data($userData)->update()) !== false)
				$res2=$user->table('company_info')->where(array('user_id'=>$user_id))->data($companyData)->update();

			if(false!==$res1 && isset($res2) && false !==$res2){//操作成功
				if($res1===0 && $res2===0){//更新成功，但数据未改变
					$user->commit();
					$res=2;
				}
				else $res=1;//此时事务不提交，后续还要更新认证状态
			}
			else{
				$res = '系统繁忙，请稍后再试';
			}
			//$res = $user->commit();
		}
		else{
			$res = $user->getError();
		}
		if(is_numeric($res)){//操作成功
			return $this->getSuccInfo($res);
		}else{
			return $this->getSuccInfo(0,$res);
		}
	}

	private function checkPass($user_id,$pass){
		$user = self::$userObj;
		$data = $user->where(array('id'=>$user_id,'password'=>sha1($pass)))->getObj();
		if(!empty($data)){
			return true;
		}
		return false;

	}
	/**
	 * 更改密码
	 * @param array $userData 用户密码数据
	 * @param int $user_id 用户id
	 * @return
	 */
	public function changePass($userData,$user_id){
		if($this->checkPass($user_id,$userData['old_pass'])){//原密码正确
			$user = self::$userObj;
			unset($userData['old_pass']);
			if($user->data($userData)->validate($this->userRules)){
				unset($user->repassword);
				$user->password = sha1($userData['password']);
				if($user->where(array('id'=>$user_id))->update() === false){
					$res = '系统繁忙，请稍后再试';
				}
				else{
					return $this->getSuccInfo();
				}
			}
			else{
				$res = $user->getError();
			}
			return $this->getSuccInfo(0,$res);
		}else{
			return $this->getSuccInfo(0,'原密码错误');
		}
	}


	//=================================================================================

	//修改手机号码部分

	//==================================================================================

	/**
	 * [checkPhone 验证手机是否唯一]
	 * @param     [type]      $phone [手机号]
	 * @return    [type]             [description]
	 */
	public function checkPhone($phone){

		$data=array(
			'mobile'=>$phone,
		);
		if(!is_object(self::$userObj)){
			self::$userObj=new M('user');
		}
		$user=self::$userObj;
		$data=$user->where($data)->getObj();

		if(!empty($data)){
			return $this->getSuccInfo(0,'手机号码存在');
		}
		return $this->getSuccinfo(1,'手机号不存在');

	}

	/**
	 * 验证第一步是否成功
	 */
	public function checkFirst($user_id){
		//获取验证结果
		$checkRes = session::get('mobileValidRes');
		$userInfo=$this->getUserInfo($user_id);
		if($checkRes && $userInfo['mobile']==$checkRes['mobile'] &&time()- $checkRes['time']<1800 ){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * [getMobileCode 获取手机验证码]
	 * @param     [type]      $phone  [手机号]
	 * @param     string      $type   [类型:空是旧手机,2:是新手机]
	 * @param string $save 存储方式
	 * @param Int $uid uid
	 * @param string $type 操作的类型
	 * @return    [type]              [description]
	 */
	public function getMobileCode($phone,$type='', $save='session', $uid=0, $types='login'){
		if ($save == 'database') {
			if ($types == 'login') {
				$fields = 'create_time';
			}else{
				$fields = 'apply_time';
			}
			$model = new M('user_password');
			$validDate = $model->where(array('uid'=>$uid))->getObj();
			if (!empty($validDate) && (time() - strtotime($validDate[$fields])) < 10) {
				return $this->getSuccinfo(1,'已发送',  array('uid'=>$uid));
			}
		}else{
			$validDate=session::get('mobileValidate');
			if($validDate!=null&&time()-$validDate['time'] < 120){
				return $this->getSuccinfo(0,'已发送');
			}
		}
		
		if($type==2){//更换手机
			$checkPhone=$this->checkPhone($phone);
			if($checkPhone['success']==0){
				return $checkPhone;
			}
		}else if($type==3){//找回密码
			$checkPhone=$this->checkPhone($phone);
			if($checkPhone['success']==1){
				return $checkPhone;
			}

		}
		
		$code=rand(100000,999999);
        $text = "您申请的校验码为 {$code},请尽快操作，妥善保管，如非本人操作，请忽略此信息。";
		//短信接口 TODO
		$hsms=new Library\Hsms();
		if(!$hsms->send($phone,$text)){
			return $this->getSuccInfo(0,'发送失败');
		}
		//短信发送成功，保存验证信息
		if ($save == 'database') {
			if ($types == 'login') {
				$data = array('code' => $code, 'create_time' => \Library\Time::getDateTime());
			}else{
				$data = array('pay_code' => $code, 'apply_time' => \Library\Time::getDateTime());
			}
			if (empty($validDate)) {
				$data['uid'] = $uid;
				$model->data($data)->add(0);
			}else{
				$model->where(array('uid' => $uid))->data($data)->update(0);
			}
		}else{
			session::set('mobileValidate',array('code'=>$code,'time'=>time(),'mobile'=>$phone));
		}
		
		return $this->getSuccinfo(1,'发送成功' );
	}

	/**
	 * 获取旧手机号验证码
	 * @param $user_id
	 * @param $captcha
	 * @return array
	 */
	public function getOldMobileCode($user_id,$captcha){
		$captchaObj = new \Library\captcha();
		if(!$captchaObj->check($captcha)){
			return array('success'=>0,'info'=>'验证码不正确');
		}
		$userInfo=$this->getUserInfo($user_id);
		$res=$this->getMobileCode($userInfo['mobile']);
		return $res;
	}
	/**
	 *获取新手机号验证码
	 * @param $user_id
	 * @param $captcha 图形验证码
	 * @param $mobile 新手机号
	 * @return array
	 */
	public function getNewMobileCode($user_id,$captcha,$mobile){
		$firstCheck=$this->checkFirst($user_id);

		if(!$firstCheck){
			return tool::getSuccInfo(0,'原手机未验证或验证超时',\Library\url::createUrl('/ucenter/mobileedit'));
		}

		$captchaObj = new \Library\captcha();
		if(!$captchaObj->check($captcha)){
			return array('success'=>0,'info'=>'验证码不正确');
		}
		$res=$this->getMobileCode($mobile,2);
		return $res;
	}
	/**
	 * [  检查验证码]
	 * @param     [type]      $code  [验证码]
	 * @param     [type]      $phone [手机号]
	 * @param     [type]      $type []
	 * @return    [type]             [description]
	 */
	private function checkMobileCode($code,$phone,$type=''){
		$validDate=session::get('mobileValidate');
		if($validDate!=null){
			if(time()-$validDate['time']>1800){
				return $this->getSuccinfo(0,'验证码超时');
			}
			if($validDate['mobile']!=$phone){
				return $this->getSuccinfo(0,'非法操作');
			}
			if($code!=$validDate['code']){
				return $this->getSuccinfo(0,'验证码错误');
			}
			//更换新手机号
			if($type==2){
				$checkPhone=$this->checkPhone($phone);
				if($checkPhone['success']==0){
					return $checkPhone;
				}

				session::clear('mobileValidate');
				session::clear('mobileValidRes');
				session::set('mobileValidRes2',array('mobile'=>$phone,'time'=>time()));
				return $this->getSuccinfo(1,'验证成功');

			}
			else if($type==3){//找回密码
				$checkPhone=$this->checkPhone($phone);
				if($checkPhone['success']==1){
					return $this->getSuccinfo(0,'手机号码不存在');
				}else{
					session::clear('mobileValidate');
					return $this->getSuccinfo(1,'验证通过');
				}
			}
			else{//更改手机号第一步验证
				//清除验证信息
				session::clear('mobileValidate');
				//保存验证结果信息
				session::set('mobileValidRes',array('mobile'=>$phone,'time'=>time()));
				return $this->getSuccinfo(1,'验证成功');
			}

		}else{
			return $this->getSuccinfo(0,'没有验证码');
		}
	}


	/**
	 * 第一步验证手机
	 * @param $user_id
	 * @param $code
	 * @return array
	 */
	public function checkMobileFirst($user_id,$code){
		$userInfo = $this->getUserInfo($user_id);
		return $this->checkMobileCode($code,$userInfo['mobile']);
	}
	/**
	 * 第二部验证新手机号，验证成功更新手机
	 * @param $user_id 用户id
	 * @param $code 验证码
	 * @param $newMobile 新手机号
	 */
	public function checkMobileSecond($user_id,$code,$newMobile){
		if($this->checkFirst($user_id)){//确认第一步验证通过
			$res=$this->checkMobileCode($code,$newMobile,2);
			if($res['success']==1) {
				$data = array(
					'id' => $user_id,
					'mobile' => $newMobile
				);
				return $this->updateUserInfo($data);
			}else{
				return tool::getSuccInfo(0,'验证码不正确');
			}
		}
		else{//第一步未通过，直接验证第二部，弹出错误
			return tool::getSuccInfo(0,'非法操作');
		}
	}


	//===============================================================================

	//找回密码

	//=================================================================================


	public function checkMobileForget($code,$mobile){
		return $this->checkMobileCode($code,$mobile,3);
	}

	public function getForgetMobileCode($mobile, $uid=0){
		if (!empty($mobile)) {
			if (!empty($uid)) {
				$res = $this->getMobileCode($mobile, 3, 'database', $uid, 'pay');
			}
		}else{
			$res = $this->getSuccinfo(0, '手机号不存在用户');
		}
		
		return $res;
	}

	public function getMobileUserInfo($mobile){
		if (!empty($mobile)) {
			$where = array('mobile' => $mobile);
			return self::$userObj->where($where)->getField('id');
		}
		return null;
	}

	/**
	 * 获取验证码表的信息
	 * @param  Int $uid uid
	 * @return Array      
	 */
	public function getPasswordInfo($uid){
		$res  = array();
		if ($uid > 0) {
			$model = new M('user_password');
			$res = $model->where(array('uid' => $uid))->getObj();
		}
		
		return $res;
	}

	/**
	 * 清除手机验证码，来判断是否为验证成功
	 * @param  Int $uid uid
	 * @return bool      
	 */
	public function clearPassword($uid){
		if ($uid > 0) {
			$data = array('code' => '', 'create_time'=>\Library\Time::getDateTime(), 'pay_code' => '', 'apply_time'=>\Library\Time::getDateTime());
			$model = new M('user_password');
			return $model->where(array('uid' => $uid))->data($data)->update(0);
		}
	}




}