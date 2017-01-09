<script type="text/javascript" src='{root:js/area/Area.js}'></script>
<script type="text/javascript" src='{root:js/area/AreaData_min.js}'></script>
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>交易管理</a>><a>发货合同详情</a></p>
					</div>
					<div class="chp_xx">
						<div class="de_ce">
							<div class="detail_chj">
								&nbsp;&nbsp;<span>{$info['create_time']}</span>
								<span>订单创建</span>
							</div>
							<div class="" style="line-height: 25px">
								{foreach:items=$info['pay_log']}&nbsp;&nbsp;
									<span>{$item['create_time']}</span>
									<span>{$item['remark']}</span>
									
									<br>
								{/foreach}
							</div>
							<div class="detail_chj" style="font-weight:bold;border-top:1px dashed #ddd">
								<b>订单号：</b><span>{$info['order_no']}</span>
								<b>下单日期:</b><span>{$info['create_time']}</span>
								<b>状态:</b><span>{$info['title']}</span>
							</div>
							<div class="detail_chj">
								<!-- <input class="qx_butt" type="button" value="取消订单"/> -->
								<!-- {if:$info['complain']==1}
									<a  href="{url:/contract/complainContract}?id={$info['id']}"><input class="fk_butt" type="button" value="我要申诉"/></a>
								{/if}
								{if:isset($info['action'][0]['url'])}<input class="fk_butt" type="button" url="{$info['action'][0]['url']}" onclick="window.location.href='{$info['action'][0]['url']}'" value="{$info['title']}"/>{/if} -->
								<a href="{url:/depositDelivery/sellerConsignment?id=$info['delivery_id']}" confirm><input class="fk_butt" type="button" value="发货"/></a>
							</div>
						</div>
						<div class="sjxx">

							<p>配送信息</p>
							<div class="sj_detal">
								<b class="sj_de_tit">预计提货日期：</b>
								<span>&nbsp;{$info['expect_time']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">提货人：</b>
								<span>&nbsp;{$info['delivery_man']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">联系电话：</b>
								<span>&nbsp;{$info['phone']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">身份证：</b>
								<span>&nbsp;{$info['idcard']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">车牌号：</b>
								<span>&nbsp;{$info['plate_number']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">备注：</b>
								<span>&nbsp;{$info['remark']}</span>
							</div>

							<p>生产厂家信息</p>
							<div class="sj_detal">
								<b class="sj_de_tit">企业名称：</b>
								<span>&nbsp;{$info['userinfo']['company_name']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">地址：</b>
								<span id='area'>&nbsp;{areatext:data=$info['userinfo']['area'] id=area}</span>&nbsp;{$info['userinfo']['address']}
							</div>

							<p>开票信息</p>

							{if:$info['invoice']==1}
							<div class="sj_detal">
								<b class="sj_de_tit">是否开票：</b>&nbsp;
									是
							</div>
								{if:!empty($invoice['order_invoice'])}

									<div class="sj_detal">
										<b class="sj_de_tit">开票状态：</b>
										&nbsp;<span>已开票</span>

									</div>
									<div class="sj_detal">
										<b class="sj_de_tit">快递公司：</b>
										&nbsp;<span>{$invoice['order_invoice']['post_company']}</span>

									</div>
									<div class="sj_detal">
										<b class="sj_de_tit">快递单号：</b>
										&nbsp;<span>{$invoice['order_invoice']['post_no']}</span>

									</div>
									<div class="sj_detal">
										<b class="sj_de_tit">开票时间：</b>
										&nbsp;<span>{$invoice['order_invoice']['create_time']}</span>

									</div>
									<div class="sj_detal">
										<b class="sj_de_tit">发票图片：</b>
										&nbsp;<img src="{$invoice['order_invoice']['image']}" />

									</div>
								{else:}
									<div class="sj_detal">
										<b class="sj_de_tit">开票状态：</b>
										&nbsp;<span>待开票</span>

									</div>
								{/if}


							{else:}
								<div class="sj_detal">
									<b class="sj_de_tit">是否开票：</b>&nbsp;
									否
								</div>
							{/if}




						</div>
						<div class="xx_center">
							<table border="0" cellpadding="" cellspacing="">
								<tbody>
								<tr class="title" >
									<td align="left" colspan="7">&nbsp;商品清单</td>
								</tr>
								<tr>
									<th>图片</th>
									<th>商品名称</th>
									<th>商品价格</th>
									<th>提货数量</th>
									<th>小计</th>
									<th>提货</th>
								</tr>
								<tr>
									<td><img src="{$info['img_thumb']}"/></td>
									<td>{$info['name']}</td>
									<td>{$info['price']}</td>
									<td>{$info['num']}{$info['unit']}</td>
									<td>{$info['amount']}</td>
									<td>待发货</td>

								</tr>
							</tbody></table>
						</div>
					</div>
				</div>
			</div>
			<!--end中间内容-->	
			<!--end右侧广告-->

			<script type="text/javascript">
				$(function(){
					$('.fk_butt').click(function(){
						// window.location.href = $(this).attr('url');
					});
				})
			</script>
		</div>
	</div>