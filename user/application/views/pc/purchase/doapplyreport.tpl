
			<!--end左侧导航-->	
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>仓单管理</a>><a>仓单审核</a></p>
					</div>
					<div class="center_tabl">

                    <form action="{url:/Purchase/doApplyReport}" method="POST" auto_submit redirect_url="{url:/Purchase/reportlists}">
						<table border="0">
                        <tr>
                            <th colspan="3">商品类型和规格</th>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>商品类型:</td>
                                <td>
                                    {foreach:items=$product['cate']}
                                        {if:$key!=0}
                                            {if:$key==1}
                                                {$item['name']}
                                            {else:}
                                               > {$item['name']}
                                            {/if}
                                        {/if}
                                   {/foreach}
                                </td>
                                <td> 
                                    
                                </td>
                            </tr>
 <tr>
                                <td nowrap="nowrap"><span></span>商品规格:</td>
                                <td>
                                    {$product['attrs']}
                                </td>
                                <td> 
                                    
                                </td>
                            </tr>
                            
                               <th colspan="3">基本商品信息</th>
                                <tr>
                                <td nowrap="nowrap"><span></span>商品名称:</td>
                                <td>
                                    {$product['product_name']}
                                </td>
                                <td> 
                                    
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>商品单价:</td>
                                <td>
                                    {$detail['price']}
                                </td>
                                <td> 
                                    
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>挂牌数量:</td>
                                <td>
                                    {$product['quantity']}({$product['unit']})
                                </td>
                                <td> 
                                   
                                </td>
                            </tr>
                           <tr>
                                <td nowrap="nowrap"><span></span>产地:</td>

                                <td id="areat">{areatext: data=$product['produce_area'] id=areat }
                                </td>
                                <td> 
                                    
                                </td>
                            </tr>
          					
                            <tr>
                                <td>图片预览：</td>
                                <td colspan="2">
    								<span class="zhs_img">
    								  {foreach: items=$product['photos'] item=$photo}
                                                                            <img src="{$photo}"/>
                                                                        
                                                                        {/foreach}  
    							</span>
                                </td>              
                            </tr>
              				


                        <tr>
                            <td>产品描述：</td>
                            <td colspan="2">
                                {$product['note']}
                            </td>
                        </tr>

                         <tr>
                            <th colspan="3">报价信息</th>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>报价用户: </td>
                                <td>
                                   {$report['username']['username']}
                                </td>
                                <td> 
                                    
                                </td>
                            </tr>
                             <tr>
                                <td nowrap="nowrap"><span></span>报价规格: </td>
                                <td>
                                   {$report['attr']}
                                </td>
                                <td> 
                                    
                                </td>
                            </tr>
                             <tr>
                                <td nowrap="nowrap"><span></span>报价单价: </td>
                                <td>
                                    {$report['price']}
                                </td>
                                <td> 
                                    
                                </td>
                            </tr>
                         <tr>
                            <td>是否通过审核：</td>
                            <td colspan="2">
                                <input type="radio" name="apply" checked value="1"> 采纳
                                <input type="radio" name="apply" value="0"> 拒绝
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">
                            <input type="hidden" value="{$report['id']}" name="id">
                            <input type="hidden" value="{$report['seller_id']}" name="seller_id">
                            <input type="hidden" value="{$report['offer_id']}" name="offer_id">
                            <input type="hidden" value="{$detail['user_id']}" name="buy_id">
                             <input type="hidden" value="{$report['price']}" name="price">
                             <input type="hidden" value="{$report['price']}" name="num">
                               <input type="submit" value="确认">
                                <!-- <span class="color">审核将收取N元/条的人工费用，请仔细填写</span> -->
                                
                            </td>
                        </tr>
                         
                 </table>
            	</form>
						
					</div>
				</div>
			</div>
			<!--end中间内容-->	
			
		</div>
      <script type="text/javascript" src="{views:js/product/attr.js}" ></script>