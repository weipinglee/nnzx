<link href="{views:css/user_index.css}" rel="stylesheet" type="text/css" />
<link href="{views:css/font-awesome.min.css}" rel="stylesheet" type="text/css" />
<link href="{views:css/pay_ment.css}" rel="stylesheet" type="text/css" /> 
<script src="{views:js/pay_ment.js}" type="text/javascript"></script>
<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{views:js/upload.js}"></script>
			<!--start中间内容-->	
			<div class="user_c_list no_bor">
				<div class="user_zhxi">


					
                   <div class="checkim">
                       <h2>确认线下凭证</h2>


                       <table class="detail_tab" border="1" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr class="detail_title">
                          <td colspan="10"><strong>订单详情</strong></td>
                        </tr>
                        <tr style="line-height: 30px;">
                          <td style="background-color: #F7F7F7;" width="100px">订单号</td>
                          <td colspan="3" width="230px">{$data['order_no']}</td>
                          <td style="background-color: #F7F7F7;" width="100px">订单日期</td>
                          <td colspan="5" width="230px">{$data['create_time']}</td>
                        </tr>
                        <tr>
                          <td style="background-color: #F7F7F7; padding-top: 5px;" valign="top" width="100px">商品信息</td>
                          <td colspan="10" style="padding-left: 0px;">
                              <table style="line-height: 30px;" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody><tr style="border-bottom:1px dashed #BFBFBF;">
                                  <td width="240px">品名</td>
                                  <!-- <td width="130px">生产厂家</td> -->
                                  <td width="120px">仓库</td>
                                  <td width="100px">单价</td>
                                  <td width="100px">单位</td>
                                  <td width="100px">重量</td>
                                  <td width="100px">小计</td>
                                  <td width="100px">手续费</td>
                                </tr>

                                
                                <tr>
                                  <td>{$data['name']}</td>
                               <!--   <td></td> --> 
                                  <td>{$data['store_name']}</td>
                                  <td>
                                          <label class="" id="d_price_1">
                                            ￥  {$data['price']}
                                          </label>
                                  </td>
                                  <td>
                                      {$data['unit']}
                              </td>
                                  <td>{$data['num']}</td>
                                  <td><label class="">
                              
                                  <label class="price02">￥</label>
                                  <label class="" id="d_sum_money_1">
                                      {$data['amount']}
                                  </label>
                              
                              
                              </label></td>
                              <td><label class="">
                              
                                  <label class="price02">￥</label>
                                  <label class="" id="d_sum_comm_1">
                                      0.00
                                  </label>
                              </label></td>
                                </tr>  
                                 
                              </tbody></table>
                      </td>
                    </tr>
                    <tr style="line-height: 35px;">
                      <td style="background-color: #F7F7F7;" width="100px">合同</td>
                      <td colspan="3" width=""><a href="{url:/contract/contract?order_id=$data['id']}" style="color:blue;" target='_blank'>合同预览</a></td>
                      <td style="background-color: #F7F7F7;" width="100px">合计金额</td>
                      <td colspan="1" width="">
                              <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                              <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                  {$data['amount']}
                              </span>   
                      </td>
                      {if:$data['show_deposit']}
                       <td style="background-color: #F7F7F7;" width="100px">已支付定金</td>
                      
                      <td colspan="1" width="">
                              <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                              <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                  {$data['pay_deposit']}
                              </span>   
                      </td>
                      {/if}
                      {if:$data['is_free'] != 1}
                      <td style="background-color: #F7F7F7;" width="100px">剩余尾款</td>
                      <td colspan="1" width="">
                              <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                              <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                  {$data['pay_retainage']}
                              </span>   
                      </td>
                      {/if}
                    </tr>
                  </tbody></table>
                          
                          <div class="pay_type">
                              <h3 class="add_zhifu">支付方式：</h3>
                              <h3 class="addwidth">
                                <div class="yListr" id="yListr" >
                                      <ul>
                                          <li>
                                            {if:$show_online}
                                            <em name="chooice" class="yListrclickem" payment='online'>线上支付<i></i></em> 

                                            <em name="chooice" payment='offline'>线下支付<i></i></em> 
                                            {else:}
                                              <em name="chooice" payment='offline' class="yListrclickem">线下支付<i></i></em> 
                                            {/if}
                                          </li>

                                      </ul>
                              </div> 

                        <script type="text/javascript">
                            $(function() {
                                $(".yListr ul li em").click(function() {
                                  var payment = $(this).attr('payment');
                                  $(this).addClass("yListrclickem").siblings().removeClass("yListrclickem");
                                  $('input[name=payment]').val(payment);
                                })
                            });
                        </script>
                       
                   <div id="bain_bo">
                   <div class="">
                        <ul>
                        	<li>凭证图片：</li>
                          <li><img src="{$data['proof_thumb']}"></li>
                        </ul>
                      
                    
                    </div>
                  </div>  
                            
                       </h3> 
                         </div>

                    <form action="{url:/Order/confirmProof}" method="post" auto_submit="1" redirect_url="{url:/contract/sellerdetail?id=$data['id']}" >
                        <input type="hidden" name="order_id" value="{$data['id']}" />
                        <div class="pay_bton">
                            <a href="javascript:void(0)" id='pay_retainage'  confirm="1" confirm_text="确认线下支付凭证无误？" >确认凭证</a>
                        </div>
                    </form>


                           </div>

               

				</div>				
				
			</div>
			<!--end中间内容-->


