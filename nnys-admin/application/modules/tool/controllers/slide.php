<?php
/**
 * 幻灯片管理
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/6/16
 * Time: 10:24
 */
use nainai\system\slide;
use Library\safe;
use Library\json;
class slideController extends Yaf\Controller_Abstract{
    private $slideModel='';
    public function init(){
        $this->slideModel=new slide();
        $this->getView()->setLayOut('admin');
    }

    /**
     *添加幻灯片
     */
    public function addSlideAction(){
        if(IS_AJAX &&IS_POST){
            $data['name']=safe::filterPost('name');
            $img=safe::filterPost('imgfile2');
            $data['img']=\Library\tool::setImgApp($img);
            $data['status']=safe::filterPost('status','int');
            $data['order']=safe::filterPost('order','int');
            $data['bgcolor']=safe::filterPost('bgcolor');
            $slideModel=$this->slideModel;
            $res=$slideModel->addSlide($data);
            die(json::encode($res));
        }

    }

    /**
     *幻灯片列表
     */
    public function slideListAction(){
        $page=safe::filterGet('page','int');
        $res=$this->slideModel->getSlideList($page);
        $this->getView()->assign('slideList',$res[0]);
        $this->getView()->assign('pageBar',$res[1]);
    }

    /**
     * 删除幻灯片
     * @return bool
     */
    public function delAction(){
        if(IS_AJAX){

            $id=intval($this->_request->getParam('name'));
            $res=$this->slideModel->delSlide($id);
            die(json::encode($res));
        }
        return false;
    }

    /**
     * 编辑幻灯片
     * @return bool
     */
    public function editSlideAction(){
        if(IS_AJAX&&IS_POST){
            $date['id']=safe::filterPost('id','int');
            $date['name']=safe::filterPost('name');
            $date['order']=safe::filterPost('order','int');
            $img=safe::filterPost('imgfile2');
            $date['img']=\Library\tool::setImgApp($img);
            $date['status']=safe::filterPost('status','int');
            $date['bgcolor']=safe::filterPost('bgcolor');
            $res=$this->slideModel->editSlide($date);
            die(json::encode($res));
        }
        $id=safe::filterGet('id');
        $slideInfo=$this->slideModel->getSlideInfo($id);
        if($slideInfo){
            $this->getView()->assign('slideInfo',$slideInfo);
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
            $res = $this->slideModel->setSlideStatus($data);
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