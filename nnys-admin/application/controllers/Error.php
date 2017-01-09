<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/27 0027
 * Time: 下午 3:45
 */

class ErrorController extends Yaf\Controller_Abstract {

    //从2.1开始, errorAction支持直接通过参数获取异常
    public function errorAction($exception) {
        //1. assign to view engine
        $this->getView()->assign("exception", $exception);
        //5. render by Yaf
    }
}