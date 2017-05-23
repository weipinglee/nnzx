<?php
/**
 * url绠＄悊绫?鍩轰簬yaf璺敱
 * User: weipinglee
 * Date: 2016/2/17 0017
 * Time: 涓婂崍 9:25
 */
namespace Library;
use \Library\tool;
class url {

    /**
     * 鏍规嵁涓嶅悓璺敱瑙勫垯浜х敓url
     * @param string $str 褰㈠锛?cli/test/index?key=value&key1=value2@deal '鐨勫瓧绗︿覆锛屽鏋滅涓�涓瓧绗︽槸鈥?鈥?琛ㄧずmodule涓篿ndex,
     * 濡傛灉涓嶆槸鈥?鈥欙紝绗竴涓?/'鍓嶇殑閮ㄥ垎鏄痬odule,鍚庨潰浠?/'鍒嗗壊鐨勪緷娆℃槸鎺у埗鍣ㄣ�佹柟娉?濡傛灉缂哄け/鍒欓粯璁や负index,?鍚庨潰鐨勬槸鍙傛暟瀵癸紝@鍚庨潰鐨勬槸涓绘満鍚?     * 娉ㄦ剰:蹇呴』鏄?/?@鐨勯『搴忥紝/鍙互鏄竴涓垨0涓?     * @param string $baseUrl 绔欑偣璺緞 濡傛灉浼犻�掓鍙傛暟 浼氬拷鐣?str涓瑻鍚庨潰鐨勫唴瀹?     * @return string 杩斿洖浜х敓鐨剈rl
     */
    public static function createUrl($str,$baseUrl=null){
        $url_str = trim($str);

        $pos = array('module'=>'','controller'=>'','action'=>'','param'=>'','host'=>'');
        //閬嶅巻瀛楃涓?閬囧埌鐗规畩瀛楃鍒?pos鏁扮粍鎸囬拡绉诲姩
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

        //妯″潡銆佹帶鍒跺櫒銆佹柟娉曡缃粯璁ゅ�?        $pos['module'] = $pos['module']=='' ? 'index' : strtolower($pos['module']);
        $pos['controller'] = $pos['controller']=='' ? 'index' : strtolower($pos['controller']);
        $pos['action'] = $pos['action']=='' ? 'index' : strtolower($pos['action']);

        //璁＄畻浼犻�掔殑鍙傛暟
        $params = array();
        if($pos['param']!=''){
            $param_tem = explode('&',$pos['param']);
            foreach($param_tem as $val){
                $arr = explode('=',$val);
                $params[$arr[0]] = $arr[1];
            }
            //灏嗗彉閲忚В鏋愪负php浠ｇ爜
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
     *缁欏畾鎸囧畾鐨勬ā鍧椼�佹帶鍒跺櫒銆佹柟娉曞拰鍙傛暟鍒楄〃锛屽�掑簭鏌ユ壘application.int閰嶇疆鏂囦欢涓殑璺敱淇℃伅锛屾壘鍒板尮閰嶇殑璺敱骞舵牴鎹璺敱瑙勫垯鐢熸垚url,
     * 鐩墠鍙尮閰嶉噸鍐欏拰姝ｅ垯璺敱锛屾病鏈夊尮閰嶅埌鐨勮繑鍥為潤鎬佽矾鐢辩殑缁撴灉
     * @param string $controller 鎺у埗鍣ㄥ悕绉?     * @param string $action 鏂规硶鍚?     * @param string $module 妯″潡鍚?     * @param array $params 浼犻�掔殑鍙傛暟
     * @return string
     */
    private static function getRoute($controller,$action,$module='index',$params=array() ){

        $routes = array_reverse(tool::getConfig('routes'));
        //閬嶅巻璺敱瑙勫垯閰嶇疆淇℃伅
        foreach($routes as $key=>$val){
           if(!isset($val['route']))continue;
            $route = $val['route'];
            $m = isset($route['module']) && $route['module']!='' ? strtolower($route['module']) : 'index';
            $c = isset($route['controller']) && $route['controller']!=''? strtolower($route['controller']) : 'index';
            $a = isset($route['action']) && $route['action']!=''? strtolower($route['action']) : 'index';


            //鍖归厤鍒颁簡鍙傛暟涓ā鍧椼�佹帶鍒跺櫒銆佹柟娉曠殑璺敱瑙勫垯锛屽鏋滆鍒欎腑妯″潡銆佹帶鍒跺櫒銆佸姩浣滃甫鏈夛細,鍒欐槸鍔ㄦ�佸尮閰嶏紝琛ㄧず鍖归厤鎴愬姛
            //鍙尮閰峳egex鍜宺ewrite涓ょ
            if(($m==$module || strpos($m,':')!==false) && ($c==$controller || strpos($c,':')!==false) && ($a == $action || strpos($a,':')!==false)){//璺敱鍖归厤鎴愬姛

                switch($val['type']){
                    case 'rewrite' : {//閲嶅啓璺敱瑙勫垯

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
                        $match = preg_replace('/^#\^?/','',$match);//鍘绘帀姝ｅ垯璺敱match鐨勫墠瀵?鍜宆
                        $match = preg_replace('/\$?#$/','',$match);//鍘绘帀鏈�鍚庛�傘�傘�?                        //灏唌atch涓殑鎹曡幏瀛愮粍(鍗冲渾鎷彿涓?鏇挎崲涓衡�?鈥檓ap鍚嶇О
                        foreach($val['map'] as $v){
                            $match = preg_replace(array('/\([^()]*\)/'),':'.$v,$match,1);
                        }
                        //鍔ㄦ�佹ā鍧椼�佹帶鍒跺櫒銆佹柟娉曠殑鏇挎崲
                        if(strpos($m,':')!==false)$match = str_replace($m,$module,$match);
                        if(strpos($c,':')!==false)$match = str_replace($c,$controller,$match);
                        if(strpos($a,':')!==false)$match = str_replace($a,$action,$match);

                        //鍘绘帀鍏朵粬姝ｅ垯涓殑[]?,[]+,...,杞箟鐨勫瓧绗﹀幓鎺夊墠缃甛
                        $match = preg_replace('/[\[|\]\*|\]\+|\]\?]/','',$match);
                        $match = str_replace('\/','/',$match);
                        $match = str_replace('\?','?',$match);
                        //鍙傛暟鏇挎崲
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
        //娌℃湁鍖归厤鍒板垯鐢▂af_route_static闈欐�佽矾鐢憋紝/module/controller/action/parms鐨勬ā寮?
        $match = $module=='index' ? '' : $module.'/';
        $match .= $controller.'/'.$action;
        foreach($params as $key=>$val){
            $match .= '/'.$key.'/'.$val;
        }
        return $match;
    }




    /**
     * 杩斿洖閰嶇疆鏂囦欢涓富鏈哄悕瀵瑰簲鐨勫熀纭�璺緞
     * @param string $name 涓绘満鍚?     * @return string
     */
    public static function getConfigHost($name){
        $host_list = tool::getGlobalConfig('host');
        return isset($host_list[$name]) ? $host_list[$name] : '';
    }

    /**
     * @brief  鑾峰彇褰撳墠鑴氭湰鎵�鍦ㄦ枃浠跺す
     * @return 鑴氭湰鎵�鍦ㄦ枃浠跺す
     */
    public static function getScriptDir()
    {
        // $return = strtr(dirname($_SERVER['SCRIPT_NAME']),"\\","/");
        $return = strtr(dirname($_SERVER['SCRIPT_NAME']),"\\","/");

        return $return == '/' ? '' : $return.'';
    }

    /**
     * @brief 鑾峰彇缃戠珯鏍硅矾寰?     * @param  string $protocol 鍗忚  榛樿涓篽ttp鍗忚锛屼笉闇�瑕佸甫'://'
     * @return String $baseUrl  缃戠珯鏍硅矾寰?     *
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
     * @brief 杩斿洖鍏ュ彛鏂囦欢URl鍦板潃
     * @return string 杩斿洖鍏ュ彛鏂囦欢URl鍦板潃
     */
    public static function getEntryUrl()
    {
        return self::getHost().$_SERVER['SCRIPT_NAME'];
    }
    /**
     * 鑾峰彇瑙嗗浘鐩綍
     */
    public static function getViewDir(){
        $client = client::getDevice();
        $template = $client=='pc' ? 'pc' : 'mobile';
        return self::getScriptDir().'/views/'.$template.'/';
    }
    /**
     * @brief 鑾峰彇褰撳墠url鍦板潃[缁忚繃RewriteRule涔嬪悗鐨刔
     * @return String 褰撳墠url鍦板潃
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
     * @brief 鑾峰彇褰撳墠URI鍦板潃
     * @return String 褰撳墠URI鍦板潃
     */
    public static function getUri()
    {
        if( !isset($_SERVER['REQUEST_URI']) ||  $_SERVER['REQUEST_URI'] == "" )
        {
            // IIS 鐨勪袱绉嶉噸鍐?           
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
                //淇pathinfo
                if ( !isset($_SERVER['PATH_INFO']) && isset($_SERVER['ORIG_PATH_INFO']) )
                    $_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];


                if ( isset($_SERVER['PATH_INFO']) ) {
                    if ( $_SERVER['PATH_INFO'] == $_SERVER['SCRIPT_NAME'] )
                        $_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
                    else
                        $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
                }

                //淇query
                if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
                {
                    $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
                }

            }
        }
        return $_SERVER['REQUEST_URI'];
    }

    //鑾峰彇缃戠珯鏍圭洰褰?    
    public static function getBaseUrl(){
        return self::getHost().self::getScriptDir();
    }

}



