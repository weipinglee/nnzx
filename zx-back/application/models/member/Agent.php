<?php

namespace member;

use \Library\M;
use \Library\Query;
use \Library\Tool;

/**
 * 代理商的数据处理
 */
class agentModel extends \baseModel{


    protected $table = 'agent';
     /**
     * 添加代理商验证规程
     * @var array
     */
    protected $rules = array(
        array('username','/.{2,16}/','必须填写代理商用户名'),
        array('mobile','mobile','必须填写代理商联系方式'),
        array('company_name','require','必须填写代理商公司名称'),
        array('contact','require','必须填写代理人联系人名称'),
        array('contact_phone','require','必须填写代理人联系人联系方式'),
        array('address','require','必须填写代理人联系人地址'),
        array('status','int','必须选择状态')
    );

    /**
     * 代理商的数据处理对象
     * @var [Object]
     */
    private $_agentModel;

    public function __construct(){
    	$this->_agentModel = new M('agent');
    }

   /**
     * 获取代理商列表
     * @param  [Int]  $page     [分页]
     * @param  [String] $where [<查询的where条件>]
     * @param  [Array] $bind [<查询的where条件绑定的数据>]
     * @return [Array.list]            [代理商列表数据]
     * @return [Array.pageHtml]            [代理商分页数据]
     */
    public function getAgentList($page, $where='', $bind=array()){
    	$query = new Query('agent');
    	$query->fields = '*';
    	$query->page = $page;
    	$query->pagesize = 20;
    	$query->where = $where;
    	$query->bind = $bind;
    	$query->order = 'create_time desc';
    	$guideList = $query->find();
    	
    	return array('list' => $guideList, 'pageHtml' => $query->getPageBar());
    }


       /**
     * 获取代理商详情数据
     * @param  [Int] $id [id]
     * @return [Array]    
     */
    public function getAgentDetail($id){
    	if (intval($id) > 0) {
    		return $this->_agentModel->where('id=:id')->bind(array('id'=>$id))->getObj();
    	}
    	return array();
    }



}