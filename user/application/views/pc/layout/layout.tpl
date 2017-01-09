<!DOCTYPE html>
<html>
<head>
  <title>耐耐网</title>
  <meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" />
  <meta name="keywords"/>
  <meta name="description"/>
  <meta charset="utf-8">
  
</head>
<body>
  <div class="login_top">
    <ul class="w1200">
      <ul class="topnav_left">
        <li><a href="{url:index/index@deal}"><img class="shouy" src="{views:images/password/shouy.png}"><span class="inde_txt">耐耐网首页</span></a></li>
        <li class="space">您好，欢迎进入耐耐网</li>
        <li><a href="{url:/login/login}">请登录</a></li>
        <li><a href="{url:/login/register}">欢迎注册</a></li>
      </ul>
      <ul class="topnav_right">
        <!--<li><a href="">会员中心</a><i>|</i></li>
        <li><a href="">我的合同</a><i>|</i></li>
        <li><a href="">消息中心</a><i>|</i></li>
        <li><a href=""><img class="shouy icon" src="{views:images/password/mobile.png}">手机版</a><i>|</i></li>-->
        <li><a href="javascript:;" onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&sid=4006238086&o=new.nainaiwang.com&q=7', '_blank', 'height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');"  border="0" SRC=http://wpa.qq.com/pa?p=1:4006238086:1 alt="点击这里给我发消息">在线客服</a><i>|</i></li>
        <li>交易时间&nbsp;{$deal['start_time']}--{$deal['end_time']}</li>
     </ul>  
    </ul>
</div>            
{content}

<!--公用底部控件 开始-->
<div class="background_img bottom"></div>
    <div class="w1200 secondaryend">
    <p>Copyright&nbsp;&nbsp; © 2000-2016&nbsp;&nbsp;耐耐云商科技有限公司&nbsp;版权所有&nbsp;&nbsp;网站备案/许可证号：沪ICP备15028925号</p>
    <p>服务电话：4006238086&nbsp;地址：上海浦东新区唐镇上丰路977号B座</p>
    <p>
        增值电信业务经营许可证沪B2-20150196
        <!-- <a href="#" target="_blank" style="color: #666666;">沪ICP备15028925号</a>
        <a href="#" target="_blank" style="color: #006aa8;">ICP许可证</a> -->
    </p>
</div>
</body>
</html>