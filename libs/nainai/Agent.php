<?php

namespace nainai;

use \Library\M;
use \Library\Query;
use \Library\Tool;

/**
 * 代理商的数据处理
 */
class Agent extends \nainai\Abstruct\ModelAbstract{

     /**
     * 添加代理商验证规程
     * @var array
     */
    protected $Rules = array(
        array('username','require','必须填写代理商用户名'),
        array('mobile','require','必须填写代理商联系方式'),
        array('company_name','require','必须填写代理商公司名称'),
        array('contact','require','必须填写代理人联系人名称'),
        array('contact_phone','require','必须填写代理人联系人联系方式'),
        array('address','require','必须填写代理人联系人地址'),
        array('status','int','必须选择状态')
    );



   /**
     * 获取代理商列表
     * @param  [Int]  $page     [分页]
     * @param  [Int]  $pagesize [分页]
     * @param  [String] $where [<查询的where条件>]
     * @param  [Array] $bind [<查询的where条件绑定的数据>]
     * @return [Array.list]            [代理商列表数据]
     * @return [Array.pageHtml]            [代理商分页数据]
     */
    public function getAgentList($page, $pagesize, $where='', $bind=array()){
    	$query = new Query('agent');
    	$query->fields = '*';
    	$query->page = $page;
    	$query->pagesize = $pagesize;
    	$query->where = $where;
    	$query->bind = $bind;
    	$query->order = 'create_time desc';
    	$guideList = $query->find();
    	
    	return array('list' => $guideList, 'pageHtml' => $query->getPageBar());
    }

}