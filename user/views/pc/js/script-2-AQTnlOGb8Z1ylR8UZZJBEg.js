/*** Script File: /js/_plugins.js ***/
$(document).ready(function(){
	if($("._plugins_pageturns").length>0){
		pageTurn();
	}

	if($("._plugins_popup_btn").length>0){
		$("._plugins_popup_btn").each(function(){
			var name = $(this).attr("target-name");
			popUp($(this),$("._plugins_popup[name='"+name+"']"));
		})
	}
	if($("._plugins_tip").length>0){
		$("._plugins_tip").each(function(){
			tipInit($(this));
		})
	}

	if($("._plugins_share_btn").length>0){
		shareTool();
	}
})


/*翻页*/
/*使用方法：给任意需要翻页的标签添加"_plugins_pageturns"类即可*/
/*说明：此功能尚在开发中*/
function pageTurn(){
	var c = $("._plugins_pageturns");
	initPageTurn(c);
	turnEvent(c);
}

function initPageTurn(c){
	c.each(function(){var ct = this; $(ct).find(".page_num").on({
			focusin:function(){
				$(ct).find(".jump_btn").fadeIn(500);
			},
			focusout:function(){
				$(ct).find(".jump_btn").fadeOut(500);
			}
		})
	})
}

function turnEvent(c){
	c.each(function(){
		var ct = this;
		$(ct).find(".page_bar").on("click",".page_wrap",function(){
				var p_c = $(ct).find(".page_cur");				
				if($(this).hasClass("page_up")){//前一页
					var p_n = parseInt(p_c.text());
					if(p_n==1){
						return;
					}
					else{
						p_c.removeClass("page_cur");
						var cur_obj = p_c.parent().prev();
						cur_obj.find("a").addClass("page_cur");
						p_n--;
						barNomalized(cur_obj,p_n,5);
					}
				}
				else if($(this).hasClass("page_down")){//后一页
					var p_n = parseInt(p_c.text());
					if(p_c.parent().next().hasClass("page_down")){
						return;
					}
					else{
						p_c.removeClass("page_cur");
						var cur_obj = p_c.parent().next();
						cur_obj.find("a").addClass("page_cur");
						p_n++;
						barNomalized(cur_obj,p_n,5);				
					}
				}
				else{
					p_c.removeClass("page_cur");
					var cur_obj = $(this);
					cur_obj.find("a").addClass("page_cur");
					var p_n = parseInt($(this).find("a").text());
					barNomalized(cur_obj,p_n,5);
				}
			}
		);
	})
}

function barNomalized(obj,page,length){
	var p_l = obj.prevAll(".page_wrap").length-1;
	var h_l = Math.floor(length/2);
	if(p_l!=h_l){
		if(page<=(h_l+1) && (p_l+1)==page){
			return;
		}
		else{
			var p_o = obj.parent();
			var i_n = Math.abs(p_l-h_l);
			if(p_l<h_l){
				var p_ns = obj.nextAll(".page_wrap");
				for(var i = 0; i < i_n ; i++){
					var p = page-p_l-i-1;
					if(p<=0){
						return;
					}
					var item = '<div class="page_wrap"><div class="bg"></div><a>'+p+'</a></div>';
					var a = length-p_l-i-2;
					p_ns.eq(a).remove();
					p_o.children().first().after(item);
				}
			}
			else{
				var p_ns = obj.prevAll(".page_wrap");
				var max_p = parseInt(obj.parent().nextAll(".page_count").find("span").text());
				for(var i = 0 ; i < i_n ; i++){
					var p = page-p_l+length+i;
					if(p>max_p){
						return;
					}
					var item = '<div class="page_wrap"><div class="bg"></div><a>'+p+'</a></div>';
					p_ns.eq(i+2).remove();
					p_o.children().last().before(item);
				}
			}
		}
	}
}


/*弹出框*/
/*使用：给弹出按钮添加"_plugins_popup_btn"类,并指明弹出对象名（设置属性target-name），
给对应的弹窗添加"_plugins_popup"类，并设置name属性值与弹出按钮的target-name属性值一致*/
function popUp(obj,mask){//显示弹出框
	obj.on({
		click:function(e){
			e.stopPropagation();
			mask.addClass("visible");
			mask.toggle();
		}
	})
	mask.find(".up_cont").on({
		click:function(e){
			e.stopPropagation();
		}
	})
}

/*tooltip*/
/*使用：添加"_plugins_tip"类,并设置tip-data*/
/*例：<input class="_plugins_tip" tip-data="把鼠标移到我上面，我就显示出来啦！">*/
function tipInit(obj){
	var tip = obj.attr("tip-data");
	var div = document.createElement("div");
	var p = document.createElement("p");
	$(p).text(tip);
	div.appendChild(p);
	$(div).css({
		"position":"relative"});
	$(p).css({
		"position": "absolute",
		"background-color": "rgba(255,255,255,0.7)",
		"border": "solid 1px #ccc",
		"border-radius": "3px",
		"box-shadow": "0px 0px 3px 1px #ccc",
		"left": "4px",
		"top" : "8px",
		"display": "none",
		"padding": "0px 5px"
	});
	obj.after(div);
	obj.hover(
		function(){
			$(p).fadeIn(400);
		},
		function(){
			$(p).fadeOut(400);
		}
	)
}

/*分享*/
/*使用：给分享按钮添加"_plugins_share_btn"类即可*/

function shareTool(){
//	initShareBox();
	var ps = $("._plugins_share");
	$("._plugins_share_btn").each(function(){
		var ps_hover=0;
		ps.hover(
			function(){
				ps_hover = 1;
			},
			function(){
				ps_hover = 0;
				ps.fadeOut(100);
			}
		)
		$(this).hover(
			function(){
					var top = $(this).offset().top ;
					var left = $(this).offset().left+$(this).width();
					ps.css({
						"top":top+"px",
						"left":left+"px"
					});
					ps.fadeIn(100);
			},
			function(){
				setTimeout(function(){
				if(ps_hover){
					return;
				}
				else{
					ps.fadeOut(100);
				}
				},400);	
			}
		)
	})
}

function initShareBox(){
	var div = document.createElement("div");
	$(div).addClass("_plugins_share");
	var cont = 	'<div class="title"></div>'
    			+'<div class="share_cont">'
    			+'    <div><a href="">微信</a></div>'
    			+'    <div><a href="">QQ空间</a></div>'
    			+'    <div><a href="">QQ好友</a></div>'
    			+'    <div><a href="">腾讯微博</a></div>'
    			+'    <div><a href="">新浪微博</a></div>'
    			+'    <div><a href="">网易微博</a></div>'
    			+'    <div><a href="">搜狐微博</a></div>'
    			+'    <div><a href="">豆瓣</a></div>'
    			+'    <div><a href="">开心网</a></div>'
    			+'</div>'
	$(div).append(cont);
	$("body").append($(div));
	$("._plugins_share").find("a").each(function(){
		var name = $(this).attr("name");
		switch(name){
			case "wechat": break;
		}
	})
}

/*通用js*/
/*使用：给必填字段添加data-required="true"属性*/
/*在form标签中添加onsubmit="return formValidation(this)"属性*/
function formValidation(obj){
	var flag = true;
	$(obj).find('input').each(function(){
		if($(this).attr('name') && $(this).attr('data-required')=="true"){
			if($(this).val()==''){
				flag = false;
				alert("提交失败，有必填字段为空！");
				return false;
			}
		}
	});
	return flag;
}
;
/*** Script File: /js/main.js ***/
$(document).ready(function(){
//	dropDownList("dp_btn","nav_dropdown");
	// loadWpaLazy();
	overTurn();
//	popUp($(".i_interest"),$(".pop_up"));
	switchPanel();
	switchNews();
	docClick();
	updateItem();
	scrollTop();

	searchInit();
	$(".A_more").on({//首页更多产品按钮
		click:function(e){
			e.stopPropagation();
			var obj = $(this).parent().nextAll(".more_pdt");
			setVisible(obj,"more_pdt","normal");
		}
	})
	$(".HomeTitle>span").on("click",function(){
		var name = $(this).attr("name");
		var classname = $(this).attr("classname");
		var box = $("."+classname+'[name="'+name+'"]');
		if(box.hasClass("show")){
			return;
		}
		else{
			$(this).siblings().removeClass("active");
			$("."+classname).removeClass("show");
			box.addClass("show");
			$(this).addClass("active");
		}
	})
	$(".up_footer").find("input").not(".interest_submit").click(function(){
		hideMask($(".pop_up"));
	})
	
	$(".hideicon").click(function(){
		hideMask($(".pop_up"));
	})

	$(".pop_up").find(".cont input").on({
		click:function(){
			if($(".cont .selected").length >= 5 && !$(this).parent().hasClass("selected")){
				alert("最多只能选择5个兴趣标签！");
				return;
			}
			$(this).parent().toggleClass("selected");
		}
	})

	$(".slideBtn").find("span").on({//鼠标点击轮转条时停止轮转，切换图片
		click:function(){
			if($(this).hasClass("curr")){
				return;
			}
			else{
				$(this).siblings("span").removeClass("curr");
				$(this).addClass("curr");
				var nth = $(this).prevAll("span").length;
				$(".slideBox").find("li.show").removeClass("show");
				$(".slideBox").find("li").eq(nth).addClass("show");
			}
		}
	})
	var timeslot = 4000;//轮循事件间隔
	var changepic = setInterval(function(){autoChange();},timeslot);//首页图片自动轮转

	$(".slideBtn").find("span").hover(//鼠标浮动到轮转条时停止轮转，切换图片
		function(){
			if(!$(this).hasClass("curr")){
				$(this).siblings("span").removeClass("curr");
				$(this).addClass("curr");
				var nth = $(this).prevAll("span").length;
				$(".slideBox").find("li.show").removeClass("show");
				$(".slideBox").find("li").eq(nth).addClass("show");
			}
			clearInterval(changepic);
		},
		function(){
			changepic = setInterval(function(){autoChange();},timeslot);
		}
	)

	$(".slideBox ul").hover(//鼠标浮动到图片时停止轮转
		function(){
			clearInterval(changepic);
		},
		function(){
			changepic = setInterval(function(){autoChange();},timeslot);
		}
	)
	var ieq;
	$(".i_interest").on("click",function(){//定制感兴趣ajax
		
		var a = $(this).prev().children("li").find("a");
		var span = $(".pop_up[name='interest']").find(".cont>span");
		span.removeClass("selected");
		for(var i = 0 ;i <a.length;i++){
			var name = a.eq(i).text();
			span.each(function(){
				if($(this).children("input").val()==name){
					$(this).addClass("selected");
					return false;
				}
			})
		}
		ieq = $(this).prevAll(".i_left_title").attr("name");
	})
	$(".interest_submit").click(function(){
		var pop = $(this).parents(".pop_up");
		var st = pop.find(".selected");
		if(st.length<=0){
//			alert("请至少选择一项");
			//hideMask($(".pop_up"));
			//return;
		}
		var its = [];
		for (var i = 0; i < st.length; i++) {
			its.push(st.eq(i).find("input").val());
		};
		var data = {
			"name":ieq,
			"interest":its
		}
		$.post($.createUrl('site','interest'),data,function(json){
			if(json.status){
				var id;
				switch(ieq){
					case "1":
						id = "rmb_market";
						break;
					case "2":
						id = "usd_market";
						break;
					case "0":
						id = "retail_market";
						break;
				}

			}
			var dom = $("#"+id);
			dom.children('div:first').find('ul').children("li:gt(1)").remove();
			dom.children('div:first').find('ul').children("li:first").children("a").click();
			dom.children(".i_leftCon").children(".i_proList:gt(1)").remove();
            $(json.info).each(function(i,obj){
                dom.children('div:first').find('ul').append('<li><a href="javascript:void(0)"><em></em>'+its[i]+'</a></li>');
                var con = dom.find(".i_proList").not(".show").first().clone();
                con.children("ul").children("li:not(:first)").remove();
                con.children("ul").append(obj);
                dom.children(".i_leftCon").children("div:last").before(con);
            })
        },'json');
		hideMask($(".pop_up"));
	})


    //首页点击人民币市场，美元市场，直销零售，的点击更多链接
    $(".i_more").children("a").click(function(){
    	var data = {};
    	var m = $(this).parents(".i_market_left");
        var currency=m.attr("id");
        if(currency=="rmb_market"){
            currency=1;
        }else if(currency=="usd_market"){
            currency=2;
        }else{
            currency=0;
        }
        var l = m.find(".li_select");
        var n  = l.text();
        if(n=="化工"){
        	n = 1;
        	data.category_id = n;
        }
        else if(n=="塑料"){
        	n = 2;
        	data.category_id = n;
        }
        else{
        	data.name = n;
        }
        data.currency = currency;
        window.location.href = $.createUrl("trade","supply",data);
    });

    /*if($('.items_container').length>0){//首页滚动实现
    	$('.items_container').each(function(){
    		rollEffect($(this).children('ul'));
    	})
    }*/
    /*限定内容高度*/
	$(".WrapCon_other").css('min-height',document.documentElement.clientHeight-224+'px');    
});

function autoChange(){
	var c = $(".slideBtn").find(".curr");
	c.removeClass("curr");
	if(c.next().length==0){
		$(".slideBtn").find("span:first").addClass("curr");
	}
	else{
		c.next().addClass("curr");
	}
	var nth = $(".slideBtn").find(".curr").prevAll().length;
	$(".slideBox").find("li.show").removeClass("show");
	$(".slideBox").find("li").eq(nth).addClass("show");
}

function dropDownList(dpclass,classname){//菜单下拉框
	$("."+dpclass).on({
		click:function(e){
			e.stopPropagation();
			var obj = $(this).nextAll("."+classname);
			setVisible(obj,classname,"slideUpDown");
		}
	})
}

function listItemChose(classname,parentclass){//菜单下拉框选项点击
	$("."+classname).children().on({
		click:function(){
			$(this).parent("."+parentclass).removeClass("visible");
		}
	})
}

function setVisible(obj,classname,effect){//显示指定类节点
	if(obj.hasClass("visible")){
		switch(effect){
			case "normal":
				obj.toggle();
				break;
			case "slideUpDown":
				obj.slideUp();
				break;
		}
		obj.removeClass("visible");
	}
	else{
		$("."+classname).removeClass("visible");
		switch(effect){
			case "normal":
				$("."+classname).css("display","none");
				obj.toggle();
				break;
			case "slideUpDown":
				$("."+classname).slideUp();
				obj.slideDown();
				break;
		}
		obj.addClass("visible");
	}
}

function setAllHidden(classname,effect){//隐藏指定类节点
	$("."+classname).each(function(){
		if($(this).hasClass("visible")){
			switch(effect){
				case "normal":
					$(this).css("display","none");
					break;
				case "slideUpDown":
					$(this).slideUp();
			}
			$(this).removeClass("visible");
		}
	})
}

function docClick(){//点击页面
	$(document).on({
		click:function(){
			setAllHidden("nav_dropdown","slideUpDown");
			setAllHidden("pop_up","normal");
			setAllHidden("more_pdt","normal");
		}
	})
}

function switchPanel(){//报盘内容切换
	$(".i_leftTit").find("ul").on("click","li a",function(){
		if($(this).parent().hasClass("li_select")){
			return;
		}
		else{
			var par = $(this).parent();
			par.siblings("li").removeClass("li_select");
			par.addClass("li_select");
			var nth = $(this).parent().prevAll().length;
			var pars = $(this).parents(".i_market_left").find(".i_leftCon");
			pars.find(".i_proList.show").toggle();
			pars.find(".i_proList.show").removeClass("show");
			pars.find(".i_proList").eq(nth).toggle();
			pars.find(".i_proList").eq(nth).addClass("show");
		}
	})
}

function switchNews(){//看点内容切换
	$(".iNewsTit").find("a").on({
		click:function(){
			if($(this).parent().hasClass("iNewsCur")){
				return;
			}
			else{
				var par = $(this).parent();
				par.siblings("li").removeClass("iNewsCur");
				par.addClass("iNewsCur");
				var nth = $(this).parent().prevAll().length/2;
				var pars = $(this).parents(".i_market_right").find(".iNewsCon");
				pars.find("ul.show").removeClass("show");
				pars.find("ul").eq(nth).addClass("show");
			}
		}
	})
}

function overTurn(){//翻转效果
	$(".overturn").hover(
		function(){
			$(this).find("div:first").animate({"margin-top":"-42px"},200);
		},
		function(){
			$(this).find("div:first").animate({"margin-top":"0px"},200);
		}
	)
}

function popUp(obj,mask){//显示弹出框
	obj.on({
		click:function(e){
			e.stopPropagation();
			mask.addClass("visible");
			mask.toggle();
		}
	})
	mask.find(".up_cont").on({
		click:function(e){
			e.stopPropagation();
		}
	})
}

function hideMask(mask){//隐藏弹出框
	mask.css("display","none");
}

/*页面切换*/
function pageChange(items,pagenum,container){
	container.children().css("display","none");
	for(var i = 0;i<items;i++){		
		container.children().eq((pagenum-1)*items+i).css("display","block");
	}
}

/*检查快速找货表单是否为空*/
function isempty(e){
	var value = $(e).find("textarea").val();
	if(value==""){
		alert("需求内容不能为空");
		return false;
	}
	else{
		return true;
	}
}

/*最新交易条目更新*/
function updateItem(){
	/*var	l_h =  window.location.href;
	var index = l_h.indexOf("com");
	if(l_h.substr(index+4)!=""){
		return false;
	}*/
	var timeslot = 6000;
	var i =0;
	var update = setInterval(function(){
		var item = $(".items_container.yichi").find("li:last");
		var height = item.height();
		item.parent().prepend(item);
		item.css('opacity',0);
		item.parent().css('top',-height);
		item.parent().animate({'top':'0px'},500);
		setTimeout(function(){
			fadeIn(item);
		},1000);
		
		i++;
	},timeslot);
}
function fadeIn(obj){
	var item = obj;
	opa = 0;
	var fade = setInterval(function(){
		if(opa<1){
			opa += 0.005;
			$(item).css("opacity",opa);
		}
		else{
			clearInterval(fade);
		}
	},10);
}

function newOrderMessageHint(isLogin) {
    if (!isLogin) return;
    if(setInterval)
    {
        var now=new Date();
        var curYear=now.getFullYear();
        var curMonth=now.getMonth()+1;
        var curDay=now.getDate();
        var curHour = now.getHours();      //获取当前小时数(0-23)
        var curMinute = now.getMinutes();   // 获取当前分钟数(0-59)
        var curSec =now.getSeconds();  
        var startTime =  curYear+"-"+curMonth+"-"+curDay+ ' ' + curHour + ':' + curMinute + ':' + curSec;
        setInterval(function(){
            $.ajax({
                url: $.createUrl('public','newOrderMessageHint'),
                data: {startTime:startTime},
			    dataType: "json",
                type: 'GET',
                async: true,
                success:function(d){
                    if (d.count>0) {                               	
				        $(".orderNewHint").css("display","block");
                    }else{
				        $(".orderNewHint").css("display","none");
                    }
                }
            })}
        ,10000);
    } else {
        $(".orderNewHint").css("display","none");
    }
}

function newUserMessageHint(isLogin) {
    if (!isLogin) return;
    if(setInterval)
    {
        var now=new Date();
        var curYear=now.getFullYear();
        var curMonth=now.getMonth()+1;
        var curDay=now.getDate();
        var curHour = now.getHours();      //获取当前小时数(0-23)
        var curMinute = now.getMinutes();   // 获取当前分钟数(0-59)
        var curSec =now.getSeconds();
        var startTime =  curYear+"-"+curMonth+"-"+curDay+ ' ' + curHour + ':' + curMinute + ':' + curSec;
        setInterval(function(){
            $.ajax({
                url: $.createUrl('public','newUserMessageHint'),
                data: {startTime:startTime},
			    dataType: "json",
                type: 'GET',
                async: true,
                success:function(d){
                    if (d.count>0) {                               	
				        $(".newHint").css("display","block");
                    }else{
				        $(".newHint").css("display","none");
                    }
                }
            })}
        ,10000);
    } else {
        $(".newHint").css("display","none");
    }
}

//pc首页“最新交易”和“大家都在做什么”板块滚动效果
function rollEffect(obj){
	var obj_cl = obj.children().clone();
	var height = obj.height();
	obj.append(obj_cl);
	var top = 0;
	var t = setInterval(function(){
		obj.css('top',top);
		top-=1;
		if(top <= -height){
			top = 0;
		}
	},50);
}

function loadWpaLazy(){//重定位qq按钮
	var dev_h = document.documentElement.clientHeight;
	var initIframe = setInterval(function(){
		if($("iframe[width='92']").length>0){
			clearInterval(initIframe);
			$("iframe[width='92']").css({
				position: 'fixed',
		  		bottom: "10px",
		  		right: '19px',
		  		'z-index': 10000
			});
		}
	},2000);
}
/*浮动侧栏*/

function scrollTop(){
	$(".scroll_top").on("click",function(){
		$("body,html").animate({scrollTop:"0px"},400);
	})
}

function isGuestCheck(){//是否登陆
	if (isGuest) {
        if(window.confirm("请先登录！")){
          $.get($.createUrl('site', 'recordUrl'), {url: window.location.href}, function () {
              location.href = $.createUrl('public', 'login');
          }, 'json');
        }
        return true;
    }
    else{
    	return false;
    }
}

//通用搜索js
var word;
function searchInit(){
	$('.base_search_input').bind('keyup', function(event){
		if (event.keyCode == 38 || event.keyCode == 40){

			var key = event.keyCode - 39;
			var ss = $('.base_search_drop_activity').index() + key;
			$('.base_search_drop>ul>li').removeClass('base_search_drop_activity');
			$('#baseSearchDropLI'+ss).addClass('base_search_drop_activity');
			$('.base_search_input').val($('.base_search_drop_activity').text());

			$('.base_search_type').val($('.base_search_drop_activity').data('type'));
		}else if(event.keyCode == 13){
			if($('.base_search_drop').attr('opacity') != 0 && $('.base_search_drop_activity').text() != '' ){
				//searchHistory();

				searchHistory($('.base_search_drop_activity').text(), $('.base_search_drop_activity').data('type'));
				//$('.base_search_input').val($('.base_search_drop_activity').text());
				//('.base_search_btn').submit();
			}
		}else{
			word = $('.base_search_input').val();
			search();
		}
	});

	$('.base_search_input').bind('blur', function(){
		$('.base_search_drop').css('opacity','0');
	});
	$('.base_search_input').bind('focus', function(){
		$('.base_search_drop').css('opacity','1');
	})

	$('.base_search_tab').on('click', 'li', function(){
		$('.base_search_tab>ul>li').removeClass('selected');
		$(this).addClass('selected');
		$('.base_search_form>form').attr('action', $(this).data('url'));
	});

	$('.base_search_drop').on('click', 'li', function(){

		searchHistory($(this).text(), $(this).data('type'));
	})

	searchAssgin();
}

function jumpSearch(resault, type){
	$('.base_search_input').val(resault);
	$('.base_search_type').val(type);
	$('.base_search_form>form').submit();
}

var Comurl = "http://115.29.55.114:8092/hsh-api-search";
function getUserId(){
	var userId = $('#userId').val();
	if(userId == null || userId == ""){
		userId = $('#userSessionId').val();;
	}
	return userId;
}
function search(){
	//keyup propertychange
	//jQuery.support.cors = true; $this->user
	var url = Comurl+"/tip/list";
	var userId = getUserId();
	var word = $('.base_search_input').val();
	$('.base_search_drop>ul').html('');
	

	$.ajax({
		type:'post',
		datatype:'JSONP',
		jsonp: 'jsoncallback',
		url:url,
		data:{'userId': userId, 'word':word},
		success:function(res){
			if(res.data != null){
				var dataP = res.data.tips;
				
				$('.base_search_drop>ul').html('');
				$.each(dataP, function(n, value){
					$('.base_search_drop>ul').append('<li id="baseSearchDropLI'+n+'" data-type='+value['type']+'>'+
						value['word']+'</li>')
					
				})
			}


		},
		error:function(res){
			
		}
	})

}

function searchHistory(resault, type){
	var url = Comurl+"/tip/saveClick";
	var userId = getUserId();


	$.ajax({
		type:'post',
		datatype:'JSONP',
		jsonp: 'jsoncallback',
		url:url,
		data:{'userId': userId, 'word':word, 'result': resault, 'type':type},
		success:function(res){
			

			jumpSearch(resault, type);//成功之后再进行跳转
		},
		error:function(res){
			
		}
	})
}

function searchAssgin(){
	$('.base_search_input').val($('#searchKeyword').val());
}


;
/*** Script File: /js/includes/jquery.form.js ***/
/*!
 * jQuery Form Plugin
 * version: 3.50.0-2014.02.05
 * Requires jQuery v1.5 or later
 * Copyright (c) 2013 M. Alsup
 * Examples and documentation at: http://malsup.com/jquery/form/
 * Project repository: https://github.com/malsup/form
 * Dual licensed under the MIT and GPL licenses.
 * https://github.com/malsup/form#copyright-and-license
 */
/*global ActiveXObject */

// AMD support
(function (factory) {
    "use strict";
    if (typeof define === 'function' && define.amd) {
        // using AMD; register as anon module
        define(['jquery'], factory);
    } else {
        // no AMD; invoke directly
        factory( (typeof(jQuery) != 'undefined') ? jQuery : window.Zepto );
    }
}

(function($) {
"use strict";

/*
    Usage Note:
    -----------
    Do not use both ajaxSubmit and ajaxForm on the same form.  These
    functions are mutually exclusive.  Use ajaxSubmit if you want
    to bind your own submit handler to the form.  For example,

    $(document).ready(function() {
        $('#myForm').on('submit', function(e) {
            e.preventDefault(); // <-- important
            $(this).ajaxSubmit({
                target: '#output'
            });
        });
    });

    Use ajaxForm when you want the plugin to manage all the event binding
    for you.  For example,

    $(document).ready(function() {
        $('#myForm').ajaxForm({
            target: '#output'
        });
    });

    You can also use ajaxForm with delegation (requires jQuery v1.7+), so the
    form does not have to exist when you invoke ajaxForm:

    $('#myForm').ajaxForm({
        delegation: true,
        target: '#output'
    });

    When using ajaxForm, the ajaxSubmit function will be invoked for you
    at the appropriate time.
*/

/**
 * Feature detection
 */
var feature = {};
feature.fileapi = $("<input type='file'/>").get(0).files !== undefined;
feature.formdata = window.FormData !== undefined;

var hasProp = !!$.fn.prop;

// attr2 uses prop when it can but checks the return type for
// an expected string.  this accounts for the case where a form 
// contains inputs with names like "action" or "method"; in those
// cases "prop" returns the element
$.fn.attr2 = function() {
    if ( ! hasProp ) {
        return this.attr.apply(this, arguments);
    }
    var val = this.prop.apply(this, arguments);
    if ( ( val && val.jquery ) || typeof val === 'string' ) {
        return val;
    }
    return this.attr.apply(this, arguments);
};

/**
 * ajaxSubmit() provides a mechanism for immediately submitting
 * an HTML form using AJAX.
 */
$.fn.ajaxSubmit = function(options) {
    /*jshint scripturl:true */

    // fast fail if nothing selected (http://dev.jquery.com/ticket/2752)
    if (!this.length) {
        log('ajaxSubmit: skipping submit process - no element selected');
        return this;
    }

    var method, action, url, $form = this;

    if (typeof options == 'function') {
        options = { success: options };
    }
    else if ( options === undefined ) {
        options = {};
    }

    method = options.type || this.attr2('method');
    action = options.url  || this.attr2('action');

    url = (typeof action === 'string') ? $.trim(action) : '';
    url = url || window.location.href || '';
    if (url) {
        // clean url (don't include hash vaue)
        url = (url.match(/^([^#]+)/)||[])[1];
    }

    options = $.extend(true, {
        url:  url,
        success: $.ajaxSettings.success,
        type: method || $.ajaxSettings.type,
        iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank'
    }, options);

    // hook for manipulating the form data before it is extracted;
    // convenient for use with rich editors like tinyMCE or FCKEditor
    var veto = {};
    this.trigger('form-pre-serialize', [this, options, veto]);
    if (veto.veto) {
        log('ajaxSubmit: submit vetoed via form-pre-serialize trigger');
        return this;
    }

    // provide opportunity to alter form data before it is serialized
    if (options.beforeSerialize && options.beforeSerialize(this, options) === false) {
        log('ajaxSubmit: submit aborted via beforeSerialize callback');
        return this;
    }

    var traditional = options.traditional;
    if ( traditional === undefined ) {
        traditional = $.ajaxSettings.traditional;
    }

    var elements = [];
    var qx, a = this.formToArray(options.semantic, elements);
    if (options.data) {
        options.extraData = options.data;
        qx = $.param(options.data, traditional);
    }

    // give pre-submit callback an opportunity to abort the submit
    if (options.beforeSubmit && options.beforeSubmit(a, this, options) === false) {
        log('ajaxSubmit: submit aborted via beforeSubmit callback');
        return this;
    }

    // fire vetoable 'validate' event
    this.trigger('form-submit-validate', [a, this, options, veto]);
    if (veto.veto) {
        log('ajaxSubmit: submit vetoed via form-submit-validate trigger');
        return this;
    }

    var q = $.param(a, traditional);
    if (qx) {
        q = ( q ? (q + '&' + qx) : qx );
    }
    if (options.type.toUpperCase() == 'GET') {
        options.url += (options.url.indexOf('?') >= 0 ? '&' : '?') + q;
        options.data = null;  // data is null for 'get'
    }
    else {
        options.data = q; // data is the query string for 'post'
    }

    var callbacks = [];
    if (options.resetForm) {
        callbacks.push(function() { $form.resetForm(); });
    }
    if (options.clearForm) {
        callbacks.push(function() { $form.clearForm(options.includeHidden); });
    }

    // perform a load on the target only if dataType is not provided
    if (!options.dataType && options.target) {
        var oldSuccess = options.success || function(){};
        callbacks.push(function(data) {
            var fn = options.replaceTarget ? 'replaceWith' : 'html';
            $(options.target)[fn](data).each(oldSuccess, arguments);
        });
    }
    else if (options.success) {
        callbacks.push(options.success);
    }

    options.success = function(data, status, xhr) { // jQuery 1.4+ passes xhr as 3rd arg
        var context = options.context || this ;    // jQuery 1.4+ supports scope context
        for (var i=0, max=callbacks.length; i < max; i++) {
            callbacks[i].apply(context, [data, status, xhr || $form, $form]);
        }
    };

    if (options.error) {
        var oldError = options.error;
        options.error = function(xhr, status, error) {
            var context = options.context || this;
            oldError.apply(context, [xhr, status, error, $form]);
        };
    }

     if (options.complete) {
        var oldComplete = options.complete;
        options.complete = function(xhr, status) {
            var context = options.context || this;
            oldComplete.apply(context, [xhr, status, $form]);
        };
    }

    // are there files to upload?

    // [value] (issue #113), also see comment:
    // https://github.com/malsup/form/commit/588306aedba1de01388032d5f42a60159eea9228#commitcomment-2180219
    var fileInputs = $('input[type=file]:enabled', this).filter(function() { return $(this).val() !== ''; });

    var hasFileInputs = fileInputs.length > 0;
    var mp = 'multipart/form-data';
    var multipart = ($form.attr('enctype') == mp || $form.attr('encoding') == mp);

    var fileAPI = feature.fileapi && feature.formdata;
    log("fileAPI :" + fileAPI);
    var shouldUseFrame = (hasFileInputs || multipart) && !fileAPI;

    var jqxhr;

    // options.iframe allows user to force iframe mode
    // 06-NOV-09: now defaulting to iframe mode if file input is detected
    if (options.iframe !== false && (options.iframe || shouldUseFrame)) {
        // hack to fix Safari hang (thanks to Tim Molendijk for this)
        // see:  http://groups.google.com/group/jquery-dev/browse_thread/thread/36395b7ab510dd5d
        if (options.closeKeepAlive) {
            $.get(options.closeKeepAlive, function() {
                jqxhr = fileUploadIframe(a);
            });
        }
        else {
            jqxhr = fileUploadIframe(a);
        }
    }
    else if ((hasFileInputs || multipart) && fileAPI) {
        jqxhr = fileUploadXhr(a);
    }
    else {
        jqxhr = $.ajax(options);
    }

    $form.removeData('jqxhr').data('jqxhr', jqxhr);

    // clear element array
    for (var k=0; k < elements.length; k++) {
        elements[k] = null;
    }

    // fire 'notify' event
    this.trigger('form-submit-notify', [this, options]);
    return this;

    // utility fn for deep serialization
    function deepSerialize(extraData){
        var serialized = $.param(extraData, options.traditional).split('&');
        var len = serialized.length;
        var result = [];
        var i, part;
        for (i=0; i < len; i++) {
            // #252; undo param space replacement
            serialized[i] = serialized[i].replace(/\+/g,' ');
            part = serialized[i].split('=');
            // #278; use array instead of object storage, favoring array serializations
            result.push([decodeURIComponent(part[0]), decodeURIComponent(part[1])]);
        }
        return result;
    }

     // XMLHttpRequest Level 2 file uploads (big hat tip to francois2metz)
    function fileUploadXhr(a) {
        var formdata = new FormData();

        for (var i=0; i < a.length; i++) {
            formdata.append(a[i].name, a[i].value);
        }

        if (options.extraData) {
            var serializedData = deepSerialize(options.extraData);
            for (i=0; i < serializedData.length; i++) {
                if (serializedData[i]) {
                    formdata.append(serializedData[i][0], serializedData[i][1]);
                }
            }
        }

        options.data = null;

        var s = $.extend(true, {}, $.ajaxSettings, options, {
            contentType: false,
            processData: false,
            cache: false,
            type: method || 'POST'
        });

        if (options.uploadProgress) {
            // workaround because jqXHR does not expose upload property
            s.xhr = function() {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position; /*event.position is deprecated*/
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        options.uploadProgress(event, position, total, percent);
                    }, false);
                }
                return xhr;
            };
        }

        s.data = null;
        var beforeSend = s.beforeSend;
        s.beforeSend = function(xhr, o) {
            //Send FormData() provided by user
            if (options.formData) {
                o.data = options.formData;
            }
            else {
                o.data = formdata;
            }
            if(beforeSend) {
                beforeSend.call(this, xhr, o);
            }
        };
        return $.ajax(s);
    }

    // private function for handling file uploads (hat tip to YAHOO!)
    function fileUploadIframe(a) {
        var form = $form[0], el, i, s, g, id, $io, io, xhr, sub, n, timedOut, timeoutHandle;
        var deferred = $.Deferred();

        // #341
        deferred.abort = function(status) {
            xhr.abort(status);
        };

        if (a) {
            // ensure that every serialized input is still enabled
            for (i=0; i < elements.length; i++) {
                el = $(elements[i]);
                if ( hasProp ) {
                    el.prop('disabled', false);
                }
                else {
                    el.removeAttr('disabled');
                }
            }
        }

        s = $.extend(true, {}, $.ajaxSettings, options);
        s.context = s.context || s;
        id = 'jqFormIO' + (new Date().getTime());
        if (s.iframeTarget) {
            $io = $(s.iframeTarget);
            n = $io.attr2('name');
            if (!n) {
                $io.attr2('name', id);
            }
            else {
                id = n;
            }
        }
        else {
            $io = $('<iframe name="' + id + '" src="'+ s.iframeSrc +'" />');
            $io.css({ position: 'absolute', top: '-1000px', left: '-1000px' });
        }
        io = $io[0];


        xhr = { // mock object
            aborted: 0,
            responseText: null,
            responseXML: null,
            status: 0,
            statusText: 'n/a',
            getAllResponseHeaders: function() {},
            getResponseHeader: function() {},
            setRequestHeader: function() {},
            abort: function(status) {
                var e = (status === 'timeout' ? 'timeout' : 'aborted');
                log('aborting upload... ' + e);
                this.aborted = 1;

                try { // #214, #257
                    if (io.contentWindow.document.execCommand) {
                        io.contentWindow.document.execCommand('Stop');
                    }
                }
                catch(ignore) {}

                $io.attr('src', s.iframeSrc); // abort op in progress
                xhr.error = e;
                if (s.error) {
                    s.error.call(s.context, xhr, e, status);
                }
                if (g) {
                    $.event.trigger("ajaxError", [xhr, s, e]);
                }
                if (s.complete) {
                    s.complete.call(s.context, xhr, e);
                }
            }
        };

        g = s.global;
        // trigger ajax global events so that activity/block indicators work like normal
        if (g && 0 === $.active++) {
            $.event.trigger("ajaxStart");
        }
        if (g) {
            $.event.trigger("ajaxSend", [xhr, s]);
        }

        if (s.beforeSend && s.beforeSend.call(s.context, xhr, s) === false) {
            if (s.global) {
                $.active--;
            }
            deferred.reject();
            return deferred;
        }
        if (xhr.aborted) {
            deferred.reject();
            return deferred;
        }

        // add submitting element to data if we know it
        sub = form.clk;
        if (sub) {
            n = sub.name;
            if (n && !sub.disabled) {
                s.extraData = s.extraData || {};
                s.extraData[n] = sub.value;
                if (sub.type == "image") {
                    s.extraData[n+'.x'] = form.clk_x;
                    s.extraData[n+'.y'] = form.clk_y;
                }
            }
        }

        var CLIENT_TIMEOUT_ABORT = 1;
        var SERVER_ABORT = 2;
                
        function getDoc(frame) {
            /* it looks like contentWindow or contentDocument do not
             * carry the protocol property in ie8, when running under ssl
             * frame.document is the only valid response document, since
             * the protocol is know but not on the other two objects. strange?
             * "Same origin policy" http://en.wikipedia.org/wiki/Same_origin_policy
             */
            
            var doc = null;
            
            // IE8 cascading access check
            try {
                if (frame.contentWindow) {
                    doc = frame.contentWindow.document;
                }
            } catch(err) {
                // IE8 access denied under ssl & missing protocol
                log('cannot get iframe.contentWindow document: ' + err);
            }

            if (doc) { // successful getting content
                return doc;
            }

            try { // simply checking may throw in ie8 under ssl or mismatched protocol
                doc = frame.contentDocument ? frame.contentDocument : frame.document;
            } catch(err) {
                // last attempt
                log('cannot get iframe.contentDocument: ' + err);
                doc = frame.document;
            }
            return doc;
        }

        // Rails CSRF hack (thanks to Yvan Barthelemy)
        var csrf_token = $('meta[name=csrf-token]').attr('content');
        var csrf_param = $('meta[name=csrf-param]').attr('content');
        if (csrf_param && csrf_token) {
            s.extraData = s.extraData || {};
            s.extraData[csrf_param] = csrf_token;
        }

        // take a breath so that pending repaints get some cpu time before the upload starts
        function doSubmit() {
            // make sure form attrs are set
            var t = $form.attr2('target'), 
                a = $form.attr2('action'), 
                mp = 'multipart/form-data',
                et = $form.attr('enctype') || $form.attr('encoding') || mp;

            // update form attrs in IE friendly way
            form.setAttribute('target',id);
            if (!method || /post/i.test(method) ) {
                form.setAttribute('method', 'POST');
            }
            if (a != s.url) {
                form.setAttribute('action', s.url);
            }

            // ie borks in some cases when setting encoding
            if (! s.skipEncodingOverride && (!method || /post/i.test(method))) {
                $form.attr({
                    encoding: 'multipart/form-data',
                    enctype:  'multipart/form-data'
                });
            }

            // support timout
            if (s.timeout) {
                timeoutHandle = setTimeout(function() { timedOut = true; cb(CLIENT_TIMEOUT_ABORT); }, s.timeout);
            }

            // look for server aborts
            function checkState() {
                try {
                    var state = getDoc(io).readyState;
                    log('state = ' + state);
                    if (state && state.toLowerCase() == 'uninitialized') {
                        setTimeout(checkState,50);
                    }
                }
                catch(e) {
                    log('Server abort: ' , e, ' (', e.name, ')');
                    cb(SERVER_ABORT);
                    if (timeoutHandle) {
                        clearTimeout(timeoutHandle);
                    }
                    timeoutHandle = undefined;
                }
            }

            // add "extra" data to form if provided in options
            var extraInputs = [];
            try {
                if (s.extraData) {
                    for (var n in s.extraData) {
                        if (s.extraData.hasOwnProperty(n)) {
                           // if using the $.param format that allows for multiple values with the same name
                           if($.isPlainObject(s.extraData[n]) && s.extraData[n].hasOwnProperty('name') && s.extraData[n].hasOwnProperty('value')) {
                               extraInputs.push(
                               $('<input type="hidden" name="'+s.extraData[n].name+'">').val(s.extraData[n].value)
                                   .appendTo(form)[0]);
                           } else {
                               extraInputs.push(
                               $('<input type="hidden" name="'+n+'">').val(s.extraData[n])
                                   .appendTo(form)[0]);
                           }
                        }
                    }
                }

                if (!s.iframeTarget) {
                    // add iframe to doc and submit the form
                    $io.appendTo('body');
                }
                if (io.attachEvent) {
                    io.attachEvent('onload', cb);
                }
                else {
                    io.addEventListener('load', cb, false);
                }
                setTimeout(checkState,15);

                try {
                    form.submit();
                } catch(err) {
                    // just in case form has element with name/id of 'submit'
                    var submitFn = document.createElement('form').submit;
                    submitFn.apply(form);
                }
            }
            finally {
                // reset attrs and remove "extra" input elements
                form.setAttribute('action',a);
                form.setAttribute('enctype', et); // #380
                if(t) {
                    form.setAttribute('target', t);
                } else {
                    $form.removeAttr('target');
                }
                $(extraInputs).remove();
            }
        }

        if (s.forceSync) {
            doSubmit();
        }
        else {
            setTimeout(doSubmit, 10); // this lets dom updates render
        }

        var data, doc, domCheckCount = 50, callbackProcessed;

        function cb(e) {
            if (xhr.aborted || callbackProcessed) {
                return;
            }
            
            doc = getDoc(io);
            if(!doc) {
                log('cannot access response document');
                e = SERVER_ABORT;
            }
            if (e === CLIENT_TIMEOUT_ABORT && xhr) {
                xhr.abort('timeout');
                deferred.reject(xhr, 'timeout');
                return;
            }
            else if (e == SERVER_ABORT && xhr) {
                xhr.abort('server abort');
                deferred.reject(xhr, 'error', 'server abort');
                return;
            }

            if (!doc || doc.location.href == s.iframeSrc) {
                // response not received yet
                if (!timedOut) {
                    return;
                }
            }
            if (io.detachEvent) {
                io.detachEvent('onload', cb);
            }
            else {
                io.removeEventListener('load', cb, false);
            }

            var status = 'success', errMsg;
            try {
                if (timedOut) {
                    throw 'timeout';
                }

                var isXml = s.dataType == 'xml' || doc.XMLDocument || $.isXMLDoc(doc);
                log('isXml='+isXml);
                if (!isXml && window.opera && (doc.body === null || !doc.body.innerHTML)) {
                    if (--domCheckCount) {
                        // in some browsers (Opera) the iframe DOM is not always traversable when
                        // the onload callback fires, so we loop a bit to accommodate
                        log('requeing onLoad callback, DOM not available');
                        setTimeout(cb, 250);
                        return;
                    }
                    // let this fall through because server response could be an empty document
                    //log('Could not access iframe DOM after mutiple tries.');
                    //throw 'DOMException: not available';
                }

                //log('response detected');
                var docRoot = doc.body ? doc.body : doc.documentElement;
                xhr.responseText = docRoot ? docRoot.innerHTML : null;
                xhr.responseXML = doc.XMLDocument ? doc.XMLDocument : doc;
                if (isXml) {
                    s.dataType = 'xml';
                }
                xhr.getResponseHeader = function(header){
                    var headers = {'content-type': s.dataType};
                    return headers[header.toLowerCase()];
                };
                // support for XHR 'status' & 'statusText' emulation :
                if (docRoot) {
                    xhr.status = Number( docRoot.getAttribute('status') ) || xhr.status;
                    xhr.statusText = docRoot.getAttribute('statusText') || xhr.statusText;
                }

                var dt = (s.dataType || '').toLowerCase();
                var scr = /(json|script|text)/.test(dt);
                if (scr || s.textarea) {
                    // see if user embedded response in textarea
                    var ta = doc.getElementsByTagName('textarea')[0];
                    if (ta) {
                        xhr.responseText = ta.value;
                        // support for XHR 'status' & 'statusText' emulation :
                        xhr.status = Number( ta.getAttribute('status') ) || xhr.status;
                        xhr.statusText = ta.getAttribute('statusText') || xhr.statusText;
                    }
                    else if (scr) {
                        // account for browsers injecting pre around json response
                        var pre = doc.getElementsByTagName('pre')[0];
                        var b = doc.getElementsByTagName('body')[0];
                        if (pre) {
                            xhr.responseText = pre.textContent ? pre.textContent : pre.innerText;
                        }
                        else if (b) {
                            xhr.responseText = b.textContent ? b.textContent : b.innerText;
                        }
                    }
                }
                else if (dt == 'xml' && !xhr.responseXML && xhr.responseText) {
                    xhr.responseXML = toXml(xhr.responseText);
                }

                try {
                    data = httpData(xhr, dt, s);
                }
                catch (err) {
                    status = 'parsererror';
                    xhr.error = errMsg = (err || status);
                }
            }
            catch (err) {
                log('error caught: ',err);
                status = 'error';
                xhr.error = errMsg = (err || status);
            }

            if (xhr.aborted) {
                log('upload aborted');
                status = null;
            }

            if (xhr.status) { // we've set xhr.status
                status = (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) ? 'success' : 'error';
            }

            // ordering of these callbacks/triggers is odd, but that's how $.ajax does it
            if (status === 'success') {
                if (s.success) {
                    s.success.call(s.context, data, 'success', xhr);
                }
                deferred.resolve(xhr.responseText, 'success', xhr);
                if (g) {
                    $.event.trigger("ajaxSuccess", [xhr, s]);
                }
            }
            else if (status) {
                if (errMsg === undefined) {
                    errMsg = xhr.statusText;
                }
                if (s.error) {
                    s.error.call(s.context, xhr, status, errMsg);
                }
                deferred.reject(xhr, 'error', errMsg);
                if (g) {
                    $.event.trigger("ajaxError", [xhr, s, errMsg]);
                }
            }

            if (g) {
                $.event.trigger("ajaxComplete", [xhr, s]);
            }

            if (g && ! --$.active) {
                $.event.trigger("ajaxStop");
            }

            if (s.complete) {
                s.complete.call(s.context, xhr, status);
            }

            callbackProcessed = true;
            if (s.timeout) {
                clearTimeout(timeoutHandle);
            }

            // clean up
            setTimeout(function() {
                if (!s.iframeTarget) {
                    $io.remove();
                }
                else { //adding else to clean up existing iframe response.
                    $io.attr('src', s.iframeSrc);
                }
                xhr.responseXML = null;
            }, 100);
        }

        var toXml = $.parseXML || function(s, doc) { // use parseXML if available (jQuery 1.5+)
            if (window.ActiveXObject) {
                doc = new ActiveXObject('Microsoft.XMLDOM');
                doc.async = 'false';
                doc.loadXML(s);
            }
            else {
                doc = (new DOMParser()).parseFromString(s, 'text/xml');
            }
            return (doc && doc.documentElement && doc.documentElement.nodeName != 'parsererror') ? doc : null;
        };
        var parseJSON = $.parseJSON || function(s) {
            /*jslint evil:true */
            return window['eval']('(' + s + ')');
        };

        var httpData = function( xhr, type, s ) { // mostly lifted from jq1.4.4

            var ct = xhr.getResponseHeader('content-type') || '',
                xml = type === 'xml' || !type && ct.indexOf('xml') >= 0,
                data = xml ? xhr.responseXML : xhr.responseText;

            if (xml && data.documentElement.nodeName === 'parsererror') {
                if ($.error) {
                    $.error('parsererror');
                }
            }
            if (s && s.dataFilter) {
                data = s.dataFilter(data, type);
            }
            if (typeof data === 'string') {
                if (type === 'json' || !type && ct.indexOf('json') >= 0) {
                    data = parseJSON(data);
                } else if (type === "script" || !type && ct.indexOf("javascript") >= 0) {
                    $.globalEval(data);
                }
            }
            return data;
        };

        return deferred;
    }
};

/**
 * ajaxForm() provides a mechanism for fully automating form submission.
 *
 * The advantages of using this method instead of ajaxSubmit() are:
 *
 * 1: This method will include coordinates for <input type="image" /> elements (if the element
 *    is used to submit the form).
 * 2. This method will include the submit element's name/value data (for the element that was
 *    used to submit the form).
 * 3. This method binds the submit() method to the form for you.
 *
 * The options argument for ajaxForm works exactly as it does for ajaxSubmit.  ajaxForm merely
 * passes the options argument along after properly binding events for submit elements and
 * the form itself.
 */
$.fn.ajaxForm = function(options) {
    options = options || {};
    options.delegation = options.delegation && $.isFunction($.fn.on);

    // in jQuery 1.3+ we can fix mistakes with the ready state
    if (!options.delegation && this.length === 0) {
        var o = { s: this.selector, c: this.context };
        if (!$.isReady && o.s) {
            log('DOM not ready, queuing ajaxForm');
            $(function() {
                $(o.s,o.c).ajaxForm(options);
            });
            return this;
        }
        // is your DOM ready?  http://docs.jquery.com/Tutorials:Introducing_$(document).ready()
        log('terminating; zero elements found by selector' + ($.isReady ? '' : ' (DOM not ready)'));
        return this;
    }

    if ( options.delegation ) {
        $(document)
            .off('submit.form-plugin', this.selector, doAjaxSubmit)
            .off('click.form-plugin', this.selector, captureSubmittingElement)
            .on('submit.form-plugin', this.selector, options, doAjaxSubmit)
            .on('click.form-plugin', this.selector, options, captureSubmittingElement);
        return this;
    }

    return this.ajaxFormUnbind()
        .bind('submit.form-plugin', options, doAjaxSubmit)
        .bind('click.form-plugin', options, captureSubmittingElement);
};

// private event handlers
function doAjaxSubmit(e) {
    /*jshint validthis:true */
    var options = e.data;
    if (!e.isDefaultPrevented()) { // if event has been canceled, don't proceed
        e.preventDefault();
        $(e.target).ajaxSubmit(options); // #365
    }
}

function captureSubmittingElement(e) {
    /*jshint validthis:true */
    var target = e.target;
    var $el = $(target);
    if (!($el.is("[type=submit],[type=image]"))) {
        // is this a child element of the submit el?  (ex: a span within a button)
        var t = $el.closest('[type=submit]');
        if (t.length === 0) {
            return;
        }
        target = t[0];
    }
    var form = this;
    form.clk = target;
    if (target.type == 'image') {
        if (e.offsetX !== undefined) {
            form.clk_x = e.offsetX;
            form.clk_y = e.offsetY;
        } else if (typeof $.fn.offset == 'function') {
            var offset = $el.offset();
            form.clk_x = e.pageX - offset.left;
            form.clk_y = e.pageY - offset.top;
        } else {
            form.clk_x = e.pageX - target.offsetLeft;
            form.clk_y = e.pageY - target.offsetTop;
        }
    }
    // clear form vars
    setTimeout(function() { form.clk = form.clk_x = form.clk_y = null; }, 100);
}


// ajaxFormUnbind unbinds the event handlers that were bound by ajaxForm
$.fn.ajaxFormUnbind = function() {
    return this.unbind('submit.form-plugin click.form-plugin');
};

/**
 * formToArray() gathers form element data into an array of objects that can
 * be passed to any of the following ajax functions: $.get, $.post, or load.
 * Each object in the array has both a 'name' and 'value' property.  An example of
 * an array for a simple login form might be:
 *
 * [ { name: 'username', value: 'jresig' }, { name: 'password', value: 'secret' } ]
 *
 * It is this array that is passed to pre-submit callback functions provided to the
 * ajaxSubmit() and ajaxForm() methods.
 */
$.fn.formToArray = function(semantic, elements) {
    var a = [];
    if (this.length === 0) {
        return a;
    }

    var form = this[0];
    var formId = this.attr('id');
    var els = semantic ? form.getElementsByTagName('*') : form.elements;
    var els2;

    if (els && !/MSIE [678]/.test(navigator.userAgent)) { // #390
        els = $(els).get();  // convert to standard array
    }

    // #386; account for inputs outside the form which use the 'form' attribute
    if ( formId ) {
        els2 = $(':input[form=' + formId + ']').get();
        if ( els2.length ) {
            els = (els || []).concat(els2);
        }
    }

    if (!els || !els.length) {
        return a;
    }

    var i,j,n,v,el,max,jmax;
    for(i=0, max=els.length; i < max; i++) {
        el = els[i];
        n = el.name;
        if (!n || el.disabled) {
            continue;
        }

        if (semantic && form.clk && el.type == "image") {
            // handle image inputs on the fly when semantic == true
            if(form.clk == el) {
                a.push({name: n, value: $(el).val(), type: el.type });
                a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
            }
            continue;
        }

        v = $.fieldValue(el, true);
        if (v && v.constructor == Array) {
            if (elements) {
                elements.push(el);
            }
            for(j=0, jmax=v.length; j < jmax; j++) {
                a.push({name: n, value: v[j]});
            }
        }
        else if (feature.fileapi && el.type == 'file') {
            if (elements) {
                elements.push(el);
            }
            var files = el.files;
            if (files.length) {
                for (j=0; j < files.length; j++) {
                    a.push({name: n, value: files[j], type: el.type});
                }
            }
            else {
                // #180
                a.push({ name: n, value: '', type: el.type });
            }
        }
        else if (v !== null && typeof v != 'undefined') {
            if (elements) {
                elements.push(el);
            }
            a.push({name: n, value: v, type: el.type, required: el.required});
        }
    }

    if (!semantic && form.clk) {
        // input type=='image' are not found in elements array! handle it here
        var $input = $(form.clk), input = $input[0];
        n = input.name;
        if (n && !input.disabled && input.type == 'image') {
            a.push({name: n, value: $input.val()});
            a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
        }
    }
    return a;
};

/**
 * Serializes form data into a 'submittable' string. This method will return a string
 * in the format: name1=value1&amp;name2=value2
 */
$.fn.formSerialize = function(semantic) {
    //hand off to jQuery.param for proper encoding
    return $.param(this.formToArray(semantic));
};

/**
 * Serializes all field elements in the jQuery object into a query string.
 * This method will return a string in the format: name1=value1&amp;name2=value2
 */
$.fn.fieldSerialize = function(successful) {
    var a = [];
    this.each(function() {
        var n = this.name;
        if (!n) {
            return;
        }
        var v = $.fieldValue(this, successful);
        if (v && v.constructor == Array) {
            for (var i=0,max=v.length; i < max; i++) {
                a.push({name: n, value: v[i]});
            }
        }
        else if (v !== null && typeof v != 'undefined') {
            a.push({name: this.name, value: v});
        }
    });
    //hand off to jQuery.param for proper encoding
    return $.param(a);
};

/**
 * Returns the value(s) of the element in the matched set.  For example, consider the following form:
 *
 *  <form><fieldset>
 *      <input name="A" type="text" />
 *      <input name="A" type="text" />
 *      <input name="B" type="checkbox" value="B1" />
 *      <input name="B" type="checkbox" value="B2"/>
 *      <input name="C" type="radio" value="C1" />
 *      <input name="C" type="radio" value="C2" />
 *  </fieldset></form>
 *
 *  var v = $('input[type=text]').fieldValue();
 *  // if no values are entered into the text inputs
 *  v == ['','']
 *  // if values entered into the text inputs are 'foo' and 'bar'
 *  v == ['foo','bar']
 *
 *  var v = $('input[type=checkbox]').fieldValue();
 *  // if neither checkbox is checked
 *  v === undefined
 *  // if both checkboxes are checked
 *  v == ['B1', 'B2']
 *
 *  var v = $('input[type=radio]').fieldValue();
 *  // if neither radio is checked
 *  v === undefined
 *  // if first radio is checked
 *  v == ['C1']
 *
 * The successful argument controls whether or not the field element must be 'successful'
 * (per http://www.w3.org/TR/html4/interact/forms.html#successful-controls).
 * The default value of the successful argument is true.  If this value is false the value(s)
 * for each element is returned.
 *
 * Note: This method *always* returns an array.  If no valid value can be determined the
 *    array will be empty, otherwise it will contain one or more values.
 */
$.fn.fieldValue = function(successful) {
    for (var val=[], i=0, max=this.length; i < max; i++) {
        var el = this[i];
        var v = $.fieldValue(el, successful);
        if (v === null || typeof v == 'undefined' || (v.constructor == Array && !v.length)) {
            continue;
        }
        if (v.constructor == Array) {
            $.merge(val, v);
        }
        else {
            val.push(v);
        }
    }
    return val;
};

/**
 * Returns the value of the field element.
 */
$.fieldValue = function(el, successful) {
    var n = el.name, t = el.type, tag = el.tagName.toLowerCase();
    if (successful === undefined) {
        successful = true;
    }

    if (successful && (!n || el.disabled || t == 'reset' || t == 'button' ||
        (t == 'checkbox' || t == 'radio') && !el.checked ||
        (t == 'submit' || t == 'image') && el.form && el.form.clk != el ||
        tag == 'select' && el.selectedIndex == -1)) {
            return null;
    }

    if (tag == 'select') {
        var index = el.selectedIndex;
        if (index < 0) {
            return null;
        }
        var a = [], ops = el.options;
        var one = (t == 'select-one');
        var max = (one ? index+1 : ops.length);
        for(var i=(one ? index : 0); i < max; i++) {
            var op = ops[i];
            if (op.selected) {
                var v = op.value;
                if (!v) { // extra pain for IE...
                    v = (op.attributes && op.attributes.value && !(op.attributes.value.specified)) ? op.text : op.value;
                }
                if (one) {
                    return v;
                }
                a.push(v);
            }
        }
        return a;
    }
    return $(el).val();
};

/**
 * Clears the form data.  Takes the following actions on the form's input fields:
 *  - input text fields will have their 'value' property set to the empty string
 *  - select elements will have their 'selectedIndex' property set to -1
 *  - checkbox and radio inputs will have their 'checked' property set to false
 *  - inputs of type submit, button, reset, and hidden will *not* be effected
 *  - button elements will *not* be effected
 */
$.fn.clearForm = function(includeHidden) {
    return this.each(function() {
        $('input,select,textarea', this).clearFields(includeHidden);
    });
};

/**
 * Clears the selected form elements.
 */
$.fn.clearFields = $.fn.clearInputs = function(includeHidden) {
    var re = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i; // 'hidden' is not in this list
    return this.each(function() {
        var t = this.type, tag = this.tagName.toLowerCase();
        if (re.test(t) || tag == 'textarea') {
            this.value = '';
        }
        else if (t == 'checkbox' || t == 'radio') {
            this.checked = false;
        }
        else if (tag == 'select') {
            this.selectedIndex = -1;
        }
		else if (t == "file") {
			if (/MSIE/.test(navigator.userAgent)) {
				$(this).replaceWith($(this).clone(true));
			} else {
				$(this).val('');
			}
		}
        else if (includeHidden) {
            // includeHidden can be the value true, or it can be a selector string
            // indicating a special test; for example:
            //  $('#myForm').clearForm('.special:hidden')
            // the above would clean hidden inputs that have the class of 'special'
            if ( (includeHidden === true && /hidden/.test(t)) ||
                 (typeof includeHidden == 'string' && $(this).is(includeHidden)) ) {
                this.value = '';
            }
        }
    });
};

/**
 * Resets the form data.  Causes all form elements to be reset to their original value.
 */
$.fn.resetForm = function() {
    return this.each(function() {
        // guard against an input with the name of 'reset'
        // note that IE reports the reset function as an 'object'
        if (typeof this.reset == 'function' || (typeof this.reset == 'object' && !this.reset.nodeType)) {
            this.reset();
        }
    });
};

/**
 * Enables or disables any matching elements.
 */
$.fn.enable = function(b) {
    if (b === undefined) {
        b = true;
    }
    return this.each(function() {
        this.disabled = !b;
    });
};

/**
 * Checks/unchecks any matching checkboxes or radio buttons and
 * selects/deselects and matching option elements.
 */
$.fn.selected = function(select) {
    if (select === undefined) {
        select = true;
    }
    return this.each(function() {
        var t = this.type;
        if (t == 'checkbox' || t == 'radio') {
            this.checked = select;
        }
        else if (this.tagName.toLowerCase() == 'option') {
            var $sel = $(this).parent('select');
            if (select && $sel[0] && $sel[0].type == 'select-one') {
                // deselect all other options
                $sel.find('option').selected(false);
            }
            this.selected = select;
        }
    });
};

// expose debug var
$.fn.ajaxSubmit.debug = false;

// helper fn for console logging
function log() {
    if (!$.fn.ajaxSubmit.debug) {
        return;
    }
    var msg = '[jquery.form] ' + Array.prototype.join.call(arguments,'');
    if (window.console && window.console.log) {
        window.console.log(msg);
    }
    else if (window.opera && window.opera.postError) {
        window.opera.postError(msg);
    }
}

}));


;
/*** Script File: /js/allcommon.js ***/
function removeHTMLTag(str) {
    str = str.replace(/<\/?[^>]*>/g,''); //去除HTML tag
    str = str.replace(/[ | ]*\n/g,'\n'); //去除行尾空白
    //str = str.replace(/\n[\s| | ]*\r/g,'\n'); //去除多余空行
    str=str.replace(/&nbsp;/ig,'');//去掉&nbsp;
    return str;
}
function is_obj(obj) {
    return typeof obj === 'object' && Object.prototype.toString.call(obj).toLowerCase() === '[object object]' && !obj.length;
}
function is_array(value) {
    return Object.prototype.toString.apply(value) === '[object Array]';
    if (!value)
        return false;
    return (value instanceof Array);
};
// 获取按键的对象
// @ev 表示点击事件回调函数中的第一个参数
function get_currKey(ev) {
	var e = ev || event;

	return e.keyCode || e.which || e.charCode;
}
//解析程序段get_errors函数输出的错误信息，默认间隔符号为换行
function parse_info(arr, d) {
	if (typeof arr == 'string') {
		return arr;
	}
	if (typeof d == 'undefined') {
		d = "\n";
	}
	var str = c = '';
	for (var key in arr) {
		str += c + arr[key];
		c = d;
	}
	return str;
}
// php in_array的js版
function in_array(str, arr) {
	for (var k in arr) {
		if (arr[k] == str) {
			return true;
		}
	}
	return false;
}
// 获取json格式数据，返回key=>json数据
function get_key_val(data, key) {
	var res = [];
	for (var k in data) {
		res[data[k][key]] = data[k];
	}
	return res;
}
// 根据分隔符，数组转化成字符串
function implode(d, arr) {
	if (!d) {
		d = ',';
	}
	var str = '';
	var c = '';
	for (var key in arr) {
		str += c + arr[key];
		c = d;
	}
	return str;
}
// ajax form 的泛用性调用，参数为表单的ID，使用前请确认已经加载jquery.form.js
function ajaxSubmit(form_id, success_callback) {
	var options = {
		dataType: "json",
		success: function(msg) {
			if (!msg.status) {
				alert(parse_info(msg.info));
			} else {
				if (msg.info) {
					if (typeof success_callback == 'function') {
						alert(msg.info, success_callback);
					} else {
						alert(msg.info);
					}
				} else if (typeof success_callback == 'function') {
					success_callback(msg);
				} else if (msg.extra && typeof msg.extra == 'string') {
					eval(msg.extra);
				}
			}
		}
	};
	$("#" + form_id).ajaxSubmit(options);
}
// ajax 返回的success方法，用于页面刷新
function ajaxSuccess(msg) {
	if (!msg.status) {
		alert(parse_info(msg.info));
	} else {
		//表格刷新
		if (msg.info != null)
			ajaxRefresh(msg.info);
		//附加操作
		if (msg.extra) {
			if (typeof msg.extra == 'string')
				eval(msg.extra);
			else {
				for (var key in msg.extra) {
					$("." + key).html(msg.extra[key]);
				}
			}
		}
	}
}
// ajax 分页
function ajaxPage(obj) {
	var url = $(obj).attr('href');
	if (url.indexOf('ajax_page = 1') == -1) {
		url = add_url_param(url, {
			'ajax_page': 1
		});
	}
	$.get(url, '', ajaxSuccess, 'json');
	return false;
}
// ajax 刷新页面
function ajaxRefresh(html) {
	if (typeof refresh_class == 'undefined') {
		$(".main_data").html(html);
	} else {
		$("." + refresh_class).html(html);
	}
}
// 判断是否引入js
function is_include(name) {

	var js = /js$/i.test(name);

	var es = document.getElementsByTagName(js ? 'script' : 'link');

	for (var i = 0; i < es.length; i++) {
		if (es[i][js ? 'src' : 'href'].indexOf(name) != -1) {
			return true;
		}
	}

	return false;
}
// 删除url参数
function del_url_param(url, obj) {
	for (var key in obj) {
		var reg = new RegExp('([\\?|&])' + obj[key] + '=(\\w*)&?', "i");
		url = url.replace(reg, '$1');
	}
	// 如果末尾有&或?号则删除
	var r = new RegExp('[\?|&]$', 'i');
	url = url.replace(r, '');
	return url;
}
// 替换url参数值
function rep_url_param(url, obj) {
	url += '&';

	for (var key in obj) {
		var reg = new RegExp('(' + key + '=).*?(&)', "i");
		url = url.replace(reg, '$1' + obj[key] + '$2');
	}
	var r = new RegExp('&$', 'i');
	url = url.replace(r, '');

	return url;
}
// 构造url参数
function add_url_param(url, obj) {
	var joinChar = (url.indexOf('?') === -1) ? '?' : '&',
		arrParams = [],
		strParams = '';
	for (var key in obj) {
		arrParams[arrParams.length] = '&' + key + '=' + obj[key];
	}
	// 去掉第一个'&', 因为有joinChar存在
	strParams = arrParams.join('').substring(1);
	return url + joinChar + strParams;
}
// 获取url参数
function get_url_param(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
	var r = window.location.search.substr(1).match(reg); //匹配目标参数
	if (r != null){
		return unescape(r[2]);
	}
	return null; //返回参数值
}
// 绑定需要下拉提示的元素,
// @param1 只接收class参数,被绑定的元素
// @param2 ajax获取数据的地址，如果不传，则视为从当前标签的url属性中获取
function bind_hint(cls, url, callback) {
	var obj = $("." + cls);
	var time = 0;
	obj.keyup(function(e) {
		time = (new Date()).getTime();
		var target = $(this); //当前input对象
		var e = e || event;
		var currKey = e.keyCode || e.which || e.charCode;
		var forbid_arr = [13, 16, 17, 18, 20, 37, 38, 39, 40, 44, 27, 61, 91, 173];

		var value = $(this).val();
		if (typeof url == 'undefined') {
			url = $(this).attr('url');
		}
		setTimeout(function(){
			var ttemp = (new Date()).getTime();
			if((ttemp-time)>=950){

				if (!in_array(currKey, forbid_arr) && value) {
					$.get(url, {
						company_name: value
					}, function(msg) {
						if (msg.status) {
							access_submit = 0;
							show_hint(msg.info, cls, callback, target);
						} else {
							show_hint(null, cls, null, target);
						}
					}, 'json');
				}
			}
		},1000)
	});
}
//类似baidu的下拉提示
function show_hint(data, cls, callback, target) {
	var div_class = cls + '_show_div';
	var input = target;
	var div = input.next("." + div_class);
	if (data == null) {
		div.hide();
		return false;
	}
	if (div.length == 0) {
		hint_event(cls, div_class, callback, target);
		var style_json = {
			width: (parseInt(input.css('width')) + parseInt(input.css('paddingLeft')) + parseInt(input.css('paddingRight'))) + 'px',
			left: input.offset().left + 'px',
			top: (input.offset().top + parseInt(input.css('height')) + parseInt(input.css('paddingTop')) + parseInt(input.css('paddingBottom'))) + 'px'
		};

		var style = '';
		for (var key in style_json) {
			style += key + ':' + style_json[key] + ';';
		}
		style += 'max-height:250px;overflow-y:auto;position:absolute;border:1px solid #cdcdcd;background:white;z-index:99999;border-radius:4px;word-wrap: break-word;';

		var show_div = $("<div class='" + div_class + "' style='" + style + "'></div>");
		input.after(show_div);
		input.next("." + div_class).on('click', 'div.hint_list', function() {
			var input = $(this).parent("." + div_class).prev('.' + cls);
			input.val($.trim($(this).attr('value')));
			$("." + cls + '_hint').val($(this).attr('sid'));
			input.attr('id-val', $.trim($(this).attr('value')));
			access_submit = 1;
			$("." + div_class).hide();
			if(callback){
				callback();
			}
		})
	}
	div.show();
	var content = '';
	for (var key in data) {
		content += '<div class="hint_list" style="cursor:point" sid="' + data[key].id + '" value="' + data[key].value + '">' + data[key].html + '</div>';
	}
	input.next("." + div_class).html(content);
}
//下拉提示的键盘事件
function hint_event(input_class, hint_class, callback, target) {
	target.keyup(function(e) {
		var e = e || event;
		var currKey = e.keyCode || e.which || e.charCode;
		var selected = 'selected';
		var hint_div = $(this).next("." + hint_class);
		var hint_selected = hint_div.find("." + selected);
		if (hint_div.css('display') != 'none') {
			switch (currKey) {
				case 38:
					if (hint_selected.length > 0) {
						var prev = hint_selected.prev();
						hint_selected.removeClass(selected);
						prev.addClass(selected);
					} else {
						var lastchild = hint_div.find(".hint_list:last");
						var parent_top = hint_div.offset().top;
						var self_top = lastchild.offset().top;
						var distance = self_top - parent_top;
						hint_div.animate({
							scrollTop: distance
						}, 200);
						lastchild.addClass(selected);
					}
					return false;
				case 40:
					if (hint_selected.length > 0) {
						var next = hint_selected.next();
						hint_selected.removeClass(selected);
						next.addClass(selected);
					} else {
						hint_div.find(".hint_list:first").addClass(selected);
					}
					return false;
				case 13:
					if (hint_selected.length > 0) {
						access_submit = 1;
						target.val(hint_selected.attr('value'));
						$("." + input_class + '_hint').val(hint_selected.attr('sid'));
						$(this).attr('id-val', hint_selected.attr('value'));
						hint_div.hide();
						if(callback){
							callback();
						}
					}
					return false;
			}
		}
	})
}

;
