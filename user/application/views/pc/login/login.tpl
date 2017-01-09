<link href="{views:css/password_new.css}" rel="stylesheet">
  <link href="{views:css/home.css?v=2}" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="{root:js/jquery/jquery-1.7.2.min.js}"></script>
  <script type="text/javascript" src="{views:js/login.js}"></script>
  <script type="text/javascript" src="{views:js/common.js}"></script>
  
<script type="text/javascript" >
  var logPath = '{url:/login/doLog}';
</script>


   <div class="toplog_bor none">
    <div class="m_log w1200">
        <div class="logoimg_left">
            <div class="img_box"><img class="shouy" src="{views:images/password/logo.png}" id="btnImg"></div>
            <div class="word_box">欢迎登录</div>

  

        </div>
         <div class="logoimg_right">
            <img class="shouy" src="{views:images/password/iphone.png}"> 
            <h3>服务热线：<b>400-6238-086</b></h3>
         </div>
        
    </div>
   </div> 
<div class="wrap">
  
 <div  class="bacg_img"> 
  <div class="container">
    <div class="register-box">
      <div class="reg-slogan"><h5>会员登录</h5><span>还没有会员帐号？<a href="{url:/login/register}">免费注册</a></span></div>

      <div class="reg-form" id="js-form-mobile"> <br>
        <span id="error_info"></span>
        <br>
        <input type="hidden" name="callback" value="{$callback}" />
        <div class="cell">
           <img  src="{views:images/password/data.png}"> 
           <input type="text" name="mobile" id="js-mobile_ipt" class="text" maxlength="20" placeholder="用户名/手机号"/>
        </div>
        <div class="cell">
          <img  src="{views:images/password/account.png}"> 
          <input type="password" name="passwd" id="js-mobile_pwd_ipt" class="text" placeholder="密码"/>
        </div>
        <!-- !验证码 -->
        <div class="cell vcode">
          <img class="vcode_img" src="{views:images/password/yanzm.png}">
          <input type="text" name="code" id="js-mobile_vcode_ipt" class="text" maxlength="4" placeholder="验证码"/>
       <a id='chgCode' href="javascript:void(0)" onclick="changeCaptcha('{url:/login/getCaptcha}?w=200&h=50',$(this).find('img'))"><img src="{url:/login/getCaptcha}?w=200&h=50" /></a>
        </div>
        <div class="mamory">
          <!-- <span><label for=""><input type="checkbox" checked="checked"></label>记住密码</span> -->
          <a href="{url:/login/PasswordReset}">忘记密码?</a>
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
