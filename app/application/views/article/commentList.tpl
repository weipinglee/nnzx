
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no minimal-ui"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="white">
<meta name="baidu-tc-cerfication" content="e08afafaa2ad8ee624b1d14e86f076b0" />
<meta name="apple-itunes-app" content="app-id=869266629, app-argument=mlj://" />

<link href="{views:css/m1102.css}" rel="stylesheet" />
<script src="{views:js/jQuery/jquery-1.8.0.min.js}" type="text/javascript" language="javascript"></script>
<script src="{views:js/zepto.min.js}" type="text/javascript" language="javascript"></script>
<script src="{views:js/main.js}" type="text/javascript" language="javascript"></script>
<style type="text/css">
    .settings .userinfo img.little-face{border-radius: 50%;width: 30px;height: 30px;}
    .bottom-nav .textview{width: 80%;margin: 2% 0;text-align: left;line-height: 30px;}
    .settings .userinfo .info-title{margin-left: 40px; }
    .settings .userinfo .info-title .nick{font-size: 12px;margin: 0;font-weight: normal;line-height: 15px;}
    .settings .userinfo .info-title .nick.time{font-size: 10px;color: #aaa;}
    .settings .userinfo{padding-bottom:5px; }
    .bottom-nav .send{background: #c81623;border-radius: 20px;width: 15%;color: #fff;height: 33px;border: 0;margin: 2% 0;}
    .settings .userinfo .location{color: #333;}
</style>


<title>评论页</title>
</head>
<body>
<div id="main" class="wrapper" FullScreen="false">
<section id="staticpage" class="page current" style="display:block;">
    <div class="top-nav-box">
        <div class="top-nav">
            <a class="tnav-btn tnav-left tnav-back" href="#" onClick="backPage();return false;"></a>
            <span class="nav-title">评论</span>
        </div>
    </div>
    <div class="main-body">
        <div class="body-scroll">
            
            <div class="settings-space"></div>
            <div class="settings">
                <div class="item normal">
                    <span class="title">全部评论</span>
                </div>
            </div>
            <div class="settings">
                <div class="item userinfo">
                    <img class="little-face" src="http://img.meilijia.com/user_pics/f625d3ab4933d7360ca0c64d9123244a_150.jpg" />
                    <div class="info-title">
                        <p class="nick">用户名</p>
                        <p class="nick time">05-07&nbsp;23楼</p>
                        <p class="location">
                            我用6S站阿达果不其然在接下来不到两秒钟时间之内布鲁斯就已经彻底账款了房源一百五十公里之内的一起
                        </p>
                        <div class="reply-area">
                            <p>
                                <span>BLackRook：</span>折评论有毒
                            </p>
                            <p>
                                <span>BLackRook</span>回复<span>云天之家：</span>P5天下第一！！
                            </p>
                        </div>
                        <p class="reply-view">
                            <a class="reply">
                                <img src="{views:images/reply.png}" />
                                <span>回复</span>
                            </a>
                        </p>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="item userinfo">
                    <img class="little-face" src="http://img.meilijia.com/user_pics/f625d3ab4933d7360ca0c64d9123244a_150.jpg" />
                    <div class="info-title">
                        <p class="nick">用户名</p>
                        <p class="nick time">05-07&nbsp;23楼</p>
                        <p class="location">
                            我用6S站阿达果不其然在接下来不到两秒钟时间之内布鲁斯就已经彻底账款了房源一百五十公里之内的一起
                        </p>
                        <div class="reply-area">
                            <p>
                                <span>BLackRook：</span>折评论有毒
                            </p>
                        </div>
                        <p class="reply-view">
                            <a class="reply">
                                <img src="{views:images/reply.png}" />
                                <span>回复</span>
                            </a>
                        </p>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="item userinfo">
                    <img class="little-face" src="http://img.meilijia.com/user_pics/f625d3ab4933d7360ca0c64d9123244a_150.jpg" />
                    <div class="info-title">
                        <p class="nick">用户名</p>
                        <p class="nick time">05-07&nbsp;23楼</p>
                        <p class="location">
                            我用6S站阿达果不其
                        </p>
                        <div class="reply-area">
                            <p>
                                <span>BLackRook：</span>折评论有毒
                            </p>
                        </div>
                        <p class="reply-view">
                            <a class="reply">
                                <img src="{views:images/reply.png}" />
                                <span>回复</span>
                            </a>
                        </p>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:block;width:100%;height:66px;"></div>

<script type="text/javascript">
 
    //基本函数*2
    var addHandler = window.addEventListener?
    function(elem,event,handler){elem.addEventListener(event,handler);}:
    function(elem,event,handler){elem.attachEvent("on"+event,handler);};
 
    var $ = function(id){return document.getElementById(id);}
 
         
    function autoTextArea(elemid){
        //新建一个textarea用户计算高度
        if(!$("_textareacopy")){
            var t = document.createElement("textarea");
            t.id="_textareacopy";
            t.style.position="absolute";
            t.style.left="-9999px";
            document.body.appendChild(t);
        }
        function change(){
            $("_textareacopy").value= $(elemid).value;
            $(elemid).style.height= $("_textareacopy").scrollHeight+$("_textareacopy").style.height+"px";
        }
        addHandler($("target"),"propertychange",change);//for IE
        addHandler($("target"),"input",change);// for !IE
        $(elemid).style.overflow="hidden";//一处隐藏，必须的。
        $(elemid).style.resize="none";//去掉textarea能拖拽放大/缩小高度/宽度功能
    }
 
    addHandler(window,"load",function(){
        autoTextArea("target");
    });

                   
</script>

    <div class="bottom-nav-box">
        <div class="bottom-nav">
            <textarea placeholder="回复楼主" class="textview" id="target" rows="" cols=""></textarea>
            <input type="button" value="发送" class="send">
        </div>
    </div>


</section>       

</body>
</html>