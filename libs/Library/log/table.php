<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/17 0017
 * Time: 下午 5:43
 */

namespace Library\log;

class table{

    public static function get(){
        return  array(
            'dealer'=>'交易商认证',
            'store_manager'=>'仓库管理员认证',
            'user_group'=>'用户组',
            'user_bank' => '开户信息',
            'configs_general' => '配置表',
            'withdraw_request' => '提现申请',
            'product_category' => '商品分类',
            'product_attribute'=> '商品属性',

        );
    }

}
