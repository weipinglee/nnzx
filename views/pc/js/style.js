$(function(){
	//咨讯类型切换
	$(".content_title_ul li .title_a").click(function(){
		$(".content_title_ul li .title_a").removeClass("on");
		$(this).addClass('on');
	})
	//分页切换样式
	$(".page .page_num").click(function(){
		$(".page .page_num").removeClass("on");
		$(this).addClass('on');
	})
	//上一页
	$(".page .page_up").click(function(){
		var index = $(".page .page_num.on").index();//获取当前页
			if(index > 2){
				$(".page .page_num").removeClass("on");//清除所有选中
				$(".page a").eq(index-1).addClass("on");//选中上一页

			}
	})
	//点击首页效果
	$(".page .page_first").click(function(){
		$(".page .page_num").removeClass("on");
		$(".page .page_num").eq(0).addClass("on")
	})
	//行业移入移除效果
	$("ul li.quotation_li").mouseover(function () {
                $(".quotation_ul_bage").show();
    });
    $("ul li.quotation_li").mouseleave(function () {
       $(".quotation_ul_bage").hide();
    });
})