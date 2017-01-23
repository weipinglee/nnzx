<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0038)http://www.nainaiwang.com/#index_banner6 -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" /><title>
        耐耐网
    </title><meta name="Keywords" content="耐火材料、耐耐网"><meta name="Description" content="耐火材料、耐耐网">
    <script type="text/javascript" defer="" async="" src="{views:js/uta.js}"></script>
    <script src="{views:js/jquery-1.9.1.min.js}" type="text/javascript" language="javascript"></script>


    <script src="{views:js/gtxh_formlogin.js}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{views:css/index20141027.css}">
    <link rel="stylesheet" href="{views:css/classify.css}">
    <script type="text/javascript" src="{root:js/form/validform.js}" ></script>
    <script type="text/javascript" src="{root:js/form/formacc.js}" ></script>

    <script type="text/javascript" src="{root:js/layer/layer.js}" ></script>
    <script type="text/javascript" src="{views:js/area/Area.js}" ></script>
    <script type="text/javascript" src="{views:js/area/AreaData_min.js}" ></script>
    <!-- 头部css -->
    <link href="{views:css/topnav20141027.css}" rel="stylesheet" type="text/css">
    <script src="{views:js/gtxh_Login.js}" type="text/javascript"></script>
    <script src="{views:js/countdown.js}" type="text/javascript"></script>
    <!--[if lte IE 6]>
    <script>
        $(function(){
            $(".kind_name").mouseover(function(){
                $(".kind_sort").hide();
                $(this).next().show();
                $(this).css("border-bottom","2px solid #e50102");
                $(this).css("border-top","2px solid #e50102");
            });
            $(".kind_list").mouseleave(function(){
                $(".kind_sort").hide();
                $(".kind_name").css("border-bottom","1px solid #eaeaea");
                $(".kind_name").css("border-top","none");
            });

        });
    </script>
    <![endif]-->
    <!-- 帮助中心页 常见问题 -->
    <link rel="stylesheet" type="text/css" href="{views:css/help.css}"/>
    <script src="{views:js/help.js}" type="text/javascript" ></script>
    <!-- 帮助页 常见问题end -->

    <style>
            #search_list{
                width: 70px;
                margin:0 auto;
                border:1px solid #bababa;
                border-top: none;
                display: none;
                overflow: hidden;
                height: 40px;
                position: absolute;
                top: 35px;
            }
         #search_list li {
            padding: 0 0 0 15px;
            color: #999;
            background: #FFF;
            width: 70px;
            height: 20px;
            line-height: 20px;
            clear: both;
        }
    </style>

</head>
<body>





<!--[if lte IE 6]>
<div style="width:100%;_position:absolute;
_bottom:auto;
_top:expression(eval(document.documentElement.scrollTop));
z-index:1000;">
    <div style="width:100%;height:30px;border-bottom:1px solid #ff5a00;background:#ffede3;color:#444;line-height:30px; text-align:center;">
        系统检测您当前的浏览器为IE6，可能会影响部分功能的使用。为了您有更好的体验。建议您<a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank" style="color:#c81624;text-decoration:underline;">升级IE浏览器</a>或者下载安装使用<a href="http://dlsw.baidu.com/sw-search-sp/soft/9d/14744/ChromeStandalone_V43.0.2357.124_Setup.1433905898.exe" target="_blank" style="color:#c81624;text-decoration:underline;">谷歌浏览器chrome</a>
    </div>
    <style>
        body{_padding-top:30px;}
    </style>
</div>
<![endif]-->

<!------------------公用头部控件 开始-------------------->
<div class="bg_topnav">
    <div class="topnav_width">
        <div class="topnav_left">
            <div class="top_index">
                <img class="index_img" src="{views:images/index/icon_index.png}"/>
                <a rel="external nofollow" href="{url:/index/index@deal}" target="_blank" >耐耐网首页</a>
            </div>

            <div class="index_user">
            {if:isset($username)}您好，
                <a rel="external nofollow"  href="{url:/ucenterindex/index@user}"  target="_blank" class="">{$username}</a>
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
                   <a href="{url:/contract/buyerList@user}">我的合同</a><span class="line_l">|<span>
                </li>
                {/if}
                <li>
                    <a href="{url:/message/usermail@user}">消息中心{if:$login==1&&$mess!=0}<em class="information">{$mess}</em>{/if}</a><span class="line_l">|<span>
                </li>
                <!--<li>
                    <img class="iphon_img" src="{views:images/index/icon_iphon.png}"/>
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
<!------------------公用头部控件 开始-------------------->


<!------------------logo 开始-------------------->
<div id="index_logo">
    <div class="page_width">
        <div class="index_logo">
            <h1>
                <a href="{url:/index/index}"></a>
            </h1>
        </div>

        <script type="text/javascript" src="{views:js/search&floor.js}"></script>
        <div class="searchbox">
            <div class="search_xz">
               <!--  <select class="search_select" name="type">
                    <option value="gong" {if:isset($searchtype) && $searchtype==1}selected{/if}>供应</option>
                    <option value="qiu" {if:isset($searchtype) && $searchtype==2}selected{/if}>求购</option>
                </select> -->
                {if:isset($searchtype) && $searchtype==2}
                <input type="button" class="search_select" value="求购">
                <input type="hidden" name="type" value="qiu"/>
                {else:}
                <input type="button" class="search_select" value="供应">
                <input type="hidden" name="type" value="gong"/>
                {/if}
                     <ul id="search_list">
                        <li js_data="gong">供应</li>
                        <li js_data="qiu">求购</li>
                      </ul> 

            </div>
            <div class="bodys">
                <p class="keyword_0"><input type="text" {if:isset($search)}value="{$search}"{/if} name="content" placeholder="请输入关键词查询" value="" id=""  /><a href="javascript:void(0)" onclick="searchGoods()"><button class="one1">搜索</button></a></p>
            </div>
        </div>  
        <script>
         $(function(){
                $(".search_select").click(function(){
                    if($("#search_list").is(":hidden")){
                        $("#search_list").show();
                    }else{
                    $("#search_list").hide();

                     }
                })
                $("#search_list li").each(function(){
                    $(this).hover(function(){ 
                        $(this).css('background','#f7f7f7');
                     },function(){ 
                        $(this).css('background','#FFF');
                     }) 
                       
                })
                $("#search_list li").each(function(){
                    var _t = $(this)
                        ,_v = _t.attr('js_data');
                     _t.click(function(){
                        $('.search_select').val(_t.text());
                        $('input[name=type]').val(_v);
                        $('#search_list').hide();
                     })
                })
                

         });

        </script>

        <script type="text/javascript">
            function searchGoods(){
                var type = $('input[name=type]').val();
                var content = $('input[name=content]').val();
                if(content=='')return false;
                window.location.href='{url:/offers/offerList}/type/'+type+'/content/'+content;
            }
            document.onkeydown=function(event){
                e = event ? event :(window.event ? window.event : null);
                if(e.keyCode==13){
                    searchGoods();
                }
            }
        </script>
        <div class="index_phone">
            服务热线：<span>400-6238-086</span>
          
        </div>
    </div>
</div>

<!------------------logo 结束-------------------->
<!------------------导航 开始-------------------->
<div id="index_nav">
    <div class="page_width">
        <div class="all_steel"><img class="steel_img" src="{views:images/index/icon_daoha.png}"/>全部产品分类</div>


        <ul class="nav">
            <li {if:!isset($cur) || $cur=='index'}class="current"{/if}><a href="{url:/index/index}">首页</a></li>
            <li {if:isset($cur) && $cur=='offerlist'}class="current"{/if}><a href="{url:/offers/offerlist}" target="_blank">交易中心</a></li>
            <li {if:isset($cur) && $cur=='storage'}class="current"{/if}><a href="{url:/index/storage}" target="_blank">仓储专区</a></li>
            <li {if:isset($cur) && $cur=='found'}class="current"{/if}><a href="{url:/index/found}" target="_blank">帮我找</a></li>
        </ul>
    </div>
</div>

  <!-- 分类开始 -->



<div id="classify_lists" {if:!isset($index) || $index!=1}style="display:none;"{/if}>
    <div class="all-sort-list" >
                        {set:$i=1;}
                        {foreach: items=$catList}
                            <div class="item" id="{$i}">
                                <div class="icon-nh{$i}">&nbsp;</div>{set:$i = $i +1;}

                                <h3>

                                    <p class="fenlei-h1">{$item['name']}</p><p class="fenlei">

                                        {for:from=0 upto=2 item=$num}
                                            {if:isset($item['nested'][$num]['id'])}
                                                <a href="{url:/offers/offerlist?cate=$item['nested'][$num]['id']}">{$item['nested'][$num]['name']}</a>&nbsp;
                                            {/if}
                                        {/for}

                                    </p>
                                </h3>
                                <div class="item-list clearfix" style="top: 1px; display: none;">

                                    <div class="subitem">
                                        {foreach: items=$item['nested'] key=$kk}
                                            {if:$kk<=11}
                                            <dl class="fore1">
                                                <dt><a href="{url:/offers/offerlist?cate=$item['id']}">{$item['name']}</a></dt>

                                                <dd>
                                                    {foreach:items=$item['nested']}
                                                        <em><a href="{url:/offers/offerlist?cate=$item['id']}">{$item['name']}</a></em>
                                                    {/foreach}
                                                </dd>
                                            </dl>
                                            {/if}
                                        {/foreach}
                                    </div>
                                    <!--
                                    <div class="cat-right">
                                        <dl class="categorys-brands" clstag="homepage|keycount|home2013|0601d">
                                            <dt>推荐品牌出版商</dt>
                                            <dd>
                                                <ul>
                                                    <li><a href="#" target="_blank">中华书局</a></li>
                                                    <li><a href="#" target="_blank">人民邮电出版社</a></li>
                                                    <li><a href="#" target="_blank">上海世纪出版股份有限公司</a></li>
                                                    <li><a href="#" target="_blank">电子工业出版社</a></li>
                                                    <li><a href="#" target="_blank">三联书店</a></li>
                                                    <li><a href="#" target="_blank">浙江少年儿童出版社</a></li>
                                                </ul>
                                            </dd>
                                        </dl>
                                    </div>-->
                                </div>
                            </div>
                        {/foreach}
                </div>
            </div>
                        <!--所有分类 End-->
 <!-- 分类js strat-->
        <script type="text/javascript">


                $('.all-sort-list > .item').hover(function () {
                    var eq = $('.all-sort-list > .item').index(this),               //获取当前滑过是第几个元素
                            h = $('.all-sort-list').offset().top,                       //获取当前下拉菜单距离窗口多少像素
                            s = $(window).scrollTop(),                                  //获取游览器滚动了多少高度
                            i = $(this).offset().top,
                            id = $(this).attr('id');                               //当前元素滑过距离窗口多少像素

                    try{
                        item=parseInt(Aa(this, "item-list clearfix")[0].currentStyle['height']);
                    }catch (er){item = ( $(this).children('.item-list').height());            //下拉菜单子类内容容器的高度
                    }
                    sort = $('.all-sort-list').height();                        //父类分类列表容器的高度

                    if (item < sort) {                                             //如果子类的高度小于父类的高度
                        /*if (eq == 0) {
                            $(this).children('.item-list').css('top', (i - h));
                        } else {
                            $(this).children('.item-list').css('top', (i - h) + 1);
                        }*/
                    } else {
                        if (s > h) {                                              //判断子类的显示位置，如果滚动的高度大于所有分类列表容器的高度
                            if (i - s > 0) {                                         //则 继续判断当前滑过容器的位置 是否有一半超出窗口一半在窗口内显示的Bug,
                                $(this).children('.item-list').css('top', 0);
                            } else {
                                $(this).children('.item-list').css('top', 0);
                            }
                        } else {
                            $(this).children('.item-list').css('top', 0);
                        }
                    }


                    $(this).addClass('hover');
                    $(this).children('.item-list').css('display', 'block');
                    $(this).children('.icon-nh' + id).addClass('icon-nh' + id + '-1');
                }, function () {
                    $(this).removeClass('hover');
                    $(this).children('.item-list').css('display', 'none');
                    var id = $(this).attr("id");
                    //alert(id);
                    $(this).children('.icon-nh' + id).removeClass('icon-nh' + id + '-1');
                });
                function Aa(a, b) {var c = a.getElementsByTagName("*");var d = [];for (var i = 0; i < c.length; i++) {if (c[i].className == b) {d.push(c[i]);}};return d;}
                var item;


            </script>
      <!--   分类js end -->


  <!--   分类js 隐藏 start -->

       <script>

              $(function(){
                   var _sign = $('input[name=js_sign_banner]').val();
                   if(_sign != 1){
                        a_all.mouseover(function(){show()});
                        a_all.mouseout(function(){hide()});
                        $('#classify_lists').find('.all-sort-list').css('position', 'absolute')
                        b_title.mouseover(function(){show()});
                        b_title.mouseout(function(){hide()});
                   }
              });

                        var a_all = $('.all_steel');
                        var b_title = $('#classify_lists');
                        
                        var timer = null;
                  
                    function show(){
                        clearInterval( timer );
                        b_title.css('display','block')
                    }
                    function hide(){
                        timer = setTimeout(function(){
                            b_title.css('display','none')
                        }, 200);
                    }


     </script>

<!--   分类js 隐藏 end -->












 <!-- 分类结束 -->




{content}

<!--公用底部控件 开始-->
<!--公用底部控件 开始-->
<link href="{views:css/footer.css}" rel="stylesheet" type="text/css">
<div id="footer">



    <div class="footer_link clearfix">
        <div class="foter_width">
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
        </div>
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
		
            <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1260482243'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1260482243%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
    </div>

</div>




<!--公用底部控件 结束-->


<!--悬浮导航-->

</body></html>