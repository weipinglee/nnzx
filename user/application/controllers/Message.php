<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/27
 * Time: 11:15
 */
use Library\safe;
use Library\JSON;
class MessageController extends UcenterBaseController{


    /**
     *消息管理
     */
    public function userMailAction(){
        $page=safe::filterGet('page','int');
        $this->getView()->assign('userId',$this->user_id);
        $mess=new \nainai\message($this->user_id);
        $messInfo=$mess->getAllMessage($page);
        $this->getView()->assign('messList',$messInfo[0]);
        $this->getView()->assign('pageBar',$messInfo[1]);
        //未读消息;
        $countNeedMess=$mess->getCountMessage();
        //var_dump($countNeedMess);
        $this->getView()->assign('countNeedMessage',$countNeedMess);
    }

    /**
     * 获取未读消息的总数
     * @return bool
     */
    public function needCountMessageAction(){
        if(IS_POST&&IS_AJAX){
            $messModel=new \nainai\message($this->user_id);
            echo $messModel->getCountMessage();
            return false;
        }
        return false;
    }
    /**
     * 记录消息阅读时间
     * @return bool
     */
    public function readMessAction(){
        if(IS_POST&&IS_AJAX){
            $messId=safe::filterPost('id','int');
            $messModel=new \nainai\message($this->user_id);
            $res=$messModel->writeMess($messId);
            if($res){
                die(JSON::encode(array('success'=>1)));
            }else{
                die(JSON::encode(array('success'=>0)));
            }
        }
    }

    /**
     * 批量阅读
     * @return bool
     */
    public function allReadAction(){
        if(IS_POST&&IS_AJAX){
            $messModel=new \nainai\message($this->user_id);
            $messIds=safe::filterPost('ids');
            $messIds=explode(',',$messIds);
            foreach($messIds as $v){
                if(is_numeric($v)){
                    $messModel->writeMess($v);
                }

            }
            die(JSON::encode(array('success'=>1)));
        }
        return false;

    }

    /**
     * 删除消息
     * @return bool
     */
    public function delMessageAction(){
        if(IS_POST&&IS_AJAX){
            $id=safe::filterPost('id','int');
            $messModel=new \nainai\message($this->user_id);
            $res=$messModel->delMessage($id);
            if($res){
                die(JSON::encode(array('success'=>1)));
            }else{
                die(JSON::encode(array('success'=>0)));
            }


        }
        return false;

    }

    /**
     *批量删除
     */
    public function batchDelAction(){
        if(IS_POST&&IS_AJAX){
            $messModel=new \nainai\message($this->user_id);
            $messIds=safe::filterPost('ids');
            $messIds=explode(',',$messIds);
            $messIds=array_filter($messIds,function($var){
                return is_numeric($var);
            });
            $messIds=implode(',',$messIds);
            $res=$messModel->batchDel($messIds);
            $res?die(JSON::encode(array('succv ess'=>1))):die(JSON::encode(array('success'=>1)));
        }
        return false;
    }

}