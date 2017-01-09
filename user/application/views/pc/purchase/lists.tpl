
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>采购管理</a>><a>采购列表</a></p>
					</div>
					<div class="chp_xx">
						<div class="xx_top">
							<form action="{url:/Purchase/lists}" method="GET" name="">
								<ul>
									<li>名称：<input id="warename" name="name" type="text" value="{$name}"></li>
								
			
									<li>状态：<select name="status">
									<option value="9">全部</option>
										{foreach: items=$status}
											<option value="{$key}" {if: isset($s) && $key===$s}selected{/if}>{$item}</option>
										{/foreach}
									</select></li>
									<li>时间：<input class="Wdate" type="text" name="beginDate" value="{$beginDate}" onclick="WdatePicker()"> <span style="position: relative;left: -3px;">—</span><input class="Wdate" type="text" name="endDate" value="{$endDate}" onclick="WdatePicker()">
									</li>
									<li> <input type="submit" value="查找" class="chaz"></li>
								</ul>
							</form>
							<div style="clear:both;"></div>
						</div>
						<div class="xx_center">
							<table border="0"  cellpadding="" cellspacing="">
								<tr class="title">
									
									<td>序号</td>
									<td>名称</td>
									<td>市场分类</td>
									<td>总量</td>
									<td>单位</td>
									<td>单价(元)</td>
									<!-- <td>保险</td> -->
									<td>发布状态</td>
									<td>时间</td>
									<td>操作</td>
								</tr>
								{foreach: items=$productList item=$list }
								{set: $key++}
								<tr>
									<td>{$key}</td>
									<td><p>{$list['name']}</p></td>
									<td>{$list['cname']}</td>
									<td>{$list['quantity']}</td>
									<td>{$list['unit']}</td>
									<td>{$list['price_l']}-{$list['price_r']}</td>
									<!-- <td>已投保</td> -->
									<td><span class="col000000">{$list['status_txt']}</span></td>
									<td>{$list['apply_time']}</td>
									<td>
										<a href="{url:/Purchase/detail?id=$list['id']}">查看</a>
										{if:$list['status'] == \nainai\offer\product::OFFER_OK}
											<a href="{url:/Purchase/reportlists}?id={$list['id']}">报价列表</a>
										{/if}
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

		