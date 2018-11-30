<?php

use \Library\safe;
use \Library\thumb;
use \Library\url;
use \Library\json;
use \Library\tool;

class ArcCateController extends InitController {

	public function init(){
		parent::init();
		$this->cateModel = new categoryModel();
	}

	/**
	 * 分类列表
	 */
	public function cateListAction(){
		$page = safe::filterGet('p','int',1);
		$list = $this->cateModel->cateList($page);
		$this->getView()->assign('list', $list[0]);
		$this->getView()->assign('pageBar', $list[1]);
	}

	public function addCateAction(){
		if(IS_POST){
			$data['name'] = safe::filterPost('name');
			$data['sort'] = safe::filterPost('sort','int');
			$data['pid'] = safe::filterPost('pid','int');
			$data['status'] = safe::filterPost('status');
			$data['icon'] = \Library\tool::setImgApp(safe::filterPost('imgfile2'));
			$data['create_time'] = date('Y-m-d H:i:s',time());
			$res = $this->cateModel->cateAdd($data);
			die(json::encode($res));
		}else{
			$this->getView()->assign('oper','添加');
			\Yaf\Dispatcher::getInstance()->disableView();
			$cateList = $this->cateModel->cateFlowHtml();
			$this->getView()->assign('cateList',$cateList);
			$this->getView()->assign('url',url::createUrl('category/arcCate/addCate'));
			$this->display('cateedit');
		}
	}
	
	public function cateeditAction(){
		if(IS_POST){
			$data['id'] = safe::filterPost('id');
			$data['name'] = safe::filterPost('name');
			$data['sort'] = safe::filterPost('sort','int');
			$data['pid'] = safe::filterPost('pid','int');
			if($_POST['imgfile2'])$data['icon'] = \Library\tool::setImgApp(safe::filterPost('imgfile2'));
			$data['status'] = safe::filterPost('status');
			$res = $this->cateModel->cateEdit($data);
			die(json::encode($res));
		}else{
			$id = safe::filter($this->_request->getParam('id'));
			$info = $this->cateModel->getcateInfo($id);
			$this->getView()->assign('oper','编辑');
			\Yaf\Dispatcher::getInstance()->disableView();

			$cateList = $this->cateModel->cateFlowHtml($info['pid']);
			$this->getView()->assign('cateList',$cateList);
			$this->getView()->assign('id',$id);
			$this->getView()->assign('info',$info);
			$this->getView()->assign('url',url::createUrl('category/arcCate/cateEdit'));
			$this->display('cateedit');
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
            $res = $this->cateModel->setStatus($data);
            die(json::encode($res));

        }
    }

    public function delAction(){
        if (IS_AJAX) {
            $id=safe::filterGet('id');
            $res = $this->cateModel->delcate($id);
            die(json::encode($res));

        }
    }
}