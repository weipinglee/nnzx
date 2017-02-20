<?php

/**
 * 分类管理
 */
use Library\Query;
use Library\M;
use Library\tool;
class CategoryModel
{   

    public function __construct()
    {   
        $this->cate = new \nainai\category\ArcCate();
        $this->cateModel = new M('article_category');
    }

    protected $rules = array(
        array('name','require','名称不能为空',2,),
    );

    /**
     * 获取列表
     * @param int $page
     * @return array
     */
    public function cateList($page=1){
        $cateTree = $this->cate->cateFlow($this->cate->cateList());
        //var_dump($cateTree);
        return array($cateTree);
        // return $this->cate->cateList($page);
    }

    public function cateFlowHtml($id=0){
        return $this->cate->cateFlowHtml($id);
    }
    
    public function cateTree(){
        $cateTree = $this->cate->cateTree($this->cateList());
    }

    /**
     * 判断分类名称是否存在
     * @param $where
     * @return bool
     */
    public function checkcateName($where){
        $data=$this->cateModel->fields('id')->where($where)->getObj();
        if(!empty($data)){
            return true;
        }else{
            return false;
        }

    }
    
    /**
     * 分类添加
     * @param $data
     * @return array
     */
    public function cateAdd($data){
        $cateModel=$this->cateModel;
        $res='';
        if($cateModel->data($data)->validate($this->rules)){
            if(!$this->checkcateName(array('name'=>$data['name']))){
                $res=$cateModel->data($data)->add();

                return $res ? tool::getSuccInfo(1, '添加成功') : tool::getSuccInfo(0, '添加失败');
            }else{
                return tool::getSuccInfo(0,'名称存在');
            }
            
        }else{
            $res=$cateModel->getError();
            return tool::getSuccInfo(0,$res);
        }


    }

    /**
     * 分类修改
     * @param $data
     * @return array
     */
    public function cateEdit($data){
        $cateModel=$this->cateModel;
        $res="";
        if($cateModel->data($data)->validate($this->rules)){
            
            if(isset($data['name'])&&$this->checkcateName(array('name'=>$data['name'],'id'=>array('neq',$data['id'])))){
                return tool::getSuccInfo(0,'名称不能重复');
            }    
            $res = $cateModel->where(array('id'=>$data['id']))->data($data)->update();
            return $res ? tool::getSuccInfo(1, '修改成功') : tool::getSuccInfo(0, '修改失败');
            
        }else{
            $res=$cateModel->getError();
            return tool::getSuccInfo(0,$res);
        }
        
    }

    public function setStatus($data){
        return $this->cateEdit($data);
    }

    /**
     * 获取分类详细信息
     * @param $id
     * @return array|bool
     */
    public function getcateInfo($id){
        $cateModel=$this->cateModel;
        $data=array(
            'id'=>$id
        );
        $info=$cateModel->where($data)->getObj();
        return $info ? $info : false;
    }

    public function delcate($id){
        $cateModel=$this->cateModel;
        $where=array('id'=>$id);
        if($cateModel->data(array('is_del'=>1))->where($where)->update()){
            return tool::getSuccInfo(1,'删除成功');
        }else{
            return tool::getSuccInfo(0,'删除失败');
        }

    }
}