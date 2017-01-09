<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 系统管理</h1>
<div class="bloc">
    <div class="title">
        管理员操作记录
    </div>
    <div class="content">
        <div class="pd-20">
	{include:layout/search.tpl}
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<!-- <th width="25"><input type="checkbox" name="checkall" value=""></th> -->
				<th width="80">ID</th>
				<th width="100">用户名</th>
				<th width="130">时间</th>
				<th width="100">ip</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach:items=$data['list']}
			<tr class="text-c">
				<!-- <td><input type="checkbox" value="" name="check"></td> -->
				<td>{$item['id']}</td>
				<td>{$item['name']}</td>
				<td>{$item['datetime']}</td>
				<td class="td-manage">
					{$item['ip']}
				 </td>
				<td class="td-manage">
					{$item['content']}
				</td>
			</tr>
		{/foreach}
		</tbody>

	</table>
		{$data['bar']}
	</div>
</div>
<script type="text/javascript">
	;$(function(){
		$('.search-admin').click(function(){
			var name = $(this).siblings('input').val();
			window.location.href = "{url:/system/admin/logList}"+"?name="+name;
		});
	})
</script>



