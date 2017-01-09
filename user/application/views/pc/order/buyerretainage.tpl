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
                       <h2>核对支付{if:$total_amount}全款{else:}尾款{/if}信息</h2>

                      
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
                                              ￥{$data['price']}
                                          </label>
                                  </td>
                                  <td>
                                      {$data['unit']}
                              </td>
                                  <td> {$data['num']}
                                     </td>
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
                      {if:$data['pay_deposit']}
                         <td style="background-color: #F7F7F7;" width="100px">已支付定金</td>
                        
                        <td colspan="1" width="">
                                <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                                <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                    {$data['pay_deposit']}
                                </span>   
                        </td>

                      <td style="background-color: #F7F7F7;" width="100px">剩余未支付</td>

                      <td colspan="1" width="">
                              <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                              <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                  {$data['topay_retainage']}
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
                                  $('.pay_bton span').each(function(){
                                    if($(this).is(':visible') || !$(this).attr('style')){
                                      $(this).hide();
                                      $(this).css({display:'none'});
                                    }else{
                                      $(this).show();
                                      $(this).css({display:'block'});
                                    }
                                  });
                                })
                            });
                        </script>
                       
                   <div id="bain_bo">

                   <form action="{url:/Order/buyerRetainage}" id='account_form' pay_secret="1" method="post" auto_submit enctype="multipart/form-data" redirect_url="{url:/contract/buyerdetail?id=$data['id']}">

                   {if:$show_online}
                   <div class="sty_online" style="display:block;">
                       <input type="hidden" value="{$data['id']}" name="order_id"/>
                       <input type="hidden" value="online" name="payment"/>
						      <label for=""><input name="account" type="radio" value="1" checked="true"/>市场代理账户</label>

						      <label for=""><input name="account" type="radio" value="2" />银行签约账户</label>
						      <!-- <label for=""><input name="account" type="radio" value="3" />票据账户</label> -->

                   </div>
                   {/if}
                   </form>
                   <form action="{url:/Order/buyerRetainage}" id='proof_form'  method="post" auto_submit enctype="multipart/form-data">
                   <div class="sty_offline" {if:!$show_online}style='display: block;'{/if}>
                    {if:$bankinfo['true_name'] && $bankinfo['bank_name'] && $bankinfo['card_no']}
                        <ul>
                        	<li>账户名称：{$bankinfo['true_name']}</li>
                        	<li>开户银行：{$bankinfo['bank_name']}</li>
                        	<li>银行账号：{$bankinfo['card_no']}</li>
                        	<li><span>上传支付凭证：</span>
                            <div id="preview"></div>
                          <div  class="up_img">
                              <img name="proof" src=""/>
                              <input type="hidden"  name="imgproof" value="" pattern="required" alt="请上传图片" />
                            </div><!--img name属性与上传控件id相同-->
            							<!-- <input class="uplod" type="file" name='proof' onchange="previewImage(this)" /> -->
                          <span class="input-file">选择文件<input type="file" name="proof" id="proof"  onchange="javascript:uploadImg(this);" style="width:70px;" /></span>
                          <input type="hidden" value="{$data['id']}" name="order_id"/>
                          <input type="hidden" value="offline" name="payment"/>
                          <input type="hidden" value="{url:/ucenter/upload}" name="uploadUrl"/>

                        	</li>
                        </ul>
                    {else:}
                        等待卖方开户
                    {/if}
                    </div>
                   </form> 
                  </div>  
                            
                       </h3> 
                         </div>
                  

                  <div class="pay_bton">
                  	<h5>待支付金额：<i>{$data['topay_retainage']}</i>元</h5>
                    {if:$show_online}
                  	  {if:!$data['pay_retainage'] && !$data['proof']}
                        <span style="display:block;"><a  href="javascript:;" id='pay_retainage'>立即支付尾款</a></span>
                        {else:}
                        已支付
                      {/if}
                    {/if}
                      <span {if:$show_online}style="display:none;"{/if}>
                        {if:$bankinfo['true_name'] && $bankinfo['bank_name'] && $bankinfo['card_no']}
                          {if:!($data['proof'] || $data['pay_retainage'])}
                            <a  href="javascript:;" id='pay_proof'>上传凭证</a>
                            {else:}
                          {/if}
                        {else:}
                          <a href="{url:/order/banckNotice?tar_id=$data['seller']}">通知卖方开户</a>
                        {/if}
                      </span>
                      
                  </div>
      

                           </div>


               

				</div>				
				
			</div>
			<!--end中间内容-->	

      <script type="text/javascript">
        $(function(){
          $('#pay_retainage').unbind('click').click(function(){
            $('#account_form').submit();
          });

          $('#pay_proof').unbind('click').click(function(){
            if($('input[name=payment]').val() == 'offline' && !$('input[name=imgproof]').val()){
              alert('请上传支付凭证');
              return false;
            }
            $('#proof_form').submit();
          });
          
        });
      </script>
					