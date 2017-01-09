<script type="text/javascript" src="{root:js/arttemplate/artTemplate.js}"></script>
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
    <link href="{views:css/nav.css}" rel="stylesheet" />
    <script src="{views:js/jquery.nav.js}" type="text/javascript"></script>
        <div id="inner">
            <div class="hot-event">
            {set:$count = count($indexSlide)}
                {foreach: items=$indexSlide}
                <div class="event-item" style="{if:$key==0}display: block;{else:}display:none;{/if}background:{$item['bgcolor']}">
                    <a target="_blank" href="javascript:;">
                        <img src="{$item['img']}" class="photo" style="width: 100%; height: 470px;margin:0 auto" alt="{$itme['name']}" />
                    </a>
                </div>
                {/foreach}
                <div class="switch-tab">
                    {foreach: items=$indexSlide}
                    {set:$key++}
                    <a href="javascript:;" onclick="return false;" {if:$key == 1} class="current"{/if}>{$key}</a>
                    {/foreach}
                </div>
            </div>
        </div>
        <script type="text/javascript">
             var _c = {$count};
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
               <p id="time_year" class="time_year">{$year}<br><span class="time_month">{$month}/{$day}</span></p>
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
                   <p class="data_content">{$offer_num}</p>
               </div>
               <img class="data_img" src="{views:images/icon/data-img_03.png}"/>
           </div>
           <div class="data-tit">                            
               <div class="data">
                   <p class="data_title">当前成交量</p>
                   <p class="data_content">{$order_num}</p>
               </div>
               <img class="data_img" src="{views:images/icon/data-img_06.png}"/>
           </div>
           <div class="data-tit">
               <div class="data">
                   <p class="data_title">昨日成交量</p>
                   <p class="data_content">{$order_num_yes}</p>
               </div>
               <img class="data_img" src="{views:images/icon/data-img_08.png}"/>
           </div>
           <div class="data-tit">
               <div class="data">
                   <p class="data_title">当前入驻商家</p>
                   <p class="data_content">{$all_user_num}位</p>
               </div>
               <img class="data_img" src="{views:images/icon/data-img_10.png}"/>
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
        <link rel="stylesheet" type="text/css" href="{views:css/style_main.css}">
                <!-- 中间内容 -->
                <div class="WebBox">
                   <!--人民币市场-->
                     <div class="i_market clearfix">

                    <div class="i_market_left" id="rmb_market">
                        <div id="floor-1" class="item"></div>

                        <div class="i_leftTit clearfix">
                            <div class="i_left_title" name="1" id="item1">交易市场</div>
                            <ul class="js_rep_offer">
                                {foreach:items=$topCat}
                                    <li class="{if:$key==0}li_select{/if}" onclick="showOffers({$item['id']},$(this))"><a href="javascript:void(0)"><em></em><span></span>{$item['name']}</a></li>

                                {/foreach}
                       <!--         <li class="li_select" onclick="showOffers(1,$(this))"><a href="javascript:void(0)"><em></em><span></span>冶金化工市场</a></li>
                            </ul> -->
                            </ul>
                          <span class="i_more"><a rel="{url:/offers/offerlist}" href="{url:/offers/offerlist}">更多&gt;&gt;</a></span>  
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
                           <link rel="stylesheet" href="{views:css/swiper.min.css}">
                            <script src="{views:js/jquery.bxslider.js}"></script>
                           <div style="width:100%;height:1px;background:#ccc;margin:10px 0;"></div>
                             <div class="slider4">
                                 {foreach: items=$adList}
                                  <div class="slide"><img src="{$item['content']}" /></div>
                                 {/foreach}
                                </div>
                        </div>

                    </div>

                    <!--大家都在做什么-->
                    <div class="i_market_right">

                        <div class="iConWrap index_height">
                            <div class="iConTitle">最新交易</div>
                            <div class="items_container yichi">
                                <ul style="top: 0px;">
                                    {foreach:items=$newTrade}
                                        <li style="opacity: 1.0000000000000007;">
                                            {set:$time=date('m-d',strtotime($item['create_time']))}
                                            {if: ! empty($item['username'])}
                                            {set:$userName=mb_substr($item['username'],0,4,'utf-8')}
                                            <i>{$userName}****</i>
                                            {else:}
                                            <i>****</i>
                                            {/if}
                                            {if:$item['type']==1}
                                                <em class="red">售出</em>
                                            {else:}
                                                <em class="green">采购</em>
                                            {/if}
                                            <b>{$item['name']}{$item['num']}{$item['unit']}</b>
                                            <span>{$time}</span>
                                            <div class="titles"> <i></i>
                                              <p>{$item['name']}{$item['num']}{$item['unit']}</p>
                                            </div>
                                        </li>


                                    {/foreach}

                                </ul>
                            </div>
                        </div>

                    </div>

                </div>    
                <div class="guanimg">{echo: \Library\Ad::show("首页1")}</div>

                    <!--美金市场-->
                    <div class="i_market clearfix">
                        <div class="i_market_left" id="rmb_market">
                            <div id="floor-2" class="item"></div>
                            <div class="i_leftTit i_leftTit_bg clearfix">
                                <div class="i_left_title " name="1" id="item2">市场指数</div>
                                <ul>
                                    <ul>
                                        {foreach:items=$topCat}
                                            <li {if:$key==0}class='li_select'{/if} onclick="statistics({$item['id']},this)" ><a attr="{$item['id']}"href="javascript:void(0)"><em class="em2"></em><span></span>{$item['name']}</a></li>

                                        {/foreach}
                                    </ul>
                                </ul>
                                            
                            </div>
                            {set: $first_cat_id=$topCat[0]['id']}
                            <script src="https://code.highcharts.com/highcharts.js"></script>
                            <script src="https://code.highcharts.com/modules/exporting.js"></script>
                            <script language="javascript" type="text/javascript">
                                $(function(){
                                    var cat_id={$first_cat_id};
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
                                    var statisList={$statcCatList};
                                    var categories={$statcTime};
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
                                            href:'{url:/index/index}'
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
                                    <div class="img_pro"><img src="{views:images/index/zhibiao.jpg}"></div>
                                </div>
                                <div class="i_proList i_proList_zhishu">
                                    <div class="img_pro"><img src="{views:images/index/zhibiao.jpg}"></div>
                                </div>
                                <div class="i_proList i_proList_zhishu">
                                    <div class="img_pro"><img src="{views:images/index/zhibiao.jpg}"></div>
                                </div>
                                <div class="i_proList i_proList_zhishu">
                                    <div class="img_pro"><img src="{views:images/index/zhibiao.jpg}"></div>
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
                                    {foreach: items=$statcProList}
                                    <div class="ShopPro_item clearfix">
                                        <span class="ShopPro_text">{$item['name']}</a></span>
                                        <span class="ShopPro_change i_TextRed"><img class="shja" {if:$item['change_range'] == 0}src="{views:images/index/icon_line.png}"{elseif:abs($item['change_range']) <> $item['change_range']}src="{views:images/index/icon_down.png}"{else:}src="{views:images/index/icon_top.png}"{/if}/>{echo:abs($item['change_range'])}%</span>
                                        <span class="ShopPro_price i_TextRed">￥{$item['price']}</span>
                                        <div class='titles hot'>   <i></i>
                                          <p>
                                                {$item['name']}
                                            </p></div>
                                    </div>
                                    {/foreach}
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
                                 {foreach: items=$allCompanyAd}
                                <div class="slide"><img src="{$item['content']}"></div>
                                 {/foreach}

                                
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
                                        {foreach:items=$creditMember}
                                            <li class="rank_list">
                                            <span class="i_r_1">{if:$key==0}
                                                    <img src="{views:images/rank_06.png}">

                                                                {elseif:$key==1}
                                                    <img src="{views:images/rank_13.png}">

                                                                {elseif:$key==2}
                                                    <img src="{views:images/rank_16.png}">

                                                {else:}
                                                    {echo:$key+1}
                                                {/if}


                                            </span>
                                                <span class="i_r_2">{echo:mb_substr($item['company_name'],0,5,'utf-8')}</span>
                                                <span class="i_r_4"><img style="margin-top: -17px;" src="{$item['icon']}"></span>
                                                <span class="i_r_5">{$item['credit']}</span>
                                            </li>
                                        {/foreach}


                                    </ul>
                                </div>
                            </div>
                                        
                        </div>

                    </div>
                   

                </div>

                <!-- //中间内容 -->

                            <!--//通用底部-->
            <!-- 最新交易js -->
            <script type="text/javascript" src="{views:js/script-2-AQTnlOGb8Z1ylR8UZZJBEg.js}"></script>
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
					var offerData = {$offerCateList};
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
                        {foreach:items=$fuwuList}
                            <li class="iServiceTit">
                                <div class="fw_img"><img src="{echo:\Library\Thumb::get($item['img'])}" onerror="{views:images/index/kongbai.png}"/></div>
                                <div class="wi_fw"><a href="{url:help/help}?cat_id={$item['cat_id']}&id={$item['id']}">{$item['name']}</a></div>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
            <div class="div_flink">
                <ul>
                    <li class="ul_tit"><b>友情链接</b></li>
                    {set: $sum=count($frdLinkList)}
                    <ul class="lin_lists">
                    {foreach: items=$frdLinkList}
                        <li class="li_txt">
                            <a class="li_a" href="{$item['link']}" target="_blank">{$item['name']}</a>
                        </li>
                        {if:$key!=$sum-1}
                            <li class="li_l">
                                <span class="span_l">|</span>
                            </li>    
                        {/if}
                    {/foreach}
                    </ul> 
                </ul>
            </div>
        </div>


        <!-- 浮动楼层 -->
<link rel="stylesheet" type="text/css" href="{views:css/global_site_index_new.css}">
<div class="floor_left_box" id="floornav" data-tpa="YHD_HOMEPAGE_FLOORNAV" style="display: block;">
              <div class="show_div">
                <a href="#floor-1" data="#floor-1" rel="floor-1" class="cur fhdb_a">
                    <i class="left_iconfont " display="block"><img src="{views:images/floor_01.png}">交易市场</i>
                    <em class="two_line" display="none"><img src="{views:images/floor_cur_01.png}">交易市场</em>
                </a>
                 <div class="hover_div">
                    <em></em>
                    <a href="" data="#toTop" rel="toTop" class="hove_a">交易市场</a>
                </div>
              </div>
              <div class="show_div">
              <a href="#floor-2" data="#floor-2" rel="floor-2" class="fhdb_a">
                  <i class="left_iconfont " display="none"><img src="{views:images/floor_02.png}">市场指数</i>
                  <em class="two_line" display="black"><img src="{views:images/floor_cur_02.png}">市场指数</em>
              </a>
               <div class="hover_div">
                    <em></em>
                    <a href="" data="#toTop" rel="toTop" class="hove_a">市场指数</a>
                </div>
              </div>
              <div class="show_div">
              <a href="#floor-3" data="#floor-3" rel="floor-3" class="fhdb_a">
                  <i class="left_iconfont " display="none"><img src="{views:images/floor_030.png}">推荐商家</i>
                  <em class="two_line" display="black"><img src="{views:images/floor_cur_030.png}">推荐商家</em>
              </a>
                <div class="hover_div">
                    <em></em>
                    <a href="" data="#toTop" rel="toTop" class="hove_a">推荐商家</a>
                </div>
              </div>
            <div class="show_div">
              <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=4006238086&aty=0&a=0&curl=&ty=1" target="_blank" data="#toTop" rel="floor-4" style="margin-top:7px;" class="cur fhdb_a">
                  <i class="left_iconfont " display="none"><img src="{views:images/floor_04.png}">客服</i>
                  <em class="two_line" display="black"><img src="{views:images/floor_cur_04.png}">客服</em>
              </a>
               <div class="hover_div">
                    <em></em>
                    <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=4006238086&aty=0&a=0&curl=&ty=1" target="_blank" data="#toTop" rel="toTop" class="hove_a">联系客服</a>
                </div>
            </div>
            <div class="show_div">
                  <a href="" class="fhdb_a" data="#toTop" rel="toTop">
                      <i class="left_iconfont " display="none"><img src="{views:images/floor_05.png}">返回顶部</i>
                      <em class="two_line" display="black"><img src="{views:images/floor_cur_05.png}">返回顶部</em>
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
                    <a href="tencent://message/?uin=<%=data[i].qq%>&Site=qq&Menu=yes"><img style="vertical-align:middle;" src="{views:images/icon/QQ16X16.png}" class="ser_img" alt="联系客服"/>
                    </a>
                        <%}else { %>
                         <img style="vertical-align:middle;" src="{views:images/icon/QQgray16X16.png}" class="ser_img"/>
                    </a>

                <% } %>
</span>


            <span class="i_w_10">
                <%if (data[i].quantity - data[i].sell - data[i].freeze>0) { %>
                    <%if (data[i].type==1) { %>
                        <a class="<%=data[i].id%>" href="{url:/offers/offerdetails}/id/<%==data[i].id%>/pid/<%=data[i].product_id%>">
                            <img class="ckxq" src="{views:images/icon/ico_sc1.png}" class="ser_img" alt="查看详情"/>
                        </a>
                     <a href="{url:/trade/check}/id/<%=data[i].id%>/pid/<%=data[i].product_id%>">
                         <img src="{views:images/icon/ico_sc3.png}" class="ser_img" alt="下单"/>
                     </a>
                    <%}else { %>
                        <a href="{url:/offers/purchasedetails}/id/<%=data[i].id%>">
                            <img src="{views:images/icon/ico_sc1.png}" class="ser_img" alt="查看详情"/>
                        </a>
                         <a href="{url:/trade/report}/id/<%=data[i].id%>">
                              <img src="{views:images/icon/ico_sc3.png}" class="ser_img" alt="下单"/>
                        </a>
                    <% } %>
                    <%}else { %>
                <img src="{views:images/icon/bg_ycj.png}" class="ser_img_1"/>
                <% } %>
                </span>
        </li>
<% } %>
<% } %>
</script>
