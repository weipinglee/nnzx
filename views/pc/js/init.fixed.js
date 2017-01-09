var browser={
	versions:function(){
		var u = navigator.userAgent, app = navigator.appVersion;
		return {	//移动终端浏览器版本信息
			trident: u.indexOf('Trident') > -1, //IE内核
			presto: u.indexOf('Presto') > -1, //opera内核
			webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
			gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
			mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
			ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
			android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
			iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
			iPad: u.indexOf('iPad') > -1, //是否iPad
			webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
		};
	}(),
	language:(navigator.browserLanguage || navigator.language).toLowerCase()
}
$(document).ready(function(){
	if(!browser.versions.mobile){
		var _st = $.cookie("fixed");
		if(!_st)_st=0;
		var _code = '<div id="fixed"><dl><dd><a href="http://sc.chinaz.com/" class="web">个人中心</a></dd><dd><a href="http:/sc.chinaz.com/" class="mb">在线客服</a></dd><dd><a href="http://sc.chinaz.com/" target="_blank" class="dj">常见问题</a></dd><dd><a href="http://sc.chinaz.com/" target="_blank" class="mh">用户反馈</a></dd><dd><a href="http://sc.chinaz.com/" target="_blank" class="dh">耐耐社区</a></dd><dt><a href="javascript:void(0);" class="close"></a></dt></dl></div>';
		if(_st==1){
			$(_code).hide().appendTo("body").fixed({x:-54,y:0}).fadeIn(500);
			$("#fixed dt a.close").width('68px');
		} else {
			$(_code).hide().appendTo("body").fixed({x:0,y:0}).fadeIn(500);
		}
		$("#fixed dt").click(function(){
			var _left = $("#fixed").offset().left;
			if(_left>=0){
				$.cookie("fixed",1,{path:'/'});
				$("#fixed").animate({left:-54},300,'swing',function(){
					$("#fixed dt a.close").hide().width('68px').fadeIn(500);
				});
			} else {
				$.cookie("fixed",0,{path:'/'});
				$("#fixed dt a.close").width('55px');
				$("#fixed").animate({left:0},300,'swing',function(){
				});
			}
		});
	}
});

$(".ye").on("click",function(){
    $(this).addClass("turn_red"
        );$(this).
    siblings(".ye").removeClass
    ("turn_red")});$("#aaab").on("click",
    function(){var a=$(this).siblings(".turn_red");
    if(a.prev()
        .attr("id")!="aaab"){a.prev().
        addClass("turn_red");a.removeClass("turn_red")}});
    $("#aaaa").on("click",function(){var a=$(this).siblings(".turn_red");if(a.next().attr("id")!="aaaa"){
            a.next().addClass("turn_red");a.removeClass("turn_red")}});
$("#aaac").on("change",function(){this.value=this.value;if(this.value<0){this.value=1}if(this.value.indexOf("0")<0&this.value.indexOf("1")<0&this.value.indexOf("2")<0&this.value.indexOf("3")<0&this.value.indexOf("4")<0&this.value.indexOf("5")<0&this.value.indexOf("6")<0&this.value.indexOf("7")<1&this.value.indexOf("8")<1&this.value.indexOf("9")<1){this.value=1}});
$("#aaad").on("click",function(){
var val=$("#aaac").val();
if($(".ye[value="+val+"]").length==1){
$(".ye").removeClass("turn_red");
$(".ye[value="+val+"]").addClass("turn_red");
}
});