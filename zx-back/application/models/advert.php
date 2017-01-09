<?php

/**
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/5/24
 * Time: 10:41
 * 广告管理
 */
use Library\Query;
use Library\M;
use Library\tool;
class advertModel
{   private $adPoModel;
    private $adMaModel;

    /**
     * advertModel constructor.
     */
    public function __construct()
    {   $this->adMaModel=new M('ad_manage');
        $this->adPoModel=new M('ad_position');
    }

    protected $adPositionRules = array(
        array('name','require','名称不能为空',1,),
        array('height','number','高度必须设置',1),
        array('width','number','宽度必须设置',1),
    );
    protected $adManageRules=array(
        array('name','require','名称不能为空',1),
        array('position_id','number','广告位不能为空',1),
        array('start_time','datetime','开始时间不能为空'),
        array('end_time','datetime','结束时间不能为空'),
        array('content','require','图片不能为空')

    );
    /**
     * 获取广告列表
     * @param int $page
     * @return array
     */
    public function getAdManageList($page=1){
        $reModel = new Query('ad_manage as m');
        $reModel->join=' left join ad_position as p on m.position_id=p.id';
        $reModel->fields='m.name,p.name as pname,m.order,m.start_time,m.end_time,m.id';
        $reModel->where = 'm.is_del = 0';
        $reModel->page = $page;
        $adManageInfo = $reModel->find();
        $reBar = $reModel->getPageBar();
        return array($adManageInfo,$reBar);

    }

    /**
     * 判断广告位名称是否存在
     * @param $where
     * @return bool
     */
    public function checkAdPositionName($where){
        $data=$this->adPoModel->fields('id')->where($where)->getObj();
        if(!empty($data)){
            return true;
        }else{
            return false;
        }

    }
    /**
     * 获取广告位列表
     * @param int $page
     * @return array
     */
    public function getAdPositionList($page=1){
        $reModel=new Query('ad_position as p');
        $reModel->where='is_del=0';
        $reModel->page=$page;
        $adPositionList=$reModel->find();
        $reBar=$reModel->getPageBar();
        return array($adPositionList,$reBar);

    }

    /**
     * 广告位添加
     * @param $data
     * @return array
     */
    public function adPositionAdd($data){
        $adPoModel=$this->adPoModel;
        $res='';
        if($adPoModel->data($data)->validate($this->adPositionRules)){
            if(!$this->checkAdPositionName(array('name'=>$data['name']))){
                $res=$adPoModel->data($data)->add();

                return $res ? tool::getSuccInfo(1, '添加成功') : tool::getSuccInfo(0, '添加失败');
            }else{
                return tool::getSuccInfo(0,'名称存在');
            }

        }else{
            $res=$adPoModel->getError();
            return tool::getSuccInfo(0,$res);
        }


    }

    /**
     * 广告添加
     * @param $date
     * @return array
     */
    public function adManageAdd($data){
        $adMaModel=$this->adMaModel;
        $res="";
        if($adMaModel->data($data)->validate($this->adManageRules)){
            $res=$adMaModel->data($data)->add();
            return $res ? tool::getSuccInfo(1, '添加成功') : tool::getSuccInfo(0, '添加失败');
        }else{
            $res=$adMaModel->getError();
            return tool::getSuccInfo(0,$res);
        }


    }

    /**
     * 广告修改
     * @param $data
     * @return array
     */
    public function adManageEdit($data){
        $adMaModel=$this->adMaModel;
        $res='';
        if($adMaModel->data($data)->validate($this->adManageRules)){
            $res=$adMaModel->where(array('id'=>$data['id']))->data($data)->update();
            return $res ? tool::getSuccInfo(1, '修改成功') : tool::getSuccInfo(0, '修改失败');

        }else{
            $res=$adMaModel->getError();
            return tool::getSuccInfo(0,$res);
        }

    }

    /**
     * 广告位修改
     * @param $data
     * @return array
     */
    public function adPositionEdit($data){
        $adPoModel=$this->adPoModel;
        $res="";
        if($adPoModel->data($data)->validate($this->adPositionRules)){
            if(isset($data['name'])&&!$this->checkAdPositionName(array('name'=>$data['name'],'id'=>array('neq',$data['id'])))) {
                $res = $adPoModel->where(array('id'=>$data['id']))->data($data)->update();
                return $res ? tool::getSuccInfo(1, '修改成功') : tool::getSuccInfo(0, '修改失败');
            }else{
                return tool::getSuccInfo(0,'名称不能重复');
            }
        }else{
            $res=$adPoModel->getError();
            return tool::getSuccInfo(0,$res);
        }

    }

    /**
     * 获取广告位详细信息
     * @param $id
     * @return array|bool
     */
    public function getAdPositionInfo($id){
        $adPoModel=$this->adPoModel;
        $data=array(
            'id'=>$id
        );
        $info=$adPoModel->where($data)->getObj();
        return $info ? $info : false;
    }

    /**
     * 获取广告的详细信息
     * @param $id
     * @return array|bool
     */
    public function getAdManageInfo($id){
        $adMaModel=new Query('ad_manage as m');
        $adMaModel->join='left join ad_position as p on m.position_id=p.id';
        $adMaModel->where='m.id= :id';
        $adMaModel->bind=array('id'=>$id);
        $adMaModel->fields='m.*';
        $info=$adMaModel->getObj();
        return $info ? $info : false;

    }
    public function delAdManage($id){
        $adMaModel=$this->adMaModel;
        $where=array('id'=>$id);
        if($adMaModel->where($where)->delete()){
            return tool::getSuccInfo(1,'删除成功');
        }else{
            return tool::getSuccInfo(0,'删除失败');
        }

    }
    public function delAdPosition($id){
        $adPoModel=$this->adPoModel;
        $where=array('id'=>$id);
        if($adPoModel->data(array('is_del'=>1))->where($where)->update()){
            return tool::getSuccInfo(1,'删除成功');
        }else{
            return tool::getSuccInfo(0,'删除失败');
        }

    }
}