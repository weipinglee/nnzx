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
            $("#login").click(function () {
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
            <div><img class="" src="{views:images/password/one_q.png}"><p>验证手机号</p></div>
            <div><img class="" src="{views:images/password/two_q.png}"><p>重置密码</p></div>
            <div><img class="" src="{views:images/password/three_r.png}"><p>修改成功</p></div>
           </div>
            <input type="hidden" value="{url:/login/login}" name="url" id="txtUrl">      
               <ul class="mar_top">
                    <li><span class="error red"><span class="field-validation-valid" data-valmsg-for="txtMessage" data-valmsg-replace="true" id="txtMessage"></span></span></li>
                    <li><h3>恭喜您，新密码设置成功！</h3></li>


                    <li><input type="button" value="立即登录" class="tj_btn success" id="login"></li>
                </ul> </div>
    </div>