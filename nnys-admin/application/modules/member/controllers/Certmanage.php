<?php

/**
 * @name MemberController
 * @author weipinglee
 * @desc 角色认证管理控制器
 * date:2016-5-3
 */
use \Library\safe;
use \nainai\cert\certDealer;
use \nainai\cert\certStore;
use \Library\Thumb;
use \Library\url;
use \Library\JSON;
class certManageController extends InitController {


     public function init(){
          $this->getView()->setLayout('admin');
          //echo $this->getViewPath();
     }
     /** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/yar-demo/index/index/index/name/root 的时候, 你就会发现不同
     */
     public function indexAction() {


     }



     /**
      *交易商认证列表页
     */
     public function dealerCertAction(){
          $m = new certDealer();

          $page = safe::filterGet('page','int',1);
          $pageData = $m->certList($page);

          $this->getView()->assign('data',$pageData);

     }

     /**
      *交易商认证列表页
      */
     public function dealerCertedAction(){
          $m = new certDealer();
          $condition = array('name' => '交易商认证列表', 'type' =>'dealer');
          $pageData = $m->certedList($condition);

          $this->getView()->assign('data',$pageData);

     }



     /**
      * 交易商申请认证详情页
      */
     public function dealercertDetailAction(){
          $id = $this->getRequest()->getParam('uid',0);
          $id = safe::filter($id,'int',0);

          if($id){
               $certObj = new certDealer();

               $certData = $certObj->getDetail($id);

               if(empty($certData))
                    $this->redirect(url::createUrl('member/certManage/dealerCert'));

               $this->getView()->assign('cert',$certData);
          }
          else{
               return false;
          }



     }

     /**
      * 交易商认证角色处理
      */
     public function doDealerCertAction(){
          if(IS_POST){
               $user_id = safe::filterPost('user_id','int',0);
               $status  = safe::filterPost('status','int',0);
               $info    = safe::filterPost('message');
               $status  = $status==1 ? 1 : ($status==2?2:0);
               $m = new certDealer();
               $res = $m->verify($user_id,$status,$info);

               echo JSON::encode($res);

          }
          return false;

     }

     /**
      *仓库管理员认证列表页
      */
     public function storeCertAction(){
          $m = new certStore();

          $page = safe::filterGet('page','int',1);
          $pageData = $m->certList($page);

          $this->getView()->assign('data',$pageData);
          

     }

     /**
      *仓库管理员认证列表页
      */
     public function storeCertedAction(){
          $m = new certStore();

          $condition = array('name' => '仓库管理员认证列表', 'type' =>'store_manager');
          $pageData = $m->certedList($condition);
          $this->getView()->assign('data',$pageData);

     }

     /**
      * 仓库管理员认证详情
      */
     public function storecertDetailAction(){
          $id = $this->getRequest()->getParam('uid',0);
          $id = safe::filter($id,'int',0);
          if($id){
               $certObj = new certStore();

               $data = $certObj->getDetail($id);

               // if(empty($data))
               //      $this->redirect(url::createUrl('member/member/storeCert'));

               $this->getView()->assign('cert',$data[0]);
               $this->getView()->assign('store',$data[1]);

          }
          else{
               $this->redirect(url::createUrl('member/member/storeCert'));
          }
     }

     /**
      * 仓库认证角色处理
      */
     public function doStoreCertAction(){
          if(IS_POST){
               $user_id = safe::filterPost('user_id','int',0);
               $status  = safe::filterPost('status','int',0);
               $info    = safe::filterPost('message');
               $status  = $status==1 ? 1 : 0;
               $m = new certStore();
               $res = $m->verify($user_id,$status,$info);

               echo JSON::encode($res);

          }
          return false;

     }








}