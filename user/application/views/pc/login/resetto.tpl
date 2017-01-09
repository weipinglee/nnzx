    <link href="{views:css/password_new.css}" rel="stylesheet">

    <script type="text/javascript" src="{root:js/form/formacc.js}" ></script>
    <script type="text/javascript" src="{root:js/form/validform.js}" ></script>
    <script type="text/javascript" src="{root:js/layer/layer.js}"></script>
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
   <div class="toplog_bor">
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
            <div><img class="" src="{views:images/password/two_r.png}"><p>重置密码</p></div>
            <div><img class="" src="{views:images/password/three_g.png}"><p>修改成功</p></div>
           </div>
            <input type="hidden" value="{url:/login/login}" name="url" id="txtUrl">
            <input type='hidden' value='{url:/login/getMobileCode}' id='codeUrl'>
            <input type='hidden' value='{url:/login/findPassword}' id='findUrl'>
<form action="{url:/login/findPassword}" method="post" id="647727080" auto_submit >                <ul>
                    <li><span class="error red"><span class="field-validation-valid" data-valmsg-for="txtMessage" data-valmsg-replace="true" id="txtMessage"></span></span></li>
                    <li><label>新密码：</label><input type="password" datatype="s6-15" class="text1" id="txtPassWord" name="passWord"> </li>
                    <li><label class="margin_left">
                    确认密码：</label><input type="password" class="text1" datatype="*" id="txtAgainPassWord" name="againPassWord" recheck="passWord"> </li>
                    <input type="hidden" name="mobile" value="{$mobile}" id="txtMobile">
                    
                    <li><input type="button" value="下一步" class="tj_btn" id="btnSubmit2"></li>
                </ul>
</form>        </div>
    </div>