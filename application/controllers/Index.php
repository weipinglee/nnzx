 <?php
/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
use \nainai\offer\product;
use \Library\url;
use \Library\safe;
use \Library\Payment;
use \Library\json;
use \Library\M;
use \Library\tool;
class IndexController extends PublicController {



	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/yar-demo/index/index/index/name/root 的时候, 你就会发现不同
     */
	public function indexAction() {
		//phpinfo();
        $this->getView()->assign('cur','index');

		$this->getView()->assign('index',1);

		$productModel=new product();
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		//获取幻灯片
		$indexSlide=\nainai\system\slide::getIndexSlide();
		foreach($indexSlide as $k=>$v){
			$indexSlide[$k]['img']=\Library\Thumb::getOrigImg($v['img']);
		}
		
		//获取统计数据
		$statcModel=new \nainai\statistics();
        $statsMarketModel=new \nainai\statsMarket();
        $allStatsData=$statsMarketModel->getAllStatsList();

        $statcTime = array();

        $statcTime=$allStatsData[1];
        $statcCatList=$allStatsData[0];
		$this->getView()->assign('statcTime',\Library\json::encode($statcTime));
        $statcProList=$statcModel->getHotProductDataList(10);
        $topCat=$productModel->getTopCate(8);
        $company=\nainai\companyRec::getAllCompany();

		//获取信誉排行企业用户
		$indexModel = new indexModel();
        $creditMember = $indexModel->getCreditMemberList(10);

		//获取首页最新完成的交易
		$order = new \nainai\order\Order();
		$newTrade = $order->getNewComplateTrade(20);
		$offer = new offersModel();
		//获取报盘总数
		$offer_num = $offer->getOfferNum();
		$this->getView()->assign('offer_num',$offer_num['num']);
		//获取企业总数
		$company_num = $indexModel->getTotalCompany();
		$this->getView()->assign('company_num',$company_num['num']);
        //获取注册的总数
		$userNum=$indexModel->getAllUser();
		$this->getView()->assign('all_user_num',$userNum['num']);
		//获取当前和昨日成交量
		$order_num = $order->getOrderTotal();
		$order_num_yes = $order->getOrderTotal('yesterday');

		//获取滚动的图片信息
		$adModel=new \Library\ad();
		$adList=$adModel->getAdListByName('滚动');
		foreach($adList as $k=>$v) {
			if (isset($v['content'])) {
				$adList[$k]['content'] = \Library\Thumb::getOrigImg($v['content']);
			}
		}
		//获取所有的推荐商户信息
		$allCompany=\nainai\companyRec::getAllCompanyOrderByType();
        //获取推荐商家的广告
        $allCompanyAd=$adModel->getAdListByName('推荐商家');
        foreach($allCompanyAd as $k=>$v){
            if(isset($v['content'])){
                $allCompanyAd[$k]['content']=\Library\Thumb::getOrigImg($v['content']);
            }
        }
	
		//获取交易市场信息
		$offerList = array();
		foreach($topCat as $key=>$val){
			$offerList[$val['id']] = $offer->getOfferCategoryList($val['id']);
			
			foreach($offerList[$val['id']] as $k => $v)
			{
				$offerList[$val['id']][$k]['produce_area'] = substr($v['produce_area'],0,2);
			}
		}
		
       // var_dump($allCompanyAd);die;
        $this->getView()->assign('allCompanyAd',$allCompanyAd);
		$this->getView()->assign('allCompany',$allCompany);
		$this->getView()->assign('adList',$adList);
		$this->getView()->assign('creditMember',$creditMember);
		$this->getView()->assign('offerCateList',\Library\json::encode($offerList));
		$this->getView()->assign('statcCatList',\Library\json::encode($statcCatList));
		$this->getView()->assign('statcProList',$statcProList);
		$this->getView()->assign('company',$company);
		$this->getView()->assign('topCat',$topCat);
		$this->getView()->assign('indexSlide',$indexSlide);
		$this->getView()->assign('newTrade',$newTrade);
		$this->getView()->assign('order_num',$order_num['num']);
		$this->getView()->assign('order_num_yes',$order_num_yes['num']);
		$this->getView()->assign('year',$year);
		$this->getView()->assign('month',$month);
		$this->getView()->assign('day',$day);
	}
    
    
    //支付异步回调
    public function serverCallbackAction(){
        //从URL中获取支付方式
        $payment_id      = safe::filterGet('id','int');
        $paymentInstance = Payment::createPaymentInstance($payment_id);


        if(!is_object($paymentInstance))
        {
            die('fail');
        }

        //初始化参数
        $money   = '';
        $message = '支付失败';
        $orderNo = '';

        //执行接口回调函数
        $callbackData = array_merge($_POST,$_GET);
        unset($callbackData['controller']);
        unset($callbackData['action']);
        unset($callbackData['_id']);
        $return = $paymentInstance->serverCallback($callbackData,$payment_id,$money,$message,$orderNo);        
        //支付成功
        if($return)
        {
            //充值方式
            $recharge_no = str_replace('recharge','',$orderNo);
            $rechargeObj = new M('recharge_order');
            $rechargeRow = $rechargeObj->getObj('recharge_no = "'.$recharge_no.'"');
            if(empty($rechargeRow))
            {
                die('fail') ;
            }
            $dataArray = array(
                'status' => 1,
            );

            $rechargeObj->data($dataArray);
            $result = $rechargeObj->data($dataArray)->where('recharge_no = "'.$recharge_no.'"')->update();

            if(!$result)
            {
                die('fail') ;
            }

            $money   = $rechargeRow['account'];
            $user_id = $rechargeRow['user_id'];
            $agenA = new \nainai\fund\agentAccount();
            $res = $agenA->in($user_id, $money);
            if($res)
            {
                $paymentInstance->notifyStop();
                exit;
            }
        }
        //支付失败
        else
        {
            $paymentInstance->notifyStop();
            exit;
        }
    }

	public function foundAction(){
        $this->getView()->assign('cur','found');
    }
    
    public function doFoundAction(){
        if(!$this->login)
        {
            die(json::encode(tool::getSuccInfo(0,'请登录后再操作', url::createUrl('/login/login@user'))));
        }
        else
        {
            $foundObj = new M('found');
            $fData = array(
                'product_name' => safe::filterPost('name'),
                'spec' => safe::filterPost('spec'),
                'num' => safe::filterPost('num'),
                'place' => safe::filterPost('place'),
                'user_name' => safe::filterPost('username'),
                'phone' => safe::filterPost('phone'),
                'area' => safe::filterPost('local'),
                'user_id' => $this->login['user_id'],
                'description' => safe::filterPost('desc'),
                'create_time' => date('Y-m-d H:i:s')
            );

            $f_id = $foundObj->data($fData)->add();
            if($f_id){
                die(json::encode(\Library\tool::getSuccInfo()));
            }
            else
            {
                die(json::encode(\Library\tool::getSuccInfo(0, '服务器错误')));
            }
        }
        
	}


    public function helpAction(){
    }

    public function storageAction(){
        $this->getView()->assign('cur','storage');
    }
    
    //获取首页交易市场数据
    public function getCateOfferListAction()
    {
        $id = safe::filterPost('id', 'int');
        $id = 6;
        $offer = new OffersModel();
        $data = $offer->getOfferCategoryList($id);
        foreach($data as $k => $v)
        {
            $data[$k]['produce_area'] = substr($v['produce_area'],0,2);
        }
        die(json::encode($data));
    }
}
