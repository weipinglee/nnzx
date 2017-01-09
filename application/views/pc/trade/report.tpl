   <div class="toplog_bor">
    <div class="m_log w1200">
        <div class="logoimg_left">
            <div class="img_box"><img class="shouy" src="{views:images/password/logo.png}" id="btnImg"></div>
            <div class="word_box">报价单</div>
        </div>
         <div class="logoimg_right">
            <img class="shouy" src="{views:images/password/iphone.png}"> 
            <h3>服务热线：<b>400-6238-086</b></h3>
         </div>
        
    </div>
   </div> 
<div class="clearfix"></div>





<!------------------logo 结束-------------------->
   
     
    <!--主要内容 开始-->
    <div id="mainContent" style="background:#FFF;"> 
    
        <div class="page_width">
            
            <!----第一行搜索  开始---->
            <div class="mainRow1 sure">
                <!--搜索条件 开始-->

             <!------------------订单 开始-------------------->
            <div class="submit">
             
             <div class="submit_word">
               <h3>核对并填写报价</h3>
             </div>  
               
             <div class="order_form">
                 <table border="1">
                    <tr class="form_bor" height="50">
                    <th width="25%" bgcolor="#fafafa">产品详情</th>
                    <th width="15%" bgcolor="#fafafa">规格</th>
                    <th width="15%" bgcolor="#fafafa">单位</th>
                    <th width="15%" bgcolor="#fafafa">意向单价（元）</th>
                    <th width="15%" bgcolor="#fafafa">需求数量</th>
                    <th width="15%" bgcolor="#fafafa">买方</th>
                    </tr>
                    <tr class="form_infoma">
                    <td class="product_img" >
                        {foreach: items=$product['photos'] item=$v}
                            {if:$key==0}
                                <img src="{$v}" width="80" height="80" alt="产品" />
                            {/if}
                        {/foreach}
                        <div class="produ_left">
                         <p>
                             {foreach:items=$product['cate']}
                                 {if:$key!=0}
                                     {if:$key==1}
                                         {$item['name']}
                                     {else:}
                                         / {$item['name']}
                                     {/if}
                                 {/if}
                             {/foreach}
                         </p>
                         <p>{$product['product_name']}</p>
                        </div>

                    </td>
                    <td class="guige">
                        {foreach:items=$product['attr_arr']}
                            <p>{$key}:{$item}</p>
                         {/foreach}
                  </td>
                    <td>{$product['unit']}</td>
                    <td class="price"><i>￥</i><span>{$offer['price_l']}-{$offer['price_r']}</span></td>
                    <td>{$product['quantity']}</td>
                    <td>{$offer['username']['username']}</td>
                    </tr>
                </table>
             </div> 
            <form action="{url:/trade/doreport}?callback={url:/offers/report?id=$offer['id']}" auto_submit redirect_url="{url:/offers/offerlist}" method="post">
                <input type="hidden" name="id" value="{$offer['id']}">
                <div class="sheet_box">
                    <div>
                        <label for="">产地：</label>
                        <span id="areabox">
                        {area:}
                            </span>
                    </div>
                    <div>
                        <label for="">价格：</label><input type="text" datatype="*" name="price" /><span class="unit">元/{$product['unit']}</span>
                    </div>

                    {if:!empty($product['attribute'])}
                      {set:$attrs=array_keys($product['attribute'])}
                        {set:$i=0;}
                          {foreach: items=$product['attr_arr']}
                          <div>
                             <label for=""> {$key}：</label>
                             <input type="text" id="attr_value{$item}" datatype="*" name="attribute[{$attrs[$i]}]" class="required" />

                        </div>
                            {set:$i=$i+1;}
                          {/foreach}
                    {/if}

                </div>
                <div class="sunmit_btn"><a href="javascript:void(0)">提交</a></div>
                <script type="text/javascript">
                    $(function(){
                        $('.sunmit_btn a').click(function(){
                            if({$user_id} == 0){
                                window.location.href='{url:/login/login@user}'+'?callback='+window.location.href;
                            }else{
                                $(this).parents('form').submit();
                            }
                        });
                    });
                </script>
                </form>
            </div>
       </div> 
       </div>
   </div>






