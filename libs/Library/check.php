<?php

/**
 * User: weipinglee
 * Date: 2016/2/26 0026
 * Time: 下午 2:13
 */
namespace Library;
class check
{

    // 操作状态
    const MODEL_INSERT          =   1;      //  插入模型数据
    const MODEL_UPDATE          =   2;      //  更新模型数据
    const MODEL_BOTH            =   3;      //  包含上面两种方式 默认

    const EXISTS_VALIDATE       =   0;      // 表单存在字段则验证 默认
    const MUST_VALIDATE         =   1;      // 必须验证
    const VALUE_VALIDATE        =   2;      // 表单值不为空则验证

    protected $tableData   = '';


    /**
     * 使用正则验证数据from thinkphp
     * @access public
     * @param string $value  要验证的数据
     * @param string $rule 验证规则
     * @return boolean
     */
    public function regex($value,$rule) {
        $validate = array(
            'require'   =>  '/\S+/',
            'mobile'    =>  '/^1[2|3|4|5|6|7|8|9][0-9]\d{8}$/',
            'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
            'currency'  =>  '/^(([1-9][0-9]{0,7})|0)(\.\d{0,2})?$/',
            'number'    =>  '/^\d+$/',
            'zip'       =>  '/^\d{6}$/',
            'int'   =>  '/^[-\+]?\d+$/',
            'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',
            'english'   =>  '/^[A-Za-z]+$/',
            'date'      =>  '/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/i',
            'datetime'  =>  '/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29) (?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9])$/i',
            'zh'        =>  '/^[\x{4E00}-\x{9FFF}\x{f900}-\x{fa2d}]{m,n}$/u',
            's'         =>  '/^[\x{4E00}-\x{9FFF}\x{f900}-\x{fa2d}\w\.\s]{m,n}$/u',//匹配中文、字母、数字、下划线、点、不可见字符
            'identity'  =>  '/^\d{14,17}(\d|x)$/i',
        );
        // 检查是否有内置的正则表达式
        if(isset($validate[strtolower($rule)]))
            $rule       =   $validate[strtolower($rule)];
        else{
            $pos = strpos(strtolower($rule),'{');
            if($pos!==false && isset($validate[substr(strtolower($rule),0,$pos)])){//匹配内置的限制位数的正则
                $rule = str_replace('{m,n}',substr(strtolower($rule),$pos),$validate[substr($rule,0,$pos)]);
            }
        }
       return preg_match($rule,$value)===1;
    }

    /**
     * 表单验证
     * @access protected
     * @param array $data 验证数据
     * @param array $rules 验证规则 数组中包含若干个验证因子 array(field,rule,message,[condition,type,when])
     * @param string $error 错误信息
     * @param string $type 创建类型，1：插入 2：更新
     * @param string $pk 主键
     * @return boolean
     */
    public function validate($data,$rules,&$error,$type='',$pk='id') {
        if(empty($data))return false;
        $this->tableData = $data;
        $type = $type?:(!empty($data[$pk])?self::MODEL_UPDATE:self::MODEL_INSERT);
        foreach($rules as $key=>$val) {
            // 验证因子定义格式
            // array(field,rule,message,condition,type,when,params)
            // 判断是否需要执行验证
            if(empty($val[5]) || ( $val[5]== self::MODEL_BOTH && $type < 3 ) || $val[5]== $type ) {

                $val[3]  =  isset($val[3])?$val[3]:self::EXISTS_VALIDATE;
                $val[4]  =  isset($val[4])?$val[4]:'regex';
                // 判断验证条件
                switch($val[3]) {
                    case self::MUST_VALIDATE:   // 必须验证 不管表单是否有设置该字段
                        if(false === $this->_validationField($error,$val))
                            return false;
                        break;
                    case self::VALUE_VALIDATE:    // 值不为空的时候才验证
                        if(isset($data[$val[0]]) && '' != trim($data[$val[0]]))
                            if(false === $this->_validationField($error,$val))
                                return false;
                        break;
                    default:    // 默认表单存在该字段就验证
                        if(isset($data[$val[0]]))
                            if(false === $this->_validationField($error,$val))
                                return false;
                }
            }
        }

        return true;
    }

    /**
     * 验证表单字段 支持批量验证
     * 如果批量验证返回错误的数组信息
     * @access protected
     * @param array $val 验证因子
     * @return boolean
     */
    protected function _validationField(&$error,$val) {
        if(false === $this->_validationFieldItem($val)){
            $error = $val[2];
            return false;
        }
        return true;
    }

    /**
     * 根据验证因子验证字段
     * @access protected
     * @param array $val 验证因子
     * @return boolean
     */
    protected function _validationFieldItem($val) {
        $data = $this->tableData;
        switch(strtolower(trim($val[4]))) {
            case 'function':// 使用函数进行验证
            case 'callback':// 调用方法进行验证
                $args = isset($val[6])?(array)$val[6]:array();
                if(is_string($val[0]) && strpos($val[0], ','))
                    $val[0] = explode(',', $val[0]);
                if(is_array($val[0])){
                    // 支持多个字段验证
                    foreach($val[0] as $field)
                        $_data[$field] = $data[$field];
                    array_unshift($args, $_data);
                }else{
                    array_unshift($args, $data[$val[0]]);
                }
                if('function'==$val[4]) {
                    return call_user_func_array($val[1], $args);
                }else{
                    return call_user_func_array(array(&$this, $val[1]), $args);
                }
            case 'confirm': // 验证两个字段是否相同
                return $data[$val[0]] == $data[$val[1]];

            default:  // 检查附加规则
            {
                return $this->checkData($data[$val[0]],$val[1],$val[4]);

            }
        }
    }

    /**
     * 验证数据 支持 in between equal length regex expire ip_allow ip_deny
     * @access public
     * @param string $value 验证数据
     * @param mixed $rule 验证表达式
     * @param string $type 验证方式 默认为正则验证
     * @return boolean
     */
    public function checkData($value,$rule,$type='regex'){
        $type   =   strtolower(trim($type));
        switch($type) {
            case 'in': // 验证是否在某个指定范围之内 逗号分隔字符串或者数组
            case 'notin':
                $range   = is_array($rule)? $rule : explode(',',$rule);
                return $type == 'in' ? in_array($value ,$range) : !in_array($value ,$range);
            case 'between': // 验证是否在某个范围
            case 'notbetween': // 验证是否不在某个范围
                if (is_array($rule)){
                    $min    =    $rule[0];
                    $max    =    $rule[1];
                }else{
                    list($min,$max)   =  explode(',',$rule);
                }
                return $type == 'between' ? $value>=$min && $value<=$max : $value<$min || $value>$max;
            case 'equal': // 验证是否等于某个值
            case 'notequal': // 验证是否等于某个值
                return $type == 'equal' ? $value == $rule : $value != $rule;
            case 'length': // 验证长度
                $length  =  mb_strlen($value,'utf-8'); // 当前数据长度
                if(strpos($rule,',')) { // 长度区间
                    list($min,$max)   =  explode(',',$rule);
                    return $length >= $min && $length <= $max;
                }else{// 指定长度
                    return $length == $rule;
                }
            case 'expire':
                list($start,$end)   =  explode(',',$rule);
                if(!is_numeric($start)) $start   =  strtotime($start);
                if(!is_numeric($end)) $end   =  strtotime($end);
                return time::getTime() >= $start && time::getTime() <= $end;
            case 'ip_allow': // IP 操作许可验证
                return in_array(Client::getIp(),explode(',',$rule));
            case 'ip_deny': // IP 操作禁止验证
                return !in_array(Client::getIp(),explode(',',$rule));
            case 'regex':
            default:    // 默认使用正则验证 可以使用验证类中定义的验证名称
                // 检查附加规则
              {

                  return $this->regex($value,$rule);
              }

        }
    }
}