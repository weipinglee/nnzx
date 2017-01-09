
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 修改手机号</h1>
<div class="bloc">
    <div class="title">
        已审核列表
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
				<th width="100">真实姓名/企业名称</th>
				<th width="90">联系电话</th>
				<th width="90">新的手机号</th>
				<th width="150">申请时间</th>
				<th width="130">状态</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['list']}
			<tr class="text-c">

				<td>{$item['id']}</td>
				<td><u style="cursor:pointer" class="text-primary" >{$item['username']}</u></td>
				<td>{if:empty($item['name'])}{$item['company_name']}{else:}{$item['name']}{/if}</td>
				<td>{$item['mobile']}</td>
				<td>{$item['new_mobile']}</td>
				<td>{$item['apply_time']}</td>
				<td>{$item['status_txt']}</td>
				<td class="td-manage">
				<a title="编辑" href="{url:member/member/teldetail?id=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i> </td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$data['bar']}
	</div>
</div>
