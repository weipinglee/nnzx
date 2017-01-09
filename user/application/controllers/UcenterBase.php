<?php

use \Library\checkRight;
use \Library\PlUpload;
use \Library\photoupload;
use \Library\json;
use \Library\url;
use \Library\Safe;
use \Library\Thumb;
use \Library\tool;

/**
 * 用户中心的抽象基类
 */
class UcenterBaseController extends \nainai\controller\Base{

	/**
	 * 所有的用户中心列表的分页是这个
	 * @var integer
	 */
	protected $pagesize = 10;

	protected $certType = null;

	private static $certPage = array(
		'deal'=>'dealcert',
		'store'=>'storecert'
	);
 
	/**
	 * 设置对话框中返回的url
	 * @var [type]
	 */
	public $backUrl;
	/**
	 * 设置对话框中继续的url
	 * @var [type]
	 */
	public $goUrl;


	protected function init(){
		parent::init();//继承父类的方法，检测是否登录和角色
                    $this->getView()->setLayout('layout');
                    $controllerName = $this->_request->getControllerName();
		$actionName = $this->_request->getActionName();

        $user = new \nainai\member();
        $secret_url = $user->getSecretUrl();
        
        //判断是否需要支付密码
        if(IS_POST && in_array(strtolower($controllerName).'/'.strtolower($actionName),$secret_url)){
            $pay_secret = safe::filterPost('pay_secret') ? safe::filterPost('pay_secret') : safe::filter($this->_request->getParam('pay_secret'));
            if(!$pay_secret){
                IS_AJAX ? die(json::encode(tool::getSuccInfo(0,'请输入支付密码'))) : $this->error('请输入支付密码');die;
            }
            $sec = $user->validPaymentPassword($pay_secret);
            if(!$sec){
				IS_AJAX ? die(json::encode(tool::getSuccInfo(0,'支付密码错误'))) : $this->error('支付密码错误'); die;
            }

        }

        //确认操作
		$action_confirm = $this->_request->getParam('action_confirm');
		if(isset($action_confirm)){
			$info = safe::filter($this->_request->getParam('info'));
			$redirect = safe::filter($this->_request->getParam('redirect'));
			$redirect = $redirect ? $redirect : str_replace('/action_confirm/1','','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			$this->confirm($info ? $info : '确认此项操作？',$redirect);
			exit;
		}

		$this->getView()->setLayout('ucenter');
		//获取菜单数据
                    $MenuModel = new \nainai\user\Menu();
		$MenuModel->createTreeMenu($this->menuList);
		$menu = $MenuModel->createHtmlMenu($controllerName);
		$this->getView()->assign('topArray', $menu['top']);
		$this->getView()->assign('leftArray', $menu['left']);
                    
        
		// 判断该方法买家是否能操作，如果不能，跳转到用户中心首页
		 if($this->user_type==0 && isset($this->sellerAction) && in_array($action,$this->sellerAction)){
		 	$this->redirect(url::createUrl('/ucenter/index'));
		 }
		$this->getView()->assign('action', $actionName);
		$mess=new \nainai\message($this->user_id);
		$countNeedMess=$mess->getCountMessage();
		$this->getView()->assign('mess',$countNeedMess);
	}

	

    	/**
    	 * 设置处理成功后返回的结果
    	 * @param [Array] $returnData [返回结果]
    	 * @param string $type       [处理类型]
    	 */
    	public function HandlerHtml( & $returnData, $type='default'){
    		switch ($type) {
    			case 'default':
    				$returnData['url']['backUrl'] = $this->backUrl;
    				$returnData['url']['goUrl'] = $this->goUrl; 

    				$url = url::createUrl('/UcenterBase/defaultHtml') . '?' . http_build_query($returnData);
    				$this->redirect($url);
    				break;
    			
    			case 'json':
    				echo json::encode($returnData);
    				break;
    		}
    		exit();
    	}

    	/**
    	 * 默认的处理返回页面
    	 */
      	public function defaultHtmlAction(){
    		$success = Safe::filterGet('success', 'int');
    		$msg = Safe::filterGet('info');
    		$Url = Safe::filterGet('url');

    		$this->getView()->assign('success', $success);
    		$this->getView()->assign('msg', $msg);
    		$this->getView()->assign('url', $Url);
    	}



    	protected function success($info = '操作成功！',$redirect = ''){
    		if(isset($redirect)){
    			$redirect = str_replace('%','||',urlencode($redirect));
    		}
    		
    		$this->redirect(url::createUrl("/Oper/success?info={$info}&redirect={$redirect}"));
                exit();
    	}
        
    	protected function error($info = '操作失败！',$redirect = ''){

    		if(isset($redirect)){
    			$redirect = str_replace('%','||',urlencode($redirect));
    		}
    		$this->redirect(url::createUrl("/Oper/error?info={$info}&redirect={$redirect}"));
                    exit();
    	}

    	protected function confirm($info = '确认此项操作？',$redirect = ''){

    		if(isset($redirect)){
    			$redirect = str_replace('%','||',urlencode($redirect));
    		}
    		$this->redirect(url::createUrl("/Oper/confirm?info={$info}&redirect={$redirect}"));
    	}

        /**
         * 验证用户支付密码
         */
        public function validPaymentPasswordAction(){
            $pay_secret = safe::filterPost('pay_secret');
			if(!$pay_secret)
				$pay_secret = safe::filterGet('pay_secret');
			if(!$pay_secret)
				$pay_secret = $this->getRequst()->getParam('pay_secret');

            $user = new \nainai\user\User();
            $valid = $user->validPaymentPassword($pay_secret);
            $res = $valid === true ? tool::getSuccInfo() : tool::getSuccInfo(0,'支付密码错误');

            echo JSON::encode($res);
            return false;
        }

}

