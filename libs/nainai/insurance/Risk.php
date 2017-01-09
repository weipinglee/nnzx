<?php

namespace nainai\insurance;

use \Library\M;
use \Library\Query;
use \Library\Tool;

/**
 * 保险的数据处理
 */
class Risk extends \nainai\Abstruct\ModelAbstract{

     const PICC = 1;

     public function getCompany(){
          return array(self::PICC => '人保');
     }

     protected $Rules = array(
        array('name','/\S{2,20}/i','必须填写保险产品名'),
        array('company','require','必须选择保险公司'),
        array('mode','require','必须选择保额类型'),
        array('project_code','require','必须填写定额方案代码'),
        array('code','require','必须填写保险代码'),
        array('limit','require','必须填写保险保额')
    );

     public function getRiskList($page=0, $where = array()){
            $query = new Query('risk');
            if ($page >= 0) {
                $query->page = $page;
                $query->pagesize = 10;
            }
            if (! empty($where) && isset($where['status'])) {
                $query->where = 'status = 1';
            }
            $query->order = 'create_time desc';
            $data = $query->find();
            if ($page >= 0) {
                $res = array('lists' => $data, 'bar' => $query->getPageBar());
            }else{
              $insurance = array();
              $company = $this->getCompany();
              foreach ($data as $key => $value) {
                  $insurance[$value['id']] = array('company' => $company[$value['company']], 'name' => $value['name'], 'mode' => $value['mode'], 'id' => $value['id'], 'note' => $value['note']);
                  if ($value['mode'] == 1) {
                    $insurance[$value['id']]['fee'] =  $value['rate'];
                  }else{
                    $insurance[$value['id']]['fee'] =  $value['fee'];
                  }
              }
                $res = $insurance;
            }
            
            return $res;
     }

     /**
      * 获取分类对应能够买的保险,能够追溯上级分类
      * @param  Int $cid 分类id
      * @return Array      
      */
     public function getCategoryRisk($cid){
            $risk_data = array();
           
           $model = new \nainai\offer\product();
           $cates = $model->getParents($cid);
           if (!empty($cates)) {
                foreach ($cates as $key => $value) {
                     $risk_data = $model->getCateName($value['id'], 'risk_data');
                     if (!empty($risk_data)) { //如果上一级分类有保险配置，就用这个配置
                          $risk = $this->getRiskDetail($risk_data);
                          break;
                     }
                }
           }
           return $risk;
     }

     /**
      * 获取risk，id对应的产品数据
      * @param  String $risk_data risk
      * @return Array            
      */
     public function getRiskDetail($risk_data){
         if($risk_data=='')
             return array();
        //获取保险产品信息
        $list = $this->getRiskList(-1, array('status' => 1));
        if (!empty($risk_data)) { //如果上一级分类有保险配置，就用这个配置
                          if (is_string($risk_data)) {
                            $risk_data = explode(',', $risk_data);
                          }
                          $risk = array();
                          foreach ($risk_data as &$value) {
                              $risk[$value]['risk_id'] = $list[$value]['id'];
                              $risk[$value]['name'] = $list[$value]['name'];
                              $risk[$value]['company'] = $list[$value]['company'];
                              $risk[$value]['mode'] = $list[$value]['mode'];
                              $risk[$value]['fee'] = $list[$value]['fee'];
                          }
         }
         return $risk;
     }

    /**
     * 获取保险信息
     * @param mixed $riskIds  逗号分隔的保险id或id数组
     */
    public function getProductRisk($riskIds){
        if(is_array($riskIds) && !empty($riskIds)){
            $riskIds = implode(',',$riskIds);
        }

        $obj = new M('risk');
        $data = $obj->where('id in ('.$riskIds.')')->select();
        $company = $this->getCompany();
        foreach($data as $k=>$val){
            $data[$k]['company'] = $company[$val['company']];
        }
        return $data;




    }

    

}