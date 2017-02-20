<?php
/**
 * 关于系统帮助
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/6/16
 * Time: 15:20
 */
namespace nainai;
use Library\cache\driver\Memcache;
use Library\M;
use Library\Query;
use Library\tool;

class SiteHelp
{
    protected $helpRules=array(
        array('cat','number','分类id必须存在'),
        array('sort','number','排序必须为数字'),
        array('name','require','名称必须存在'),
        );
    protected $helpCatRules=array(
        array('name','require','名称必须存在'),
        array('sort','number','排序为数字'),
        array('status','number','状态不能为空'),
    );
    private $helpObj='';
    private $helpCatObj='';
    public function __construct(){
        $this->helpObj=new \Library\M('help');
        $this->helpCatObj=new \Library\M('help_category');
    }
    public  function getHelpById($id)
    {
        $helpObj=new Query('help as h');
        $helpObj->join='left join help_category as c on c.id=h.cat_id';
        $helpObj->where='h.id= :id';
        $helpObj->fields='h.*,c.id as cId,c.name as cName';
        $helpObj->bind=array('id'=>$id);
        $res=$helpObj->getObj();
        return $res;

    }
    public function getHelpCatById($id){
        $where['id']=$id;
        return $this->helpCatObj->where($where)->getObj();
    }
    public function addhelp($data){
        $helpObj=$this->helpObj;
        if($helpObj->data($data)->validate($this->helpRules)){
            if($this->checkHelpName(['name'=>$data['name']])){
                return \Library\tool::getSuccInfo(0,'名称存在');
            }
            $helpObj->data($data)->add();
            return \Library\tool::getSuccInfo(1,'添加成功');
        }else{
            $error=$helpObj->getError();
            return \Library\tool::getSuccInfo(0,'添加失败原因为:'.$error);
        }
    }
    public function addhelpCat($data){
        $helpCatObj=$this->helpCatObj;
        if($helpCatObj->data($data)->validate($this->helpCatRules)){
            if($this->checkHelpCatName(['name'=>$data['name']])){
                return \Library\tool::getSuccInfo(0,'名称存在');
            }
            $helpCatObj->data($data)->add();
            return \Library\tool::getSuccInfo(1,'添加成功');
        }else{
            $error=$helpCatObj->getError();
            return \Library\tool::getSuccInfo(0,'添加失败原因为:'.$error);
        }

    }
    public function helpEdit($data)
    {
        $helpObj=$this->helpObj;
        if($helpObj->data($data)->validate($this->helpRules)){
            if($res=$this->checkHelpName(['name'=>$data['name']])){
                if($res['id']==$data['id']){
                    $helpObj->data($data)->where(['id'=>$data['id']])->update();
                    return \Library\tool::getSuccInfo(1,'修改成功');
                }else{
                    return \Library\tool::getSuccInfo(0,'名称重复');
                }
            }
            $helpObj->data($data)->where(['id'=>$data['id']])->update();
            return \Library\tool::getSuccInfo(1,'修改成功');
        }else{
            $error=$helpObj->getError();
            return \Library\tool::getSuccInfo(0,'修改失败原因为:'.$error);
        }

    }
    public function helpCatEdit($data){
        $helpCatObj=$this->helpCatObj;
        if($helpCatObj->data($data)->validate($this->helpCatRules)){
            $helpCatObj->data($data)->where(['id'=>$data['id']])->update();
            return \Library\tool::getSuccInfo(1,'修改成功');
        }else{
            $error=$helpCatObj->getError();
            return \Library\tool::getSuccInfo(0,'修改失败原因为:'.$error);
        }
    }

    public  function helpDel($id)
    {
        $helpObj=$this->helpObj;
        $where=['id'=>$id];
        $res=$helpObj->where($where)->delete();
        return $res?\Library\tool::getSuccInfo(1,'删除成功'):\Library\tool::getSuccInfo(0,'删除失败');
    }

    public  function helpCatDel($id)
    {
        $helpCatObj=$this->helpCatObj;
        $where=['id'=>$id];
        $res=$helpCatObj->where($where)->delete();
        return $res?\Library\tool::getSuccInfo(1,'删除成功'):\Library\tool::getSuccInfo(0,'删除失败');
    }

    public function getHelpList($page=1)
    {
        $helpObj=new \Library\Query('help as h');
        $helpObj->join='left join help_category as c on c.id=h.cat_id';
        $helpObj->fields='c.name as cname,h.*';
        $helpObj->order='`sort` ASC';
        $helpObj->page=$page;
        $helpList=$helpObj->find();
        $pageBar=$helpObj->getPageBar();
        return [$helpList,$pageBar];
    }
    public function getHelpCatList($page=1){
        $helpCatObj=new \Library\Query('help_category');
        $helpCatObj->page=$page;
        $helpCatObj->order='`sort` ASC';
        $helpCatList=$helpCatObj->find();
        $pageBar=$helpCatObj->getPageBar();
        return [$helpCatList,$pageBar];
    }
    public function checkHelpName($where){
        $helpObj=$this->helpObj;
        $res=$helpObj->where($where)->getObj();
        return $res?$res:false;
    }
    public function checkHelpCatName($where){
        $helpCatObj=$this->helpCatObj;
        $res=$helpCatObj->where($where)->getObj();
        return $res?$res:false;
    }
    public function setCatStatus($data){
        $helpCatObj=$this->helpCatObj;
        $res=$helpCatObj->data($data)->where(['id'=>$data['id']])->update();
        return $res?tool::getSuccInfo(1,'修改成功'):tool::getSuccInfo(0,'修改失败');
    }
    public function getAllCat(){
        $helpCatObj=new Query('help_category');
        $helpCatObj->fields='id,name';
        $res=$helpCatObj->find();
        return $res;
    }
    public static function getFuwuList(){
        $memcache=new Memcache();
        $fuwuList=$memcache->get('fuwuList');
        if($fuwuList){
            return unserialize($fuwuList);
        }
        $helpCatObj=new M('help_category');
        $helpCatInfo=$helpCatObj->where(['name'=>'服务'])->getObj();
        if($helpCatInfo){
            $helpObj=new Query('help');
            $helpObj->where='cat_id= :cat_id';
            $helpObj->limit=5;
            $helpObj->order='sort asc';
            $helpObj->bind=array('cat_id'=>$helpCatInfo['id']);

            $fuwuList=$helpObj->find();
            $memcache->set('fuwuList',serialize($fuwuList));
            return $fuwuList;
        }
        return false;

    }
}