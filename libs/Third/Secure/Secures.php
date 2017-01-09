<?php

namespace Third\Secure;

/**
* 
*/
class Secures
{

     /**
      * xml解析为数组，能解析属性
      * @param  [String] $xmlstring [xml字符串]
      * @return [Array]            [xml转化的数组]
      */
     public function xmlToArray($xmlstring) {
          return json_decode(json_encode((array) simplexml_load_string($xmlstring)), true);
     }


     /**
      * 数组解析为xml
      * @param [Array] $data         解析数组
      * @param string $rootNodeName 根节点
      * @param Object $xml              
      */
      public function ArrayToXml($data, $rootNodeName = 'data', $xml=null)
         {
             if (ini_get('zend.ze1_compatibility_mode') == 1)
             {
                 ini_set ('zend.ze1_compatibility_mode', 0);
             }
              
             if ($xml == null)
             {
                    $xmlstring = "<?xml version='1.0' ";
                    if (isset($data['encoding'])) {
                         $xmlstring .= " encoding='{$data['encoding']}'";
                         unset($data['encoding']);
                    }else{
                      $xmlstring .= " encoding='UTF-8'";
                    }

                    if (isset($data['standalone'])) {
                         $xmlstring .= " standalone='{$data['standalone']}'";
                         unset($data['standalone']);
                    }
                    $xmlstring .= "?><$rootNodeName />";
                    $xml = simplexml_load_string($xmlstring);
             }
              
             foreach($data as $key => $value)
             {
                 if (is_numeric($key))
                 {
                     $key = "unknownNode_". (string) $key;
                 }
                  
                 $key = preg_replace('/[^a-z]/i', '', $key);
                  
                 if (is_array($value))
                 {
                     $node = $xml->addChild($key);
                     $this->ArrayToXml($value, $rootNodeName, $node);
                 }
                 else
                 {
                     $value = htmlentities($value);
                     $xml->addChild($key,$value);
                 }   
             }
             return $xml->asXML();
        }


     

    function writelog($filename='', $content, $openmod='w') {
     $type = 'NOTIC:';
     $log = '['.$this->classname."]\t". date('Y-m-d H:i:s', time())."\t$type\t".str_replace(array("\r", "\n"), array(' ', ' '), trim($content))."\r\n";
          $this->swritefile($filename, $log, 'a');
    }

     //写入文件
     function swritefile($filename, $writetext, $openmod='w') {
          //echo $filename;exit;
          if(!file_exists($filename))
          {
               touch($filename);
          }
          if(@$fp = fopen($filename, $openmod)) {
               flock($fp, 2);
               fwrite($fp, $writetext);
               fclose($fp); //echo $fp; exit;
               return true;
          } else {
               //$this->runlog('error', "File: $filename write error.");
               return false;
          }
     }

}