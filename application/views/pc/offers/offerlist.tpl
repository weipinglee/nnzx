    <script type="text/javascript" src="{views:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{views:js/area/Area.js}" ></script>
            <script src="{views:js/roll.js}"></script>
    <link rel="stylesheet" type="text/css" href="{views:css/roll.css}">
    <link rel="stylesheet" type="text/css" href="{views:css/user_index.css}">
    <!-- 轮播图end-->
<script type="text/javascript" src="{root:js/arttemplate/artTemplate.js}"></script>
    <link rel="stylesheet" type="text/css" href="{views:css/font-awesome.min.css}">

    <link rel="stylesheet" type="text/css" href="{views:css/product.css}">
    <link rel="stylesheet" type="text/css" href="{views:css/style_main.css}">
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
                <input type="hidden" name="attr_url" value="{url:/Offers/ajaxGetCategory}"  />
               <input type="hidden" name="sort" value="default" />
                <input type="hidden" name="img_url" value="{views:}"  />
            <div class="class_jy tlist_100" id="offer_type">
                <span class="jy_title ">交易类型：</span>
                <ul>
                    <li class="a_choose">
                        <a class='type' href="#" title="type" rel="0"> 不限</a>
                    </li>
                    {foreach: items=$type}
                    <li >
                        <a class='type' href="#" title="type" rel="{$key}"> {$item}</a>
                    </li>
                    {/foreach}

                </ul>
            </div>
            <div class="class_jy tlist_1" id="offer_mode">
                <span class="jy_title">报盘类型：</span>
                <ul>
                    <li class="a_choose">
                        <a  class='model' href="#" title="model" rel="0"> 不限</a>
                    </li>
                    {foreach: items=$mode}
                    <li {if: $key==0}class="a_choose"{/if}>
                        <a  class='model' href="#" title="model" rel="{$key}"> {$item}</a>
                    </li>
                    {/foreach}


                </ul>
            </div>
             {if: !empty($cate)}

            <div class="class_jy" id="level1">
                <span class="jy_title">市场类型：</span>
                <ul>
                    <li value="0"  class="a_choose" ><a title="cate">不限</a></li>
                     {foreach: items=$cate}
                    <li value="{$item['id']}" ><a title="cate">{$item['name']}</a></li>
                    {/foreach}
                </ul>


            </div>

            {/if}
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
    {if:$login==0}
        <div class="pro_gg">
            <div class="tit_center">
                <p><span class="title_big"><a href="{url:/login/login@user}"><u class="red">登录</u> </a>后可查看更多现货资源。</span><a href="{url:/login/register@user}"><u class="red">点击这里免费注册</u></a>
                </p>
            </div>
        </div>
    {/if}
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
        <input type='hidden' name='user_type' value="{$user_type}">
            <hr style="border:1px dashed #ccc;border-bottom:0;border-right:0;
            border-left:0;">
            <!--<p class="wx_tit"><b>温馨提示：</b>请您在交易前自行与资源发布者进行确认！耐耐网仅提供免费发布渠道，并不对资源发布作任何审查。使用资源单频道进行交易所存在的风险及产生的后果由您与发布者自行承担。
            </p>-->
        </div> </div> </div> </div>
        <!-- 温馨提示end-->

            <script src="{views:js/product/attr.js}"></script>
                  
           <script type="text/html" id="productTemplate">
               <% for(var i=0;i<data.length;i++){ %>
               <div class="pro_cen">
                   <ul class="main_centon">
                       <li class="tit_left">
                           <!--<a title="品质保证"><img class="pz_img" src="{views:images/icon/icon_pz.png}"></a>-->
                           <span><%=data[i].name%></span>
                       </li>
                       <li><a class="cz_wz pro_img"><img src="<% if(data[i].img == ''){ %>{views:images/no_picture.png}<% }else { %><%=data[i].img%> <%}%>" class="icon_img" width="30"></a></li>
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
                       <a title="已投保"><img class="icon_img" src="{views:images/icon/icon_yb.png}"/></a>
                       <% } else { %>
                       <a title="未投保"><img class="icon_img" src="{views:images/icon/icon_wb.png}"/></a>
                       <% }%>
                           <a title="认证"><img class="icon_img" src="{views:images/icon/icon_rz.png}"/></a>
                       </li>
                       <li class="but_left">
                           <div class="">
                               <div >
                               <% if (data[i].jiao==0){ %>
                                    <% if (data[i].qq){ %>
                                   <a href="tencent://message/?uin=<%=data[i].qq%>&Site=qq&Menu=yes"><img style="vertical-align:middle;" src="{views:images/icon/QQ16X16.png}" class="ser_img" alt="联系客服"/>
                                   </a>
                                     <% }else{%>
                                     <img style="vertical-align:middle;" src="{views:images/icon/QQgray16X16.png}" class="ser_img"/>
                                     <% }%>
                                   <% if (data[i].type==1){ %>
								                    
                                   <a href="{url:/Offers/offerdetails}/id/<%=data[i].id%>/pid/<%=data[i].product_id%>" ><img style="vertical-align:middle;" src="{views:images/icon/ico_sc1.png}" class="ser_img" alt="查看详情"/></a>
								   <a href="{url:/trade/check}/id/<%=data[i].id%>/pid/<%=data[i].product_id%>" no_cert="<%=data[i].no_cert%>" info="<%=data[i].info%>" class="check_btn"><img style="vertical-align:middle;"  src="{views:images/icon/ico_sc3.png}" class="ser_img" alt="下单"/></a>
                                    <% } else { %>
									<a href="{url:/Offers/purchaseDetails}/id/<%=data[i].id%>/pid/<%=data[i].product_id%>" ><img style="vertical-align:middle;"  src="{views:images/icon/ico_sc1.png}" class="ser_img" alt="查看详情"/></a>
								   <a href="{url:/trade/report}/id/<%=data[i].id%>" no_cert="<%=data[i].no_cert%>" info="<%=data[i].info%>"  class='check_btn'><img style="vertical-align:middle;"  src="{views:images/icon/ico_sc3.png}" class="ser_img" alt="报价"/></a>
                                 
                                    
                                   <% }%>
                                   <% } else { %>
                                   <img style="vertical-align:middle;" src="{views:images/icon/bg_ycj.png}" class="ser_img_1"/>
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
            
            {if:isset($cate_list) && !empty($cate_list)}
                 {foreach:items=$cate_list}
                    $('[id^=level]').find('li[value={$item}]').trigger('click');
                  {/foreach}

            {else:}
            var offer_type = '{$searchtype}';
            if(offer_type!=0){
                $('#offer_type').find('.a_choose').removeClass('a_choose');
                $('#offer_type').find('a[rel='+offer_type+']').parent('li').addClass('a_choose');
            }
            var content = '{$search}';
                 getCategory({'offertype':offer_type,'search':content});
            {/if}

        })
    </script>

