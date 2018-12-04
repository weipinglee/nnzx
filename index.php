<?php

// phpinfo();exit;
date_default_timezone_set('Asia/Shanghai');
// error_reporting(E_ALL);
define('APPLICATION_PATH', __DIR__);

header("Content-Type:text/html;charset=utf-8");
header("Access-Control-Allow-Origin:https://www.nainaiwang.com");
header("Access-Control-Allow-Origin:http://ceshi.nainaiwang.com");
header("Access-Control-Allow-Methods:POST,GET");
DEFINE('DEVICE_TYPE','pc');
$application = new Yaf\Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
