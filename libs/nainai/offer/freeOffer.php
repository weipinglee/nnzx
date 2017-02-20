<?php
/**
 * 自由报盘管理类
 * author: weipinglee
 * Date: 2016/5/7
 * Time: 21:59
 */

namespace nainai\offer;
use nainai\fund;
use \Library\tool;
use \Library\M;
class freeOffer extends product{



    /**
     * 获取自由报盘费率
     *
     */
    public function getFee($user_id){

        $m = new \nainai\member();
        $group = $m->getUserGroup($user_id);

        if($group['vip']) return 0;

        //获取费率
        if(empty($group)){
            $feeRate = 100;
        }
        else{
            $feeRate = $group['free_fee'];
        }


        //获取后台设置的自由报盘费用
        $obj = new M('scale_offer');
        $fee = $obj->getField('free');
        return bcmul(floatval($fee),$feeRate)/100;
    }

    /**
     * 报盘申请插入数据
     * @param array $productData  商品数据
     * @param array $offerData 报盘数据
     *
     */
    public function doOffer($productData,$offerData,$offer_id=0){
        $user_id = $this->user_id;
        $acc_type = $offerData['acc_type'];
        $fund = fund::createFund($acc_type);
        $active = $fund->getActive($user_id);//获取用户可用金额
        $fee = $this->getFee($user_id);//获取自由报盘费用

        if($active >= $fee){
            $offerData['offer_fee'] = $fee;
            $offerData['user_id'] = $user_id;
            $offerData['mode'] = self::FREE_OFFER;
            $this->_productObj->beginTrans();
            if($offer_id){//删除旧的id
                $this->delOffer($offer_id,$this->user_id);
            }
            $insert = $this->insertOffer($productData,$offerData);

            if($insert===true){
                if($fee>0){
                    $note = '自由报盘冻结报盘费';
                    $fund->freeze($user_id,$fee,$note);
                }
                if($this->_productObj->commit()){
                    return tool::getSuccInfo();
                }
                else  return tool::getSuccInfo(0,$this->errorCode['server']['info']);
            }
            else{
                $this->_productObj->rollBack();
                $this->errorCode['dataWrong']['info'] = $insert;
                return tool::getSuccInfo(0,$this->errorCode['dataWrong']['info']);
            }

        }
        else{//资金不足
            return tool::getSuccInfo(0,$this->errorCode['fundLess']['info']);
        }

    }

}