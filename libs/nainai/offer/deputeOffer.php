<?php
/**
 * ί�б��̹���
 * author: weipinglee
 * Date: 2016/5/7
 * Time: 23:43
 */

namespace nainai\offer;
use \Library\tool;
class deputeOffer extends product{

    /**
     * ��ȡί�б��̷���
     * @return int
     */
    public function getFeeRate($user_id){
        $m = new \nainai\member();
        $group = $m->getUserGroup($user_id);
        if(empty($group)){
            return 0;
        }
        else{
            return $group['depute_fee'];
        }
    }


    /**
     * ���̲�������
     * @param array $productData  ��Ʒ����
     * @param array $offerData ��������
     */
    public function doOffer($productData,$offerData){
        $offerData['mode'] = self::DEPUTE_OFFER;
        $this->_productObj->beginTrans();
        $offerData['user_id'] = $this->user_id;
        $insert = $this->insertOffer($productData,$offerData);

        if($insert===true){
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
}