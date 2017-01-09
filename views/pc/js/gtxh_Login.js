/// <reference path="jquery-1.7.2.min.js" />

$().ready(function () {
    UserLogin(true);

    $("#gtxh_btnLogin").click(function () {
        ClickLogin();
    });

    $("#toploginbox").keydown(function (event) {
        if (event.keyCode == 13) {
            ClickLogin();
        }
    });

    // 退出
    $("#loginOut").click(function () {
        $("#iframe_loginOut").attr("src", "http://iv.prcsteel.com/logout.aspx");
        $("#toploginbox").show();
        $("#userCenterbox").hide();
    });

    // 维持登录状态
    function keepStatus() {
        $.getJSON("http://iv.prcsteel.com/HeadLogin.aspx?action=status&jsoncallback=?", {}, function (re) {
            var status = re.status;
            if (status == "loginout") {
                window.clearInterval(inter);
            }
        });
    }

    var inter;
    if ($("#userCenterbox").css('display') == "none") {
        inter = window.setInterval(keepStatus, 6000);
    }

});


// 点击登录
function ClickLogin() {
    var gtxh_mobile = $.trim($("#gtxh_LoginMobile").val());
    var gtxh_pwd = $.trim($("#gtxh_LoginPwd").val());
    if (gtxh_mobile == "") {
        $("#gtxh_LoginMobile").focus();
        var ucUrl = $("#userCenter").attr("href");
        if (ucUrl != null && typeof (ucUrl) != undefined) {
            var domain = ucUrl.split(".")[0];
            domain = domain.split("//")[1];
            var domaincom = "com";
            if (ucUrl.indexOf(".prcsteel.com") > 0) {
                domaincom = "cn";
            }
            var openUrl = "http://iv.prcsteel.com/?go=http://" + domain + ".prcsteel." + domaincom + "/UnifyIdentityValidate.aspx?go=" + ucUrl;
            window.open(openUrl);
        }
        return;
    }
    var reg = new RegExp("(^1[3-9][0-9]{9}$)");
    if (!reg.test(gtxh_mobile)) {
        alert("请输入正确的手机号码！");
        $("#gtxh_LoginMobile").focus();
        return;
    }
    if (gtxh_pwd == "") {
        $("#gtxh_LoginPwd").focus();
        return;
    }
    UserLogin(false);
}

// 发送登录请求，获取登录Key
function UserLogin(isauto) {
    var gtxh_mobile = $.trim($("#gtxh_LoginMobile").val());
    var gtxh_pwd = $.trim($("#gtxh_LoginPwd").val());
    var autoLogin = $("#gtxh_autoLogin").is(':checked');
    var getsrc = "http://iv.prcsteel.com/FormLogin.aspx?phone=" + gtxh_mobile + "&pwd=" + gtxh_pwd + "&autoLogin=" + autoLogin + "&jsoncallback=?";
    $.getJSON(getsrc, function (data) {
        var status = data.status;
        if (status == "success") {
            if (isauto == false) {
                var rurl = $("#userCenter").attr("ru");
                if (typeof (rurl) != undefined && $.trim(rurl) != "") {
                    window.location = rurl;
                }
                else {
                    window.location = $("#userCenter").attr("href");
                }
            }
            else {
                ProcessLogin();
            }
        }
        else {
            $("#toploginbox").show();
            $("#userCenterbox").hide();

            if (isauto == false) {
                switch (data.iv) {
                    case "several errors":
                        if (confirm("您的账号由于多次登录尝试失败，已被暂时冻结，请1小时后重试。是否立即找回密码？")) {
                            window.location = "http://iv.prcsteel.com/ForgetPassword.aspx";
                        }
                        break;
                    case "error":
                        if (confirm("您的手机号码或密码输入有误，是否需要重新设置密码？")) {
                            window.location = "http://iv.prcsteel.com/ForgetPassword.aspx";
                        }
                        break;
                    case "null":
                        $("#toploginbox").show();
                        $("#userCenterbox").hide();
                        break;
                    case "no bind":
                        if (confirm("该手机号尚未绑定账户，绑定后可用手机号直接登录，是否立即绑定？")) {
                            window.location = "http://iv.prcsteel.com/?from=toplogin&phone=" + gtxh_mobile;
                        }
                        break;
                    case "freeze":
                        alert("您的账号未通过身份认证或被冻结，请联系客服!");
                        break;
                    default:
                        if (confirm("未知错误，请采用其他方式登录？")) {
                            window.location = "http://iv.prcsteel.com";
                        }
                        break;
                }
            }
        }
    });
}

// 处理登录Key
function ProcessLogin() {
    $.getJSON("http://iv.prcsteel.com/HeadLogin.aspx?loginKey=loginkey&jsoncallback=?", function (data) {
        var status = data.status;
        if (status == "success") {
            $("#toploginbox").hide();
            $("#userCenterbox").show();

            $("#gtxh_uame").text(data.UserName);
            //$("#userCenter").attr("href", data.uc);
        }
        else {
            $("#toploginbox").show();
            $("#userCenterbox").hide();
        }
    });
}