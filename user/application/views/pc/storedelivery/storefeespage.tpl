<script type="text/javascript" src='{root:js/area/Area.js}'></script>
<script type="text/javascript" src='{root:js/area/AreaData_min.js}'></script>
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>交易管理</a>><a>支付仓库管理费用</a></p>
					</div>
					<div class="chp_xx">
						<div class="de_ce">
							<div class="detail_chj" style="margin-top: 11px">
								<!-- <input class="fk_butt" type="button" value="支付仓库管理费用"/> -->

							<form action="{url:/storeDelivery/storeFees}" method="post" auto_submit pay_secret="1" redirect_url="{url:/delivery/deliselllist}">
								<input type="hidden" name="id" value="{$info['id']}" />
								<a href="javascript:void(0)" confirm="1" confirm_text="确定支付？" style="background: #FC7300;padding: 8px 15px;color:#fff;text-decoration: none">支付仓库管理费用</a>
							</form>
							</div>
						</div>
						<div class="sjxx">
							<p>仓库信息</p>

							<div class="sj_detal">
								<b class="sj_de_tit">仓库名称：</b>
								<span>&nbsp;{$info['store_name']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">提货数量：</b>
								<span>&nbsp;{$info['delivery_num']}{$info['unit']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">租库日期：</b>
								<span>&nbsp;{$info['rent_time']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">入库日期：</b>
								<span>&nbsp;{$info['in_time']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">提货日期：</b>
								<span>&nbsp;{$info['now_time']}</span>
							</div>

							<div class="sj_detal">
								<b class="sj_de_tit">租库单价：</b>
								<span>&nbsp;￥{$info['store_price']}</span>
							</div>

							<div class="sj_detal">
								<b class="sj_de_tit">总价：</b>
								<span>&nbsp;￥{$info['store_fee']}</span>
							</div>
						</div>
						<div class="sjxx">
							<p>商品信息</p>

							<div class="sj_detal">
								<b class="sj_de_tit">商品名称：</b>
								<span>&nbsp;{$info['name']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">商品单价：</b>
								<span>&nbsp;{$info['price']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">商品数量：</b>
								<span>&nbsp;{$info['delivery_num']}{$info['unit']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">小计：</b>
								<span>&nbsp;{$info['delivery_amount']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">配送：</b>
								<span>&nbsp;未发货</span>
							</div>

						</div>
						<div class="sjxx">
							<p>提货人信息</p>

							<div class="sj_detal">
								<b class="sj_de_tit">提货人：</b>
								<span>&nbsp;{$delivery_info['delivery_man']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">电话：</b>
								<span>&nbsp;{$delivery_info['phone']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">身份证号：</b>
								<span>&nbsp;{$delivery_info['idcard']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">车牌号：</b>
								<span>&nbsp;{$delivery_info['plate_number']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">备注：</b>
								<span>&nbsp;{$delivery_info['remark']}</span>
							</div>

						</div>
						<!-- <div class="xx_center">
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
									<th>配送</th>
								</tr>
								<tr>
									<td><img src="{$info['img_thumb']}"/></td>
									<td>{$info['name']}</td>
									<td>{$info['price']}</td>
									<td>{$info['delivery_num']}{$info['unit']}</td>
									<td>{$info['delivery_amount']}</td>
									<td>未发货</td>
								</tr>
							</tbody></table>
						</div> -->
					</div>
				</div>
			</div>
			<!--end中间内容-->	
			<!--end右侧广告-->

			<script type="text/javascript">
				$(function(){
					$('.fk_butt').click(function(){
						window.location.href = $(this).attr('url');
					});
				})
			</script>
		</div>
	</div>