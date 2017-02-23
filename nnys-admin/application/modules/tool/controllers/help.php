<?php
/**
 * 帮助管理
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/6/16
 * Time: 14:18
 */
use nainai\siteHelp;
class helpController extends Yaf\Controller_Abstract{

    public function init(){
        $this->getView()->setLayOut('admin');
    }

    /**
     *帮助列表
     */
    public function helpListAction(){
        $helpModel=new siteHelp();
        $page=\Library\safe::filterGet('page','int');
        $res=$helpModel->getHelpList($page);
        $this->getView()->assign('helpList',$res[0]);
        $this->getView()->assign('pageBar',$res[1]);

    }

    /**
     *帮助分类列表
     */
    public function helpCatListAction(){
        $helpModel=new siteHelp();
        $page=\Library\safe::filterGet('page','int');
        $res=$helpModel->getHelpCatList($page);
        $this->getView()->assign('helpCatList',$res[0]);
        $this->getView()->assign('pageBar',$res[1]);
    }

    /**
     *添加帮助
     */
    public function helpAddAction(){
        $helpModel=new siteHelp();
        if(IS_AJAX&&IS_POST){
            $data['name']=\Library\safe::filterPost('name');
            $data['cat_id']=\Library\safe::filterPost('cat_id','int');
            if($data['cat_id']==0){
                die(\Library\json::encode(['success'=>0,'info'=>'请选择分类']));
            }
            ini_set('post_max_size','100M');
            ini_set('upload_max_filesize','100M');
            $data['time']=date('Y-m-d H:i:s',time());
            $data['sort']=\Library\safe::filterPost('sort','int');
            $data['link']=\Library\safe::filterPost('link');
            $data['content']=$_POST['introduce'];
            $img=\Library\safe::filterPost('imgfile2');
            $data['img']=\Library\tool::setImgApp($img);
            $id=\Library\safe::filterPost('id','int');
            if($id){
                $data['id']=$id;
                $res=$helpModel->helpEdit($data);
                die(\Library\json::encode($res));
            }else{
                $res=$helpModel->addhelp($data);
            }
            die(\Library\json::encode($res));
        }else{
            $id=\Library\safe::filterGet('id','int');
            if($id){
                $res=$helpModel->getHelpById($id);
                $this->getView()->assign('helpInfo',$res);
            }
            $catList=$helpModel->getAllCat();
            $this->getView()->assign('catList',$catList);

        }


    }

    /**
     *添加编辑帮助分类
     */
    public function helpCatAddAction(){
        $helpCatModel=new siteHelp();
        if(IS_POST){
            $data['name']=\Library\safe::filterPost('name');
            $data['sort']=\Library\safe::filterPost('sort','int');
            $data['status']=\Library\safe::filterPost('status','int');
            $id=\Library\safe::filterPost('id','int',0);
            if($id!=0){
                $data['id']=$id;
                $res=$helpCatModel->helpCatEdit($data);
            }else{
                $res=$helpCatModel->addhelpCat($data);
            }
            die(\Library\json::encode($res));
        }else{
            $id=\Library\safe::filterGet('id','int');
            if($id){
                $res=$helpCatModel->getHelpCatById($id);
                $this->getView()->assign('helpCatInfo',$res);
            }

        }

    }




    /**
     *编辑帮助
     */
    public function helpEditAction(){
        $id=\Library\safe::filterGet('id','int');
        $helpModel=new siteHelp();
        $res=$helpModel->getHelpById($id);
        $catList=$helpModel->getAllCat();
        $this->getView()->assign('catList',$catList);
        $this->getView()->assign('helpInfo',$res);
    }

    /**
     * 删除帮助
     * @return bool
     */
    public function delHelpAction(){
        if(IS_AJAX){
            $id=intval($this->_request->getParam('id'));
            $helpModel=new siteHelp();
            $res=$helpModel->helpDel($id);
            die(\Library\json::encode($res));
        }
        return false;
    }

    /**
     * 删除帮助分类
     * @return bool
     */
    public function delHelpCatAction(){
        if(IS_AJAX){
            $id=intval($this->_request->getParam('id'));

            $helpModel=new siteHelp();
            $res=$helpModel->helpCatDel($id);
            die(\Library\json::encode($res));
        }
        return false;
    }

    /**
     * 更改分类状态
     * @return bool
     */
    public function setCatStatusAction(){
        if(IS_AJAX){
            $id=intval($this->_request->getParam('id'));
            $status=\Library\safe::filterPost('status','int');
            $data=[
                'id'=>$id,
                'status'=>$status
            ];
            $helpModel=new siteHelp();
            $res=$helpModel->setCatStatus($data);
            die(\Library\json::encode($res));

        }
        return false;

    }
    public function test2Action(){
        $hsms=new Library\Hsms();
       $res= $hsms->send('18703210113','1111');
       var_dump($res);
        die;

    }
}