$(document).ready(function (){ 
	$(".ul1 .ul1_li .tow_tit").on('click', function(){
			if($(this).parent(".ul1_li").find(".ul2").is(':hidden')){
			$(".big_tit .ul1 li a").removeClass("cur");
			$(this).addClass("cur");
			$(this).find("i").removeClass("icon-caret-down")
			$(this).find("i").addClass("icon-caret-up");
			$(this).parent(".ul1_li ").find(".ul2").show();
		}else{
			$(this).removeClass("cur");
			$(this).find("i").removeClass("icon-caret-up")
			$(this).find("i").addClass("icon-caret-down");
			$(this).parent(".ul1_li").find(".ul2").hide();
		}
	})
	$(".ul2 li").on('click', function(){
		$(".ul2 li a").removeClass("a_cur");
		$(this).find("a").addClass("a_cur");
	})
})