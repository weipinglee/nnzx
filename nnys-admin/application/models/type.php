<?php

/**
 * 分类管理
 */
use Library\M;
use Library\tool;
class TypeModel
{   

    public function __construct()
    {   
        $this->type = new \nainai\category\ArcType();
        $this->typeModel = new M('article_type');
    }

    protected $rules = array(
        array('name','require','名称不能为空',2,),
    );

    /**
     * 获取列表
     * @param int $page
     * @return array
     */
    public function typeList($page=1){
        $typeTree = $this->type->typeFlow($this->type->typeList());
        // var_dump($typeTree);
        return array($typeTree);
        // return $this->type->typeList($page);
    }

    public function typeFlowHtml($pid=0,$id=0,$top=1){
        return $this->type->typeFlowHtml($pid,$id,$top);
    }

    public function typeTree(){
        $typeTree = $this->type->typeTree($this->typeList());
    }

    /**
     * 判断分类名称是否存在
     * @param $where
     * @return bool
     */
    public function checktypeName($where){
        $data=$this->typeModel->fields('id')->where($where)->getObj();
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
    public function typeAdd($data){
        $typeModel=$this->typeModel;
        $res='';
        if($typeModel->data($data)->validate($this->rules)){
            if(!$this->checktypeName(array('name'=>$data['name']))){
                $res=$typeModel->data($data)->add();

                return $res ? tool::getSuccInfo(1, '添加成功') : tool::getSuccInfo(0, '添加失败');
            }else{
                return tool::getSuccInfo(0,'名称存在');
            }
            
        }else{
            $res=$typeModel->getError();
            return tool::getSuccInfo(0,$res);
        }


    }

    /**
     * 分类修改
     * @param $data
     * @return array
     */
    public function typeEdit($data){
        $typeModel=$this->typeModel;
        $res="";
        if($typeModel->data($data)->validate($this->rules)){
            
            if(isset($data['name'])&&$this->checktypeName(array('name'=>$data['name'],'id'=>array('neq',$data['id'])))){
                return tool::getSuccInfo(0,'名称不能重复');
            }    
            $res = $typeModel->where(array('id'=>$data['id']))->data($data)->update();
            return $res ? tool::getSuccInfo(1, '修改成功') : tool::getSuccInfo(0, '修改失败');
            
        }else{
            $res=$typeModel->getError();
            return tool::getSuccInfo(0,$res);
        }
        
    }

    public function setStatus($data){
        return $this->typeEdit($data);
    }

    /**
     * 获取分类详细信息
     * @param $id
     * @return array|bool
     */
    public function gettypeInfo($id){
        $typeModel=$this->typeModel;
        $data=array(
            'id'=>$id
        );
        $info=$typeModel->where($data)->getObj();
        return $info ? $info : false;
    }

    public function deltype($id){
        $typeModel=$this->typeModel;
        $where=array('id'=>$id);
        if($typeModel->data(array('is_del'=>1))->where($where)->update()){
            return tool::getSuccInfo(1,'删除成功');
        }else{
            return tool::getSuccInfo(0,'删除失败');
        }

    }
}