<?php
/**
 * 友情链接
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/6/15
 * Time: 15:22
 */
use Library\safe;
use nainai\system\friendlyLink;
use Library\json;
class friendlyLinkController extends Yaf\Controller_Abstract{
    private $frdLinkModel;
    public function init(){
        $this->frdLinkModel=new friendlyLink();
        $this->getView()->setLayOut('admin');
    }
    public function addFrdLinkAction(){
        if(IS_AJAX &&IS_POST){
            $data['name']=safe::filterPost('name');
            $data['link']=safe::filterPost('link');
            $data['status']=safe::filterPost('status','int');
            $data['order']=safe::filterPost('order','int');
            $frdLinkModel=$this->frdLinkModel;
            $res=$frdLinkModel->addLink($data);
            die(json::encode($res));
        }

    }
    public function frdLinkListAction(){
        $page=safe::filterGet('page','int');
        $res=$this->frdLinkModel->getfrdLinkList($page);
        $this->getView()->assign('frdLinkList',$res[0]);
        $this->getView()->assign('pageBar',$res[1]);
    }
    public function delAction(){
        if(IS_AJAX&&IS_GET){
            $id=safe::filterGet('id','int');
            $res=$this->frdLinkModel->delLink($id);
            die(json::encode($res));
        }
        return false;
    }
    public function editLinkAction(){
        if(IS_AJAX&&IS_POST){
            $date['id']=safe::filterPost('id','int');
            $date['name']=safe::filterPost('name');
            $date['order']=safe::filterPost('order','int');
            $date['link']=safe::filterPost('link');
            $date['status']=safe::filterPost('status','int');
            $res=$this->frdLinkModel->editLink($date);
            die(json::encode($res));
        }
        $id=safe::filterGet('id','int');
        $linkInfo=$this->frdLinkModel->getLinkInfo($id);
        if($linkInfo){
            $this->getView()->assign('linkInfo',$linkInfo);
        }else{
            return false;
        }

    }
    public function setStatusAction()
    {
        if (IS_AJAX) {
            $id=intval($this->_request->getParam('id'));
            $status = safe::filterPost('status', 'int');
            $data = [
                'id' => $id,
                'status' => $status
            ];
            $res = $this->frdLinkModel->setLinkStatus($data);
            die(json::encode($res));

        }
    }
}