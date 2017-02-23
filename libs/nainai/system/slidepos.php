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


class slidepos{
    private $slideposObj='';
    protected $slideposRules=array(
        array('name','require','名称不能为空'),

    );

    public function __construct(){
        $this->slideposObj=new M('slide_position');
    }

    /**
     * 添加幻灯片
     * @param array $params
     * @return array
     */
    public function addSlidepos($params=array()){
        $slideposObj=$this->slideposObj;
        if($slideposObj->data($params)->validate($this->slideposRules)){
            if($this->checkName(['name'=>$params['name']])){
                return \Library\tool::getSuccInfo(0,'名称已经存在');
            }
            $slideposObj->data($params)->add();
            return \Library\tool::getSuccInfo(1,'添加成功');
        }else{
            $error=$slideposObj->getError();
            return \Library\tool::getSuccInfo(0,'添加失败,原因为:'.$error);
        }
    }

    /**
     *  修改幻灯片
     * @param array $params
     * @return array
     */
    public function editSlidepos($params=array()){

        $slideposObj=$this->slideposObj;
        if($slideposObj->data($params)->validate($this->slideposRules)){
            if($res=$this->checkName(['name'=>$params['name']])) {
                if ($res['id'] != $params['id']) {
                    return \Library\tool::getSuccInfo(0, '名称已经存在');

                }
            }
            if($slideposObj->where(['id'=>$params['id']])->data($params)->update()){
                return \Library\tool::getSuccInfo(1,'修改成功');
            }
            return \Library\tool::getSUccInfo(0,'修改失败');

        }else{
            $error=$slideposObj->getError();
            return \Library\tool::getSuccInfo(0,'修改失败，原因为:'.$error);
        }


    }

    /**
     * 删除幻灯片
     * @param $name
     * @return array
     */
    public function delSlidepos($id){
        $slideposObj=$this->slideposObj;
        if($slideposObj->where(['id'=>$id])->delete()){
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
        $slideposObj=$this->slideposObj;
        $res=$slideposObj->where($where)->getObj();
        return $res?$res:false;
    }
    
    /**
     * 换取幻灯片列表
     * @param int $page
     * @return array
     */
    public function getSlideposList($page=1){
        $slideposObj=new \Library\Query('slide_position');
        $slideposObj->page = $page;
        $slideposList=$slideposObj->find();
        $page = $slideposObj->getPageBar();
        return [$slideposList,$page];
    }
    public function getSlideposHtml($id=0){
        $list = $this->getSlideposList();
        $html = '';
        foreach ($list[0] as $key => $value) {
            $is_select = $value['id'] == $id ? "selected = 'selected'" : '';
            
            $html .= <<<STR
            <option value='{$value['id']}' {$is_select}>{$value['intro']}</option>;
STR;
        }

        return $html;
    }

    /**
     * 更改幻灯片的状态
     * @param array $params
     * @return array
     */
    public function setSlideposStatus($params=array()){
        $slideposObj=$this->slideposObj;
        $where=['id'=>$params['id']];


        $data['status']=$params['status'];
        if($slideposObj->where($where)->data($data)->update()){
            $memcache=new Memcache();
            $memcache->rm('indexSlidepos');
            return \Library\tool::getSuccInfo(1,'修改成功');
        }else{
            return \Library\tool::getSuccInfo(0,'修改失败');
        }

    }
    public function getSlideposInfo($id){
        return $this->slideposObj->where(['id'=>$id])->getObj();
    }

    public static function getIndexSlidepos(){
        $memcache=new Memcache();
        $indexSlidepos=$memcache->get('indexSlidepos');
        if(isset($indexSlidepos)&&$indexSlidepos){
            $res=unserialize($indexSlidepos);
            return $res;
        }
        $slideposObj=new M('slide_position');
        $res=$slideposObj->where(array('status'=>1))->order('`order` asc')->select();
        $memcache->set('indexSlidepos',serialize($res));
        return $res;
    }


}