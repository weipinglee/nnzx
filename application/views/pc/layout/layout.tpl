<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>资讯中心</title>
	<meta name="keywords" content="耐耐资讯" />

    <script src="{views:js/jquery-1.9.1.min.js}" type="text/javascript" language="javascript"></script>
    <script src="{views:js/new-slide.js}" type="text/javascript" language="javascript"></script>
    <script src="{views:js/style.js}" type="text/javascript" language="javascript"></script>
    <script src="{views:js/new-nav.js}" type="text/javascript" language="javascript"></script>
    <link rel="stylesheet" type="text/css" href="{views:css/new-style.css}">
</head>
<body>



<body>
<div class="header">
    <div class="content">
        <div class="logo"></div>
        <ul class="nav" >
            <li><a href='{url:/index/index}' {if:$type_id == 0}class='on'{/if}>首页</a></li>
            <li id="industry"><a href='{url:/hangye/index}/type/{$typelist[0]['id']}' {if:$type_id ==$typelist[0]['id']}class="on"{/if}>行业</a></li>

            <li><a href="{url:/shuju/index}/type/{$typelist[1]['id']}" {if:$type_id == $typelist[1]['id']}class="on"{/if}>数据</a></li>
            <li><a href='{url:/guandian/index}/type/{$typelist[2]['id']}' {if:$type_id == $typelist[2]['id']}class="on"{/if}>观点</a></li>
			 <li><a href='https://www.nainaiwang.com' ></a></li>
        </ul>
        <form class="search">
            <input type="text" placeholder="请输入关键字查询" class="text"><input type="button" value="搜索" class="button">
        </form>
    </div>
    <script type="text/javascript">
        $(function(){
            $('.search .button').click(function(){
                var k = $(this).siblings('input').val();
                if(k != '' && k != '请输入关键字查询')
                window.location.href = "{url:/search/index}/keyword/"+k;
            });
            $('.search .text').keydown(function(e){
                if(e.keyCode == 13){
                    e.preventDefault();
                    var k = $(this).val();
                    if(k != '' && k != '请输入关键字查询')
                        window.location.href = "{url:/search/index}/keyword/"+k;
                    return;
                }
            });
        })
    </script>
    
    <div class="in_nav" id="in_nav">
        <ul>
            <img src="{views:images/nav_top.png}" class="in_nav_top">
            
            {foreach:items=$cates}
            <li>
                <img style="max-width: 20px;max-height: 20px;border: none;margin-top: 2px;margin-left: 10px" src="{$item['icon']}"/>
                <a class="title_a" href="{url:/Hangye/index}/type/3/id/{$item['id']}">{$item['name']}
                    <!-- <div class="c-tip-arrow" style="left: 38px;"><em></em></div> -->
                </a>
            </li>
            {/foreach}
            <!-- <li class="industry1"><a href>建材行业</a></li> -->
        </ul>
    </div>
    </div>
{content}

<!--公用底部控件 开始-->
<link href="{views:css/footer.css}" rel="stylesheet" type="text/css">
<div class="clear"></div>
<div  class='footer'>

    <div class="div_flink">
         <ul>
            <li class="ul_tit"><b>友情链接</b></li>
            <ul class="lin_lists">
                {foreach:items=$fl}
                    <li class="li_txt">
                        <a href="{$item['link']}" target="_blank">{$item['name']}</a>
                    </li> 
                    <li class="li_l">
                        <span class="span_l">|</span>
                    </li>  
                {/foreach}
                
                    
            </ul> 
        </ul>
    </div>

    
    <div class="fotter_bq ">
        <div>
            Copyright&nbsp;&nbsp; © 2000-2015&nbsp;&nbsp;耐耐云商科技有限公司&nbsp;版权所有&nbsp;&nbsp; 网站备案/许可证号:沪ICP备15028925号
        </div>
        <div>
            服务电话：4006238086 地址:上海浦东新区唐镇上丰路977号b座
        </div>
        <div>
            增值电信业务经营许可证沪B2-20150196
        </div>
        <div>
            违法信息举报邮箱：shensu@nainaiwang.com
        </div>
        <div>
            技术支持：耐耐云商科技有限公司技术部
        </div>

            <!-- <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1260482243'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1260482243%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script> -->
    </div>

</div>


<div class="floor_left_box" id="floornav" data-tpa="YHD_HOMEPAGE_FLOORNAV" style="display: none;">
        <div class="show_div">
            <a href="" class="fhdb_a" data="#toTop" rel="toTop">
                <i class="left_iconfont "><img src="{views:images/floor_01.png}">刷新信息</i>
                <em class="two_line"><img src="{views:images/floor_cur_01.png}">刷新信息</em>
            </a>
            <div class="hover_div">
                <em></em>
                <a href="" data="#toTop" rel="toTop" class="hove_a">刷新信息</a>
            </div>
        </div>
        <div class="show_div">
            <a href="" class="fhdb_a" data="#toTop" rel="toTop">
                <i class="left_iconfont "><img src="{views:images/floor_05.png}">返回顶部</i>
                <em class="two_line"><img src="{views:images/floor_cur_05.png}">返回顶部</em>
            </a>
            <div class="hover_div">
                <em></em>
                <a href="" data="#toTop" rel="toTop" class="hove_a">返回顶部</a>
            </div>
        </div>

    </div>

<!--公用底部控件 结束-->
</body>
</body>