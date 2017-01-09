  <link href="{views:css/password_new.css}" rel="stylesheet">
  <link href="{views:css/home.css?v=2}" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="{root:js/jquery/jquery-1.7.2.min.js}"></script>
  <script type="text/javascript" src="{views:js/login.js}"></script>
  <script type="text/javascript" src="{views:js/common.js}"></script>
<script type="text/javascript" >
  var logPath = '{url:/login/doLog}';
</script>


   <div class="toplog_bor">
    <div class="m_log w1200">
        <div class="logoimg_left">
            <div class="img_box"><img class="shouy" src="{views:images/password/logo.png}" id="btnImg"></div>
            <div class="word_box">欢迎注册</div>

  

        </div>
         <div class="logoimg_right">
            <img class="shouy" src="{views:images/password/iphone.png}"> 
            <h3>服务热线：<b>400-6238-086</b></h3>
         </div>
        
    </div>
   </div> 
<div class="wrap">
  
 <div  class="bacg_img succeed"> 
  

    <div class="happy_img">
      <img class="" src="{views:images/password/succeed.png}"> 
      <p class="big_word">恭喜您已注册成功！</p>
      <p>为了您更好的交易，请及时进行认证</p>
    </div>
    <div class="two_btn">
      <a class="reging" href="{url:/ucenter/dealcert}">进行认证</a>
      <a class="faleindex" href="{url:/index/index@deal}">回到首页</a>
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
