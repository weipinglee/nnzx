<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 系统管理</h1>
<div class="bloc">
    <div class="title">
        信誉值配置列表
    </div>
    <div class="content">
        <div class="pd-20">
	 <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a class="btn btn-primary radius" href="{url:/system/Confsystem/creditOper}oper_type/1"><i class=" icon-plus fa-plus"></i> 添加配置</a> </span>  </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<!-- <th width="25"><input type="checkbox" name="checkall" value=""></th> -->
				<th width="80">参数名</th>
				<th width="100">中文名</th>
				<th width="100">参数类型</th>
				<th width="70">处理方式</th>
				<th width="50">参数值</th>
				<th width="50">排序</th>
				<th width="120">创建日期</th>
				<th width="170">解释说明</th>
				<th width="60">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data}
			<tr class="text-c">
				<!-- <td><input type="checkbox" value="" name="check"></td> -->
				<td>{$item['name']}</td>
				<td>{$item['name_zh']}</td>
				<td>{if:$item['type'] == 1}百分比{else:}数值{/if}</td>
				<td>{if:$item['sign'] == 1}减少{else:}增加{/if}</td>
				<td>{$item['value']}</td>
				<td>{$item['sort']}</td>
				<td>{$item['time']}</td>
				<td>{$item['note']}</td>
				<td class="td-manage">
				<a title="编辑" href="{url:/system/Confsystem/creditOper}oper_type/2/name/{$item['name']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a> 
				<a title="删除" href="javascript:;" ajax_status=-1 ajax_url="{url:/system/Confsystem/creditDel}name/{$item['name']}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$bar}
	</div>
</div>
