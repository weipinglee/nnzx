<?php
/**
 * @file query_class.php
 * @brief 系统统一查询类文件，处理复杂的查询问题
 * @date 2010-12-17
 * @version 0.6
 * @note
 */
/**
 * @brief IQuery 系统统一查询类
 * @class IQuery
 * @note
 */
namespace Library;
use \Library\DB\DbFactory;
use \Library\Page;
use \Library\cache\Cache;
class Query
{
	public  $db       = null;
	private $sql      = array('table'=>'','fields'=>'*','where'=>'','bind'=>array(),'join'=>'','group'=>'','having'=>'','order'=>'',
								'limit'=>' ','distinct'=>'');
	private $tablePre = '';
	private $cache    = null;
	public  $paging   = null;

    /**
     * @brief 构造函数
     * @param string $name 表名
     */
	public function __construct($name)
	{
		//$this->tablePre = isset(IWeb::$app->config['DB']['tablePre'])?IWeb::$app->config['DB']['tablePre']:'';
		$this->table = $name;
		$this->db = DbFactory::getInstance();
	}
    /**
     * @brief 给表添加表前缀
     * @param string $name 可以是多个表名用逗号(,)分开
     */
	public function setTable($name)
	{
		if(strpos($name,',') === false)
		{
			$this->sql['table']= $this->tablePre.$name;
		}
		else
		{
			$tables = explode(',',$name);
			foreach($tables as $key=>$value)
			{
				$tables[$key] = $this->tablePre.trim($value);
			}
			$this->sql['table'] = implode(',',$tables);
		}
	}
    /**
     * @brief 取得表前缀
     * @return String 表前缀
     */
    public function getTablePre()
    {
        return $this->tablePre;
    }
    /**
     * @brief 设置where子句数据
     * @return String
     */
    public function setWhere($str)
    {
        $this->sql['where']= 'where '.preg_replace('/from\s+(\S+)/i',"from {$this->tablePre}$1 ",$str);
    }
    /**
     * @brief 取得where子句数据
     * @return String
     */
    public function getWhere()
    {
    	return ltrim($this->sql['where'],'where');
    }
    /**
     * @brief 实现属性的直接存
     * @param string $name
     * @param string $value
     */
    private function setJoin($str)
    {
		$this->sql['join'] = preg_replace('/(\w+)(?=\s+as\s+\w+(,|\)|\s))/i',"{$this->tablePre}$1 ",$str);
    }
	public function __set($name,$value)
	{
		switch($name)
		{
			case 'table':$this->setTable($value);break;
			case 'fields':$this->sql['fields'] = $value;break;
			case 'where':$this->setWhere($value);break;
			case 'join':$this->setJoin($value);break;
			case 'group':$this->sql['group'] = 'GROUP BY '.$value;break;
			case 'having':$this->sql['having'] = 'having '.$value;break;
			case 'order':$this->sql['order'] = 'order by '.$value;break;
			case 'limit':$value == 'all' ? ($this->sql['limit'] = '') : ($this->sql['limit'] = 'limit '.$value);break;
            case 'page':$this->sql['page'] =intval($value); break;
            case 'pagesize':$this->sql['pagesize'] =intval($value); break;
            case 'pagelength':$this->sql['pagelength'] =intval($value); break;
			case 'distinct':
			{
				if($value)$this->sql['distinct'] = 'distinct';
				else $this->sql['distinct'] = '';
				break;
			}
			case 'cache':
			{
				$this->cache = new Cache($value);
			}
			break;
			case 'bind':$this->sql['bind'] = $value;
			break;
		}
	}
    /**
     * @brief 实现属性的直接取
     * @param mixed $name
     * @return String
     */
	public function __get($name)
	{
		if(isset($this->sql[$name]))return $this->sql[$name];
	}

    public function __isset($name)
    {
        if(isset($this->sql[$name]))return true;
    }

	public function __unset($name){
		if(isset($this->sql[$name]))
			$this->sql[$name] = null;
	}
    /**
     * @brief 取得查询结果
     * @return array
     */
	public function find()
	{
		if (is_int($this->page)) {
			$sql = "select $this->distinct $this->fields from $this->table $this->join $this->where $this->group $this->having $this->order";

			$pagesize = isset($this->pagesize) ? intval($this->pagesize) : 20;
			$pagelength = isset($this->pagelength) ? intval($this->pagelength) : 10;
			$count = $this->getPageCount($sql);

			$this->paging = new Page($count, $pagesize, $pagelength);
			$this->paging->cache = $this->cache;
            $limit = $this->paging->getPageLimit($this->page, $p);
			$sql .=$limit;
            if ($p == 1) {return array();}//$this->page = 0;
            
			return $this->getSqlResult($sql);
		} else {
			$sql = "select $this->distinct $this->fields from $this->table $this->join $this->where $this->group $this->having $this->order $this->limit";
			
			return $this->getSqlResult($sql);
		}
	}

	/**
	 * 根据sql返回查询结果
	 * @param string $sql
	 * @return array 返回处理结果
     */
	private function getSqlResult($sql){
		//开启缓存
		if ($this->cache) {
			$cacheKey = md5($sql);
			$result = $this->cache->get($cacheKey);
			if ($result) {
				return unserialize($result);
			} else {
				$result = $this->db->exec($sql, $this->sql['bind'], 'SELECT');
				$this->cache->set($cacheKey, serialize($result));
			}
		} //关闭缓存
		else {
			$result = $this->db->exec($sql, $this->sql['bind'], 'SELECT');
		}
		return $result;
	}
		/**
		 * 获取页面总数
		 * @param string $sql 查询的sql语句
		 */
	private function getPageCount($sql){

		if(strpos($sql,'GROUP BY') === false)
		{

			$endstr = strstr($sql,'from');

			$endstr = preg_replace('/^(.*)order\s+by.+$/i','$1',$endstr);
			// $count=$this->db->exec("select count(*) as total ".$endstr,$this->sql['bind'],'SELECT');
			$res=count($this->db->exec($sql,$this->sql['bind'],'SELECT'));
			$count[0]['total'] = $res;
		}
		else
		{
			$count=$this->db->exec("select count(*) as total from (".$sql.") as IPaging",$this->sql['bind'],'SELECT');
		}
		return isset($count[0]['total']) ? $count[0]['total'] : 0;

	}
	/**
	 * @brief 取一条结果
	 */
	public function getObj(){
		$this->limit = 1;
		$res = $this->find();
		return count($res)>0 ? $res[0] : array();
	} 
	/**
	 * @brief 分页展示
	 * @param string $url   URL地址
	 * @param string $attrs URL后接参数
	 * @return string pageBar的对应HTML代码
	 */
    public function getPageBar($url='',$attrs='')
    {
        return $this->paging->getPageBar($url,$attrs);
    }

    public function cache($key)
    {
    	if($this->cache)
    	{
    		$this->cache->get($key);
    	}
    	return null;
    }
}