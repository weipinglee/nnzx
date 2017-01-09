<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/25
 * Time: 14:31
 */

namespace nainai;


use Library\M;
use Library\Query;
use Library\Session\Driver\Memcache;
use Library\tool;
use nainai\offer\product;

class statsMarket
{   protected $statsMarketRule=array(
    array('name','require','名称不能为空'),
    array('cate_id','number','分类不能为空'),
    array('status','number','状态不能为空'),
    array('is_del','number','是否删除不能')
    );
    protected $statsRules=array(
        array('price','require','金额必须填'),
        array('market_stats_id','number','统计商品id必须填'),
    );
    private $statsModel;
    public  function _construct(){
        $this->statsModel=new M('market_stats');
    }
    public function addStatsMarket($data){
        $statsModel=new M('market_stats');
        if($statsModel->data($data)->validate($this->statsMarketRule)){
            if(!$this->checkStatsMarketName($data['name'],$data['cate_id'])){
                $id=$statsModel->data($data)->add();

                if($id){
                    return tool::getSuccInfo(1,'添加成功');
                }
                return tool::getSuccInfo(0,'添加失败');
            }
            return tool::getSuccInfo(0,'该分类下已经存在该名称');
        }else{
            return tool::getSuccInfo(0,'添加失败:'.$statsModel->getError());
        }

    }
    public function editStatsMarket($data){
        $stataModel=new M('market_stats');
        if($stataModel->data($data)->validate($this->statsMarketRule)){
            if(!$this->checkStatsMarketName($data['name'],$data['cate_id'])){
                $where=['id'=>$data['id']];
                unset($data['id']);
               $stataModel->where($where)->data($data)->update();
                return tool::getSuccInfo(1,'修改成功');
            }
            return tool::getSuccInfo(0,'该分类下已经存在该名称');
        }else{
            return tool::getSuccInfo(0,'添加失败:'.$stataModel->getError());
        }
    }
    public function checkStatsMarketName($name,$cate_id){
        $statsModel=new M('market_stats');
        if($statsModel->where(['name'=>$name,'cate_id'=>$cate_id])->getObj())return true;
            return false;
    }
    public function getStatsMarketList($page){
        $statsObj=new Query('market_stats');
        $statsObj->where='is_del=:is_del';
        $statsObj->page=$page;
        $statsObj->bind=['is_del'=>0];
        $res=$statsObj->find();
        $pageBar=$statsObj->getPageBar();
        return [$res,$pageBar];
    }
    public function getStatsMarketInfo($id){
        $statsModel=new M('market_stats');
        return $statsModel->where(['id'=>$id])->getObj();
    }
    public function addStats($data){
        $statsObj=new M('market_stats_data');
        if($statsObj->data($data)->validate($this->statsRules)){
            if($data['create_time']!=''){
                $data['create_time']=date('Y-m-d H:i:s',strtotime($data['create_time']));
            }else{
                $data['create_time']=date('Y-m-d H:i:s',time());
            }
            $id=$statsObj->data($data)->add();
            if($id){
                return tool::getSuccInfo(1,'添加成功','',$id);
            }
            return tool::getSuccInfo(0,'添加失败');
        }
        return tool::getSuccInfo(0,$statsObj->getError());
    }
    public function getStatsInfo($id){
        $statsObj=new Query('market_stats_data as s');
        $statsObj->where='s.id=:id';
        $statsObj->bind=['id'=>$id];
        $statsObj->join='left join market_stats as m on s.market_stats_id=m.id';
        $statsObj->fields='s.*,m.name';
        return $statsObj->getObj();
    }
    public function editStats($data){
        $statsObj=new M('market_stats_data');
        if($statsObj->data($data)->validate($this->statsRules)){
            if($data['create_time']!=''){
                $data['create_time']=date('Y-m-d H:i:s',strtotime($data['create_time']));
            }else{
                $data['create_time']=date('Y-m-d H:i:s',time());
            }
            $id=$data['id'];
            unset($data['id']);
            $statsObj->where(['id'=>$id])->data($data)->update();
            return tool::getSuccInfo(1,'修改成功');
        }else{
            return tool::getSuccInfo(0,$statsObj->getError());
        }
    }
    public function getStatsList($page){
        $statsObj=new Query('market_stats_data as s');
        $statsObj->join='left join market_stats as m on s.market_stats_id=m.id';
        $statsObj->page=$page;
        $statsObj->fields='s.*,m.name';
        $data=$statsObj->find();
        $pageBar=$statsObj->getPageBar();
        return [$data,$pageBar];
    }
    public function delStats($id){
        $statsObj=new M('market_stats_data');
        $statsObj->where(['id'=>$id])->delete();
        return tool::getSuccInfo(1,'删除成功');
    }
    public function getAllStatsList(){
        $memcache=new \Library\cache\driver\Memcache();
        $allStatcList=$memcache->get('allStatcList');
        if($allStatcList){
            return unserialize($allStatcList);
        }else{
            $allStatcList=array();
        }
        $productModel=new product();
        $topCat=$productModel->getTopCate(8);
        $marketObj=new Query('market_stats_data as s');
        $marketObj->join='left join market_stats as m on m.id=s.market_stats_id';
        $marketObj->fields='date(s.create_time) as create_time,s.price,m.name';
        $marketObj->order='s.create_time';
        $marketObj->where='m.cate_id=:cid';
        foreach($topCat as $k=>$v) {
            $marketObj->bind = array('cid' => $v['id']);
            $allStatcList[$v['id']]=$marketObj->find();
            $staticTimes[$v['id']]=$this->getStaticTime($v['id']);
        }
        $tmp=array();
        foreach($allStatcList as $k=>$v){
            
            foreach($v as $kk=>$vv){
                $tmp[$k][$vv['name']][]=$vv;
            }
        }
        $res=[$tmp,$staticTimes];
        $memcache->set('allStatcList',serialize($res));
        return $res;

    }
    public function getStaticTime($cid){
    /*    $memcache=new \Library\cache\driver\Memcache();
        $staticTime=$memcache->get('staticTime');
        if($staticTime){
            return unserialize($staticTime);
        }*/
        $marketObj=new Query('market_stats_data as s');
        $marketObj->join='left join market_stats as m on s.market_stats_id=m.id';
        $marketObj->where='m.status=1 and m.is_del=0 and m.cate_id=:cid';
        $marketObj->fields='distinct date(s.create_time) as create_time';
        $marketObj->order='create_time';
        $marketObj->bind=array('cid'=>$cid);
        $time=$marketObj->find();
        $res=array();
        foreach($time as $k=>$v){
            $res[$k]=$v['create_time'];
        }
        //$memcache->set('staticTime',serialize($res));
        return $res;
    }
}