<?php
use \Library\safe;
use \nainai\article;
use \Library\cache\Cache;
use \Library\json;
class InterfaceController extends Yaf\Controller_Abstract {
	
	public function init(){
		$this->article = new article();
	}

	//交易网站首页资讯数据
	public function tradewebInfoAction(){//return array('a','b');
		//$jsonp = safe::filterGet('callback');
		$cacheObj = new Cache(array('type'=>'m','expire'=>60));
		$result = '';
		if($cacheObj->isActive()){
			$result = $cacheObj->get('TRADEWEB_INFO');
		}

		if(!$result){
			$page = safe::filterGet('page','int',1);

			//主体数据
			$main_data = $this->article->arcList($page,array('status'=>1,'is_del'=>0),'','',10,0,0,'INTERFACE');
			$result = $main_data;
			if($cacheObj->isActive()){
				$cacheObj->set('TRADEWEB_INFO',$result);
			}
		}

		die(json::encode($result));

	}

}