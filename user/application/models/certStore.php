<?php
/**
 * 交易商认证子类,区别于父类，该类获取页面显示的具体内容
 * author: weipinglee
 * Date: 2016/5/3 0003
 * Time: 下午 3:56
 */

class certStoreModel extends \nainai\cert\certStore{

    /**
     * 获取用户中心认证页面显示内容
     * @param int $user_id
     * @return array
     */
    public function getCertShow($user_id=0){
        $cert_type = self::$certType;
        if($user_id==0)$user_id = $this->user_id;
        $status_data = $this->getCertStatus($user_id,$cert_type);
        $certArr = array();
        switch($status_data['status']){
            case self::CERT_BEFORE : {//从未申请
                $certArr['button_show'] = true;
                $certArr['button_text'] = '去认证';
                $certArr['step'] = 1;

            }
                break;
            case self::CERT_INIT:{//更改资料后
                $certArr['button_show'] = true;
                $certArr['button_text'] = '重新认证';
                $certArr['step'] = 3;
            }
                break;
            case self::CERT_APPLY:{//提交申请
                $certArr['button_show'] = false;
                $certArr['button_text'] = '';
                $certArr['step'] = 3;
            }
                break;
            case self::CERT_SUCCESS:{//认证成功
                $certArr['button_show'] = false;
                $certArr['button_text'] = '';
                $certArr['step'] = 3;
            }
                break;
            case self::CERT_FAIL : {//认证驳回
                $certArr['button_show'] = true;
                $certArr['button_text'] = '重新认证';
                $certArr['step'] = 3;
            }
                break;
        }
        $certArr['status_text'] = self::$status_text[$status_data['status']];
        return $certArr;
    }

}