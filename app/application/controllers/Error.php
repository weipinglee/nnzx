<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/27 0027
 * Time: ÏÂÎç 3:45
 */

class ErrorController extends Yaf\Controller_Abstract {

    //´Ó2.1¿ªÊ¼, errorActionÖ§³ÖÖ±½ÓÍ¨¹ý²ÎÊý»ñÈ¡Òì³£
    public function errorAction($exception) {
        
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
        echo '<pre>';var_dump($exception);
        return false;
    }


}