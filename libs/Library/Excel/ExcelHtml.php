<?php 

namespace Library\Excel;
class ExcelHtml{
     private $_sleep_time = 2000000; //休眠时间
     private $_sleep_count = 2000; //每次计算休眠，分批的次数

     /*$ext_parm =array('is_put_file'=>1); 调用对应文件添加此参数代表直接可以缓存文本方式,不会在浏览器弹出报表2014/12/8@wangye
        同时使用此参数$file_name参数可以为空,
        $arr参数为调用的数据,colspan_count为列数值
     */
     function createExecl($arr=array(), $colspan_count, $file_name='', $ext_parm=array())
     {

          $output = $this->creatExcellHeader($file_name, $colspan_count, $ext_parm);
        $output .= $this->creatExcellBody($arr, 2000);
        $output .= $this->creatExcellFooter();

          if(!isset($ext_parm['is_put_file'])){
               echo $output;
          }
          else{
               return $output;
          }
          
                              
     }
     
     /**
      * [creatExcellHeader 制作execel头部]
      * @param  [type] $outName       [文件名]
      * @param  [type] $colspan_count [多少列]
      * @param  [type] $ext_parm      [是否输出]
      * @return [String]                [html头部]
      */
      public function creatExcellHeader($outName, $colspan_count, $ext_parm) {
            header ( "Content-type:application/vnd.ms-excel" );
            header ( "Content-Disposition:filename={$outName}.xls" );

            header("Cache-control: private");
            header("Pragma: private");

           $output = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
            $output .= "<HTML xmlns='http://www.w3.org/1999/xhtml'>";
            $output .= "<HEAD>";
            $output .= "<META http-equiv=Content-Type content=\"text/html; charset=utf-8\">";
            $output .= "<style>
     td{
          text-align:center;
          font-size:12px;
          font-family:Arial, Helvetica, sans-serif;
          border:#1C7A80 1px solid;
          color:#152122;
     }
     table,tr{
          border-style:none;
     }
     .title{
          background:#7DDCF0;
          color:#FFFFFF;
          font-weight:bold;
     }
     </style>";
            $output .= "</HEAD>";
            $output .= "<BODY>";
            $output .= "<TABLE BORDER=1>";
            $output .= "<tr>
          <td class='title' colspan={$colspan_count} style='width:500px;text-align:left;'>{$outName}</td>
       </tr>";
            return $output;
        }

        /**
         * [creatExcellBody 制作表格每一行]
         * @param  [Array] $data        [数组]
         * @param  [int] $sleep_count [从多少行开始休眠]
         * @return [String]              [表格每行]
         */
        public function creatExcellBody($data, $sleep_count) {
          $datakeys= array_keys($data[0]);
            $datakey = array_keys($data[1]);
               $output  = '';
            if($data)
            {
                    foreach ((array)$data as $key => $value) {
                            $output .= '<tr>';
                            if (0 == $key) {
                              foreach ((array)$datakeys as $v) {
                                    $output .= "<td width='140' >{$value[$v]}</td>";
                              }
                            }else{
                              foreach ((array)$datakey as $v) {
                                    $output .= "<td width='140' >{$value[$v]}</td>";
                              }
                            }
                            $output .= '</tr>';

                            if ($key == $sleep_count) {
                              usleep($this->_sleep_time);
                                        $sleep_count += $this->_sleep_count;
                            }
                    }
            }
            return $output;
        }

        /**
         * [creatExcellFooter excel 底部]
         * @return [String] [html]
         */
        public  function creatExcellFooter(){
            $output = "</TABLE>";
            $output .= "</BODY>";
            $output .= "</HTML>";
            return $output;
        }
}
?>