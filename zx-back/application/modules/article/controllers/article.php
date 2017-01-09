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
	}

	/**
	 * 分类列表
	 */
	public function arcListAction(){
		$page = safe::filterGet('p','int',1);
		$list = $this->Model->arcList($page);
		$this->getView()->assign('list', $list[0]);
		$this->getView()->assign('pageBar', $list[1]);
	}
	
	public function addArcAction(){
		if(IS_POST){
			$data['name'] = safe::filterPost('name');
			$data['cate_id'] = safe::filterPost('cate_id','int');
			$data['content'] = htmlspecialchars($_POST['content']);
			$data['status'] = safe::filterPost('status');
			$data['cover'] = tool::setImgApp(safe::filterPost('imgcover'));
			$data['type'] = \nainai\Article::TYPE_ADMIN;
			$data['user_id'] = $this->admin_id;			
			$data['create_time'] = date('Y-m-d H:i:s',time());
			$res = $this->Model->arcAdd($data);
			die(json::encode($res));
		}else{
			$this->getView()->assign('oper','添加');
			\Yaf\Dispatcher::getInstance()->disableView();
			$cateList = $this->cateModel->cateFlowHtml();
			$this->getView()->assign('cateList',$cateList);
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
			if(strpos('@',$_POST['imgcover']) === false) $data['cover'] = safe::filterPost('imgcover');
			$res = $this->Model->arcEdit($data);
			die(json::encode($res));
		}else{
			$id = safe::filter($this->_request->getParam('id'));
			$info = $this->Model->getarcInfo($id);
			
			$cateList = $this->cateModel->cateFlowHtml($info['cate_id']);
			$this->getView()->assign('cateList',$cateList);
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
            $res = $this->Model->delcate($id);
            die(json::encode($res));

        }
    }
}