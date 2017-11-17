<?php

use \Library\Safe;
use \Library\Thumb;
use \Library\url;
use \Library\json;
use \Library\tool;

class ArticleController extends InitController {

	public function init(){
		parent::init();
		$this->Model = new articleModel();
		$this->cateModel = new categoryModel();
		$this->typeModel = new typeModel();
	}
	
	public function arcListAction(){
		$page = safe::filterGet('page','int',1);
		$cate_id = safe::filterPost('cate_id','int',0);
		$name = safe::filterPost('name','trim','');
		$where = array('is_ad'=>array('gte',0),'is_del'=>0);
		if($cate_id) $where['cate_id'] = $cate_id;
		if($name) $where['name'] = array('like',$name);

		$list = $this->Model->arcList($page,$where);
		$cate_list = $this->cateModel->cateFlowHtml($cate_id);
		
		$this->getView()->assign('list', $list[0]);
		$this->getView()->assign('data', array('search'=>array('name'=>'=')));
		$this->getView()->assign('pageBar', $list[1]);
		$this->getView()->assign('cates', $cate_list);
		$this->getView()->assign('name', $name);
		$this->getView()->assign('cate_id', $cate_id);
	}
	
	public function addArcAction(){
		if(IS_POST){
			$data['name'] = safe::filterPost('name');
			$data['cate_id'] = safe::filterPost('cate_id','int');
			$data['content'] = htmlspecialchars($_POST['content']);
			$data['status'] = safe::filterPost('status');
			$data['recommend'] = safe::filterPost('recommend');
			$data['type'] = safe::filterPost('type');
			$data['keywords'] = safe::filterPost('keywords');
			$data['is_ad'] = safe::filterPost('is_ad'); 
			$imgcover = safe::filterPost('imgcover');
			foreach ($imgcover as &$value) {
				$value = str_replace(url::getScriptDir().'/', '',tool::setImgApp($value));
			}
			$data['cover'] = implode(',',$imgcover);
			$data['user_type'] = \nainai\Article::TYPE_ADMIN;
			$data['user_id'] = $this->admin_id;			
			$data['create_time'] = date('Y-m-d H:i:s',time());
			$data['update_time'] = date('Y-m-d H:i:s',time());
			$res = $this->Model->arcAdd($data);
			die(json::encode($res));
		}else{
			$this->getView()->assign('oper','添加');
			\Yaf\Dispatcher::getInstance()->disableView();
			$cateList = $this->cateModel->cateFlowHtml();
			$typelist = $this->typeModel->typeFlowHtml();
			$this->getView()->assign('cateList',$cateList);
			$this->getView()->assign('typelist',$typelist);
			$this->getView()->assign('url',url::createUrl('article/article/addarc'));
			$this->display('arcedit');
		}
	}
	
	public function arceditAction(){
		if(IS_POST){
			$data['id'] = safe::filterPost('id');
			$data['name'] = safe::filterPost('name');
			$data['cate_id'] = safe::filterPost('cate_id','int');
			$data['content'] = htmlspecialchars($_POST['content']);
			$data['status'] = safe::filterPost('status');
			$data['recommend'] = safe::filterPost('recommend');
			$data['type'] = safe::filterPost('type');
			$data['keywords'] = safe::filterPost('keywords');
			$data['is_ad'] = safe::filterPost('is_ad');
			$data['update_time'] = date('Y-m-d H:i:s',time());
			$imgcover = safe::filterPost('imgcover');
			foreach ($imgcover as &$value) {
				if(strpos($value, '@') === false)
					$value = str_replace(url::getScriptDir().'/', '',tool::setImgApp($value));
			}
			$data['cover'] = implode(',',$imgcover);
			$res = $this->Model->arcEdit($data);
			die(json::encode($res));
		}else{
			$id = safe::filter($this->_request->getParam('id'));
			$info = $this->Model->getarcInfo($id);
			
			$cateList = $this->cateModel->cateFlowHtml($info['cate_id']);
			$typelist = $this->typeModel->typeFlowHtml($info['type']);
			$this->getView()->assign('cateList',$cateList);
			$this->getView()->assign('typelist',$typelist);
			$this->getView()->assign('oper','编辑');
			
			$this->getView()->assign('id',$id);
			$this->getView()->assign('info',$info);
			$this->getView()->assign('url',url::createUrl('article/article/arcedit'));
			
		}
	}

	public function setStatusAction(){
        if (IS_AJAX) {
            $id=intval($this->_request->getParam('id'));
            $status = safe::filterPost('status', 'int');
            $data = [
                'id' => $id,
                'status' => $status
            ];
            $res = $this->Model->setStatus($data);
            die(json::encode($res));

        }
    }

    public function delAction(){
        if (IS_AJAX) {
            $id=safe::filterGet('id');
            $res = $this->Model->delarc($id);
            die(json::encode($res));
        
        }	
    }

    public function uploadifyAction(){
    	$targetFolder = '/nnys-admin/upload/uploadify'; // Relative to the root
    	
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
		if (!empty($_FILES)){//} && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['files']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;

			$fileParts = pathinfo($_FILES['files']['name']);
			// var_dump($fileParts);exit;
			$targetFile = rtrim($targetPath,'/') . '/' . md5($_FILES['files']['name'].time()).'.'.$fileParts['extension'];
			$showfile = $targetFolder . '/' . md5($_FILES['files']['name'].time()).'.'.$fileParts['extension'];

			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
			
			if (in_array($fileParts['extension'],$fileTypes)) {
				move_uploaded_file($tempFile,$targetFile);
				$res = $showfile;
			} else {
				$res = false;
			}
		}else{
			$res = false;
		}
		die(json::encode($res ? tool::getSuccInfo(1,$res):tool::getSuccInfo(0,'上传失败')));
    }
}