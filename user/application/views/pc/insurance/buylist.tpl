
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>保险管理</a>><a>产品列表</a></p>
					</div>
					<div class="chp_xx">
						<div class="xx_center">
							<table border="0"  cellpadding="" cellspacing="">
								<tr class="title">
									
									<td>保险名称</td>
									<td>保险公司</td>
									<td>操作</td>
								</tr>
								{foreach: items=$risk_data item=$list }
								{set: $key++}
								<tr>
									<td>{$list['name']}</td>
									<td>{$list['company']}</td>
									<td>
										<a href="{url:/Insurance/buy?id=$list['risk_id']&oid=$id}">购买</a>
										<!-- <a href="{url:/Purchase/doApply?id=$list['id']}">审核</a> -->
									</td>
								</tr>
								{/foreach}
								
							</table>

						</div>
						

						</div>
						<div class="page_num">
							{$pageHtml}
						</div>
					</div>
				</div>
				
				
			</div>

		