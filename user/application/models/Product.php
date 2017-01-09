<?php

use \Library\Query;
use \Library\tool;
use \Library\M;
/**
 * 商品模型
 * @author zengmaoyong 
 */
class productModel extends \nainai\offer\product{


	/**
	 * 获取报盘对应的产品列表
	 * @param  [Int] $page     [分页]
	 * @param  [Int] $pagesize [分页]
	 * @param  string $where    [where的条件]
	 * @param  array  $bind     [where绑定的参数]
	 * @return [Array.list]           [返回的对应的列表数据]
	 * @return [Array.pageHtml]           [返回的分页html数据]
	 */
	public function getOfferProductList($page, $pagesize, $where='', $bind=array()){
		$query = new Query('product_offer as c');
		$query->fields = 'c.id, a.name, b.name as cname, a.quantity,a.unit,a.freeze,a.sell, c.price, c.expire_time, c.status, c.mode, a.user_id, c.apply_time';
		$query->join = '  LEFT JOIN products as a ON c.product_id=a.id LEFT JOIN product_category as b ON a.cate_id=b.id ';
		$query->page = $page;
		$query->pagesize = $pagesize;
		// $query->order = ' a.create_time desc';

		$status = implode(',', array(self::OFFER_APPLY, self::OFFER_OK, self::OFFER_NG));
		$where .= ' AND c.status IN (' .$status. ')';
		if (empty($where)) {
			$where = ' AND c.mode IN (1, 2,3, 4) ';
		}else{
			$where .= ' AND c.mode IN (1, 2,3, 4) ';
			$query->bind = $bind;
		}
		$query->where = $where;
		$list = $query->find();
		foreach($list as $k=>$v){
			$list[$k]['status'] = $this->getStatus($list[$k]['status']);
		}
		return array('list' => $list, 'pageHtml' => $query->getPageBar());
	}




	/**
	 * 获取对应id的报盘和产品详情数据
	 * @param  [Int] $id [报盘id]
	 * @return [Array]     [报盘和产品数据]
	 */
	public function getOfferProductDetail($id,$user_id){
		$query = new M('product_offer');
		$offerData = $query->where(array('id'=>$id,'user_id'=>$user_id))->getObj();
		$offerData['divide_txt'] = $this->getDivide($offerData['divide']);
		$offerData['status_txt'] = $this->getStatus($offerData['status']);
		$productData = $this->getProductDetails($offerData['product_id']);
		return array($offerData,$productData);
	}


}