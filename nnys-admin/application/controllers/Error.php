<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/27 0027
 * Time: ���� 3:45
 */

class ErrorController extends Yaf\Controller_Abstract {

    //��2.1��ʼ, errorAction֧��ֱ��ͨ��������ȡ�쳣
    public function errorAction($exception) {
        //1. assign to view engine
        $this->getView()->assign("exception", $exception);
        //5. render by Yaf
    }
}