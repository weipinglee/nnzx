<?php
/**
 * �ʽ������
 * author:weipinglee
 * Date: 2016/4/22
 * Time: 10:11
 */

namespace nainai;
class fund{

    const FUND_AGENT  =  1; //�����˻�


    public static function createFund($id){

        switch($id){


            case self::FUND_AGENT :
            default : {
                 return new \nainai\fund\agentAccount();
             }
            break;
        }
    }
}