<?php
/**
 * 仓库管理类
 * author: weiping
 * Date: 2016/4/21
 * Time: 8:18
 */
namespace nainai;
use \Library\M;
use \Library\Query;
use \nainai\offer\product;
use \Library\Tool;

class store{

     protected $storeProduct = 'store_products';//仓单数据表
    //仓单数据规则
     protected $storeProductRules = array(
        array('store_id', 'number', '必须选择仓库!'),
        array('product_id', 'number', '请填写产品信息'),
        array('package', 'number','请选择是否打包!')
    );

    //仓单状态
    //const USER_APPLY          = 10;//卖方申请
    const USER_AGREE          = 11;//卖方确认
    const USER_REJECT         = 12;//卖方确认不通过
   // const STOREMANAGER_AGREE  = 21;//仓库管理员审核通过
  //  const STOREMANAGER_REJECT = 22;
    const STOREMANAGER_SIGN   = 23;

    const MARKET_AGREE        = 31;//市场通过
    const MARKET_REJECT       = 32;//市场拒绝
    const MARKET_AGAIN = 55;
    const DELETE = 4; //删除记录


     /**
      * 获取仓单的状态
      * @return [Array] 
      */
    public function getStatus(){
        return array(
            //self::USER_APPLY => '未审核',
           // self::STOREMANAGER_AGREE => '仓库管理员审核通过',
           // self::STOREMANAGER_REJECT => '仓库管理员审核不通过',
            self::STOREMANAGER_SIGN   => '仓库管理员签发仓单',
            self::USER_AGREE => '卖方确认',
            self::USER_REJECT => '卖方拒绝',
            self::MARKET_AGREE => '后台审核通过',
            self::MARKET_REJECT => '后台审核驳回',
            self::MARKET_AGAIN => '后台重新审核'
        );
    }

    /**
     * 获取仓租费用时间单位
     * @param string $u
     * @return array|string
     */
    public static  function getTimeUnit($u=''){
        $unit = array(
            'y'=>'年',
            'm' => '月',
            'd' => '日'
        );
        if($u && isset($unit[$u])){
            return $unit[$u];
        }

        return '日';



    }


    /**
     * 获取仓单状态
     */
    public function getStatusText($status){
        $array = $this->getStatus();
        if(isset($array[$status]))
            return $array[$status];
        return '未知';
    }

    /**
     * 获取仓单详情
     * @param  [Int] $id [仓单id]
     * @param int $user_id 仓库管理员id
     * @return [Array]
     */
    public function getManagerStoreDetail($id,$user_id){
        $store_id = $this->getManagerStoreId($user_id);//根据$user_id获取
        $query = new Query('store_products as a');
        $query->fields = 'a.id as sid,a.user_id,a.cang_pos,a.sign_time,a.user_time,a.market_time,a.store_unit,a.check_org,a.check_no,a.confirm,a.product_id,a.status,a.package,a.package_unit,a.package_num,a.package_weight, b.name as pname, c.name as cname, b.attribute, b.produce_area, b.create_time, b.quantity, b.unit, b.id as pid,  d.name as sname, b.note, a.store_pos, a.in_time, a.rent_time, a.quality, a.store_price,a.package_units,a.msg,a.admin_msg';
        $query->join = ' LEFT JOIN products as b ON a.product_id = b.id LEFT JOIN product_category  as c  ON b.cate_id=c.id LEFT JOIN store_list as d ON a.store_id=d.id';
        $query->where = ' a.id=:id AND a.store_id=:store_id';
        $query->bind = array('id' => $id,'store_id'=>$store_id);
        $data = $query->getObj();
        if(empty($data)){
            return false;
        }

        $data['status_txt'] = $this->getStatusText($data['status']);
        $data['confirm_thumb'] = \Library\thumb::get($data['confirm'],180,180);
        $data['confirm_orig'] = \Library\thumb::getOrigImg($data['confirm']);
        $data['quality_thumb'] = \Library\thumb::get($data['quality'],180,180);
        $data['quality_orig'] = \Library\thumb::getOrigImg($data['quality']);
        $productModel = new product();

        $product = $productModel->getProductDetails($data['product_id']);
        $product['quantity'] = $productModel->floatForm($product['quantity']);
        $detail = array_merge($data,$product);
        return $detail;
    }
     /**
     * 获取仓库列表
     * @return mixed
     */
    public static function getStoretList(){
        $storeModel = new M('store_list');
        $where  = array('status' => 1,'is_del'=>0);
        return $storeModel->table('store_list')->fields('id, name, short_name, area, address')->where($where)->select();
    }

    /**
     * 获取用户管理的仓库id
     * @param $user_id
     */
    public function getManagerStoreId($user_id){
        $m = new \nainai\cert\certStore();
        return  $m->getUserStore($user_id);

    }
   
 /**
     * 获取仓库管理员所属的仓单列表，仓库管理员页码
     * @param  [Int] $page     页码
     * @param int $user_id 管理员id
     * @return [Array]       ]
     */
    public function getManagerStoreList($page, $user_id=0){
         //仓单列表
        $store_id = $this->getManagerStoreId($user_id);//此处获取仓库管理员管理的仓库id
        $condition = array();
        $condition['where'] = 'a.store_id = :store_id ';
        $condition['bind'] = array('store_id'=>$store_id);

        return $this->getStoreProductList($page,$condition);
    }

    /**
     * 获取管理员所属申请仓单列表
     * @param $page
     * @param $user_id
     * @return array
     */
    public function getManagerApplyStoreList($page,$user_id){
        $store_id = $this->getManagerStoreId($user_id);//此处获取仓库管理员管理的仓库id
        $condition = array();
        $condition['where'] = 'a.store_id = :store_id AND a.status = :status';
        $condition['bind'] = array('store_id'=>$store_id,'status'=>self::USER_APPLY);

        return $this->getStoreProductList($page,$condition);
    }

    /**
     * 获取仓单列表
     * @param int $page 页码
     * @param array $condition 条件
     */
    protected function getStoreProductList($page,$condition=array(),$pagesize=10){
        $query = new \Library\searchQuery('store_products as a');
        $query->fields = 'a.id,a.user_id,b.name as sname, a.status, c.name as pname,c.quantity,d.name as cname, c.attribute,c.unit, a.package_unit, a.package_weight';
        $query->join = ' LEFT JOIN store_list as b ON a.store_id=b.id LEFT JOIN products as c ON a.product_id = c.id   LEFT JOIN product_category as d  ON c.cate_id=d.id';
        $query->page = $page;
        $query->pagesize = 10;
        if(!empty($condition)){
            $query->where = $condition['where'];
            $query->bind  = isset($condition['bind']) ? $condition['bind'] : array();
        }

        $storeList = $query->find(self::getStatus());

        $attrs = $attr_id = array();
        foreach ($storeList['list'] as $key => $value) {

            $attrs = unserialize($value['attribute']);
            $storeList['list'][$key]['attribute'] = $attrs;
            if(!empty($attrs)){
                foreach ($attrs as $aid => $name) {
                    if (!in_array($aid, $attr_id)) {
                        $attr_id[] = $aid;
                    }
                }
            }

        }
        $obj = new product();
        $storeList['attrs'] =  $obj->getHTMLProductAttr($attr_id);
        return $storeList;
    }

    /**
     * 获取仓单id 的状态
     * @param $id 仓单id
     */
    public function getStoreProductStatus($id){
        $st = new M($this->storeProduct);
        return $st->where(array('id'=>$id))->getField('status');

    }
    /**
     * 仓库管理员审核仓单
     * @param array $store array('status'=>,'info'),status 为0拒绝，1通过
     * @param $id 仓单id
     * @param $user_id 管理员id
     */
    public function storeManagerCheck(& $store, $id,$user_id){
        if($this->getStoreProductStatus($id)==self::USER_APPLY){//处于申请状态可审核
            $store_id = $this->getManagerStoreId($user_id);
            $store['status'] = intval($store['status'])==1 ? self::STOREMANAGER_AGREE : self::STOREMANAGER_REJECT;
            $store['manager_time'] = \Library\Time::getDateTime();
            $res =  $this->UpdateApplyStore( $store, array('id'=>$id,'store_id'=>$store_id));
            if($res===true){
                return tool::getSuccInfo();
            }
            else{
                return tool::getSuccInfo(0,$res);
            }
        }
        return tool::getSuccInfo(0,'操作错误');

    }


    /**
     * 仓单签发
     * @param array $store array('status'=>,'info'),status 为0拒绝，1通过
     * @param array $productData 商品数据
     * @param $id
     * @param $user_id 管理员id
     */
    public function storeManagerSign(& $store,$productData, $id,$user_id){
        if($this->getStoreProductStatus($id)==self::STOREMANAGER_AGREE) {//处于仓管审核已审核可签发
            $store_id = $this->getManagerStoreId($user_id);
            $store['status'] = self::STOREMANAGER_SIGN;
            
            $pObj = new M('store_products');
            $spData = $pObj->where(array('id'=>$id))->getObj();

            if(!empty($spData) && $spData['store_id']==$store_id){//存在仓单数据且该仓库属于当前用户
                $product = new product();
                if($product->proValidate($productData)){
                    $store['sign_time'] = \Library\Time::getDateTime();
                    $pObj->beginTrans();
                    $upRes = $this->UpdateApplyStore($store, array('id'=>$id,'store_id'=>$store_id));
                    if($upRes===true && !empty($productData)){
                        $pObj->table('products')->data($productData)->where(array('id'=>$spData['product_id']))->update();
                    }
                    if(true === $pObj->commit()){
                        return tool::getSuccInfo();
                    }
                    else{
                        return tool::getSuccInfo(0,'网络错误');
                    }

                }
                else{
                    return tool::getSuccInfo(0,'操作错误');
                }
            }


        }
        return tool::getSuccInfo(0,'操作错误');
    }

    /**
     * 用户确认仓单
     * @param int $status 确认状态
     * @param int $id 仓单id
     * @param int $user_id 用户id
     */
    public function userCheck($status,$id,$user_id, $msg, $username){
        if($this->getStoreProductStatus($id)==self::STOREMANAGER_SIGN) {
            $store = array();
            $store['status'] = intval($status) == 1 ? self::USER_AGREE : self::USER_REJECT;
            $store['user_time'] = \Library\Time::getDateTime();
            $store['msg'] = $msg;
            $res = $this->UpdateApplyStore($store, array('id'=>$id,'user_id'=>$user_id));

            $info = $this->getUserStoreDetail($id, $user_id);
            $title =    '仓单签发审核';
            $content = '仓单签发' . $productData[0]['name'] . '需要审核';

            $adminMsg = new \nainai\AdminMsg();
            $adminMsg->createMsg('checkoffer',$id,$content,$title);
            $param = array('type' => 'check');
            $param['status'] = $store['status'];
            $param['user_id'] = $info['sign_user'];
            $param['name'] = $info['product_name'];
            $obj = new \nainai\message($param['user_id']);
            $re = $obj->send('store', $param);
            $log = array();
            $log['action'] = '用户确认仓单';
            $log['content'] = '用户' . $username . ',修改仓单' . $id . '状态为:' . $this->getStatusText($store['status']);
            $userLog = new \Library\userLog();
            $userLog->addLog($log);
            if($res===true){
                return tool::getSuccInfo();
            }
            else{
                return tool::getSuccInfo(0,$res);
            }
        }
        return tool::getSuccInfo(0,'操作错误');
    }


    /**
     * 更改仓单状态,各方审核调用
     * @param [Array] $store [审核的仓单数据]
     * @param [array] $where    [搜索条件]
     */
    protected function UpdateApplyStore( & $store, $where){
         $storeProductObj = new M($this->storeProduct);
        $storeProductObj->data($store);
        if($storeProductObj->validate($this->storeProductRules)){
           $res =  $storeProductObj->where($where)->update();
            if(is_int($res) && $res>0)
                return true;
            else return '操作错误';
        }
        else{
            return $storeProductObj->getError();
        }
    }

    /**
     * [获取用户的仓单列表, 并且没有添加报盘]
     * @param int $page 页码
     * @param  [Int] $uid [用户id]
     * @return [Array]
     */
    public function getUserStoreList($page,$uid){
        $condition = array();
        $condition['where'] = 'a.user_id=:user_id ';
        $condition['bind'] = array('user_id'=>$uid);

        return $this->getStoreProductList($page,$condition);

    }

    /**
     * 获取可用的仓单
     * @param $uid 用户id
     */
    public function getUserActiveStore($uid){
        $condition = array();
        $condition['where'] = 'a.user_id=:user_id AND a.status=:status AND is_offer = :is_offer';
        $condition['bind'] = array('user_id'=>$uid,'status'=>self::MARKET_AGREE,'is_offer'=>0);

        return $this->getStoreProductList(1,$condition,500);
    }
    /**
     * 获取对应的仓单详情
     * @param  [Int] $id [仓单id]
     * @param int $user_id 用户id
     * @return [Array]
     */
    public function getUserStoreDetail($id,$user_id=0){
        $query = new Query('store_products as a');
        $query->fields = 'a.*, d.name as store_name';
        $query->join = '  LEFT JOIN store_list as d ON a.store_id=d.id';

        if($user_id){
            $query->where = ' a.id=:id AND a.user_id=:user_id';
            $query->bind = array('id' => $id,'user_id'=>$user_id);
        }
        else{
            $query->where = ' a.id=:id ';
            $query->bind = array('id' => $id);
        }
        $detail =  $query->getObj();//仓单详情，不包括商品
         if(empty($detail)){
            return false;
        }

        $detail['status_txt'] = $this->getStatusText($detail['status']);
        $detail['confirm_thumb'] = \Library\thumb::get($detail['confirm'],180,180);
        $detail['confirm_orig'] = \Library\thumb::getOrigImg($detail['confirm']);
        $detail['quality_thumb'] = \Library\thumb::get($detail['quality'],180,180);
        $detail['quality_orig'] = \Library\thumb::getOrigImg($detail['quality']);
        //获取商品信息
        $productModel = new product();

        $product = $productModel->getProductDetails($detail['product_id']);
        $product['quantity'] = $productModel->floatForm($product['quantity']);
        $detail = array_merge($detail,$product);
        return $detail;
    }

    /**
     * 判断仓单是否为这个用户的
     * @param  [Int] $id      [仓单Id]
     * @param  [Int] $user_id [用户id]
     * @return [Boolean] 
     */
    public function judgeIsUserStore($id, $user_id){
        if (intval($id) > 0 && intval($user_id) > 0) {
            $storeObj = new M($this->storeProduct);
            $where = array('id'=>$id,'user_id'=>$user_id,'status'=>self::MARKET_AGREE,'is_offer'=>0);//is_offer是否报盘
            $data = $storeObj->fields('id')->where($where)->getObj();

            if (!empty($data)) {
                return true;
            }
        }
        return false;
    }

     /**
     * 生成仓单
     * @param array $productData 商品数据
     * @param array $storeData 仓库数据
     */
    public function createStoreProduct($productData,$storeData,$user_id){
        $productObj = new product();
        $storeData['store_id'] = $this->getManagerStoreId($user_id);
        if(!$storeData['store_id'])
            return tool::getSuccInfo(0,'无此权限');
        $storeProductObj = new M($this->storeProduct);
        //验证商品数据和仓单数据
        if($productObj->proValidate($productData) && $storeProductObj->validate($this->storeProductRules,$storeData)){
            $storeProductObj->beginTrans();
            $pId = $storeProductObj->table('products')->data($productData[0])->add(1);
            $imgData = $productData[1];
            if (intval($pId) > 0) {
                //插入图片数据
                if (!empty($imgData)) {
                    foreach ($imgData as $key => $imgUrl) {
                        $imgData[$key]['products_id'] = $pId;
                    }
                    $storeProductObj->table('product_photos')->data($imgData)->adds(1);

                }
                //插入仓单数据
                $storeData['product_id'] = $pId;
                $storeData['status'] = self::STOREMANAGER_SIGN;
                $id = $storeProductObj->table($this->storeProduct)->data($storeData)->add(1);
                if ($id > 0) {
                            

                            $param['name'] = $productData[0]['name'];
                            $obj = new \nainai\message($storeData['user_id']);
                            $obj->send('store', $param);
                }
            }
            $res = $storeProductObj->commit();
        }
        else{
            $res = $productObj->getErrorMessage();
            $res = $storeProductObj->getError();
        }
        if($res===true){
            $resInfo = Tool::getSuccInfo(1, 'success','',$id);
        }
        else{
            $resInfo = Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
        }
        return $resInfo;


    }

    public function updateStoreProduct($productData,$storeData, $product_id, $id){
        $productObj = new product();
         $storeProductObj = new M($this->storeProduct);
        //验证商品数据和仓单数据
        if($productObj->proValidate($productData) && $storeProductObj->validate($this->storeProductRules,$storeData)){
            $storeProductObj->beginTrans();
            $storeProductObj->table('products')->where('id=:id')->bind(array('id' => $product_id))->data($productData[0])->update(1);
            $imgData = $productData[1];
            if (intval($product_id) > 0) {
                //插入图片数据
                if (!empty($imgData)) {
                    foreach ($imgData as $key => $imgUrl) {
                        $imgData[$key]['products_id'] = $product_id;
                    }
                    $storeProductObj->table('product_photos')->where(array('products_id'=>$product_id))->delete();
                    $storeProductObj->table('product_photos')->data($imgData)->adds(1);

                }
                $storeProductObj->table($this->storeProduct)->where('id=:id')->bind(array('id' => $id))->data($storeData)->update(1);
            }
            $res = $storeProductObj->commit();
        }
        else{
            $res = $productObj->getErrorMessage();
            $res = $storeProductObj->getError();
        }
        if($res===true){
            $resInfo = Tool::getSuccInfo(1, 'success');
        }
        else{
            $resInfo = Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
        }
        return $resInfo;
    }


}

