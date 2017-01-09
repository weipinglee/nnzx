/**
Author:lcw
Name:钢为网弹窗登录
Directions:
    1：引用jquery框架（此代码是在1.72下写的）;
    2：引用js；
    3：调用方式如下，第一种是在页面加载的时候调用，第二种是输入登录。其中callback为回调函数，result为登录成功以后的iv值：
        $().ready(function(){

            // 实例代码一：
            $.fn.gtxhLogin({
            callback: function (result) {
                alert(result);
            }
            });

            // 实例代码二：
            $("#test1").click(function () {
                $.fn.gtxhLogin({
                    isShow:1,
                    callback: function (result) {
                        alert(result);
                    }
                });
            });
        });
**/
(function ($) {
    $.extend($.fn, {
        gtxhLogin: function (setting) {
            var options = $.extend({
                isShow: 0,
                callback: function () { }   //点击确定触发此事件
            }, setting);
            if (options.isShow == 0)
                sendLogin("http://iv.prcsteel.com/FormLogin.aspx?login=login");
            else {
                //加载样式文件
                if ($("#gtxh_login_style").size() == 0) {
                    var link = document.createElement("link");
                    link.rel = "stylesheet";
                    link.type = "text/css";
                    link.href = "http://iv.prcsteel.com/css/gtxh_login_style.css";
                    link.id = "gtxh_login_style";
                    document.getElementsByTagName("head")[0].appendChild(link);
                }
                if ($("#dragbox").size() > 0) return;
                //初始化
                var boxContent = "<div id='loginbox' class='loginbox'><ul id='logining'><li>手机号码：<input type='text' id='userPhone' name='userPhone' class='input_txt' maxlength='11' /></li>";
                boxContent += "<li>登录密码：<input type='password' id='userPwd' name='userPwd' class='input_txt' /></li><li style='height:30px; line-height:15px;'><span id='login_msg' class='login_msg'></span></li>";
                boxContent += "<li><input type='button' id='submit' value=' 登 录 ' class='input_btn' />&nbsp;&nbsp;<a href='http://iv.prcsteel.com/forgetpassword.aspx'>忘记密码</a></li></ul>";
                boxContent += "<p>还没有钢为网账号？&nbsp;&nbsp;<a target='_blank' href='http://iv.prcsteel.com/RegStep1.aspx'>立即注册</a></p></div>";
                var top = $(window).height() / 2 + $(document).scrollTop();
                var left = $(window).width() / 2;
                var boxWidth = 470;
                var boxHeight = 290;
                var dragbox = $("<div id='dragbox' style='display:none;'><div class='dragTitle'><span>手机号码登录</span><a id='closeBox'>X</a></div><div class='dragContent'></div></div>").attr('class', "dragbox").css({ 'top': 0, 'left': left - boxWidth / 2, "width": boxWidth, "height": boxHeight }).appendTo(document.body);
                //插入内容
                $(dragbox).find(".dragContent").html(boxContent);
                //显示
                $("<div id='cover' style='position:absolute;z-index:1000;top:0; left:0; background:#efefef; opacity:0.5; filter:alpha(opacity=50); height:" + $(document).height() + "px; width:100%;'></div>").appendTo($("body"));
                $(dragbox).show().css({ "left": $(document).width() / 2 - $(dragbox).width() / 2 }).animate({ top: ($(window).height() - $(dragbox).height()) / 2 - 30, filter: "alpha(opacity=100)", opacity: 1 }, 900);
                //关闭
                $(dragbox).find("#closeBox").bind("click", function () { hideLogin(); });
                /* @Name: div拖动简单示例(jQuery)  @Author: Rocky    */
                function drag(dragControl, dragContent) {
                    var _drag = false, _x, _y, cw, ch, sw, sh;
                    var dragContent = typeof dragContent == "undefined" ? dragControl : dragContent;
                    $(dragControl).mousedown(function (e) {
                        _drag = true;
                        _x = e.pageX - parseInt($(dragContent).css("left"));
                        _y = e.pageY - parseInt($(dragContent).css("top"));
                        cw = $(document).width();
                        ch = $(document).height();
                        sw = parseInt($(dragContent).outerWidth());
                        sh = parseInt($(dragContent).outerHeight());
                        window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty(); //禁止拖放对象文本被选择的方法
                        document.body.setCapture && $(dragContent)[0].setCapture(); // IE下鼠标超出视口仍可被监听
                        $(document).mousemove(function (e) {
                            if (_drag) {
                                var x = e.pageX - _x;
                                var y = e.pageY - _y;
                                x = x < 0 ? x = 0 : x < (cw - sw) ? x : (cw - sw);
                                y = y < 0 ? y = 0 : y < (ch - sh) ? y : (ch - sh);
                                $(dragContent).css({ top: y, left: x });
                            }
                        }).mouseup(function () {
                            _drag = false;
                            document.body.releaseCapture && $(dragContent)[0].releaseCapture();
                        });
                    });
                }
                //拖动 
                drag($(dragbox).find('.dragTitle'), dragbox);
                var islogin = false;
                $("#loginbox #submit").bind("click", function () {
                    if (islogin) return;
                    var phone = $.trim($("#loginbox #userPhone").val());
                    var reg = new RegExp("(^1[3-9][0-9]{9}$)");
                    if (!reg.test(phone)) {
                        $("#loginbox #login_msg").text("请输入正确的手机号码！");
                        $("#loginbox #userPhone").focus();
                        return;
                    }
                    var pwd = $.trim($("#loginbox #userPwd").val());
                    if (pwd == "") {
                        $("#loginbox #login_msg").text("请输入密码！");
                        $("#loginbox #userPwd").focus();
                        return;
                    }
                    $("#loginbox #login_msg").html("<span style='color:green;'>登录中...</span>");
                    var getsrc = "http://iv.prcsteel.com/FormLogin.aspx?phone=" + phone + "&pwd=" + pwd;
                    islogin = sendLogin(getsrc);
                    try {
                        utaq.push(['trackEvent','btn-log']);
                    } catch (e) {}
                });
                $("#loginbox #userPhone").bind("mouseout", function () {
                    var phone = $.trim($("#loginbox #userPhone").val());
                    var reg = new RegExp("(^1[3-9][0-9]{9}$)");
                    if (!reg.test(phone)) {
                        $("#loginbox #login_msg").text("请输入正确的手机号码！");
                        $("#loginbox #userPhone").focus();
                        return;
                    }
                    else {
                        $.getJSON("http://iv.prcsteel.com/FormLogin.aspx?action=ValPhone&phone=" + phone + "&jsoncallback=?", {}, function (data) {
                            var result = data.status;
                            if (result.indexOf("exist") > -1) {
                                var wjwloginName = result.split("|")[1];
                                $("#loginbox #login_msg").text("可用五金网账号“" + wjwloginName + "”的密码进行登录！");
                            }
                            else if (result == "fail") {
                                $("#loginbox #login_msg").text("手机号码或密码错误！");
                            }
                            else if (result == "no") {
                                $("#loginbox #login_msg").html("该手机号码尚未注册！<a target='_blank' href='http://iv.prcsteel.com/RegStep1.aspx'>注册账号</a> 或 <a target='_blank' id='bindphone' href='http://iv.prcsteel.com/?from=toplogin&phone=" + phone + "'>绑定账号</a>");
                            }
                            else {
                                $("#loginbox #login_msg").html("");
                            }
                        });
                    }
                });

                $("#loginbox").bind("keydown", function (event) {
                    if (event.keyCode == 13) {
                        $("#loginbox #submit").click();
                    }
                });
            }
            //hide box
            hideLogin = function HideLogin() {
                $("#dragbox").animate({ top: "0", filter: "alpha(opacity=0)", opacity: 0 }, 700, function () {
                    $("#cover,#dragbox").remove();
                });
            }
            //发送登录请求
            function sendLogin(getsrc) {
                $.getJSON(getsrc + "&jsoncallback=?", function (data) {
                    var status = data.status;
                    if (status == "success") {
                        $("#loginbox #login_msg").text("");
                        hideLogin();
                        $("body iframe").each(function () {
                            var iframesrc = $(this).attr("src");
                            if (iframesrc != null && iframesrc.indexOf("iv") > 0) {
                                if (iframesrc.substring(iframesrc.indexOf("?"), 1) > 0)
                                    $(this).attr("src", iframesrc + "&loginrandom=" + Math.random());
                                else
                                    $(this).attr("src", iframesrc + "?loginrandom=" + Math.random());
                            }
                        });
                        options.callback(data.iv);
                        return true;
                    }
                    else {
                        switch (data.iv) {
                            case "several errors":
                                $("#loginbox #login_msg").html("您的账号由于多次登录尝试失败，已被暂时冻结，请1小时后重试。<a href=''http://iv.prcsteel.com/ForgetPassword.aspx'> 忘记密码</a>");
                                break;
                            case "error":
                                $("#loginbox #login_msg").text("手机号码或密码错误！");
                                break;
                            case "no bind":
                                $("#loginbox #login_msg").html("该手机号码尚未绑定账户！<a href='http://iv.prcsteel.com/Default.aspx?from=toplogin&phone=" + $.trim($("#userPhone").val()) + "'> 绑定账号</a>");
                                break;
                            case "freeze":
                                $("#loginbox #login_msg").text("抱歉，该账号已被冻结，如有疑问，请联系客服！");
                                break;
                            default:
                                $("#loginbox #login_msg").html("未知错误，请采用其他方式登录！ <a href='http://iv.prcsteel.com'>登录页面</a>");
                                break;
                        }
                    }
                });
                return false;
            }
        }
    });
})(jQuery);