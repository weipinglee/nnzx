<?php

use \Library\checkRight;
use \Library\PlUpload;
use \Library\photoupload;
use \Library\json;
use \Library\url;
use \Library\safe;
use \Library\Thumb;
use \Library\tool;
use \nainai\store;
use \nainai\offer\product;
use \nainai\offer\freeOffer;
use \nainai\offer\depositOffer;
use \nainai\offer\deputeOffer;
/**
 * 交易管理的控制器类
 */
class ManagerDealController extends UcenterBaseController {
    /**
     * 设置分类多少以后有展开
     * @var integer
     */
    private $_limiteProduct = 2;


    /**
     * 设置产品过期的天数
     * @var integer
     */
    private $_expireDay = 5;

    /**
     * 提示mode对应的类型
     * @var array
     */
    private $_mode = array(
        1 => '自由报盘',
        2 => '保证金报盘',
        3 => '委托报盘',
        4 => '仓单报盘'
    );


    protected  $certType = 'deal';//需要的认证类型

    //买家不能操作的方法
    protected $sellerAction = array('productlist','indexoffer','freeOffer','dofreeoffer','depositoffer','dodepositoffer',
        'deputeoffer','dodeputeoffer','storeoffer','dostoreoffer');

    /**
     * 个人中心首页
     */
    public function indexAction(){

    }

    /**
     * 产品发布页面展示
     * @return
     */
    public function indexOfferAction(){
        $certObj=new \nainai\cert\certificate();
        if ($this->pid == 0) {
            $certStatus=$certObj->getCertStatus($this->user_id,'deal');
        }else{
             $certStatus=$certObj->getCertStatus($this->pid,'deal');
        }
       

        $this->getView()->assign('certStatus',$certStatus);
    }

    public function addSuccessAction(){

    }

   /**
     * 商品添加页面展示
     */
    private function productAddAction($mode = ''){
        //获取商品分类信息，默认取第一个分类信息
        $productModel = new product();
        $category = $productModel->getCategoryLevel();

        //获取保险
        $key = count($category['cate']);
        $risk = new \nainai\insurance\Risk();
         $risk_data = array();
        //获取默认的分类设置的保险， 如果最下级默认没有保险，用父级的。
        do{
            $risk_data = $category['cate'][$key]['show'][0]['risk_data'];
            $risks = array();
            if (!empty($risk_data)) {
                $risks = $risk->getRiskDetail($risk_data);
                break;
            }
            $key --;
        }while($key > 0);
        if ($mode == 'deputeoffer') {
            $Obj = new \nainai\system\EntrustSetting();
            $rate = $Obj->getRate($category['defaultCate']);
            $this->getView()->assign('rate',$rate);
        }
        //注意，js要放到html的最后面，否则会无效
        $this->getView()->assign('categorys', $category['cate']);
        $this->getView()->assign('risk_data', $risks);
        $this->getView()->assign('cate_id', $category['defaultCate']);
    }

    //检查报盘规则
    protected function offerCheck(){
        $divide = Safe::filterPost('divide');
        $minimum = Safe::filterPost('minimum','float',0);
        $quantity = Safe::filterPost('quantity','float');
        if($divide == 1){
            if(!$minimum) return json::encode(tool::getSuccInfo(0,'未填写最小起订量'));
            if(bccomp($quantity, $minimum) == -1) return json::encode(tool::getSuccInfo(0,'最小起订量需小于商品数量'));
        }
        return true;
    }

    /**
     * 自由报盘申请页面
     *
     */
    public function freeOfferAction(){
        $freeObj = new freeOffer();
        $freeFee = $freeObj->getFee($this->user_id);

        $fund  = new \nainai\fund\agentAccount();
        if ($fund->getActive($this->user_id) < $freeFee) {
            $this->redirect(url::createUrl('/fund/cz'));
        }

        $user = new \nainai\user\User();
        $pay = $user->getUser(array('id' => $this->user_id), 'pay_secret');
        if (empty($pay['pay_secret'])) {
            $this->error('请先设置支付密码', url::createUrl('/ucenter/paysecret'));
        }

        $token =  \Library\safe::createToken();
        $this->getView()->assign('token',$token);
        $offer = array('divide' => 1);
        $this->getView()->assign('offer',$offer);
        $this->getView()->assign('fee',$freeFee);
        $this->productAddAction();
    }


    /**
     * 自由报盘提交处理
     *
     */
    public function doFreeOfferAction(){
        if(IS_POST){
            $token = safe::filterPost('token');
            if(!safe::checkToken($token))
                 die(json::encode(tool::getSuccInfo(0,'请勿重复提交'))) ;
            $res = $this->offerCheck();
            if($res !== true) die($res);
            $offer_id = safe::filterPost('offer_id','int',0);
            $offerObj = new freeOffer($this->user_id);

            $offerData = array(
                'apply_time'  => \Library\Time::getDateTime(),
                'divide'      => Safe::filterPost('divide', 'int'),
                'minimum'     => (safe::filterPost('divide', 'int') == 1) ? Safe::filterPost('minimum', 'float') : 0,
                'minstep'     => (safe::filterPost('divide', 'int') == 1) ? safe::filterPost('minstep', 'float') : 0,
                
                 'weight_type' => Safe::filterPost('weight_type'),
                'accept_area' => Safe::filterPost('accept_area'),
                'accept_day' => Safe::filterPost('accept_day', 'int'),
                'price'        => Safe::filterPost('price', 'float'),
                'acc_type'   => 1,//现在写死了，就是代理账户
                 'insurance' => Safe::filterPost('insurance', 'int'),
               'risk' =>implode(',', Safe::filterPost('risk', 'int')),
               'expire_time' =>  Safe::filterPost('expire_time'),
               'other' => Safe::filterPost('other'),
            );



            if(!$offerData['risk']){
                $offerData['risk'] = '';
            }


            $productData = $this->getProductData();
            if(isset($productData[0]['quantity']) && $offerData['minimum'] > $productData[0]['quantity']){
                $offerData['minimum'] = $productData[0]['quantity'];
            }
            $res = $offerObj->doOffer($productData,$offerData,$offer_id);
            
            echo json::encode($res);
            exit;
        }
        return false;

    }

    /**
     * 保证金报盘申请页面
     *
     */
    public function depositOfferAction(){
        $token =  \Library\safe::createToken();
        $this->getView()->assign('token',$token);

        $depositObj = new \nainai\offer\depositOffer();

        $rate = $depositObj->getDepositRate($this->user_id);
        $offer = array('divide' => 1);
        $this->getView()->assign('rate',$rate);
        $this->getView()->assign('offer',$offer);
        $this->productAddAction();
    }

    /**
     * 保证金报盘提交处理
     *
     */
    public function doDepositOfferAction(){
        if(IS_POST){
            $token = safe::filterPost('token');
            if(!safe::checkToken($token))
                 // die(json::encode(tool::getSuccInfo(0,'请勿重复提交'))) ;
            $offer_id = safe::filterPost('offer_id','int',0);
            $depositObj = new depositOffer($this->user_id);
            $res = $this->offerCheck();
            if($res !== true) die($res);
            $offerData = array(
                'apply_time'  => \Library\Time::getDateTime(),
                'divide'      => safe::filterPost('divide', 'int'),
                'minimum'     => (safe::filterPost('divide', 'int') == 1) ? safe::filterPost('minimum', 'float') : 0,
                'minstep'     => (safe::filterPost('divide', 'int') == 1) ? safe::filterPost('minstep', 'float') : 0,

                'accept_area' => safe::filterPost('accept_area'),
                'accept_day' => safe::filterPost('accept_day', 'int'),
                'price'        => safe::filterPost('price', 'float'),
                 'insurance' => Safe::filterPost('insurance', 'int',''),
                 'weight_type' => Safe::filterPost('weight_type'),

                'risk' =>implode(',', Safe::filterPost('risk', 'int')),
                'expire_time' =>  Safe::filterPost('expire_time'),
               'other' => Safe::filterPost('other'),
               // 'acc_type'   => 1,
            );
            if(!$offerData['risk']){
                $offerData['risk'] = '';
            }
            $productData = $this->getProductData();

            if(isset($productData[0]['quantity']) && $offerData['minimum'] > $productData[0]['quantity']){
                $offerData['minimum'] = $productData[0]['quantity'];
            }

            $res = $depositObj->doOffer($productData,$offerData,$offer_id);
            
            echo json::encode($res);
            exit;
        }
        else
        echo \Library\json::encode(tool::getSuccInfo(0,'操作失败'));
        exit;

    }



    /**
     * 委托报盘申请页面
     *
     */
    public function deputeOfferAction(){
        $token =  \Library\safe::createToken();
        $this->getView()->assign('token',$token);
        $member = new \nainai\member();
        $this->getView()->assign('is_vip',$member->is_vip($this->user_id));
        $offer = array('divide' => 1);
        $this->getView()->assign('offer',$offer);
        $this->productAddAction('deputeoffer');
    }

    /**
     * 保证金报盘提交处理
     *
     */
    public function doDeputeOfferAction(){
        if(IS_POST){
            $token = safe::filterPost('token');
            if(!safe::checkToken($token))
                 die(json::encode(tool::getSuccInfo(0,'请勿重复提交'))) ;
            $res = $this->offerCheck();
            if($res !== true) die($res);
            $offerData = array(
                'apply_time'  => \Library\Time::getDateTime(),
                'divide'      => Safe::filterPost('divide', 'int'),
                'minimum'     => (safe::filterPost('divide', 'int') == 1) ? Safe::filterPost('minimum', 'float') : 0,
                'minstep'     => (safe::filterPost('divide', 'int') == 1) ? safe::filterPost('minstep', 'float') : 0,
                
                 'weight_type' => Safe::filterPost('weight_type'),
                'accept_area' => Safe::filterPost('accept_area'),
                'accept_day' => Safe::filterPost('accept_day', 'int'),
                'price'        => Safe::filterPost('price', 'float'),
                'sign'        => Tool::setImgApp(Safe::filterPost('imgfile1')),//委托书照片
                'insurance' => Safe::filterPost('insurance', 'int'),
               'risk' =>implode(',', Safe::filterPost('risk', 'int')),
               'expire_time' =>  Safe::filterPost('expire_time'),
               'other' => Safe::filterPost('other'),
                // 'acc_type'   => 1,
            );

            if(!$offerData['risk']){
                $offerData['risk'] = '';
            }
            $deputeObj = new deputeOffer($this->user_id);
            $productData = $this->getProductData();
            if(isset($productData[0]['quantity']) && $offerData['minimum'] > $productData[0]['quantity']){
                $offerData['minimum'] = $productData[0]['quantity'];
            }
            $res = $deputeObj->doOffer($productData,$offerData);

            echo json::encode($res);
            exit;
        }
        return false;

    }

    /**
     * 仓单报盘
     * @return 
     */
    public function storeOfferAction(){
        $token =  \Library\safe::createToken();
        $this->getView()->assign('token',$token);
        $storeModel = new \nainai\store();

        $storeList = $storeModel->getUserActiveStore($this->user_id);

        $this->getView()->assign('storeList', $storeList['list']);
    }


    /**
     * Ajax获取仓单报盘页面的商品详情
     * @return 
     */
    public function ajaxGetStoreAction(){
        $return_json = array();
        $pid = Safe::filterPost('pid', 'int');
        if (intval($pid) > 0) {
            $storeModel = new \nainai\store();
            $return_json = $storeModel->getUserStoreDetail($pid,$this->user_id);
            //获取保险产品信息
            $risk = new \nainai\insurance\Risk();
            $return_json['risk_data'] = $risk->getCategoryRisk($return_json['cate']);
        }
        echo JSON::encode($return_json);
        return false;
    }

        /**
         * AJax获取产品分类信息
         * @return [Json]
         */
        public function ajaxGetCategoryAction(){
            $pid = Safe::filterPost('pid', 'int',0);
            if($pid){
                $productModel = new product();
                $cate = $productModel->getCategoryLevel($pid);

                $cate['attr'] = $productModel->getProductAttr($cate['chain']);
                 $risk_data = array();
                //获取保险产品信息
                $risk = new \nainai\insurance\Risk();
                $list = $risk->getRiskList(-1, array('status' => 1));

                //获取子类的保险配置
                 if (!empty($cate['cate'])) {
                            $key  = count($cate['cate']);
                            do{
                                $risk_data = $cate['cate'][$key]['show'][0]['risk_data'];
                                if (!empty($risk_data)) {
                                    break;
                                }
                            $key --;
                        }while($key > 0);
                 }

                //当前分类没有配置保险，获取父类的保险配置
                if (empty($risk_data)) {
                    $cates = $productModel->getParents($pid);
                    foreach ($cates as $key => $value) {
                        $risk_data = $productModel->getCateName($value['id'], 'risk_data');
                        if (!empty($risk_data)) { //如果上一级分类有保险配置，就用这个配置
                            $risk_data = explode(',', $risk_data);
                            break;
                        }
                    }
                }
                 //获取分类设置的保险
                if (!empty($risk_data)) {
                    $risks = array();
                    $risks = $risk->getRiskDetail($risk_data);
                }
                $mode = safe::filterPost('mode');
                if ($mode == 'weitou') {
                            $Obj = new \nainai\system\EntrustSetting();
                            $cate['rate'] = $Obj->getRate($pid);
                }
                $cate['risk_data'] = $risks;
                unset($cate['chain']);
                echo JSON::encode($cate);
            }
            return false;
        }



    /**
     * 获取POST提交上来的商品数据,报盘处理和申请仓单处理都会用到
     * @return array 商品数据数组
     */
    private function getProductData(){
        $attrs = Safe::filterPost('attribute');
        foreach($attrs as $k=>$v){
            if(!is_numeric($k)){
                echo JSON::encode(tool::getSuccInfo(0,'属性错误'));
                exit;
            }
        }
        $time = date('Y-m-d H:i:s', time());

        $detail = array(
            'name'         => Safe::filterPost('warename'),
            'cate_id'      => Safe::filterPost('cate_id', 'int'),
            'quantity'     => Safe::filterPost('quantity', 'float'),
            'attribute'    => empty($attrs) ? '' : serialize($attrs),
            'note'         => Safe::filterPost('note'),
            'produce_area' => Safe::filterPost('area'),
            'create_time'  => $time,
            'unit'         => Safe::filterPost('unit'),
            'user_id' => $this->user_id
        );
        //图片数据
        $imgData = Safe::filterPost('imgData');

        $resImg = array();
        if(!empty($imgData)){
            foreach ($imgData as $imgUrl) {
                if (!empty($imgUrl) && is_string($imgUrl)) {
                    if(!isset($detail['img']) || $detail['img']=='')
                         $detail['img'] = tool::setImgApp($imgUrl);
                    array_push($resImg, array('img' => tool::setImgApp($imgUrl)));
                }
            }
        }

        return array($detail,$resImg, $this->username);
    }

    /**
     * 处理仓单报盘
     * @return
     */
    public function doStoreOfferAction(){
        if (IS_POST) {
            $token = safe::filterPost('token');
            if(!safe::checkToken($token))
                die(json::encode(tool::getSuccInfo(0,'请勿重复提交'))) ;
            
            $id = Safe::filterPost('storeproduct', 'int', 0);//仓单id

            $storeObj = new \nainai\store();
            $res = $this->offerCheck();
            if($res !== true) die($res);
            if ($storeObj->judgeIsUserStore($id, $this->user_id)) { //判断是否为用户的仓单
                // 报盘数据
                $offerData = array(
                    'apply_time'  => \Library\Time::getDateTime(),
                    'divide'      => Safe::filterPost('divide', 'int'),
                    'minimum'     => ($this->getRequest()->getPost('divide') == 1) ? Safe::filterPost('minimum', 'float') : 0,
                    'minstep'     => (safe::filterPost('divide', 'int') == 1) ? safe::filterPost('minstep', 'float') : 0,
                    'status'      => 0,
                    'accept_area' => Safe::filterPost('accept_area'),
                    'accept_day' => Safe::filterPost('accept_day', 'int'),
                    'price'        => Safe::filterPost('price', 'float'),
                    'user_id'     => $this->user_id,
                    'insurance' => Safe::filterPost('insurance', 'int', 0),
                    'risk' =>implode(',', Safe::filterPost('risk', 'int')),
                   'expire_time' =>  Safe::filterPost('expire_time'),
                   'other' => Safe::filterPost('other'),
                   'weight_type' => Safe::filterPost('weight_type'),
                );
                if(!$offerData['risk']){
                    $offerData['risk'] = '';
                }
                $offerObj = new \nainai\offer\storeOffer($this->user_id);
                $offerData['product_id'] = Safe::filterPost('product_id', 'int');


                $res = $offerObj->insertStoreOffer($id,$offerData, $this->username);
                if($res['success']==1){
                    $title = '仓单报盘审核';
                    $content = '仓单号为'.$id.'的报盘需要审核';

                    $adminMsg = new \nainai\AdminMsg();
                    $adminMsg->createMsg('checkoffer',$res['id'],$content,$title);
                }

                die(json::encode($res)) ;
            }
            die(json::encode(tool::getSuccInfo(0,'仓单不存在'))) ;
        }

        $this->redirect('indexoffer');
    }


    /**
     * 申请仓单处理
     */
    public function doStoreProductAction(){

        if(IS_POST){
            $token = safe::filterPost('token');
            if(!safe::checkToken($token))
                die(json::encode(tool::getSuccInfo(0,'请勿重复提交'))) ;
            $productData = $this->getProductData();//获取商品数据
            $storeList = array(
                'store_id' => Safe::filterPost('store_id', 'int'),
                'package'  => Safe::filterPost('package','int'),
                'package_num' => Safe::filterPost('packNumber'),
                'package_unit' => Safe::filterPost('packUnit'),
                'package_weight' => Safe::filterPost('packWeight'),
                'apply_time'  => \Library\Time::getDateTime(),
                'user_id' => $this->user_id,
                'store_pos' => safe::filterPost('pos'),
                'cang_pos'  => safe::filterPost('cang'),
                'store_price'=> safe::filterPost('store_price'),
                'in_time' => safe::filterPost('inTime'),
                'rent_time' => safe::filterPost('rentTime'),
                'check_org' => safe::filterPost('check'),
                'check_no'  => safe::filterPost('check_no'),
                'confirm'   => \Library\tool::setImgApp(safe::filterPost('imgfile1'))
            );
            $storeObj = new store();
            $res = $storeObj->createStoreProduct($productData,$storeList);
            echo json::encode($res);

        }
        return false;
    }

    /**
     * 仓单列表
     */
    public function storeProductListAction(){
        $page = Safe::filterGet('page', 'int', 0);
        $store = new store();

        $data = $store->getUserStoreList($page,$this->user_id);

        $this->getView()->assign('statuList', $store->getStatus());
        $this->getView()->assign('data', $data);

    }

    /**
     * 仓单详情
     * @return bool
     */
    public function storeProductDetailAction(){
        $id = $this->getRequest()->getParam('id');
        $id = Safe::filter($id,'int',0);
        if($id){
            $stObj = new store();
            $detail = $stObj->getUserStoreDetail($id,$this->user_id);

            $this->getView()->assign('storeDetail', $detail);
        }

        else
        return false;
    }

    /**
     * 仓单确认
     */
    public function userMakeSureAction(){
        if(IS_POST){
            $storeProductID = safe::filterPost('id','int',0);
            $status = safe::filterPost('status','int',0);
            $msg = safe::filterPost('msg');
            $store = new store();
           $res = $store->userCheck($status,$storeProductID,$this->user_id, $msg, $this->username);
           die(json::encode($res));

        }
        return false;

    }
    //上传接口
    public function swfuploadAction(){
        //调用文件上传类
        $photoObj = new photoupload();
        $photoObj->setThumbParams(array(180,180));
        $photo = current($photoObj->uploadPhoto());

        if($photo['flag'] == 1)
        {
            $result = array(
                'flag'=> 1,
                'img' => $photo['img'],
                'thumb'=> $photo['thumb'][1]
            );
        }
        else
        {
            $result = array('flag'=> $photo['flag'],'error'=>$photo['errInfo']);
        }
        echo JSON::encode($result);

        return false;
    }



    /**
     * 产品列表页面
     */
    public function productListAction(){
        $page = Safe::filterGet('page', 'int', 0);
        $name = Safe::filterGet('name');
        $status = Safe::filterGet('status', 'int', 9);
        $beginDate = Safe::filterGet('beginDate');
        $endDate = Safe::filterGet('endDate');

        //查询组装条件
        $where = 'c.user_id=:uid';
        $bind = array('uid' => $this->user_id);

        if (!empty($name)) {
            $where .= ' AND a.name like"%'.$name.'%"';
            $this->getView()->assign('name', $name);
        }

        if (!empty($status) && $status != 9 || $status==0) {
            $where .= ' AND c.status=:status';
            $bind['status'] = $status;

        }

        if (!empty($beginDate)) {
            $where .= ' AND apply_time>=:beginDate';
            $bind['beginDate'] = $beginDate;
            $this->getView()->assign('beginDate', $beginDate);
        }

        if (!empty($endDate)) {
            $where .= ' AND apply_time<=:endDate';
            $bind['endDate'] = $endDate;
            $this->getView()->assign('endDate', $endDate);
        }

        $productModel = new ProductModel();
        $productList = $productModel->getOfferProductList($page, $this->pagesize,  $where, $bind);
        $statusList = $productModel->getStatusArray();
        $this->getView()->assign('statusList', $statusList);
        $this->getView()->assign('status', $status);
        $this->getView()->assign('mode', $this->_mode);
        $this->getView()->assign('productList', $productList['list']);
        $this->getView()->assign('pageHtml', $productList['pageHtml']);
    }


    /**
     * 产品详情页面
     */
    public function productDetailAction(){

        $id = $this->getRequest()->getParam('id');
        $id = Safe::filter($id, 'int', 0);

        if (intval($id) > 0) {
            $productModel = new ProductModel();
            $offerDetail = $productModel->getOfferProductDetail($id,$this->user_id);
            if ($offerDetail[0]['insurance'] == 1) {
                $risk = new \nainai\insurance\Risk();
                $riskData = $risk->getRiskDetail($offerDetail[0]['risk']);
                $this->getView()->assign('riskData',$riskData);
            }

            if($offerDetail[0]['status'] == $productModel::OFFER_NG){
                if($offerDetail[0]['mode'] == $productModel::DEPOSIT_OFFER)
                    $updateUrl = url::createUrl('/managerdeal/updatedepositeoffer?id='.$offerDetail[0]['id']);
                if($offerDetail[0]['mode'] == $productModel::FREE_OFFER)
                    $updateUrl = url::createUrl('/managerdeal/updatefreeoffer?id='.$offerDetail[0]['id']);
                if($offerDetail[0]['mode'] == $productModel::STORE_OFFER)
                    $updateUrl = url::createUrl('/managerdeal/updatestoreoffer?id='.$offerDetail[0]['id']);
                $this->getView()->assign('updateUrl',$updateUrl);
            }
            $this->getView()->assign('offer', $offerDetail[0]);
            $this->getView()->assign('product', $offerDetail[1]);

        }
        else{
            $this->redirect('productList');
        }


    }

    /**
     * 修改报盘
     */
    public function updateFreeOfferAction(){
        $token =  \Library\safe::createToken();
        $this->getView()->assign('token',$token);
        $id = $this->getRequest()->getParam('id');
        $id = Safe::filter($id, 'int', 0);
        if($id){
            $productModel = new ProductModel();
            $offerDetail = $productModel->getOfferProductDetail($id,$this->user_id);
            $cate_sel = array();//商品所属的各级分类
            foreach($offerDetail[1]['cate'] as $k=>$v){
                $cate_sel[] = $v['id'];
            }
            $pro = new \nainai\offer\product();
            $categorys = $pro->getCategoryLevelSpec($cate_sel);

            $this->getView()->assign('attr',json::encode($offerDetail[1]['attribute']));
            unset($offerDetail[1]['attribute']);

            $this->getView()->assign('offer',$offerDetail[0]);
            $this->getView()->assign('product',$offerDetail[1]);
            $this->getView()->assign('categorys',$categorys);
            $this->getView()->assign('cate_sel',$cate_sel);
        }
    }

    /**
     * 修改报盘
     */
    public function updateDepositeOfferAction(){
        $token =  \Library\safe::createToken();
        $this->getView()->assign('token',$token);
        $id = $this->getRequest()->getParam('id');
        $id = Safe::filter($id, 'int', 0);
        if($id){
            $productModel = new ProductModel();
            $offerDetail = $productModel->getOfferProductDetail($id,$this->user_id);
            $cate_sel = array();//商品所属的各级分类
            foreach($offerDetail[1]['cate'] as $k=>$v){
                $cate_sel[] = $v['id'];
            }
            $pro = new \nainai\offer\product();
            $categorys = $pro->getCategoryLevelSpec($cate_sel);

            $this->getView()->assign('attr',json::encode($offerDetail[1]['attribute']));
            unset($offerDetail[1]['attribute']);

            $this->getView()->assign('offer',$offerDetail[0]);
            $this->getView()->assign('product',$offerDetail[1]);
            $this->getView()->assign('categorys',$categorys);
            $this->getView()->assign('cate_sel',$cate_sel);
        }
    }




    /**
     * 撤销报盘
     */
    public function ajaxsetStatusAction(){
        $id = Safe::filterPost('id', 'int', 0);

        if (intval($id) > 0) {
            $model = new product('');
            $data =array(
                'status' => $model::OFFER_CANCEL
            );

            $res = $model->update($data, $id);
            if ($res['success'] == 1) {
                    $credit = new \nainai\CreditConfig();
                    $credit->changeUserCredit($this->user_id, 'cancel_offer');
                    $log = array();
                    $log['action'] = '撤销报盘' ;
                    $log['content'] = '用户:' . $this->username. ',撤销报盘id为' . $id . '的报盘';
                    $userLog = new \Library\userLog();
                    $userLog->addLog($log);
            }
            exit(json::encode($res));
        }
        exit(json::encode(tool::getSuccInfo(0, 'Error id')));
    }

    /**
     * 修改仓单报盘页面
     */
    public function updateStoreofferAction(){
        $id = $this->getRequest()->getParam('id');
        $id = Safe::filter($id, 'int', 0);
        $token =  \Library\safe::createToken();
        $this->getView()->assign('token',$token);
        if($id){
            $productModel = new ProductModel();
            $offerDetail = $productModel->getOfferProductDetail($id,$this->user_id);
            $storeP = new \Library\M('store_products');
            $storeProduct = $storeP->where(array('product_id'=>$offerDetail[0]['product_id']))->getObj();
            $this->getView()->assign('storeproduct',$storeProduct);

            $this->getView()->assign('offer',$offerDetail[0]);
            $this->getView()->assign('product',$offerDetail[1]);
        }
    }

    /**
     * 仓单报盘修改提交
     */
    public function doUpdateStoreOfferAction(){
        if(IS_POST){
            $token = safe::filterPost('token');
            if(!safe::checkToken($token))
                die(json::encode(tool::getSuccInfo(0,'请勿重复提交'))) ;
            if($id = safe::filterPost('offer_id','int',0)){
                $offerData = array(
                    'apply_time'  => \Library\Time::getDateTime(),
                    'divide'      => Safe::filterPost('divide', 'int'),
                    'minimum'     => ($this->getRequest()->getPost('divide') == 1) ? Safe::filterPost('minimum', 'float') : 0,
                    'minstep'     => (safe::filterPost('divide', 'int') == 1) ? safe::filterPost('minstep', 'float') : 0,
                    'status'      => 0,
                    'accept_area' => Safe::filterPost('accept_area'),
                    'accept_day' => Safe::filterPost('accept_day', 'int'),
                    'price'        => Safe::filterPost('price', 'float'),
                    'user_id'     => $this->user_id,
                    'insurance' => Safe::filterPost('insurance', 'int'),
                    'risk' =>implode(',', Safe::filterPost('risk', 'int'))
                );

                $obj = new \Library\M('product_offer');
                $res = $obj->where(array('id'=>$id))->data($offerData)->update();
                if($res){
                    die(json::encode(tool::getSuccInfo()));
                }

            }

        }
        die(json::encode(tool::getSuccInfo(0,'修改失败')));
    }

    /**
     * 打印预览
     */
    public function tableAction(){
        $this->getView()->setLayOut('');
        $id = $this->getRequest()->getParam('id');
        $id = Safe::filter($id, 'int', 0);

        if (intval($id) > 0) {
             $stObj = new store();
            $data = $stObj->getUserStoreDetail($id, 0);
            // $data = $stObj->getManagerStoreDetail($id,$this->user_id);
            $mem = new \nainai\member();
            $userData = $mem->getUserDetail($data['user_id']);
            $this->getView()->assign('user', $userData);
            $this->getView()->assign('storeDetail', $data);
            $this->getView()->assign('photos', $data['photos']);
        }else{
            $this->redirect(url::createUrl('/ManagerStore/ApplyStoreList'));
        }
    }

}
