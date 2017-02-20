<?php
namespace Library;
use \Library\JSON;
use \Library\M;
use \Library\Query;

/**
 * @file payment.php
 * @brief 支付方式 操作类
 * @author
 * @date 2011-01-20
 * @version 0.6
 * @note
 */

/**
 * @class Payment
 * @brief 支付方式 操作类
 */
//支付状态：支付失败
define("PAY_FAILED", -1);
//支付状态：支付超时
define("PAY_TIMEOUT", 0);
//支付状态：支付成功
define("PAY_SUCCESS", 1);
//支付状态：支付取消
define("PAY_CANCEL", 2);
//支付状态：支付错误
define("PAY_ERROR", 3);
//支付状态：支付进行
define("PAY_PROGRESS", 4);
//支付状态：支付无效
define("PAY_INVALID", 5);

class Payment {
	/**
	 * @brief 创建支付类实例
	 * @param $payment_id int 支付方式ID
	 * @return 返回支付插件类对象
	 */
	public static function createPaymentInstance($payment_id) {

		$paymentRow = self::getPaymentById($payment_id);

		if ($paymentRow && isset($paymentRow['class_name']) && $paymentRow['class_name']) {
			$class_name = $paymentRow['class_name'];
			$result = "\\Library\\payment" . "\\" . $class_name . "\\" . $class_name;

			if (new $result($payment_id)) {

				return new $result($payment_id);
				//echo 1;//return new $result(3)
			} else {

				//IError::show(403, '支付接口类' . $class_name . '没有找到');
			}
		} else {
			//IError::show(403, '支付方式不存在');
		}
	}

	/**
	 * @brief 根据支付方式配置编号  获取该插件的详细配置信息
	 * @param $payment_id int    支付方式ID
	 * @param $key        string 字段
	 * @return 返回支付插件类对象
	 */
	public static function getPaymentById($payment_id, $key = '') {

		$paymentDB = new Query('payment');
		$paymentDB->where = 'id=:id';
		$paymentDB->bind = array('id' => $payment_id);
		$paymentRow = $paymentDB->getObj();

		if ($key) {
			return isset($paymentRow[$key]) ? $paymentRow[$key] : '';
		}

		return $paymentRow;
	}

	/**
	 * @brief 根据支付方式配置编号  获取该插件的配置信息
	 * @param $payment_id int    支付方式ID
	 * @param $key        string 字段
	 * @return 返回支付插件类对象
	 */
	public static function getConfigParam($payment_id, $key = '') {
		$payConfig = self::getPaymentById($payment_id, 'config_param');
		if ($payConfig) {
			$payConfig = JSON::decode($payConfig);
			return isset($payConfig[$key]) ? $payConfig[$key] : '';
		}
		return '';
	}
	/**
	 * 获取支付参数（商户id，密码）
	 * @param unknown $payment_id
	 */
	private static function getPaymentParam($payment_id) {
		//最终返回值
		$payment = array();

		//初始化配置参数
		$paymentInstance = Payment::createPaymentInstance($payment_id);
		$configParam = $paymentInstance->configParam();
		//return $configParam;
		foreach ($configParam as $key => $val) {
			$payment[$key] = '';
		}

		//获取公共信息
		$paymentRow = self::getPaymentById($payment_id, 'config_param');
		if ($paymentRow) {
			$paymentRow = JSON::decode($paymentRow);
			foreach ($paymentRow as $key => $item) {
				$payment[$key] = $item;
			}
		}
		return $payment;
	}

	/**
	 * @brief 获取订单中的支付信息 M:必要信息; R表示店铺; P表示用户;
	 * @param $payment_id int    支付方式ID
	 * @param $type       string 信息获取方式 order:订单支付;recharge:在线充值;
	 * @param $argument   mix    参数
	 * @return array 支付提交信息
	 */
	public static function getPaymentInfo($payment_id, $type, $argument) {

		$payment = self::getPaymentParam($payment_id);

		if ($type == 'recharge') {
			//判断用户有没有登录
			/*if (session::get('user_id') == null) {
			IError::show(403, '请登录系统');
			}	*/

			if (!isset($argument['account']) || $argument['account'] <= 0) {
				//IError::show(403, '请填入正确的充值金额');

			}

			$rechargeObj = new M('recharge_order');
			$reData = array(
				//'user_id' => session::get('user_id'),
				'id' => null,
				'user_id' => 1,
				'order_no' => self::createOrderNum(),
				//资金
				'amount' => $argument['account'],
				'create_time' => self::getDateTime(),
				'proot' => ' ',
				'status' => '0',
				//支付方式
				'pay_type' => $argument['payType'],
			);
			$rechargeObj;
			$r_id = $rechargeObj->data($reData)->add();

			//充值时用户id跟随交易号一起发送,以"_"分割
			$payment['M_OrderNO'] = 'recharge' . $reData['order_no'];
			$payment['M_OrderId'] = $r_id;
			$payment['M_Amount'] = $reData['amount'];
			$payment['M_Remark'] = '';
		}

		//交易信息
		$payment['M_Time'] = time();
		$payment['M_Paymentid'] = $payment_id;

		//店铺信息
		$payment['R_Address'] = isset($site_config['address']) ? $site_config['address'] : '';
		$payment['R_Name'] = isset($site_config['name']) ? $site_config['name'] : '山城速购';
		$payment['R_Mobile'] = isset($site_config['mobile']) ? $site_config['mobile'] : '13232323';
		$payment['R_Telephone'] = isset($site_config['phone']) ? $site_config['phone'] : '400-234-4564564';
		
		return $payment;
	}

	public static function createOrderNum() {
		return 'recharge' . date('YmdHis') . rand(100000, 999999);
	}
	public static function getDateTime($format = '', $time = '') {
		$time = $time ? $time : time();
		$format = $format ? $format : 'Y-m-d H:i:s';
		return date($format, $time);
	}

	/**
	 * 更新在线充值
	 * @param string $recharge_no 充值订单号
	 * @param string $proot 第三方返回的交易流水号
	 * @return bool
	 */
	public static function updateRecharge($recharge_no, $proot = '') {
		$rechargeObj = new M('recharge_order');
		$rechargeObj->where(array('order_no'=>$recharge_no));
		$rechargeRow = $rechargeObj->getObj();
		if (empty($rechargeRow)) {
			return false;
		}

		if ($rechargeRow['status'] == 1) {
			return true;
		}
		if ($proot == '') {
			return false;
		}
		$dataArray = array(
			'status' => 1,
			'proot' => $proot,
		);

		$rechargeObj->beginTrans();
		$rechargeObj->where(array('order_no'=>$recharge_no))->data($dataArray)->update();


		$userid = $rechargeRow['user_id'];
		$money = $rechargeRow['amount'];
		$fund = \nainai\fund::createFund(1);
		$fundRes = $fund->in($userid, $money);

		return $rechargeObj->commit();

	}
}