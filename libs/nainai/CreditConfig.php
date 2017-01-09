<?php
namespace nainai;

use \Library\M;
use \Library\Query;
use \Library\Tool;

/**
 * 信誉
 */
class CreditConfig extends \nainai\Abstruct\ModelAbstract{

	public function __construct(){
		$this->tableName = 'configs_credit';
		parent::__construct();
	}

	/**
	 * 根据对应的操作改变用户的信誉值
	 * @param  [Int]  $userId      [用户id]
	 * @param  [String]  $operateName [操作的名称]
	 * @param  integer $value       [根据百分比计算的信誉值]
	 * @param String $[note] [<信誉的变化说明>]
	 * @return [Boolean] 
	 */
	public function changeUserCredit($userId, $operateName, $value=0, $note=''){
		if (intval($userId) > 0 && is_string($operateName)) {

			$configData = $this->model->table($this->tableName)->fields('name, type, sign, value')->where('name=:name')->bind(array('name' => $operateName))->getObj();
			$userData = $this->model->table('user')->fields('id, credit')->where('id=:id')->bind(array('id' => $userId))->getObj();
			
			if (!empty($configData) && !empty($userData)) {
				if ($configData['type'] == 1) {//百分比，需要乘于value
					$configData['value'] = bcmul($configData['value'],  $value, 5); 
				}
				//日志数据
				$logData = array(
					'user_id' => $userId,
				);
				if($note){
					$logData['intro'] = $note;
				}
				else{
					$logData['intro'] = isset($this->creditNote[$operateName]) ? $this->creditNote[$operateName] : '';
				}

				//根据对应的表示做出对应的操作
				switch (intval($configData['sign'])) {
					case 0: //加
						$userData['credit'] = bcadd($userData['credit'], $configData['value'], 5);
						$logData['value'] = $configData['value'];
						break;

					case 1:  //减
						$userData['credit'] = bcsub($userData['credit'], $configData['value'], 5);
						$logData['value'] = '-' . $configData['value'];
						break;
				}
				$res = (bool)$this->model->data(array('credit' => $userData['credit']))->where('id=:id')->bind(array('id' => $userId))->update();
				$res = true;

				if ($res === TRUE) {
					$b = $this->addCreditLog($logData);
					return TRUE;
				}
			}
		}

		return FALSE;
	}

	/**
	 * 添加信誉日志
	 * @param [Array] $logData [日志数据]
	 */
	public function addCreditLog( & $logData){
		$logData['datetime'] = \Library\Time::getDateTime();

		return (bool)$this->model->table('credit_log')->data($logData)->add(0);
	}

	/**
	 * @var array 各种类型的信誉变动备注
	 */
	protected $creditNote = array(
		'cert_dealer' => '认证交易商成功',
		'cert_store'  => '认证仓库管理员成功',
		'cert_ship'   => '认证物流',
		'cancel_contract' => '取消合同',
		'cancel_offer' => '取消报盘',
		'contract'    => '完成合同',
		'credit_money' => '缴纳信用保证金',
		'pay'         => "支付",
		'product'     => '发布报盘成功',
		'register'    => '注册成功',
		'cancel_cert_dealer' => '交易商重新认证',
		'cancel_cert_store' => '取消仓库认证'
	);

}