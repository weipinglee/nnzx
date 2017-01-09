<!DOCTYPE html>
<!-- saved from url=(0070)http://sso.nainaiwang.cn/PasswordReset/Index?ReturnUrl=http://www.nainaiwang.cn/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>耐耐网-找回密码</title>
    <link href="{views:css/password.css}" rel="stylesheet">
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
</head>
<body>
    <div class="login_top">
    <ul class="w1200">
        <li><a href="index.html">首页</a></li>
        <li><a href="product.html">交易中心</a></li>
        <li><a href="news.html">数据中心</a></li>
        <li><a href="auction.html">竞价招投标</a></li>
        <li><a href="shopdetail.html">品牌商户</a></li>
    </ul>
</div>

    <div class="m_log w1200">
        <img src="{views:images/logo_p.jpg}" id="btnImg">
    </div>

    <div class="zhaohui">
        <div class="w1200">
            <h4>找回密码</h4>
            <input type="hidden" value="{url:/login/login}" name="url" id="txtUrl">
            <input type='hidden' value='{url:/login/getMobileCode}' id='codeUrl'>
            <input type='hidden' value='{url:/login/findPassword}' id='findUrl'>
<form action="{url:/login/findPassword}" method="post" id="647727080" auto_submit >                <ul>
                    <li><span class="error red"><span class="field-validation-valid" data-valmsg-for="txtMessage" data-valmsg-replace="true" id="txtMessage"></span></span></li>
                    <li><label>手机号：</label><input type="text" class="text1" id="txtMobile" name="mobile"> </li>
                    <li>
                        <label>验证码：</label><input type="text" class="text1 text1_yzm" id="inputCode" placeholder="请输入验证码"  name="inputCode">
                        <img id="image"src="{url:/login/getCaptcha}" height="45" onclick="this.src='{url:/login/getCaptcha}?'+Math.random()"/>
                    </li>

                    <li><label>验证码：</label><input type="text" class=" text1 text1_yzm" id="txtCode" name="code"> <input type="button" value="获取验证码" class="yzm"> </li>



                    <li><label>新密码：</label><input type="password" class="text1" id="txtPassWord" name="passWord" type="password"> </li>
                    <li><label>确认密码：</label><input type="password" class="text1" id="txtAgainPassWord" name="againPassWord" type="password"> </li>
                    <li><input type="submit" value="提交" class="tj_btn" id="btnSubmit"></li>
                </ul>
</form>        </div>
    </div>

    <div class="w1200 secondaryend">
    <p>Copyright 2014-2016 耐耐云商科技有限公司 www.nainaiwang.cn All Rights Reserved </p>
    <p>
        <a href="#" target="_blank" style="color: #666666;">沪ICP备15028925号</a>
        <a href="#" target="_blank" style="color: #006aa8;">ICP许可证</a>
    </p>
</div>


</body></html>