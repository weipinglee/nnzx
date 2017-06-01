
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no minimal-ui"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="white">
<meta name="baidu-tc-cerfication" content="e08afafaa2ad8ee624b1d14e86f076b0" />
<link rel="apple-touch-icon-precomposed" href=http://wap.baidu.com/static/img/webapp/img/icon_114.png/>
<meta name="apple-itunes-app" content="app-id=869266629, app-argument=mlj://" />
<link href="{views:css/m1102.css}" rel="stylesheet" />
<script src="{views:js/jQuery/jquery-1.8.0.min.js}" type="text/javascript" language="javascript"></script>
<script src="{views:js/zepto.min.js}" type="text/javascript" language="javascript"></script>
<script src="{views:js/main.js}" type="text/javascript" language="javascript"></script>

<title>APP详情页</title>
</head>
<body>
<div id="main" class="wrapper" FullScreen="false">
<section id="staticpage" class="page current" style="display:block;">
    <!-- <div class="top-nav-box">
        <div class="top-nav">
            <a class="tnav-btn tnav-left tnav-back" href="#" onClick="backPage();return false;"></a>
            <span class="nav-title">耐耐资讯</span>
        </div>
    </div> -->
    <div class="main-body">
        <div class="body-scroll">
            <div class="settings">
                <div class="item userinfo">
                        <p class="nick">{$info['name']}</p>
                        <p class="location"><span class="author">{$info['author']}</span><span class="time">{$info['create_time']}</span></p>

                </div>
            </div>
            <div class="settings">
                <div class="item userinfo">
                    <!-- <img class="face" src="{$info['cover'][0]}" /> -->
                    <div class="info">
                        {$info['content']}
                    </div>
                </div>
            </div>
            <div class="settings-space"></div>
            <div class="settings">
                <div class="item normal">
                    <span class="title">相关推荐</span>
                </div>
            </div>
            <div class="settings">
                {foreach:items=$info['comArcList']}
                <a href="{url:/article/arcInfo}/id/{$item['id']}">
                    <div class="item userinfo">
                        <img class="little-face" src="{$item['cover'][0]}" />
                        <div class="info-title">
                            <p class="nick">{$item['name']}</p>
                            <p class="location"><span class="author">{$item['author']}</span><span class="time">{$item['create_time']}</span></p>
                        </div>
                    </div>
                </a>
                {/foreach}
            </div>
               <div style="display:block;width:100%;height:66px;"></div>
    <div class="bottom-nav-box">
        <div class="bottom-nav">
            <a href class="textview">
                <img src="{views:images/pen.png}">
                <span>想说点什么？</span>
            </a>
            <a href="{url:/article/arcInfo}/id/{$item['id']}" class="talkview">
                <img src="{views:images/talk.png}" />
                <span>评论</span><!-- 没有评论时显示评论有评论时显示数量 -->
            </a>
            <div class="collect" id = "colection" onClick ="coll()">
                <img src="{views:images/savebtnno.png}" id="collect" value="collected"/>
                <span>收藏</span>
            </div>
            <div class="shareview" id="share">
                <img src="{views:images/share.png}" />
                <span>分享</span>
            </div>
        </div>
    </div>
    <section class="screenW">
        <div class="subW">
            <div class="info">
                <div class="shareBox">
                    <h2>请选择您的分享方式：</h2>
                    <div class="bdsharebuttonbox">
                        <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a>
                        <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a>
                        <a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友">QQ</a>
                        <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a>
                        <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a>
                    </div>
                    <div class="bdsharebuttonbox">
                        <a href="#" onclick="return false;" class="popup_more" data-cmd="more"></a>
                    </div>
                </div>
            </div>
            <div class="close">关闭</div>
        </div>
    </section>

</body>
</html>