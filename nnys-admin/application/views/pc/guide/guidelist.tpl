   <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
    <script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>

        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="img/icons/posts.png" alt="" /> 导航栏目管理</h1>
<div class="bloc">
    <div class="title">
        导航栏目列表
    </div>
    <div class="content">
        <div class="pd-20">

			<div class="header_tit">
				<ul>
				{foreach: items=$bar item=$value key=$key}
				<li><a class="header_nav main cur" {if:$key==$type}style="font-weight:bold;"{/if} href="{url:/guide/guideList?type=$key}">{$value}</a></li>
		                        {/foreach}

				</ul>
			</div>
	<div class="zhu_nav">
	 	<div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-trash fa-trash"></i>批量删除</a> <a class="btn btn-primary radius" href="{url:/guide/addGuide}"><i class=" icon-plus fa-plus"></i> 添加导航</a> </span> </div>
		<table class="table table-border table-bordered table-hover table-bg table-sort">
			<tr class="text-c">
				<th><input type="checkbox" name="checkall" value=""></th>
				<th>ID</th>
				<th>导航名称</th>
				<th>链接地址</th>
				<th>排序</th>
				<th>操作</th>
			</tr>

			{foreach: items=$guideData item=$data}
			{set: $key++}
			<tr class="text-c">
				<td><input type="checkbox" value="1" name="check"></td>
				<td>{$key}</td>
				<td><u style="cursor:pointer" class="text-primary">{$data['name']}</u></td>
				<td>{$data['link']}</td>
				<td>{$data['sort']}</td>
				<td class="td-manage"> 
					<a title="编辑" href="{url:/guide/updateGuide?id=$data['id']}"  style="text-decoration:none"><i class="icon-edit fa-edit"></i></a> 
					 <a title="删除" href="javascript:;" ajax_status=-1 ajax_url="{url:/guide/deleteGuide?id=$data['id']}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a>
				</td>
			</tr>
			{/foreach}
		</table>

		<span>{$pageHtml}</span>
	</div>

	</div>
</div>

