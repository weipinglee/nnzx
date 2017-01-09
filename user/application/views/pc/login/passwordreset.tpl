    <link href="{views:css/password_new.css}" rel="stylesheet">
    <script src="{views:js/jquery-1.8.0.min.js}"></script>
    <script src="{views:js/jquery.extend.js}"></script>
    <script src="{views:js/pub_js.js}"></script>
    <script src="{views:js/passwordReset.js}"></script>
    <script type="text/javascript">

        $(function () {
            $("#btnImg").click(function () {
                window.location = $("#txtUrl").val();
            });
        })
    </script>

   <div class="toplog_bor none">
    <div class="m_log w1200">
        <div class="logoimg_left">
            <div class="img_box"><img class="shouy" src="{views:images/password/logo.png}" id="btnImg"></div>
            <div class="word_box">找回密码</div>

  

        </div>
         <div class="logoimg_right">
            <img class="shouy" src="{views:images/password/iphone.png}"> 
            <h3>服务热线：<b>400-6238-086</b></h3>
         </div>
        
    </div>
   </div> 
  <div class="zhaohui">
        <div class="w1200">
           <div class="step_box">
            <div><img class="" src="{views:images/password/one_r.png}"><p>验证手机号</p></div>
            <div><img class="" src="{views:images/password/two_g.png}"><p>重置密码</p></div>
            <div><img class="" src="{views:images/password/three_g.png}"><p>修改成功</p></div>
           </div>
            <input type="hidden" value="{url:/login/login}" name="url" id="txtUrl">
            <input type='hidden' value='{url:/login/getMobileCode}' id='codeUrl'>
            <input type='hidden' value='{url:/login/checkMobileCode}' id='findUrl'>
            <input type='hidden' value='{url:/login/getUserInfo}' id='getUrl'>
<form action="{url:/login/checkMobileCode}" method="post" id="647727080" auto_submit >                <ul>
                    <li><span class="error red"><span class="field-validation-valid" data-valmsg-for="txtMessage" data-valmsg-replace="true" id="txtMessage"></span></span></li>
                    <li>
                        <label>手机号：</label><input type="text" class="text1" id="txtMobile" name="mobile"> 
                    </li>
                     <li>
                        <label class="yanzm">验证码：</label><input type="text" class="text1 text1_yzm" id="inputCode" placeholder="请输入验证码"  name="inputCode">
                        <img id="image" src="{url:/login/getCaptcha}" onclick="this.src='{url:/login/getCaptcha}?'+Math.random()"/>
                    </li>
                    <li>
                        <label>校验码：</label><input type="text" class=" text1 text1_yzm" id="txtCode" name="code"> <input  id="yzmBtn" type="button" value="获取校验码" class="yzm"> 
                    </li>
                   

                    <input type="hidden" name="uid" id="uid" value="">


                    <li><input type="button" value="下一步" class="tj_btn" id="btnSubmit"></li>
                    
                </ul>
</form>        </div>
    </div>