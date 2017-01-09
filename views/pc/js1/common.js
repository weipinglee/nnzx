//全局变量
var SITE_URL = 'http://' + window.location.host + '/';
var STATIC_URL = SITE_URL;
var IMAGE_URL = SITE_URL;
var FILE_URL = SITE_URL;
var WWW_URL ='http://www.zhaosuliao.com/';
var open_time;

//全局设置ajax请求不缓存
$.ajaxSetup({
    "cache": false
});


var publishingSuccess={
		setings:{},
		fbMask:null,
		fbBomb:null,
		init:function(opt){
			var that=this;
			var html='';
			that.setings=$.extend({},opt);
			html+=  '<div id="fb_mask" style="display: block;"></div>';
			html+=	  '<div id="fb_ok_bomb" style="display: block;">';
			html+=		 '<div class="ok_title">';
			html+=			'采购单<span class="num">'+ that.setings.num +'</span><span>发布成功</span>';
			html+=				'<span class="close_ok"></span>';
			html+=			'</div>'
			html+=			'<div class="ok_content">';
			html+=				'<p class="p1">你已成功发布以下采购信息，请等待审核!审核成功后将免费为您找货。</p>';
			html+=				'<div class="text_content">'+ that.setings.content +'</div>';
			html+=			'</div>';
			html+=		'</div>';
			if($("#fb_mask").length<1 && $("#fb_ok_bomb").length<1){
				that.addHtml(html);
				that.addEvent();
			}else{
				that.toggleShow();
			}
		},
		addEvent:function(){
			var that=this;
			$(document).on('click','.ok_title .close_ok',function(){
				that.toggleHide();
			});
		},
		
		addHtml:function(html){
			var that=this;
			$("body").append(html);
			$("#fb_mask").css({'height':$('body').height()});
			that.fbMask=$("#fb_mask");
			that.fbBomb=$("#fb_ok_bomb");
			var h=($(window).height()-that.setings.height)/2 + $(window).scrollTop();
			that.fbBomb.css({'width': that.setings.width,'height':that.setings.height,'marginTop':0,'top' : h });
		},
		toggleShow:function(){
			var that=this;
			var h=($(window).height()-that.setings.height)/2 + $(window).scrollTop();
			that.fbMask.show();
			that.fbBomb.show().css({'top':h});
			that.fbBomb.find('.num').html(that.setings.num);
			that.fbBomb.find('.text_content').html(that.setings.content);
			
		},
		toggleHide:function(){
			this.fbMask.hide();
			this.fbBomb.hide();
		}
}
    

//显示登录对话框
function show_dialog_login() {
    var referer = escape(location.href);
    art.dialog({
        id: 'login_dialog',
        iframe: WWW_URL + "/user/login/mini?referer=" + referer,
        title: '会员登录',
        width: '380',
        height: '310',
        lock: true
    });
}


//提示开闭市消息
function tip_open_time() {
    if (open_time == null) {
        $.ajax({
            type: "get",
            url: SITE_URL + 'product/isOpenTime',
            async: false,
            success: function(rs) {
                if (rs.status == 1) {
                    open_time = rs.data;
                } else {
                    open_time = -1;
                }
            }
        });
        //open_time=$.getcookie('is_open_time');
    }
    if (open_time <= 0) {
        return confirm('找塑料网交易时间为工作日9：00~17：30，非工作时间发布的委托采购会延迟处理，给您带来不便，请见谅。');
    }
    return true;

}

//倒计时
var countdown = {
    second: 60,
    timer: null,
    source: null,
    target: null,
    init: function(source) {
        var content = '<div class="countdown"><span>' + countdown.second + '</span>秒后重新获取</div>';
        countdown.source = source;
        countdown.source.hide().after(content);
        countdown.target = $(".countdown");
        countdown.timer = setInterval(countdown.play, 1000);
    },
    play: function() {
        countdown.second--;
        countdown.second > 0 ? countdown.target.find("span").text(countdown.second) : countdown.stop();
    },
    stop: function() {
        clearInterval(countdown.timer);
        countdown.second = 60;
        countdown.source.show().next(".countdown").remove();
    }
};

//自动变换背景框宽度
var auto_bg = {
    "max_width": 1920,
    "site_width": 1200,
    "o": null,
    "set": function() {
        var window_width = $(window).width();
        var w = (auto_bg.max_width - window_width) / 2;
        if (w > 360) {
            auto_bg.o.width(auto_bg.site_width);
        } else {
            auto_bg.o.css("width", "100%");
        }
    },
    "event": function() {
        window.onresize = auto_bg.set;
    },
    "init": function(o) {
        auto_bg.o = o;
        auto_bg.set();
        auto_bg.event();
    }
};

//显示消息
$.showmessage = function(msg, modal, timeout, html) {
    var id = 'windowmessage';

    var close = function() {
        $("#windowmask").remove();
        $("#" + id).remove();
    };

    if ($("#" + id).length) {
        close();
    }

    var tid = 'windowmessagetitle';
    var cid = 'windowmessagecontent';
    var xid = 'windowmessageclose';

    modal = modal ? modal : 0;
    timeout = timeout ? timeout : 0;

    $("body").append('<div id="windowmask"></div>');
    if (modal) {
        $("#windowmask").attr("class", "windowmask").css("width", $(document).width()).css("height", $(document).height());
    }
    $("body").append('<div id="' + id + '"></div>');
    $("#" + id).attr("class", "msgbox").append('<div id="' + tid + '"></div>').append('<div id="' + cid + '"></div>');
    $("#" + tid).attr("class", "title");
    $("#" + cid).attr("class", "content");
    $("#" + tid).html('<div class="l">' + '提示' + '</div><div class="r"><a href="javascript:void(0);" class="close" id="' + xid + '">&nbsp;</a></div>');
    $("#" + id).hide();

    if (timeout) {
        setTimeout(function() {
            close();
        }, timeout);
    }

    html ? $("#" + cid).html(msg) : $("#" + cid).html(msg);
    $("#" + id).css("margin-left", "-" + parseInt($("#" + id).css("width")) / 2 + "px").css("margin-top", "-" + parseInt($("#" + id).css("height")) / 2 + "px");

    $("#" + xid + ",[act='close']").click(function() {
        close();
    });

    $("#" + id).show();
};

$(function() {
    //导航栏-委托找货
    $("#purchase_goods,.purchase_goods").on("click", function() {
    var that=$(this);
        if (!tip_open_time()) {
            return false;
        }

        $.getJSON(SITE_URL + 'common/check_login', function(rs) {
        	var str=that.attr('href');
        	console.log(str)
            if (rs.status == 1) {
            
                location.href = str;
            } else {
               // show_dialog_login();
                location.href = str;
            }
        });

    });

    function setDefaultSearchText() {
        var index = $(".search .sear_title").find(".on").index();
        var emptyStr = index == 1 ? "请输入品种/牌号/厂家进行搜索" : "请输入品种/牌号/厂家/公司进行搜索";
        if ($.trim($(this).val()) == "") {
            $(this).val(emptyStr).css({
                "color": "#999"
            });
        }
    }

    //搜索1
    $(".sear_cont").find(".sear_inp").on("focus", function() {
        var emptyStr0 = "请输入品种/牌号/厂家/公司进行搜索";
        var emptyStr1 = "请输入品种/牌号/厂家进行搜索";
        if ($(this).val() == emptyStr0 || $(this).val() == emptyStr1) {
            $(this).val("").css({
                "color": "#000"
            });
        }
    }).on("blur", function() {
        var index = $(".search .sear_title").find(".on").index();
        var emptyStr = index == 1 ? "请输入品种/牌号/厂家进行搜索" : "请输入品种/牌号/厂家/公司进行搜索";
        if ($.trim($(this).val()) == "") {
            $(this).val(emptyStr).css({
                "color": "#999"
            });
        }
    });
    
    $(".sear_cont").find(".sear_sub").on("click", function() {
        var emptyStr0 = "请输入品种/牌号/厂家/公司进行搜索";
        var emptyStr1 = "请输入品种/牌号/厂家进行搜索";
        var word = $.trim($(".sear_cont").find("input[name='keyword']").val());
        if (word == emptyStr0 || word == emptyStr1 || word == '') {
            alert("请输入搜索条件");
            $("input[name='keyword']").focus();
            return false;
        } else {
            var index = $(".search .sear_title").find(".on").index();
            if (index == 1) {
                location.href = WWW_URL + "wuxingbiao/search?word=" + encodeURIComponent(word);
            } else {
                location.href = WWW_URL + "product/list?keyword=" + encodeURIComponent(word);
            }
        }
    });
    
    $(".sear_cont").on("keydown", "form", function(e) {
        if (e.keyCode == "13") {
            $(".sear_cont").find(".sear_sub").trigger("click");
        }
    });
    
    /**  搜索物性表和搜现货效果***/
    $(".sear_title span").click(function() {
        $(".sear_title span").removeClass("on");
        $(this).addClass("on");

        var index = $(".search .sear_title").find(".on").index();
        var emptyStr0 = "请输入品种/牌号/厂家/公司进行搜索";
        var emptyStr1 = "请输入品种/牌号/厂家进行搜索";
        var emptyStr = index == 1 ? emptyStr1 : emptyStr0;
        var input = $(".sear_cont").find(".sear_inp");
        if ($.trim(input.val()) == "" || $.trim(input.val()) == emptyStr0 || $.trim(input.val()) == emptyStr1) {
            input.val(emptyStr).css({
                "color": "#999"
            });
        }
    });
    


    //免费发布采购信息
    $("#purchase_submit").on("click", function() {
        if (!tip_open_time()) {
            return false;
        }

        var content = $.trim($("#purchase_content").val());
        if (!content) {
            alert("请输入你要委托的信息");
            return false;
        } else {
            $.getJSON(SITE_URL + 'common/check_login', function(rs) {
                if (rs.status == 1 && rs.data.is_checked==1 && rs.data.name!='') {
                    $.post(SITE_URL + '/purchaseView/save', {
                        "keyword": content
                    }, function(rs) {
                        if (rs.status < 0) {
                            alert(rs.msg);
                        } else {
                          //  $(".Dwt").show();
                           // $(".Dwt").find('#purchase_sn').html(rs.data[0]);
                         //   $(".Dwt").find('.p2#issue_content').html(rs.data[1]);
                        	publishingSuccess.init({'width':500,'height':275,'num':rs.data[0],'content':rs.data[1]});
                        }
                    });
                } else {
                	location.href=SITE_URL+"product/entrust_add?content="+content;
                }
            });
        }
    });
    
    $(".Dwt").find("#close_purchase").bind("click", function() {
        $(".Dwt").hide();
    });

    //客服qq
    // $(".kf_box .t").find("a").on("click", function() {
    //     if ($(this).hasClass("s")) {
    //         $(".kf_box").animate({
    //             marginLeft: "0px"
    //         }, 500);
    //         $(this).removeClass("s");
    //     } else {
    //         $(".kf_box").animate({
    //             marginLeft: "-135px"
    //         }, 500);
    //         $(this).addClass("s");
    //     }
    // });

    //客服qq2015-12-30
    $(".kf li").mouseover(function(){
        $(this).children(".on").show();
        $(this).children(".other").show();
    }).mouseout(function(){
        $(this).children(".on").hide();
        $(this).children(".other").hide();
    });
    $("#up_top").click(function(){
        $('body,html').animate({scrollTop:0},600);  
    });

    /**导航nav移入效果**/
    $(".new_nav_content a").each(function() {
        if (typeof $(this).attr('class') == 'undefined') {
            $(this).mouseover(function() {
                $(this).css('background', '#3088D2');
            }).mouseout(function() {
                $(this).css('background', '');
            });
        }
    });

    //价格走势
    $(".trend_nav").mouseover(function() {
        $(".trend_other").show();
    });
    $(".trend_nav").mouseout(function() {
        $(".trend_other").hide();
    });

});

//添加Cookie
function addCookie(name, value, options) {
    if (arguments.length > 1 && name != null) {
        if (options == null) {
            options = {};
        }
        if (value == null) {
            options.expires = -1;
        }
        if (typeof options.expires == "number") {
            var time = options.expires;
            var expires = options.expires = new Date();
            expires.setTime(expires.getTime() + time * 1000);
        }
        document.cookie = encodeURIComponent(String(name)) + "=" + encodeURIComponent(String(value)) + (options.expires ? "; expires=" + options.expires.toUTCString() : "") + (options.path ? "; path=" + options.path : "") + (options.domain ? "; domain=" + options.domain : ""), (options.secure ? "; secure" : "");
    }
}

// 获取Cookie
function getCookie(name) {
    if (name != null) {
        var value = new RegExp("(?:^|; )" + encodeURIComponent(String(name)) + "=([^;]*)").exec(document.cookie);
        return value ? decodeURIComponent(value[1]) : null;
    }
}

// 移除Cookie
function removeCookie(name, options) {
    addCookie(name, null, options);
}

(function($) {

    // 令牌	
    $(document).ajaxSend(function(event, request, settings) {
        if (!settings.crossDomain && settings.type != null && settings.type.toLowerCase() == "post") {
            var token = getCookie("token");
            if (token != null) {
                request.setRequestHeader("token", token);
            }
        }
    });

    $(document).ajaxComplete(function(event, request, settings) {
        if (typeof(request.getResponseHeader) !== "undefined") {
            var loginStatus = request.getResponseHeader("loginStatus");
            var tokenStatus = request.getResponseHeader("tokenStatus");
            if (loginStatus == "accessDenied") {
                location.href = SITE_URL + "/user/login";
            } else if (tokenStatus == "accessDenied") {
                var token = getCookie("token");
                if (token != null) {
                    $.extend(settings, {
                        global: false,
                        headers: {
                            token: token
                        }
                    });
                    $.ajax(settings);
                }
            }
        }
    });

})(jQuery);

// 令牌
$().ready(function() {

    $("form").submit(function() {
        var $this = $(this);
        if ($this.attr("method") != null && $this.attr("method").toLowerCase() == "post" && $this.find("input[name='token']").size() == 0) {
            var token = getCookie("token");
            if (token != null) {
                $this.append('<input type="hidden" name="token" value="' + token + '" \/>');
            }
        }
    });

    $(".deleteConfirm").click(function() {
        var _href = $(this).attr("_href");
        top.$.jBox.confirm("确定是否确定删除？", "提示", function(v, h, f) {
            if (v == true) {
                //$(this).attr("href",_href);
                loading('正在提交，请稍等...');
                window.location.href = _href;
            }
            return true;
        }, {
            buttons: {
                '确定': true,
                '取消': false
            }
        });
    });

    $(".loading").click(function() {
        var _href = $(this).attr("_href");
        loading('正在提交，请稍等...');
        window.location.href = _href;
    });




    $(".area_wrapper").areaPop({
        hiddens: {
            city: "cityId",
            province: "provinceId"
        },
        url: {
            city: SITE_URL + "/admin/common/region", //获取城市 parentId
            province: SITE_URL + "/resources/fore/plugin/jquery-areapop/jquery-areapop-province.json" //获取省份
        }
    });

    //我要供货按钮
    $(".supply_button").on("click", function() {
    	var purchase_id=$(this).data("id");
    	var that=this;

        if(!tip_open_time())
        {
            return false;
        }
        $.get(SITE_URL+'common/check_login',function(rs)
        {
            if(rs.status==0)
            {
                show_dialog_login();
            }
            else
            {
            	$.get(SITE_URL+'purchaseView/supply_check',{"purchase_id":purchase_id},function(rs)
                {
                    if(rs.status<0)
                    {
                        alert(rs.msg);
                    }
                    else
                    {   
                    	var mid=rs.data.mid;
                    	var name=rs.data.name;
                    	var info =rs.data.pur_name+' '+rs.data.pur_material+' '+rs.data.pur_manufacturer+' '+rs.data.pur_onsaleNumber+'吨 '+rs.data.pur_price;
 				        if(rs.data.pur_priceto==''&&rs.data.pur_priceto>0&&rs.data.pur_price!=rs.data.pur_priceto){
 				        	info +='~'+rs.data.pur_priceto;
 				        }
 				        info +=rs.data.pur_tradeCoin==2?'美元':'元';
 				        info	+=' '+rs.data.pur_city+' '+rs.data.pur_market
				        var str = '';
				        str += '<form action="'+SITE_URL+'/purchaseView/supplySave" id="form_supply" method="post">';
				        str += '<input type="hidden" id="midJS" name="mid" value="'+mid+'"/>';
				        str += '<input type="hidden" id="purchase_idJS" name="purchase_id" value="'+purchase_id+'"/>';
				        str += '<p class="supply_p1">采购内容： <span>'+ info +'</span></p>';
				        str += '<p class="supply_p2">请在下方填写您的真实报价（价格必填），并对您的货物描述清楚。</p>';
				        str += '<p class="supply_p3">例如：ABS HP171 惠州中海油乐金 5吨 13450元 东莞市 东莞塑胶交易市场</p>';
				        str += '<p class="supply_p4">ABS AG15E1 台湾台化 5吨 13800 东莞塑胶交易市场</p>';
				        if(name==''){
					        str += '<div class="supply_input">';
					        str += '	<div class="supply_line_input">';
					        str += '		<span class="supply_input_text">公司名称：</span>';
					        str += '		<input type="text" class="supply_input_inp" name="name" id="companyNameJs"/>';
					        str += '		<span class="supply_input_text">企业类型：</span>';
					        str += '		<select class="supply_select" name="type">';
					        str += '			<option value="-1">--请选择--</option>';
					        str += '			<option value="上游厂家">上游厂家</option>';
					        str += '			<option value="贸易商">贸易商</option>';
					        str += '			<option value="终端">终端</option>';
					        str += '		</select>';
					        str += '		<span class="supply_input_text">地区：</span>';
					        str += '		<div class="area_wrapper">';
					        str += '			<div class="rovince_parent parent_div province_div" data-target="province">';
					        str += '				<input type="text" readonly  name="province" class="areapop_input"/>';
					        str += '				<input type="hidden"  name="provinceId" />';
					        str += '			</div>';
					        str += '			<div class="city_parent parent_div city_div" data-target="city">';
					        str += '				<input type="text" readonly name="city" class="areapop_input" />';
					        str += '				<input type="hidden"  name="cityId" />';
					        str += '			</div>';
					        str += '		</div>';
					        str += '	</div>';
					        str += '	<div class="supply_line_input">';
					        str += '		<span class="supply_input_text">主营品种：</span>';
					        str += '		<input type="text" class="supply_input_inp " name="mainProducts"/>';
					        str += '		<span class="supply_input_text">联系人：</span>';
					        str += '		<input type="text" class="supply_input_inp "  name="linkman"/>';
					        str += '	</div>';
					        str += '</div>';
				        }
				        str += '<div class="supply_textarea_div">';
				        str += '	<div class="textarea_left">货物描述：</div>';
				        str += '	<div class="textarea_right">';
				        str += '		<textarea class="textarea_content" name="content"></textarea>';
				        str += '	</div>';
				        str += '</div>';
				        str += '<p class="supply_tips"><span>不合理报价会被系统自动屏蔽</span></p>';
				        str += '<input class="supply_submit" type="button" value="我要供货"/>';
				        str += '</form>';
				        if(name==''){
				        	supplyCommodity.supplyBomb(that,750,535, str ,info,mid,purchase_id);
				        }else{	
				        	supplyCommodity.supplyBomb(that,750,450, str,info,mid,purchase_id);
				        	
				        }
                    }
                });
            }
        });

    });


});

/*我要供货弹框*/
var supplyCommodity = {
    arr: [],
    html: '',
    winW: $(window).width(),
    winH: 0,
    myMask: null,
    mysupply: null,
    supplyBomb: function(obj,w,h,str,info,mid,purchase_id) {
        if ($(obj).attr('data-flag') === undefined && this.myMask == null && this.mysupply==null) {
        	this.winH= $("body").height();
            $(obj).attr('data-flag', 'yes');
            this.addHtml(w,h,str,info,mid,purchase_id);
            this.addEvent();
        } else {
            this.toggleShow(h,info,mid,purchase_id);
        }
       
    },
    addEvent: function() {
        var that = this;
        $(document)
        .on('click', '.close_supply', function() {
                that.toggleHide();
            })
        .on('click', '.supply_submit', function() {
              var json= $("#form_supply").serialize();
             if($(".supply_input").length>0){
            	 if($.trim($('#companyNameJs').val())==''){
               	  alert('请输入公司名称');
               	  return ;
                 }else if($.trim($('.supply_select').val())=='-1'){
               	  alert('请选择企业类型');
               	  return ;
                 }else if($.trim($('input[name="province"]').val()) ==''){
           	 		alert('请选择省份');
       	 			return ;
                 }else if($.trim($('input[name="city"]').val())==''){
               	  alert('请选择城市');
     	 			  return ;
                 }else if($.trim($('input[name="mainProducts"]').val())==''){
               	  alert('请输入主营品种');
     	 			  return ;
                 }else if($.trim($('input[name="linkman"]').val())==''){
               	  alert('请输入联系人');
     	 			  return ;
                 }else if($.trim($('.textarea_content').val())==''){
            		 alert('请输入供货内容');
            		 return ;
            	 }else{
            		 $.post(SITE_URL+'purchaseView/supplySave' + "?v=" + $.now(),json,function(data){
                         alert(data.msg);
                         that.toggleHide();
               	  	}); 
            	 }
             }else{
            	 if($.trim($(".textarea_content").val())==''){
            		 alert('请输入供货内容')
            	 }else{
            		 $.post(SITE_URL+'purchaseView/supplySave' + "?v=" + $.now(),json,function(data){
                         alert(data.msg);
                         that.toggleHide();
               	  	});
            	 }
             }

            })
    },
    addHtml: function(w,h,str,info,mid,purchase_id) {
        var that = this;
        that.arr.push([
            '<div id="mysupply" style="display:block;">',
            '<div class="supply_title">',
            '<span class="supply_title_text">我要供货</span>',
            '<a class="close_supply" href="javascript:void(0)"></a>',
            '</div>',
            '<div class="supply_content">',
            '</div>',
            '</div>'
        ].join(""));
      //  alert(that.winH)
        that.html = that.arr.join("");
        $("body").append('<div id="myMask" style="width:' + that.winW + 'px;height:' + that.winH + 'px;" ></div>');
        $("body").append(that.html);
        $(".supply_content").append(str);
        that.myMask = $("#myMask");
        that.mysupply = $("#mysupply");
        var scrollT=$(window).scrollTop();
        that.mysupply.css({'width':w,'height':h,'left':(that.winW-w)/2,'top':($(window).height()-h)/2+scrollT});
        that.mysupply.find(".supply_p1 span").html(info);
     
        $(".area_wrapper").areaPop({
            hiddens: {
                city: "cityId",
                province: "provinceId"
            },
            url: {
                city: SITE_URL + "/admin/common/region", //获取城市 parentId
                province: SITE_URL + "/resources/fore/plugin/jquery-areapop/jquery-areapop-province.json" //获取省份
            }
        });
        
        
    },
    toggleShow: function(h,info,mid,purchase_id) {
        var that = this;
        var scrollT=$(window).scrollTop();
        that.mysupply.css({'top':($(window).height()-h)/2+scrollT});
        that.myMask.show();
        that.mysupply.show();
        that.mysupply.find(".supply_p1 span").html(info);
        that.mysupply.find(".textarea_content").val('');
        that.mysupply.find("#midJS").val(mid);
        that.mysupply.find("#purchase_idJS").val(purchase_id);
    },
    toggleHide: function() {
        var that = this;
        that.myMask.hide();
        that.mysupply.hide();
    }
}



//显示加载框
function loading(mess) {
    top.$.jBox.tip.mess = null;
    top.$.jBox.tip(mess, 'loading', {
        opacity: 0
    });
}

if ($.validator) {
    //设置validate的默认值
    $.validator.setDefaults({
        submitHandler: function(form) {
            loading('正在提交，请稍等...');
            form.submit();
        }
    });

    $.extend($.validator.messages, {
        required: "必填",
        email: "E-mail格式错误",
        url: "网址格式错误",
        date: "日期格式错误",
        dateISO: "日期格式错误",
        pointcard: "信用卡格式错误",
        number: "只允许输入数字",
        digits: "只允许输入零或正整数",
        minlength: "长度不允许小于{0}",
        maxlength: $.validator.format("长度不允许大于{0}"),
        rangelength: $.validator.format("长度必须在{0}-{1}之间"),
        min: $.validator.format("不允许小于{0}"),
        max: $.validator.format("不允许大于{0}"),
        range: $.validator.format("必须在{0}-{1}之间"),
        accept: "输入后缀错误",
        equalTo: "两次输入不一致",
        remote: "输入错误",
        integer: "只允许输入整数",
        positive: "只允许输入正数",
        negative: "只允许输入负数",
        decimal: "数值超出了允许范围",
        pattern: "格式错误",
        extension: "文件格式错误"
    });
}