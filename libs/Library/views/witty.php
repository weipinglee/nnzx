<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/16 0016
 * Time: 上午 9:28
 */

namespace Library\views;

use \Library\url;
class witty{
    /**
     * List of Variables which will be replaced in the
     * template
     *
     * @var array
     */
    protected $_tpl_vars = array();

    //模板目录
    public $_tpl_dir = '';

    protected $_layout_dir = '';

    protected $layout = '';

    //编译目录
    protected $_compile_dir = '';
    //缓存目录
    protected $_cache_dir   = '';

    protected $_tpl_ext = '.tpl';
	
	protected $_template_name = 'pc';

	//设置模板名称
	public function setTemplateName($name=''){
		$this->_template_name = $name;
	}
    /**
     *设置模板目录
     */
    public function setTplDir($dir){
        if ($this->isAbsoluteDir($dir)){//判断是否是绝对路径
            $this->_tpl_dir = $dir;
        }

    }

    /**
     * 设置布局模板目录
     */
    public function setLayoutDir($dir){
        if ($this->isAbsoluteDir($dir)) {//判断是否是绝对路径
            $this->_layout_dir = $dir;
        }
    }


    public function setLayout($str){
        if(is_string($str))
            $this->layout = $this->_layout_dir.$str;
    }

    /**
     * 设置编译目录
     */
    public function setCompileDir($dir){
        if ($this->isAbsoluteDir($dir)) {//判断是否是绝对路径
            $this->_compile_dir = $dir;
            if(!file_exists($this->_compile_dir) && !mkdir($this->_compile_dir)){
                exit('编译目录不存在');
            }
        }
    }



    /**
     * 设置缓存目录
     */
    public function setCacheDir($dir){
        if ($this->isAbsoluteDir($dir)) {//判断是否是绝对路径
            $this->_cache_dir = $dir;
            
            if(!file_exists($this->_cache_dir) && !mkdir($this->_cache_dir)){
                exit('缓存目录不存在');
            }
        }
    }

    /**
     * 判断是否是绝对路径
     * @$dir str 路径
     */
    private function isAbsoluteDir($dir){
        if (is_string($dir) && (strpos($dir,':') !==false || strpos($dir,'/') ===0)) {
            return true;
        }
        return false;
    }
    /**
     *设置要分配的变量
     * @param $name
     * @param $value
     */
    public function assign($name,$value){
        $this->_tpl_vars[$name] = $value;
    }


    /**
     * 渲染模板
     * @param $tpl  模板文件
     */
    public function render($tpl){

        $template = $this->_tpl_dir.$tpl;
        extract($this->_tpl_vars);

        if (!file_exists($template)) {
            exit('ERROR:模板文件不存在！');
        }

        $parse_file = $this->_compile_dir.md5($tpl).'.php';
        $layout_file = $this->layout.$this->_tpl_ext;
        if(!file_exists($parse_file) || (filemtime($template) > filemtime($parse_file)) || (file_exists($layout_file) && (filemtime($layout_file) > filemtime($parse_file)))){


            $content = file_get_contents($template);

            //处理layout
            $content = $this->renderLayout($layout_file,$content);

            $content = preg_replace_callback('/{include:([\/a-zA-Z0-9_\.]+)}/',array($this,'includeFile'), $content);

            $content = preg_replace_callback('/{(\/?)(\$|url|root|views|echo|foreach|set|if|elseif|else|while|for|code|areatext|img|area)\s*(:?)([^}]*)}/i', array($this,'translate'), $content);



            if (!file_put_contents($parse_file, $content) ) {
                exit('编译文件生成出错！');
            }
        }
        include($parse_file);
    }

    /**
     * 载入include标签的内容
     * @param $matches
     * @return string
     */
    private function includeFile($matches){
        return file_get_contents($this->_tpl_dir.$matches[1]);
    }
    /**
     * @brief 渲染layout
     * @param string $layoutFile 布局视图文件名
     * @param string $viewContent 视图代码块
     * @return string 编译合成后的完整视图
     */
    private function renderLayout($layoutFile,$viewContent)
    {
        if(is_file($layoutFile))
        {
            //在layout中替换view
            $layoutContent = file_get_contents($layoutFile);
            $content = str_replace('{content}',$viewContent,$layoutContent);
            return $content;
        }
        else
            return $viewContent;
    }

    /**
     * 解析模板标签
     * @param $matches
     * @return string
     */
    private function translate($matches){
        if($matches[1]!=='/')
        {
            switch($matches[2].$matches[3])
            {

                case '$':
                {
                    $str = trim($matches[4]);
                    $first = $str[0];
                    if($first != '.' && $first != '(')//排除js代码
                    {
                        if(strpos($str,')')===false)return '<?php echo isset($'.$str.')?$'.$str.':"";?>';
                        else return '<?php echo $'.$str.';?>';
                    }
                    else return $matches[0];
                }
                case 'echo:': return '<?php echo '.rtrim($matches[4],';/').';?>';

               case 'if:': return '<?php if('.$matches[4].'){?>';
                case 'elseif:': return '<?php }elseif('.$matches[4].'){?>';
                case 'else:': return '<?php }else{'.$matches[4].'?>';
                case 'set:':
                {
                    return '<?php '.$matches[4].'; ?>';
                }
                case 'while:': return '<?php while('.$matches[4].'){?>';
                case 'foreach:':
                {
                    $attr = $this->getAttrs($matches[4]);
                    if(!isset($attr['items'])) $attr['items'] = '$items';
                    if(!isset($attr['key'])) $attr['key'] = '$key';
                    if(!isset($attr['item'])) $attr['item'] = '$item';

                    return '<?php if(!empty('.$attr['items'].')) foreach('.$attr['items'].' as '.$attr['key'].' => '.$attr['item'].'){?>';
                }
                case 'for:':
                {
                    $attr = $this->getAttrs($matches[4]);
                    if(!isset($attr['item'])) $attr['item'] = '$i';
                    if(!isset($attr['from'])) $attr['from'] = 0;

                    if(!isset($attr['upto']) && !isset($attr['downto'])) $attr['upto'] = 10;
                    if(isset($attr['upto']))
                    {
                        $op = '<=';
                        $end = $attr['upto'];
                        if($attr['upto']<$attr['from']) $attr['upto'] = $attr['from'];
                        if(!isset($attr['step'])) $attr['step'] = 1;
                    }
                    else
                    {
                        $op = '>=';
                        $end = $attr['downto'];
                        if($attr['downto']>$attr['from'])$attr['downto'] = $attr['from'];
                        if(!isset($attr['step'])) $attr['step'] = -1;
                    }
                    return '<?php for('.$attr['item'].' = '.$attr['from'].' ; '.$attr['item'].$op.$end.' ; '.$attr['item'].' = '.$attr['item'].'+'.$attr['step'].'){?>';
                }

                case 'url:' : {//解析url到编译文件中，后续再访问无需再次解析
                    return url::createUrl(trim($matches[4]));
                }

                case 'views:' : {//模板目录
                    return url::getScriptDir().'/views/'.$this->_template_name.'/'.trim(trim($matches[4]),'/');
                }
                break;
                case 'root:' : {//根目录
                    return url::getScriptDir().'/'.trim(trim($matches[4]),'/');
                }
                break;
                case 'area:' : {
                    $attr = $this->getAttrs($matches[4]);
                    if(!isset($attr['data'])) $attr['data'] = '';
                     if(!isset($attr['provinceID'])) $attr['provinceID'] = 'seachprov';
                    if(!isset($attr['cityID']))$attr['cityID'] = 'seachcity';
                    if(!isset($attr['districtID']))$attr['districtID'] = 'seachdistrict';
                    if(!isset($attr['inputName'])) $attr['inputName'] = 'area';
                    if(substr($attr['data'],0,1) == '$')
                        $attr['data'] = '<?php echo '.$attr['data'].' ; ?>';

            return   <<< OEF
                <script type="text/javascript">
                 {$attr['inputName']}Obj = new Area();

                  $(function () {
                     {$attr['inputName']}Obj.initComplexArea('{$attr['provinceID']}', '{$attr['cityID']}', '{$attr['districtID']}', '{$attr['data']}','{$attr['inputName']}');
                  });
                </script>
			 <select  id="{$attr['provinceID']}"  onchange=" {$attr['inputName']}Obj.changeComplexProvince(this.value, '{$attr['cityID']}', '{$attr['districtID']}');">
              </select>&nbsp;&nbsp;
              <select  id="{$attr['cityID']}"  onchange=" {$attr['inputName']}Obj.changeCity(this.value,'{$attr['districtID']}','{$attr['districtID']}');">
              </select>&nbsp;&nbsp;<span id='{$attr['districtID']}_div' >
               <select   id="{$attr['districtID']}"  onchange=" {$attr['inputName']}Obj.changeDistrict(this.value);">
               </select></span>
               <input type="hidden"  name="{$attr['inputName']}" {$attr['pattern']} alt="{$attr['alt']}" value='{$attr['data']}' />
                <span></span>
OEF;
                }
                break;

                case 'areatext:' : {
                    $attr = $this->getAttrs($matches[4]);
                    if(!isset($attr['data'])) $attr['data'] = '';
                    if(!isset($attr['id'])) $attr['id'] = '';
                    if(!isset($attr['delimiter'])) $attr['delimiter'] = ' ';
                    if(substr($attr['data'],0,1) == '$')
                        $attr['data'] = '<?php echo '.$attr['data'].' ; ?>';
                    if(substr($attr['id'],0,1) == '$')
                        $attr['id'] = '<?php echo '.$attr['id'].' ; ?>';

                    return   <<< OEF
                    <span id="areatext{$attr['id']}">
                        <script type="text/javascript">
                         ( function(){
                            var areatextObj = new Area();
                            var text = areatextObj.getAreaText('{$attr['data']}','{$attr['delimiter']}');
                            $('#areatext{$attr['id']}').html(text);

                            })()
                        </script>
                     </span>


OEF;

                }
                break;

                case 'img:' : {
                    $attr = $this->getAttrs($matches[4]);
                    if(!isset($attr['orig'])) $attr['orig'] = '';
                    if(!isset($attr['thumb'])) $attr['thumb'] = $attr['orig'];
                    if(!isset($attr['data'])) $attr['data'] = '';
                    if(!isset($attr['width'])) $attr['width'] = '';
                    if(!isset($attr['height'])) $attr['height'] = '';
                    if(substr($attr['thumb'],0,1) == '$')
                        $attr['thumb'] = '<?php echo '.$attr['thumb'].' ; ?>';
                    if(substr($attr['orig'],0,1) == '$')
                        $attr['orig'] = '<?php echo '.$attr['orig'].' ; ?>';
                    if($attr['orig'] )
                        return <<< OEF
                         <a target="_blank" href="{$attr['orig']}"><img src="{$attr['thumb']}" /></a>
OEF;

                    if($attr['data'])
                    return   '
                    <?php if('.$attr['data'].')$org=\Library\Thumb::getOrigImg('.$attr['data'].');
                    if('.$attr['width'].' && '.$attr['height'].')
                    $thumb = \Library\Thumb::get('.$attr['data'].','.$attr['width'].','.$attr['height'].');
                    else $thumb = $org ;
                    ?>
                    <a target="_blank" href="<?php echo $org ;?>"><img src="<?php echo $thumb ;?>" /></a>
';

                }
                break;


                default:
                {
                    return $matches[0];
                }
            }
        }
        else
        {
            if($matches[2] =='code') return '?>';
            else return '<?php }?>';
        }
    }

    /**
     * @brief 分析标签属性
     * @param string $str
     * @return array以数组的形式返回属性值
     */
    private function getAttrs($str)
    {
        preg_match_all('/\w+\s*=(?:[^=]+?)(?=(\S+\s*=)|$)/i', trim($str), $attrs);
        $attr = array();
        foreach($attrs[0] as $value)
        {
            $tem = explode('=',$value);
            $attr[trim($tem[0])] = trim($tem[1]);
        }
        return $attr;
    }

    /**
     * @brief 变量替换操作
     * @param string $str
     * @return string
     */
    protected function varReplace($str)
    {
        return preg_replace(array("#(\\$.*?(?=$|\/))#","#(\\$\w+)\[(\w+)\]#"),array("\".$1.\"","$1['$2']"),$str);
    }
	

}