<?php
/**
 * 统计管理类
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/6/6
 * Time: 10:10
 */
namespace nainai;
use Library\cache\driver\Memcache;
use Library\M;
use Library\Query;
use Library\tool;
use \nainai\offer\product;

class statistics{
    static $childCat=array();
    const MAKET_STATIC=1;//市场统计
    const COMMODITY_STATIC=2;//商品统计
    public $interval=5;//间隔时间
    //统计分类表验证规则
    protected $catStaticRules=array(
        array('cate_id','number','分类id不能为空'),
        array('type','number','类型不能为空')
    );
    //统计表验证规则
    protected  $marketRules=array(
        array('cate_id','number','分类id不能为空'),
        array('type','number','类型不能为空'),
        array('ave_price','double','价格不能为空'),
        array('prev_price','double','价格不能为空'),
        array('days','number','统计时间不能为空')

    );


    /**
     * 添加分类
     * @param $cateId 分类id
     * @param $type 类型
     * @return array
     */
    public function addCate($cateId, $type){
        $catObj=new M('static_category');
        $data=array(
            'cate_id'=>$cateId,
            'type'=>$type
        );
        if($catObj->where($data)->getObj()){
            return tool::getSuccInfo(0,'该分类的统计类型已经存在');
        }
        if($catObj->data($data)->validate($this->catStaticRules)){
            $pro = new \nainai\offer\product();
            $data['top_cate'] = $pro->getcateTop($cateId);
            if($catObj->data($data)->add()){
                return tool::getSuccInfo(1,'添加成功');
            }else {
                return tool::getSuccInfo(0, '添加失败');
            }
        }
    }
    /**
     * 删除分类
     * @param $cateId 分类id
     * @param $type 类型
     * @return array
     */
    public function delCate($cateId, $type){
        $catObj=new M('static_category');
        $data=array(
            'cate_id'=>$cateId,
            'type'=>$type
        );
        if($catObj->where($data)->delete()){
            return tool::getSuccInfo(1,'删除成功');
        }else{
            return tool::getSuccInfo(0,'分类不存在');
        };
    }
    /**
     * 创建市场指数统计
     * @return array
     */
    public function  createStatistics(){
        $marketObj=new M('static_market');
        $createTime = $marketObj->order('id desc')->getField('create_time');

        if($createTime!==false && $this->interval>\Library\time::getDiffDays($createTime,\Library\time::getDateTime())){
            return tool::getSuccInfo(0,'统计时间还没到');
        }

        $catList=$this->getStatCateList();


        $offerObj=new Query('product_offer as f');
        $offerObj->join='left join products as p on f.product_id=p.id';
        $offerObj->fields='AVG(f.price) as "avg"';
        

        $data=array(
            'create_time'=>date('Y-m-d H:i:s',time()),
            'days'=>$this->interval
        );
        $error=array();

        foreach($catList as $key=>$cate){
           $prev_price = $marketObj->where(array('cate_id'=>$cate['cate_id'],'type'=>$cate['type']))->order('id desc')->getField('ave_price');
            if(!$prev_price)
                $prev_price = 0;
            $cate_childs = $this->getChildCate($cate['cate_id']);
            $cate_childs[] =$cate['cate_id'];
            $cate_childs = join(',',$cate_childs);
            $offerObj->where='f.type=1 and p.cate_id in ('.$cate_childs.') and datediff(NOW(),f.apply_time)<'.$this->interval;
            $offerObj->order = 'f.price asc';
            $res = $offerObj->find();

            if(empty($res)||$res[0]['avg']==null){
                $data['ave_price'] = $prev_price;
            }
            else{
                $data['ave_price']=$res[0]['avg'];
            }


            $data['prev_price'] = $prev_price;
            $data['cate_id']=$cate['cate_id'];
            $data['type'] = $cate['type'];
            if($marketObj->data($data)->validate($this->marketRules)){
                    $marketObj->data($data)->add();
            }else{
                    $error[]=$marketObj->getError();
            }

        }

        if(empty($error)){
            return tool::getSuccInfo(1,'添加成功');
        }else{
            return tool::getSuccInfo(0,count($error).'条插入失败');
        }
    }

    protected function getChildCate($id){
        $obj = new M('product_category');
        $arr = array();
        $data = $obj->where(array('pid'=>$id))->fields('id')->select();
        if(!empty($data)){
            foreach($data as $k=>$v){
                $arr[] = $v['id'];
                $arr = array_merge($arr,$this->getChildCate($v['id']));
            }
        }
        return $arr;
    }
    /**
     * 获取所有的统计分类
     * @return array
     */
    private function getAllCat(){
        //$catObj=new M('static_category');
        $catObj=new Query('static_category');
        $catList=$catObj->find();
        $result=array();
        foreach($catList as $k=>$v){
            $result[$v['type']][]=$v;
        }
        return $result;
    }

    public function getStatCateList(){
        $catObj=new Query('static_category as s');
        $catObj->join = 'left join product_category as c on s.cate_id=c.id';
        $catObj->fields = 's.id as stat_id,s.cate_id,s.type,s.status as static_status,c.*';
        $catList=$catObj->find();
        foreach($catList as $k=>$v){
            $catList[$k]['type_text'] = $this->getStatsType($v['type']);
        }
        return $catList;
    }

    /**
     * 获取最新的统计数据
     * @param $type
     * @return array
     */
    public function getNewStatistics($type){
        if($type==self::COMMODITY_STATIC||$type==self::MAKET_STATIC){
            $marketObj=new Query('static_market as m');
            $marketObj->join='left join product_category as c on m.cate_id=c.id';
            $marketObj->fields='c.name,m.*';
            $marketObj->where='m.type= :type and datediff(NOW(),m.create_time)<'.$this->interval;
            $marketObj->bind=array('type'=>$type);
            $mRes=$marketObj->find();

            $result=array();
            foreach($mRes as $k=>$v){
                $result[$v['cate_id']]['name']=$v['name'];
                unset($v['name']);
                $result[$v['cate_id']]['data']=$v;
            }
            return $result;

        }else{
            return tool::getSuccInfo(0,'要获取的数据类型不存在');
        }
    }

    /**
     * 获取统计数据列表
     * @param int $page
     * @return array
     */
    public static function getMarketStatsList($page=1){
        $marketObj=new Query('static_market as m');
        $marketObj->join='left join product_category as c on m.cate_id=c.id';
        $marketObj->fields='c.name,m.*';
        $marketObj->page=$page;
        $res=$marketObj->find();
        $resPageBar=$marketObj->getPageBar();
        return array($res,$resPageBar);
    }

    /**
     * 根据类型获取统计名称
     * @param $type
     * @return string
     */
    public static function getStatsType($type){
        switch(intval($type)){
            case self::COMMODITY_STATIC:
                return '商品统计';
            break;
            case self::MAKET_STATIC:
                return '市场统计';
            break;
            default:
                return '未知类型';
            break;
        }
    }

    /**
     * 获取所有的统计类型
     * @return array
     */
    public static function getAllType(){
        return array(
            self::MAKET_STATIC=>'市场统计',
            self::COMMODITY_STATIC=>'商品统计'
        );
    }
    //删除统计
    public static function delStats($id){
        $statsModel=new M('static_market');
        $where=array('id'=>$id);
        $res=$statsModel->where($where)->delete();
        $memcache=new Memcache();
        return  $res?tool::getSuccInfo(1,'删除成功'):tool::getSuccInfo(0,'删除失败');

    }
    public static function delStatsCate($id){
        $statsModel=new M('static_category');
        $where=array('id'=>$id);

        $res=$statsModel->where($where)->delete();
        return  $res?tool::getSuccInfo(1,'删除成功'):tool::getSuccInfo(0,'删除失败');
    }

    /**
     * 获取最新的统计数据
     * @param $type
     * @return mixed
     */
    public function getNewStatcList($type){
        $productModel=new product();
        $topCat=$productModel->getTopCate();
        $marketObj=new Query('static_market as m');
        $marketObj->join='left join product_category as c on m.cate_id=c.id';
        $marketObj->fields='c.name,m.*';
        $marketObj->where='m.type= :type and datediff(NOW(),m.create_time)<'.$this->interval.' and find_in_set(m.cate_id,getChildLists(:cid))';
        
		foreach($topCat as $k=>$v) {
            $marketObj->bind = array('cid' => $v['id'], 'type' => $type);
			$marketObj->cache = 'm';
            $newStatcList[$v['id']]=$marketObj->find();
        }
        return $newStatcList;
    }

    /**
     * 获取最新统计数据（不分类）
     */
    public function getNewStaticListNocate($type){
        $marketObj=new Query('static_market as m');
        $marketObj->join='left join product_category as c on m.cate_id=c.id';
        $marketObj->fields='c.name,m.*';
        $marketObj->limit = 10;
        $marketObj->where='m.type= :type and datediff(NOW(),m.create_time)<'.$this->interval;
        $marketObj->bind = array('type'=>$type);
		$marketObj->cache = 'm';
        $data = $marketObj->find();
        return $data;
    }
    /*
     *
     * */
    public function getStaticTime($type){
        $memcache=new Memcache();
     /*   $staticTime=$memcache->get('staticTime');
        if($staticTime){
            return unserialize($staticTime);
        }*/
        $marketObj=new Query('static_market');
        $marketObj->fields='distinct date(create_time) as create_time';
        $marketObj->where='type= :type';
        $marketObj->order='create_time';
        $marketObj->bind=array('type'=>$type);
        $time=$marketObj->find();
       $res=array();
         foreach($time as $k=>$v){
            $res[$k]=$v['create_time'];
        }
        $memcache->set('staticTime',serialize($res));
        return $res;
    }
    
    //获取热门商品数据
    public function getHotProductDataList($l=10)
    {
        $memcache=new Memcache();
        $hotProductDataList=$memcache->get('hotProductDataList');
        if($hotProductDataList){
            return unserialize($hotProductDataList);
        }
        $query=new Query('products_stats_data as psd');
        $query->join='left join products_stats as ps on psd.products_stats_id=ps.id';
        $query->fields = 'ps.id, ps.name';
        $query->distinct = 1;
        $query->limit = $l;
        $query->where='ps.status = 1 and ps.is_del = 0';
        // $query->order = "psd.id DESC, ps.id DESC";
        $query->cache = 'm';
        $data = $query->find();
        $obj = new M('products_stats_data');
        $ret = array();
        foreach($data as $k => $v)
        {
            $temp = $obj->where('products_stats_id='.$v['id'])->order('id DESC')->getObj();
            $temp['name'] = $v['name'];
            $ret[] = $temp;
        }
        $memcache->set('hotProductDataList',serialize($ret));
        return $ret;
    }
}