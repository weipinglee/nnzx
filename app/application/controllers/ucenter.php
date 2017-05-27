<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/27 0027
 * Time: ���� 9:07
 */
use \Library\checkRight;
use \Library\safe;
use \Library\json;
use \Library\tool;
class Ucenter extends \Yaf\Controller_Abstract{

    public function init(){
        $right = new checkRight();
        $right->checkLogin($this);//δ��¼�Զ�������¼ҳ
    }
    //���¼����ղ�
    public function addFavoriteAction(){
        if(IS_POST){
            $data = array(
                'user_id'=>$this->user_id,
                'article_id' => safe::filterPost('article_id','int'),
                'time'   => \Library\time::getDateTime()
            );
            $obj = new \zixun\articleFavorite();
            die(json::encode($obj->add($data))) ;
        }
        die(json::encode(tool::getSuccInfo(0,'��������')));

    }

    //����ȡ���ղ�
    public function cancleFavoriteAction(){
        if(IS_POST){
            $data = array(
                'user_id'=>$this->user_id,
                'article_id' => safe::filterPost('article_id','int'),
            );
            $obj = new \zixun\articleFavorite();
            die(json::encode($obj->cancle($data))) ;
        }
    }

    //�����ղ��б�
    public function favoriteListAction(){
        if(IS_POST){
            $page = safe::filterGet('page','int',1);
            $user_id = $this->user_id;
            $obj = new \zixun\articleFavorite();
            die(json::encode($obj->getList($user_id,$page)));
        }

    }

    //��������
    public function addCommentAction(){
        if(IS_POST){
            $data = array(
                'article_id'=>safe::filterPost('article_id','int'),
                'text'      => safe::filterPost('text')
            );
            if($data['article_id'] && $data['text']){
                die(json::encode(tool::getSuccInfo()));
            }
            else{
                die(json::encode(tool::getSuccInfo(0,'ʧ��')));
            }

        }
        die(json::encode(tool::getSuccInfo(0,'ʧ��')));
    }

    //�ظ�����,������۵�����
    public function reCommentAction(){
        if(IS_POST){
            $data = array(
                'comment_id'=>safe::filterPost('comment_id','int'),
                'text'      => safe::filterPost('text')
            );
            if($data['comment_id'] && $data['text']){
                die(json::encode(tool::getSuccInfo()));
            }
        }
        die(json::encode(tool::getSuccInfo(0,'ʧ��')));
    }




}