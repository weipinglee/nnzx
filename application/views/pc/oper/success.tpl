


<link rel="stylesheet" type="text/css"  href="{views:css/404.css}"/>
<div class="bg">
	<div class="cont">
		<div class="c1"><img src="{views:images/err/succ.png}" class="img1" /></div>
		<h2>{$info}</h2>
		<div class="c2"><a href="javascript:history.back()" class="re">返回上一页</a><a href="{url:/ucenterindex/index@user}" class="home">返回个人中心</a><!-- <a href="" class="sr">搜索一下页面相关信息</a> --></div>
		<!-- <div class="c3"><a href="http://www.nainaiwang.com" class="c3">耐耐</a>提醒您 - 您可能输入了错误的网址，或者该网页已删除或移动</div> -->
	</div>
</div>

<script type="text/javascript">
	$(function(){
		var redirect = "{$redirect}";
		console.log(redirect);
		if(redirect){
			setTimeout(function(){
				window.location.href = redirect;
			},2000);
		}else{
			setTimeout(function(){
				history.back();
			},2000);
		}
	})
</script>