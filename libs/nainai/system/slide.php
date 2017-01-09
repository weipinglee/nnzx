<?php
/**
 * 幻灯片管理
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/6/16
 * Time: 9:50
 */
namespace nainai\system;
use Library\cache\driver\Memcache;
use Library\M;

use Library\Query;


class slide{
    private $slideObj='';
    protected $slideRules=array(
        array('name','require','名称不能为空'),
        array('img','require','图片不能为空'),
        array('status','number','状态不能为空')

    );

    public function __construct(){
        $this->slideObj=new M('slide');
    }

    /**
     * 添加幻灯片
     * @param array $params
     * @return array
     */
    public function addSlide($params=array()){
        $slideObj=$this->slideObj;
        if($slideObj->data($params)->validate($this->slideRules)){
            if($this->checkName(['name'=>$params['name']])){
                return \Library\tool::getSuccInfo(0,'名称已经存在');
            }
            $slideObj->data($params)->add();
            return \Library\tool::getSuccInfo(1,'添加成功');
        }else{
            $error=$slideObj->getError();
            return \Library\tool::getSuccInfo(0,'添加失败,原因为:'.$error);
        }
    }

    /**
     *  修改幻灯片
     * @param array $params
     * @return array
     */
    public function editSlide($params=array()){
        $slideObj=$this->slideObj;
        if($slideObj->data($params)->validate($this->slideRules)){
            if($res=$this->checkName(['name'=>$params['name']])) {
                if ($res['id'] != $params['id']) {
                    return \Library\tool::getSuccInfo(0, '名称已经存在');

                }
            }
            if($slideObj->where(['id'=>$params['id']])->data($params)->update()){
                return \Library\tool::getSuccInfo(1,'修改成功');
            }
            return \Library\tool::getSUccInfo(0,'修改失败');

        }else{
            $error=$slideObj->getError();
            return \Library\tool::getSuccInfo(0,'修改失败，原因为:'.$error);
        }


    }

    /**
     * 删除幻灯片
     * @param $name
     * @return array
     */
    public function delSlide($id){
        $slideObj=$this->slideObj;
        if($slideObj->where(['id'=>$id])->delete()){
            return \Library\tool::getSuccInfo(1,'删除成功');
        }
        return \Library\tool::getSuccInfo(0,'删除失败');
    }

    /**
     * 检查名称是否重复
     * @param array $where
     * @return bool
     */
    private function checkName($where=array()){
        $slideObj=$this->slideObj;
        $res=$slideObj->where($where)->getObj();
        return $res?$res:false;
    }

    /**
     * 换取幻灯片列表
     * @param int $page
     * @return array
     */
    public function getSlideList($page=1){
        $slideObj=new \Library\Query('slide');
        $slideObj->page=$page;
        $slideObj->order='`order` ASC';
        $slideList=$slideObj->find();
        $pageBar=$slideObj->getPageBar();
        return [$slideList,$pageBar];
    }

    /**
     * 更改幻灯片的状态
     * @param array $params
     * @return array
     */
    public function setSlideStatus($params=array()){
        $slideObj=$this->slideObj;
        $where=['id'=>$params['id']];


        $data['status']=$params['status'];
        if($slideObj->where($where)->data($data)->update()){
            $memcache=new Memcache();
            $memcache->rm('indexSlide');
            return \Library\tool::getSuccInfo(1,'修改成功');
        }else{
            return \Library\tool::getSuccInfo(0,'修改失败');
        }

    }
    public function getSlideInfo($id){
        return $this->slideObj->where(['id'=>$id])->getObj();
    }

    public static function getIndexSlide(){
        $memcache=new Memcache();
        $indexSlide=$memcache->get('indexSlide');
        if(isset($indexSlide)&&$indexSlide){
            $res=unserialize($indexSlide);
            return $res;
        }
        $slideObj=new M('slide');
        $res=$slideObj->where(array('status'=>1))->order('`order` asc')->select();
        $memcache->set('indexSlide',serialize($res));
        return $res;
    }


}