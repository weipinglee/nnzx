<?php
/**
 * url管理类,基于yaf路由
 * User: weipinglee
 * Date: 2016/2/17 0017
 * Time: 上午 9:25
 */
namespace Library;
use \Library\tool;
class url {

    /**
     * 根据不同路由规则产生url
     * @param string $str 形如：'cli/test/index?key=value&key1=value2@deal '的字符串，如果第一个字符是‘/’,表示module为index,
     * 如果不是‘/’，第一个'/'前的部分是module,后面以'/'分割的依次是控制器、方法,如果缺失/则默认为index,?后面的是参数对，@后面的是主机名
     * 注意:必须是//?@的顺序，/可以是一个或0个
     * @param string $baseUrl 站点路径 如果传递次参数 会忽略$str中@后面的内容
     * @return string 返回产生的url
     */
    public static function createUrl($str,$baseUrl=null){
        error_reporting(0);
        $url_str = trim($str);

        $pos = array('module'=>'','controller'=>'','action'=>'','param'=>'','host'=>'');
        //遍历字符串,遇到特殊字符则$pos数组指针移动
        $i=0;
        while($i<strlen($url_str)){
            switch($url_str[$i]){
                case '/' : {
                    next($pos);
                }
                break;
                case '?':{
                    while(key($pos)!='param'){
                        next($pos);
                    }
                }
                break;
                case '@' : {
                    while(key($pos)!='host'){
                        next($pos);
                    }
                }
                break;
                case ' ' : ;
                break;
                default: $pos[key($pos)] .=$url_str[$i] ;
            }
            $i++;
        }

        //模块、控制器、方法设置默认值
        $pos['module'] = $pos['module']=='' ? 'index' : strtolower($pos['module']);
        $pos['controller'] = $pos['controller']=='' ? 'index' : strtolower($pos['controller']);
        $pos['action'] = $pos['action']=='' ? 'index' : strtolower($pos['action']);

        //计算传递的参数
        $params = array();
        if($pos['param']!=''){
            $param_tem = explode('&',$pos['param']);
            foreach($param_tem as $val){
                $arr = explode('=',$val);
                $params[$arr[0]] = $arr[1];
            }
            //将变量解析为php代码
            foreach($params as $key=>$val){
                if(strpos(trim($val),'$')===0)
                    $params[$key] = '<?php echo '. $params[$key].';?>';
            }
        }

        if($baseUrl==null){
            if($pos['host']==''){
                $baseUrl = self::getHost().self::getScriptDir();
            }
            else $baseUrl = self::getConfigHost($pos['host']);
        }

      return $baseUrl.'/'.self::getRoute($pos['controller'],$pos['action'],$pos['module'],$params);
    }

    /**
     *给定指定的模块、控制器、方法和参数列表，倒序查找application.int配置文件中的路由信息，找到匹配的路由并根据该路由规则生成url,
     * 目前只匹配重写和正则路由，没有匹配到的返回静态路由的结果
     * @param string $controller 控制器名称
     * @param string $action 方法名
     * @param string $module 模块名
     * @param array $params 传递的参数
     * @return string
     */
    private static function getRoute($controller,$action,$module='index',$params=array() ){

        $routes = array_reverse(tool::getConfig('routes'));
        //遍历路由规则配置信息
        foreach($routes as $key=>$val){
           if(!isset($val['route']))continue;
            $route = $val['route'];
            $m = isset($route['module']) && $route['module']!='' ? strtolower($route['module']) : 'index';
            $c = isset($route['controller']) && $route['controller']!=''? strtolower($route['controller']) : 'index';
            $a = isset($route['action']) && $route['action']!=''? strtolower($route['action']) : 'index';


            //匹配到了参数中模块、控制器、方法的路由规则，如果规则中模块、控制器、动作带有：,则是动态匹配，表示匹配成功
            //只匹配regex和rewrite两种
            if(($m==$module || strpos($m,':')!==false) && ($c==$controller || strpos($c,':')!==false) && ($a == $action || strpos($a,':')!==false)){//路由匹配成功

                switch($val['type']){
                    case 'rewrite' : {//重写路由规则

                        $match = $val['match'];
                        $star = strpos($match, '*') !== false ? 1 : 0;
                        if(strpos($m,':')!==false)$match = str_replace($m,$module,$match);
                        if(strpos($c,':')!==false)$match = str_replace($c,$controller,$match);
                        if(strpos($a,':')!==false)$match = str_replace($a,$action,$match);
                        if ($star) {
                            $match = preg_replace('/\/\*[\/]?/', '', $match);
                            foreach ($params as $k => $v) {
                                if (strpos($match, ':' . $k) !== false) {
                                    $match = str_replace(':' . $k, $v, $match);
                                } else {
                                    $match .= '/' . $k . '/' . $v;
                                }
                            }
                        } else {
                            foreach ($params as $k => $v) {
                                if (strpos($match, ':' . $k) !== false) {
                                    $match = str_replace(':' . $k, $v, $match);
                                }
                            }
                        }

                        return $match;
                    }
                    break;
                    case 'regex' : {
                        $match = $val['match'];
                        $match = preg_replace('/^#\^?/','',$match);//去掉正则路由match的前导#和^
                        $match = preg_replace('/\$?#$/','',$match);//去掉最后。。。
                        //将match中的捕获子组(即圆括号中)替换为‘:’map名称
                        foreach($val['map'] as $v){
                            $match = preg_replace(array('/\([^()]*\)/'),':'.$v,$match,1);
                        }
                        //动态模块、控制器、方法的替换
                        if(strpos($m,':')!==false)$match = str_replace($m,$module,$match);
                        if(strpos($c,':')!==false)$match = str_replace($c,$controller,$match);
                        if(strpos($a,':')!==false)$match = str_replace($a,$action,$match);

                        //去掉其他正则中的[]?,[]+,...,转义的字符去掉前置\
                        $match = preg_replace('/[\[|\]\*|\]\+|\]\?]/','',$match);
                        $match = str_replace('\/','/',$match);
                        $match = str_replace('\?','?',$match);
                        //参数替换
                        foreach ($params as $k => $v) {
                            if (strpos($match, ':' . $k) !== false) {
                                $match = str_replace(':' . $k, $v, $match);
                            }
                        }

                        return $match;
                    }
                    break;
                }
            }
        }
        //没有匹配到则用yaf_route_static静态路由，/module/controller/action/parms的模式

        $match = $module=='index' ? '' : $module.'/';
        $match .= $controller.'/'.$action;
        foreach($params as $key=>$val){
            $match .= '/'.$key.'/'.$val;
        }
        return $match;
    }




    /**
     * 返回配置文件中主机名对应的基础路径
     * @param string $name 主机名
     * @return string
     */
    public static function getConfigHost($name){
        $host_list = tool::getGlobalConfig('host');
        return isset($host_list[$name]) ? $host_list[$name] : '';
    }

    /**
     * @brief  获取当前脚本所在文件夹
     * @return 脚本所在文件夹
     */
    public static function getScriptDir()
    {
        $return = strtr(dirname($_SERVER['SCRIPT_NAME']),"\\","/");

        return $return == '/' ? '' : $return.'';
    }

    /**
     * @brief 获取网站根路径
     * @param  string $protocol 协议  默认为http协议，不需要带'://'
     * @return String $baseUrl  网站根路径
     *
     */
    public static function getHost($protocol='')
    {
        $protocol = tool::getGlobalConfig('http');
        if(!$protocol)
            $protocol = 'http';
        $host	 = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
        $baseUrl = $protocol.'://'.$host;
        return $baseUrl;
    }
    /**
     * @brief 返回入口文件URl地址
     * @return string 返回入口文件URl地址
     */
    public static function getEntryUrl()
    {
        return self::getHost().$_SERVER['SCRIPT_NAME'];
    }
    /**
     * 获取视图目录
     */
    public static function getViewDir(){
        $client = client::getDevice();
        $template = $client=='pc' ? 'pc' : 'mobile';
        return self::getScriptDir().'/views/'.$template.'/';
    }
    /**
     * @brief 获取当前url地址[经过RewriteRule之后的]
     * @return String 当前url地址
     */
    public static function getUrl()
    {
        if (isset($_SERVER['HTTP_X_REWRITE_URL']))
        {
            // check this first so IIS will catch
            $requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
        }
        elseif(isset($_SERVER['IIS_WasUrlRewritten']) && $_SERVER['IIS_WasUrlRewritten'] == '1' && isset($_SERVER['UNENCODED_URL'])       && $_SERVER['UNENCODED_URL'] != '')
        {
            // IIS7 with URL Rewrite: make sure we get the unencoded url (double slash problem)
            $requestUri = $_SERVER['UNENCODED_URL'];
        }
        elseif (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'],"Apache")!==false )
        {
            $requestUri = $_SERVER['PHP_SELF'];
        }
        elseif(isset($_SERVER['REQUEST_URI']))
        {
            $requestUri = $_SERVER['REQUEST_URI'];
        }
        elseif(isset($_SERVER['ORIG_PATH_INFO']))
        {
            // IIS 5.0, PHP as CGI
            $requestUri = $_SERVER['ORIG_PATH_INFO'];
            if (!empty($_SERVER['QUERY_STRING']))
            {
                $requestUri .= '?' . $_SERVER['QUERY_STRING'];
            }
        }
        else
        {
            die("getUrl is error");
        }
        return self::getHost().$requestUri;
    }
    /**
     * @brief 获取当前URI地址
     * @return String 当前URI地址
     */
    public static function getUri()
    {
        if( !isset($_SERVER['REQUEST_URI']) ||  $_SERVER['REQUEST_URI'] == "" )
        {
            // IIS 的两种重写
            if (isset($_SERVER['HTTP_X_ORIGINAL_URL']))
            {
                $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
            }
            else if (isset($_SERVER['HTTP_X_REWRITE_URL']))
            {
                $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
            }
            else
            {
                //修正pathinfo
                if ( !isset($_SERVER['PATH_INFO']) && isset($_SERVER['ORIG_PATH_INFO']) )
                    $_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];


                if ( isset($_SERVER['PATH_INFO']) ) {
                    if ( $_SERVER['PATH_INFO'] == $_SERVER['SCRIPT_NAME'] )
                        $_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
                    else
                        $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
                }

                //修正query
                if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
                {
                    $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
                }

            }
        }
        return $_SERVER['REQUEST_URI'];
    }

    //获取网站根目录
    public static function getBaseUrl(){
        return self::getHost().self::getScriptDir();
    }

}



