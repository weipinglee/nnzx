<?php

use \Library\json;
use \Library\url;
use \Library\Safe;
use \Library\Thumb;
use \Library\tool;
use \Library\PlUpload;
use \nainai\offer\product;
use \nainai\offer\PurchaseOffer;
/**
 * 保险管理
 * @author maoyong
 * @copyright 2016-07-19
 */
class InsuranceController extends UcenterBaseController{

     /**
      * 申请列表
      */
     public function applyListAction(){
          $condition = array('buyer_id' => $this->user_id);
          $this->listData($condition);
     }

     /**
      * 投保列表
      */
     public function insuranceListAction(){
          $condition = array('user_id' => $this->user_id);
          $this->listData($condition);
     }

     /**
      * 列表数据获取
      * @param  array  $condition 
      */
     public function listData($condition = array()){
          $page = Safe::filterGet('page', 'int', 0);
          $name = Safe::filterGet('name');
          $beginDate = Safe::filterGet('beginDate');
          $endDate = Safe::filterGet('endDate');
          $status = Safe::filterGet('status', 'int', 9);

          if (!empty($name)) {
               $condition['name'] = $name;
              $this->getView()->assign('name', $name);
          }

          if ($status != 9) {
               $condition['status'] = $status;
              $this->getView()->assign('s', $status);
          }

          if (!empty($beginDate)) {
               $condition['beginDate'] = $beginDate . ' 00:00:00';
              $this->getView()->assign('beginDate', $beginDate);
          }

          if (!empty($endDate)) {
               $condition['endDate'] = $endDate . ' 23:59:59';
              $this->getView()->assign('endDate', $endDate);
          }    

          $model = new \nainai\insurance\RiskApply();
          $lists = $model->getApplyList($page, $this->pagesize, $condition);
          
          $this->getView()->assign('status', $model->getStatus());
          $this->getView()->assign('lists', $lists['lists']);
          $this->getView()->assign('bar', $lists['bar']);
     }

     /**
      * 查看申请投保详情
      */
     public function insurancedetailAction(){
          if (IS_POST) {
               $model = new \nainai\insurance\RiskApply();
               $id = Safe::filterPost('id', 'int');
               if (intval($id) > 0) {
                    $data = array(
                         'status' => (Safe::filterPost('status', 'int') == 1) ? $model::APPLYOK : $model::APPLYNO
                    );

                    $res = $model->updateRiskApply($data, $id);
                    exit(JSON::encode($res));
               }
               exit(JSON::encode(tool::getSuccInfo(0, '错误的申请信息')));
          }
               $this->detailData();
     }

     /**
      * 个人申请投保信息
      */
     public function applydetailAction(){
          $this->detailData();
     }

     /**
      * 获取投保信息
      */
     public function detailData(){
          $id = $this->getRequest()->getParam('id');
          $id = Safe::filter($id, 'int');

          if (intval($id) > 0) {
               $model = new \nainai\insurance\RiskApply();
               $detail = $model->getDetail(array('id' =>$id));
               $this->getView()->assign('detail', $detail);
               $this->getView()->assign('status', $model->getStatus());
          }else{
               $this->error('错误的申请信息!');
          }
     }

     /**
      * 购买保险产品列表
      */
     public function buyListAction(){
        $id = Safe::filterGet('id', 'int');
        if (intval($id) > 0) {
          $order = new \nainai\order\Order();
          $info = $order->contractDetail($id,'other');

          $risk = new \nainai\insurance\Risk();
          $risk_data = $risk->getRiskDetail($info['risk']);
          $this->getView()->assign('risk_data', $risk_data);
        }else{
          $this->error('错误的请求！');
        }
        $this->getView()->assign('id', $id);
     }

     /**
      * 购买保险
      */
     public function buyAction(){
      $insurance = new \Third\Secure\Picc();
        if (IS_POST) {
              $insureData = array(
                'linkName' => Safe::filterPost('linkName'),
                'linkTel' => Safe::filterPost('linkTel'),
                'startDate' => Safe::filterPost('baoDate'),
                'relation' => Safe::filterPost('relation'),
                'code' => Safe::filterPost('code'),
                'fee' => Safe::filterPost('fee'),
                'rate' => Safe::filterPost('rate'),
                'project_code' => Safe::filterPost('project_code'),
                'limit' => Safe::filterPost('limit'),
                'role' => Safe::filterPost('role'),
                'area' => Safe::filterPost('area'),
              );
              //计算保费
              $insureData['endDate'] = \Library\Time::getDateTime('Y-m-d', strtotime($insureData['startDate']) + 364*24*3600);
              $insureData['insuranceFee'] = round($insureData['fee'] * ($insureData['rate']/1000), 2);
              //投保人信息
              $insureData['toubaoInfo'] = array(
                'name' => Safe::filterPost('baoName'),
                'address' => Safe::filterPost('baoAddress'),
                'tel' => Safe::filterPost('baoTel'),
                'email' => Safe::filterPost('baoEmail'),
                'type' => Safe::filterPost('baoidentType'),
                'identno' => Safe::filterPost('baoidentNO'),
              );
              //被保人信息
              $insureData['insureInfo'] = array(
                'name' => Safe::filterPost('theName'),
                'address' => Safe::filterPost('theAddress'),
                'tel' => Safe::filterPost('theTel'),
                'email' => Safe::filterPost('theEmail'),
                'type' => Safe::filterPost('theidentType'),
                'identno' => Safe::filterPost('theidentNo'),
              );
              //获取被保人出生日期
              if ($insureData['insureInfo']['type'] == 01) {
                $insureData['insureInfo']['birthday'] = substr($insureData['insureInfo']['identno'], 6, 4) . '-' .substr($insureData['insureInfo']['identno'], 10, 2) . '-' . substr($insureData['insureInfo']['identno'], 12, 2);
              }else{
                $insureData['insureInfo']['birthday'] = Safe::filterPost('birthday');
              }
              $res = $insurance->insures($insureData);
              die(json::encode($res));

        }
         else{
             $order_no = safe::filter($this->_request->getParam('oid'));
             $id = safe::filter($this->_request->getParam('id'));

             if (intval($order_no) <= 0 && intval($id) <= 0) {
                 $this->error('错误的请求！');
             }

             $order = new \nainai\order\Order();
             $info = $order->contractDetail($order_no,'other');
             $risk = new \nainai\insurance\Risk();
             $risk_data = $risk->getRisk($id);

             $this->getView()->assign('info', $info);
             $this->getView()->assign('risk_data', $risk_data);
             $this->getView()->assign('identity', $insurance->identity);
             $this->getView()->assign('role', $insurance->role);
             $this->getView()->assign('area', $insurance->area);
             $this->getView()->assign('relation', $insurance->relation);
         }


     }


    /**
     * 申请投保页面
     */
    public function applyAction(){
        $id = safe::filterGet('id');
        if (intval($id) > 0) {

            $model = new \nainai\offer\product();

            $detail = $model->offerDetail($id);
            $detail['modetext'] = $model->getMode($detail['mode']);

            if ($this->user_id == $detail['user_id']) {
                $this->error('不能申请自己发布报盘的保险!');
            }
            //获取保险产品信息
            $risk = new \nainai\insurance\Risk();
            $risk_data = $risk->getCategoryRisk($detail['cate_id']);

            $this->getView()->assign('detail', $detail);
            $this->getView()->assign('risk_data', $risk_data);
        }else{
            $this->error('错误的报盘!');
        }
    }

    /**
     * 处理申请投保
     */
    public function doApplyAction(){
        if (IS_POST) {
            $model = new \nainai\insurance\RiskApply();
            $data = array(
                'buyer_id' => $this->user_id,
                'offer_id' => safe::filterPost('id', 'int'),
                'quantity' => safe::filterPost('quantity', 'float'),
                'note' => safe::filterPost('note'),
                'risk' => implode(',', safe::filterPost('risk')),
                'apply_time'  => \Library\Time::getDateTime(),
                'status' => $model::APPLY
            );

            $res = $model->addRiskApply($data);
            die(json::encode($res));
        }else{
            $this->error('请走正确的流程申请保险');
        }
        exit();
    }

}
