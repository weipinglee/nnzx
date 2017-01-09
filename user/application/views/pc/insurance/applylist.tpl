
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>采购管理</a>><a>采购列表</a></p>
					</div>
					<div class="chp_xx">
						<div class="xx_top">
							<form action="{url:/Insurance/applyList}" method="GET" name="">
								<ul>
									<li>名称：<input id="warename" name="name" type="text" value="{$name}"></li>
								
			
									<li>状态：<select name="status">
									<option value="9">全部</option>
										{foreach: items=$status}
											<option value="{$key}" {if: isset($s) && $key===$s}selected{/if}>{$item}</option>
										{/foreach}
									</select></li>
									<li>申请时间：<input class="Wdate" type="text" name="beginDate" value="{$beginDate}" onclick="WdatePicker()"> <span style="position: relative;left: -3px;">—</span><input class="Wdate" type="text" name="endDate" value="{$endDate}" onclick="WdatePicker()">
									</li>
									<li> <a class="chaz"><input class="chaz_look" type="submit" value="查找"> </a></li>
								</ul>
							</form>
							<div style="clear:both;"></div>
						</div>
						<div class="xx_center">
							<table border="0"  cellpadding="" cellspacing="">
								<tr class="title">
									
									<td>报盘序号</td>
									<td>报盘商品名称</td>
									<td>购买数量</td>
									<td>申请状态</td>
									<td>申请时间</td>
									<td>审核时间</td>
									<td>操作</td>
								</tr>
								{foreach: items=$lists item=$list }
								{set: $key++}
								<tr>
									<td>{$list['offer_id']}</td>
									<td><p>{$list['name']}</p></td>
									<td>{$list['quantity']}</td>
									<td>{$status[$list['status']]}</td>
									<td>{$list['apply_time']}</td>
									<td>{$list['check_time']}</td>
									<td>
										<a href="{url:/Insurance/applydetail?id=$list['id']}">查看</a>
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

		