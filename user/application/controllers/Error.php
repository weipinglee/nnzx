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
        $this->getView()->setLayout('');
        switch($exception->getCode()) {
            case 513:
            case 514:
            case 515:
            case 516:
            case 517:
            case 518:
                header( "HTTP/1.1 404 Not Found" );
                header( "Status: 404 Not Found" );
                break;
        }

    }


}