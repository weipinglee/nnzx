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
class AppBaseController extends Yaf\Controller_Abstract{

	/**
	 * 所有的用户中心列表的分页是这个
	 * @var integer
	 */
	protected $pagesize = 10;

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

