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




    <script type="text/javascript" src="/nn2/views/pc/js/area/AreaData_min.js" ></script>
<script type="text/javascript" src="/nn2/views/pc/js/area/Area.js" ></script>
            <script src="/nn2/views/pc/js/roll.js"></script>
    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/roll.css">
    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/user_index.css">
    <!-- 轮播图end-->
<script type="text/javascript" src="/nn2/js/arttemplate/artTemplate.js"></script>
    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/product.css">
    <link rel="stylesheet" type="text/css" href="/nn2/views/pc/css/style_main.css">
        <style>
    .page_num {
      margin-top:  12px;
    }
  </style>

 <!------------------导航 开始-------------------->



                <input type="hidden" id="UserID">
                <!--主要内容 开始-->
                <div id="mainContent">
                    <div class="page_width">

           <div class="pro_classify">
            <!-- <div class="class_re">
                <h3>

                </h3>

                <div class="st_ext">

                </div>
            </div> -->
            <div class="clearfix cla_sty">
                <input type="hidden" name="attr_url" value="http://localhost/nn2/offers/ajaxgetcategory"  />
               <input type="hidden" name="sort" value="default" />
                <input type="hidden" name="img_url" value="/nn2/views/pc/"  />
            <div class="class_jy tlist_100" id="offer_type">
                <span class="jy_title ">交易类型：</span>
                <ul>
                    <li class="a_choose">
                        <a class='type' href="#" title="type" rel="0"> 不限</a>
                    </li>
                    <?php if(!empty($type)) foreach($type as $key => $item){?>
                    <li >
                        <a class='type' href="#" title="type" rel="<?php echo isset($key)?$key:"";?>"> <?php echo isset($item)?$item:"";?></a>
                    </li>
                    <?php }?>

                </ul>
            </div>
            <div class="class_jy tlist_1" id="offer_mode">
                <span class="jy_title">报盘类型：</span>
                <ul>
                    <li class="a_choose">
                        <a  class='model' href="#" title="model" rel="0"> 不限</a>
                    </li>
                    <?php if(!empty($mode)) foreach($mode as $key => $item){?>
                    <li <?php if( $key==0){?>class="a_choose"<?php }?>>
                        <a  class='model' href="#" title="model" rel="<?php echo isset($key)?$key:"";?>"> <?php echo isset($item)?$item:"";?></a>
                    </li>
                    <?php }?>


                </ul>
            </div>
             <?php if( !empty($cate)){?>

            <div class="class_jy" id="level1">
                <span class="jy_title">市场类型：</span>
                <ul>
                    <li value="0"  class="a_choose" ><a title="cate">不限</a></li>
                     <?php if(!empty($cate)) foreach($cate as $key => $item){?>
                    <li value="<?php echo isset($item['id'])?$item['id']:"";?>" ><a title="cate"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
                    <?php }?>
                </ul>


            </div>

            <?php }?>
        </div>
               <script  type='text/html' id='cateTemplate'>
                   <div class="class_jy" id="level1" >
                       <span class="jy_title"><%=childname%>：</span>
                       <ul>
                           <li value="0"  class="a_choose" ><a title="cate">不限</a></li>
                           <%for (var i=0;i<data.length;i++) { %>
                           <li value="<%=data[i].id%>"  ><a title="cate"><%=data[i].name%></a></li>
                           <% } %>
                       </ul>


                   </div>
               </script>


<!-- 分类 end -->
<!-- 产品 start -->
<div class="pro_main">
    <div class="pro_sort">
        <div class="sort_list">
            <a href="javascript:void(0)" class="curr sort"><input type="hidden" name="sort" value="default" />默认排序</a>
            <a href="javascript:void(0)" class="sort" rel="asc" ><input type="hidden" name="sort" value="price_asc" />商品单价<i></i></a>
            <a href="javascript:void(0)" class="sort" rel="asc"><input type="hidden" name="sort" value="time_asc" />发布时间<i></i></a>
            <a href="javascript:void(0)" class="" id="Place">商品产地</a>
        </div>
        <!-- 商品产地筛选 -->
        <div class="hit_point" style="text-align:left;">
            <ul>
                <li>
                    <b>华北</b><a href="javascript:void(0)" title="0">不限</a><a href="javascript:void(0)" title="11">北京</a><a href="javascript:void(0)" title="12">天津</a><a href="javascript:void(0)" title="13">河北</a><a href="javascript:void(0)" title="14">山西</a><a
                    href="javascript:void(0)" title="15" >内蒙古</a>
                </li>
                <li>
                    <b>华东</b><a href="javascript:void(0)" title="0">不限</a><a href="javascript:void(0)" title="31">上海</a><a href="javascript:void(0)" title="33">浙江</a><a href="javascript:void(0)" title="32" >江苏</a><a href="javascript:void(0)" title="34" >安徽</a>

                </li>

            </ul>
        </div>
        <script type="text/javascript">
            $("#Place").mouseover(function () {
                $(".hit_point").css("display", "block");
            });
            $("#Place").mouseout(function () {
                $(".hit_point").css("display", "none");
            });
            $(".hit_point").mouseover(function () {
                $(".hit_point").css("display", "block");
            });
            $(".hit_point").mouseout(function () {
                $(".hit_point").css("display", "none");
            });
        </script>
    </div>
    <div class="pro_cen">
        <ul class="main_title">
            <li class="tit_left">品名</li>
            <li>图片</li>
            <li>供求</li>
            <li>类型</li>
            <li style="width:200px;">产地</li>
            <li>交货地</li>

            <li>剩余</li>
            <li style="width:130px;">
                <!-- <a class="main_mr">默认</a><a class="main_px">从低到高<i class="arrow_color icon-arrow-up"></i></a> -->
                单价
            </li>

        </ul>
    </div>
    


        <!--广告 strat -->
    <?php if($login==0){?>
        <div class="pro_gg">
            <div class="tit_center">
                <p><span class="title_big"><a href="http://localhost/nn2/user/public/login/login"><u class="red">登录</u> </a>后可查看更多现货资源。</span><a href="http://localhost/nn2/user/public/login/register"><u class="red">点击这里免费注册</u></a>
                </p>
            </div>
        </div>
    <?php }?>
    <!--
        <div class="pro_gg">
            <div class="gg_img">
                <div class="gg_cen">
                    <textarea class="text" Placeholder="写下您的真实需求，包括规格、材质等，收到后我们会立即给您回电确认，剩下的交给我们吧。"></textarea><i
                    class="icon_type icon-search"></i><input class="sumit" type="submit" value="帮我找"/>
                </div>
            </div>
        </div>-->
        <!-- 广告 end -->
        <!-- 温馨提示 -->

        <div class="pro_gg">
        <input type='hidden' name='user_type' value="<?php echo isset($user_type)?$user_type:"";?>">
            <hr style="border:1px dashed #ccc;border-bottom:0;border-right:0;
            border-left:0;">
            <!--<p class="wx_tit"><b>温馨提示：</b>请您在交易前自行与资源发布者进行确认！耐耐网仅提供免费发布渠道，并不对资源发布作任何审查。使用资源单频道进行交易所存在的风险及产生的后果由您与发布者自行承担。
            </p>-->
        </div> </div> </div> </div>
        <!-- 温馨提示end-->

            <script src="/nn2/views/pc/js/product/attr.js"></script>
                  
           <script type="text/html" id="productTemplate">
               <% for(var i=0;i<data.length;i++){ %>
               <div class="pro_cen">
                   <ul class="main_centon">
                       <li class="tit_left">
                           <!--<a title="品质保证"><img class="pz_img" src="/nn2/views/pc/images/icon/icon_pz.png"></a>-->
                           <span><%=data[i].name%></span>
                       </li>
                       <li><a class="cz_wz pro_img"><img src="<% if(data[i].img == ''){ %>/nn2/views/pc/images/no_picture.png<% }else { %><%=data[i].img%> <%}%>" class="icon_img" width="30"></a></li>
                       <li><% if(data[i].type == 1){ %><i class="green">供</i><% }else { %><i class="red">求</i> <%}%></li>
                       <li><% if(data[i].type == 1){ %><%=data[i].mode_txt%><% }else { %>--<%}%></li>

                       <li style="width:200px;"><%=data[i].produce_area%></li>
                       <li><%=data[i].accept_area%></li>
                       <li><%=data[i].left%> (<%=data[i].unit%>)</li>
                       <li class="price_unit"><i class="qian_blue">
                               <% if(data[i].type == 1){ %>
                               ￥<%=data[i].price%>
                               <% }else { %>
                               ￥<%=data[i].price_l%> - ￥<%=data[i].price_r%>
                               <%}%>
                           </i>
                       </li>
                       <li class="toubao_rz">
                       <% if(data[i].insurance == 1){%>
                       <a title="已投保"><img class="icon_img" src="/nn2/views/pc/images/icon/icon_yb.png"/></a>
                       <% } else { %>
                       <a title="未投保"><img class="icon_img" src="/nn2/views/pc/images/icon/icon_wb.png"/></a>
                       <% }%>
                           <a title="认证"><img class="icon_img" src="/nn2/views/pc/images/icon/icon_rz.png"/></a>
                       </li>
                       <li class="but_left">
                           <div class="">
                               <div >
                               <% if (data[i].jiao==0){ %>
                                    <% if (data[i].qq){ %>
                                   <a href="tencent://message/?uin=<%=data[i].qq%>&Site=qq&Menu=yes"><img style="vertical-align:middle;" src="/nn2/views/pc/images/icon/QQ16X16.png" class="ser_img" alt="联系客服"/>
                                   </a>
                                     <% }else{%>
                                     <img style="vertical-align:middle;" src="/nn2/views/pc/images/icon/QQgray16X16.png" class="ser_img"/>
                                     <% }%>
                                   <% if (data[i].type==1){ %>
								                    
                                   <a href="http://localhost/nn2/offers/offerdetails/id/<%=data[i].id%>/pid/<%=data[i].product_id%>" ><img style="vertical-align:middle;" src="/nn2/views/pc/images/icon/ico_sc1.png" class="ser_img" alt="查看详情"/></a>
								   <a href="http://localhost/nn2/trade/check/id/<%=data[i].id%>/pid/<%=data[i].product_id%>" no_cert="<%=data[i].no_cert%>" info="<%=data[i].info%>" class="check_btn"><img style="vertical-align:middle;"  src="/nn2/views/pc/images/icon/ico_sc3.png" class="ser_img" alt="下单"/></a>
                                    <% } else { %>
									<a href="http://localhost/nn2/offers/purchasedetails/id/<%=data[i].id%>/pid/<%=data[i].product_id%>" ><img style="vertical-align:middle;"  src="/nn2/views/pc/images/icon/ico_sc1.png" class="ser_img" alt="查看详情"/></a>
								   <a href="http://localhost/nn2/trade/report/id/<%=data[i].id%>" no_cert="<%=data[i].no_cert%>" info="<%=data[i].info%>"  class='check_btn'><img style="vertical-align:middle;"  src="/nn2/views/pc/images/icon/ico_sc3.png" class="ser_img" alt="报价"/></a>
                                 
                                    
                                   <% }%>
                                   <% } else { %>
                                   <img style="vertical-align:middle;" src="/nn2/views/pc/images/icon/bg_ycj.png" class="ser_img_1"/>
                                   <% }%>
                               </div>
                               <ul>
                                   <li class="sele"><a class="cz_wz pro_img">图片</a></li>
                                   <li class="sele"><a class="cz_wz pro_kf"
                                                       href="http://wpa.qq.com/msgrd?v=1&uin=800022859&site=qq&menu=yes"
                                                       target="_blank">客服</a></li>
                               </ul>
                           </div>
                       </li>
                   </ul>
               </div>
               <% } %>
            </script>


    <script type="text/javascript">
        $(function(){
            
            <?php if(isset($cate_list) && !empty($cate_list)){?>
                 <?php if(!empty($cate_list)) foreach($cate_list as $key => $item){?>
                    $('[id^=level]').find('li[value=<?php echo isset($item)?$item:"";?>]').trigger('click');
                  <?php }?>

            <?php }else{?>
            var offer_type = '<?php echo isset($searchtype)?$searchtype:"";?>';
            if(offer_type!=0){
                $('#offer_type').find('.a_choose').removeClass('a_choose');
                $('#offer_type').find('a[rel='+offer_type+']').parent('li').addClass('a_choose');
            }
            var content = '<?php echo isset($search)?$search:"";?>';
                 getCategory({'offertype':offer_type,'search':content});
            <?php }?>

        })
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