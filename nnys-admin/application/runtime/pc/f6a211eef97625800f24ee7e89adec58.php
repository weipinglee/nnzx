<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="/nnys-admin/views/pc/js/libs/jquery/1.11/jquery.min.js"></script>

	<link rel="stylesheet" href="/nnys-admin/views/pc/css/min.css" />
	<script type="text/javascript" src="/nnys-admin/views/pc/js/validform/validform.js"></script>
	<script type="text/javascript" src="/nnys-admin/views/pc/js/validform/formacc.js"></script>
	<script type="text/javascript" src="/nnys-admin/views/pc/js/layer/layer.js"></script>
	<link rel="stylesheet" href="/nnys-admin/views/pc/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/nnys-admin/views/pc/css/H-ui.min.css">
	<script type="text/javascript" src="/nnys-admin/js/area/Area.js" ></script>
	<script type="text/javascript" src="/nnys-admin/js/area/AreaData_min.js" ></script>
	<script type="text/javascript" src="/nnys-admin/views/pc/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>

<script type="text/javascript" src="/nnys-admin/views/pc/js/libs/jquery/1.11/jquery.min.js"></script>
<script type="text/javascript" src="/nnys-admin/views/pc/js/layer/layer.js"></script>
<script type="text/javascript" src="/nnys-admin/views/pc/js/validform/formacc.js"></script>
        <div id="content" class="white">
            <h1><img src="/nnys-admin/views/pc/img/icons/posts.png" alt="" /> 系统管理</h1>
<div class="bloc">
    <div class="title">
        管理员列表
    </div>
    <div class="content">
        <div class="pd-20">
	<div class="text-c">
		<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="" value="<?php echo isset($name)?$name:"";?>">
		<button type="submit" class="btn btn-success radius search-admin" id="" name=""><i class="icon-search fa-search"></i> 搜管理员</button>
	</div>
	 <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-trash fa-trash"></i>批量删除</a>  --><a class="btn btn-primary radius" href="http://info.nainaiwang.com/nnys-admin//system/admin/adminAdd/"><i class=" icon-plus fa-plus"></i> 添加管理员</a> </span>  </div>
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
		<?php if(!empty($data)) foreach($data as $key => $item){?>
			<tr class="text-c">
				<!-- <td><input type="checkbox" value="" name="check"></td> -->
				<td><?php echo isset($item['id'])?$item['id']:"";?></td>
				<td><u style="cursor:pointer" class="text-primary" onclick="member_show('张三','member-show.html','10001','360','400')"><?php echo isset($item['name'])?$item['name']:"";?></u></td>
				<td><?php echo isset($item['role_name'])?$item['role_name']:"";?></td>
				<td><?php echo isset($item['email'])?$item['email']:"";?></td>
				<td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
				<td class="td-status">
					<?php if($item['status'] == 0){?>
					
						<span class="label label-success radius">已启用</span>
					<?php }else{?>
						<span class="label label-error radius">停用</span>
					<?php }?>
				</td>
				<td class="td-manage">
					<?php if($item['status'] == 0){?>
					<a style="text-decoration:none" href="javascript:;" title="停用" ajax_status=1 ajax_url="http://info.nainaiwang.com/nnys-admin/system/admin/setstatus/id/<?php echo $item['id'];?>"><i class="icon-pause fa-pause"></i></a>
					<?php }elseif($item['status'] == 1){?>
					<a style="text-decoration:none" href="javascript:;" title="启用" ajax_status=0 ajax_url="http://info.nainaiwang.com/nnys-admin/system/admin/setstatus/id/<?php echo $item['id'];?>"><i class="icon-play fa-play"></i></a>
					<?php }?>
				 <a title="编辑" href="http://info.nainaiwang.com/nnys-admin//system/admin/adminUpdate/id/<?php echo isset($item['id'])?$item['id']:"";?>" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a> 
				 <a style="text-decoration:none" class="ml-5" href="http://info.nainaiwang.com/nnys-admin//system/admin/adminPwd/id/<?php echo isset($item['id'])?$item['id']:"";?>" title="修改密码"><i class="icon-unlock fa-unlock"></i></a> 
				 <a title="删除" href="javascript:;" ajax_status=-1 ajax_url="http://info.nainaiwang.com/nnys-admin//system/admin/setStatus/id/<?php echo isset($item['id'])?$item['id']:"";?>" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
			</tr>
		<?php }?>
		</tbody>

	</table>
		<?php echo isset($bar)?$bar:"";?>
	</div>
</div>
<script type="text/javascript">
	;$(function(){
		$('.search-admin').click(function(){
			var name = $(this).siblings('input').val();
			window.location.href = "http://info.nainaiwang.com/nnys-admin//system/admin/adminList/"+"?name="+name;
		});
	})
</script>






</body>
</html>