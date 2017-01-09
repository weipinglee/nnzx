<?php
/**
 * 友情链接管理类
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/6/15
 * Time: 13:14
 */
namespace nainai\system;
use Library\M;
use Library\tool;

class friendlyLink{

    protected $linkRules=array(
      array('name','require','名称不能为空'),
      array('link','require','链接地址不能为空'),
      array('status','number','状态不能为空'),
    );
    private $frdLinkObj='';
    public function __construct(){
        $this->frdLinkObj=new M('friendly_link');
    }

    /**
     * 添加链接
     * @param array $params
     * @return array
     */
    public function addLink($params=array()){
        $frdLinkObj=$this->frdLinkObj;
        if($frdLinkObj->data($params)->validate($this->linkRules)){
            if($this->checkName(['name'=>$params['name']])){
                return \Library\tool::getSuccInfo(0,'名称不能重复');
            }
            $res=$frdLinkObj->data($params)->add();
            return  \Library\tool::getSuccInfo(1,'添加成功');
        }else{
            $error=$frdLinkObj->getError();
            return \Library\tool::getSUccInfo(0,'添加失败，原因为:'.$error);
        }
    }

    /**
     * 修改链接
     * @param array $params
     * @return array
     */
    public function editLink($params=array()){
        $frdLinkObj=$this->frdLinkObj;
        if($frdLinkObj->data($params)->validate($this->linkRules)){
            $where=['name'=>$params['name']];
            if($res=$this->checkName($where)){
                if($res['id']!=$params['id']) {
                    return \Library\tool::getSuccInfo(0, '名称已经存在');
                }
            }
            if($frdLinkObj->where($where)->data($params)->update()){
                return \Library\tool::getSuccInfo(1,'修改成功');
            }else{
                return \Library\tool::getSuccInfo(0,'修改失败');
            }
        }else{
            $error=$frdLinkObj->getError();
            return \Library\tool::getSuccInfo(0,'添加失败,原因为:'.$error);
        }

    }

    /**
     * 获取链接列表
     * @param int $page
     * @return array
     */
    public function getfrdLinkList($page=1){
        $frdLinkObj=new \Library\Query('friendly_link');
        $frdLinkObj->page=$page;
        $frdLinkObj->order='`order` ASC';
        $res=$frdLinkObj->find();
        $pageBar=$frdLinkObj->getPageBar();
        return array($res,$pageBar);
    }

    /**
     * 获取前台显示友情链接
     * @param $num
     */
    public function getFrdLink($num){
        $memcache=new \Library\cache\driver\Memcache();
        $frdLink=$memcache->get('frdLink');
        if($frdLink){
            return unserialize($frdLink);
        }
        $frdObj = $this->frdLinkObj;
        $frdLink=$frdObj->where(array('status'=>1))->order('`order` asc')->limit($num)->select();
        $memcache->set('frdLink',serialize($frdLink));
        return $frdLink;
    }

    /**
     * 更改链接状态
     * @param array $params
     * @return array
     */
    public function setLinkStatus($params=array()){
        $frdLinkObj=$this->frdLinkObj;
        $where=['id'=>$params['id']];

            $data['status']=$params['status'];
            if($frdLinkObj->where($where)->data($data)->update()){
                return \Library\tool::getSuccInfo(1,'修改成功');
            }else{
                return \Library\tool::getSuccInfo(0,'修改失败');
            }


    }

    /**
     * 检查名称是否存在
     * @param array $data
     * @return mixed
     */
    public function checkName($data=array()){
        $frdLinkObj=$this->frdLinkObj;
        $res=$frdLinkObj->where($data)->getObj();
        return $res;
    }

    /**
     * 删除链接
     * @param $name
     * @return array
     */
    public function delLink($id){
        $where=['id'=>$id];
        $frdLinkObj=$this->frdLinkObj;
        $res=$frdLinkObj->where($where)->delete();
        return $res ? tool::getSuccInfo(1,'删除成功'):tool::getSuccInfo(0,'删除失败');
    }
    public function getLinkInfo($id){
        $where=['id'=>$id];
        return $this->frdLinkObj->where($where)->getObj();

    }
}