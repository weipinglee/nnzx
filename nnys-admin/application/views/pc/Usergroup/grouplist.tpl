<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 会员管理</h1>
<div class="bloc">
    <div class="title">
        会员角色列表
    </div>
    <div class="content">
        <div class="pd-20">
	 <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a class="btn btn-primary radius" href="{url:/member/usergroup/groupAdd}"><i class=" icon-plus fa-plus"></i> 添加分组</a> </span>  </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="checkall" value=""></th>
				<th width="80">ID</th>
				<th width="100">会员等级</th>
				<th width="100">信誉值分界线</th>
				<th width="70">分组图标</th>
				<th width="130">保证金比率</th>
				<th width="130">自由报盘费用比率</th>
				<th width="170">委托报盘手续费比率</th>
				<th width="70">创建日期</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data}
			<tr class="text-c">
				<td><input type="checkbox" value="" name="check"></td>
				<td>{$item['id']}</td>
				<td>{$item['group_name']}</td>
				<td>{$item['credit']}</td>
				<td>{if:isset($item['icon_thumb'])}<img src="{$item['icon_thumb']}"/>{else:}无{/if}</td>
				<td>{$item['caution_fee']}</td>
				<td>{$item['free_fee']}</td>
				<td>{$item['depute_fee']}</td>
				<td>{$item['create_time']}</td>
				<td class="td-manage">
				<a title="编辑" href="{url:/member/usergroup/groupEdit}id/{$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a> 
				<!--<a title="分配菜单" href="{url:/member/usergroup/allocationUserMenu}id/{$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
				--><a title="删除" href="javascript:;" ajax_status=-1 ajax_url="{url:/member/usergroup/groupDel}id/{$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$bar}
	</div>
</div>
