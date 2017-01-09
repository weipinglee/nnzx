<?php
/**
 * 交易费率配置项模型
 */
namespace config;
use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\Thumb;
class ConfscaleOfferModel{

	//模型对象实例
	private $confscaleOffer;
	public function __construct(){
		$this->confscaleOffer = new M('scale_offer');
	}
	/**
	 * 会员分组规则
	 * @var array
	 */
	protected $confscaleOfferRules = array(
		array('free','/^(\d{1,}(\.\d{0,2})?)$/','自由报盘收费格式错误',0,'regex'),
		array('deposite','/^(\d{1,2}(\.\d{1,3})?|100)$/','保证金报盘收费格式错误',0,'regex'),
		array('fee','/^(\d{1,2}(\.\d{1,3})?|100)$/','手续费格式错误',0,'regex'),
	);

	
	/**
	 * 新增或编辑
	 * @param  array 操作数据数组
	 * @return mixed
	 */
	public function confscaleOfferUpdate($data){
		$confscaleOffer = $this->confscaleOffer;
		if($confscaleOffer->data($data)->validate($this->confscaleOfferRules)){
			if(isset($data['id'])){
				$id = $data['id'];
				//编辑
				$res = $confscaleOffer->where(array('id'=>$id))->data($data)->update();
				$res = is_int($res) && $res>0 ? true : ($confscaleOffer->getError() ? $confscaleOffer->getError() : '数据未修改');
			}else{
				$confscaleOffer->beginTrans();
				$aid = $confscaleOffer->add();
				$res = $confscaleOffer->commit();
			}
		}else{
			$res = $confscaleOffer->getError();
		}
	
		
		if($res===true){
			$log = new \Library\log();
			$log->addLog(array('content'=>'更新了报盘费率'));
			$resInfo = tool::getSuccInfo();
		}
		else{
			$resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;
	}

	/**
	 * 根据id获取配置项信息
	 * 
	 * @param  int $id 
	 * @return array  信息
	 */
	public function getconfscaleOfferInfo($id){
		$info = $this->confscaleOffer->where(array('id'=>$id))->getObj();
		return $info ? $info : array();
	}


}