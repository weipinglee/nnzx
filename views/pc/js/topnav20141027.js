// JavaScript Document
$(function () {
    var inPanel = false;
    $(".popueButton").hover(function () {
        HideAll();
        inPanel = true;
        $(this).addClass("hover");
        $(this).next().show();
    }, function () {
        inPanel = false;
        setTimeout(HideAll, 200);
    });
    $(".popuePanel").hover(function () {
        inPanel = true;
    }, function () {
        inPanel = false;
        setTimeout(HideAll, 500);
    });
    function HideAll() {
        if (inPanel) return;
        $(".popueButton").removeClass("hover");
        $(".popuePanel").hide();
    }
    /*头部手机app触发事件*/
    $("#topPhone").mouseenter(function () {
		$(this).find(".top_a").attr("style", "display:block !important;");
		$(this).find(".top_a").find("em").attr("style", "display:inline-block");
    });
    $("#topPhone").mouseleave(function () {
		$(".top_a").find("em").attr("style", "display:none !important");
        $(this).find(".top_a").attr("style", "display:none !important;visibility: hidden");
    })

    // 鼠标经过登录box不隐藏，不经常就隐藏
    var IshoverBox = false;
    $("#login_boxMain").mouseover(function () {
        IshoverBox = true;
        $("#login_boxMain").show();
        $(".topnav_login").addClass("topnav_login_d");
    });
    $(".topnav_login").mouseleave(function () {
        if (IshoverBox == false) {
            $("#login_boxMain").hide();
            $(".topnav_login").removeClass("topnav_login_d");
        }
    });

    var loginboxisClick = false;
    $(document).click(function () {
        if (loginboxisClick == false) {
            $("#login_boxMain").hide();
            $(".topnav_login").removeClass("topnav_login_d");
            IshoverBox = false;
        }
    });

    $("#login_boxMain").click(function (event) {
        loginboxisClick = true;
        var clearst = setTimeout(function () {
            loginboxisClick = false;
            clearTimeout(clearst);
        }, 100);
    });

    $(".topnav_login").mouseover(function () {
        $("#login_boxMain").show();
        $(this).addClass("topnav_login_d");
    });

    $("#gtxh_importpwd").focus(function () {
        $(this).hide();
        $("#gtxh_LoginPwd").show().focus();
    });
    $("#gtxh_LoginPwd").blur(function () {
        if ($(this).val() == "") {
            $(this).hide();
            $("#gtxh_importpwd").show();
        }
    });

    $("#gtxh_LoginMobile").focus(function () {
        var loginmobile = $.trim($(this).val());
        if (loginmobile == "手机号码") {
            $("#gtxh_LoginMobile").val("").css({ "color": "#000" });
        }
    });

    $("#gtxh_LoginMobile").focusout(function () {
        var loginmobile = $.trim($(this).val());
        if (loginmobile == "") {
            $("#gtxh_LoginMobile").val("手机号码").css({ "color": "#b3b1b1" });
        }
    });



});
