
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
            <div class="word_box">支付完成</div>
        </div>
         <div class="logoimg_box">
           <div class="sure_order">
            <img class="" src="/nn2/views/pc/images/password/small_1q.png"> 
            <p>确认订单</p>
           </div>
            <div class="pay_order">
            <img class="" src="/nn2/views/pc/images/password/small_2q.png"> 
            <p>支付货款</p>
           </div>
            <div class="plete_order">
            <img class="" src="/nn2/views/pc/images/password/small_3s.png"> 
            <p>支付完成</p>
           </div>
         </div>
        
    </div>
   </div> 
<div class="clearfix"></div> 
 

    <!--主要内容 开始-->
    <div id="mainContent" style="background:#FFF;"> 

          <div class="pay_succeed">
            <div class="sued_top">
              <img src="/nn2/views/pc/images/password/succeed.png" alt="" />
              <p><?php if($info){?><?php echo isset($info)?$info:"";?><?php }else{?>支付完成，订单已生成！<?php }?></p>
            </div>
            <div class="sued_cen">
              <ul>
                <li><b>订单号：</b><span><?php echo isset($order_no)?$order_no:"";?></span></li>
                <li><b>订单总额：</b><span>￥<i><?php echo isset($amount)?$amount:"";?><i></span></li>
                <li><b>已支付：  </b><span class="bfpay">￥<i><?php echo isset($pay_deposit)?$pay_deposit:"";?><i></span></li>
              </ul>

            </div>

            <div class="sued_bottom">
              <a class="goon_look" href="http://localhost/nn2/offers/offerlist">继续浏览</a>
              <a class="hetong_look" href="http://localhost/nn2/user/public/contract/buyerdetail/id/<?php echo $id;?>">查看合同</a>
            </div>
          </div>

    </div> 
    <div class="line_dashed"></div>




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