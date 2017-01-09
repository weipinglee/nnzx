<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0038)http://www.nainaiwang.com/#index_banner6 -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" /><title>
        耐耐网
    </title><meta name="Keywords" content="耐火材料、耐耐网"><meta name="Description" content="耐火材料、耐耐网">
    <script type="text/javascript" defer="" async="" src="/nn2/views/pc/js/uta.js"></script>
    <script src="/nn2/views/pc/js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>


    <script src="/nn2/views/pc/js/gtxh_formlogin.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/index20141027.css">
    <link rel="stylesheet" href="/nn2/views/pc/css/classify.css">
    <script type="text/javascript" src="/nn2/js/form/validform.js" ></script>
    <script type="text/javascript" src="/nn2/js/form/formacc.js" ></script>

    <script type="text/javascript" src="/nn2/js/layer/layer.js" ></script>
    <script type="text/javascript" src="/nn2/views/pc/js/area/Area.js" ></script>
    <script type="text/javascript" src="/nn2/views/pc/js/area/AreaData_min.js" ></script>
    <!-- 头部css -->
    <link href="/nn2/views/pc/css/topnav20141027.css" rel="stylesheet" type="text/css">
    <script src="/nn2/views/pc/js/gtxh_Login.js" type="text/javascript"></script>
    <script src="/nn2/views/pc/js/countdown.js" type="text/javascript"></script>
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
    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/help.css"/>
    <script src="/nn2/views/pc/js/help.js" type="text/javascript" ></script>
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
                <img class="index_img" src="/nn2/views/pc/images/index/icon_index.png"/>
                <a rel="external nofollow" href="http://124.166.246.120:8000/user/public/index/index" target="_blank" >耐耐网首页</a>
            </div>

            <div class="index_user">
            <?php if(isset($username)){?>您好，
                <a rel="external nofollow"  href="http://localhost/nn2/user/public/ucenterindex/index"  target="_blank" class=""><?php echo isset($username)?$username:"";?></a>
                <?php }else{?>
                <span>您好，欢迎进入耐耐网</span>
                <?php }?>
            </div>
            <?php if($login==0){?>
            <div class="login_link" id="toploginbox">
                <a rel="external nofollow" href="http://localhost/nn2/user/public/login/login" target="_blank" class="topnav_login">请登录</a>
            </div>
            <div class="topnav_regsiter">
                <a rel="external nofollow" href="http://localhost/nn2/user/public/login/register" target="_blank">免费注册</a>
            </div>
            <?php }else{?>
            <div class="login_link" id="toploginbox">
                <a rel="external nofollow" href="http://localhost/nn2/user/public/login/logout" target="_blank" class="topnav_login">退出</a>
            </div>
            <?php }?>
        </div>
        <div class="topnav_right">
            <ul>
                <?php if($login!=0){?>
                 <li>
                   <a href="http://localhost/nn2/user/public/ucenterindex/index">会员中心</a><span class="line_l">|<span>
                </li>
                <li>
                   <a href="http://localhost/nn2/user/public/contract/buyerlist">我的合同</a><span class="line_l">|<span>
                </li>
                <?php }?>
                <li>
                    <a href="http://localhost/nn2/user/public/message/usermail">消息中心<?php if($login==1&&$mess!=0){?><em class="information"><?php echo isset($mess)?$mess:"";?></em><?php }?></a><span class="line_l">|<span>
                </li>
                <!--<li>
                    <img class="iphon_img" src="/nn2/views/pc/images/index/icon_iphon.png"/>
                    <a href="">手机版</a><span class="line_l">|<span>
                </li>-->
                <li>
                    <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=4006238086&aty=0&a=0&curl=&ty=1" target="_blank" ><!--onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&sid=279020473&o=new.nainaiwang.com&q=7', '_blank', 'height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');" --> 在线客服</a><span class="line_l">|<span>
                </li>
                <li style="padding-top:2px;">
                    <span>交易时间：<?php echo isset($deal['start_time'])?$deal['start_time']:"";?>--<?php echo isset($deal['end_time'])?$deal['end_time']:"";?></span>
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
                <a href="http://localhost/nn2/index/index"></a>
            </h1>
        </div>

        <script type="text/javascript" src="/nn2/views/pc/js/search&floor.js"></script>
        <div class="searchbox">
            <div class="search_xz">
               <!--  <select class="search_select" name="type">
                    <option value="gong" <?php if(isset($searchtype) && $searchtype==1){?>selected<?php }?>>供应</option>
                    <option value="qiu" <?php if(isset($searchtype) && $searchtype==2){?>selected<?php }?>>求购</option>
                </select> -->
                <?php if(isset($searchtype) && $searchtype==2){?>
                <input type="button" class="search_select" value="求购">
                <input type="hidden" name="type" value="qiu"/>
                <?php }else{?>
                <input type="button" class="search_select" value="供应">
                <input type="hidden" name="type" value="gong"/>
                <?php }?>
                     <ul id="search_list">
                        <li js_data="gong">供应</li>
                        <li js_data="qiu">求购</li>
                      </ul> 

            </div>
            <div class="bodys">
                <p class="keyword_0"><input type="text" <?php if(isset($search)){?>value="<?php echo isset($search)?$search:"";?>"<?php }?> name="content" placeholder="请输入关键词查询" value="" id=""  /><a href="javascript:void(0)" onclick="searchGoods()"><button class="one1">搜索</button></a></p>
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
                window.location.href='http://localhost/nn2/offers/offerlist/type/'+type+'/content/'+content;
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
        <div class="all_steel"><img class="steel_img" src="/nn2/views/pc/images/index/icon_daoha.png"/>全部产品分类</div>


        <ul class="nav">
            <li <?php if(!isset($cur) || $cur=='index'){?>class="current"<?php }?>><a href="http://localhost/nn2/index/index">首页</a></li>
            <li <?php if(isset($cur) && $cur=='offerlist'){?>class="current"<?php }?>><a href="http://localhost/nn2/offers/offerlist" target="_blank">交易中心</a></li>
            <li <?php if(isset($cur) && $cur=='storage'){?>class="current"<?php }?>><a href="http://localhost/nn2/index/storage" target="_blank">仓储专区</a></li>
            <li <?php if(isset($cur) && $cur=='found'){?>class="current"<?php }?>><a href="http://localhost/nn2/index/found" target="_blank">帮我找</a></li>
        </ul>
    </div>
</div>

  <!-- 分类开始 -->



<div id="classify_lists" <?php if(!isset($index) || $index!=1){?>style="display:none;"<?php }?>>
    <div class="all-sort-list" >
                        <?php $i=1;; ?>
                        <?php if(!empty($catList)) foreach($catList as $key => $item){?>
                            <div class="item" id="<?php echo isset($i)?$i:"";?>">
                                <div class="icon-nh<?php echo isset($i)?$i:"";?>">&nbsp;</div><?php $i = $i +1;; ?>

                                <h3>

                                    <p class="fenlei-h1"><?php echo isset($item['name'])?$item['name']:"";?></p><p class="fenlei">

                                        <?php for($num = 0 ; $num<=2 ; $num = $num+1){?>
                                            <?php if(isset($item['nested'][$num]['id'])){?>
                                                <a href="http://localhost/nn2/offers/offerlist/cate/<?php echo $item['nested'][$num]['id'];?>"><?php echo isset($item['nested'][$num]['name'])?$item['nested'][$num]['name']:"";?></a>&nbsp;
                                            <?php }?>
                                        <?php }?>

                                    </p>
                                </h3>
                                <div class="item-list clearfix" style="top: 1px; display: none;">

                                    <div class="subitem">
                                        <?php if(!empty($item['nested'])) foreach($item['nested'] as $kk => $item){?>
                                            <?php if($kk<=11){?>
                                            <dl class="fore1">
                                                <dt><a href="http://localhost/nn2/offers/offerlist/cate/<?php echo $item['id'];?>"><?php echo isset($item['name'])?$item['name']:"";?></a></dt>

                                                <dd>
                                                    <?php if(!empty($item['nested'])) foreach($item['nested'] as $key => $item){?>
                                                        <em><a href="http://localhost/nn2/offers/offerlist/cate/<?php echo $item['id'];?>"><?php echo isset($item['name'])?$item['name']:"";?></a></em>
                                                    <?php }?>
                                                </dd>
                                            </dl>
                                            <?php }?>
                                        <?php }?>
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
                        <?php }?>
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




<script type="text/javascript" src="/nn2/js/arttemplate/artTemplate.js"></script>
<input type="hidden" name="js_sign_banner" value="1">
<script type="text/javascript">
$(function(){
    $('.js_rep_offer .li_select').trigger('click');
})

</script>
    <!------------------导航 开始-------------------->
    <form method="post" action="" id="form1">
        <div class="aspNetHidden">
        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="b7kHdN58Jsi2cPaAmmpEqXjSD5M7lilMmnUNdKzTkgYwpBrDsYEml4gvo/iOj8sf">
        </div>
    </form>


    <input type="hidden" id="UserID">
      <!-- 轮播大图 开始 -->

    <div class="banner">
        <!-- 代码 开始 -->
    <link href="/nn2/views/pc/css/nav.css" rel="stylesheet" />
    <script src="/nn2/views/pc/js/jquery.nav.js" type="text/javascript"></script>
        <div id="inner">
            <div class="hot-event">
            <?php $count = count($indexSlide); ?>
                <?php if(!empty($indexSlide)) foreach($indexSlide as $key => $item){?>
                <div class="event-item" style="<?php if($key==0){?>display: block;<?php }else{?>display:none;<?php }?>background:<?php echo isset($item['bgcolor'])?$item['bgcolor']:"";?>">
                    <a target="_blank" href="javascript:;">
                        <img src="<?php echo isset($item['img'])?$item['img']:"";?>" class="photo" style="width: 100%; height: 470px;margin:0 auto" alt="<?php echo isset($itme['name'])?$itme['name']:"";?>" />
                    </a>
                </div>
                <?php }?>
                <div class="switch-tab">
                    <?php if(!empty($indexSlide)) foreach($indexSlide as $key => $item){?>
                    <?php $key++; ?>
                    <a href="javascript:;" onclick="return false;" <?php if($key == 1){?> class="current"<?php }?>><?php echo isset($key)?$key:"";?></a>
                    <?php }?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
             var _c = <?php echo isset($count)?$count:"";?>;
             $('#inner').nav({ t: 2000, a: 1000, c: _c});
        </script>
        <!-- 代码 结束 -->
      </div> 
    <!-- 轮播大图 结束 -->


 

   <!--最新数据 开始-->
  <div class="mostnew_date" style="display:none">
  
   <div id="row1_clinch" class="row1_clinch">
       <div class="clinch_tit">
           <div class="tit_time">
               <p id="time_year" class="time_year"><?php echo isset($year)?$year:"";?><br><span class="time_month"><?php echo isset($month)?$month:"";?>/<?php echo isset($day)?$day:"";?></span></p>
               <!-- <p id="time_day" class="time_day">11</p> -->
           </div>
           <div class="tit_font">
               <b>最新<span>数据</span></b>
               <br>
               RECENT DATAS</div>
       </div>
       <div class="data-list">
           <div class="data-tit">
               <div class="data">
                   <p class="data_title">当前在线报盘</p>
                   <p class="data_content"><?php echo isset($offer_num)?$offer_num:"";?></p>
               </div>
               <img class="data_img" src="/nn2/views/pc/images/icon/data-img_03.png"/>
           </div>
           <div class="data-tit">                            
               <div class="data">
                   <p class="data_title">当前成交量</p>
                   <p class="data_content"><?php echo isset($order_num)?$order_num:"";?></p>
               </div>
               <img class="data_img" src="/nn2/views/pc/images/icon/data-img_06.png"/>
           </div>
           <div class="data-tit">
               <div class="data">
                   <p class="data_title">昨日成交量</p>
                   <p class="data_content"><?php echo isset($order_num_yes)?$order_num_yes:"";?></p>
               </div>
               <img class="data_img" src="/nn2/views/pc/images/icon/data-img_08.png"/>
           </div>
           <div class="data-tit">
               <div class="data">
                   <p class="data_title">当前入驻商家</p>
                   <p class="data_content"><?php echo isset($all_user_num)?$all_user_num:"";?>位</p>
               </div>
               <img class="data_img" src="/nn2/views/pc/images/icon/data-img_10.png"/>
           </div>
       </div>                    
   </div>
   
  </div>  
   <!--最新数据 结束-->
    <!--主要内容 开始-->

                            </div>
    <div id="mainContent">
        <div class="page_width">
            <!----第一行搜索  开始---->
            <div class="mainRow1">
                <!--搜索条件 开始-->
                <div class="wrap">
                    
             
 <!--搜索条件 结束-->

                
            </div>
            <!-----第一行搜索  结束---->
            

            
            <!----五大类  开始---->
            <div class="mainRow3">                
        <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/style_main.css">
                <!-- 中间内容 -->
                <div class="WebBox">
                   <!--人民币市场-->
                     <div class="i_market clearfix">

                    <div class="i_market_left" id="rmb_market">
                        <div id="floor-1" class="item"></div>

                        <div class="i_leftTit clearfix">
                            <div class="i_left_title" name="1" id="item1">交易市场</div>
                            <ul class="js_rep_offer">
                                <?php if(!empty($topCat)) foreach($topCat as $key => $item){?>
                                    <li class="<?php if($key==0){?>li_select<?php }?>" onclick="showOffers(<?php echo isset($item['id'])?$item['id']:"";?>,$(this))"><a href="javascript:void(0)"><em></em><span></span><?php echo isset($item['name'])?$item['name']:"";?></a></li>

                                <?php }?>
                       <!--         <li class="li_select" onclick="showOffers(1,$(this))"><a href="javascript:void(0)"><em></em><span></span>冶金化工市场</a></li>
                            </ul> -->
                            </ul>
                          <span class="i_more"><a rel="http://localhost/nn2/offers/offerlist" href="http://localhost/nn2/offers/offerlist">更多&gt;&gt;</a></span>  
                        </div>

                        <div class="i_leftCon" id="offer_list">
                            <div class="i_proList show">
                                <ul>
                                    <li class="i_ListTit" id="offer">
                                        <span class="i_w_1">品名</span>
                                        <span class="i_w_2">供求</span>
                                        <span class="i_w_3">类型</span>
                                        <span class="i_w_4">产地</span>
                                        <span class="i_w_5">交货地</span>
                                        <span class="i_w_6">数量</span>
                                        <span class="i_w_7">剩余</span>
                                        <span class="i_w_8">单价</span>
                                        <span class="i_w_9">咨询</span>
                                        <span class="i_w_10">操作</span>
                                    </li>
                                </ul>
                                <ul id="offerRowBox">
                                
                                </ul>
                            </div>

                           <!-- 广告轮播 Swiper -->
                           <link rel="stylesheet" href="/nn2/views/pc/css/swiper.min.css">
                            <script src="/nn2/views/pc/js/jquery.bxslider.js"></script>
                           <div style="width:100%;height:1px;background:#ccc;margin:10px 0;"></div>
                             <div class="slider4">
                                 <?php if(!empty($adList)) foreach($adList as $key => $item){?>
                                  <div class="slide"><img src="<?php echo isset($item['content'])?$item['content']:"";?>" /></div>
                                 <?php }?>
                                </div>
                        </div>

                    </div>

                    <!--大家都在做什么-->
                    <div class="i_market_right">

                        <div class="iConWrap index_height">
                            <div class="iConTitle">最新交易</div>
                            <div class="items_container yichi">
                                <ul style="top: 0px;">
                                    <?php if(!empty($newTrade)) foreach($newTrade as $key => $item){?>
                                        <li style="opacity: 1.0000000000000007;">
                                            <?php $time=date('m-d',strtotime($item['create_time'])); ?>
                                            <?php if( ! empty($item['username'])){?>
                                            <?php $userName=mb_substr($item['username'],0,4,'utf-8'); ?>
                                            <i><?php echo isset($userName)?$userName:"";?>****</i>
                                            <?php }else{?>
                                            <i>****</i>
                                            <?php }?>
                                            <?php if($item['type']==1){?>
                                                <em class="red">售出</em>
                                            <?php }else{?>
                                                <em class="green">采购</em>
                                            <?php }?>
                                            <b><?php echo isset($item['name'])?$item['name']:"";?><?php echo isset($item['num'])?$item['num']:"";?><?php echo isset($item['unit'])?$item['unit']:"";?></b>
                                            <span><?php echo isset($time)?$time:"";?></span>
                                            <div class="titles"> <i></i>
                                              <p><?php echo isset($item['name'])?$item['name']:"";?><?php echo isset($item['num'])?$item['num']:"";?><?php echo isset($item['unit'])?$item['unit']:"";?></p>
                                            </div>
                                        </li>


                                    <?php }?>

                                </ul>
                            </div>
                        </div>

                    </div>

                </div>    
                <div class="guanimg"><?php echo  \Library\Ad::show("首页1");?></div>

                    <!--美金市场-->
                    <div class="i_market clearfix">
                        <div class="i_market_left" id="rmb_market">
                            <div id="floor-2" class="item"></div>
                            <div class="i_leftTit i_leftTit_bg clearfix">
                                <div class="i_left_title " name="1" id="item2">市场指数</div>
                                <ul>
                                    <ul>
                                        <?php if(!empty($topCat)) foreach($topCat as $key => $item){?>
                                            <li <?php if($key==0){?>class='li_select'<?php }?> onclick="statistics(<?php echo isset($item['id'])?$item['id']:"";?>,this)" ><a attr="<?php echo isset($item['id'])?$item['id']:"";?>"href="javascript:void(0)"><em class="em2"></em><span></span><?php echo isset($item['name'])?$item['name']:"";?></a></li>

                                        <?php }?>
                                    </ul>
                                </ul>
                                            
                            </div>
                            <?php  $first_cat_id=$topCat[0]['id']; ?>
                            <script src="https://code.highcharts.com/highcharts.js"></script>
                            <script src="https://code.highcharts.com/modules/exporting.js"></script>
                            <script language="javascript" type="text/javascript">
                                $(function(){
                                    var cat_id=<?php echo isset($first_cat_id)?$first_cat_id:"";?>;
                                    changeContainer(cat_id);
                                });
                                function statistics(id,obj){
                                    $(obj).siblings().removeClass('li_select');
                                    $(obj).addClass('li_select');
                                    //var recObj=$('#statc'+id);
                                   /* $('#item5').children().css('display','none');
                                    recObj.css('display','block');*/
                                    changeContainer(id);
                                }
                                function changeContainer(id){
                                    var statisList=<?php echo isset($statcCatList)?$statcCatList:"";?>;
                                    var categories=<?php echo isset($statcTime)?$statcTime:"";?>;
                                    var series=new Array();
                                    var j=0;
                                    var chart;
                                    var text;
                                    if(statisList[id]!=undefined&&categories[id]!=undefined){
                                        
                                        text='市场指数';
                                        $.each(statisList[id],function(index,value){

                                            var data=new Array();
                                            for(var i=0;i<value.length;i++){
                                                var price=parseInt(value[i].price,10);
                                                data[i]=price;
                                            }
                                            series[j]={name:index,data:data};
                                            j++;
                                        });
                                    }else {
                                        categories[id]=null;series=[{
                                            type:'line',
                                            name:'',
                                            data:[]
                                        }];
                                        text='暂时没有数据';
                                    }


                                    $('#container').highcharts({
                                        title: {
                                            text: text,
                                            x: -20 //center
                                        },
                                        credits:{
                                            text:'耐耐网',
                                            href:'http://localhost/nn2/index/index'
                                        },
                                        subtitle: {
                                            text: 'www.nainaiwang.com',
                                            x: -20
                                        },
                                        noData: {
                                            // Custom positioning/aligning options
                                            position: {
                                                align: 'right',
                                                verticalAlign: 'bottom'
                                            },
                                            // Custom svg attributes
                                            attr: {
                                                'stroke-width': 1,
                                                stroke: '#cccccc'
                                            },
                                            // Custom css
                                            style: {
                                                fontWeight: 'bold',
                                                fontSize: '15px',
                                                color: '#202030'
                                            }
                                        },
                                        xAxis: {
                                            categories: categories[id]
                                        },
                                        yAxis: {
                                            title: {
                                                text: '金额（元）'
                                            },
                                            plotLines: [{
                                                value: 0,
                                                width: 1,
                                                color: '#808080'
                                            }]
                                        },
                                        tooltip: {
                                            valueSuffix: '元 '
                                        },
                                        legend: {
                                            layout: 'vertical',
                                            align: 'right',
                                            verticalAlign: 'middle',
                                            borderWidth: 0
                                        },
                                        series:series
                                    });
                                }
                            </script>
                            <div class="i_leftCon" style="margin:0px;">
                                <div class="i_proList show i_proList_zhishu">
                                    <div class="img_pro" id="container"></div>
                                </div>
                                <div class="i_proList i_proList_zhishu">
                                    <div class="img_pro"><img src="/nn2/views/pc/images/index/zhibiao.jpg"></div>
                                </div>
                                <div class="i_proList i_proList_zhishu">
                                    <div class="img_pro"><img src="/nn2/views/pc/images/index/zhibiao.jpg"></div>
                                </div>
                                <div class="i_proList i_proList_zhishu">
                                    <div class="img_pro"><img src="/nn2/views/pc/images/index/zhibiao.jpg"></div>
                                </div>
                                <div class="i_proList i_proList_zhishu">
                                    <div class="img_pro"><img src="/nn2/views/pc/images/index/zhibiao.jpg"></div>
                                </div>
                                <div class="i_proList i_proList_zhishu">
                                    
                                </div>
                                     
                            </div>
                        
                        </div>
                                                    
                        <!--大家都在做什么-->
                        <div class="i_market_right">
                            <div class="ShopPro">
                                <div class="ShopPro_Tab clearfix" style="border-bottom:2px solid #ffab2d;">
                                    <ul>
                                        <li class="selected" style="color:#ffab2d;">热门商品</li>
                                    </ul>
                                </div>
                                <div class="ShopPro_Con">
                                    <?php if(!empty($statcProList)) foreach($statcProList as $key => $item){?>
                                    <div class="ShopPro_item clearfix">
                                        <span class="ShopPro_text"><?php echo isset($item['name'])?$item['name']:"";?></a></span>
                                        <span class="ShopPro_change i_TextRed"><img class="shja" <?php if($item['change_range'] == 0){?>src="/nn2/views/pc/images/index/icon_line.png"<?php }elseif(abs($item['change_range']) <> $item['change_range']){?>src="/nn2/views/pc/images/index/icon_down.png"<?php }else{?>src="/nn2/views/pc/images/index/icon_top.png"<?php }?>/><?php echo abs($item['change_range']);?>%</span>
                                        <span class="ShopPro_price i_TextRed">￥<?php echo isset($item['price'])?$item['price']:"";?></span>
                                        <div class='titles hot'>   <i></i>
                                          <p>
                                                <?php echo isset($item['name'])?$item['name']:"";?>
                                            </p></div>
                                    </div>
                                    <?php }?>
                                </div> 

                               
                            </div>              
                        </div>
                    </div>

                                <!--推荐商家-->
                    <div class="i_market_comm clearfix">

                        <div class="i_market_lef_t_comm" id="retail_market">
                            <div id="floor-3" class="item"></div>
                            <div class="i_leftTit i_leftTit_sj clearfix">
                                <div class="i_left_title " name="1" id="item3">推荐商家</div>
                            </div>

                        
                           

                                  <div class="slider4 recommend">
                                 <?php if(!empty($allCompanyAd)) foreach($allCompanyAd as $key => $item){?>
                                <div class="slide"><img src="<?php echo isset($item['content'])?$item['content']:"";?>"></div>
                                 <?php }?>

                                
                             </div>
                                 <script>
                              $(document).ready(function(){
                                $('.slider4').bxSlider({
                                  slideWidth: 215,
                                  minSlides: 2,
                                  maxSlides: 4,
                                  moveSlides: 1,
                                  startSlide: 1,
                                  auto: true,
                                  slideMargin: 10
                                });
                              });
                            </script>

                        </div>

                        <!--大家都在做什么-->
                        <div class="i_market_right">
                                    
                            <div class="ShopPro six">
                                <div class="ShopPro_Tab clearfix">
                                    <ul>
                                        <li class="selected">信誉排行</li>
                                    </ul>
                                </div>
                                <div class="shop_rank">
                                    <ul class="rank_tab">
                                        <li class="rank_tit">
                                            <span class="i_r_1">排名</span>
                                            <span class="i_r_2">用户</span>
                                            <span class="i_r_4">等级</span>
                                            <span class="i_r_5">信誉值</span>
                                        </li>
                                        <?php if(!empty($creditMember)) foreach($creditMember as $key => $item){?>
                                            <li class="rank_list">
                                            <span class="i_r_1"><?php if($key==0){?>
                                                    <img src="/nn2/views/pc/images/rank_06.png">

                                                                <?php }elseif($key==1){?>
                                                    <img src="/nn2/views/pc/images/rank_13.png">

                                                                <?php }elseif($key==2){?>
                                                    <img src="/nn2/views/pc/images/rank_16.png">

                                                <?php }else{?>
                                                    <?php echo $key+1;?>
                                                <?php }?>


                                            </span>
                                                <span class="i_r_2"><?php echo mb_substr($item['company_name'],0,5,'utf-8');?></span>
                                                <span class="i_r_4"><img style="margin-top: -17px;" src="<?php echo isset($item['icon'])?$item['icon']:"";?>"></span>
                                                <span class="i_r_5"><?php echo isset($item['credit'])?$item['credit']:"";?></span>
                                            </li>
                                        <?php }?>


                                    </ul>
                                </div>
                            </div>
                                        
                        </div>

                    </div>
                   

                </div>

                <!-- //中间内容 -->

                            <!--//通用底部-->
            <!-- 最新交易js -->
            <script type="text/javascript" src="/nn2/views/pc/js/script-2-AQTnlOGb8Z1ylR8UZZJBEg.js"></script>
            <!-- 最新交易js end -->               
            </div>
            <!----五大类  结束---->
            <script type="text/javascript">
                $('document').ready(function(){
                    var obj=$('#item3').next().children().first();
                    var id=obj.attr('attr');
                    var obj2=$('#item2').next().children().first();;
                    var id2=obj.attr('attr');
                    obj2.addClass('li_select');
                    obj.addClass('li_select');
                    var recObj=$('#rec'+id);
                    var recObj2=$('#statc'+id2);
                    recObj2.css('display','block');
                    recObj.css('display','block');

                });
                function companyRec(id,obj){
                    $(obj).siblings().removeClass('li_select');
                    $(obj).addClass('li_select');
                    var recObj=$('#rec'+id);
                    $('#item4').nextAll().css('display','none');
                    recObj.css('display','block');

                }
/*                function statistics(id,obj){
                    $(obj).siblings().removeClass('li_select');
                    $(obj).addClass('li_select');
                    var recObj=$('#statc'+id);
                    $('#item5').children().css('display','none');
                    recObj.css('display','block');

                }*/


                function showOffers(id,obj){
					var offerData = <?php echo isset($offerCateList)?$offerCateList:"";?>;
                    obj.siblings().removeClass('li_select');
                    obj.addClass('li_select');
                    /*$('[id^=offer]').removeClass('show');
                    $('#offer'+id).addClass('show');*/

                   
                    //$('#offerRowBox').empty();
                    template.helper('getAreaText', function(area_data){  
                          var areatextObj = new Area();
                          var text = areatextObj.getAreaText(area_data);
                           return text;
                    });  
					if(offerData[id]){
						 var offerRowHtml = template.render('offerRowTemplate',{data:offerData[id]});
                         $('#offerRowBox').html(offerRowHtml);
					}
                           


                }
            </script>
        </div>
    </div>  
    <!--主要内容 结束-->
        <!--耐耐网服务-->

</div>

        <div class="footer_clude">
            <!--耐耐网服务-->
            <div class="i_service clearfix">
                <div class="iServiceCon clearfix">
                    <ul>
                        <?php if(!empty($fuwuList)) foreach($fuwuList as $key => $item){?>
                            <li class="iServiceTit">
                                <div class="fw_img"><img src="<?php echo \Library\Thumb::get($item['img']);?>" onerror="/nn2/views/pc/images/index/kongbai.png"/></div>
                                <div class="wi_fw"><a href="http://localhost/nn2/help/help/index?cat_id=<?php echo isset($item['cat_id'])?$item['cat_id']:"";?>&id=<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a></div>
                            </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="div_flink">
                <ul>
                    <li class="ul_tit"><b>友情链接</b></li>
                    <?php  $sum=count($frdLinkList); ?>
                    <ul class="lin_lists">
                    <?php if(!empty($frdLinkList)) foreach($frdLinkList as $key => $item){?>
                        <li class="li_txt">
                            <a class="li_a" href="<?php echo isset($item['link'])?$item['link']:"";?>" target="_blank"><?php echo isset($item['name'])?$item['name']:"";?></a>
                        </li>
                        <?php if($key!=$sum-1){?>
                            <li class="li_l">
                                <span class="span_l">|</span>
                            </li>    
                        <?php }?>
                    <?php }?>
                    </ul> 
                </ul>
            </div>
        </div>


        <!-- 浮动楼层 -->
<link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/global_site_index_new.css">
<div class="floor_left_box" id="floornav" data-tpa="YHD_HOMEPAGE_FLOORNAV" style="display: block;">
              <div class="show_div">
                <a href="#floor-1" data="#floor-1" rel="floor-1" class="cur fhdb_a">
                    <i class="left_iconfont " display="block"><img src="/nn2/views/pc/images/floor_01.png">交易市场</i>
                    <em class="two_line" display="none"><img src="/nn2/views/pc/images/floor_cur_01.png">交易市场</em>
                </a>
                 <div class="hover_div">
                    <em></em>
                    <a href="" data="#toTop" rel="toTop" class="hove_a">交易市场</a>
                </div>
              </div>
              <div class="show_div">
              <a href="#floor-2" data="#floor-2" rel="floor-2" class="fhdb_a">
                  <i class="left_iconfont " display="none"><img src="/nn2/views/pc/images/floor_02.png">市场指数</i>
                  <em class="two_line" display="black"><img src="/nn2/views/pc/images/floor_cur_02.png">市场指数</em>
              </a>
               <div class="hover_div">
                    <em></em>
                    <a href="" data="#toTop" rel="toTop" class="hove_a">市场指数</a>
                </div>
              </div>
              <div class="show_div">
              <a href="#floor-3" data="#floor-3" rel="floor-3" class="fhdb_a">
                  <i class="left_iconfont " display="none"><img src="/nn2/views/pc/images/floor_030.png">推荐商家</i>
                  <em class="two_line" display="black"><img src="/nn2/views/pc/images/floor_cur_030.png">推荐商家</em>
              </a>
                <div class="hover_div">
                    <em></em>
                    <a href="" data="#toTop" rel="toTop" class="hove_a">推荐商家</a>
                </div>
              </div>
            <div class="show_div">
              <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=4006238086&aty=0&a=0&curl=&ty=1" target="_blank" data="#toTop" rel="floor-4" style="margin-top:7px;" class="cur fhdb_a">
                  <i class="left_iconfont " display="none"><img src="/nn2/views/pc/images/floor_04.png">客服</i>
                  <em class="two_line" display="black"><img src="/nn2/views/pc/images/floor_cur_04.png">客服</em>
              </a>
               <div class="hover_div">
                    <em></em>
                    <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=4006238086&aty=0&a=0&curl=&ty=1" target="_blank" data="#toTop" rel="toTop" class="hove_a">联系客服</a>
                </div>
            </div>
            <div class="show_div">
                  <a href="" class="fhdb_a" data="#toTop" rel="toTop">
                      <i class="left_iconfont " display="none"><img src="/nn2/views/pc/images/floor_05.png">返回顶部</i>
                      <em class="two_line" display="black"><img src="/nn2/views/pc/images/floor_cur_05.png">返回顶部</em>
                  </a>
                <div class="hover_div">
                    <em></em>
                    <a href="" data="#toTop" rel="toTop" class="hove_a">返回顶部</a>
                </div>
            </div>

        </div>
        <!-- 浮动楼层 end -->
<script type='text/html' id='offerRowTemplate'>
 <%if (data.length>0) { %>
<%for (var i=0;i<data.length;i++) { %>
        <li>
            <span class="i_w_1 "><%=data[i].pname%></span>
            <%if (data[i].type==1) { %>
                <span class="i_w_2 i_TextGreen">
                   供
                </span>
            <%}else { %>
                <span class="i_w_2 i_TextRed">
                   求
                </span>
            <% } %>
            <span class="i_w_3">
                  <%=data[i].mode%>
            </span>
            <span class="i_w_4" id="area<%=i%>">
				 <%if (data[i].produce_area) { %>
				<%=getAreaText(data[i].produce_area)%>
				 <%}else { %>
				 未知
				<% } %>
			</span>
            <span class="i_w_5"><%=data[i].accept_area%></span>
            <span class="i_w_6"><%=data[i].quantity%></span>
            <span class="i_w_7"><%=data[i].quantity-data[i].sell-data[i].freeze%></span>
            <span class="i_w_8">￥<%=data[i].price%></span>
            <span class="i_w_9">
                <%if (data[i].qq) { %>
                    <a href="tencent://message/?uin=<%=data[i].qq%>&Site=qq&Menu=yes"><img style="vertical-align:middle;" src="/nn2/views/pc/images/icon/QQ16X16.png" class="ser_img" alt="联系客服"/>
                    </a>
                        <%}else { %>
                         <img style="vertical-align:middle;" src="/nn2/views/pc/images/icon/QQgray16X16.png" class="ser_img"/>
                    </a>

                <% } %>
</span>


            <span class="i_w_10">
                <%if (data[i].quantity - data[i].sell - data[i].freeze>0) { %>
                    <%if (data[i].type==1) { %>
                        <a class="<%=data[i].id%>" href="http://localhost/nn2/offers/offerdetails/id/<%==data[i].id%>/pid/<%=data[i].product_id%>">
                            <img class="ckxq" src="/nn2/views/pc/images/icon/ico_sc1.png" class="ser_img" alt="查看详情"/>
                        </a>
                     <a href="http://localhost/nn2/trade/check/id/<%=data[i].id%>/pid/<%=data[i].product_id%>">
                         <img src="/nn2/views/pc/images/icon/ico_sc3.png" class="ser_img" alt="下单"/>
                     </a>
                    <%}else { %>
                        <a href="http://localhost/nn2/offers/purchasedetails/id/<%=data[i].id%>">
                            <img src="/nn2/views/pc/images/icon/ico_sc1.png" class="ser_img" alt="查看详情"/>
                        </a>
                         <a href="http://localhost/nn2/trade/report/id/<%=data[i].id%>">
                              <img src="/nn2/views/pc/images/icon/ico_sc3.png" class="ser_img" alt="下单"/>
                        </a>
                    <% } %>
                    <%}else { %>
                <img src="/nn2/views/pc/images/icon/bg_ycj.png" class="ser_img_1"/>
                <% } %>
                </span>
        </li>
<% } %>
<% } %>
</script>


<!--公用底部控件 开始-->
<!--公用底部控件 开始-->
<link href="/nn2/views/pc/css/footer.css" rel="stylesheet" type="text/css">
<div id="footer">



    <div class="footer_link clearfix">
        <div class="foter_width">
            <ul>
                <?php if(!empty($helpList2)) foreach($helpList2 as $key => $item){?>
                    <li class="footer_li">
                        <a class="fotter_div" target="_blank"><b><?php echo isset($item['name'])?$item['name']:"";?></b></a>
                        <?php if(!empty($item['data'])) foreach($item['data'] as $k => $v){?>
                            <?php if($v['link']){?>
                                <a class="fotter_a" href="<?php echo isset($v['link'])?$v['link']:"";?>" target="_blank"><?php echo isset($v['name'])?$v['name']:"";?></a>

                            <?php }else{?>
                                <a class="fotter_a" href="http://localhost/nn2/help/help?cat_id=<?php echo isset($v['cat_id'])?$v['cat_id']:"";?>&id=<?php echo isset($v['id'])?$v['id']:"";?>" target="_blank"><?php echo isset($v['name'])?$v['name']:"";?></a>

                            <?php }?>
                         <?php }?>
                    </li>
                <?php }?>

            </ul>
            <ul class="ewm_ul">
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注耐火频道</b></div>
                    <div><img src="/nn2/views/pc/images/index/a_naih.png"></div>
                </li>
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注耐耐网</b></div>
                    <div><img src="/nn2/views/pc/images/index/a_nain.png"></div>
                </li>
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注建材频道</b></div>
                    <div><img src="/nn2/views/pc/images/index/a_jianc.png"></div>
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