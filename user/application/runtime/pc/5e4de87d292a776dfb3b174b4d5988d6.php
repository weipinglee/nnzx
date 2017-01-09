<!DOCTYPE html>
<html>
<head>
  <title>耐耐网</title>
  <meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" />
  <meta name="keywords"/>
  <meta name="description"/>
  <meta charset="utf-8">
  
</head>
<body>
  <div class="login_top">
    <ul class="w1200">
      <ul class="topnav_left">
        <li><a href="http://124.166.246.120:8000/user//index/index"><img class="shouy" src="/nn2/user/views/pc/images/password/shouy.png"><span class="inde_txt">耐耐网首页</span></a></li>
        <li class="space">您好，欢迎进入耐耐网</li>
        <li><a href="http://localhost/nn2/user/login/login">请登录</a></li>
        <li><a href="http://localhost/nn2/user/login/register">欢迎注册</a></li>
      </ul>
      <ul class="topnav_right">
        <!--<li><a href="">会员中心</a><i>|</i></li>
        <li><a href="">我的合同</a><i>|</i></li>
        <li><a href="">消息中心</a><i>|</i></li>
        <li><a href=""><img class="shouy icon" src="/nn2/user/views/pc/images/password/mobile.png">手机版</a><i>|</i></li>-->
        <li><a href="javascript:;" onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&sid=4006238086&o=new.nainaiwang.com&q=7', '_blank', 'height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');"  border="0" SRC=http://wpa.qq.com/pa?p=1:4006238086:1 alt="点击这里给我发消息">在线客服</a><i>|</i></li>
        <li>交易时间&nbsp;<?php echo isset($deal['start_time'])?$deal['start_time']:"";?>--<?php echo isset($deal['end_time'])?$deal['end_time']:"";?></li>
     </ul>  
    </ul>
</div>            
<link href="/nn2/user/views/pc/css/password_new.css" rel="stylesheet">
  <link href="/nn2/user/views/pc/css/home.css?v=2" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="/nn2/user/js/jquery/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="/nn2/user/views/pc/js/login.js"></script>
  <script type="text/javascript" src="/nn2/user/views/pc/js/common.js"></script>
  
<script type="text/javascript" >
  var logPath = 'http://localhost/nn2/user/login/dolog';
</script>


   <div class="toplog_bor none">
    <div class="m_log w1200">
        <div class="logoimg_left">
            <div class="img_box"><img class="shouy" src="/nn2/user/views/pc/images/password/logo.png" id="btnImg"></div>
            <div class="word_box">欢迎登录</div>

  

        </div>
         <div class="logoimg_right">
            <img class="shouy" src="/nn2/user/views/pc/images/password/iphone.png"> 
            <h3>服务热线：<b>400-6238-086</b></h3>
         </div>
        
    </div>
   </div> 
<div class="wrap">
  
 <div  class="bacg_img"> 
  <div class="container">
    <div class="register-box">
      <div class="reg-slogan"><h5>会员登录</h5><span>还没有会员帐号？<a href="http://localhost/nn2/user/login/register">免费注册</a></span></div>

      <div class="reg-form" id="js-form-mobile"> <br>
        <span id="error_info"></span>
        <br>
        <input type="hidden" name="callback" value="<?php echo isset($callback)?$callback:"";?>" />
        <div class="cell">
           <img  src="/nn2/user/views/pc/images/password/data.png"> 
           <input type="text" name="mobile" id="js-mobile_ipt" class="text" maxlength="20" placeholder="用户名/手机号"/>
        </div>
        <div class="cell">
          <img  src="/nn2/user/views/pc/images/password/account.png"> 
          <input type="password" name="passwd" id="js-mobile_pwd_ipt" class="text" placeholder="密码"/>
        </div>
        <!-- !验证码 -->
        <div class="cell vcode">
          <img class="vcode_img" src="/nn2/user/views/pc/images/password/yanzm.png">
          <input type="text" name="code" id="js-mobile_vcode_ipt" class="text" maxlength="4" placeholder="验证码"/>
       <a id='chgCode' href="javascript:void(0)" onclick="changeCaptcha('http://localhost/nn2/user/login/getcaptcha?w=200&h=50',$(this).find('img'))"><img src="http://localhost/nn2/user/login/getcaptcha?w=200&h=50" /></a>
        </div>
        <div class="mamory">
          <!-- <span><label for=""><input type="checkbox" checked="checked"></label>记住密码</span> -->
          <a href="http://localhost/nn2/user/login/passwordreset">忘记密码?</a>
        </div>
        <div class="bottom">
          <a id="js-mobile_btn" href="javascript:void(0);" class="button btn-green" onclick="double_submit()">登&nbsp;&nbsp;录</a>
        </div>
		
      </div>
    </div>
  </div>
  </div>
</div>
<script type="text/javascript">
  $(function(){
    document.onkeydown=function(event){
      e = event ? event :(window.event ? window.event : null);
      if(e.keyCode==13){
        double_submit();
      }
    }
  })
</script>


<!--公用底部控件 开始-->
<div class="background_img bottom"></div>
    <div class="w1200 secondaryend">
    <p>Copyright&nbsp;&nbsp; © 2000-2016&nbsp;&nbsp;耐耐云商科技有限公司&nbsp;版权所有&nbsp;&nbsp;网站备案/许可证号：沪ICP备15028925号</p>
    <p>服务电话：4006238086&nbsp;地址：上海浦东新区唐镇上丰路977号B座</p>
    <p>
        增值电信业务经营许可证沪B2-20150196
        <!-- <a href="#" target="_blank" style="color: #666666;">沪ICP备15028925号</a>
        <a href="#" target="_blank" style="color: #006aa8;">ICP许可证</a> -->
    </p>
</div>
</body>
</html>