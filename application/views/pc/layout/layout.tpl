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
        })
    </script>
    
    <div class="in_nav" id="in_nav">
        <ul>
            <img src="{views:images/nav_top.png}" class="in_nav_top">

            {foreach:items=$cates}
            <li>
                <a class="title_a" href="{url:/Hangye/index}/type/3/id/{$item['id']}">{$item['name']}
                    <div class="c-tip-arrow" style="left: 38px;"><em></em></div>
                </a>
            </li>
            {/foreach}
            <!-- <li class="industry1"><a href>建材行业</a></li> -->
        </ul>
    </div>
{content}
</body>

</html>