<?php
/**
 * 后台的列表查询类
 * User: Administrator
 * Date: 2016/7/14 0014
 * Time: 下午 12:42
 */
namespace Library;
class searchQuery extends Query{


    private $down = 0;//是否导出

    /**
     * 获取列表数据，返回页面显示信息
     * @param array $selectData 查询选择框的数据
     * @return array list:列表数据，bar:分页条,search:搜索区显示内容
     */
    public function find($selectData=array()){
        $table = ltrim($this->table,' ');
        $table = explode(' ',$table);
        $table = $table[0];
        $cond = $this->getWhereCond($table);
        $search = '';
        if(!empty($cond)){
            if($cond[0]['where']){
                if($this->getWhere())
                    $this->where = $this->getWhere(). ' AND '.$cond[0]['where'];
                else
                    $this->where = $cond[0]['where'];
                $this->bind = array_merge($this->bind,$cond[0]['bind']);
            }
            $search = $cond[1];
            if(isset($search['select'])){
                $search['selectData'] = $selectData;
            }
        }
        if (isset($cond[0]['down']) && $cond[0]['down'] == 1) {//如果是导出
            $this->down = 1;
            unset($this->page);
        }else if(!isset($this->page) || !$this->page){ //如果没有定义分页，在这里定义
            $this->page = $cond[0]['page'];
            
        }
        
        if (intval($this->pagesize) == 0) {
            $this->pagesize = 20;
        }
        $list = parent::find();
        $result = array('list' => $list, 'search'=>$search);
        if (!isset($cond[0]['down']) ||$cond[0]['down'] == 0) {
            $bar = $this->getPageBar();
            $result['bar'] = $bar;
        }

        return $result;
    }
    /**
     * 获取搜索条件
     * @param $condArr
     *  array(
    'time'=>'b.apply_time',
    'like' => 'u.username,b.identify_no',
    'status' => 'b.status'
    );
     * @return array
     */
    public static function getWhereCond($tableName){
        if(!$tableName)
            return array();
        $configArr = \conf\searchConfig::config($tableName);
        
        if(empty($configArr))
            return array();
        $condArr = $search = array();
        foreach($configArr as $k=>$v){
            if($k=='down'){
                $search[$k] = $v;
            }elseif ($k == 'likes') {
                $keys = explode(',', $v[0]);
                $vals = explode(',', $v[1]);
                $search['likes'] = $news = array();
                foreach ($keys as $key => $str) {
                    $news[$key] = substr($str, strpos($str, '.') + 1);
                    $search['likes'][$news[$key]] = $vals[$key];
                }
            }else{
                $condArr[$k] = $v[0];
                $search[$k] = $v[1];
            }

        }

        $page = safe::filterGet('page', 'int', 0);
        $begin = safe::filterGet('begin');
        $end = safe::filterGet('end');
        $name = safe::filterGet('like');
        $status = safe::filterGet('status');
        //选择查询
        $select = safe::filterGet('select');

        //区间查询
        $min = safe::filterGet('min','float',0);
        $max = safe::filterGet('max','float',0);
        $down = safe::filterGet('down', 'int', 0);//是否导出
        $cond  = array();

        $cond['down'] = $down;
        $cond['where'] =  $temp = '';$cond['bind'] = array();
        $cond['page'] = $page;

        if (!empty($news)) {
            $search['likesval'] = array();
            foreach ($news as $key => $value) {
                $tempval = safe::filterGet($value);
                $search['likesval'][$value] = $tempval;
                if (!empty($tempval)) {
                    if($cond['where']!='')
                        $temp = ' AND ';
                    $cond['where'] .= $temp .$keys[$key].' LIKE "%' .$tempval. '%"';
                }
            }
        }

        if($begin && isset($condArr['time'])){
            if($cond['where']!='')
                $temp = ' AND ';
            $cond['where'] .= $temp."  {$condArr['time']} >= :begin";
            $cond['bind']['begin'] = $begin ;
        }
        if($end && isset($condArr['time'])){
            if($cond['where']!='')
                $temp = ' AND ';
            $cond['where'] .= $temp." {$condArr['time']} <= :end";
            $cond['bind']['end'] = $end;
        }
        if($status && isset($condArr['status'])){
            if($cond['where']!='')
                $temp = ' AND ';
            $cond['where'] .= $temp." {$condArr['status']} = :status";
            $cond['bind']['status'] = $status;
        }
        if($name && isset($condArr['like']) && count($condArr['like'])>0){
            $like = explode(',',$condArr['like']);
            if($cond['where']!='')
                $temp = ' AND ';
            $likeWhere = '';
            foreach($like as $l){
                $likeWhere .= '  '.$l .' like :like OR ';
            }
            $likeWhere = substr($likeWhere,0,-3);
            $cond['where'] .= $temp." ( {$likeWhere} )";
            $cond['bind']['like'] = "%{$name}%";
        }

        if(isset($_GET['select']) && $select!='all' && isset($condArr['select'])){
            if($cond['where']!='')
                $temp = ' AND ';
            $cond['where'] .= $temp." {$condArr['select']} = :select";
            $cond['bind']['select'] = $select;
        }

        //区间查询条件，只能是数字
        if($min && isset($condArr['between'])){
            if($cond['where']!='')
                $temp = ' AND ';
            $cond['where'] .= $temp." {$condArr['between']} >= :min";
            $cond['bind']['min'] = $min;
        }
        if($max && isset($condArr['between'])){
            if($cond['where']!='')
                $temp = ' AND ';
            $cond['where'] .= $temp." {$condArr['between']} <= :max";
            $cond['bind']['max'] = $max;
        }
        return array($cond,$search);
    }


    /**
     * 导出操作
     * @param array $list 列表
     * @param string $type 导出的数据类型 在downconfig里配置
     * @param string $name 文件名称
     * @return bool
     */
    public function downExcel($list=array(), $type='',$name=''){
        if (is_array($list) && !empty($list) && $this->down) {

            $excel = array();
            if($type)
                $excel[0] = \conf\Downconfig::getConfig($type);
            else{
                $table = ltrim($this->table,' ');
                $excel[0] = \conf\Downconfig::getConfig($table);
            }
            if (empty($excel[0])) {
                exit();
            }
            $keys = array_keys($excel[0]);
            $count = count($keys);
            foreach ($list as $key => $value) {
                $item = array();
                for ($i=0; $i < $count; $i++) {
                    $item[$keys[$i]] = $value[$keys[$i]];
                }
                array_push($excel, $item);
            }

            $obj = new \Library\Excel\ExcelHtml();
            $fileName =  $name .  '信息报表';
            $obj->createExecl($excel, $count,  $fileName);
            exit();
        }

        return false;
    }

}

