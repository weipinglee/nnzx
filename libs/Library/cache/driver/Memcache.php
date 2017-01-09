<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2013 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 何辉 <runphp@qq.com>
// +----------------------------------------------------------------------

namespace Library\cache\driver;
/**
 * Memcached缓存驱动
 */
class Memcache extends \Library\cache\Cache {

    /**
     *
     * @param array $options
     */
    public function __construct($options = array()) {
        if ( !extension_loaded('memcache') ) {
            return '未开启扩展';
        }
        $options = array_merge(array(
            'servers'       =>  array(array('127.0.0.1',11211)),
            'lib_options'   =>  null
        ), $options);

        $this->options      =   $options;
        $this->options['expire'] =  isset($options['expire']) && $options['expire']?  $options['expire']  :   3600;
        $this->options['prefix'] =  isset($options['prefix'])?  $options['prefix']  :   "nn2_";
        $this->options['length'] =  0;//isset($options['length'])?  $options['length']  :   0;

         $this->handler      =   new \Memcache();
         $this->handler->connect('localhost', 11211);
         $options['lib_options'] && $this->handler->setOptions($options['lib_options']);
    }

    /**
     * 读取缓存
     * @access public
     * @param string $name 缓存变量名
     * @return mixed
     */
    public function get($name) {
        return $this->handler->get($this->options['prefix'].$name);
    }

    /**
     * 写入缓存
     * @access public
     * @param string $name 缓存变量名
     * @param mixed $value  存储数据
     * @param integer $expire  有效时间（秒）
     * @return boolean
     */
    public function set($name, $value, $expire = null) {
         if(is_null($expire)) {
             $expire  =  $this->options['expire'];
        }
         $name   =   $this->options['prefix'].$name;
         if($this->handler->set($name, $value,0, $expire)) {
             if($this->options['length']>0) {
        //         // 记录缓存队列
                 $this->queue($name);
             }
             return true;
         }
        return false;
    }

    /**
     * 删除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function rm($name, $ttl = false) {
         $name   =   $this->options['prefix'].$name;
         return $ttl === false ?
         $this->handler->delete($name) :
         $this->handler->delete($name, $ttl);
    }

    /**
     * 清除缓存
     * @access public
     * @return boolean
     */
    public function clear() {
        return $this->handler->flush();
    }
}
