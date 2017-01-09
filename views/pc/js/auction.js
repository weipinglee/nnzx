$(document).ready(function(){
 	$(".au_top ul li").click(function(){
 		$(".au_top ul li").removeClass("au_cur");
 		$(this).addClass("au_cur");
 	})
 })