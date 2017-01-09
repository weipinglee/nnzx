<?php
/**
 * 商户推荐管理类
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/5/30
 * Time: 9:49
 */
namespace nainai;
use Library\cache\driver\Memcache;
use \Library\M;
use Library\Query;
use \Library\time;
use \Library\tool;
class companyRec{
    private $cRecModel='';
    private $cInfoModel='';
    public  $firstLimit=4;
    public  $secondLimit=10;
    public  $thirdLimit=5;
    //推荐类型
    CONST FIREST_REC=1;//第一推荐
    CONST SECOND_REC=2;//第二推荐
    CONST THIRD_REC=3;//第三推荐
    /**
     * companyRec constructor.
     */
    public function __construct(){
        $this->cRecModel=new M('company_rec');
        $this->cInfoModel=new M('company_info');

    }
    protected $recRules=array(
        array('user_id','number','用户id不能为空'),
        array('type','number','推荐类型不能为空'),
          array('start_time','date','开始时间不能为空'),
          array('end_time','date','结束时间不能为空')
    );
    /**
     * 添加推荐
     * @param array $parmas
     * @return array
     */
    public function addRec($parmas=array()){
        if(isset($parmas['user_id'])){
            $where=array('user_id'=>$parmas['user_id']);
            $infoRes=$this->cInfoModel->where($where)->getObj();
            if(!$infoRes){
                return tool::getSuccInfo(0,'推荐用户必须是企业用户');
            }
        }else{
            return tool::getSuccInfo(0,'用户ID必须存在');
        }
        if(!isset($parmas['start_time'])){
            $parmas['start_time']=time::getDateTime();
        }
        if(!isset($parmas['end_time'])){
            return tool::getSuccInfo(0,'结束时间必须存在');
        }
        if($this->cRecModel->data($parmas)->validate($this->recRules)){
            $where=array(
                'user_id'=>$parmas['user_id'],
                'type'=>$parmas['type']
            );
            $this->cRecModel->where($where);
            $cRes=$this->cRecModel->getObj();
            //如果存在相同类型的推荐，就更新。否则就添加
            if($cRes){
                $where=array('id'=>$cRes['id']);
                if($this->cRecModel->data($parmas)->where($where)->update()){
                    return tool::getSuccInfo(1,'修改成功');
                }
                return tool::getSuccInfo(0,'修改失败');
            }else {
                if ($this->cRecModel->data($parmas)->add()) {
                    return tool::getSuccInfo(1, '添加成功');
                } else {
                    return tool::getSuccInfo(0, '添加失败');
                }
            }
        }else{
            $error=$this->cRecModel->getError();
            return tool::getSuccInfo(0,$error);
        }
    }

    /**
     * 编辑推荐
     * @param $data
     * @return array
     */
    public function editRec($data){
        $crecModel=$this->cRecModel;
        $resInfo=$crecModel->where(array('id'=>$data['id']))->getObj();
        //如果现在的类型不等于之前的类型，就判断是否有相同的类型
        if($resInfo['type']!=$data['type']) {
            $where = array('user_id' => $data['user_id']);
            $res = $crecModel->where($where)->select();
            if ($res) {
                foreach ($res as $v) {
                    if ($v['type'] == $data['type']) {
                        return tool::getSuccInfo(0, '要修改推荐类型存在');
                    }
                }
            }
        }
        if($crecModel->data($data)->validate($this->recRules)){
            $where=array('id'=>$data['id']);
            unset($data['id']);
            $crecModel->beginTrans();
            $crecModel->data($data)->update();
            $res = $crecModel->commit();
            if($res===true){
                return tool::getSuccInfo(1,'修改成功');
            }else{
                return tool::getSuccInfo(0,'修改失败');
            }

        }else{
            $error=$crecModel->getError();
            return tool::getSuccInfo(0,$error);
        }


    }

    /**
     * 关闭，开启推荐
     * @param $userId
     * @param $type
     * @param $status
     * @return array
     */
    public function closeRec($userId, $type,$status=0){
        $cRecModel=$this->cRecModel;
        $where=array(
            'user_id'=>$userId,
            'type'=>$type
        );
        $res=$cRecModel->where($where);
        $res=$cRecModel->getObj();
        if($res){
            $data=array('status'=>$status);
            if($cRecModel->data($data)->where(array('id'=>$res['id']))->update()){
                return tool::getSuccInfo(1,'修改成功');
            }else{
                return tool::getSuccInfo(0,'修改失败');
            }
        }else{
            return $status==0?tool::getSuccInfo(0,'要关闭的推荐不存在'):tool::getSuccInfo(0,'要开启的推荐不存在');
        }
    }
    /**
     * 获得某个分类下面的推荐企业信息
     * @param $cateId
     */
    private function getRec($cateId,$type){
        $cRecModel=new \Library\Query('company_rec as r');
        $cRecModel->join='left join company_info as i on r.user_id=i.user_id';
        $cRecModel->where='i.category= :cateId and NOW() between r.start_time and r.end_time and r.type='.$type;
        if($type==self::FIREST_REC){
            $cRecModel->limit=$this->firstLimit;
        }
        if($type==self::SECOND_REC){
            $cRecModel->limit=$this->secondLimit;
        }
        if($type==self::THIRD_REC){
            $cRecModel->limit=$this->thirdLimit;
        }
        $cRecModel->bind=array('cateId'=>$cateId);
        $res=$cRecModel->find();
        return $res;

    }


    /**
     * 获取第三推荐
     * @param $cateId 分类id
     * @return array 以地区id前两位为下标的数组
     */
    public function getThirdRec($cateId){
        $thirdRec=$this->getRec($cateId,3);
        $result=array();
        foreach($thirdRec as $k=>$v){
            $provinceCode = substr($v['area'],0,2);
            $result[$provinceCode][]=$v;
        }
        return $result;
    }

    /**
     * 获取前两个推荐
     * @param $cateId
     * @return array 下标0：第一推荐.下标1：第二推荐
     */
    public function getFirstTwoRec($cateId){
        $firstRec=$this->getRec($cateId,1);
        $secondRec=$this->getRec($cateId,2);
        $result=array(
            $firstRec,
            $secondRec
        );

        return $result;
    }

    /**
     * 获取推荐列表
     * @param int $page
     * @return array
     */
    public function getRecList($page=1){
        $cRecModel=new \Library\Query('company_rec as r');
        $cRecModel->join='left join company_info as i on r.user_id=i.user_id left join user as u on u.id=r.user_id';
        $cRecModel->fields='r.*,u.username,i.company_name';
        $cRecModel->page=$page;
        $recList=$cRecModel->find();
        $recBar=$cRecModel->getPageBar();
        return array($recList,$recBar);
    }

    /**
     * 获取推荐类型
     * @param $type
     * @return string
     */
    public static function getRecType($type=''){
        switch($type){
            case self::FIREST_REC:
                return "第一推荐";
                break;
            case self::SECOND_REC:
                return "第二推荐";
                break;
            case self::THIRD_REC:
                return "第三推荐";
            break;
            default:
                return array(
                    self::FIREST_REC=>"第一推荐",
                    self::SECOND_REC=>'第二推荐',
                    self::THIRD_REC=>'第三推荐'
                );
            break;

        }

    }

    /**
     * 获取某条推荐信息的详情
     * @param $id
     * @return array
     */
    public static function getRecDetail($id){
        $RecModel=new \Library\Query('company_rec as r');
        $RecModel->join='left join company_info as i on i.user_id=r.user_id left join user as u on r.user_id=u.id left join product_category as p on p.id=i.category';
        $RecModel->fields='r.*,i.company_name,u.username,p.name as pname,u.mobile';
        $RecModel->where='r.id= :rid';
        $RecModel->bind=array('rid'=>$id);
        $res=$RecModel->getObj();
        return $res;
    }

    /**
     * 根据userId获取企业名称
     * @param $userId
     * @return array
     */
    public function getCompanyInfo($userId){

        $cInfoModel=new \Library\Query('company_info');
        if(is_array($userId)) {
            $cInfoModel->fields='company_name';
            $userId=implode(',',$userId);
            $cInfoModel->where='user_id in ('. $userId.')';
            $cNames=$cInfoModel->find();
            $res=array();
            foreach($cNames as $v){
                $res[]=$v['company_name'];
            }
        }else{
            $where=array('user_id'=>$userId);
            $res= $cInfoModel->where($where)->getField('company_name');
        }
        return $res;
    }

    /**
     * 设置状态
     * @param $id
     * @param $status
     */
    public function setStatus($id,$status){
        $this->cRecModel->beginTrans();
        $this->cRecModel->where(array('id'=>$id))->data(array('status'=>$status))->update();
        $res = $this->cRecModel->commit();
        if($res===true)
            return tool::getSuccInfo();
        else
            return tool::getSuccInfo(0,'操作错误');

    }
    public static function getAllCompanyOrderByType(){
        $cRecObj=new \Library\Query('company_rec as r');
        $cRecObj->join='left join company_info as i on r.user_id=i.user_id';
        $cRecObj->where='NOW() between r.start_time and r.end_time and r.status=1';
        $cRecObj->order='r.type ASC';
        $allCompany=$cRecObj->find();
        return $allCompany;
    }
    //返回所有的推荐信息，
    public static function getAllCompany(){
        $memcache=new Memcache();
        $allCompany=$memcache->get('allCompany');
        if($allCompany){
            return unserialize($allCompany);
        }
        $cRecModel        = new \Library\Query('company_rec as r');
        $cRecModel->join  = 'left join company_info as i on r.user_id=i.user_id';
        $cRecModel->where = 'NOW() between r.start_time and r.end_time and r.status=1';
        $allCompany=$cRecModel->find();

        $result=array();
        foreach($allCompany as $k=>$v){
            $result[$v['category']][]=$v;

        }

        $res=array();
        foreach($result as $k=>$v){
                foreach($v as $kk=>$vv){
                    if($vv['type']==self::FIREST_REC){
                            $res[$k][$vv['type']][]=$vv;
                    }
                    if($vv['type']==self::SECOND_REC){
                        $res[$k][$vv['type']][]=$vv;
                    }
                    if($vv['type']==self::THIRD_REC){
                        
                            
                            $provinceCode=substr($vv['area'],0,2);
                            $res[$k][$vv['type']][$provinceCode][]=$vv;
                      

                    }
                }

        }
        $memcache->set('allCompany',serialize($res));
       /* echo "<pre>";
        print_r($res);*/
      return $res;
    }

}