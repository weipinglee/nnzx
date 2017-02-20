
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 一般配置管理</h1>
<div class="bloc">
    <div class="title">
        配置列表
    </div>
    <div class="content">
        <div class="pd-20">
			{include:layout/search.tpl}
	 <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a class="btn btn-primary radius" href="{url:system/Confsystem/addConfig}"><i class=" icon-plus fa-plus"></i> 添加配置</a> </span>  </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="80">英文名</th>
				<th width="100">中文名</th>
				<th width="100">类型</th>
				<th width="100">值</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['list']}
			<tr class="text-c">
				<td>{$item['name']}</td>
				<td>{$item['name_zh']}</td>
				<td>{$item['type']}</td>
				<td>{$item['value']}</td>
				<td class="td-manage">
				 <a title="编辑" href="{url:system/Confsystem/editConfig?id=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
				 <a title="删除" href="javascript:;" ajax_status=-1 ajax_url="{url:system/Confsystem/delConfig?id=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$data['bar']}
	</div>
</div>




