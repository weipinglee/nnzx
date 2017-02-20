<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/15 0015
 * Time: 上午 9:42
 */

namespace config;
use admintool\adminQuery;
use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\Thumb;
class configsModel extends \baseModel{

    //配置表名
    protected $table = 'configs_general';

    //配置信息规则
    protected $rules = array(
        array('id','number','id错误',0,'regex'),
        array('name','/^[a-zA-Z_]{2,30}$/','配置项英文名错误',0,'regex'),
        array('name_zh','s{2,100}','配置项中文名错误',0,'regex'),
        array('type','/^[a-zA-Z_]{2,20}$/','配置项类型错误',0,'regex'),
    );

    protected $type = array(
        'jiesuan' => '结算',
        'qita' => '其他'
    );

    /**
     * 获取所有配置类型,如果传入参数获取具体的配置，如果不传，获取所有类型
     * @return array
     */
    public function getType($typeName=''){
        if($typeName!=''){
            return isset($this->type[$typeName]) ? $this->type[$typeName] : '';
        }
        return $this->type;
    }

    public function getConfigList($page=1){
        $obj = new adminQuery($this->table .' as c');
        $obj->page = $page;
        return $obj->find($this->getType());

    }









}