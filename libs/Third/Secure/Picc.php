<?php

namespace Third\Secure;
use \Library\tool;

class Picc extends Secures {

     private $insure;
     private $quit;
     private $claim;
     private $visa;
     private $key;
     private $code;

     private $t_key = 'Picc37mu63ht38mw';
     private $t_code = 'CPI000086';
     private $t_insure = 'http://yanshou.mypicc.com.cn/ecooperation/webservice/insure?wsdl';
     private $t_quit = 'http://yanshou.mypicc.com.cn/ecooperation/webservice/insure?wsdl';
     private $t_visa = 'http//yanshou.mypicc.com.cn/ecooperation/webservice/visa?wsdl';
     private $t_claim = 'http://yanshou.mypicc.com.cn/ecooperation/webservice/claim?wsdl';

     private $test = true;

     private $request = array();
     private $response = array();

     public function __construct(){
          if ($this->test) {
               $this->key = $this->t_key;
               $this->code = $this->t_code;
               $this->insure = $this->t_insure;
               $this->quit = $this->t_quit;
               $this->claim = $this->t_claim;
               $this->visa = $this->t_visa;
          }
     }

     public  $identity = array(
          '01'=>'身份证',
          '02'=>'户口薄',
          '03'=>'护照',
          '04'=>'军官证',
          '07'=>'港澳居民身份证',
          '25'=>'港澳居民来往内地通行证',
          '26'=>'台湾居民往来内地通行证',
          '99'=>'其它'
     );

     public  $relation = array(
          '01'=> '本人',
          '10'=> '配偶',
          '40'=> '儿女',
          '50'=> '父母',
          '99'=> '其它'
     );

     public  $role = array(
          '05' => '生产',
          '06' => '销售',
          '22' => '进口商',
          '23' => '出口商',
          '24' => '批发商',
          '25' => '零售商',
          '26' => '代理商',
          '34' => '生产和销售商',
          '99' => '其他'
     );

     public  $area = array(
          '01' => '中国境内（港澳台除外）',
          '02' => '中国境内（包含港澳台）',
          '03' => '世界范围（美加除外）',
          '04' => '世界范围（包含美加）'
     );

     public function insures( & $data){
          $this->request['interfaceNo'] = '001001';
          $this->request['datas'] = $this->getInsureXml( $data);

          return $this->commonOperate(__FUNCTION__);
     }

     public function getInsureXml(& $data){
          $uuid = 'nnw' . \Library\Time::getDateTime('YmdHis') . '123';
          $xml = '<?xml version="1.0" encoding="GB2312" standalone="yes"?>';
          $xml .= '<ApplyInfo>';
          $xml .= '<GeneralInfo>
                              <UUID>'. $uuid  .'</UUID>
                              <PlateformCode>' . $this->code .'</PlateformCode>
                              <Md5Value>' .md5($uuid . $data['insuranceFee'] . $this->key ). '</Md5Value> 
                         </GeneralInfo>';
          $xml .= '<PolicyInfos><PolicyInfo>';
          $xml .= '<SerialNo>1</SerialNo>
                         <RiskCode>'.$data['code'].'</RiskCode>
                         <OperateTimes>'.\Library\Time::getDateTime().'</OperateTimes>
                         <StartDate>' . $data['startDate']. '</StartDate>
                         <EndDate>' . $data['endDate']. '</EndDate>
                         <StartHour>0</StartHour>
                         <EndHour>24</EndHour> 
                         <SumAmount>'.$data['limit']. '</SumAmount>
                         <SumPremium>'.$data['insuranceFee']. '</SumPremium> 
                         <ArguSolution>1</ArguSolution>
                         <InsuredPlan>
                              <RationType>'.$data['project_code']. '</RationType>
                              <Schemes>
                                        <Scheme>
                                             <SchemeCode>1</SchemeCode>
                                             <SchemeAmount>'.$data['limit']. '</SchemeAmount>
                                             <SchemePremium>'.$data['insuranceFee']. '</SchemePremium>
                                        </Scheme>
                              </Schemes>
                         </InsuredPlan>';
          $xml .= '<LiabInfo>
                              <ProductType>ZAH</ProductType>
                              <BusinessNature>'.$data['role']. '</BusinessNature>
                              <Coverage>'.$data['area']. '</Coverage>
                              <NowTurnOver>' .$data['fee']. '</NowTurnOver>
                         </LiabInfo>';
          $xml .= '<Applicant> 
                              <AppliName>' .$data['toubaoInfo']['name']. '</AppliName>
                              <AppliIdType>' .$data['toubaoInfo']['type']. '</AppliIdType>
                              <AppliIdNo>' .$data['toubaoInfo']['identno']. '</AppliIdNo>
                              <AppliIdMobile>' .$data['toubaoInfo']['tel']. '</AppliIdMobile>
                              <SendSMS>Y</SendSMS>
                              <AppliIdEmail>' .$data['toubaoInfo']['email']. '</AppliIdEmail>
                              <AppliAddress>' .$data['toubaoInfo']['address']. '</AppliAddress>
                              <AppliIdentity>' .$data['relation']. '</AppliIdentity>
                         </Applicant>
                         <Insureds>
                              <Insured>
                                   <InsuredSeqNo>1 </InsuredSeqNo>
                                   <InsuredName>' .$data['insureInfo']['name']. '</InsuredName>
                                   <InsuredIdType>' .$data['insureInfo']['type']. '</InsuredIdType>
                                   <InsuredIdNo>' .$data['insureInfo']['identno']. '</InsuredIdNo>
                                   <InsuredBirthday>' .$data['insureInfo']['birthday']. '</InsuredBirthday>
                                   <InsuredIdMobile>' .$data['insureInfo']['tel']. '</InsuredIdMobile>
                                   <InsuredEmail>' .$data['insureInfo']['email']. '</InsuredEmail>
                                   <InsuredAddress>' .$data['insureInfo']['address']. '</InsuredAddress>
                              </Insured>
                         </Insureds>';
          $xml .= '</PolicyInfo></PolicyInfos></ApplyInfo>';
          return $xml;
     }


     public function commonOperate($function){
          try{
               $return = array();

               $client = new \SoapClient('http://test.mypicc.com.cn/ecooperation/webservice/insure?wsdl', array('trace' => TRUE,'cache_wsdl' => WSDL_CACHE_NONE));
               switch ($function) {
                    case 'insures':
                         $res = $client->insureService($this->request);
                         var_dump($res);
                         break;
                    
                    default:
                         return FALSE;
                         break;
               }
               
               $xml = str_replace('GB2312', 'UTF-8', $res->return);
               $data = $this->xmlToArray($xml);
               if ($data['GeneralInfoReturn']['ErrorCode'] != '00') {
                    $return = tool::getSuccInfo(0, $data['GeneralInfoReturn']['ErrorMessage']);
               }
               $message = $data['PolicyInfoReturns']['PolicyInfoReturn']['SaveResult'] .'|'. $data['PolicyInfoReturns']['PolicyInfoReturn'][ 'SaveMessage'] . '|';
               $message .= $data['PolicyInfoReturns']['PolicyInfoReturn']['InsuredReturns']['InsuredReturn']['CheckResult']  .'|'. $data['PolicyInfoReturns']['PolicyInfoReturn']['InsuredReturns']['InsuredReturn']['CheckMessage'] ;
               if ( $data['PolicyInfoReturns']['PolicyInfoReturn']['SaveResult'] == '00' && $data['PolicyInfoReturns']['PolicyInfoReturn']['InsuredReturns']['InsuredReturn']['CheckResult'] == '00') {
                    $return = tool::getSuccInfo(1, $message);
               }else{
                    $return = tool::getSuccInfo(0, $message);
               }
          }
          catch(Exception $e){
               $return = tool::getSuccInfo(0, $e->getMessage());
          }

          return $return;
     }



}
