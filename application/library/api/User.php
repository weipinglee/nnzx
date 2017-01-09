<?php
/**
 * @date 2015-9-13 
 * @author zhengyin <zhengyin.name@gmail.com>
 * @blog http://izhengyin.com
 *
 */

namespace api;

class User extends \tool\ApiServer{
	
	public function add(){
		
		return __METHOD__;
	}
	
	
	public function update($params){
		if(!$this->checkSign($params)){
			return $this->response(0,array(
					'errCode'=>'SIGN_ERROR',
					'errInfo'=>'签名错误'
			));
		}
		
		$userModel = new \UserModel();
		
		$result = $userModel->updateUser();
		
		return $this->response(1, $result);
	}
}