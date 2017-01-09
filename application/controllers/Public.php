<?php
/**
 * 交易中心不需要登录的控制器公共类
 */
use \Library\url;
use \nainai\offer\product;
class PublicController extends \Yaf\Controller_Abstract{

     public $login;

     public function init(){
          $right = new \Library\checkRight();
          $isLogin = $right->checkLogin();
          $this->getView()->setLayout('layout');
          //获取所有分类
          $productModel=new product();
          $res=$productModel->getAllCat();
          $res = array_slice($res,0,6);
          $this->getView()->assign('catList',$res);
       //   $frdLink = new \nainai\system\friendlyLink();
          //获取帮助
          $helpModel=new \nainai\system\help();
          $helpList=$helpModel->getHelplist();
          $this->getView()->assign('helpList2',$helpList);
          //获得服务列表
          $fuwuList=\nainai\SiteHelp::getFuwuList();
          $this->getView()->assign('fuwuList',$fuwuList);
          //获取友情链接
          $frdLinkModel= new \nainai\system\friendlyLink();
          $frdLinkList=$frdLinkModel->getFrdLink(20);
          $this->getView()->assign('frdLinkList',$frdLinkList);
          if($isLogin){
               $this->login = \Library\session::get('login');
               //获取未读消息
               $messObj=new \nainai\message($this->login['user_id']);
               $mess=$messObj->getCountMessage();
               $this->getView()->assign('mess',$mess);
               $this->getView()->assign('login',1);
               $this->getView()->assign('username',$this->login['username']);
          }
          else
               $this->getView()->assign('login',0);
          
          $model = new \nainai\system\DealSetting();
          $deal = $model->getsetting();
          $this->getView()->assign('deal', $deal);

     }


     protected function success($info = '操作成功！',$redirect = ''){
          if(isset($redirect)){
               $redirect = str_replace('%','||',urlencode($redirect));
          }
          
          $this->redirect(url::createUrl("/Oper/success?info={$info}&redirect={$redirect}"));
     }

     protected function error($info = '操作失败！',$redirect = ''){

          if(isset($redirect)){
               $redirect = str_replace('%','||',urlencode($redirect));
          }
          $this->redirect(url::createUrl("/Oper/error?info={$info}&redirect={$redirect}"));
     }

     protected function confirm($info = '确认此项操作？',$redirect = ''){

          if(isset($redirect)){
               $redirect = str_replace('%','||',urlencode($redirect));
          }
          $this->redirect(url::createUrl("/Oper/confirm?info={$info}&redirect={$redirect}"));
     }

}