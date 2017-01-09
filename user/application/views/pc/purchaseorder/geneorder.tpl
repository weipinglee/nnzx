
<link href="{views:css/pay_ment.css}" rel="stylesheet" type="text/css" />
<script src="{views:js/pay_ment.js}" type="text/javascript"></script>
<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{views:js/upload.js}"></script>
			<!--start中间内容-->	
			<div class="user_c_list no_bor">
				<div class="user_zhxi">
                   <div class="checkim">
                       <h2>支付采购定金</h2>


                       <table class="detail_tab" border="1" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr class="detail_title">
                          <td colspan="10"><strong>报价详情</strong></td>
                        </tr>
                        <tr style="line-height: 30px;">
                          <td style="background-color: #F7F7F7;" width="100px">报价号</td>
                          <td colspan="1" width="230px">{$data['id']}</td>
                          <td style="background-color: #F7F7F7;" width="100px">报价人</td>
                          <td colspan="1" width="230px">{$data['username']}</td>
                          <td style="background-color: #F7F7F7;" width="100px">报价日期</td>
                          <td colspan="5" width="230px">{$data['create_time']}</td>
                        </tr>
                        <tr>
                          <td style="background-color: #F7F7F7; padding-top: 5px;" valign="top" width="100px">商品信息</td>
                          <td colspan="10" style="padding-left: 0px;">
                              <table style="line-height: 30px;" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody><tr style="border-bottom:1px dashed #BFBFBF;">
                                  <td width="240px">品名</td>
                                  <!-- <td width="130px">生产厂家</td> -->
                                  <td width="120px">分类</td>
                                  <td width="280px">规格</td>
                                  <td width="100px">单价</td>
                                  <td width="100px">重量</td>
                                  <td width="100px">小计</td>
                                  <td width="100px">手续费</td>
                                </tr>

                                
                                <tr>
                                  <td>{$data['product_name']}</td>
                               <!--   <td></td> --> 
                                  <td>{$data['cate']}</td>
                                  <td>{$data['attr_txt']}</td>
                                  <td>
                                          <label class="" id="d_price_1">
                                              {$data['price']} 
                                          </label> 元
                                  </td>
                                  <td>{$data['quantity']}
                                  吨</td>
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
                      <!-- <td colspan="3" width=""><a href="javascript:;" style="color:blue;" target=_blank>合同预览</a></td> -->
                      <td style="background-color: #F7F7F7;" width="100px">合计金额</td>
                      <td colspan="2" width="">
                              <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                              <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                  {$data['amount']}
                              </span>   
                      </td>
                       <td style="background-color: #F7F7F7;" width="100px">定金数额</td>
                      <td colspan="2" width="">
                              <span class="orange price02" style="font-size:18px; text-decoration: none; list-style: none;">￥</span>
                              <span class="orange" style="font-size:18px; text-decoration: none; list-style: none;" id="b_o_q">
                                  {$data['deposit']}
                              </span>   
                      </td>

                     
                    </tr>
                  </tbody></table>
                          
                          <div class="pay_type">
                              <div class="pay_way">
                                  <h3 class="add_zhifu">支付方式：</h3>
                                        <h3 class="addwidth">
                                            <div class="yListr" id="yListr" >
                                                  <ul>
                                                      <li>
                                                        <em name="chooice" class="yListrclickem" payment='online'>线上支付<i></i></em> 

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
                                                 <form action="{url:/PurchaseOrder/geneOrderHandle}" auto_submit pay_secret="1" redirect_url="{url:/purchase/lists}" method="post" enctype="multipart/form-data">
                                                 <div class="sty_online" style="display:block;">
                                                     <input type="hidden" value="online" name="payment"/>
                                                <label for=""><input name="account" type="radio" value="1" checked="true"/>市场代理账户</label>
                                                <label for=""><input name="account" type="radio" value="2" />银行签约账户</label>
                                                <!-- <label for=""><input name="account" type="radio" value="3" />票据账户</label> -->
                                                <input type="hidden" name="id" value="{$data['id']}"/>
                                           </div>
                                           
                                           </form> 
                                          </div>  
                                      
                                 </h3>
                              </div>
                              <div class="trans_way">                                
                                  <h3 class="add_zhifu">物流方式：</h3>
                                  <h3 class="addwidth" style="line-height:33px;font-size:14px;padding:0;">物流自提</h3>
                              </div>         
                          </div>


                  <div class="pay_bton">
                  	<h5>待支付金额：<i>{$data['deposit']}</i>元</h5>
                  	<a href="javascript:;" id='pay_retainage'>立即支付</a>
                  </div>


                           </div>


               

				</div>				
				
			</div>
			<!--end中间内容-->	

      <script type="text/javascript">
        $(function(){
          $('#pay_retainage').unbind('click').click(function(){
            if($('input[name=payment]').val() == 'offline' && !$('input[name=imgproof]').val()){
              alert('请上传支付凭证');
              return false;
            }
            $('form').submit();
          });
        });
      </script>
					