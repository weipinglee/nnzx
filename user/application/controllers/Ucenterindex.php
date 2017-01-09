<?php
/**
 * 用户中心首页
 * User: weipinglee
 * Date: 2016/5/18 0004
 * Time: 上午 9:35
 */

use Library\url;
class UcenterIndexController extends UcenterBaseController {


    /**
     * 个人中心首页
     */
    public function indexAction(){
        $group = new \nainai\member();

        $groupData = $group->getUserGroup($this->user_id);//会员分组数据
        $creditGap = $group->getGroupCreditGap($this->user_id);//与更高等级的分组的差值
        $this->getView()->assign('username',$this->username);
        $this->getView()->assign('user_type', $this->user_type);
        
        $this->getView()->assign('group',$groupData);
        $this->getView()->assign('creditGap',$creditGap);

        $this->getView()->assign('cert',$this->cert);

        $cert = $this->cert;
        $href = $cert['deal'] == 1 ? ($cert['store'] == 1 ? '' : url::createUrl('/ucenter/storecert@user') ) : url::createUrl('/ucenter/dealcert@user');
        $this->getView()->assign('href',$href);
        //获取代理账户金额
        $fundObj = \nainai\fund::createFund(1);
        $active = $fundObj->getActive($this->user_id);
        $freeze = $fundObj->getFreeze($this->user_id);
        $total = $active + $freeze;
        $this->getView()->assign('count',$total);
         $order = new \nainai\order\Order();

        if ($this->user_type == 1) {
                   //获取销售合同
                $where = array();
                $list = $order->sellerContractList($this->user_id,1,$where);

                if(isset($list['list'][0]))
                    $contract1 = $list['list'][0];
                else $contract1 = array();
                $this->getView()->assign('contract1',$contract1);
        }
        
        //获取购买合同
        $list = $order->buyerContractList($this->user_id,1,$where);

        if(isset($list['list'][0]))
            $contract2 = $list['list'][0];
        else $contract2 = array();

        $this->getView()->assign('contract2',$contract2);
    }






}