<?php
/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
use \Library\photoupload;
use \Library\json;
use \Library\Session;
use \Library\adminrbac\rbac;
class IndexController extends InitController {


	public function init(){
		parent::init();
		if (!\admintool\admin::is_admin()) {
			// $menus = \Library\Session::get('admin_menus');
			$menus = rbac::accessMenu();
			$this->getView()->assign('menus',JSON::encode($menus));
		}else{ 
			$this->getView()->assign('menus','admin');
		}
		
	}
	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/yar-demo/index/index/index/name/root 的时候, 你就会发现不同
     */
	public function indexAction() {
		// session_destroy();
		$admin_info = admintool\admin::sessionInfo();
		$this->getView()->assign('info',$admin_info);
	}

	public function welcomeAction(){
		$this->getView()->setLayout('');
	}

	public function noaccessAction(){

	}

	/**
	 * ajax上传图片
	 * @return bool
	 */
	public function uploadAction(){

		//调用文件上传类
		$photoObj = new photoupload();
		$photoObj->setThumbParams(array(180,180));
		$photo = current($photoObj->uploadPhoto());

		if($photo['flag'] == 1)
		{
			$result = array(
				'flag'=> 1,
				'img' => $photo['img'],
				'thumb'=> $photo['thumb'][1]
			);
		}
		else
		{
			$result = array('flag'=> $photo['flag'],'error'=>$photo['errInfo']);
		}
		echo JSON::encode($result);

		return false;
	}

	/**
	 * 获取管理员操作提醒
	 */
	public function getMsgAction(){
		if(IS_POST){
			$admin_info = admintool\admin::sessionInfo();

			if (empty($admin_info) || !isset($admin_info['id'])) {
				exit(json::encode(array()));
			}
			$admin_id = $admin_info['id'];
			$adminModel = new AdminModel();
			$role = $adminModel->getAdminInfo($admin_id);

			$msgModel = new \nainai\AdminMsg();
			$msgData = $msgModel->getmsg($admin_id);

			if (!empty($msgData) ) {
				foreach ($msgData as $key => $value) {

					//判断是否有权限
					$value['url_oper'] = ltrim($value['url_oper'],'/');
					$operUrl = explode('/',$value['url_oper']);
					$rbac = new \Library\adminrbac\rbac();
					$check = $rbac->AccessDecision($operUrl[0],$operUrl[1],$operUrl[2]);
					if($check){//如果有权限,设置已访问
						$msgModel->setVisit($admin_id,$value['id']);
						//生成访问的url
						$msgData[$key]['url'] = ltrim($msgData[$key]['url'],'/');
						$url = explode('?',$msgData[$key]['url']);
						$i=0;
						$c = 0;
						while($i<strlen($url[0])){
							if($c==3)
								break;
							if($url[0][$i]=='/'){
								$c = $c + 1;
							}
							$i = $i  + 1;
						}

						$msgData[$key]['url'] = \Library\url::createUrl(substr($url[0],0,$i));
						$msgData[$key]['url'] .= $url[1] ? '?'.$url[1] : '/';
						$msgData[$key]['url'] .= substr($url[0],$i).$value['args'];

					}
					else{
						unset($msgData[$key]);
					}
				}
				die(json::encode($msgData));
			}

			exit(json::encode(array()));
		}
		return false;

	}

	/**
	 * 清除缓存
	 */
	public function clearCacheAction(){
		if(IS_POST){
			$cache = new \Library\cache\Cache('m');
			if($cache->clear()){
				die(json::encode(\Library\tool::getSuccInfo()));
			}
			die(json::encode(\Library\tool::getSuccInfo(0,'操作失败')));
		}

	}




}
