<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 系统管理</h1>
<div class="bloc">
    <div class="title">
        管理员列表
    </div>
    <div class="content">
        <div class="pd-20">
	<div class="text-c">
		<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="" value="{$name}">
		<button type="submit" class="btn btn-success radius search-admin" id="" name=""><i class="icon-search fa-search"></i> 搜管理员</button>
	</div>
	 <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-trash fa-trash"></i>批量删除</a>  --><a class="btn btn-primary radius" href="{url:/system/admin/adminAdd}"><i class=" icon-plus fa-plus"></i> 添加管理员</a> </span>  </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<!-- <th width="25"><input type="checkbox" name="checkall" value=""></th> -->
				<th width="80">ID</th>
				<th width="100">用户名</th>
				<th width="100">所属分组</th>
				<th width="150">邮箱</th>
				<th width="130">加入时间</th>
				<th width="70">状态</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data}
			<tr class="text-c">
				<!-- <td><input type="checkbox" value="" name="check"></td> -->
				<td>{$item['id']}</td>
				<td><u style="cursor:pointer" class="text-primary" onclick="member_show('张三','member-show.html','10001','360','400')">{$item['name']}</u></td>
				<td>{$item['role_name']}</td>
				<td>{$item['email']}</td>
				<td>{$item['create_time']}</td>
				<td class="td-status">
					{if:$item['status'] == 0}
					
						<span class="label label-success radius">已启用</span>
					{else:}
						<span class="label label-error radius">停用</span>
					{/if}
				</td>
				<td class="td-manage">
					{if:$item['status'] == 0}
					<a style="text-decoration:none" href="javascript:;" title="停用" ajax_status=1 ajax_url="{url:system/admin/setStatus?id=$item['id']}"><i class="icon-pause fa-pause"></i></a>
					{elseif:$item['status'] == 1}
					<a style="text-decoration:none" href="javascript:;" title="启用" ajax_status=0 ajax_url="{url:system/admin/setStatus?id=$item['id']}"><i class="icon-play fa-play"></i></a>
					{/if}
				 <a title="编辑" href="{url:/system/admin/adminUpdate}id/{$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a> 
				 <a style="text-decoration:none" class="ml-5" href="{url:/system/admin/adminPwd}id/{$item['id']}" title="修改密码"><i class="icon-unlock fa-unlock"></i></a> 
				 <a title="删除" href="javascript:;" ajax_status=-1 ajax_url="{url:/system/admin/setStatus}id/{$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$bar}
	</div>
</div>
<script type="text/javascript">
	;$(function(){
		$('.search-admin').click(function(){
			var name = $(this).siblings('input').val();
			window.location.href = "{url:/system/admin/adminList}"+"?name="+name;
		});
	})
</script>



