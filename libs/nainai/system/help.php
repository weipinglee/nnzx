<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 17:07
 */

namespace nainai\system;


use Library\M;
use Library\Query;
use Library\Session\Driver\Memcache;

class help
{
    public $helpLimit=4;
    public $helpCatLimit=4;
    public function getHelplist(){
        $memcache=new \Library\cache\driver\Memcache();
        $helpList=$memcache->get('helpList'.$this->helpCatLimit.$this->helpLimit);
        if($helpList){
            return unserialize($helpList);
        }
        $helpCatObj=new Query('help_category');
        $helpCatObj->where="status=:status and name<>:name";
        $helpCatObj->bind=['status'=>1,'name'=>'服务'];
        if($this->helpCatLimit!='') {
            $helpCatObj->limit = $this->helpCatLimit;
        }
        $helpCatObj->order=' sort asc';
        $helpCatList=$helpCatObj->find();
        $helpObj=new Query('help');
        if($this->helpLimit!="") {
            $helpObj->limit = $this->helpLimit;
        }
        $helpObj->order=' sort asc';
        $helpList=array();
        foreach($helpCatList as $k=>$v){
            $helpObj->where='cat_id=:cat_id';
            $helpObj->bind=['cat_id'=>$v['id']];
            $helpList[$k]['cat_id']=$v['id'];
            $helpList[$k]['name']=$v['name'];
            $helpList[$k]['data']=$helpObj->find();
        }
        $memcache->set('helpList'.$this->helpCatLimit.$this->helpLimit,serialize($helpList));
        return $helpList;
    }
    public function getAllHelpList(){
        $memcache=new \Library\cache\driver\Memcache();
        $helpList=$memcache->get('allHelpList'.$this->helpCatLimit.$this->helpLimit);
        if($helpList){
            return unserialize($helpList);
        }
        $helpCatObj=new Query('help_category');
        $helpCatObj->where="status=:status";
        $helpCatObj->bind=['status'=>1];
        if($this->helpCatLimit!='') {
            $helpCatObj->limit = $this->helpCatLimit;
        }
        $helpCatObj->order=' sort asc';
        $helpCatList=$helpCatObj->find();
        $helpObj=new Query('help');
        if($this->helpLimit!="") {
            $helpObj->limit = $this->helpLimit;
        }
        $helpObj->order=' sort asc';
        $helpList=array();
        foreach($helpCatList as $k=>$v){
            $helpObj->where='cat_id=:cat_id';
            $helpObj->bind=['cat_id'=>$v['id']];
            $helpList[$k]['cat_id']=$v['id'];
            $helpList[$k]['name']=$v['name'];
            $helpList[$k]['data']=$helpObj->find();
        }
        $memcache->set('allHelpList'.$this->helpCatLimit.$this->helpLimit,serialize($helpList));
        return $helpList;
    }
}