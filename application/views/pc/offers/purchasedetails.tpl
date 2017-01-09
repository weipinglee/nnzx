<link rel="stylesheet" type="text/css" href="{views:css/offer_ask.css}"/>
<link href="{views:css/pro_show.css}" rel="stylesheet">
<link href="{views:css/tender_con.css}" rel="stylesheet">
<script src="{views:js/product/attr.js}"></script>
    <!--主要内容 开始-->
    <div id="mainContent">
        <div class="page_width">
            <!-- 未登录招标内容start -->
           <div class="tender_content">
                <div class="tender_top">
                    <b>我的位置：</b><span>现货大厅> </span>  <span>商品详情</span>
                </div>


     <!-- content start -->
            <div class="offer_content">
                
                <div class="offer_left">
                    <ul>
                        <li><h3>
                                {foreach:items=$data['cate']}
                                    {$item['name']}

                                {/foreach}
                                {$data['product_name']}
                            </h3>
                        </li>
                        <li> 产地：<i><span id="areatext">{areatext:data=$data['produce_area'] id=areatext }</span></i></li>
                        <li>买方：<i>{$user['company_name']}</i></li>
                        <li>发布时间：<i>{$data['apply_time']}</i></li>
                        <li>截止时间：<i>{$data['expire_time']}</i></li>
                    </ul>
                    {if:!empty($kefu)}
                    <div class="link_style">
                        <h5><a href="tencent://message/?uin={$kefu['qq']}&Site=qq&Menu=yes"><img src="{views:images/order/bj_kefu.png}" alt="" /><span>联系客服</span></a></h5>
                        <!-- <h5><a href=""><img src="images/order/bj_shouc.png" alt="" /><span>收藏产品</span></a></h5> -->
                    </div>
                    {/if}

        <input type='hidden' name='user_type' value="{$user_type}">
                </div>
                <div class="offer_right">
                    <ul>
                        <li>意向价：<b> {$data['price_l']}~{$data['price_r']}</b>元/ {$data['unit']} <span class="qianse">（含税）</span></li>
                        <li>需求量： <i>{$data['quantity']}</i>  {$data['unit']}</li>
                    </ul>

                  <!--  <div class="counter">
                    <input id="min" name="" type="button" value="-" disabled="disabled">  
                    <input id="text_box" name="" type="text" value="1">  
                    <input id="add" name="" type="button" value="+">  
                  </div> -->
                  
                    <div class="buy_btn baoj">
                        <a href="#" id='buy_now' onclick="report('{url:/trade/report?id=$data['id']}')" ><i><img src="{views:images/order/bj_gm.png}" alt="" /></i><b>立即报价</b></a>
                    </div>
                    <script type="text/javascript">
                        $(function(){
                            if({$no_cert} == '1'){
                                
                                $('#buy_now').attr('href','javascript:;').attr('onclick','#').unbind('click').click(function(){
                                    layer.msg('您的资质不完善,不能进行报价');
                                    
                                    return false;
                                });
                            }
                        });
                    </script>
                </div>
                <div style="clear:both;"></div>
                <div class="cont_1">
                    <h5 class="tit"><i><img src="{views:images/pro_show_03.jpg}"></i><span>产品参数</span></h5>
                    <table>
                        <tr>                <th colspan="2">商品明细</th>            </tr>
                        <tr>
                            <td>品名</td>
                            <td>{$data['product_name']}</td>
                        </tr>

                        <tr>
                            <td>产地</td>
                            <td><span id="area">{areatext:data=$data['produce_area'] id=area }</span></td>
                        </tr>
                        {foreach:items=$data['attr_arr']}
                        <tr>
                            <td>{$key}</td>
                            <td>{$item}</td>
                        </tr>
                        {/foreach}

                        <tr>
                            <th colspan="2">报盘详情</th>
                        </tr>
                        <tr>
                            <td>报盘类型</td>
                            <td>采购报盘</td>
                        </tr>
                        <tr>
                            <td>交易方式</td>
                            <td>买盘</td>
                        </tr>
                        <tr>
                            <td>是否投保</td>
                            <td>不限</td>
                        </tr>
                        <tr>
                            <td>计重方式</td>
                            <td>理论计值</td>
                        </tr>
                        <tr>
                            <td>可否拆分</td>
                            <td>不可</td>
                        </tr>
                        <tr>
                            <td>报盘数量</td>
                            <td>{$data['quantity']}{$data['unit']}</td>
                        </tr>

                        <tr>
                            <td>商品单价</td>
                            <td>{$data['price_l']}~{$data['price_r']}/{$data['unit']}</td>
                        </tr>
                        <tr>
                            <th colspan="2">交收详情</th>
                        </tr>
                        <tr>
                            <td>交收时间</td>
                            <td>成交后顺延{$data['accept_day']}天开始交收</td>
                        </tr>
                        <tr>
                            <td>交收地点</td>
                            <td>{$data['accept_area']}</td>
                        </tr>

                        <tr>
                            <td>有效期</td>
                            <td>{$data['expire_time']}</td>
                        </tr>
                         <tr>
                            <td>产品描述</td>
                            <td>{$data['note']}</td>
                        </tr>
                    </table>
<!-- 
                    <h5 class="tit"><i><img src="{views:images/pro_show_04.jpg}"></i><span>质量标准</span></h5>
                    <table style="width:100%;">

                       
                    </table> -->
                     <link href="{views:css/product_pic.css}" rel="stylesheet">
                                    <script src="{views:js/pic.js}"></script>


                     <h5 class="tit"><i><img src="{views:images/pro_show_05.jpg}"></i><span>商品图片</span></h5>
                    

                                                <div id="slider">
                                                      {foreach:items=$data['origphotos']}
                                                            <div class="spic">
                                                                <img src="{$item}" />
                                                            </div>  
                                                      {/if}
                                                </div>  


                                        
                                    <script type="text/javascript">  
                                            $(document).ready(function() {
                                            $('#slider').slider({ speed: 500 });
                                            var length=$("#slider img").size();
                                            if(length-1>4){
                                                $(".image-slider-back").css("display","block");
                                                $(".image-slider-forward").css("display","block");
                                            }else{              
                                                $(".image-slider-back").css("display","none");
                                                $(".image-slider-forward").css("display","none");
                                            }
                                            });
                                        </script> 

      <!-- content end -->


               
           </div>
