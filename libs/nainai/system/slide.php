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
use Library\Thumb;
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

    public static function getSlidebyPos($pos_name=''){
        // $memcache=new Memcache();
        // $indexSlide=$memcache->get('Slide'.$pos_id);
        if(isset($indexSlide)&&$indexSlide){
            $res=unserialize($indexSlide);
            return $res;
        }
        $slideObj=new Query('slide as s');
        $slideObj->join = 'left join slide_position as sp on sp.id = s.pos_id';
        $slideObj->fields = 's.*';
        $slideObj->where = " s.status=1 and sp.name='".$pos_name."'";
        $slideObj->order='`order` asc';
        $res = $slideObj->find();
        foreach ($res as $key => $value) {
            $value['thumb_img'] = Thumb::get($value['img']);
            $value['img'] = Thumb::getOrigImg($value['img']);

            $tmp [$value['id']] = $value;
        }
        // $memcache->set('Slide'.$pos_id,serialize($res));
        return $tmp;
    }
    
    public static function combineShow($pos_name='',$start=0,$length=4,$attach = 3){
        $data = self::getSlidebyPos($pos_name);
        $data = array_reverse($data);
        error_reporting(0);
        // $data = array_slice($data, $start,$length);
        $suf_data = array_reverse(array_slice($data, 0,$attach));//小图数据
        
        $data = array_reverse(array_slice($data,$attach,count($data)-$attach));

        $pre_html = "<ul class='num'></ul><ul class='des'>";
        $html = "<div id='banner'> <ul class='img'>";
        foreach ($data as $key => $item) {
            $is_on = $key == 0 ? "class='on'" : '';
            $pre_html .= "<li><p>{$item['name']}</p></li>";
            $html .= <<<STR
            <li><a href="{$item['link']}" target="_blank"><img src="{$item['img']}" title="{$item['name']}" width="640" height="320" alt="{$item['name']}" class="pic_zoom"/></a></li>
STR;
        }
        $html .= '</ul>';
        $pre_html .= '</ul><div class="btn"><span class="prev"><</span><span class="next">></span></div></div>';


        $suf_html = "<div id='banner_list'><ul>";
        foreach ($suf_data as $key => $value) {
            $suf_html .= "<li><a href='#'' target='_blank'><img src='{$value['thumb_img']}' alt='{$value['name']}'' width='190' height='100' class='pic_zoom1'></a><h3><a href=‘#’>{$value['name']}</a> </h3> </li>";
        }
        $suf_html .= '</ul></div>';
        $html = $html.$pre_html.$suf_html;

        return $html;   
    }

}