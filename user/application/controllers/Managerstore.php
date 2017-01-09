<?php

use \Library\url;
use \nainai\store;
use \Library\Safe;
use \Library\Thumb;
use \nainai\offer\product;
use \Library\json;
/**
 * 仓单管理的的控制器类
 */
class ManagerStoreController extends UcenterBaseController{

	protected  $certType = 'store';



	public function indexAction(){}

	public function addSuccessAction(){}

	/**
	 * 审核仓单列表
	 */
	public function applyStoreListAction(){
		$page = Safe::filterGet('page', 'int', 0);
		//$type = $this->getRequest()->getParam('type');
		//$type = Safe::filter($type,'int',1);
		$type=2;
		$store = new store();

		if($type==1)
			$data = $store->getManagerApplyStoreList($page,$this->user_id);
		else
			$data = $store->getManagerStoreList($page,$this->user_id);

		$this->getView()->assign('statuList', $store->getStatus());
		$this->getView()->assign('data', $data);
	}

	/**
	 * 仓单签发时获取用户信息
	 */
	public function getUserAction(){
		if(IS_POST){
			$acc = safe::filterPost('username');
			$user = new \nainai\member();
			$res = $user->getUserDetail(array('username'=>$acc, 'type' => 1));
			die(json::encode($res));
		}
		return false;



	}

	


	/**
	 * 仓单提货出库审核列表
	 */
	public function storeCheckListAction(){
		$store = new \nainai\delivery\StoreDelivery();
		$page = safe::filterGet('page','int',1);
		$list = $store->storeCheckList($page,$this->user_id);
		$this->getView()->assign('data',$list['data']);
        		$this->getView()->assign('page',$list['bar']);
	}

	/**
	 * 仓单提货详情
	 */
	public function storeCheckDetailAction(){
		$store = new \nainai\delivery\StoreDelivery();
		$id = safe::filter($this->_request->getParam('id'));
		$info = $store->storeFees($id);
		$this->getView()->assign('info',$info);
	}

	/**
	 * 确认出库
	 */
	public function storeDeliveryCheckAction(){
		$delivery_id = safe::filter($this->_request->getParam('id'));

		$store = new \nainai\delivery\StoreDelivery();
		$res = $store->managerCheckout($delivery_id);
		if($res['success'] == 1){
			$this->success('已确认出库',url::createUrl('/ManagerStore/storeCheckList'));
		}else{
			$this->error($res['info']);
		}

	}

	/**
	 * 审核仓单后，仓单签发的详情页面
	 */
	public function applyStoreSignAction(){
		$id = $this->getRequest()->getParam('id');
		$id = Safe::filter($id, 'int', 0);
		if (intval($id) > 0) {
			$store = new store();
			$data = $store->getManagerStoreDetail($id,$this->user_id);


			$this->getView()->assign('storeDetail', $data);
		}else{
			$this->redirect(url::createUrl('/ManagerStore/ApplyStoreList'));
		}
	}


	/**
	 * 商品添加页面展示
	 */
	private function productAddAction(){

		$category = array();

		//获取商品分类信息，默认取第一个分类信息
		$productModel = new product();
		$category = $productModel->getCategoryLevel();

		$attr = $productModel->getProductAttr($category['chain']);
		$attr = array_reverse($attr);
		//注意，js要放到html的最后面，否则会无效
		$this->getView()->assign('categorys', $category['cate']);
		$this->getView()->assign('attrs', $attr);
		$this->getView()->assign('unit', $category['unit']);
		$this->getView()->assign('cate_id', $category['defaultCate']);
	}

	//仓单签发
	public function storeSignAction(){
		$store_list = store::getStoretList();

		$this->getView()->assign('storeList',$store_list);
		$this->productAddAction();

		$token =  \Library\safe::createToken();
		$this->getView()->assign('token',$token);
	}




	/**
	 * 仓单审核页面
	 */
	public function applyStoreCheckAction(){
		$id = $this->getRequest()->getParam('id');
		$id = Safe::filter($id, 'int', 0);
		if (intval($id) > 0) {
			$store = new store();
			$data = $store->getManagerStoreDetail($id,$this->user_id);
			$userObj = new \nainai\member();

			$userData = $userObj->getUserDetail($data['user_id']);
			
		    $this->getView()->assign('detail', $data);
			$this->getView()->assign('user', $userData);
		}
	        
	}

	/**
	 * 仓单详情
	 */
	public function applyStoreDetailAction(){
		$id = $this->getRequest()->getParam('id');
		$id = Safe::filter($id, 'int', 0);

		if (intval($id) > 0) {
			$store = new store();
			$data = $store->getManagerStoreDetail($id,$this->user_id);
			$mem = new \nainai\member();
			$userData = $mem->getUserDetail($data['user_id']);
			$this->getView()->assign('user', $userData);
			$this->getView()->assign('storeDetail', $data);
			$this->getView()->assign('photos', $data['photos']);
		}else{
			$this->redirect(url::createUrl('/ManagerStore/ApplyStoreList'));
		}
	}

	/**
	 * 处理审核
	 * @return 
	 */
	public function doApplyStoreAction(){
		$id = Safe::filterPost('id', 'int', 0);
		if (IS_POST && intval($id) > 0) {
			$apply = array();
			$apply['status'] = (Safe::filterPost('apply', 'int', 0) == 1) ? 1 : 0;//获取审核状态

			$store = new store();
			$res = $store->storeManagerCheck($apply, $id,$this->user_id);
			die(json::encode($res)) ;
		}
		$this->redirect('ApplyStore');
	}

	/**
	 * 获取POST提交上来的商品数据,报盘处理和申请仓单处理都会用到
	 * @return array 商品数据数组
	 */
	private function getProductData(){
		$attrs = Safe::filterPost('attribute');
		if(!empty($attrs)){
			foreach($attrs as $k=>$v){
				if(!is_numeric($k)){
					echo JSON::encode(\Library\tool::getSuccInfo(0,'属性错误'));
					exit;
				}
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
		);

		//图片数据
		$imgData = Safe::filterPost('imgData');

		$resImg = array();
		if(!empty($imgData)){
			foreach ($imgData as $imgUrl) {
				if (!empty($imgUrl) && is_string($imgUrl)) {
					if(!isset($detail['img']) || $detail['img']=='')
						$detail['img'] = \Library\tool::setImgApp($imgUrl);
					array_push($resImg, array('img' => \Library\tool::setImgApp($imgUrl)));
				}
			}
		}

		return array($detail,$resImg);
	}
	/**
	 * 处理仓单签发
	 */
	public function doStoreSignAction(){

		if (IS_POST) {
			$user_id = safe::filterPost('user_id','int',0);
			if(!$user_id)
				die(json::encode(\Library\tool::getSuccInfo(0,'用户id错误')));
			
			$storeProduct = array(
				'user_id'   => $user_id,
				'store_pos' => safe::filterPost('pos'),
				'cang_pos'  => safe::filterPost('cang'),
				'store_price'=> safe::filterPost('store_price'),
				'store_unit' => safe::filterPost('store_unit','/^[dym]$/'),
				'in_time' => safe::filterPost('inTime'),
				'rent_time' => safe::filterPost('rentTime'),
				'check_org' => safe::filterPost('check'),
				'check_no'  => safe::filterPost('check_no'),
				'sign_time' => \Library\time::getDateTime(),
				'package'   => safe::filterPost('package','int'),
				'confirm'   => \Library\tool::setImgApp(safe::filterPost('imgfile1')),
				'quality'   => \Library\tool::setImgApp(safe::filterPost('imgfile2')),
				'sign_user' => $this->user_id
			);
			if ($storeProduct['package']) {
				$storeProduct['package_unit'] = safe::filterPost('packUnit');
				$storeProduct['package_num'] = safe::filterPost('packNumber', 'float');
				$storeProduct['package_weight'] = safe::filterPost('packWeight', 'float');
				$storeProduct['package_units'] = safe::filterPost('pageUnits');
			}
			$productData = $this->getProductData();
			$productData[0]['user_id'] = $user_id;

			$store = new store();
			$res = $store->createStoreProduct( $productData,$storeProduct,$this->user_id);
			if($res['success']==1){
				$log = new \Library\userLog();
				$log->addLog(array('action'=>'仓单签发','content'=>'签发了id为'.$res['id'].'的仓单'));
			}
			die(json::encode($res)) ;
		}
		$this->redirect('ManagerStoreList');
	}

	/**
	 * 仓单管理页面
	 */
	public function ManagerStoreListAction(){
		$page = Safe::filterGet('page', 'int', 0);
		$store = new store();
		$data = $store->getApplyStoreList($page, $this->pagesize, $this->user_id);

		$this->getView()->assign('statuList', $store->getStatus());
		$this->getView()->assign('storeList', $data['list']);
		$this->getView()->assign('attrs', $data['attrs']);
		$this->getView()->assign('pageHtml', $data['pageHtml']);
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
			$cate['risk_data'] = $risks;
			unset($cate['chain']);
			echo JSON::encode($cate);
		}
		return false;
	}
	 /**
     * 修改仓单信息
     */
    public function updateStoreAction(){
    	$id = Safe::filterGet('id','int',0);
    	if($id){
    		$stObj = new store();
    		$detail = $stObj->getManagerStoreDetail($id,$this->user_id);

    
			$cate_sel = array();//商品所属的各级分类
			foreach($detail['cate'] as $k=>$v){
				$cate_sel[] = $v['id'];
			}
			$pro = new \nainai\offer\product();
			$categorys = $pro->getCategoryLevelSpec($cate_sel);

			$this->getView()->assign('categorys',$categorys);
			$this->getView()->assign('cate_sel',$cate_sel);
    		$user = new \nainai\member();
    		$res = $user->getUserDetail(array('id'=>$this->user_id));
    		$this->getView()->assign('detail', $detail);
			$this->getView()->assign('imgData', $detail['imgData']);
    		$this->getView()->assign('user', $res);
    	}else{
    		$this->error('错误的请求方式!');
    	}
    }

    /**
     * 处理仓单签发
     */
    public function doupdateStoreAction(){

    	if (IS_POST) {
    		$product_id = safe::filterPost('product_id');
    		$id = safe::filterPost('id');
    		if (empty($product_id) || empty($id)) {
    			die(json::encode(\Library\Tool::getSuccInfo(0, '错误的请求方式!')));
    		}
    		$storeProduct = array(
    			'store_pos' => safe::filterPost('pos'),
    			'cang_pos'  => safe::filterPost('cang'),
    			'store_price'=> safe::filterPost('store_price'),
    			'in_time' => safe::filterPost('inTime'),
    			'rent_time' => safe::filterPost('rentTime'),
    			'check_org' => safe::filterPost('check'),
    			'check_no'  => safe::filterPost('check_no'),
    			'package'   => safe::filterPost('package','int')
    			);

    		if ($storeProduct['package']) {
    			$storeProduct['package_unit'] = safe::filterPost('packUnit');
    			$storeProduct['package_num'] = safe::filterPost('packNumber', 'float');
    			$storeProduct['package_weight'] = safe::filterPost('packWeight', 'float');
    		}
    		if (!empty(safe::filterPost('imgfile1'))) {
    			$storeProduct['confirm'] = \Library\tool::setImgApp(safe::filterPost('imgfile1'));
    		}
    		if (!empty(safe::filterPost('imgfile2'))) {
    			$storeProduct['quality'] = \Library\tool::setImgApp(safe::filterPost('imgfile2'));
    		}
    		$productData = $this->getProductData();
    		unset($productData[0]['produce_area']);
    		$store = new store();
    		$storeProduct['status'] = $store::STOREMANAGER_SIGN;
    		$res = $store->updateStoreProduct( $productData,$storeProduct,$product_id, $id);

			if($res['success']==1){
				$log = new \Library\userLog();
				$log->addLog(array('action'=>'仓单签发','content'=>'修改了id为'.$id.'的仓单'));
			}
    		die(json::encode($res));
    	}
    }

}