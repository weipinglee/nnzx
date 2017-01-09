<?php

namespace nainai\insurance;

use \Library\M;
use \Library\Query;
use \Library\Tool;

/**
 * 申请保险的数据处理
 */
class RiskApply extends \nainai\Abstruct\ModelAbstract{

     const APPLY = 0;
     const APPLYOK = 1;
     const APPLYNO = 2;

     public function getStatus(){
          return array(
               self::APPLY => '申请',
               self::APPLYOK => '申请通过',
               self::APPLYNO => '申请驳回',
          );
     }

     protected $Rules = array(
        array('buyer_id','require','必须有申请人'),
        array('offer_id','require','必须选择报盘来申请'),
        array('quantity','require','请填写购买的数量！')
    );

     /**
      * 获取申请保险的列表
      * @param  Int $page      页码
      * @param  Int $pagesize  页数
      * @param  array  $condition 查询的条件
      * @return Array.lists            返回的列表 
      * @return Array.bar 分页html
      */
     public function getApplyList($page, $pagesize, $condition = array()){
          $query = new Query('risk_apply as a');
          $query->fields = 'a.*, p.name';
          $query->join = ' LEFT JOIN product_offer as o ON a.offer_id=o.id LEFT JOIN products as p ON o.product_id=p.id';
          $query->page = $page;
          $query->pagesize = $pagesize;
          $query->order = 'apply_time desc';

          //申请的列表
          if (isset($condition['buyer_id']) && !empty($condition['buyer_id'])) {
               $where = ' buyer_id=:buyer_id ';
               $bind = array('buyer_id' => $condition['buyer_id']);
          }

          //投保的列表
          if (isset($condition['user_id']) && !empty($condition['user_id'])) {
               $where = ' o.user_id=:user_id ';
               $bind = array('user_id' => $condition['user_id']);
               $query->join .= ' LEFT JOIN user as u ON o.user_id=u.id LEFT JOIN company_info as c ON u.id=c.user_id';
               $query->fields .= ' , u.username, c.company_name';
          }
          
          if (isset($condition['name']) && !empty($condition['name'])) {
               $where .= ' AND p.name like"%'.$condition['name'].'%"';
          }

          if (isset($condition['status']) && intval($condition['status']) >= 0) {
               $where .= ' AND a.status=:status';
               $bind['status'] = $condition['status'];
          }

          if (isset($condition['beginDate']) && !empty($condition['beginDate'])) {
               $where .= ' AND a.apply_time>=:beginDate';
              $bind['beginDate'] = $condition['beginDate'];
          }

          if (isset($condition['endDate']) && !empty($condition['endDate'])) {
               $where .= ' AND a.apply_time<=:endDate';
              $bind['endDate'] = $condition['endDate'];
          }

          $query->where = $where;
          $query->bind = $bind;
          $lists = $query->find();

          return array('lists' => $lists, 'bar' => $query->getPageBar());
     }

     /**
      * 获取申请投保的详情
      * @param  integer $id      申请投保id    
      * @return Array        
      */
     public function getDetail($condition = array()){
          $query = new Query('risk_apply as a');
          $query->fields = 'a.*, p.name, p.cate_id, o.type, u.username, c.company_name';
          $query->join = ' LEFT JOIN product_offer as o ON a.offer_id=o.id LEFT JOIN products as p ON o.product_id=p.id';
          $query->join .= ' LEFT JOIN user as u ON o.user_id=u.id LEFT JOIN company_info as c ON u.id=c.user_id';

          $where = ' 1 ';
          $bind = array();

          if (isset($condition['id']) && !empty($condition['id'])) {
            $where .= ' AND a.id=:id';
            $bind['id'] = $condition['id'];
          }

          if (isset($condition['offer_id']) && !empty($condition['offer_id'])) {
            $where .= ' AND a.offer_id=:offer_id';
            $bind['offer_id'] = $condition['offer_id'];
          }

          if (isset($condition['user_id']) && !empty($condition['user_id'])) {
            $where .= ' AND a.user_id=:user_id';
            $bind['user_id'] = $condition['user_id'];
          }
          $query->where = $where;
          $query->bind = $bind;

          $detail = $query->getObj();
          $risk = new Risk();
          $detail['risk_data'] = $risk->getProductRisk($detail['risk'], $detail['cate_id']);

          $product = new \nainai\offer\product();
          $detail['typeText'] = $product->getType($detail['type']);

          return $detail;
     }

}