	
			<!--start中间内容-->	
			<div class="user_c" style="width:79%">
				<div class="user_zhxi">
				<form action="" method="get">
					<div class="zhxi_tit">
						<p><a>资金管理</a>><a>代理账户管理</a></p>
					</div>
					<div>
						<div class="zj_gl">
							<div class="zj_l">
								<a href="{url:/Fund/Cz}" class="zj_a cz">充值</a>
								<a href="{url:/Fund/tx}" class="zj_a tx">提现</a>
								<p class="re_t">结算账号资金总额</p>
								<h1 class="rental">￥{echo:$active+$freeze}</h1>
								<p class="state"></p>
							</div>
							<div class="zj_r">
								<div class="zj_price"></div>
								<div class="zj_column">
									<span class="column_yes" style="width:{echo:$freeze/($active+$freeze)*300}px;" title="{$freeze}"></span>
									<span class="column_no" style="width:{echo:$active/($active+$freeze)*300}px;" title="{$active}"></span>
									<div class="clear"></div>
								</div>
								<div class="price">
									<span class="price_l">
										<i class="pr_l"></i>
										<span>可用资金</span>
									</span>
									<span class="price_r">
										<i class="pr_r"></i>
										<span>冻结资金</span>
									</span>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						
					</div>
                    <div class="zj_mx">
                    	<div class="mx_l">结算账户资金明细</div>
						<form action="{url:/Fund/index}" method="GET" name="">
                        <div class="mx_r">
							 交易时间：<input class="Wdate" name="begin" type="text" value="{$cond['begin']}" onClick="WdatePicker()">
							<span class="js_span1">-</span>
							<input class="Wdate" type="text" name="end" value="{$cond['end']}" onClick="WdatePicker()">
							<span class="js_span2">交易号：</span><input type="text" value="{$cond['no']}" name="Sn">
							<select name="day" >
								<option value="7" {if:$cond['day']==7}selected{/if}>一周内</option>
								<option value="30" {if:$cond['day']==30}selected{/if}>一个月内</option>
								<option value="365" {if:$cond['day']==365}selected{/if}>一年内</option>
							</select>
							<button class="search_an" type="submit">搜索</button> 					
						</div>
							</form>
                    </div>
					<div class="jy_xq">
                    <table cellpadding="0" cellspacing="0">
				        <tr>
				            <th>交易号</th>
				            <th>交易时间</th>
				            <th>收入</th>
				            <th>支出</th>
				            <th>冻结</th>
							<th>总金额</th>
							<th>可用金额</th>
				            <th>摘要备注</th>
				        </tr>
						{foreach:items=$flow }
						<tr>

							<td>{$item['flow_no']}</td>
							<td>{$item['time']}</td>
							<td>{$item['fund_in']}</td>
							<td>{$item['fund_out']}</td>
							<td>{echo:$item['total'] -$item['active'] }</td>
							<td>{$item['total']}</td>
							<td>{$item['active']}</td>
							<td>{$item['note']}</td>

						</tr>
						{/foreach}
                    </table>
					</div>
				</form>
				</div>
			</div>
			
	<!--end中间内容-->		
