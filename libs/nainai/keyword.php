<?php 
/**
 * @author panduo
 * @date 2016-12-26 15:47:41
 * @brief 关键字相关
 */
namespace nainai;
use \nainai\phpanalysis\Phpanalysis;
use \Library\Query;
use \Library\M;
class Keyword{

    /**
     * 常规用法
     * @param  $str
     * @return array
     */
    public static function commonUse($str){
        // 严格开发模式
        ini_set('display_errors', 'On');
        ini_set('memory_limit', '64M');
        error_reporting(E_ALL);

        header('Content-Type: text/html; charset=utf-8');

        $do_fork = $do_unit = true;//岐义处理 新词识别
        $do_multi = $do_prop = $pri_dict = false;//多元切分 词性标注 是否预载全部词条
        $okresult = '';
        if($str != '')
        {
            //初始化类
            PhpAnalysis::$loadInit = false;
            $pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);
            
            //载入词典
            $pa->LoadDict(); 
            
            //执行分词
            $pa->SetSource($str);
            $pa->differMax = $do_multi;
            $pa->unitWord = $do_unit;
            
            $pa->StartAnalysis( $do_fork );
            $okresult = $pa->GetFinallyResult(' ', $do_prop);
            // $pa_foundWordStr = $pa->foundWordStr;
            
            $okresult = trim($okresult,' ');
            if(strpos($okresult,' ')){
                $okresult = explode(' ', $okresult);
            }else{
                $okresult = array($okresult);
            }
        }

        return array_unique($okresult);

    }

    /**
     * 关键字搜索记录添加
     * @param  array  $keywords 关键字数组
     * @return array
     */
    public static function search($keywords = array()){
        $keywords = array_unique($keywords);
        if(!$keywords || !is_array($keywords)) return ;
        $model = new M('article_keyword');
        foreach ($keywords as $value) {
            $insert[] = array('name'=>$value,'search_num'=>1,'create_time'=>date('Y-m-d H:i:s',time()));
        }

        @$model->insertUpdates($insert,array('search_num'=>'+1'));
    }

    /**
     * 文章访问记录添加
     * @param  array $arcInfo 文章信息数组
     * @return 
     */
    public static function check($user_id,$arcInfo){
        $arc_keywords = isset($arcInfo['keywords']) && $arcInfo['keywords'] ? (strpos($arcInfo['keywords'],',') ? explode(',',$arcInfo['keywords']) : array($arcInfo['keywords']) ): array();
        $title = $arcInfo['name'];
        $ans_title = Keyword::commonUse($title);
        
        $keywords = array_merge($arc_keywords,$ans_title);

        $keywords = array_unique($keywords);
        self::search($keywords);
        
        if(isset($user_id)){
            $res = self::keywordInfo($keywords);
            foreach ($res as $key => $value) {
                $data []= array('keyword'=>$value['id'],'user_id'=>$user_id,'search_num'=>1,'create_time'=>date('Y-m-d H:i:s',time()));
            }
            
            $user_log = new M('user_keywords');
            //用户访问记录添加
            @$user_log->insertUpdates($data,array('search_num'=>'+1'));
        }
        return $keywords;
    }

    /**
     * 获取关键词相关信息
     * @param  array $keywords 关键词数组
     * @return array
     */
    public static function keywordInfo($keywords = array()){
        $data = array();
        $keyword_str = '';
        foreach ($keywords as $key => $value) {
            $keyword_str .= "'".$value."',";
        }
        $keyword_str = rtrim($keyword_str,",");
        $model = new M('article_keyword');
        //获取关键字相关信息
        $res = $model->where(array('name'=>array('in',$keyword_str)))->fields('id,name,search_num,base_score')->select();

        foreach ($res as $key => $value) {
            $tmp[$value['name']] = $value;
        }
        return isset($tmp) ? $tmp : array();
    }

    /**
     * 获取用户常用关键字列表
     * @param  int $user_id 用户id
     * @param  int $num  返回数目
     * @return array
     */
    public static function userFavKeywords($user_id,$num = 5){
        $user_id = intval($user_id);
        if(!$user_id) return array();

        $user_log = new Query('user_keywords as uk');
        $user_log->join = 'left join article_keyword as ak on uk.keyword = ak.id';
        $user_log->fields = 'ak.name';
        $user_log->order = 'uk.search_num desc';
        $user_log->where = 'uk.user_id = :user_id';
        $user_log->bind = array('user_id'=>$user_id);
        $user_log->pagesize = $num;
        $user_log->page = 1;

        $fav_keywords = $user_log->find();
        foreach ($fav_keywords as $key => $value) {
            $tmp []= $value['name'];
        }
        return $tmp;
    }

    /**
     * 热门关键字列表
     * @return [type] [description]
     */
    public static function hotKeywords($limit = 10){
        $article_keyword = new M('article_keyword');
        return $article_keyword->fields('name,search_num*base_score as score')->order('score desc')->limit($limit)->select();
    }

}