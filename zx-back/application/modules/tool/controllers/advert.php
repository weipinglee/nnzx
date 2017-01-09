<?php

/**
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/5/24
 * 广告管理类
 * Time: 10:14
 */
use Library\ad;
use Library\M;
use Library\Query;
use Library\safe;
use Library\url;
use Library\JSON;
use Library\tool;
class advertController extends Yaf\Controller_Abstract{
    /**
     *
     */
    public function init(){

        $this->getView()->setLayOut('admin');
    }
    /**
     * 广告列表
     */
    public function adManageListAction(){

        $page=safe::filterPost('page','int');
        $adObj=new advertModel();
        $data=$adObj->getAdManageList($page);
        $this->getView()->assign('adManageList',$data[0]);
        $this->getView()->assign('resBar',$data[1]);
    }
    /**
     *广告添加
     */
    public function adManageAddAction(){
        $adObj=new advertModel();
        if(IS_AJAX||IS_POST) {
           $content=safe::filterPost('imgfile2');
           if($content==""){
               die(JSON::encode(array('success'=>0,'info'=>'请上传图片')));
           }
            $content = tool::setImgApp($content);
           $date=array(
               'name'=>safe::filterPost('name'),
               'position_id'=>safe::filterPost('position_id','int'),
               'link'=>safe::filterPost('link'),
               'order'=>safe::filterPost('order','int'),
               'start_time'=>safe::filterPost('start_time'),
               'end_time'=>safe::filterPost('end_time'),
               'content'=>tool::setImgApp($content),
               'description'=>safe::filterPost('description')
           );
           $res=$adObj->adManageAdd($date);
           die(JSON::encode($res));
        }

        $adPoDate=$adObj->getAdPositionList();
        $this->getView()->assign('adPoDate',$adPoDate[0]);


    }

    /**
     *广告修改
     */
    public function adManageEditAction(){
        $adModel=new advertModel();
        if(IS_POST||IS_AJAX){
            $content=safe::filterPost('imgfile2');

            $data=array(
                'id'=>safe::filterPost('id','int'),
                'name'=>safe::filterPost('name'),
                'position_id'=>safe::filterPost('position_id','int'),
                'link'=>safe::filterPost('link'),
                'order'=>safe::filterPost('order'),
                'start_time'=>safe::filterPost('start_time'),
                'end_time'=>safe::filterPost('end_time'),
                'description'=>safe::filterPost('description')
            );
            if($content!=""){
                $data['content']=tool::setImgApp($content);
            }
            $res=$adModel->adManageEdit($data);
            die(JSON::encode($res));
        }

        $id=safe::filterGet('id');
        $info=$adModel->getAdManageInfo($id);
        $adPoDate=$adModel->getAdPositionList();
        $info['content']=\Library\Thumb::get($info['content'],180,180);
       // var_dump($info);
        $this->getView()->assign('info',$info);
        $this->getView()->assign('adPoDate',$adPoDate[0]);

    }
    /**
     *广告位添加
     */
    public function adPositionAddAction(){

        if(IS_POST||IS_AJAX){
            $data=array(
                'name'=>safe::filterPost('name'),
                'width'=>safe::filterPost('width','int'),
                'height'=>safe::filterPost('height','int'),
                'status'=>safe::filterPost('status','int')
                );
            $adPoModel=new advertModel();
            $res=$adPoModel->adPositionAdd($data);
            die(JSON::encode($res));
        }
    }

    /**
     *广告位修改
     */
    public function adPositionEditAction(){
        $adPoModel=new advertModel();
        if(IS_POST||IS_AJAX){
            $data=array(
                'id'=>safe::filterPost('id','int'),
                'name'=>safe::filterPost('name'),
                'width'=>safe::filterPost('width','int'),
                'height'=>safe::filterPost('height','int'),
                'status'=>safe::filterPost('status','int')
            );
            $res=$adPoModel->adPositionEdit($data);
            die(JSON::encode($res));

        }
        $id=safe::filterGet('id','int');
       
        $info=$adPoModel->getAdPositionInfo($id);
        $this->getView()->assign('info',$info);

    }
    /**
     *广告位列表
     */
    public function adPositionListAction(){
        $page=safe::filterPost('page','int');
        $adObj=new advertModel();
        $data=$adObj->getAdPositionList($page);;
        $this->getView()->assign('adPositionList',$data[0]);
        $this->getView()->assign('resBar',$data[1]);
    }

    public function testAction(){

    }

    /**
     * 逻辑删除广告
     * @return bool
     */
    public function delManageAction(){
        if(IS_AJAX&&IS_POST){
            $id = $this->getRequest()->getParam('id','int');
            $id=safe::filter($id,'int');
            $adModel=new advertModel();
            $res=$adModel->delAdManage($id);
            die(JSON::encode($res));
        }
        return false;
    }

    /**
     * 逻辑删除广告位
     * @return bool
     */
    public function delPositionAction(){
        if(IS_AJAX&&IS_POST){
            $id = $this->getRequest()->getParam('id','int');
            $id=safe::filter($id,'int');
            $adModel=new advertModel();
            $res=$adModel->delAdPosition($id);
            die(JSON::encode($res));
        }
        return false;
    }

}