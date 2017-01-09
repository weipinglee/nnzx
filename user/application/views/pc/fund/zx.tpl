	<style type="text/css">
		.page{padding: 10px;text-align: center;}
		.page>.prefix_page,.page>.next_page,.page>.content{display: inline-block;padding: 5px;color:#ddd;border:1px solid silver;cursor: pointer;}
		.page>.now_page{margin:0 5px;}
	</style>
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
				<form action="" method="get">
					<div class="zhxi_tit">
						<p><a>资金管理</a>><a>中信银行签约账户管理</a></p>
					</div>
					<div>
						<div class="zj_gl">
							<div class="zj_l">
								<a href="{url:/Fund/zxpage}" class="zj_a cz">{if:isset($no)}账户信息{else:}开通{/if}</a>
								{if:isset($no)}
								<a href="{url:/Fund/zxtx}" class="zj_a tx">提现</a>
								<p class="re_t">结算账号资金总额</p>
								<h1 class="rental">￥{echo:$balance['SJAMT']}</h1>
								{/if}
								<p class="state"></p>
							</div>
							<div class="zj_r">
								<div class="zj_price"></div>
								<div class="zj_column">
									<span class="column_yes" style="width:{echo:$balance['DJAMT']/($balance['SJAMT'])*300}px;" title="{$balance['DJAMT']}"></span>
									<span class="column_no" style="width:{echo:$balance['KYAMT']/($balance['SJAMT'])*300}px;" title="{$balance['KYAMT']}"></span>
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
							 交易时间：<input class="Wdate" name="startDate" type="text" value="{$startDate}" onClick="WdatePicker()">
							<span class="js_span1">-</span>
							<input class="Wdate" type="text" name="endDate" value="{$endDate}" onClick="WdatePicker()">
							
							<button type="submit" class="search_an">搜索</button> 					
						</div>
							</form>
                    </div>
					<div class="jy_xq">
                    <table cellpadding="0" cellspacing="0">
				        <tr>
				            <th>柜员交易号</th>
				            <th>交易时间</th>
				            <th>交易类别</th>
				            <th>交易金额</th>
							<th>账户余额</th>
				            <th>对方账号</th>
				            <!-- <th>对方账户名</th> -->
				            <th>打印校验码</th>
				            <th>备注</th>
				            <th>打印</th>
				        </tr>
						{foreach:items=$flow }
						<tr>

							<!-- <td>{$item['HOSTFLW']}</td>
							<td>{$item['TRANDATE']}{$item['TRANTIME']}</td>
							<td>{$item['TRANTYPE_TEXT']}</td>
							<td>{$item['TRANAMT']}</td>
							<td>{$item['ACCBAL']}</td>
							<td>{$item['OPPACCNO']}</td>
							<td>{$item['OPPACCNAME']}</td> -->
							<td>{$item['tellerNo']}</td>
							<td>{$item['tranDate']}{$item['tranTime']}</td>
							<td>{$item['TRANTYPE_TEXT']}</td>
							<td>{$item['tranAmt']}</td>
							<td>{$item['accBalAmt']}</td>
							<td>{$item['accountNo']}</td>
							<!-- <td>{$item['accountNm']}</td> -->
							<td>{$item['verifyCode']}</td>
							<td>{$item['memo']}</td>
							<td width="40px"><a target="_blank" href="https://enterprise.bank.ecitic.com/corporbank/cb060400_reBill.do">打印</a></td>
						</tr>
						{/foreach}
					
						
                    </table>
					</div>
					<div class='page'>{$page_format}</div>
				</form>
				</div>
			</div>
			
	<!--end中间内容-->		
<script type="text/javascript">
	$(function(){
		var page = parseInt("{$page}");
		var url = window.location.href;
		if(url.indexOf("&page=")>0){
			url = url.replace(/&page={$page}/,'');
		}
		if(url.indexOf("?page=")>0){
			url = url.replace(/\?page={$page}/,'');	
		}
		
		var new_url = '';
		var is_pa = url.indexOf('?');
		new_url = is_pa>0 ? url+"&page=" : url+"?page=";
		
		$('.prefix_page').click(function(){
			layer.load(2);
			new_url += (page-1);
			window.location.href = new_url;
		});
		$('.next_page').click(function(){
			layer.load(2);
			new_url += (page+1);
			window.location.href = new_url;
		});
		$('.content').click(function(){
			layer.load(2);
			var index = parseInt($(this).text());
			new_url += index;
			window.location.href = new_url;
		});
	});
</script>