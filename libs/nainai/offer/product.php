<?php
/**
 * 商品管理类
 * author: weipinglee
 * Date: 2016/4/19
 * Time: 13:31
 */
namespace nainai\offer;
use Library\cache\driver\Memcache;
use \Library\M;
use \Library\Time;
use \Library\Query;
use \Library\Thumb;
use \Library\log;
use \Library\tool;
class product  {

    private $product_limit = 5;

    protected $offer_table = 'product_offer';

    protected $expire_days = 30;//过期天数

    protected $errorCode = array(
        'fundLess' => array('code'=>-1,'info'=>'账户余额不足'),
        'dataWrong' => array('code'=>1,'info'=>''),
        'server'   => array('code'=>2,'info'=>'网络错误')
    );

    //是否可拆分
    const DIVIDE = 1;//可拆分
    const UNDIVIDE = 0;//不可拆分
    //报盘类型
    const PURCHASE_OFFER = 0;
    const FREE_OFFER  = 1;
    const DEPOSIT_OFFER = 2;
    const DEPUTE_OFFER  = 3;
    const STORE_OFFER = 4;

    private $_errorInfo = '';

    protected $user_id = '';

    //报盘状态
    const OFFER_APPLY = 0;
    const OFFER_OK    = 1;
    const OFFER_NG    = 2;
    const OFFER_CANCEL = 4; //取消报盘


    public function getModelArray(){
        return array(
            self::FREE_OFFER => $this->getMode(self::FREE_OFFER),
            self::DEPOSIT_OFFER => $this->getMode(self::DEPOSIT_OFFER),
            self::STORE_OFFER => $this->getMode(self::STORE_OFFER),
            self::DEPUTE_OFFER => $this->getMode(self::DEPUTE_OFFER),
            self::PURCHASE_OFFER => $this->getMode(self::PURCHASE_OFFER),

        );
    }

    const TYPE_BUY = 2;
    const TYPE_SELL = 1;
    //获取交易方式
    public function getType($type){
        switch ($type) {
            case self::TYPE_SELL:
                $tp = '卖盘';
                break;
            case self::TYPE_BUY:
                $tp = '买盘';
                break;

            default:
                $tp = '未知';
                break;
        }
        return $tp;
    }

    public function getTypeArray(){
        return array(
            self::TYPE_SELL => $this->getType(self::TYPE_SELL),
            self::TYPE_BUY => $this->getType(self::TYPE_BUY)
        );
    }


    //获取状态信息
    public function getStatus($status){
        switch ($status) {
            case self::OFFER_APPLY:
                $st = '待审核';
                break;
            case self::OFFER_OK:
                $st = '已通过';
                break;
            case self::OFFER_NG:
                $st = '未通过';
                break;
            case self::OFFER_CANCEL:
                $st = '撤单';
                break;
            default:
                $st = '未知';
                break;
        }
        return $st;
    }

    //获取是否可拆分
    public function getDivide($div){
        $divide = array(
            self::UNDIVIDE=>'否',
            self::DIVIDE=>'是'
        );
        if($div==1 || $div==0){
            return $divide[$div];
        }
        return $divide[0];
    }
    //获取报盘模式文本
    public function getMode($mode){
        switch ($mode) {
            case self::PURCHASE_OFFER:
                $mode_txt = '采购报盘';
                break;
            case self::FREE_OFFER:
                $mode_txt = '自由报盘';
                break;
            case self::DEPOSIT_OFFER:
                $mode_txt = '保证金报盘';
                break;
            case self::STORE_OFFER:
                $mode_txt = '仓单报盘';
                break;
            case self::DEPUTE_OFFER :
                $mode_txt = '委托报盘';
                break;
            default:
                $mode_txt = '未知';
                break;
        }
        return $mode_txt;
    }

    public function getStatusArray(){
        return array(
            self::OFFER_APPLY => $this->getStatus(self::OFFER_APPLY),
            self::OFFER_OK => $this->getStatus(self::OFFER_OK),
            self::OFFER_NG => $this->getStatus(self::OFFER_NG)
        );
    }


    /**
     * 商品验证规则
     * @var array
     */
    protected $productRules = array(
        array('name','require','商品名称必须填写'),
        array('cate_id','number','商品类型id错误'),
        array('price','currency','商品价格必须是数字'),
        array('quantity','double','供货总量必须是数字'),
        array('attribute', 'require', '请选择商品属性'),
        array('note', 'require', '商品描述必须填写')
    );

    /**
     * 报盘验证规则
     * @var array
     */
    protected $productOfferRules = array(
        array('product_id', 'number', '必须有商品id'),
        array('mode', 'number', '必须有报盘类型'),
        array('divide', 'number','是否可拆分的id错误'),
        array('minimum','double','最小起订量错误'),
        array('minstep','double','最小递增量错误'),
        array('price','currency','商品价格必须是数字'),
        array('price_l','currency','商品价格必须是数字'),
        array('price_r','currency','商品价格必须是数字'),
        array('acc_type','/^[\d+,?]+$/','账户类型错误'),
        array('sign','/^[a-zA-Z0-9_@\.\/]+$/','请上传图片'),
        array('accept_area', 'require', '交收地点必须填写'),
        array('accept_day', 'number', '交收时间必须填写')
    );

    /**
     * pdo的对象
     * @var [Obj]
     */
    protected $_productObj;

    /**
     * @param int $user_id 用户id
     */
    public function __construct($user_id=0){
        $this->_productObj = new M('products');
        if($user_id!=0){
            $this->user_id = $user_id;
        }
    }

    public function getErrorMessage(){
        return $this->_errorInfo;
    }

    public function setErrorMessage($mess){
        $this->_errorInfo = $mess;
    }

    /**
     * 获取层级分类
     * @param int $pid
     * @return mixed
     */
    public function getCategoryLevel($pid = 0){
        $where  = array('status' => 1,'is_del'=>0,'pid'=>$pid);
        static $res = array();
        $category = $this->_productObj->table('product_category')->fields('id,pid, name, unit, childname, attrs, risk_data')->where($where)->select();
        $childName = '';

        if(empty($res) && $pid!=0){
            $cate = $this->_productObj->table('product_category')->where(array('id'=>$pid))->fields('childname,pid')->getObj();

            $childName = $cate['childname'];
            $res['chain'] = array($pid);
            while($cate['pid']!=0){
                array_unshift($res['chain'],$cate['pid']) ;
                $cate['pid'] = $this->_productObj->table('product_category')->where(array('id'=>$cate['pid']))->getField('pid');
            }

        }

        if(!empty($category)){
            $res['defaultCate'] = $category[0]['id'];
            $res['unit'] = $category[0]['unit'];
            $res['cate'][]['show'] = $category;
            $res['chain'][] = $category[0]['id'];
            $this->getCategoryLevel($category[0]['id']);
        }
        else{
            $res['defaultCate'] = $pid;
        }
        $res['childname'] = $childName;

        return  $res;
    }


    /**
     * 获取指定的分类层级
     * @param array $cate array(2,3,4)，2是顶级分类，3是2的下级分类，。。。
     */
    public function getCategoryLevelSpec($cate){
        array_unshift($cate,0);
        $where  = array('status' => 1,'is_del'=>0);
        $res = array();
        foreach($cate as $key=>$val){
            $where['pid'] = $val;
            $res[$key] = $this->_productObj->table('product_category')->fields('id,pid, name, unit, childname, attrs, risk_data')->where($where)->select();
            if(empty($res[$key])){
                unset($res[$key]);
                break;
            }
            if($val==0)
                $res[$key]['childname'] = '市场分类';
            else{
                $childName = $this->_productObj->table('product_category')->where(array('id'=>$val))->getField('childname');
                $res[$key]['childname'] = $childName ? $childName : '商品分类';
            }
        }

        return $res;


    }

    /**
     * 获取所有顶级分类
     */
    public function getTopCate($num=''){
        $memcache=new Memcache();
        $topCate=$memcache->get('topCate'.$num);
          if($topCate){
            return unserialize($topCate);
        }
        $where  = array('status' => 1, 'is_del' => 0,'pid'=>0);
        if($num)
            $this->_productObj->table('product_category')->limit($num);
        else{
            $this->_productObj->table('product_category');
        }
      //  $this->_productObj->limit=$num==''?500:$num;
        $category = $this->_productObj->fields('id,pid, name, unit, childname, attrs')->order('sort ASC,id DESC')->where($where)->select();
        $memcache->set('topCate'.$num,serialize($category));
        return $category;
    }

    /**
     * 获取某一个分类的顶级分类
     * @param $cate
     * @return mixed
     */
    public function getcateTop($cate){
        if(intval($cate)>0){
            $cate = intval($cate);
            $obj = new M('product_category');
            $pid = $obj->where(array('id'=>$cate))->getField('pid');
            while($pid!=0){
                $cate = $pid;
                $pid = $obj->where(array('id'=>$pid))->getField('pid');
            }
        }
        return $cate;
    }



    /**
     * 获取下级所有分类，以及下级所有第一个分类id,单位
     * @param array
     */
    private function getChildCate($cate,$level=1){
        if(empty($cate))return array();
        static $cateChild = array();
        static $cateFirst = array();
         static $step = 0;
        static $unit = '';
        $step1 = 0;
        foreach($cate as $k=>$v){

            if($step==0){//记录第一个分类序列
                $cateFirst[] = $k;
                $unit = $v['unit'];
            }

            if(isset($cate[$k]['child'])){
                $temp = $cate[$k]['child'];
                unset($cate[$k]['child']);
                $cateChild[$level]['show'][] = $cate[$k];//所有分类写入

                if($step1==0 ) {//只有第一个分类才遍历子分类
                    $this->getChildCate($temp,$level+1);
                }

            }
            else{
                $cateChild[$level]['show'][] = $cate[$k];//所有分类写入
            }

            $step1 +=1;
            $step += 1;
        }
        return array($cateChild,$cateFirst,$unit);
    }
    /**
     * 获取递归数组
     * @param array $items
     * @param int $pid 父类id
     * @return array
     */
    private  function generateTree(&$items,$pid=0,$unit=''){
         $tree = array();

        foreach($items as $key=>$item){
            if($item['pid']==$pid){
                $v = $items[$key];
                $v['unit'] = $items[$key]['unit'] =='' ? $unit : $items[$key]['unit'] ;
                if (!empty($item['risk_data'])) {
                    $v['risk_data'] = explode(',', $item['risk_data']);
                }
                
                $tree[$item['id']] = $v;
               // unset($items[$key]);
                $tree[$item['id']]['child'] = $this->generateTree($items,$item['id'],$v['unit']);

            }
        }

         return  $tree;
    }


    /**
     *获取所有分类的属性，去除重复
     * @param array $cates 分类数组,array(2,3)
     * @return mixed
     */
    public function getProductAttr($cates=array()){
        if(empty($cates))
            return array();
        $attrs = $this->_productObj->table('product_category')->fields('attrs')->where('id in ('.join(',',$cates).')')->select();

        $attr_arr = array();
        foreach($attrs as $v){
            if($v['attrs']!='')
                $attr_arr = array_merge($attr_arr,explode(',',$v['attrs']));
        }
        if(empty($attr_arr))
            return array();
        return $this->_productObj->table('product_attribute')->where('id in ('.join(',',$attr_arr).')')->select();
    }

    /**
     * 验证商品数据是否正确
     * @param array $productData 商品数据
     * @return bool
     */
    public function proValidate($productData){
        if($this->_productObj->validate($this->productRules,$productData)){
            return true;
        }

        return false;
    }

    /**
     * 获取商品详情
     * @param int $product_id 商品id
     *
     */
    public function getProductDetails($product_id){
        if(!$product_id)
            return array();
        $obj = new M('products');
        $obj->fields('name as product_name,  attribute, produce_area, create_time, quantity,freeze,sell,cate_id, unit, id as product_id, note');
        $obj->where(array('id'=>$product_id));
        $detail = $obj->getObj();

        $attr_ids = array();
        $detail['attribute'] = unserialize($detail['attribute']);
        if(!empty($detail['attribute'])){
            foreach ($detail['attribute'] as $key => $value) {
                $attr_ids[] = $key;
            }
        }

        //获取所属分类
        $detail['cate'] = $this->getParents($detail['cate_id']);
        foreach ($detail['cate'] as $key => $value) {
            $detail['cate_chain'] .= $value['name'].'/';    
        }
        //获取属性
        $attrs = $this->getHTMLProductAttr($attr_ids);
        $detail['attrs'] = '';
        if(!empty($detail['attribute'])) {
            foreach ($detail['attribute'] as $key => $value) {
                if(@isset($attrs[$key])){
                    $detail['attr_arr'][$attrs[$key]] = $value;
                    $detail['attrs'] .= $attrs[$key] . ' : ' . $value . ';';
                }

            }
        }
        $detail['attr_name'] = $attrs;
        //获取图片
        $photos = $this->getProductPhoto($product_id);
        $detail['photos'] = $photos[1];
        $detail['origphotos'] = $photos[0];
        $detail['imgData'] = $photos[2];
        return $detail;

    }

    /**
     * 获取报盘详情
     */
    public function offerDetail($id){
        $query = new Query('product_offer as o');
        $query->join = "left join products as p on o.product_id = p.id left join product_photos as pp on p.id = pp.products_id";
        $query->fields = "o.*,p.cate_id,p.name,pp.img,p.quantity,p.freeze,p.sell,p.unit, o.expire_time";

        $query->where = 'o.id = :id';
        $query->bind = array('id'=>$id);
        $res = $query->getObj();

        if(!empty($res)){
            $res['mode_text'] = $this->getMode($res['mode']);

            $res['img'] = empty($res['img']) ? 'no_picture.jpg' : \Library\thumb::get($res['img'],100,100);//获取缩略图
            $res['left'] = floatval($res['quantity']) - floatval($res['freeze']) - floatval($res['sell']);

            $res['divide_txt'] = $this->getDivide($res['divide']);
            if($res['divide']==self::UNDIVIDE)
                $res['minimum'] = $res['quantity'];
        }


        return $res ? $res : array();
    }
    /**
     * 获取产品的属性值，对应的属性id
     * @param  array  $attr_id [属性id]
     * @return [Array]   
     */
    public function getHTMLProductAttr($attr_id = array()){
        $attrs = array();
        if (!empty($attr_id)) {
            $attrObj = new M('product_attribute');
            $attr_id = $attrObj->fields('id, name')->where('id IN (' . implode(',', $attr_id) . ')')->select();
            foreach ($attr_id as $value) {
               $attrs[$value['id']] = $value['name']; 
            }
        }

        return $attrs;
    }

        /**
         * 根据产品id获取图片
         * @param  [type] $pid [description]
         * @return [type]      [description] 第一个原图，第二个缩略
         */
        public function getProductPhoto($pid = 0){
            $photos = array();
            $thumbs = array();
            $imgData = array();
            if (intval($pid) > 0) {
                $imgObj = new M('product_photos');
                $photos = $imgObj->fields('id, img')->where(array('products_id'=>$pid))->select();

                foreach ($photos as $key => $value) {
                    $thumbs[$key] = Thumb::get($value['img'],180,180);
                    $photos[$key] = Thumb::getOrigImg($value['img']);
                    $imgData[$key] = $value['img'];
                }

            }
            return array($photos,$thumbs,$imgData);
        }

        /**
         * 添加商品数据
         * @param  [Array] &$productData [提交的商品数据]
         * @param  [Array] &$productOffer[提交的报盘数据]
         * @return [Array]               [添加是否成功，及失败信息]
         */
        protected function insertOffer(&$productData, &$productOffer){
            if ($this->_productObj->validate($this->productRules,$productData) && $this->_productObj->validate($this->productOfferRules, $productOffer)){

                $pId = $this->_productObj->data($productData[0])->add();
                $productOffer['product_id'] = $pId;
                $productOffer['insurance'] = 0;
                $productOffer['status'] = self::OFFER_APPLY;
                $id =  $this->_productObj->table('product_offer')->data($productOffer)->add(1);

                if ($id > 0) {

                    $title =  $this->getMode($productOffer['mode'])  . '审核';
                    $content = $productData[0]['name'] . $this->getMode($productOffer['mode']) . '需要审核';

                    $adminMsg = new \nainai\AdminMsg();
                    $adminMsg->createMsg('checkoffer',$id,$content,$title);

                    if ($productOffer['mode'] == self::DEPOSIT_OFFER) {
                        $operate = 'free_offer';
                    }else{
                        $operate = 'offer';
                    }
                    $credit = new \nainai\CreditConfig();
                    $credit->changeUserCredit($productOffer['user_id'], $operate);

                    $log = array();
                    $log['action'] = $this->getMode($productOffer['mode']) ;
                    $log['content'] = '用户' . $productData[2] . '添加' . $this->getMode($productOffer['mode'])  . ':' .$productData[0]['name'];
                    $userLog = new \Library\userLog();
                    $userLog->addLog($log);
                };
                    $imgData = $productData[1];
                    if (!empty($imgData)) {
                        foreach ($imgData as $key => $imgUrl) {
                            $imgData[$key]['products_id'] = $pId;
                        }
                        $this->_productObj->table('product_photos')->data($imgData)->adds(1);
                    }
                return true;

            }else{
                 return $this->_productObj->getError();
            }

    }


    /**
     * 将小数格式化，去掉小数点后尾部的0
     * @param float $float 小数
     *
     */
    public static function floatForm($float){
        $float = strval($float);
        if(strpos($float,'.')===false){//如果是整数，直接返回
            return intval($float);
        }
        else{
            $n = strlen($float);
            $i=$n-1;
            while($i>0){
                if($float[$i]!='0')
                    break;
                $i = $i-1;
            }
            $float = substr($float,0,$i+1);
            return floatval($float);
        }
    }

    /**
     * 获取某一商品分类所有父级分类
     * @param int $cate_id 分类id
     * @return array
     */
    public function getParents($cate_id){
        if(!($cate_id && $cate_id>0)) return array();
        $m = new M('product_category');
        $res = array();
        while($cate_id!=0){
            $cate = $m->where(array('id'=>$cate_id))->fields('pid,id,name')->getObj();
            if (!empty($cate)) {
                array_unshift($res,array('id'=>$cate['id'],'name'=>$cate['name']));
                $cate_id = $cate['pid'];
            }else{
                $cate_id = 0;
            }
        }
        return $res;
    }



    /**
     * 获取某个分类名称
     * @param int $cate_id 分类id
     */
    public function getCateName($cate_id, $fields='name'){
        $m = new M('product_category');
        return $m->where(array('id'=>$cate_id))->getField($fields);

    }


    private function getNestedList($list, $pid = 0) {
        $arr = array();
        $tem = array();

        foreach ($list as $v) {
            if ($v['pid'] == $pid) {
                $tem = $this->getNestedList($list, $v['id']);
                //判断是否存在子数组
                $v['nested'] = $tem;
                $arr[] = $v;
            }
        }
        return $arr;
    }
    //获取分类列表
    public function   getAllCat() {
        $memcache=new Memcache();
        $res=$memcache->get('allCat');
        if($res){
            return unserialize($res);
        }
        $m_category = new M('product_category');
        //$m_category->where='status= :status';
        //$m_category->bind=array('status'=>1);
        $m_category->cache = 'm';
        $c_list = $m_category->where('is_del = 0 and status = 1')->order('sort ASC,id DESC')->select();
        $result = $this->getNestedList($c_list);
        $memcache->set('allCat',serialize($result));
        return $result;
    }

    //获取过期时间
    public function getExpireTime(){
        $days = $this->expire_days;
        return time::getDateTime('Y-m-d',time()+$days*24*3600);
    }


    public function update($data, $id, $pk='id'){
        $res = null;
        $this->_productObj->table('product_offer');
        if (intval($id) > 0)  {
            $res = $this->_productObj->data($data)->where($pk . '=:id')->bind(array('id'=>$id))->update();
        }else{
            $res = 'Error ID';
        }

        if(intval($res) > 0 ){
            return Tool::getSuccInfo();
         }
        else{
                return Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
         }
    }


    /**
     * 删除报盘
     * @param int $id 报盘id
     * @param int $user_id yonghu id
     */
    protected function delOffer($id,$user_id){
        if(intval($id)>0){
            $obj = new M('product_offer');
            $data = $obj->where(array('id'=>$id,'user_id'=>$user_id))->fields('product_id,status')->getObj();
            if(empty($data))
                return false;
            $product_id = $data['product_id'];
            if($data['status']!=self::OFFER_NG)
                return false;
            $obj->where(array('id'=>$id))->delete();
            $obj->table('products')->where(array('id'=>$product_id))->delete();
            $obj->table('product_photos')->where(array('products_id'=>$product_id))->delete();

        }
        return true;



    }



}
