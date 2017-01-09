///<reference path="http://pub.prcsteel.com/Js/jquery-1.7.2.min.js"  />

$(function () {
    $("#frmupload").attr("src", "Upload.aspx");
    /*登录*/
    if ($("#UserID").val() == "") {
        $.fn.gtxhLogin({
            callback: function (result) {
                Logined(result);
            }
        });
    }


    //**最新成交 开始**// 
    if ($("#clinch_con div").size() > 6) {
        var onScroll = false;
        setInterval(function () {
            if (onScroll) return;
            var t = $("#clinch_con div:first");
            t.animate({ marginTop: '-17' }, function () {
                t.appendTo("#clinch_con").css("margin-top", "0");
                t = null;
            });
        }, 4000);
        $("#clinch_con div").hover(function () { onScroll = true; }, function () { onScroll = false; });
    }

    // 最新成交弹出层
    $("#clinch_con div").mouseover(function () {
        var X = $(this).offset().top;
        var Y = $("#clinch_con").offset().top;
        $("#clinch_con_tips").empty();
        $("#clinch_con_tips").append("<span class='bot'></span><span class='top'></span>");
        $("#clinch_con_tips").append("<table width='100%' border='0' cellspacing='0' cellpadding='0'>" + $(this).find("table").html() + "</table>");
        $("#clinch_con_tips").show();
        $("#clinch_con_tips").css({ top: X - Y + 70 }); //145
    });
    $("#clinch_con div").mouseleave(function () {
        $("#clinch_con_tips").hide();
    });

    //**最新成交 结束**// 


    //数据标题随着滚轴滚动
    $(window).scroll(function () {
        scoll();
    });

});


function Logined(result) {
    var src = "UnifyIdentityValidate.aspx?iv=" + result + "&action=iframe";
    $.get(src, function (data) {
        if (data != 'no' && data != '无效凭据') {
            var info = data.split('_');
            $("#UserID").attr("title", info[0]);
            $("#UserID").val(info[1]);
        }
    });
}

//**左侧内容 右侧楼层 滚动 开始**//
function scoll() {
    var banner1 = $("#index_banner1").offset().top;
    var banner2 = $("#index_banner2").offset().top;
    var banner3 = $("#index_banner3").offset().top;
    var banner4 = $("#index_banner4").offset().top;
    var banner5 = $("#index_banner5").offset().top;
    var banner6 = $("#index_banner6").offset().top;

    var scoll_top = $(document).scrollTop();
    var dw = ($(document).width() - 1024) / 2 + 1024;
    var isIE6 = !!window.ActiveXObject && !window.XMLHttpRequest;


    if (scoll_top > banner1 && scoll_top < banner2) {
        if (isIE6) { $(".mainRow2_right").css({ position: "absolute" }); }
        else { $(".mainRow2_right").css({ position: "fixed", top: 50, left: dw }); }
        $(".mainRow2_right_middle ul li a").removeClass("mainRow2_right_cur");
        $("#line1").addClass("mainRow2_right_cur");
    }
    else if (scoll_top < banner3 && scoll_top > banner2 || scoll_top == banner2) {
        if (isIE6) { $(".mainRow2_right").css({ position: "absolute" }); }
        else { $(".mainRow2_right").css({ position: "fixed", top: 50, left: dw }); }
        $(".mainRow2_right_middle ul li a").removeClass("mainRow2_right_cur");
        $("#line2").addClass("mainRow2_right_cur");
    }
    else if (scoll_top < banner4 && scoll_top > banner3 || scoll_top == banner3) {
        if (isIE6) { $(".mainRow2_right").css({ position: "absolute" }); }
        else { $(".mainRow2_right").css({ position: "fixed", top: 50, left: dw }); }
        $(".mainRow2_right_middle ul li a").removeClass("mainRow2_right_cur");
        $("#line3").addClass("mainRow2_right_cur");
    }
    else if (scoll_top < banner5 && scoll_top > banner4 || scoll_top == banner4) {
        if (isIE6) { $(".mainRow2_right").css({ position: "absolute" }); }
        else { $(".mainRow2_right").css({ position: "fixed", top: 50, left: dw }); }
        $(".mainRow2_right_middle ul li a").removeClass("mainRow2_right_cur");
        $("#line4").addClass("mainRow2_right_cur");
    }
    else if (scoll_top < banner6 && scoll_top > banner5 || scoll_top == banner5) {
        if (isIE6) { $(".mainRow2_right").css({ position: "absolute" }); }
        else { $(".mainRow2_right").css({ position: "fixed", top: 50, left: dw }); }
        $(".mainRow2_right_middle ul li a").removeClass("mainRow2_right_cur");
        $("#line5").addClass("mainRow2_right_cur");
    }
    else if (scoll_top > banner6 || scoll_top == banner6) {
        if (isIE6) { $(".mainRow2_right").css({ position: "absolute" }); }
        else { $(".mainRow2_right").css({ position: "fixed", top: 50, left: dw }); }
        $(".mainRow2_right_middle ul li a").removeClass("mainRow2_right_cur");
        $("#line6").addClass("mainRow2_right_cur");
    }
    else if (scoll_top < banner1) {
        $(".mainRow2_right").css({ position: "absolute", top: -400, left: 1014 });
        $(".mainRow2_right_middle ul li a").removeClass("mainRow2_right_cur");
        $("#line1").addClass("mainRow2_right_cur");
    }
    else {
        if (scoll_top == banner1) {
            $(".mainRow2_right").css({ position: "fixed", top: 50, left: dw });
            $(".mainRow2_right_middle ul li a").removeClass("mainRow2_right_cur");
            $("#line1").addClass("mainRow2_right_cur");
        }
    }
}
//**左侧内容 右侧楼层 滚动 结束**//
