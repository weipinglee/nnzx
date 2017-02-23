<?php

// cvn2加密 1：加密 0:不加密
const SDK_CVN2_ENC = 0;
// 有效期加密 1:加密 0:不加密
const SDK_DATE_ENC = 0;
// 卡号加密 1：加密 0:不加密
const SDK_PAN_ENC = 0;

// ######(以下配置为PM环境：入网测试环境用，生产环境配置见文档说明)#######
// 签名证书路径
const SDK_SIGN_CERT_PATH = './key/PM_700000000000001_acp.pfx';

// 签名证书密码
const SDK_SIGN_CERT_PWD = '000000';

// 验签证书
const SDK_VERIFY_CERT_PATH = './key/certs/verify_sign_acp.cer';

// 前台请求地址
//const SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/gateway/api/frontTransReq.do';
const SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';

// 后台请求地址
//const SDK_BACK_TRANS_URL = 'https://gateway.95516.com/gateway/api/backTransReq.do';
const SDK_BACK_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/backTransReq.do';

// 批量交易
//const SDK_BATCH_TRANS_URL = 'https://gateway.95516.com/gateway/api/batchTrans.do';
const SDK_BATCH_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/batchTrans.do';

//单笔查询请求地址
//const SDK_SINGLE_QUERY_URL = 'https://gateway.95516.com/gateway/api/queryTrans.do';
const SDK_SINGLE_QUERY_URL = 'https://101.231.204.80:5000/gateway/api/queryTrans.do';

//文件传输请求地址
//const SDK_FILE_QUERY_URL = 'https://filedownload.95516.com/';
const SDK_FILE_QUERY_URL = 'https://101.231.204.80:9080/';

//有卡交易地址
//const SDK_Card_Request_Url = 'https://gateway.95516.com/gateway/api/cardTransReq.do';
const SDK_CARD_REQUEST_URL = 'https://101.231.204.80:5000/gateway/api/cardTransReq.do';

//App交易地址
//const SDK_App_Request_Url = 'https://gateway.95516.com/gateway/api/appTransReq.do';
const SDK_APP_REQUEST_URL = 'https://101.231.204.80:5000/gateway/api/appTransReq.do';

//文件下载目录
const SDK_FILE_DOWN_PATH = 'd:/file/';

//日志 目录
const SDK_LOG_FILE_PATH = 'd:/logs/';

//日志级别
const SDK_LOG_LEVEL = 'INFO';

?>