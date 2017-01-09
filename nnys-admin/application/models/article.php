<?php

/**
 * 分类管理
 */
use Library\Query;
use Library\M;
use Library\tool;
class ArticleModel
{   

    public function __construct()
    {   
        $this->article = new \nainai\Article();
        $this->articleModel = new M('article');
        $this->articleConModel = new M('article_content');
        $this->articleCovModel = new M('article_cover');

    }

    protected $rules = array(
        array('name','require','名称不能为空',2,),
    );  

    /**
     * 获取列表
     * @param int $page
     * @return array
     */
    public function arcList($page=1){
        return $this->article->arcList();
        //var_dump($cateTree);
        // return $this->cate->cateList($page);
    }


    /**
     * 判断文章名称是否存在
     * @param $where
     * @return bool
     */
    public function checkarcName($where){
        $data=$this->articleModel->fields('id')->where($where)->getObj();
        if(!empty($data)){
            return true;
        }else{
            return false;
        }

    }
    
    /**
     * 文章发布
     * @param $data
     * @return array
     */
    public function arcAdd($data){
        $model=$this->articleModel;
        $res='';
        if($model->data($data)->validate($this->rules)){
            if(!$this->checkarcName(array('name'=>$data['name']))){
                try {
                    $model->beginTrans();
                    $content = $data['content'];unset($data['content']);
                    $cover = $data['cover'];unset($data['cover']);
                    $id = $model->data($data)->add();
                    if($id>0){
                        $this->articleConModel->data(array('article_id'=>$id,'content'=>$content))->add();

                        $this->articleCovModel->data(array('article_id'=>$id,'url'=>$cover))->add();
                    }
                    $res = $model->commit();
                } catch (PDOException $e) {
                    $model->rollBack();
                    $res = $e->getError();
                }

                return $res === true ? tool::getSuccInfo(1, '添加成功') : tool::getSuccInfo(0, $res);
            }else{
                return tool::getSuccInfo(0,'名称存在');
            }
            
        }else{
            $res=$model->getError();
            return tool::getSuccInfo(0,$res);
        }


    }

    /**
     * 文章修改
     * @param $data
     * @return array
     */
    public function arcEdit($data){
        $model=$this->articleModel;
        $res="";
        if($model->data($data)->validate($this->rules)){
            
            if(isset($data['name'])&&$this->checkarcName(array('name'=>$data['name'],'id'=>array('neq',$data['id'])))){
                return tool::getSuccInfo(0,'名称不能重复');
            }    
            try {
                $article_id = $data['id'];
                $model->beginTrans();
                $covers = array();
                if(is_array($data['cover'])){
                    foreach ($data['cover'] as $key => $value) {
                        $covers []= array('article_id'=>$article_id,'url'=>tool::setImgApp($value));
                    }
                }else{
                    $covers = array('article_id'=>$article_id,'url'=>tool::setImgApp($data['cover']));
                }
                $content = $data['content'];
                unset($data['cover']);
                unset($data['content']);
                $this->articleCovModel->where(array('article_id'=>$article_id))->delete();
                $this->articleCovModel->data($covers)->add();
                $model->where(array('id'=>$article_id))->data($data)->update();
                $this->articleConModel->where(array('article_id'=>$article_id))->data(array('content'=>$content))->update();
                $res = $model->commit();
            } catch (PDOException $e) {
                $model->rollBack();
                $res = $e->getError();
            }
            
            return $res === true ? tool::getSuccInfo(1, '修改成功') : tool::getSuccInfo(0, $res);
            
        }else{
            $res=$model->getError();
            return tool::getSuccInfo(0,$res);
        }
        
    }

    public function setStatus($data){
        return $this->cateEdit($data);
    }

    /**
     * 获取文章详细信息
     * @param $id
     * @return array|bool
     */
    public function getarcInfo($id){
        return $this->article->arcInfo($id);
    }

    public function delarc($id){
        $articleModel=$this->articleModel;
        $where=array('id'=>$id);
        if($articleModel->data(array('is_del'=>1))->where($where)->update()){
            return tool::getSuccInfo(1,'删除成功');
        }else{
            return tool::getSuccInfo(0,'删除失败');
        }

    }
}