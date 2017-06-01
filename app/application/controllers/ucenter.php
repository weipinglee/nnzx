<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/27 0027
 * Time: 上午 9:07
 */
use \Library\checkRight;
use \Library\safe;
use \Library\json;
use \Library\tool;
class UcenterController extends AppBaseController{

    public function init(){
		$db = tool::getGlobalConfig(array('db','trade'));
        $right = new checkRight($db);
        $right->checkLogin($this);//未登录自动跳到登录页
    }
    //文章加入收藏
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
        die(json::encode(tool::getSuccInfo(0,'操作错误')));

    }

    //文章取消收藏
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

    //文章收藏列表
    public function favoriteListAction(){
        if(IS_POST){
            $page = safe::filterGet('page','int',1);
            $user_id = $this->user_id;
            $obj = new \zixun\articleFavorite();
            die(json::encode($obj->getList($user_id,$page)));
        }

    }

    //发布评论
    public function addCommentAction(){
        if(IS_POST){
            $data = array(
                'article_id'=>safe::filterPost('article_id','int'),
                'text'      => safe::filterPost('text')
            );
            $commentObj = new \zixun\articleComment();
            $res = $commentObj->addComment($data['article_id'],$data['text'],$this->user_id);
           die(json::encode($res));

        }
        die(json::encode(tool::getSuccInfo(0,'失败')));
    }

    //回复评论,针对评论的评论
    public function reCommentAction(){
        if(IS_POST){
            $data = array(
                'comment_id'=>safe::filterPost('comment_id','int'),
                'text'      => safe::filterPost('text')
            );
            $commentObj = new \zixun\articleComment();
            $res = $commentObj->replyComment($data['comment_id'],$data['text'],$this->user_id);
            die(json::encode($res));
        }
        die(json::encode(tool::getSuccInfo(0,'失败')));
    }

    /**
     * 获取主评论列表
     */
    public function commentListAction(){
        $article_id = safe::filterGet('article_id','int',0);
        $page = safe::filterGet('page','int',1);
        $commentObj = new \zixun\articleComment();
        $res = $commentObj->commentList($article_id,$page);
        $this->getView()->assign('list',$res);

    }

    /**
     * 回复评论列表
     */
    public function replyCommentListAction(){
        $comment_id = safe::filterGet('comment_id','int');
        $page = safe::filterGet('page','int',1);
        $commentObj = new \zixun\articleComment();
        $mainComment = $commentObj->getComment($comment_id);
        $res = $commentObj->replyCommentList($comment_id,$page);
        $this->getView()->assign('mainComment',$mainComment);
        $this->getView()->assign('replyList',$res);
    }

    //针对评论点赞
    public function dianzanAction(){
        if(IS_POST){
            $comment_id = safe::filterPost('comment_id','int');
            $commentObj = new \zixun\articleComment();
            $res = $commentObj->addFavorite($comment_id,$this->user_id);
            die(json::encode($res));
        }
        die(json::encode(tool::getSuccInfo(0,'非法操作')));
    }





}