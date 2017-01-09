<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/14 0014
 * Time: 上午 11:43
 */

namespace Library\DB;
use Library\tool;
class MYPDO {

    static private $rdb = null;//读数据库PDO对象，只可读

    static private $wdb = null;//写数据库PDO对象，可写可读

    static private $rollback = false;//是否应该回滚的标记

    //私有克隆
    private function __clone() {}


    /**
     * @brief 获取SQL语句的类型,类型：select,update,insert,delete
     * @param string $sql 执行的SQL语句
     * @return string SQL类型
     */
    private function getSqlType($sql)
    {
        $strArray = explode(' ',trim($sql),2);

        return strtoupper($strArray[0]);
    }

    /**
     * @brief 根据操作类型创建并返回dbo对象，
     * @param string $type  操作类型
     * @return PDO
     */
    private function createDB($type=''){
        if($type=='SELECT' OR $type == 'SHOW'){
            if(self::$wdb != null){
                return self::$wdb;
            }
            else if(self::$rdb != null){
                return self::$rdb;
            }
            else{
                try {
                    $db_config = tool::getConfig('database');
                    $rdb_config = $db_config['slave'];
                    $rdb_config[] = $db_config['master'];
                    $num = rand(0,count($rdb_config)-1);
                    self::$rdb = new \PDO('mysql:dbname='.$rdb_config[$num]['database'].';host='.$rdb_config[$num]['host'].';charset=utf8', $rdb_config[$num]['user'], $rdb_config[$num]['password']);
                    self::$rdb->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                } catch (\PDOException $e) {
                    exit($e->getMessage());
                }
                return self::$rdb;

            }
        }
        else{
            if(self::$wdb != null){
                return self::$wdb;
            }
            else{
                try {
                    $db_config = tool::getConfig(array('database','master'));

                    self::$wdb = new \PDO('mysql:dbname='.$db_config['database'].';host='.$db_config['host'].';charset=utf8', $db_config['user'], $db_config['password']);
                    self::$wdb->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                } catch (\PDOException $e) {
                    exit($e->getMessage());
                }
                return self::$wdb;
            }


        }
    }
    /**
     * @brief 执行一条sql
     * @param string $sql 要执行的sql语句，以:占位符形式提供,如果绑定参数有形同名字的，使用str 的where条件，使用别名
     * @param array $data 绑定的参数数组
     * @param string $type sql类型
     * @return 返回处理结果
     */
    public function exec($sql,$data=array(),$type=''){
        $sql = ltrim($sql);
        if($type==''){
            $type = $this->getSqlType($sql);

        }

        $DBlink = $this->createDB($type);

        $stmt = $DBlink->prepare($sql);

        foreach($data as $k=>$v){
            if(is_array($v)){
                $stmt->bindParam(':'.$k,$data[$k],\PDO::PARAM_LOB);//字段存数组
            }
            else {
                $stmt->bindParam(':'.$k,$data[$k]);
            }
        }

        try{
            if($res = $stmt->execute()){

                switch($type){  //根据不同的操作类型，返回数据
                    case 'SELECT' : {
                        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    }
                        break;
                    case 'UPDATE' :
                    case 'DELETE' : {
                        return $stmt->rowCount();
                    }
                        break;
                    case 'INSERT' : {
                        return $DBlink->lastInsertId();
                    }
                        break;
                    default : return $res;
                }
            }
            else{
                $this->setRollback();
            }
        }
        catch(\PDOException $e){
             exit($e->getMessage());
        }

        return false;

    }

    /**
     * 返回上次新增条目id
     * @return [type] [description]
     */
    public function lastInsertId(){
        self::$wdb->lastInsertId();
    }

    //开启事物
    public function beginTrans(){
        $this->createDB();
        self::$wdb->beginTransaction();
    }
    //事物回滚(在事物中才回滚)
    public function rollBack(){
        if($this->inTrans()){
            self::$wdb->rollBack();
        }
    }
    //事物提交(在事物中才提交)
    public function commit(){
        if($this->inTrans()){
            if($this->getRollback()===false){
                return self::$wdb->commit();
            }
            else {
                $this->rollBack();
                return false;
            }

        }else return false;

    }

    //判断是否在事物当中
    public function inTrans(){
        return self::$wdb->inTransaction();
    }

    public function setRollback(){
        self::$rollback = true;
    }
    //是否应该回滚
    public function getRollback(){
        return self::$rollback;
    }


}