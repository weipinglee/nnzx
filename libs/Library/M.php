<?php

/**
 * ????? ????Yaf?л???Model??β????????????????????????в????????????Data;
 * author: wplee
 * Date: 2016/1/28
 */

namespace Library;
use \Library\DB\DbFactory;
use \Library\cache\Cache;
class M{



	protected $db = null;//DB???

    private $tablePre = '';

	public $tableData = array();//?????????????

	private $tableName = '';

	private $whereStr = '';

	private $whereParam = array();

    private $fields   = '*';

    private $group    = '';

    private $order    = '';

    private $limit    = '';

	private $pk       = 'id';

	static private $check    = null;

	private $error   = '';

	private $cache = '';
	
	public function __construct($tableName) {
		$this->db = DbFactory::getInstance();
		$this->tableName = $this->tablePre.$tableName;
	}

	//????????
	public function pk($pk){
		$this->pk = $pk;
	}
	/**
	 * ?????????????
	 * @access public
	 * @param string $name ????
	 * @param mixed $value ?
	 * @return void
	 */
	public function __set($name,$value) {
		// ???????????????
		$this->tableData[$name]  =   $value;
	}

	/**
	 * ????????????
	 * @access public
	 * @param string $name ????
	 * @return mixed
	 */
	public function __get($name) {
		return isset($this->tableData[$name])?$this->tableData[$name]:null;
	}

	/**


	/**
	 * ????????????
	 * @access public
	 * @param string $name ????
	 * @return boolean
	 */
	public function __isset($name) {
		return isset($this->tableData[$name]);
	}

	/**
	 * ?????????????
	 * @access public
	 * @param string $name ????
	 * @return void
	 */
	public function __unset($name) {
		unset($this->tableData[$name]);
	}

	//??????????
	public function getError(){
		return $this->error;
	}

	//????????
	public function beginTrans(){
		$this->db->beginTrans();
	}
	//??????
	public function rollBack(){
		$this->db->rollBack();
	}
	//??????
	public function commit(){
		return $this->db->commit();

	}

	//???????????
	public function inTrans(){
		return $this->db->inTrans();
	}

	/**
	 * @brief ??????????????????
	 * @param $data array ???????????????
     */
	public function data($data){
		$this->tableData = $data;
		return $this;
	}

	/**
	 * ???ò??????? ?????????????
	 * @param $tableName str ????
	 * @return $this
     */
	public function table($tableName=''){
		if($tableName==''){
			return $this->tablePre.$this->tableName;
		}else{
			$this->tableName = $this->tablePre.$tableName;
			$this->clear();
			return $this;
		}
	}

	/**
	 *???????
	 *
     */
	private function clear(){
		$this->tableData = array();
		$this->whereStr = '';
		$this->whereParam = array();
		$this->fields   = '*';
		$this->group    = '';
		$this->order    = '';
		$this->limit    = ' LIMIT 500';
		$this->error = '';
	}

	/**
	 * @param $where array or str ???????
	 * @return string ????????????
	 */
	public function where($where){
		if(!isset($where))return false;
		$sql = '';
		$this->whereParam = array();//???where????
		if(is_array($where)){
			$sql .= ' WHERE ';
			foreach($where as $key=>$val){
				if(!is_array($val)){
					if($key=='_string'){
						$sql .= $val.' AND ';
					}
					else{
						$sql .= $key.' = :'.$key.' AND ';
						$this->whereParam[$key] = $val;
					}
				}
				else{
       				if($key=='_string'){
						$sql .= $val[0].' AND ';
						$this->whereParam = array_merge($this->whereParam,$val[1]);
					}
					else{
						if(isset($val[0]) && isset($val[1])){//array('neq','33')?????
							//?????????
							switch(strtolower($val[0])){
								case 'neq' : {
									$sql .= $key.' <> :'.$key.' AND ';
								}
									break;
								case 'gt' : {
									$sql .= $key.' > :'.$key.' AND ';
								}
									break;
								case 'lt' : {
									$sql .= $key.' < :'.$key.' AND ';
								}
									break;
								case 'in' : {
									$sql .= $key.' in ('.$val[1].' ) AND ';

								}

									break;
								case 'eq' :
								default : {
									$sql .= $key.' = :'.$key.' AND ';
								}
									break;

							}

							$this->whereParam[$key] = $val[1];
						}
						else{//array('neq'=>33)?????
							foreach($val as $ekey=>$v) {
								//?????????
								switch (strtolower($ekey)) {

									case 'neq' : {
										$sql .= $key . ' <> :' . $key . $ekey . ' AND ';
									}
										break;
									case 'gt' : {
										$sql .= $key . ' > :' . $key . $ekey . ' AND ';
									}
										break;
									case 'lt' : {
										$sql .= $key . ' < :' . $key . $ekey . ' AND ';
									}
										break;
									case 'eq' :
									default : {
										$sql .= $key . ' = :' . $key . $ekey . ' AND ';
									}
										break;
								}
								$this->whereParam[$key.$ekey] = $v;
							}

						}




					}
				}

			}
			$sql = substr($sql,0,-4);

		}
		else if(is_string($where)){
			$sql = ' WHERE '.$where;
		}
		$this->whereStr = $sql;
		return $this;
	}

	/**
	 * @brief ????where?????????????,where?????str??趨
	 * @param $bindArr
	 * @return $this
     */
	public function bindWhere($bindArr){
		$this->whereParam = array_merge($this->whereParam,$bindArr);
		return $this;
	}

	/**
	 * @brief ?滻bindWhere
	 * @param $bindArr
	 * @return $this
	 */
	public function bind($bindArr){
		$this->whereParam = array_merge($this->whereParam,$bindArr);
		return $this;
	}

    /**
     * @brief ???ò???????
     * @$fields array or str ??????
     */
    public function fields($fields='*'){
        if(is_string($fields))
            $this->fields = $fields;
        else if(is_array($fields)){
            $sql = '';
            foreach($fields as $key=>$val){
                $sql .= $val.',';
            }
            $sql = substr($sql,0,-1);
            $this->fields = $sql;
        }
        return $this;

    }


    /**
     *???ò??????
     * @param string $order  ??????????Σ????磺id ,id DESC
     */
    public function order($order=''){
        if($order != ''){
            $this->order = ' ORDER BY '.$order;
        }
        return $this;


    }

    /**
     * ???ò??limit
     * @param $limit str
     */
    public function limit($limit=''){
        if($limit != ''){
            $this->limit = ' LIMIT '.$limit;
        }
		else $this->limit = '';
        return $this;
    }

	/**
     * @brief ????????
	 * @param bool $trans ??????????????
	 * @return bool
     */
	public function add($trans=0) {
		$res = false;

		if(!empty($this->tableData)){
			$insData = $this->tableData;

			$insertCol = '';
			$insertVal = '';
			foreach($insData as $key => $val)
			{
				$insertCol .= '`'.$key.'`,';
				$insertVal .= ':'.$key.',';
			}
			$sql = 'INSERT INTO '.$this->tableName.' ( '.rtrim($insertCol,',').' ) VALUES ( '.rtrim($insertVal,',').' ) ';
			//echo $sql;
			$res =  $this->db->exec($sql,$this->tableData,'INSERT');
		}

		return $res;
	}

	/**
     * @brief ????????
	 * @param bool $trans ??????????????
	 * @return bool
     */

	/**
	 * ????????????????id
	 * @return [type] [description]
	 */
	public function lastInsertId(){
		return $this->db->lastInsertId();
	}

	/**
	 * ???????????
	 */
	public function adds($trans=0){
		$res = false;

		if(!empty($this->tableData)){
			$insData = $this->tableData;

			$insertCol = '';
			$insertVal = '';
			$bindData = array();
			foreach($insData as $key => $val)
			{
				$temp = '';
				if($insertCol==''){
					foreach($insData[$key] as $k=>$v){
						$insertCol .= '`'.$k.'`,';
					}
				}
				foreach($insData[$key] as $k=>$v){
					$temp .= ':'.$k.'_'.$key.',';
					$bindData[$k.'_'.$key] = $v;

				}
				$insertVal .= '('.rtrim($temp,',').'),';

			}
			$sql = 'INSERT INTO '.$this->tableName.' ( '.rtrim($insertCol,',').' ) VALUES  '.rtrim($insertVal,',');

			$res =  $this->db->exec($sql,$bindData,'INSERT');
		}

		return $res;
	}

	/**
	 * @brief ????????
	 * @param bool $trans
	 * @return bool|?????????
     */
	public function update($trans=0){
		$res = false;

		if(!empty($this->tableData) && $this->whereStr != ''){
			$sql = 'UPDATE '.$this->tableName.' SET ';
			foreach($this->tableData as $key=>$val){
				$sql .= '`'.$key.'` = :'.$key.',';
			}
			$sql = rtrim($sql,',');

			$sql .= $this->whereStr;
			$res =  $this->db->exec($sql,array_merge($this->tableData,$this->whereParam),'UPDATE');
		}
		return $res;
	}

	/**
	 * ???????
	 * @return bool|?????????
     */
	public function delete($trans=0){
		$res = false;

		if($this->whereStr != ''){
			$sql = 'DELETE FROM '.$this->tableName.$this->whereStr;
			$res =  $this->db->exec($sql,$this->whereParam,'DELETE');

		}
		return $res;
	}

    /**
     * @brief ???????????
     * @param array or string $cols ??????,?????????,??array('cols1','cols2')
     * @param array or string $orderBy ???????
     * @param array or string $desc ??????? ?: DESC:????; ASC:????;
     * @param array or int $limit ??????????? ???(500)
     * @return array ??????
     */
    public function select()
    {
    	$sql = 'SELECT '.$this->fields.' FROM '.$this->tableName. $this->whereStr.$this->order.$this->limit ;
    	
    	if ($this->cache) {
			$cacheKey = md5($sql);
			$result = $this->cache->get($cacheKey);
			if ($result) {
				return unserialize($result);
			} else {
				$result =  $this->db->exec($sql,$this->whereParam,'SELECT');
				$this->cache->set($cacheKey, serialize($result));
			}
		}
		else {
			$result =  $this->db->exec($sql,$this->whereParam,'SELECT');
		}

        return $result;
    }

    /**
     * @brief ?????????
     * @return array ?????????
     */
    public function getObj(){
        $this->limit(1);
        $sql = 'SELECT '.$this->fields.' FROM '.$this->tableName. $this->whereStr.$this->order.$this->limit ;

        $res =  $this->db->exec($sql,$this->whereParam,'SELECT');
        return empty($res) ? array() : $res[0];
    }

	/**
	 * ?????????
	 * @param string $field ???
	 * @return ?????????
     */
	public function getField($field){
		$this->limit(1)->fields($field);
		$sql = 'SELECT '.$this->fields.' FROM '.$this->tableName. $this->whereStr.$this->order.$this->limit ;
		$res =  $this->db->exec($sql,$this->whereParam,'SELECT');
		if(!empty($res))return $res[0][$field];
		return false;
	}

	/**
	 * ????????ζ???????
	 *
	 */
	public function getFields($field){
		$this->fields($field);
		$sql = 'SELECT '.$this->fields.' FROM '.$this->tableName. $this->whereStr.$this->limit ;

		$res =  $this->db->exec($sql,$this->whereParam,'SELECT');
		
		if(!empty($res)){
			$arr = array();
			foreach($res as $key=>$val){
				$arr[] = $res[$key][$field];
			}
			return $arr;
		}
		return array();
	}

    /**
     * ??????sql
     * @param $sql
     * @return ??????
     */
    public function query($sql,$param=array(),$type=''){
        $res =  $this->db->exec($sql,array_merge($this->whereParam,$param),$type);
		return $res;
    }

	/**
	 * ????????
	 * @access public
	 * @param string $field  ?????
	 * @param integer $step  ?????
	 * @return boolean
	 */
	public function setInc($field,$step=1,$trans=0) {

		if($this->whereStr!='') {
			$sql = 'UPDATE '.$this->tableName.' SET '.$field.' = '.$field.' + :step '.$this->whereStr;
			return $this->query($sql,array_merge(array('step'=>$step),$this->whereParam),'UPDATE');
		}
		return false;


	}

	/**
	 * ????????
	 * @access public
	 * @param string $field  ?????
	 * @param integer $step  ?????
	 * @return boolean
	 */
	public function setDec($field,$step=1,$trans=0) {
		if($this->whereStr!='') {
			$sql = 'UPDATE '.$this->tableName.' SET '.$field.' = '.$field.' - :step '.$this->whereStr;
			return $this->query($sql,array_merge(array('step'=>$step),$this->whereParam),'UPDATE');
		}
		else return false;

	}

	/**
	 *???????????????Ψ?????????????????????????
	 * @param array $insert ????????
	 * @param array $update ????????
	 * @param bool $trans
	 * @return 
     */
	public function insertUpdate($insert,$update,$trans=0){
		$sql = 'INSERT INTO '.$this->table();
		$insertCol = '';
		$insertVal = '';
		foreach($insert as $key => $val)
		{
			$insertCol .= '`'.$key.'`,';
			$insertVal .= ':'.$key.',';
		}
		$sql .= ' ( '.rtrim($insertCol,',').' ) VALUES ( '.rtrim($insertVal,',').' ) ON DUPLICATE KEY UPDATE';

		foreach($update as $key=>$val){
			$sql .= '`'.$key.'` = :'.$key.',';
		}
		$sql = rtrim($sql,',');
		var_dump($sql);exit;
		return $this->bind(array_merge($insert,$update))->query($sql,array(),'UPDATE');

	}
	//批量
	public function insertUpdates($insert,$update = array(),$trans=0){

		$sql = 'INSERT INTO '.$this->table();
		$insertCol = '';
		$insertVal = '';
		$bind = array();
		foreach($insert as $key => $val)
		{
			foreach ($val as $k => $v) {
				if($key == 0)
					$insertCol .= '`'.$k.'`,';
				$tmp = $k.chr($key+97);
				$insertVal .= ':'.$tmp.',';	

				$bind [$tmp] = $v;
			}
			$insertVal = rtrim($insertVal,',').'),(';
		}

		$sql .= ' ( '.rtrim($insertCol,',').' ) VALUES ( '.rtrim($insertVal,',(').($update ? ' ON DUPLICATE KEY UPDATE ':'');
		
		$bind = array_merge($bind,$update);
		foreach($update as $key=>$val){
			if($val == '+1'){
				unset($bind[$key]);
				$sql .= $key.' = '.$key.'+1,';
			}else{
				$sql .= '`'.$key.'` = :'.$key.',';
			}
		}
		$sql = rtrim($sql,',');

		return $this->bind($bind)->query($sql,array(),'UPDATE');

	}

	/**
	 * ???????
	 * @param array $rules ???????
	 * @param int $type 1 : ???? 2??????
	 * @param array $data ??????????
	 * @return bool ?????? ???????false???????$this->error???
	 */
	public function validate($rules,$data=array(),$type=''){
		$checkData = empty($data) ? $this->tableData : $data;
		if(!is_object(self::$check))
			self::$check = new check();
		return self::$check->validate($checkData,$rules,$this->error,$type,$this->pk);
	}

	/**
	 * 缓存
	 * @param  string $type   类别 m:memcached r:redis
	 * @param  int $expire 缓存时间
	 */
	public function cache($type='md',$expire=''){
		$options = $expire ? array('type'=>$type,'expire'=>$expire) : array('type'=>$type);
		$res = $this->cache = new Cache($options);
		if($res === false) $this->error = '缓存初始化失败';
		return $this;
	}



}
?>