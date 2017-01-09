<!--start中间内容-->	
<div class="user_c_list">
	<div class="user_zhxi">
		<div class="zhxi_tit">
			<p><a>交易管理</a>><a>提单管理</a></p>
		</div>
		<div class="chp_xx">
			
			<table class="sjxx">
				<tr class="sj_detal">
					<th class="sj_ti_tit">提单号</th>
					<th class="sj_ti_tit">品名</th>
					<th class="sj_ti_tit">数量</th>
					<th class="sj_ti_tit">仓库</th>
					<th class="sj_ti_tit">订单号</th>
					<th class="sj_ti_tit">日期</th>
					<th class="sj_ti_tit">状态</th>
					<th class="sj_ti_tit">操作</th>								
				</tr>
				{foreach:items=$data}
				<tr class="sj_detal">
					<td>{$item['delivery_id']}</td>
					<td>{$item['name']}</td>
					<td>{$item['delivery_num']}{$item['unit']}</td>
					<td>{$item['store_name']}</td>
					<td><a href="{url:/contract/buyerDetail?id=$item['id']}">{$item['order_no']}</a></td>
					<td>{$item['delivery_time']}</td>
					<td style="color:#079207;">{$item['title']}</td>
					<td>
						{foreach:items=$item['action'] item=$v}
							<a href="{$v['url']}" {if:$v['confirm']}confirm=1{/if}>{$v['name']}</a>&nbsp;
						{/foreach}
					</td>
				</tr>
				{/foreach}
			</table>
			
		</div>
		<div class="page_num">
			<!-- 共0条记录&nbsp;当前第<font color="#FF0000">1</font>/0页&nbsp;
			<a href="#">第一页</a>&nbsp;
			<a href="#">上一页</a>&nbsp;
			<a href="#">下一页</a>&nbsp;
			<a href="#">最后页</a>&nbsp; 
			跳转到第 <input name="pagefind" id="pagefind" type="text" style="width:20px;font-size: 12px;" maxlength="5" value="1"> 页 
			<a><span class="style1">确定</span></a> -->

			{$page}
		</div>
	</div>
</div>
<!--end中间内容-->

