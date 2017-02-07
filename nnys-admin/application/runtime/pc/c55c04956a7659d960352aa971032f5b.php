<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/libs/jquery/1.11/jquery.min.js"></script>

	<link rel="stylesheet" href="/nnzx/nnys-admin/views/pc/css/min.css" />
	<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/validform/validform.js"></script>
	<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/validform/formacc.js"></script>
	<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/layer/layer.js"></script>
	<link rel="stylesheet" href="/nnzx/nnys-admin/views/pc/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/nnzx/nnys-admin/views/pc/css/H-ui.min.css">
	<script type="text/javascript" src="/nnzx/nnys-admin/js/area/Area.js" ></script>
	<script type="text/javascript" src="/nnzx/nnys-admin/js/area/AreaData_min.js" ></script>
	<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>

<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/libs/jquery/1.11/jquery.min.js"></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/layer/layer.js"></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/validform/formacc.js"></script>
        <div id="content" class="white">
            <h1><img src="/nnzx/nnys-admin/views/pc/img/icons/posts.png" alt="" /> 系统管理</h1>
<div class="bloc">
    <div class="title">
        管理员操作记录
    </div>
    <div class="content">
        <div class="pd-20">
	
<?php if($data['search']!=''){?>
    <?php if( empty($begin)){?>
    <?php $begin=\Library\safe::filterGet('begin');; ?>
    <?php }?>
    <?php if( empty($end)){?>
    <?php $end=\Library\safe::filterGet('end');; ?>
    <?php }?>

    <?php $like=\Library\safe::filterGet('like');; ?>
    <?php $min=\Library\safe::filterGet('min');; ?>
    <?php $max=\Library\safe::filterGet('max');; ?>
    <?php $select=\Library\safe::filterGet('select');; ?>

    <?php if($select==='all' || !isset($_GET['select']) ){?>
        <?php $select = -9999; ?>
    <?php }?>

    <form action="" method="get" >
        <div class="text-c">
            <?php if(isset($data['search']['time'])){?>
                <?php echo isset($data['search']['time'])?$data['search']['time']:"";?>：

                <input type="text" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm:ss' })" id="datemin" class="input-text Wdate" name="begin" value="<?php echo isset($begin)?$begin:"";?>" style="width:120px;">
                -
                <input type="text" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm:ss' })"id="datemax" class="input-text Wdate" name="end" value="<?php echo isset($end)?$end:"";?>" style="width:120px;">
            <?php }?>

            <?php if(isset($data['search']['like'])){?>
                <input type="text" class="input-text" style="width:250px" placeholder="输入<?php echo isset($data['search']['like'])?$data['search']['like']:"";?>" id="" name="like" value="<?php echo isset($like)?$like:"";?>">
            <?php }?>
            <?php if( !empty($data['search']['likes'])){?>
                <?php if(!empty($data['search']['likes'])) foreach($data['search']['likes'] as $key => $item){?>
                    <?php echo isset($item)?$item:"";?>：<input type="text" class="input-text" style="width:250px" placeholder="输入<?php echo isset($item)?$item:"";?>"  name="<?php echo isset($key)?$key:"";?>" value="<?php echo isset($data['search']['likesval'][$key])?$data['search']['likesval'][$key]:"";?>">
                <?php }?>
            <?php }?>
            <?php if(isset($data['search']['between'])){?>
                <?php echo isset($data['search']['between'])?$data['search']['between']:"";?>:
                <input type="text" class="input-text" style="width:100px"  id="" name="min" value="<?php echo isset($min)?$min:"";?>">-
                <input type="text" class="input-text" style="width:100px"  id="" name="max" value="<?php echo isset($max)?$max:"";?>">
            <?php }?>
            <?php if(isset($data['search']['select'])){?>
                <?php echo isset($data['search']['select'])?$data['search']['select']:"";?>：
                <select name="select" >
                    <option value="all">所有</option>
                    <?php if(!empty($data['search']['selectData'])) foreach($data['search']['selectData'] as $key => $item){?>
                        <option value="<?php echo isset($key)?$key:"";?>" <?php if($select==$key){?>selected=true<?php }?>><?php echo isset($item)?$item:"";?></option>
                    <?php }?>
                </select>
            <?php }?>
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="icon-search fa-search"></i> 搜索</button>
            
            <?php if( isset($data['search']['down']) && $data['search']['down']==1){?>
            <button type="submit" class="btn btn-success radius" id="" name="down" value="1"><i class="icon-search fa-search"></i> 导出</button>
            <?php }?>

        </div>
    </form>
<?php }?>

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
		<?php if(!empty($data['list'])) foreach($data['list'] as $key => $item){?>
			<tr class="text-c">
				<!-- <td><input type="checkbox" value="" name="check"></td> -->
				<td><?php echo isset($item['id'])?$item['id']:"";?></td>
				<td><?php echo isset($item['name'])?$item['name']:"";?></td>
				<td><?php echo isset($item['datetime'])?$item['datetime']:"";?></td>
				<td class="td-manage">
					<?php echo isset($item['ip'])?$item['ip']:"";?>
				 </td>
				<td class="td-manage">
					<?php echo isset($item['content'])?$item['content']:"";?>
				</td>
			</tr>
		<?php }?>
		</tbody>

	</table>
		<?php echo isset($data['bar'])?$data['bar']:"";?>
	</div>
</div>
<script type="text/javascript">
	;$(function(){
		$('.search-admin').click(function(){
			var name = $(this).siblings('input').val();
			window.location.href = "http://localhost/nnzx/nnys-admin/system/admin/logList/"+"?name="+name;
		});
	})
</script>






</body>
</html>