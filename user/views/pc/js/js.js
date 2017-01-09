/*全局函数************************************************************************************************************/
//json操作
$.json={
    "tostring":function(object)
    {
        var string="{";
        for(var x in object)
        {
            string+='"'+x+'":'+object[x];
        }
        string+="}";
        return string;
    },
    "count":function(object)
    {
        var n=0;
        for(var x in object)
        {
            ++n;
        }
        return n;
    }
};

//设置cookie
$.setcookie=function(name,value,life)
{ 
    var cookie=name+"="+escape(value); 
    if(life>0)
    { 
        var date=new Date();
        date.setTime(date.getTime()+life*1000);
        cookie+="; expires="+date.toGMTString();
    } 
    document.cookie=cookie; 
} 

//获取cookie值
$.getcookie=function(name)
{ 
    var cookie=document.cookie;
    var array=cookie.split("; ");
    var n=array.length;
    for(var i=0;i<n;i++)
    {
        var arr=array[i].split("=");
        if(arr[0]==name)
        {
            return arr[1];
        }
    }
    return "";
} 

//删除cookie
$.deletecookie=function(name)
{ 
    var date=new Date();
    date.setTime(date.getTime()-1000);
    document.cookie=name+"=''; expires="+date.toGMTString(); 
}

//判断是否存在空格
$.checkspace=function(string)
{
    return string.match(/\s+/);
};

//判断是否为汉字
$.ischinese=function(string)
{
    return string.match(/[\u4E00-\u9FA5]/g);
};

//判断是否为手机
$.ismobile=function(string)
{
    return string.match(/^1[34578][0-9]{9}$/);
}

//去除空白字符
$.stripspace=function(string)
{
    return string.replace(/\s*/g,"");
};

//格式化日期时间
Date.prototype.pattern=function(fmt)
{
    var o={
        "M+":this.getMonth()+1,//月份
        "d+":this.getDate(),//日
        "h+":this.getHours()%12==0 ? 12 : this.getHours()%12,//小时
        "H+":this.getHours(),//小时
        "m+":this.getMinutes(),//分
        "s+":this.getSeconds(),//秒
        "q+":Math.floor((this.getMonth()+3)/3),//季度
        "S":this.getMilliseconds()//毫秒
    };
    var week={
        "0":"\u65e5",
        "1":"\u4e00",
        "2":"\u4e8c",
        "3":"\u4e09",
        "4":"\u56db",
        "5":"\u4e94",
        "6":"\u516d"
    };
    if(/(y+)/.test(fmt))
    {
        fmt=fmt.replace(RegExp.$1,(this.getFullYear()+"").substr(4-RegExp.$1.length));
    }
    if(/(E+)/.test(fmt))
    {
        fmt=fmt.replace(RegExp.$1,((RegExp.$1.length>1)?(RegExp.$1.length>2?"\u661f\u671f":"\u5468"):"")+week[this.getDay()+""]);
    }
    for(var k in o)
    {
        if(new RegExp("("+k+")").test(fmt))
        {
            fmt=fmt.replace(RegExp.$1,(RegExp.$1.length==1)?(o[k]):(("00"+o[k]).substr((""+o[k]).length)));
        }
    }
    return fmt;
}

/*对象方法************************************************************************************************************/
//上下滚动内容

$.fn.scrollcontent=function(interval)
{

    var $this=$(this);
    var box=$this.closest("div")
    var m=box.height();
    var n=$this.height();
    if(n>=m)
    {
        $this.append($this.html());
        var i=0;
        var timer;
        var start=function()
        {
            timer=setInterval(function()
            {
                box.scrollTop(i);
                i===n ? i=0 : i++;
            },interval);
        }
        var stop=function()
        {
            clearInterval(timer);
        }

        start();

        box.on("mouseover",stop).on("mouseout",start);
    }
};

$(document).ready(function(){
	$(".mid-top .mid-top-title1").click(function(){
		$(this).addClass("mid_cur");
		$(".mid-top-title2").removeClass("mid_cur");
		$(".mid").css({'display':'block'});
		$(".mid2").css({'display':'none'});
	});
	$(".mid-top .mid-top-title2").click(function(){
		$(this).addClass("mid_cur");
		$(".mid-top-title1").removeClass("mid_cur");
		$(".mid").css({'display':'none'});
		$(".mid2").css({'display':'block'});
	});
	$(".mid .line_box .b_btn").click(function(){
		alert("正在帮您找车，请稍候。。。");
	});
});
