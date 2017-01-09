/// <reference path="../../core/jquery.extend.js" />

$(function () {
     var codeUrl=$('#codeUrl').val();
    var findUrl=$('#findUrl').val();
    var getUrl=$('#getUrl').val();

    $('#txtMobile').blur(function () {
       if (formValidator(1)) {
            $.ajax({
                type: "post",
                url: getUrl,
                data: {
                    "mobile": $("#txtMobile").val()
                },
                dataType: "json",
                success: function (msg) {
                   // debugger;
                    if(msg.success==1){
                        $('#uid').val(msg.info);
                        if (msg.info == '') {
                            $('.error').find(".field-validation-error").html("【手机号】当前没有注册用户！");
                            $('.error').find(".field-validation-valid").html("【手机号】当前没有注册用户！");
                        }else{
                            $('.error').find(".field-validation-error").html("");
                            $('.error').find(".field-validation-valid").html("");
                        }
                    }else{
                        alert(msg.info);
                    }
                }
            });
        } else {
            return false;
        }
    })
   
    //提交前验证
    function formValidator($step) {
        if ($step == 1) {
             var mobile = $("#txtMobile").val();
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
        }else{
             var pwd = $("#txtPassWord").val();
             var againPassword = $("#txtAgainPassWord").val();
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
        }
        
        
        return true;
    }

    $("#btnSubmit2").click(function () {
        var self = $(this);
        if (formValidator(2)) {
            //$("#txtPassWord").attr("value", encryptCode($("#txtPassWord").val()));
            //self.parents('form').submit();

            $.ajax({
                type: "post",
                url: findUrl,
                data: {
                    "password": $("#txtPassWord").val(),
                    "mobile": $("#txtMobile").val()
                },
                dataType: "json",
                success: function (msg) {
                   // debugger;
                    if(msg.success==0){
                        alert(msg.info);
                    }else{
                        window.location=msg.returnUrl;
                    }
               /*     if (data != "跳转页面") {
                        $("#txtMessage").html(data);
                    }

                    else {
                        window.location = $("#txtUrl").val();
                    }*/


                }
            });
        } else {
            return false;
        }
    })

    $("#btnSubmit").click(function () {
        
        var self = $(this);
        if (formValidator(1)) {
            
            if ($("#txtCode").val() == '') {
                $('.error').find(".field-validation-error").html("请填写校验码！");
                $('.error').find(".field-validation-valid").html("请填写校验码！");
                return false;
            }
            //$("#txtPassWord").attr("value", encryptCode($("#txtPassWord").val()));
            //self.parents('form').submit();

            $.ajax({
                type: "post",
                url: findUrl,
                data: {
                    "uid": $("#uid").val(),
                    "code": $("#txtCode").val(),
                    "mobile": $("#txtMobile").val()
                },
                dataType: "json",
                success: function (msg) {
                   // debugger;
                    if(msg.success==0){
                        alert(msg.info);
                    }else{
                        window.location=msg.returnUrl;
                    }
               /*     if (data != "跳转页面") {
                        $("#txtMessage").html(data);
                    }

                    else {
                        window.location = $("#txtUrl").val();
                    }*/


                }
            });
        } else {
            return false;
        }
    });

    $("#btnSubmit3").click(function () {
            $.ajax({
                type: "post",
                url: findUrl,
                data: {
                    "name": $("#txtname").val(),
                    "no": $("#txtno").val(),
                    "noimg": $("#noimg").val(),
                    "applyimg": $("#applyimg").val()
                },
                dataType: "json",
                success: function (msg) {
                   // debugger;
                    if(msg.success==0){
                        alert(msg.info);
                    }else{
                        window.location=msg.returnUrl;
                    }

                }
            });
    });

    //格式化提交
    function encryptCode(str) {
        var code = "";
        for (var i = 0; i < str.length; i++) {
            var k = str.substring(i, i + 1);
            code += "$" + (str.charCodeAt(i) + "1") + ";";
        }
        return code;
    }

    $("#yzmBtn").bind('click',function () {
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
            url: codeUrl,
            data: { "mobile": $("#txtMobile").val(), "code":$("#inputCode").val(),'uid':$('#uid').val()},
            dataType: "json",
            success: function (msg) {
                if(msg.success==1){
                    time($('#yzmBtn'));
                   alert(msg.info);
                }else{
                    alert(msg.info);
                    $('#yzmBtn').attr('disabled',false);
                }

                // $('#image').click();
            }
        });
    });
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