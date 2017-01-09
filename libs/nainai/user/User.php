<?php
namespace nainai\user;

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;

/**
 * 用户对应的api
 * @author maoyong.zeng
 * @copyright 2016年05月30日
 */
class User extends \nainai\Abstruct\ModelAbstract {

    /**
     * 会员状态，正常
     */
    const NOMAL = 0;
    /**
     * 会员状态，删除
     */
    const DELETE = 2;
    /**
     * 会员状态，锁定挂起
     */
    const LOCK = 1;

	
     /**
      * 获取id对应的用户名
      * @param  Array $where  查询条件 
      * @return array    
      */
     public function getNamesList($where){
          $names = array();
          if (!empty($where)) {
               $where = ' id IN (' . implode(',', $where). ')';
               $list = $this->model->where($where)->fields('id, username')->select();
               
               foreach ($list as $key => $value) {
                    $names[$value['id']] = $value['username'];
               }
          }
          return $names;
     }

     public function getSubaccList($user_id){
        $Q = new \Library\searchQuery($this->tableName);
        $Q->fields = 'id, username, mobile, email, create_time, status';
        $Q->where = 'pid=:user_id AND status IN ('.self::NOMAL.','.self::LOCK.') ';
        $Q->bind = array('user_id' => $user_id);
        $lists = $Q->find();
        foreach ($lists['list'] as $key => &$value) {
          if ($value['status'] == self::NOMAL) {
            $value['status_text'] = '正常';
          }elseif($value['status'] == self::LOCK){
            $value['status_text'] = '异常';
          }
        }
        return $lists;
     }

}