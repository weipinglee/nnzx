

<!-- 常见问题标题 -->
<div class="line_baifn">
    <div class="comm_problem_top">
        <div class="com_por_tit">
            <i class="icon-home" style="font-size:14px;">&nbsp;</i>
            <span><a href="help.html"><b>帮助中心</b></a></span>
            <span>></span>
            <span><a href="common_problems.html"><b>{$helpCatInfo['name']}</b></a></span>
            <span>></span>
            <span><b>{$helpInfo['name']}</b></span>
        </div>
        <div class="form_right">
           <!--  <form>
                <input class="com_pro_search" type="text" placeholder="输入问题关键词"/>
                <input class="com_probutton" type="button"/>
            </form> -->
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- 常见问题标题end -->
<!------------------导航 开始-------------------->
<form method="post" action="" id="form1">
    <div class="aspNetHidden">
        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="b7kHdN58Jsi2cPaAmmpEqXjSD5M7lilMmnUNdKzTkgYwpBrDsYEml4gvo/iOj8sf">
    </div>
</form>


<input type="hidden" id="UserID">
<!--主要内容 开始-->
<div id="mainContent">
    <div class="page_width">
        <!-- 常见问题start -->
        <div class="comm_problem">
            <div class="dh_left">

                <div class="big_tit"><img class="" src="{views:images/icon/issue.png}"><b>帮助中心</b></div>
                <ul class="ul1">
                    {foreach: items=$helpList}
                    <li class="ul1_li">
                        <a href="javascript:;" class="tow_tit"><b class="first-title">{$item['name']}</b><i class="icon-caret-down"></i></a>

                        <ul class="ul2">
                            {foreach:items=$item['data'] item=$v}
                            <li><a {if:$helpInfo['name']==$v['name']} class="a_cur" {/if}href="{url:/help/help}?id={$v['id']}&cat_id={$item['cat_id']}">{$v['name']}</a></li>
                            {/foreach}
                        </ul>
                    </li>
                    {/foreach}
                </ul>
            </div>
            <div class="pro_con_right">
                <div class="right_conten">
                    <div class="con_time">
                        <h1 style="padding: 13px 18px;font-size: 16px;border-bottom: 2px solid #d61515;position: absolute;height: 20px;">{$helpInfo['name']}</h1>
                    </div>
                    <div class="text_word">
                            {$helpInfo['content']}

                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <!-- 常见问题end -->








