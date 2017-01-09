
﻿<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>产品管理</a>><a>产品详情</a></p>
					</div>
					<div class="center_tabl">
                    <form action="{url:/managerdeal/ajaxsetStatus}" method="post" auto_submit="1" redirect_url="{url:managerdeal/productList}" >
					   <table class="table2" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="spmx_title" colspan="2">商品明细</td>
                            </tr>

                           <tr>
                               <td>商品标题</td>
                               <td>{$product['product_name']}</td>
                           </tr>

                            <tr>
                                <td>产品大类</td>
                                 <td>{$product['cate'][0]['name']}</td>
                            </tr>
                           <tr>
                               <td>产品分类</td>
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
                           </tr>
                            <tr>
                                <td>规格</td>
                                <td>
                                   {$product['attrs']}
                                </td>
                            </tr>
                            <tr>
                                <td>产地</td>
                                <td id="areat">{areatext: data=$product['produce_area'] id=areat }</td>
                            </tr>
                            <tr>
                                <td>申请时间</td>
                                <td>{$product['create_time']}</td>
                            </tr>
                           <tr>
                               <td>过期时间</td>
                               <td>{$offer['expire_time']}</td>
                           </tr>
                            <tr>

                                <td>产品数量(单位)</td>
                                <td class="end_td">{$product['quantity']}（{$product['unit']}）</td>

                            </tr>
                            <tr>
                                <td class="spmx_title" colspan="2">报盘详情</td>
                            </tr>
                             <tr>
                                <td>报盘状态</td>
                                <td>

                                    <span class="col12aa07">{$offer['status_txt']}</span>

                                </td>
                            </tr>

                          <!--   <tr>
                              <td>交易类型</td>
                              <td>销售</td>
                          </tr>
                          <tr>
                              <td>担保类型</td>
                              <td>仓单</td>
                          </tr>
                          <tr>
                              <td>是否投保</td>
                              <td>是</td>
                          </tr>
                          <tr>
                              <td>支付方式</td>
                              <td>现汇</td>
                          </tr> -->
                          <tr>
                                <td>是否投保</td>
                                <td>{if: $offer['insurance'] == 1}是{else:}否{/if}</td>
                            </tr>
                             {if: $offer['insurance'] == 1}
                            <tr>
                                <td>投保产品</td>
                                <td>
                                     {foreach: items=$riskData}
                                      保险公司：{$item['company']} - 保险产品：{$item['name']} {if:$item['mode']==1}比例 : ({$item['fee']}){else:}定额 : ({$item['fee']}){/if}<br />
                                     {/foreach}
                                </td>
                            </tr>
                            {/if}
                            <tr>
                                <td>可否拆分</td>
                                <td>{$offer['divide_txt']}</td>
                            </tr>
                            <tr>

                                <td>报盘数量</td>
                                <td>{$product['quantity']}</td>

                            </tr>
                           <tr>
                               <td>单位</td>
                               <td>{$product['unit']}</td>
                           </tr>
                           {if:$offer['divide']==1}
                            <tr>
                                <td>起订量</td>
                                <td>{$offer['minimum']}</td>
                            </tr>
                               <tr>
                                   <td>最小递增量</td>
                                   <td>{$offer['minstep']}</td>
                               </tr>
                           {/if}
                            <tr>
                                <td>商品单价</td>
                                <td>{$offer['price']}元</td>
                            </tr>
                            <tr>
                                <td>交货地址</td>
                                <td>{$offer['accept_area']}</td>
                            </tr>
                           <tr>
                               <td>交收时间</td>
                               <td>T+{$offer['accept_day']}天</td>
                           </tr>
                           <tr>
                               <td>记重方式</td>
                               <td>{$offer['weight_type']}</td>
                           </tr>
                            <tr>
                                <td>产品描述</td>
                                <td>{$product['note']}</td>
                            </tr>
                            <tr>
                                <td>补充条款</td>
                                <td>{$offer['other']}</td>
                            </tr>
                            <tr>
                                <td>产品图片</td>
                                <td>
                                {foreach: items=$product['photos'] item=$v}
                                    <img src="{$v}">
                                    {/foreah}

                                </td>
                            </tr>
                             <tr>
                                <td>审核意见</td>
                                <td>{$offer['admin_msg']}
                                </td>
                            </tr>
                             <tr>
                                <td colspan="2">
                                   <input class="cg_fb" type="button" value="返回" onclick="history.go(-1)" style="float:left;"/>
                                  <input type="hidden" name="id" value="{$offer['id']}" />
                                  {if: ($product['quantity'] - $product['sell'] - $product['freeze']) > 0}
                                  <div class="pay_bton">
                                      <a href="javascript:void(0)" class="submit_chag"  id='pay_retainage'  confirm="1" confirm_text="确认撤销报盘？">撤销报盘</a>
                                  </div>
                                  {/if}
                                    {if:isset($updateUrl)}
                                        <a class="submit_chag"  href="{$updateUrl}" >修改<a/>
                                    {/if}
                                </td>
                            </tr>
                        </table>
            	    </form>
						
					</div>
				</div>
			</div>
			<!--end中间内容-->


			