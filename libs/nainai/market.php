<?php
/**
 * 市场开闭市管理
 * User: weipinglee
 * Date: 2016/8/17
 * Time: 17:00
 */
namespace nainai;
use \Library\tool;
class market{

    /**
     * 受开闭市影响的方法路径
     * @var array
     */
    protected $actions = array(
        'deal' => array(
            'index/trade/doreport',
            'index/trade/buyerpay'

        ),
        'user' => array(
            'index/fund/dofundout',
            'index/fund/dofundin',
            'index/managerdeal/dodepositoffer',
            'index/managerdeal/dofreeoffer',
            'index/managerdeal/dostoreoffer',
            'index/managerdeal/dodeputeoffer',
            'index/managerstore/dostoresign',
            'index/ucenter/dodealcert',
            'index/ucenter/dostorecert',
            'index/managerstore/doupdatestore',
            'index/depositdelivery/sellerconsignment',
            'index/depositdelivery/buyerconfirm',
            'index/contract/geneorderinvoice',
            'index/contract/complaincontract',
            'index/contract/complaincontract',
            'index/purchaseorder/geneorderhandle',
            'index/storedelivery/storefees',
            'index/order/confirmproof',
            'index/order/verifyqaulity',
            'index/order/sellerverify',
            'index/order/contractcomplete',
            'post' => array(   //里面的url 闭市时不能通过post请求，可以访问页面
                'index/purchase/issue',
                'index/fund/bank',
                'index/deposit/sellerdeposit',
                'index/order/buyerretainage',
            ),

        ),
        'admin' => array(
            'balance/accmanage/usercreditadd',
            'balance/fundin/offlinefirst',
            'balance/fundin/offlinefinal',
            'balance/fundin/del',
            'balance/fundout/firstcheck',
            'balance/fundout/finalcheck',
            'balance/fundout/transfer',
            'balance/fundout/del',
            'store/storeorder/storeorderpass',
            'store/storeproduct/setStatus',

        ),
    );



    /**
     * 判断是否处于开市时间
     *
     */
    private function checkTime(){
        $model = new \nainai\system\DealSetting();
        $deal = $model->getsetting();
        if (empty($deal)) { //如果没有设置开闭市
            return true;
        }
        $deal['weeks'] = explode(',', $deal['weeks']);
        $week = date('w');
        $start = strtotime(date('Y-m-d',time()).' '. $deal['start_time']);
        $end   = strtotime(date('Y-m-d',time()).' '.$deal['end_time']);

        if ($deal['is_operate'] == 1) {
            if ($deal['operate_time'] != $week && in_array($week, $deal['weeks']) && time()>$end) {
                $data['is_operate'] = 0;
                $model->updateDealSetting($data, $deal['date']);
                return false;
            }else{
                return true;
            }
        }

        if( in_array($week, $deal['weeks']) && (time() >= $start && time() <= $end)) {
            return true;
        }
        return false;
    }

    /**
     *判断是否可以操作
     * @param obj $request 请求
     * @return bool true:可以操作，false:不可操作
     */
    public function checkCanOper($request){
        if(!$this->checkTime()){//如果已闭市
            $appName = tool::getConfig(array('application','name'));
            if($appName && !empty($this->actions[$appName])){
                $url = $request->getModuleName().'/'.$request->getControllerName().'/'.$request->getActionName();
                $url = strtolower($url);
                if(in_array($url,$this->actions[$appName])){//该动作不能操作
                    return false;
                }

                if(isset($this->actions[$appName]['post']) && in_array($url,$this->actions[$appName]['post']) && IS_POST){//该url的post请求不能操作
                    return false;
                }

            }
        }
        return true;
    }






}