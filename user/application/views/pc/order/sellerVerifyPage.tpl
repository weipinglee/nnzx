
			<!--end左侧导航-->	
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>合同管理</a>><a>确认质量</a></p>
					</div>
					<div class="center_tabl">
                    <div class="lx_gg">
                        <b>合同详细信息</b>
                    </div>
                    <div class="list_names">
                        <span>订单号:</span>
                        <span>{$info['order_no']}</span>
                    </div>

						<table border="0">
                            <tr>
                                <td nowrap="nowrap"><span></span>商品名：</td>
                                <td colspan="2">
                                   {$info['name']}
                                </td>
                            </tr>
                            <tr>
              					<td nowrap="nowrap"><span></span>数量：</td>
                				<td colspan="2">
                                    {$info['num']}
                                </td>
           				 	</tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>单价：</td>
                                <td colspan="2">
                                    {$info['price']}
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>总价：</td>
                                <td colspan="2">
                                    {$info['amount']}
                                </td>
                            </tr>
                             <tr>
                                <td nowrap="nowrap"><span></span>购买人：</td>
                                <td colspan="2">
                                    {$info['buyer_name']}
                                </td>
                            </tr>
                            
                            
              				
                      

                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">
                                
                                <a href="{url:/order/sellerVerify?order_id=$info['id']}" confirm>确认质量</a>
                                <a href="javascript:history.back()" style="background:#c0c0c0;border:1px solid #c0c0c0;">返回</a>
                                
                            </td>
                        </tr>
                         </table>
                         </div>
                         </div>
                         </div>

			