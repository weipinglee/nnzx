
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
				<th width="100">操作时间</th>
				<th width="100">action</th>
				<th width="100">操作内容</th>
				<th width="90">ip</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['list']}
			<tr class="text-c">

				<td>{$item['id']}</td>
				<td>{$item['username']}</td>
				<td>{$item['datetime']}</td>
				<td><u style="cursor:pointer" class="text-primary" >{$item['action']}</u></td>
				
<td>{$item['content']}</td>
<td>{$item['ip']}</td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$data['bar']}
	</div>
</div>
