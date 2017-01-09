<?php
namespace conf;

/**
* 导出的下载字段数据配置
*/
class Downconfig 
{
     public static function getConfig($type){
          $config = array();
          switch ($type) {
            case 'Acc':
                $config = array('user_no'=>会员号,'username' => '用户名', 'mobile' => '手机号', 'amount' => '总金额', 'fund' => '可用资金', 'freeze' => '冻结资金');
                break;
            case 'Credit':
                $config = array('username' => '用户名', 'mobile' => '手机号', 'credit' => '信誉保证金');
                break;
           case 'user_bank':
                $config = array('user_no'=>会员号,'username' => '用户名', 'true_name' => '姓名', 'bank_name' => '开户银行', 'card_type' => '银行卡类型', 'identify_no' => '身份证号', 'status_text' => '状态');
                break;
            case 'withdraw_request':
                $config = array('user_no'=>会员号,'username' => '用户名', 'mobile' => '手机号', 'request_no' => '订单号', 'amount' => '金额', 'status_text' => '状态', 'create_time' => '时间');
                break;
            case 'recharge_orderline':
                $config = array('user_no'=>会员号,'username' => '用户名', 'order_no' => '订单号', 'amount' => '金额','pay_type'=>'充值方式', 'status_text' => '状态', 'create_time' => '时间');
                break;
              case 'recharge_orderoff':
                $config = array('user_no'=>会员号,'username' => '用户名', 'order_no' => '订单号', 'amount' => '金额', 'status_text' => '状态', 'create_time' => '时间');
                break;
              case 'dealer':
                $config = array('username' => '登录账号', 'type_text' => '会员类型', 'mobile' => '手机号', 'status_text' => '认证状态', 'apply_time' => '申请时间');
                break;
              case 'store_manager':
                $config = array('username' => '登录账号', 'type_text' => '会员类型', 'mobile' => '手机号', 'store_name'=>'认证仓库','status_text' => '认证状态', 'apply_time' => '申请时间');
                  break;
              case 'user':
                $config = array('username' => '用户名', 'true_name' => '真实姓名', 'company_name' => '企业名称', 'email' => '邮箱', 'mobile' => '手机号', 'create_time' => '注册时间', 'agent_name' => '代理商', 'ser_name' => '业务员');
                break;
              case 'admin_log':
                $config = array('id' => 'id', 'name' => '用户名', 'datetime' => '时间', 'ip' => 'ip', 'content' => '操作');
                break;
              case 'product_offer':
                $config = array('id' => 'id', 'username' => '用户名', 'true_name' => '姓名', 'company_name' => '企业名称', 'name' => '商品名', 'type_txt' => '交易方式', 'mode_txt' => '类型', 'divide_text' => '可否拆分', 'quantity' => '数量', 'price' => '挂牌价', 'status_txt' => '状态');
                break;
              case 'user_log':
                $config = array('id' => 'id', 'username' => '用户名', 'datetime' => '操作时间', 'action' => '动作', 'content' => '操作内容', 'ip' => 'ip');
                break;
              case 'order_sell':
                $config = array('order_no' => '订单编号', 'create_time' => '合同开始日期', 'end_time' => '合同完成日期', 'product_name' => '商品名称', 'buyer_name' => '买方名称', 'seller_name' => '卖方名称', 'mode_txt' => '交易方式', 'type_txt' => '报盘方式', 'num' => '成交数量', 'amount' => '合同金额', 'reduce_amount' => '质量扣款金额', 'account' => '结算金额', 'title' => '合同状态');
                break;
                case 'payto_market':
                  $config = array('id' => 'id', 'mode_text' => '订单类型', 'charge_type_text' => '收费类型', 'num' => '金额', 'order_no' => '所属订单', 'create_time' => '时间');
                  break;
                case 'order_sellapply':
                $config = array('order_no' => '订单编号', 'product_name' => '商品名称', 'cate_name' => '所属分类', 'num_txt' => '商品数量', 'delivery_num_txt' => '本轮提货数量', 'amount' => '订单金额', 'store_name' => '所在仓库', 'delivery_time' => '提货时间');
                  break;
          }
          return $config;
     }
}