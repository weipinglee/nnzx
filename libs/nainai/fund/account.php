<?php
/**
 * ÓÃ»§ÕË»§¹ÜÀíÀà
 * author: weipinglee
 * Date: 2016/4/20
 * Time: 16:18
 */
namespace nainai\fund;
use nainai\order\Order;
class account{

    public function get_account($type){
        switch ($type) {
            case Order::PAYMENT_AGENT:
                return new \nainai\fund\agentAccount();
                break;
            case Order::PAYMENT_BANK:
                return new \nainai\fund\zx();//暂时只考虑中信银行
                //return '中信银行签约支付暂时未开通，请选择其他支付方式';
                break;
            case Order::PAYMENT_TICKET:
                return '票据账户支付暂时未开通，请选择其他支付方式';
                break;
            default:
                return '无效支付方式';
                break;
        } 
    }

    /**
     * »ñÈ¡¿ÉÓÃÓà¶î
     * @param int $user_id
     */
    protected function getActive($user_id){

    }

    /**
     * »ñÈ¡¶³½á×Ê½ð½ð¶î
     * @param int $user_id ÓÃ»§id
     */
    protected function getFeeze($user_id){

    }
    /**
     * Èë½ð²Ù×÷
     * @param int $user_id ÓÃ»§id
     * @param $num float Èë½ð½ð¶î
     */
    protected function in($user_id,$num){

    }



    /**
     * ×Ê½ð¶³½á
     * @param int $user_id ÓÃ»§id
     * @param float $num ¶³½á½ð¶î
     */
    protected function freeze($user_id,$num,$clientID=''){

    }

    /**
     * ¶³½á×Ê½ðÊÍ·Å
     * @param int $user_id
     * @param float $num ÊÍ·Å½ð¶î
     */
    protected function freezeRelease($user_id,$num,$freezeno=''){

    }

    /**
     * ¶³½á×Ê½ðÖ§¸¶
     * ½«¶³½á×Ê½ð½â¶³£¬Ö§¸¶¸øÁíÍâÒ»¸öÓÃ»§
     * @param int $from ¶³½áÕË»§ÓÃ»§id
     * @param int $to  ×ªµ½µÄÕË»§ÓÃ»§id
     * @param float $num ×ªÕËµÄ½ð¶î
     *
     */
    protected function freezePay($from,$to,$num,$note='',$amount=''){

    }

    /**
     * ¿ÉÓÃÓà¶îÖ±½Ó¸¶¿î¸øÊÐ³¡
     * @param int $user_id Ö§¸¶ÓÃ»§id
     * @param float $num ×ªÕËµÄ½ð¶î
     */
    protected function payMarket($user_id,$num){

    }


}