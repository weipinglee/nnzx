<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{views:js/product/attr.js}" ></script>
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>产品管理</a>><a>仓单报盘修改</a></p>
					</div>
					<div class="center_tabl">
                     <form action="{url:/Managerdeal/doUpdateStoreOffer}" method="POST" auto_submit redirect_url="{url:/managerdeal/indexoffer}">
                            <input type="hidden" name="offer_id" value="{$offer['id']}" />
                         <table border="0">

                            <tr >
                                <td class="spmx" colspan="3">
                                    <table class="table2" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td class="spmx_title" colspan="2">商品明细</td>
                                        </tr>

                                        <tr>
                                            <td>商品名称</td>
                                            <td id="pname"> 
                                                {$product['product_name']}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>产品大类</td>
                                            <td id="cname">  
                                                {foreach:items=$product['cate']}
                                                    {if:$key!=0}>{/if}{$item['name']}
                                                {/foreach}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>规格</td>
                                            <td id="attrs">
                                                {$product['attrs']}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>产地</td>
                                            <td id="area"> 
                                                {areatext:data=$product['produce_area']}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>签发时间</td>
                                            <td >
                                                {$storeproduct['sign_time']}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="end_td">产品数量（<span id="unit">{$product['unit']}</span>）</td>
                                            <td class="end_td" id="quantity">
                                                {$product['quantity']}
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </td>
                            </tr>
                            

                            <tr>
                               <th colspan="3">基本挂牌信息</th>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>商品单价：</td>
                                <td> 
                                    <input class="text" type="text" value="{$offer['price']}" datatype="money" errormsg="价格错误" name="price">
                                    
                                </td>
                               <!--  <td> 
                                   请选择付款方式：
                                   <input type ="radio" name ="safe" checked="checked" style="width:auto;height:auto;"> 线上
                                   <input type ="radio" name ="safe" style="width:auto;height:auto;"> 线下
                               </td> -->
                            </tr>
                              <tr>
<!--         <td nowrap="nowrap"><span></span>是否投保：</td>
        <td>
            <span> <input type="radio" name="insurance" value="1"  >是 <input type="radio" name="insurance" value="0"  checked="true">否</span>
        </td>
    </tr>
    <tr id="riskdata" style="display:none;">
        <td ><span></span>投保：</td>
        <td>
            <span> 
            </span>
        </td>
    </tr> -->
                           <tr>
                            <td><span>*</span>是否可拆分：</td>
                            <td>

                                <select name="divide" id="divide">
                                    <option value="1"  >是</option>
                                    <option value="0" {if:$offer['divide']==0}selected{/if} >否</option>
                                </select>
                            </td>
                            </tr>
                            <tr class='nowrap1' {if:!isset($offer['divide']) || $offer['divide']==0}style="display:none"{/if}>
                                <td><span>*</span>最小起订量：</td>
                                <td>
                                    <span><input name="minimum" id="" value="{$offer['minimum']}" type="text"  /></span>
                                    <span></span>
                                </td>
                            </tr>
                            <tr class='nowrap1' {if:!isset($offer['divide']) || $offer['divide']==0}style="display: none"{/if} >
                                <td><span>*</span>最小递增量：</td>
                                <td>
                                    <span><input name="minstep" id="" type="text" value="{$offer['minstep']}" /></span>
                                    <span></span>
                                </td>
                            </tr>
                            <script type="text/javascript">
                                $('#divide').change(function(){
                                    if($('#divide').val()==1){
                                        $('.nowrap1').show();

                                    }else{
                                        $('.nowrap1').hide();
                                    }
                                });
                            </script>
          					

                            <tr>
                        <td>交收地点：</td>
                            <td colspan="2">
                                <input type="text" class='text' datatype="s2-100" errormsg="请填写有效地址" name="accept_area" value="{$offer['accept_area']}">
                            </td>
                            </tr>
                             <tr>
                            <td>交收时间：</td>
                            <td colspan="2">
                                <span>T+<input type="text" class='text' datatype="/[1-9]\d{0,5}/" name="accept_day" style="width:50px;" value="{$offer['accept_day']}">天</span>
                            </td>
                            </tr>
              			                      

                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">
                            <input type="hidden" name="mode" value="3">
                                <input type="hidden" name="token" value="{$token}" />
                              <input type="submit" value="提交审核">

                                
                            </td>
                        </tr>
                         
                 </table>
            	</form>

						
					</div>
				</div>
			</div>
		