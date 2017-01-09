<?php
/**
 * 获取配置参数
 * User: Administrator
 * Date: 2016/7/15 0015
 * Time: 下午 1:47
 */
namespace nainai;
use Library\M;

class configs{

    protected static $table  = 'configs_general';
    public static function getConfigsByType($type){
        if($type){
            $obj = new M(self::$table);
            $data = $obj->where(array('type'=>$type))->fields('name_zh,value')->select();
            return $data;
        }
        return array();
    }
}