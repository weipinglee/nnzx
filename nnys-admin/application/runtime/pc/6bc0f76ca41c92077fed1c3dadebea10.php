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


<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="/nnys-admin/views/pc/img/icons/posts.png" alt="" /> 广告列表</h1>

    <div class="bloc">
        <div class="title">
            广告列表
        </div>
        <div class="content">
            <div class="pd-20">
                <div class="cl pd-5 bg-1 bk-gray"> <span class="l"><a class="btn btn-primary radius" href="http://info.nainaiwang.com/nnys-admin/tool/advert/admanageadd"><i class=" icon-plus fa-plus"></i> 添加广告</a> </span>  </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="checkall" value=""></th>
                            <th width="100">广告名称</th>
                            <th width="90">广告位名称</th>
                            <th width="60">排序</th>
                            <th width="150">开始时间</th>
                            <th width="100">结束时间</th>
                            <th width='100'>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($adManageList)) foreach($adManageList as $key => $item){?>
                        <tr class="text-c">
                            <td><input type="checkbox" value="" name="check"></td>
                            <td><u style="cursor:pointer" class="text-primary" ><?php echo isset($item['name'])?$item['name']:"";?></u></td>
                            <td><?php echo isset($item['pname'])?$item['pname']:"";?></td>
                            <td><?php echo isset($item['order'])?$item['order']:"";?></td>
                            <td><?php echo isset($item['start_time'])?$item['start_time']:"";?></td>
                            <td><?php echo isset($item['end_time'])?$item['end_time']:"";?></td>
                            <td class="td-manage">
                                <a title="编辑" href="http://info.nainaiwang.com/nnys-admin/tool/advert/admanageedit?id=<?php echo isset($item['id'])?$item['id']:"";?>" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
                                <a title="删除" href="javascript:void(0);" ajax_status=-1 ajax_url="http://info.nainaiwang.com/nnys-admin/tool/advert/delmanage/id/<?php echo $item['id'];?>" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
                        </tr>
                        <?php }?>
                        </tbody>

                    </table>
                    <?php echo isset($reBar)?$reBar:"";?>
                </div>
            </div>




</body>
</html>