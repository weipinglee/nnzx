/// <reference path="../../core/jquery.extend.js" />

$(function () {

    //提交前验证
    function formValidator() {
        var mobile = $("#txtMobile").val();
        var pwd = $("#txtPassWord").val();
        var againPassword = $("#txtAgainPassWord").val();

        if ($.isEmpty(mobile)) {
            $('.error').find(".field-validation-error").html("【手机号】不允许为空！");
            $('.error').find(".field-validation-valid").html("【手机号】不允许为空！");
            return false;
        }
        if (!$.isMobile(mobile)) {
            $('.error').find(".field-validation-error").html("【手机号】格式错误！");
            $('.error').find(".field-validation-valid").html("【手机号】格式错误！");
            return false;
        }
        if (pwd.length < 6) {
            $('.error').find(".field-validation-error").html("【密码】不能低于6位");
            $('.error').find(".field-validation-valid").html("【密码】不能低于6位");
            return false;
        }
        if (pwd != againPassword) {
            $('.error').find(".field-validation-error").html("【密码】与【确认密码】不一致！");
            $('.error').find(".field-validation-valid").html("【密码】与【确认密码】不一致！");
            return false;
        }
        return true;
    }

    $("#btnSubmit").click(function () {
        var self = $(this);
        if (formValidator()) {
            //$("#txtPassWord").attr("value", encryptCode($("#txtPassWord").val()));
            //self.parents('form').submit();

            $.ajax({
                type: "post",
                url: "/PasswordReset/Index",
                data: {
                    "registerPhone": $("#txtMobile").val(),
                    "usrCode": $("#txtCode").val(),
                    "passWord": $("#txtPassWord").val(),
                    "returnUrl": $("#txtUrl").val()
                },
                dataType: "json",
                success: function (data, textStatus) {
                    debugger;
                    if (data != "跳转页面") {
                        $("#txtMessage").html(data);
                    }
                    else {
                        window.location = $("#txtUrl").val();
                    }


                }
            });
        } else {
            return false;
        }
    })

    //格式化提交
    function encryptCode(str) {
        var code = "";
        for (var i = 0; i < str.length; i++) {
            var k = str.substring(i, i + 1);
            code += "$" + (str.charCodeAt(i) + "1") + ";";
        }
        return code;
    }

    $(".yzm").click(function () {
        $(".yzm").attr('disabled', true);
        var mobile = $("#txtMobile").val();
        if ($.isEmpty(mobile)) {
            $('.error').find(".field-validation-error").html("【手机号】不允许为空！");
            $('.error').find(".field-validation-valid").html("【手机号】不允许为空！");
            $(".yzm").attr('disabled', false);
            return false;
        }
        if (!$.isMobile(mobile)) {
            $('.error').find(".field-validation-error").html("【手机号】格式错误！");
            $('.error').find(".field-validation-valid").html("【手机号】格式错误！");
            $(".yzm").attr('disabled', false);
            return false;
        }
        $.ajax({
            type: "post",
            url: "/registerUser/getCode",
            data: { "mobile": $("#txtMobile").val(), "channel": '找回密码' },
            dataType: "json",
            success: function (data, textStatus) {
                time($(".yzm"));
            }
        });
    })
    var wait = 60;
    function time(o) {

        if (wait == 0) {
            o.attr('disabled', false);
            $(o).val('获取验证码');
            wait = 60;
        } else {
            o.attr('disabled', true);
            $(o).val("重新发送(" + wait + ")");
            wait--;
            setTimeout(function () {
                time(o);
            }, 1000)
        }
    }
});