
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>产品管理</a>><a>产品列表</a></p>
					</div>
					<div class="chp_xx">
						<div class="xx_top">
							<form action="{url:/managerdeal/productlist}" method="GET" name="">
								<ul>
									<li>名称：<input id="warename" name="name" type="text" value="{$name}"></li>
									<li>发布状态：
									<select id="classcode" name="status">
									<option value="9">--全部--</option>
									{foreach: items=$statusList item=$value key=$key}
										<option value="{$key}" {if: $key==$status}SELECTED{/if}>{$value}</option>
									{/foreah}
			
									</select></li>
									<li>时间：<input class="Wdate" type="text" name="beginDate" value="{$beginDate}" onclick="WdatePicker()"> <span style="position: relative;left: -3px;">—</span><input class="Wdate" type="text" name="endDate" value="{$endDate}" onclick="WdatePicker()">
									</li>
									<li><input type="submit" value="查找" class="chaz"></li>
								</ul>
							</form>
							<div style="clear:both;"></div>
						</div>
						<div class="xx_center">
							<table border="0"  cellpadding="" cellspacing="">
								<tr class="title">
									
									<td>序号</td>
									<td>报盘类型</td>
									<td>名称</td>
									<td>市场分类</td>
									<td>总量</td>
									<td>剩余</td>
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
									<td>{$mode[$list['mode']]}</td>
									<td><p>{$list['name']}</p></td>
									<td>{$list['cname']}</td>
									<td>{echo:\nainai\offer\product::floatForm($list['quantity'])}</td>
									<td>{echo:$list['quantity']-$list['freeze']-$list['sell']}</td>
									<td>{$list['unit']}</td>
									<td>{$list['price']}</td>
									<!-- <td>已投保</td> -->
									<td><span class="col000000">{$list['status']}</span></td>
									<td>{$list['apply_time']}</td>
									<td><a href="{url:/managerDeal/productDetail?id=$list['id']}">查看</a></td>
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

		