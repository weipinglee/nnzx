<?php
/**
 * 推荐商户管理
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/6/2
 * Time: 11:49
 */
use \Library\json;
use \Library\safe;
class companyRecController extends Yaf\Controller_Abstract {
    public function init() {
        $this->getView()->setLayout('admin');
    }

    /**
     *推荐商户列表
     */
    public function recListAction(){
        $page=\Library\safe::filterGet('page','int');
        $recModel=new \nainai\companyRec();
        $res=$recModel->getRecList($page);
        $this->getView()->assign('recList',$res[0]);
        $this->getView()->assign('pageBar',$res[1]);
    }
    /*
	推荐商户编辑
     */
    public function recEditAction(){
        if(IS_POST){
            $data=array(
                'id'=>safe::filterPost('id','int'),
                'user_id'=>safe::filterPost('user_id','int'),
                'type'=>safe::filterPost('type','int'),
                'status'=>safe::filterPost('status','int'),
                'start_time'=>safe::filterPost('start_time'),
                'end_time'=>safe::filterPost('end_time')
            );

            $recModel=new \nainai\companyRec();
            $result=$recModel->editRec($data);
            echo json::encode($result);
            return false;
        }
		else{
			$id=\Library\safe::filterGet('id','int');
			if($id>0){
				$res=\nainai\companyRec::getRecDetail($id);
				$this->getView()->assign('data',$res);
			}

		}


    }
    /*
    推荐商户添加
     */
    public function recAddAction(){
    	if(IS_POST){
			$data=array(
				'user_id'=>safe::filterPost('user_id','int'),
				'type'=>safe::filterPost('type','int'),
				'status'=>safe::filterPost('status','int'),
				'start_time'=>safe::filterPost('start_time'),
				'end_time'=>safe::filterPost('end_time')
				);    		
			$recModel=new \nainai\companyRec();
			$result=$recModel->addRec($data);
			echo json::encode($result);
			return false;

    	}

    	$cInfoModel=new \Library\Query('company_info as i');
    	$cInfoModel->fields='i.user_id,i.company_name';
    	$res=$cInfoModel->find();
        //var_dump($res);
    	$this->getView()->assign('cInfo',$res);
    }
    /**
    **关闭开启推荐
     */
    public function recStatusEditAction(){
    	if(IS_POST&&IS_AJAX){
    		$userId=safe::filterPost('user_id','int');
    		$type=safe::filterPost('type','int');
    		$status=safe::filterPost('status','int');
    		$recModel=new \nainai\companyRec();
    		$result=$recModel->closeRec($userId,$type,$status);
    		echo json::encode($result);
    		return false;   
    	}

    	return false;
    }  
     /*
    删除推荐
     */
    public function recDelAction(){
    	if(IS_POST&&IS_AJAX){
    		$id=safe::filterGet('id','int');
    		$recModel=new \Library\M('company_rec');
    		$where=array('id'=>$id);
    		$res=$recModel->where($where)->delete();
    		if($res){
    		die(json::encode(\Library\tool::getSuccInfo(1,'删除成功')));
    		}else{
    			die(json::encode(\Library\tool::getSuccInfo(0,'删除失败')));
    		}
    	}else{
    		return false;
    	}

    }
         /*
   	批量添加
     */
    public function recBatchAddAction(){
		if(IS_POST&&IS_AJAX){
			//var_dump($_POST);
			$userId=safe::filterPost('user_id','int');
			$type=safe::filterPost('type','int');
			$status=safe::filterPost('type','int');
			$start_time=safe::filterPost('start_time');
			$end_time=safe::filterPost('end_time');
			$error=array();
			$recModel=new \nainai\companyRec();
			$recObj=new \Library\M('company_rec');
			$recObj->beginTrans();
			foreach($userId as $key=>$v){
				$data=array(
					'user_id'=>$userId[$key],
					'type'=>$type[$key],
					'status'=>$status[$key],
					'start_time'=>$start_time[$key],
					'end_time'=>$end_time[$key]
				);
				$res=$recModel->addRec($data);
				if($res['success']==0){
					$error[]=$userId[$key];

				}
			}
			if(empty($error)){
				$recObj->commit();
				die(JSON::encode(\Library\tool::getSuccInfo(1,'添加成功')));
			}else{
				$recObj->rollBack();
				$cInfo=$recModel->getCompanyInfo($error);
				$error=implode(',',$cInfo);

				die(JSON::encode(\Library\tool::getSuccInfo(0,'以下商户添加失败:'.$error)));
			}

		}

		return false;

    }

	public function setStatusAction(){
		if(IS_AJAX){
			$recModel=new \nainai\companyRec();
			$data['status'] = intval(safe::filterPost('status'));
			$data['id'] = intval($this->_request->getParam('id'));
			$res = $recModel->setStatus($data['id'],$data['status']);

			echo JSON::encode($res);
			return false;
		}
		return false;
	}
}