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
    <h1><img src="/nnys-admin/views/pc/img/icons/posts.png" alt="" /> 广告位列表</h1>
    <div class="bloc">
        <div class="title">
            广告位列表
        </div>
        <div class="content">
            <div class="pd-20">
                <div class="cl pd-5 bg-1 bk-gray"> <span class="l"><a class="btn btn-primary radius" href="http://info.nainaiwang.com/nnys-admin/tool/advert/adpositionadd"><i class=" icon-plus fa-plus"></i> 添加广告位</a> </span>  </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="checkall" value=""></th>
                            <th width="100">广告位名称</th>
                            <th width="60">宽高</th>
                            <th width="80">开启状态 </th>

                            <th width='100'>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($adPositionList)) foreach($adPositionList as $key => $item){?>
                        <tr class="text-c">
                            <td><input type="checkbox" value="" name="check"></td>
                            <td><u style="cursor:pointer" class="text-primary" ><?php echo isset($item['name'])?$item['name']:"";?></u></td>
                            <td><?php echo isset($item['width'])?$item['width']:"";?>x<?php echo isset($item['height'])?$item['height']:"";?></td>
                            <td>
                                <?php if($item['status']==1){?>
                                开启
                                <?php }else{?>
                                关闭
                                <?php }?>
                            </td>
                            <td class="td-manage">
                                <a title="编辑" href="http://info.nainaiwang.com/nnys-admin/tool/advert/adpositionedit?id=<?php echo isset($item['id'])?$item['id']:"";?>" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
                                <a title="删除" href="javascript:void(0);" ajax_status=-1 ajax_url="http://info.nainaiwang.com/nnys-admin/tool/advert/delposition/id/<?php echo $item['id'];?>" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
                        </tr>
                        <?php }?>
                        </tbody>

                    </table>
                    <?php echo isset($reBar)?$reBar:"";?>
                </div>
            </div>




</body>
</html>