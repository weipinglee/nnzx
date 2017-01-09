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
        'user_bank' => array(
            'time'=>array('b.apply_time','申请时间'),
            'like' => array('u.username,b.identify_no','用户名，身份证号'),
            'down' => 1
        ),

        'recharge_order' => array(
            'time'=>array('r.create_time','申请时间'),
            'like' => array('r.order_no,u.username,u.user_no','用户名，订单号，会员号'),
            'down' => 1
        ),
        'withdraw_request' => array(
            'time'=>array('w.create_time','申请时间'),
            'like' => array('w.request_no,u.username,u.user_no','用户名，订单号，会员号'),
            'down' => 1
        ),
        'user_account' => array(
            'like' => array('u.mobile,u.username,u.user_no','用户名，手机号,会员号'),
            'between' => array('a.credit','信誉保证金'),
            'down' => 1
        ),
        'configs_general' => array(
            'like'=>array('c.name,c.name_zh','英文名，中文名'),
            'select'=> array('c.type','配置类型')
        ),
        'order_sell' => array(
            'time'=>array('do.create_time','提货时间'),
            'likes' => array('o.order_no, p.name', '订单号,商品名称'),
            'down' => 1
        ),
        'product_offer' => array(
            'time'=>array('o.apply_time','创建时间'),
            'select' => array('o.mode','报盘类型'),
            'like'=>array('o.id,p.name','报盘id,商品名称'),
            'down' => 1
        ),
        'user'       => array(
            'like' => array('u.username,u.email,u.mobile','用户名、手机号、邮箱'),
            'likes' => array('p.true_name, c.company_name','真实姓名,企业名称'),
            'select'=> array('u.yewu','业务员'),
            'down' => 1
        ),
        'dealer' => array(
            'time' => array('c.apply_time','申请时间'),
            'like' => array('u.username,u.mobile','用户名，手机号'),
            'select' => array('u.type','用户类型'),
            'down' => 1
        ),
        'store_manager' => array(
            'time' => array('c.apply_time','申请时间'),
            'like' => array('u.username,u.mobile','用户名，手机号'),
            'select' => array('u.type','用户类型'),
            'down' => 1
        ),
        'order_complain' => array(
            'time' => array('a.apply_time','申请时间'),
            'like' => array('c.username', '申述用户'),
            'select' => array('a.type','申述类型')
        ),
        'admin' => array(
            'like' => array('a.name','用户名'),
            'down' => 1
        ),
        'apply_resetpay' => array(
             'time' => array('r.apply_time','申请时间'),
        ),
         'apply_resettel' => array(
             'time' => array('r.apply_time','申请时间'),
        ),
        'payto_market' => array(
            'like' => array('u.username','用户名'),
            'down' => 1
        ),
        'admin_alerted_record' => array(
            'like' => array('a.name','管理员用户名'),
            'time' => array('ar.record_time','预警时间')
        ),

        'user_log' => array(
            'like'=>array('u.username','用户名'),
            'down' => 1
        ),
        'user_alerted_record' => array('like' => array('u.username','用户名'),
            'time' => array('r.record_time','预警时间'),

            ),
        'product_attribute' => array(
            'like' => array('name','名称'),
             'select' => array('type','类型')
        ),
        'store_products' => array(
            'time' => array('a.sign_time','签发时间'),
            'like' => array('c.name','商品名称'),
            'likes' => array('b.name,a.store_pos,c.quantity', '仓库名称,库位,库存'),
            'select' => array('a.status','状态'),
        ),
        'store_list' => array(
            'like' => array('name','仓库名称')
        ),
        'entrust_setting' => array(
            'like' => array('b.name','商品类别')
        ),
         'deal_total' => array(
            'like' => array('u.username','用户名')
        )
    );

    public static function config($tableName=''){
        return isset(self::$config_arr[$tableName]) ? self::$config_arr[$tableName] : array() ;
    }
}