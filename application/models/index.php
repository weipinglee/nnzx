<?php
/**
 * User: maoyong
 * Date: 2016/5/17 0017
 * Time: ÏÂÎç 5:05
 */

use \Library\Query;
use \Library\M;
class indexModel {

    /**
     * 获取按信誉排行的企业用户列表
     * @param $num
     */
   public function getCreditMemberList($num){
       $memcache=new \Library\cache\driver\Memcache();
       $creditMemberList=$memcache->get('creditMemberList');
       if($creditMemberList){
           return unserialize($creditMemberList);
       }
        $obj = new Query('user as u');
       $obj->join = 'left join company_info as c on u.id=c.user_id left join user_account as ua on u.id = ua.user_id';
       $obj->fields = 'u.id,u.credit,c.company_name,ua.credit as credit_money';
       $obj->where = 'u.type=1';
       $obj->order = 'u.credit DESC';
       $obj->limit = $num;
	   $obj->cache = 'm';
       $data = $obj->find();
       $mem = new \nainai\member();
       if(!empty($data)){
           foreach($data as $k=>$v){
               $group = $mem->getUserGroup($v['id']);
               $data[$k]['group_name'] = $group['group_name'];
               $data[$k]['icon'] = $group['icon'];
           }
       }
        $memcache->set('creditMemberList',serialize($data));
       return $data;
   }

    /**
     * 获取注册的企业量
     * @return Array.num 企业量
     */
    public function getTotalCompany(){
        $memcache=new \Library\cache\driver\Memcache();
        $totalCompany=$memcache->get('totalCompany');
        if($totalCompany){
            return unserialize($totalCompany);
        }
        $mem = new M('user');
        $totalCompany=$mem->fields(' COUNT(id) as num')->where(array('type'=>1))->getObj();
        $memcache->set('totalCompany',serialize($totalCompany));
        return $totalCompany;
    }
    /*
     * 获取所有用户的数量
     * */

    public function getAllUser(){
        $memcache=new \Library\cache\driver\Memcache();
        $allUser=$memcache->get('allUser');
        if($allUser){
            return unserialize($allUser);
        }
        $userObj=new M('user');
        $allUser=$userObj->fields('count(id) as num')->getObj();
        $memcache->set('allUser',serialize($allUser));
        return $allUser;
    }


}