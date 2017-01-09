
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 会员管理</h1>
<div class="bloc">
    <div class="title">
        会员日志列表
    </div>
    <div class="content">
        <div class="pd-20">
			{include:layout/search.tpl}
		</div>

	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">

				<th width="80">ID</th>
				<th width="100">用户名</th>
				<th width="100">账户类型</th>
				<th width="100">银行名称</th>
				<th width="100">期初资金</th>
				<th width="100">期末资金</th>
				<th width="100">当日划入</th>
				<th width="100">当日划出</th>
				<th width="100">期初冻结资金</th>
				<th width="100">期末冻结资金</th>
				<th width="100">当前冻结资金</th>
				<th width="100">当前解冻资金</th>
				<th width="100">可用资金</th>
				<th width="90">结算时间</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['list']}
			<tr class="text-c">

				<td>{$item['id']}</td>
				<td>{$item['username']}</td>
				<td>{set: echo \nainai\member::getType($item['type'])}</td>
				<td>{$item['bank_name']}</td>
<td>{$item['begin_fund']}</td>
<td>{$item['end_fund']}</td>
				<td>{$item['today_in']}</td>
				<td>{$item['today_out']}</td>
				<td>{$item['begin_freeze_fund']}</td>
				<td>{$item['end_freeze_fund']}</td>
				<td>{$item['freeze_fund']}</td>
				<td>{$item['thaw_fund']}</td>
				<td>{$item['use_fund']}</td>
				<td>{$item['create_time']}</td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$data['bar']}
	</div>
</div>
