<?php

use \Library\Safe;
use \Library\Thumb;
use \Library\url;
use \Library\json;
use \Library\tool;

class ArcTypeController extends InitController {

	public function init(){
		parent::init();
		$this->typeModel = new typeModel();
	}

	/**
	 * 分类列表
	 */
	public function typeListAction(){
		$page = safe::filterGet('p','int',1);
		$list = $this->typeModel->typelist($page);
		
		$this->getView()->assign('list', $list[0]);
		$this->getView()->assign('pageBar', $list[1]);
	}

	public function addTypeAction(){
		if(IS_POST){
			$data['name'] = safe::filterPost('name');
			$data['sort'] = safe::filterPost('sort','int');
			$data['pid'] = safe::filterPost('pid','int');
			$data['status'] = safe::filterPost('status');
			$data['create_time'] = date('Y-m-d H:i:s',time());
			$res = $this->typeModel->typeAdd($data);
			die(json::encode($res));
		}else{
			$this->getView()->assign('oper','添加');

			\Yaf\Dispatcher::getInstance()->disableView();
			$typelist = $this->typeModel->typeFlowHtml(0,0,1);
			$this->getView()->assign('typelist',$typelist);
			$this->getView()->assign('url',url::createUrl('category/arcType/addtype'));
			$this->display('typeedit');

		}
	}
	
	public function typeeditAction(){
		if(IS_POST){
			$data['id'] = safe::filterPost('id');
			$data['name'] = safe::filterPost('name');
			$data['sort'] = safe::filterPost('sort','int');
			$data['pid'] = safe::filterPost('pid','int');
			$data['status'] = safe::filterPost('status');
			$res = $this->typeModel->typeedit($data);
			die(json::encode($res));
		}else{
			$id = safe::filter($this->_request->getParam('id'));
			$info = $this->typeModel->gettypeInfo($id);
			$this->getView()->assign('oper','编辑');
			\Yaf\Dispatcher::getInstance()->disableView();
			$typelist = $this->typeModel->typeFlowHtml($info['pid'],$id,1);
			// var_dump($typelist);
			$this->getView()->assign('typelist',$typelist);
			$this->getView()->assign('id',$id);
			$this->getView()->assign('info',$info);
			$this->getView()->assign('url',url::createUrl('category/arcType/typeedit'));
			$this->display('typeedit');
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
            $res = $this->typeModel->setStatus($data);
            die(json::encode($res));

        }
    }

    public function delAction(){
        if (IS_AJAX) {
            $id=safe::filterGet('id');
            $res = $this->typeModel->deltype($id);
            die(json::encode($res));

        }
    }
}