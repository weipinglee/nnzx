<?php
/**
 * session数据库操作类
 */

namespace Library\Session\Driver;
use \Library\M;
use \Library\tool;
/**
 * 数据库方式Session驱动
 *    CREATE TABLE user_session (
 *      session_id varchar(255) NOT NULL,
 *      session_expire int(11) NOT NULL,
 *      session_data blob,
 *      UNIQUE KEY `session_id` (`session_id`)
 *    );
 */
class Db{

    /**
     * Session有效时间
     */
   protected $lifeTime      = ''; 

    /**
     * session保存的数据库名
     */
   protected $sessionTable  = '';

    static private $hander = null;


    public function __construct($tableName,$expireTime=''){
        $this->sessionTable = $tableName;
        $this->lifeTime     = $expireTime==''?ini_get('session.gc_maxlifetime') : $expireTime;

        if(self::$hander==null)
             self::$hander = new M($this->sessionTable);
    }


    public function open(){
      return true;
    }

    public function close(){
      return true;
    }
    /**
     * 读取Session 
     * @access public 
     * @param string $sessID 
     */
   public function read($sessID) { 
       $hander = self::$hander;
       $sql = 'SELECT session_data AS data FROM '.$this->sessionTable." WHERE session_id = :session_id   AND session_expire >".time();
       $res = $hander->query($sql,array('session_id'=>$sessID),'SELECT');
       if($res !== false && count($res) > 0 ){
          return  $res[0]['data'];
       }
       return array();
   } 

    /**
     * 写入Session 
     * @access public 
     * @param string $sessID 
     * @param String $sessData  
     */
   public function write($sessID,$sessData) { 
       if(!$sessData) return false;
       $sessDB = self::$hander;
        $expire 		= 	time() + $this->lifeTime;
       $sql = 'REPLACE INTO  '.$this->sessionTable." (  session_id, session_expire, session_data)  VALUES( '$sessID', '$expire',  :sessData)";

       return $sessDB->query($sql,array('sessData'=>$sessData));
   }

    /**
     * 删除Session 
     * @access public 
     * @param string $sessID 
     */
   public function destroy($sessID) { 
       $hander 	= 	self::$hander;
       $sql = 'DELETE FROM '.$this->sessionTable." WHERE session_id = :sessID";
       return $hander->query($sql,array('sessID'=>$sessID));

   } 

    /**
     * Session 垃圾回收
     * @access public 
     * @param string $sessMaxLifeTime 
     */
   public function gc($sessMaxLifeTime='') {
       $hander 	= 	self::$hander;
       $sql = 'DELETE FROM '.$this->sessionTable.' WHERE session_expire < '.time();
       return $hander->query($sql);
   }

    /**
     * 判断是否过期
     * @param string $sessID session_id
     * @return bool true:未过期 false:已过期
     */
    public function expire($sessID){
        $hander 	= 	self::$hander;
        $data = $hander->where('session_id = :session_id AND session_expire > '.time())->bindWhere(array('session_id'=>$sessID))->getField('session_id');
        if($data==false){
            return false;
        }
        return true;
    }


}