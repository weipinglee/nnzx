<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/18 0018
 * Time: 上午 9:28
 */
namespace Library;
class tool{

    //全局配置
    private static $globalConfigs = array();
    /**
     * 获取application.ini中的配置项，并转化为数组
     * @param string $name 配置名称
     * @return mix 如果没有改配置信息则返回null
     */
    public static function getConfig($name=null){
        $configObj = \Yaf\Registry::get("config");
        if($configObj===false){
            $configObj = \Yaf\Application::app()->getConfig();
        }
        if($name!=null){
            if(!is_array($name)){
                $configObj = isset($configObj->$name) ? $configObj->$name : null;
            }
            else{
                foreach($name as $v){
                    if($configObj==null)break;
                    $configObj = isset($configObj->$v) ? $configObj->$v : null;
                }
            }

        }
        if(is_object($configObj))
            return $configObj->toArray();
        else if(is_null($configObj))
            return array();
        else return $configObj;
    }

    public static function getBasePath(){
        return APPLICATION_PATH.'/public/';
    }

    /**
     * 将图片路径加上@当前系统名
     * @param string $imgSrc 图片相对路径
     * @return string
     */
    public static function setImgApp($imgSrc){
        $name = self::getConfig(array('application','name'));
        if(!is_string($name)){
            $name = '';
        }
        return ($imgSrc!='' && strpos($imgSrc,'@')===false) ? $imgSrc.'@'.$name : $imgSrc;

    }

    //获取全局配置信息
    public static function getGlobalConfig($name=null){
        if(empty(self::$globalConfigs)){
            self::$globalConfigs = require 'configs.php';
        }

        if($name==null)
            return self::$globalConfigs;
        elseif(is_string($name))
            return isset(self::$globalConfigs[$name]) ?self::$globalConfigs[$name] : null ;
        else if(is_array($name)){
            $temp = self::$globalConfigs;
            foreach($name as $v){
                if(isset($temp[$v])){
                    $temp = $temp[$v];
                }
                else return null;
            }
            return $temp;
        }
    }

    public static function getSuccInfo($res=1,$info='',$url='',$id=''){
        return array('success'=>$res,'info'=>$info,'returnUrl'=>$url,'id'=>$id);
    }

    public static function create_uuid($user_id = 0){
        return date('YmdHis',time()).$user_id.substr(-1,3,time()).mt_rand(0,99);
    }

    //uuid
    // public static function create_uuid(){
    //     if (function_exists('com_create_guid')){
    //         return com_create_guid();
    //     }else{
    //         mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    //         $charid = strtoupper(md5(uniqid(rand(), true)));
    //         $hyphen = chr(45);// "-"
    //         $uuid = substr($charid, 0, 8).$hyphen
    //                 .substr($charid, 8, 4).$hyphen
    //                 .substr($charid,12, 4).$hyphen
    //                 .substr($charid,16, 4).$hyphen
    //                 .substr($charid,20,12);
    //         return $uuid;
    //     }
    // }

    public static function pre_dump($data){
        echo '<pre>';

        print_r($data);
        echo '</pre>';
    }

    public static function getIP() { 
        if (getenv('HTTP_CLIENT_IP')) { 
            $ip = getenv('HTTP_CLIENT_IP'); 
        } 
        elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
            $ip = getenv('HTTP_X_FORWARDED_FOR'); 
        } 
        elseif (getenv('HTTP_X_FORWARDED')) { 
            $ip = getenv('HTTP_X_FORWARDED'); 
        } 
        elseif (getenv('HTTP_FORWARDED_FOR')) { 
            $ip = getenv('HTTP_FORWARDED_FOR'); 

        } 
        elseif (getenv('HTTP_FORWARDED')) { 
            $ip = getenv('HTTP_FORWARDED'); 
        } 
        else { 
            $ip = $_SERVER['REMOTE_ADDR']; 
        } 

        if($ip == '::1')
            $ip = '127.0.0.1';
        return $ip; 
    } 

    public static function explode($str){
        return isset($str) && $str ? (strpos($str,',') ? explode($str,',') : array($str) ): array();
    }

}