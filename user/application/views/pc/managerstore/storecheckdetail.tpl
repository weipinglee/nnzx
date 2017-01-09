<script type="text/javascript" src='{root:js/area/Area.js}'></script>
<script type="text/javascript" src='{root:js/area/AreaData_min.js}'></script>
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>交易管理</a>><a>仓单出库确认</a></p>
					</div>
					<div class="chp_xx">
						<div class="sjxx">
						<p>出库信息</p>

							<div class="sj_detal">
								<b class="sj_de_tit">状态：</b>
								<span>&nbsp;{$info['status_txt']}</span>
							</div>
							{if:$info['admin_msg']}
							<div class="sj_detal">
								<b class="sj_de_tit">审核意见：</b>
								<span>&nbsp;{$info['admin_msg']}</span>
							</div>
							{/if}
							{if:$info['pstatus']== \nainai\Delivery\delivery::DELIVERY_MANAGER_CHECKOUT}
							<div class="sj_detal">
								<b class="sj_de_tit">操作</b>
								<span>&nbsp;
								<a href="{url:/ManagerStore/storeDeliveryCheck?id=$info[id]}" style="background: #FC7300;padding: 8px 15px;color:#fff;text-decoration: none">确认出库</a></span>
							</div>
							{/if}
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
								<b class="sj_de_tit">结算日期：</b>
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
							<p>商品信息</p>

							<div class="sj_detal">
								<b class="sj_de_tit">商品名称：</b>
								<span>&nbsp;{$info['name']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">产品大类：</b>
								<span>&nbsp;{$info['cate_name']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">规格：</b>
								<span>&nbsp;{$info['attrs']}</span>
							</div>

							<div class="sj_detal">
								<b class="sj_de_tit">产地：</b>
								<span id="area">&nbsp; {areatext: data=$info['produce_area'] id=areat }</span>
							</div>

							<div class="sj_detal">
								<b class="sj_de_tit">单价：</b>
								<span>&nbsp;￥{$info['price']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">数量：</b>
								<span>&nbsp;{$info['quantit']}{$info['unit']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">交收地点：</b>
								<span>&nbsp;{$info['accept_area']}</span>
							</div>
							<p>提货人信息</p>
							<div class="sj_detal">
								<b class="sj_de_tit">提货人：</b>
								<span>&nbsp;{$info['delivery_man']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">电话：</b>
								<span>&nbsp;{$info['phone']}</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">身份证号：</b>
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
						</div>
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