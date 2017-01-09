<?php
/**
 * 搜索配置项
 * User: weipinglee
 * Date: 2016/7/21
 * Time: 上午 11:13
 */

namespace conf;
class searchConfig {

    private static $config_arr = array(
        'order_sell' => array(
            'time'=>array('do.create_time','生成时间'),
            'like' => array('do.order_no','合同号'),
        ),
        'store_products' => array(
            'time' => array('a.apply_time','创建时间'),
            'like' => array('c.name','商品名称'),
            'select' => array('a.status','状态')
        ),
        'order_complain' => array(
            'time' => array('a.apply_time','申请时间'),
            'like' => array('b.order_no','订单号'),
        ),
        'user' => array(
            'time' => array('create_time','创建时间'),
            'like' => array('username','用户名'),
        ),
         'user_log' => array(
            'like' => array('username','用户名'),
        )

    );

    public static function config($tableName=''){
        return isset(self::$config_arr[$tableName]) ? self::$config_arr[$tableName] : array() ;
    }
}