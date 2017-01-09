
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 会员管理</h1>
<div class="bloc">
    <div class="title">
        会员列表
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
				<th width="100">真实姓名</th>
				<th width="100">企业名称</th>
				<th width="100">信誉会员等级</th>
				<th width="100">收费会员</th>
				<th width="90">手机</th>
				<th width="150">邮箱</th>
				<th width="130">注册时间</th>
				<th width="130">代理商</th>
				<th width="130">业务员</th>
				<th width="130">状态</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['list']}
			<tr class="text-c">
			
				<td>{$item['id']}</td>
				<td><u style="cursor:pointer" class="text-primary" >{$item['username']}</u></td>
<td>{$item['true_name']}</td>
<td>{$item['company_name']}</td>
<td>{$item['user_rank']['group_name']}</td>
<td>{if:$item['vip']>0}是{else:}否{/if}</td>
				<td>{$item['mobile']}</td>
				<td>{$item['email']}</td>
				<td>{$item['create_time']}</td>
				<td>{$item['agent_name']}</td>
				<td>{$item['ser_name']}</td>
				<td class="td-status">
				{if:$item['status'] == \nainai\user\User::NOMAL}
					<span class="label label-success radius">已启用</span>
				{else:}

					<span class="label label-error radius">停用</span>

				{/if}
				</td>
				<td class="td-manage">
				{if:$item['status'] == \nainai\user\User::NOMAL}
				<a style="text-decoration:none" ajax_status=0  ajax_url="{url:member/member/ajaxupdatestatus?id=$item['id']}"  href="javascript:;" title="停用"><i class="icon-pause fa-pause"></i></a>
				{else:}
				<a style="text-decoration:none" ajax_status=1  ajax_url="{url:member/member/ajaxupdatestatus?id=$item['id']}"  href="javascript:;" title="启用"><i class="icon-play fa-play"></i></a>
				{/if} 
				<a title="编辑" href="{url:member/member/detail?id=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i> 
				<a title="删除" href="javascript:;" ajax_status=-1 ajax_url="{url:member/member/ajaxupdatestatus?id=$item['id']&delete=1}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$data['bar']}
	</div>
</div>
