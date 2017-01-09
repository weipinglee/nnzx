<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/15
 * Time: 12:00
 */
class HelpController extends PublicController
{
    public function helpAction(){
        //获取帮助
        $helpModel=new \nainai\system\help();
        $helpModel->helpLimit='';
        $helpModel->helpCatLimit='';
        $helpList=$helpModel->getAllHelplist();
        $this->getView()->assign('helpList',$helpList);
        $cat_id=\Library\safe::filterGet('cat_id');
        $id=\Library\safe::filterGet('id','int');
        $helpModel=new \nainai\SiteHelp();
        $helpCatInfo=$helpModel->checkHelpCatName(['id'=>$cat_id]);
        $helpInfo=$helpModel->checkHelpName(['id'=>$id]);
        $this->getView()->assign('helpInfo',$helpInfo);
        $this->getView()->assign('helpCatInfo',$helpCatInfo);

    }
	
	//change ueditor picture url
	public function helpurlnnysAction(){
		return false;
		$helpModel = new \Library\M('help');
		$data = $helpModel->select();
		$newUrl = 'www.nainaiwang.com';
		$oldUrl = 'new.nainaiwang.com';
		$helpModel->begintrans();
		foreach($data as $val){
			$content = $val['content'];
			$content = str_replace($oldUrl,$newUrl,$content);
			$helpModel->data(array('content'=>$content))->where(array('id'=>$val['id']))->update();
		}
		$res = $helpModel->commit();
		if($res){
			echo 'success';
		}
		else echo 'failed';
	}
}