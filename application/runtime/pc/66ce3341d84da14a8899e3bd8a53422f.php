
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0038)http://www.nainaiwang.com/#index_banner6 -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" /><title>
        耐耐网
    </title><meta name="Keywords" content="耐火材料、耐耐网"><meta name="Description" content="耐火材料、耐耐网">
    <script type="text/javascript" defer="" async="" src="/nn2/views/pc/js/uta.js"></script>
    <script src="/nn2/views/pc/js/jquery-1.7.2.min.js" type="text/javascript" language="javascript"></script>
    <script src="/nn2/views/pc/js/gtxh_formlogin.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/index20141027.css">
    <script src="/nn2/views/pc/js/index20141027.js" type="text/javascript"></script>
    <script type="text/javascript" src="/nn2/views/pc/js/product_details_js.js"></script>
    <link rel="stylesheet" href="/nn2/views/pc/css/classify.css">
    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/password_new.css">
    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/submit_order.css"/>
    <script type="text/javascript" src="/nn2/js/form/validform.js" ></script>
    <script type="text/javascript" src="/nn2/js/form/formacc.js" ></script>
    <script type="text/javascript" src="/nn2/js/layer/layer.js"></script>
    <script type="text/javascript" src="/nn2/js/layer/extend/layer.ext.js"></script>
    <script type="text/javascript" src="/nn2/views/pc/js/area/Area.js" ></script>
    <script type="text/javascript" src="/nn2/views/pc/js/area/AreaData_min.js" ></script>
    <link href="/nn2/views/pc/css/topnav20141027.css" rel="stylesheet" type="text/css">
    <!--[if lte IE 6]>
    <script>
        $(function(){
            $(".kind_name").mouseover(function(){
                $(".kind_sort").hide();
                $(this).next().show();
                $(this).css("border-bottom","2px solid #e50102");
                $(this).css("border-top","2px solid #e50102");
            });
            $(".kind_list").mouseleave(function(){
                $(".kind_sort").hide();
                $(".kind_name").css("border-bottom","1px solid #eaeaea");
                $(".kind_name").css("border-top","none");
            });

        });
    </script>
    <![endif]-->

</head>
<body>


<!--[if lte IE 6]>
<div style="width:100%;_position:absolute;
_bottom:auto;
_top:expression(eval(document.documentElement.scrollTop));
z-index:1000;">
    <div style="width:100%;height:30px;border-bottom:1px solid #ff5a00;background:#ffede3;color:#444;line-height:30px; text-align:center;">
        系统检测您当前的浏览器为IE6，可能会影响部分功能的使用。为了您有更好的体验。建议您<a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank" style="color:#c81624;text-decoration:underline;">升级IE浏览器</a>或者下载安装使用<a href="http://dlsw.baidu.com/sw-search-sp/soft/9d/14744/ChromeStandalone_V43.0.2357.124_Setup.1433905898.exe" target="_blank" style="color:#c81624;text-decoration:underline;">谷歌浏览器chrome</a>
    </div>
    <style>
        body{_padding-top:30px;}
    </style>
</div>
<![endif]-->

<!------------------公用头部控件 开始-------------------->
 <div class="login_top">
    <ul class="w1200">
      <ul class="topnav_left">
        <li><a href="http://124.166.246.120:8000/user/public/index/index"><img class="shouy mobil" src="/nn2/views/pc/images/password/shouy.png">耐耐网首页</a></li>
        <li class="space">
          <?php if(isset($username)){?>您好，
                <a rel="external nofollow"  href="http://localhost/nn2/user/public/ucenterindex/index"  target="_blank" class=""><?php echo isset($username)?$username:"";?></a>
                <?php }else{?>
                <span>您好，欢迎进入耐耐网</span>
            <?php }?>
        </li>
        <?php if($login==0){?>
            <li><a href="http://localhost/nn2/user/public/login/login" target="_blank">请登录</a></li>
            <li><a href="http://localhost/nn2/user/public/login/register" target="_blank">欢迎注册</a></li>
            <?php }else{?>
            <li><a href="http://localhost/nn2/user/public/login/logout" target="_blank">退出</a></li>
        <?php }?>
      </ul>
      <div class="topnav_right">
      <ul >
        <!-- <li><a href="">会员中心</a><i>|</i></li>
        <li><a href="">我的合同</a><i>|</i></li> -->
        <li><a href="http://localhost/nn2/user/public/message/usermail">消息中心<?php if($login==1){?><em class="information"><?php echo isset($mess)?$mess:"";?></em><?php }?></a><i>|</i></li>
        <!-- <li><a href=""><img class="shouy mobil" src="/nn2/views/pc/images/password/mobile.png">手机版</a><i>|</i></li> -->
        <li><a href="javascript:;" onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&sid=4006238086&o=new.nainaiwang.com&q=7', '_blank', 'height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');"  border="0" SRC=http://wpa.qq.com/pa?p=1:4006238086:1 alt="点击这里给我发消息">在线客服</a><i>|</i></li>
        <li>交易时间&nbsp;<?php echo isset($deal['start_time'])?$deal['start_time']:"";?>--<?php echo isset($deal['end_time'])?$deal['end_time']:"";?></li>
     </ul>  
     </div>
    </ul>
</div>

   <div class="toplog_bor">
    <div class="m_log w1200">
        <div class="logoimg_left">
            <div class="img_box"><img class="shouy" src="/nn2/views/pc/images/password/logo.png" id="btnImg"></div>
            <div class="word_box">确认订单</div>
        </div>
         <div class="logoimg_box">
           <div class="sure_order">
            <img class="" src="/nn2/views/pc/images/password/small_1s.png"> 
            <p>确认订单</p>
           </div>
            <div class="pay_order">
            <img class="" src="/nn2/views/pc/images/password/small_2h.png"> 
            <p>支付货款</p>
           </div>
            <div class="plete_order">
            <img class="" src="/nn2/views/pc/images/password/small_3h.png"> 
            <p>支付完成</p>
           </div>
         </div>
        
    </div>
   </div> 
<div class="clearfix"></div> 

<form method="post" <?php if($data['show_payment']){?>pay_secret="1" has_secret="http://localhost/nn2/index.php/trade/hasPaySecret/"<?php }?> auto_submit="1" action='http://localhost/nn2/index.php/trade/buyerPay/?callback=http://124.166.246.120:8000/user/public/offers/check/id/<?php echo $data['id'];?>/pid/<?php echo $data['product_id'];?>'>

    <!--主要内容 开始-->
    <div id="mainContent" style="background:#FFF;"> 
    
        <div class="page_width">

         <div class="submit_word">
               <h3 class="sure_oder">填写并核对订单信息</h3>
               <a id="contract_review" href="http://localhost/nn2/user/public/contract/contract/offer_id/<?php echo $data['id'];?>/num/<?php echo $data['minimum'];?>" target='_blank'>
               <img src="/nn2/views/pc/images/password/eye_b.png" alt="" />
               <i>合同预览</i>
               </a>
         </div>  
                
        <div class="order_form suo">
            <table border="1">
               <tr class="form_bor" height="50">
               <th width="25%" bgcolor="#fafafa">产品详情</th>
               <th width="15%" bgcolor="#fafafa">规格</th>
               <th width="15%" bgcolor="#fafafa">单位</th>
               <th width="15%" bgcolor="#fafafa">单价（元）</th>
               <th width="15%" bgcolor="#fafafa">数量(最小起订量：<?php echo isset($data['minimum'])?$data['minimum']:"";?> 剩余:<?php echo isset($data['left'])?$data['left']:"";?>) </th>
               <th width="15%" bgcolor="#fafafa">总额</th>
               </tr>
               <tr class="form_infoma">
               <td class="product_img" >
                   <img src="<?php echo isset($data['img'])?$data['img']:"";?>" alt="" />
                   <div class="produ_left">
                    <p><?php echo isset($data['cate_chain'])?$data['cate_chain']:"";?></p>
                    <p><?php echo isset($data['name'])?$data['name']:"";?></p>
                   </div>

               </td>
               <td class="guige">
                   <?php if(!empty($data['attr_arr'])) foreach($data['attr_arr'] as $key => $item){?>
                       <p><?php echo isset($key)?$key:"";?>:<?php echo isset($item)?$item:"";?></p>
                   <?php }?>
               </td>
               <td><?php echo isset($data['unit'])?$data['unit']:"";?></td>
               <td class="price"><i>￥</i><span><?php echo isset($data['price'])?$data['price']:"";?></span></td>
               <td>
                 <div class="counter">
                 <?php if($data['fixed']){?>
                    <?php echo isset($data['minimum'])?$data['minimum']:"";?>
                    <input type="hidden" name="num" value="<?php echo isset($data['minimum'])?$data['minimum']:"";?>"/>
                 <?php }else{?>
                    <input id="min" name="" type="button" value="-" />  
                    <input id="text_box" name="num" type="text" value="<?php echo isset($data['minimum'])?$data['minimum']:"";?>"/>  
                    <input id="add" name="" type="button" value="+" />  
                 <?php }?>
                  
                </div>



               </td>
               <td class="price"><i>￥</i><span class="prod_amount"><?php echo isset($data['amount'])?$data['amount']:"";?></span></td>
               </tr>
           </table>
        </div> 


           
            
            <!----第一行搜索  开始---->
            <div class="mainRow1 sure">
                <!--搜索条件 开始-->

             <!------------------订单 开始-------------------->
            <div class="submit">
             
             
            
               
            
            <div class="checkim">
           
            
             <?php if($data['show_payment']){?>
                <div class="zhiffs"><b>支付方式</b>
                  <h3 class="addwidth">

                   <div class="yListr">
                     
                           <ul>
                               <li><em class="yListrclickem" paytype='0'>定金支付<i></i></em> <em paytype='1'>全款支付<i></i></em></li>
                               
                           </ul>
                            <input type="hidden" name="paytype" value="0" />
                     </div> 
                    </h3> 
                  </div>
                  <div class="zhiffs"><b>账户类型</b>
                  <h3 class="addwidth">

                   <div class="yListr bank">
                           <ul>
                              <li><em class="yListrclickem" account='1'>市场代理账户<i></i></em>

                                    <em account='2' class="qianyue" id="click_show">银行签约账户<i></i></em></li>

                           </ul>
                           <input type="hidden" name="account" value="1" />   
                     </div>
                     <div class="bank_box" style="display:none;">
                      <!--  <label for=""><input type="radio" name="bank"/></label><img src="/nn2/views/pc/images/password/bank_js.png" alt="" />
                       
                        <label for=""><input type="radio" name="bank"/></label><img src="/nn2/views/pc/images/password/bank_pa.png" alt="" /> -->
                        
                        <label for=""><input type="radio" checked="checked" name="bank"/></label><img src="/nn2/views/pc/images/password/bank_zx.png" alt="" />
                     </div>
             <script>
                 $(function(){
                   $(".yListr.bank li em").click(function(){
                    $(".bank_box").hide();
                  });

                  $(".yListr.bank #click_show").click(function(){
                    $(".bank_box").show();
                  });
                  
                 });

             </script>
              
              <?php }?>
                    </h3> 
                   </div>  
                   <div class="zhiffs"><b>是否开具发票</b>
                  <h3 class="addwidth">

                   <div class="yListr">
                           <ul>
                              <li><em  invoice='1'>开发票<i></i></em> <em invoice='2' class="yListrclickem">不开发票<i></i></em></li>
                           </ul>
                           <input type="hidden" name="invoice" value="2" />
                     </div> 
                    </h3> 
                   </div>      
              </div>     
             <script type="text/javascript">
                 $(function() {
                     $(".yListr ul li em").click(function() {
                         $(this).addClass("yListrclickem").siblings().removeClass("yListrclickem");
                     })
                 })
             </script>  
            
             <!-------------------------- -->                
            
            <span class="jiesim"><h3></h3> </span>  

            <div class="zhiffs" style="margin:35px 0px;">
              <b class="trans" style="width:auto;padding-left:35px;height:25px;line-height:25px;">物流方式：物流自提</b>
            </div>
            <span class="jiesim"><h3></h3> </span>   
            <div class="intur_box">
            <span class="daizfji"><span class="zhifjin"><strong>数量：</strong><b class='prod_num'><?php echo isset($data['minimum'])?$data['minimum']:"";?></b><?php echo isset($data['unit'])?$data['unit']:"";?></span></span>
            <span class="daizfji"><span class="zhifjin"><strong>总额：</strong><i>￥</i><b class='prod_amount'><?php echo isset($data['amount'])?$data['amount']:"";?></b></span></span>
            <?php if($data['show_payment']){?>
            <span class="daizfji"><span class="zhifjin"><strong>定金：</strong><i>￥</i><b class="pay_deposit"><?php echo isset($data['minimum_deposit'])?$data['minimum_deposit']:"";?></b></span></span><?php }?>
           </div>    
           <div class="order_comit">
              <input type="hidden" name="id" value="<?php echo isset($data['id'])?$data['id']:"";?>" />
             <?php if($data['left'] == 0){?>
                <a style="display:block;padding: 8px 20px;background: gray;margin-top:20px;color:#fff;border-radius: 5px;font-size:16px;" href="javascript:;">已成交</a>
             <?php }else{?>
                 <?php if( $data['insurance'] == 0){?>
                   <!--  <a  style="display:block;padding: 8px 20px;background: gray;margin-top:20px;color:#fff;border-radius: 5px;font-size:16px;" href="http://localhost/nn2/user/public/insurance/apply?<?php  echo http_build_query(array('id' => $data['id'])); ?>" >申请保险</a> -->
                <?php }?>
                <a class="btoncomit" href="javascript:;" >提交订单</a>
             <?php }?>
            <!-- <a class="btoncomit" href="submit_order-3.html">提交订单</a> -->
            <?php if($data['show_payment']){?><span>应支付金额：<i>￥</i><b class='pay_deposit'><?php echo isset($data['minimum_deposit'])?$data['minimum_deposit']:"";?></b></span><?php }?>
            
            </div> 


             </div>
       <!------------------订单 结束-------------------->

              
    </div>
</div>  
</div> 
    <!--主要内容 结束-->

</form>

    <script type="text/javascript">
                
                $(function(){
                    var num_input = $('input[name=num]');
                    var deposit_text = $('.pay_deposit');
                    var prod_amount = $('.prod_amount');
                    var left = parseFloat(<?php echo isset($data['left'])?$data['left']:"";?>);
                    var quantity = parseFloat("<?php echo isset($data['quantity'])?$data['quantity']:"";?>");
                    var minimum = parseFloat("<?php echo isset($data['minimum'])?$data['minimum']:"";?>");
                    var divide = parseInt("<?php echo isset($data['divide'])?$data['divide']:"";?>");
                    var price = <?php echo isset($data['price'])?$data['price']:"";?>;
                    var minimum_deposit = <?php echo isset($data['minimum_deposit'])?$data['minimum_deposit']:"";?>;
                    var left_deposit = <?php echo isset($data['left_deposit'])?$data['left_deposit']:"";?>;
                    var minimum_step = 1;
                    var temp_deposit = deposit_text.eq(1).text();
                    var paytype = 0;
                    var global_num = minimum;

                    check();

                    bindmin();
                    bindadd();


                    $('input[name=num]').blur(function(){
                        check();
                    });

                    $('.btoncomit').click(function(){
                        
                        if(<?php echo isset($user_id)?$user_id:"";?> == 0){
                          window.location.href='http://localhost/nn2/user/public/login/login'+'?callback='+window.location.href;
                        }else{
                          if(<?php echo isset($no_cert)?$no_cert:"";?>){
                            layer.msg('该商品的发布商家资质不够，暂时不能购买');
                          }else{
                            if(isnum_valid()) {
                                $(this).parents('form').submit();
                            }  
                          }
                        }
                        


                    });

                    $(".yListr ul li em").click(function() {
                         paytype = $(this).attr('paytype');
                         var account = $(this).attr('account');
                         var invoice = $(this).attr('invoice');
                         $(this).addClass("yListrclickem").siblings().removeClass("yListrclickem");
                         $(this).parents('ul').siblings('input[name=paytype]').val(paytype);
                         $(this).parents('ul').siblings('input[name=account]').val(account);
                         $(this).parents('ul').siblings('input[name=invoice]').val(invoice);
                         
                         if(paytype){
                             if(paytype == 1){
                                //全款
                                deposit_text.text(prod_amount.eq(0).text());
                             }else{
                                deposit_text.text(temp_deposit);
                             }
                        }
                     })

                    function isnum_valid(){
                        var flag = false;
                        var num = parseFloat(num_input.val());
                        if(num != global_num && (num-global_num)%minimum_step != 0){
                          layer.msg('不符合最小起步量');
                          num_input.val(global_num);
                        }else{
                          if(divide == 0){
                              if(num != quantity){
                                  layer.msg('此商品不可拆分');
                              }else{
                                  flag = true;
                              }
                          }else{
                              if(left>minimum) { //剩余量大于最小起订量
                                  if (num < minimum) {
                                      num_input.val(minimum);
                                      deposit_text.text(paytype == 1 ? minimum * price : minimum_deposit);
                                      temp_deposit = minimum_deposit;
                                      prod_amount.text(minimum * price);
                                      temp_num = minimum;
                                      layer.msg('小于最小起订量');
                                  }
                                  else if (num > left) {
                                      num_input.val(left);
                                      deposit_text.text(paytype == 1 ? left * price : left_deposit);
                                      temp_deposit = left_deposit;
                                      prod_amount.text(left * price);
                                      temp_num = left;
                                      layer.msg('超出剩余数量');
                                  } else {
                                      temp_num = num;
                                      flag = true;
                                  }
                                  global_num = temp_num;
                                  $('#contract_review').attr('href',$('#contract_review').attr('href')+"/num/"+temp_num);
                                  $('.prod_num').text(temp_num);
                              }
                              else if(num==left){
                                  flag = true;
                              }
                          }
                        }
                        return flag;
                    }

                    function check(){
                      var num = parseFloat(num_input.val());
                      var id = $('input[name=id]').val();
                      var flag = isnum_valid();
                      if(flag && <?php echo isset($data['show_payment'])?$data['show_payment']:"";?>){
                          layer.load(2);
                          unbindmin();
                          unbindadd();
                          $.post("http://localhost/nn2/offers/paydepositcom",{id:id,num:num,price:price},function(data){
                              layer.closeAll();
                              bindmin();
                              bindadd();
                              if(data.success == 1){
                                  var total = num*price;
                                  prod_amount.text(total.toFixed(2));
                                  deposit_text.text(paytype == 1 ? total.toFixed(2): data.info.toFixed(2));
                                  
                                  temp_deposit = data.info;
                                  $('#contract_review').attr('href',$('#contract_review').attr('href')+"/num/"+num);
                              }else{
                                  layer.msg(data.info);
                              }
                          },"json");
                      }else if(flag && !<?php echo isset($data['show_payment'])?$data['show_payment']:"";?>){
                        var total = num*price;
                        prod_amount.text(total.toFixed(2));
                      }
                    }

                    function bindmin(){
                      $('#min').click(function(){
                        num = parseFloat(num_input.val())-minimum_step;
                        num_input.val(num.toFixed(2));
                        check();
                      });
                    }
                    function unbindmin(){
                      $('#min').unbind('click');
                    }

                    function bindadd(){
                      $('#add').click(function(){
                        num = parseFloat(num_input.val())+minimum_step;
                        num_input.val(parseFloat(num).toFixed(2));
                        check();
                      });
                    }

                    function unbindadd(){
                      $('#add').unbind('click');
                    }
                })


            </script>






<link href="/nn2/views/pc/css/footer.css" rel="stylesheet" type="text/css" />
<div id="footer">

    <div class="fotter_bq ">
         <div>
            Copyright&nbsp;&nbsp; © 2000-2015&nbsp;&nbsp;耐耐云商科技有限公司&nbsp;版权所有&nbsp;&nbsp; 网站备案/许可证号:沪ICP备15028925号
        </div>
        <div>
            服务电话：4006238086 地址:上海浦东新区唐镇上丰路977号b座
        </div>
        <div>
            增值电信业务经营许可证沪B2-20150196
        </div>
    </div>

</div>

</body>
</html>