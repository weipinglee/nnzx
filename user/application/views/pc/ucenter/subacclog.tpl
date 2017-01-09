
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
									
									<td>操作时间</td>
									<td>用户</td>
									<td>操作</td>
									<td>内容</td>
								</tr>
								{foreach: items=$data['list'] item=$list }
								{set: $key++}
								<tr>
									<td>{$list['datetime']}</td>
									<td><p>{$list['username']}</p></td>
									<td>{$list['action']}</td>
									<td>{$list['content']}</td>
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

		