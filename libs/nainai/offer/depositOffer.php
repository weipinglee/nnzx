<?php
/**
 * ��֤���̹�����
 * author: weipinglee
 * Date: 2016/5/7
 * Time: 23:16
 */
namespace nainai\offer;
use \Library\tool;
class depositOffer extends product{

    /**
     * ��ȡ��֤����ȡ���� TODO
     */
    public function getDepositRate($user_id){
        $obj = new \nainai\member();
        $res=$obj->getUserGroup($user_id);
        return $res['caution_fee'];
    }

    /**
     * ���������������
     * @param array $productData  ��Ʒ����
     * @param array $offerData ��������
     * @param int $offer_id Ҫ���µ�id
     */
    public function doOffer($productData,$offerData,$offer_id=0){
        $offerData['mode'] = self::DEPOSIT_OFFER;
        $this->_productObj->beginTrans();
        if($offer_id){//ɾ���ɵ�id
            $this->delOffer($offer_id,$this->user_id);
        }

        $offerData['user_id'] = $this->user_id;
        $insert = $this->insertOffer($productData,$offerData);

        if($insert===true){
            if($this->_productObj->commit()){
                return tool::getSuccInfo();
            }
            else return tool::getSuccInfo(0,$this->errorCode['server']['info']);
        }
        else{
            $this->_productObj->rollBack();
            $this->errorCode['dataWrong']['info'] = $insert;
            return tool::getSuccInfo(0,$this->errorCode['dataWrong']['info']);
        }

    }
}