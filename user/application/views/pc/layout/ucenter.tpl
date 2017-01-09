<!DOCTYPE html>
<html>
<head>
  <title>个人中心</title>
  <meta name="keywords"/>
  <meta name="description"/>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
  <link href="{views:css/user_index.css}" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="{root:js/jquery/jquery-1.7.2.min.js}"></script>



  <script language="javascript" type="text/javascript" src="{views:js/My97DatePicker/WdatePicker.js}"></script>
  <script type="text/javascript" src="{views:js/regular.js}"></script>
   <script src="{views:js/center.js}" type="text/javascript"></script>
  <link href="{views:css/font-awesome.min.css}" rel="stylesheet" type="text/css" />
   <!-- 头部控制 -->
  <link href="{views:css/topnav20141027.css}" rel="stylesheet" type="text/css">
  <script src="{views:js/topnav20141027.js}" type="text/javascript"></script>
    <!-- 头部控制 -->

    <script type="text/javascript" src="{root:js/form/validform.js}" ></script>
    <script type="text/javascript" src="{root:js/form/formacc.js}" ></script>
    <script type="text/javascript" src="{root:js/layer/layer.js}"></script>
    <script type="text/javascript" src="{root:js/layer/extend/layer.ext.js}"></script>

     <link href="{root:js/form/validate/error.css}" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
    <script type="text/javascript" src="{root:js/area/Area.js}" ></script>

</head>
<body>
<!--    公用头部控件 -->
    <div class="bg_topnav">
    <div class="topnav_width">
        <div class="topnav_left">
            <div class="top_index">
                <img class="index_img" src="{views:images/icon/icon_index.png}"/>
                <a rel="external nofollow" href="{url:/index/index@deal}" target="_blank" >耐耐网首页</a>
            </div>

            <div class="index_user">
            {if:isset($username)}
                <a rel="external nofollow"  href="{url:/ucenterindex/index@user}"  target="_blank" class="">您好，{$username}</a>
                {else:}
                <span>您好，欢迎进入耐耐网</span>
                {/if}
            </div>
            {if:$login==0}
            <div class="login_link" id="toploginbox">
                <a rel="external nofollow" href="{url:/login/login@user}" target="_blank" class="topnav_login">请登录</a>
            </div>
            <div class="topnav_regsiter">
                <a rel="external nofollow" href="{url:/login/register@user}" target="_blank">免费注册</a>
            </div>
            {else:}
            <div class="login_link" id="toploginbox">
                <a rel="external nofollow" href="{url:/login/logOut@user}" target="_blank" class="topnav_login">退出</a>
            </div>
            {/if}
        </div>
        <div class="topnav_right">
            <ul>
                {if:$login!=0}
                 <li>
                   <a href="{url:/ucenterindex/index@user}">会员中心</a><span class="line_l">|<span>
                </li>
                <li>
                    {if:$usertype==1}
                        <a href="{url:/contract/sellerList}">我的合同</a>
                    {else:}
                        <a href="{url:/contract/buyerList}">我的合同</a>
                    {/if}
                    <span class="line_l">|<span>
                </li>
                {/if}
                <li>
                    <a href="{url:/message/usermail@user}">消息中心{if:$mess!=0}<em class="information">{$mess}</em>{/if}</a><span class="line_l">|<span>
                </li>
                <!--<li>
                    <img class="iphon_img" src="{views:images/icon/icon_iphon.png}"/>
                    <a href="">手机版</a><span class="line_l">|<span>
                </li>-->
                <li>
                    <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=4006238086&aty=0&a=0&curl=&ty=1" target="_blank" ><!--onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&sid=279020473&o=new.nainaiwang.com&q=7', '_blank', 'height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');" --> 在线客服</a><span class="line_l">|<span>
                </li>
                <li style="padding-top:2px;">
                    <span>交易时间：{$deal['start_time']}--{$deal['end_time']}</span>
                </li>

            </ul>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!-- 公用头部控件 -->
<div class="header">
		<div class="nav">
            <div class="logo-box zn-l">
                <a href="{url:/index/index@deal}" alt="返回耐耐首页"><img src="{views:/images/icon/nainaiwang.png}"/></a></dd>
            </div>
			<div class="nav-tit">
                <ul class="nav-list">
                    {foreach: items=$topArray item=$topList}
                        <li>
                            <a href="{$topList['url']}" {if: isset($topList['isSelect']) && $topList['isSelect'] == 1} class="cur" {/if}>{$topList['title']}</a>
                        </li>
                    {/foreach}

                </ul>
			</div>
		</div>
	</div>
	<div class="user_body">
		<div class="user_b">
			<!--start左侧导航--> 
            <div class="user_l">
                {if:!empty($leftArray) && count($leftArray)>1}
                <div class="left_navigation">
                    <ul>

                    	{foreach: items=$leftArray item=$leftList key=$k}
                    		{if: $k == 0}
                    		<li class="let_nav_tit"><h3>{$leftList['title']}</h3></li>
                    		{else:}
                            <li class="btn1" id="btn{$k}">
                                <a class="nav-first {if:$action==$leftList['action']}cur{/if}" {if: !empty($leftList['url'])} href="{$leftList['url']}"{/if} >
                                    {$leftList['title']}
                                    <i class="icon-caret-down"></i>
                                </a>
                                {if: !empty($leftList['list'])}
                                    <ul class="zj_zh" >
                                        {foreach: items=$leftList['list'] item=$list}
                                            <li><a  href="{$list['url']}" {if: in_array($action, $list['action'])}class="cur"{/if} >{$list['title']}</a></li>
                                        {/foreach}
                                    </ul>
                                {/if}
                            </li>

                    		{/if}



                    	{/foreach}
                        
                      
                    </ul>
                </div>
                {else:}
                    <div class="wrap_con">
                        <div class="personal_data">
                            <div class="head_portrait">
                                <a href="#">
                                    <img src="{views:/images/icon/head_portrait.jpg}">
                                </a>
                            </div>
                            <div class="per_username">
                                <p class="username_p"><b>您好，{$username}</b></p>
                                <p class="username_p"><!--<img src="{$group['icon']}">-->{$group['group_name']}</p>
                                <p class="username_p">消息提醒：<a href="{url:/message/userMail}"><b class="colaa0707">{$mess}</b></a></p>
                            </div>
                            <div class="per_function">
                                <a href="{url:/ucenter/baseinfo}">基本信息设置</a>
                                <a href="{url:/ucenter/password}">修改密码</a>
                            </div>

                        </div>
                    </div>
                {/if}
            </div>
            <!--end左侧导航-->
            <div id="cont">{content}</div>

				<!--end中间内容-->	
			
		</div>
	</div>
<script type="text/javascript">
    $(function() {
        $('.left_navigation ').find('.cur').parents('.btn1').find('.nav-first').trigger('click');
    })
</script>
</body>
</html>