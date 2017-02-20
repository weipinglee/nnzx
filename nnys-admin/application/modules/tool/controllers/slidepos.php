<?php
/**
 * 幻灯片管理
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/6/16
 * Time: 10:24
 */
use nainai\system\slidepos;
use Library\safe;
use Library\json;
class slideposController extends Yaf\Controller_Abstract{
    private $slideposModel='';
    public function init(){
        $this->slideposModel=new slidepos();
        $this->getView()->setLayOut('admin');
    }

    /**
     *添加幻灯片
     */
    public function addslideposAction(){
        if(IS_AJAX &&IS_POST){
            $data['name']=safe::filterPost('name');
            
            $data['status']=safe::filterPost('status','int');
            $data['intro']=safe::filterPost('intro');
            $slideposModel=$this->slideposModel;
            $res=$slideposModel->addslidepos($data);
            die(json::encode($res));
        }

    }

    /**
     *幻灯片列表
     */
    public function slideposListAction(){
        $page=safe::filterGet('page','int');
        $res=$this->slideposModel->getslideposList($page);
        $this->getView()->assign('slideposList',$res[0]);
        $this->getView()->assign('pageBar',$res[1]);
    }

    /**
     * 删除幻灯片
     * @return bool
     */
    public function delAction(){
        if(IS_AJAX){
            
            $id=intval($this->_request->getParam('name'));
            $res=$this->slideposModel->delslidepos($id);
            die(json::encode($res));
        }
        return false;
    }

    /**
     * 编辑幻灯片
     * @return bool
     */
    public function editslideposAction(){
        if(IS_AJAX&&IS_POST){
            $date['id']=safe::filterPost('id','int');
            $date['name']=safe::filterPost('name');
            $date['intro']=safe::filterPost('intro');
            $date['status']=safe::filterPost('status','int');
            $res=$this->slideposModel->editslidepos($date);
            die(json::encode($res));
        }
        $id=safe::filterGet('id');
        $slideposInfo=$this->slideposModel->getslideposInfo($id);
        if($slideposInfo){
            $this->getView()->assign('slideposInfo',$slideposInfo);
        }else{
            return false;
        }

    }

    /**
     *更改幻灯片状态
     */
    public function setStatusAction()
    {
        if (IS_AJAX) {
            $id=intval($this->_request->getParam('id'));
            $status = safe::filterPost('status', 'int');
            $data = [
                'id' => $id,
                'status' => $status
            ];
            $res = $this->slideposModel->setslideposStatus($data);
            die(json::encode($res));

        }
    }
    public function uploadAction(){

            //调用文件上传类
            $uoload=new \Library\photoupload();
            $uoload->setThumbParams(array(180,180));
            $photo=current($uoload->uploadPhoto());
            if($photo['flag']==1){
                $result=[
                    'flag'=>$photo['flag'],
                    'img'=>$photo['img'],
                    'thumb'=>$photo['thumb'][1]
                ];
            }else{
                $result=[
                    'flag'=>$photo['flag'],
                    'error'=>$photo['errInfo']
                ];
            }
        die(json::encode($result));

    }

}