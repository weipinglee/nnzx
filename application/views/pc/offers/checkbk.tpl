
    <script type="text/javascript" defer="" async="" src="{views:js/uta.js}"></script>
    <script src="{views:js/gtxh_formlogin.js}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{views:css/index20141027.css}">
    <!-- <script src="{views:js/index20141027.js}" type="text/javascript"></script> -->
    <link rel="stylesheet" href="{views:css/classify.css}">
    <link rel="stylesheet" type="text/css" href="{views:css/submit_order.css}"/>
     <script type="text/javascript" src="{views:js/submit_order.js}"></script>

    <!------------------导航 开始-------------------->
    <form method="post" action="" id="form1">
        <div class="aspNetHidden">
        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="b7kHdN58Jsi2cPaAmmpEqXjSD5M7lilMmnUNdKzTkgYwpBrDsYEml4gvo/iOj8sf">
        </div>
    </form>


    <input type="hidden" id="UserID">
    <!--主要内容 开始-->
    <div id="mainContent" style="background:#FFF;"> 
    
    
    
    
    
        <div class="page_width">

            
            <!----第一行搜索  开始---->
            <div class="mainRow1">
                <!--搜索条件 开始-->
                    
            
 
            
              
             <!------------------订单 开始-------------------->
            <div class="submit">
             
             <div class="submit_word">
             <span>支付货款</span>
             <span>支付完成</span>
             </div>  
            <div class="submit_photo">
              <img src="{views:images/order/oder-1.jpg}" width="203" height="47" alt="第一步" />
              <img src="{views:images/order/oder-2.jpg}" width="205" height="47" alt="第二步" />
              </div> 

            <form method="post" pay_secret="1" auto_submit="1" action='{url:/trade/buyerPay}?callback={url:/offers/check?id=$data['id']&pid=$data['product_id']@deal}'>

            <div class="checkim">
            <h2>填写并核对订单信息<a id='contract_review' href="{url:/contract/contract?offer_id=$data['id']&num=$data['minimum']@user}" style="color:blue;">合同预览</a></h2>
                
                <!--清单开始-->
                <div class="clrarorder">
                 <span class="qingorder"><b class="shangpqd">商品信息</b><h3>


                     <div class="bezel_clear">
                         <div class="wor_clear">

                             <span class="goods">商品</span>
                             <span class="norms">规格</span>
                             <span class="number">数量(最小起订量：{$data['minimum']} 剩余:{$data['left']}) </span>
                            <span class="numunit">单位</span> 
                             <span class="amount">总额(元)</span>
                             <span class="price ">单价(元)</span>
                         </div>

                         <div class="module_clear">
                            
                             <a href="javascript:;"><img src="{$data['img']}" width="80" height="80" alt="产品"> </a>
                             <a href="javascript:;"><div class="clear_word">
                                 <h5>{$data['name']}</h5>
                             </div></a>
                             <span class="guige">
                                 {foreach:items=$data['attr_arr']}
                                     {$key}:{$item}</br>
                                 {/foreach}
                             </span>
                             <span class="shulag">
                                {if:$data['fixed']}
                                    {$data['minimum']}
                                    <input type="hidden" name="num" value="{$data['minimum']}"/>
                                {else:}
                                    <input type="text" name="num" value="{$data['minimum']}" width="20px" style="width:100px" />
                                {/if}
                              </span>
                             <span class="danwei">{$data['unit']}</span>
                             <span class="danjia"><b>￥</b>{$data['price']}</span>
                             <span class="jine"><i><b>￥</b><b class='prod_amount'>{$data['amount']}</b></i></span>

                         </div>


                     </div>



                 </h3>
            </span>
                    <hr class="bottor" color="#c8c8c8" size="2px" />
                </div>
                {if:$data['show_payment']}
                <!--清单结束-->
                <span class="zhiffs">
                    <b>支付方式</b>
                    <h3 class="addwidth">


                        <div class="yListr">

                           <ul>
                               <li><em class="yListrclickem" paytype='0'>订金支付<i></i></em> <em paytype='1'>全款支付<i></i></em></li>
                               
                           </ul>
                            <input type="hidden" name="paytype" value="0" />

                        </div>
                    </h3>
             
                </span>

                <span class="zhiffs">
                    <b>账户类型</b>
                    <h3 class="addwidth">

                        <div class="yListr">


                            <ul id="account_type">
                                <li><em class="yListrclickem" account='1'>代理账户<i></i></em>

                                    <em account='2' class="qianyue">签约账户<i></i></em></li>
                                <!-- <em account='3'>票据账户<i></i></em>-->

                            </ul>
                            <div class="bank_box" style="display:none;">
                                <h5>请选择银行:</h5>
                               <span>
                                <input name="zhifu" type="radio" value=""><img src="{views:images/order/bank_jh.png}"/>
                               </span>
                                <span>
                                <input name="zhifu" type="radio" value=""><img src="{views:images/order/bank_pa.png}"/>
                               </span>
                                <span>
                                <input name="zhifu" type="radio" value=""><img src="{views:images/order/bank_zx.png}"/>
                               </span>
                            </div>
                            <script>
                                $(function(){
                                    var arrAccount=$("#account_type li em");
                                    for(var i=0; i<arrAccount.length;i++){
                                        arrAccount[i].index=i;
                                        arrAccount[i].onclick=function(){
                                            if(this.index==1){
                                                $('.bank_box').show();
                                            }else{
                                                $('.bank_box').hide();
                                            }
                                        };
                                    };
                                });
                            </script>
                            <input type="hidden" name="account" value="1" />
                        </div>
                    </h3>

                 </span>
                 {/if}

                 <span class="zhiffs">
                    <b>是否开具发票</b>
                    <h3 class="addwidth">

                        <div class="yListr">

                            <ul>
                                <li><em  invoice='1'>开发票<i></i></em> <em invoice='2' class="yListrclickem">不开发票<i></i></em></li>
                            </ul>
                            <input type="hidden" name="invoice" value="2" />
                        </div>
                    </h3>

                 </span>
                <!-------------------------- -->
             
        
  
             <!-------------------发票信息-------------------->
              <hr color="#c8c8c8" size="2px" /> 

              
                </div>
            {if:$data['show_payment']}
           <span class="jiesim"><b>结算信息</b><h3>  </h3> </span>
            
            <span class="daizfji"><span class="zhifjin">待支付金额：</span><i>￥</i><b class='pay_deposit'>
               {$data['minimum_deposit']}

            </b></span>
            {/if}
               <input type="hidden" name="id" value="{$data['id']}" />

             <div class="order_comit">
             {if:$data['left'] == 0}
                <a style="display:block;padding: 8px 20px;background: gray;margin-top:20px;color:#fff;border-radius: 5px;font-size:16px;" href="javascript:;">已成交</a>
             {else:}
                 {if: $data['insurance'] == 0}
                   <!--  <a  style="display:block;padding: 8px 20px;background: gray;margin-top:20px;color:#fff;border-radius: 5px;font-size:16px;" href="{url: /Insurance/apply@user}?{set: echo http_build_query(array('id' => $data['id']))}" >申请保险</a> -->
                {/if}
                <a class="btoncomit" href="javascript:;" >确认支付</a>
             {/if}

            </div>
            </form>

             </div>
       <!------------------订单 结束-------------------->

            <script type="text/javascript">
                
                $(function(){
                    var num_input = $('input[name=num]');
                    var deposit_text = $('.pay_deposit');
                    var prod_amount = $('.prod_amount');
                    var left = parseFloat({$data['left']});
                    var quantity = parseFloat("{$data['quantity']}");
                    var minimum = parseFloat("{$data['minimum']}");
                    var divide = parseInt("{$data['divide']}");
                    var price = {$data['price']};
                    var minimum_deposit = {$data['minimum_deposit']};
                    var left_deposit = {$data['left_deposit']};
                    var temp_deposit = deposit_text.text();
                    var paytype = 0;

                    
                    $('input[name=num]').blur(function(){
                        var num = parseFloat(num_input.val());
                        var id = $('input[name=id]').val();
                        var flag = isnum_valid();
                        if(flag && {$data['show_payment']}){
                            $.post("{url:/Offers/payDepositCom}",{id:id,num:num,price:price},function(data){
                                
                                if(data.success == 1){
                                    var total = num*price;
                                    prod_amount.text(total.toFixed(2));
                                    deposit_text.text(paytype == 1 ? prod_amount.text(): data.info.toFixed(2));
                                    temp_deposit = data.info;
                                    $('#contract_review').attr('href',$('#contract_review').attr('href')+"/num/"+num);
                                }else{
                                    alert(data.info);
                                }
                            },"json");
                        }else{
                            var total = num*price;
                            prod_amount.text(total.toFixed(2));
                            $('#contract_review').attr('href',$('#contract_review').attr('href')+"/num/"+num);
                        }
                    });


                    $('.btoncomit').click(function(){
                        var flag = isnum_valid();
                        if(flag) {
                            $(this).parents('form').submit();
                        }


                    });

                    function isnum_valid(){
                        var flag = false;
                        var num = parseFloat(num_input.val());
                        if(divide == 0){
                            if(num != quantity){
                                alert('此商品不可拆分');
                            }else{
                                flag = true;
                            }
                        }else{
                            if(left>minimum) { //剩余量大于最小起订量
                                if (num < minimum) {
                                    num_input.val(minimum);
                                    deposit_text.text(paytype == 1 ? minimum * price : minimum_deposit);
                                    temp_deposit = minimum_deposit;
                                    prod_amount.text(minimum * price);
                                    alert('小于最小起订量');
                                }
                                else if (num > left) {
                                    num_input.val(left);
                                    deposit_text.text(paytype == 1 ? left * price : left_deposit);
                                    temp_deposit = left_deposit;
                                    prod_amount.text(left * price);
                                    alert('超出剩余数量');
                                } else {
                                    flag = true;
                                }
                            }
                            else if(num==left){
                                flag = true;
                            }
                        }
                        return flag;
                    }


                    $(".yListr ul li em").click(function() {
                         paytype = $(this).attr('paytype');
                         var account = $(this).attr('account');
                         var invoice = $(this).attr('invoice');
                         $(this).addClass("yListrclickem").siblings().removeClass("yListrclickem");
                         $(this).parents('ul').siblings('input[name=paytype]').val(paytype);
                         $(this).parents('ul').siblings('input[name=account]').val(account);
                         $(this).parents('ul').siblings('input[name=invoice]').val(invoice);
                         
                         if(paytype){
                             if(paytype == 1){
                                //全款
                                deposit_text.text(prod_amount.text());
                             }else{
                                deposit_text.text(temp_deposit);
                             }
                        }
                     })

                })
            </script>

       

