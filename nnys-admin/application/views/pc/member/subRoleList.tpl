
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 子账户角色管理</h1>
<div class="bloc">
    <div class="title">
        角色列表
    </div>
    <div class="content">
        <div class="pd-20">

	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="checkall" value=""></th>
				<th width="100">角色名</th>
				<th width="90">是否开启</th>
				<th width="150">备注</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$subroles}
			<tr class="text-c">
				<td><input type="checkbox" value="" name="check"></td>
				<td><u style="cursor:pointer" class="text-primary" >{$item['name']}</u></td>

				<td>{$item['status']}</td>
				<td>{$item['note']}</td>
				<td class="td-manage">
					<a style="text-decoration:none" onClick="member_stop(this,'10001')" href="javascript:;" title="停用"><i class="icon-pause fa-pause"></i></a>
					<a title="编辑" href="{url:/member/roleAdd?id=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
					<a title="删除" href="{url:/member/subRoleDel?id=$item['id']}" onclick="member_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$bar}
	</div>
</div>

