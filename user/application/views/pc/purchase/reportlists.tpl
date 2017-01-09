<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>采购管理</a>><a>报价列表</a></p>
					</div>
					<div class="chp_xx">
						<div class="xx_top">
							<form action="{url:/Purchase/reportlists}" method="GET" name="">
								<ul>
									{if:!isset($user_id)}
									<li>用户名：<input id="warename" name="name" type="text" value="{$name}"></li>
									{/if}
								
									<li>状态：<select name="status">
									<option value="9">全部</option>
										{foreach: items=$status}
											<option value="{$key}" {if: isset($s) && $key===$s}selected{/if}>{$item}</option>
										{/foreach}
									</select></li>
									<li>申请时间：<input class="Wdate" type="text" name="beginDate" value="{$beginDate}" onclick="WdatePicker()"> <span style="position: relative;left: -3px;">—</span><input class="Wdate" type="text" name="endDate" value="{$endDate}" onclick="WdatePicker()">
									</li>
									<input type="hidden" name="id" value="{$id}">
									<li><input type="submit" value="查找" class="chaz"></li>
								</ul>
							</form>
							<div style="clear:both;"></div>
						</div>
						<div class="xx_center">
							<table border="0"  cellpadding="" cellspacing="">
								<tr class="title">
									
									<td>序号</td>
									<td>报价用户</td>
									<td>报价产品</td>
									<td>产地</td>
									<td>单价(元)</td>
									<!-- <td>保险</td> -->
									<td>发布状态</td>
									<td>申请时间</td>
									<td>操作</td>
								</tr>
								{foreach: items=$reportLists item=$list }
								{set: $key++}
								<tr>
									<td>{$key}</td>
									<td><p>{$list['username']}</p></td>
									<td>{$list['product_name']}</td>
									<td><span id="area{$key}">{set:$id='area'.$key}{areatext:data=$list['produce_area'] id=$id}</span></td>
									<td>{$list['price']}</td>
									<!-- <td>已投保</td> -->
									<td><span class="col000000">{$list['status_zn']}</span></td>
									<td>{$list['create_time']}</td>
									<td>
										
										{if:!isset($user_id) && $list['status'] == \nainai\offer\product::OFFER_APPLY}
										<a href="{url:/PurchaseOrder/geneOrder?id=$list['id']&offer_id=$list['offer_id']}">选择</a>
										{/if}
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

		