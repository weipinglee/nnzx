<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" />  菜单管理</h1>
<div class="bloc">
    <div class="title">
        菜单角色列表
    </div>
    <div class="content">
        <div class="pd-20">
	 <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a class="btn btn-primary radius" href="{url:/member/Menu/RoleAdd}"><i class=" icon-plus fa-plus"></i> 添加分组</a> </span>  </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="checkall" value=""></th>
				<th width="80">ID</th>
				<th width="100">分组名</th>
				<th width="100">描述</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data}
			<tr class="text-c">
				<td><input type="checkbox" value="" name="check"></td>
				<td>{$item['id']}</td>
				<td>{$item['name']}</td>
				<td>{$item['explanation']}</td>
				<td class="td-manage">
				<a title="编辑" href="{url:/member/Menu/RoleEdit}id/{$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a> 
				<a title="分配菜单" href="{url:/member/Menu/allocationUserMenu}id/{$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-list-alt fa-list-alt"></i></a> 
				<a title="删除" href="javascript:;" ajax_status=-1 ajax_url="{url:/member/Menu/RoleDel}id/{$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$bar}
	</div>
</div>
