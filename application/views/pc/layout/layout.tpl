<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>资讯中心</title>


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
        <ul class="nav">
            <li><a href='{url:/index/index}' {if:$type_id == 0}class='on'{/if}>首页</a></li>
            <li id="industry"><a href='{url:/hangye/index}/type/{$typelist[0]['id']}' {if:$type_id ==$typelist[0]['id']}class="on"{/if}>行业</a></li>

            <li><a href="{url:/shuju/index}/type/{$typelist[1]['id']}" {if:$type_id == $typelist[1]['id']}class="on"{/if}>数据</a></li>
            <li><a href='{url:/guandian/index}/type/{$typelist[2]['id']}' {if:$type_id == $typelist[2]['id']}class="on"{/if}>观点</a></li>
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
                <img src="{$item['img']}"/>
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
<div id="footer">



    <div class="footer_link clearfix">
        <!-- <div class="foter_width">
            <ul>
                {foreach: items=$helpList2}
                    <li class="footer_li">
                        <a class="fotter_div" target="_blank"><b>{$item['name']}</b></a>
                        {foreach: items=$item['data'] item=$v key=$k}
                            {if:$v['link']}
                                <a class="fotter_a" href="{$v['link']}" target="_blank">{$v['name']}</a>

                            {else:}
                                <a class="fotter_a" href="{url:/help/help}?cat_id={$v['cat_id']}&id={$v['id']}" target="_blank">{$v['name']}</a>

                            {/if}
                         {/foreach}
                    </li>
                {/foreach}

            </ul>
            <ul class="ewm_ul">
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注耐火频道</b></div>
                    <div><img src="{views:images/index/a_naih.png}"></div>
                </li>
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注耐耐网</b></div>
                    <div><img src="{views:images/index/a_nain.png}"></div>
                </li>
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注建材频道</b></div>
                    <div><img src="{views:images/index/a_jianc.png}"></div>
                </li>
            </ul>
        </div> -->
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




<!--公用底部控件 结束-->
</body>
</body>