//搜索栏
$(function () {
    $(".bodys").find('.keyword_1').hide();
    $('.border1').find('li').each(function (i) {
        var _t = $(this);
        var _i = i;
        _t.mouseover(function () {
            _t.find("a").addClass("style1");
            _t.siblings('li').find('a').removeClass('style1');
            $('.keyword_' + _i).show().siblings('p').hide();
        })
    })
})
//楼层电梯 

$(function () {
    $(window).scroll(function () {
        var scrollTop = $(document).scrollTop();
        var documentHeight = $(document).height();
        var windowHeight = $(window).height();
        var contentItems = $("#mainContent").find(".i_market .i_market_left");
        var currentItem = "";
        if (scrollTop + windowHeight == documentHeight) {
            currentItem = "#" + contentItems.last().attr("id");
        } else {
            contentItems.each(function () {
                var contentItem = $(this);
                var offsetTop = contentItem.offset().top;
                if (scrollTop > offsetTop - 100) {//此处的100视具体情况自行设定，因为如果不减去一个数值，在刚好滚动到一个div的边缘时，菜单的选中状态会出错，比如，页面刚好滚动到第一个div的底部的时候，页面已经显示出第二个div，而菜单中还是第一个选项处于选中状态
                    currentItem = "#" + contentItem.attr("id");
                }
            });
        }
        if (currentItem != $("#floornav").find(".cur").attr("data")) {
            $("#floornav").find(".cur").removeClass("cur");
            $("#floornav").find("[data=" + currentItem + "]").addClass("cur");
        }
        ;

    });
});

var oScIn=(function(){function i(a){j=gs();m.length=0;m.push($("#floor-1"));m.push($("#floor-2"));m.push($("#floor-3"));
    o=$("#floornav>a");t()}function gs(){var b;
    if(window.pageYOffset){b=window.pageYOffset}else{if(document.compatMode&&document.compatMode!="BackCompat"){b=document.documentElement.scrollTop
    }else{if(document.body){b=document.body.scrollTop}}}return b};function t(){n=$(window).height()+$(document).scrollTop();if(n==$(document).height()){q(3);
    return}for(r=m.length-1;r>=0;r--){if(j>m[r].offset().top-20&&j<m[r].offset().top+50){q(r);break}}}function p(){}function q(a){$(o[a]).addClass("cur").children("i").attr("display","block").parent().children("em").attr("display","none");
    for(s=0;s<o.length;s++){if(s!=a){$(o[s]).removeClass("cur").children("i").attr("display","none").parent().children("em").attr("display","black")
    }}}var m=[],o,n,r,s,j;return{i:i}})();$(window).resize(oScIn.i);$(window).scroll(oScIn.i);


window.onscroll = function () {
    if (document.documentElement.scrollTop + document.body.scrollTop > 400) {
        $("#floornav").fadeIn(300);
    }
    else {
        $("#floornav").fadeOut(300);
    }
}


