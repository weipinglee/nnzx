
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p>{$navi}</p>
					</div>
					<div class="chp_xx">
						<div class="xx_top">
							{include:layout/search.tpl}
							<div style="clear:both;"></div>
						</div>
						<div class="xx_center">
							<table border="0"  cellpadding="" cellspacing="">
								<tr class="title">
									
									<td>序号</td>
									<td>用户名</td>
									<td>手机号</td>
									<td>邮箱</td>
									<td>创建时间</td>
									<td>用户状态</td>
									<td>操作</td>
								</tr>
								{foreach: items=$data['list'] item=$list }
								{set: $key++}
								<tr>
									<td>{$key}</td>
									<td><p>{$list['username']}</p></td>
									<td>{$list['mobile']}</td>
									<td>{$list['email']}</td>
									<td>{$list['create_time']}</td>
									<td><span class="col000000">{$list['status_text']}</span></td>
									<td><a href="{url:/ucenter/subaccpow?id=$list['id']}">分配权限</a>
									<a href="{url:/fund/subaccindex?id=$list['id']}">转账</a>
									</td>
								</tr>
								{/foreach}
								
							</table>

						</div>
						

						</div>
						<div class="page_num">
							{$data['bar']}
						</div>
					</div>
				</div>
				
				
			</div>

		