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


<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="/nnzx/nnys-admin/views/pc/img/icons/posts.png" alt="" /> 帮助分类管理</h1>
    <div class="bloc">
        <div class="title">
            帮助分类列表
        </div>
        <div class="content">
            <div class="cl pd-5 bg-1 bk-gray"> <a class="btn btn-primary radius" href="http://localhost/nnzx/nnys-admin//tool/help/helpCatAdd/"><i class=" icon-plus fa-plus"></i> 添加分类</a> </span>  </div>
            <div class="pd-20">

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="checkall" value=""></th>
                            <th width="100">名称</th>
                            <th width="60">状态</th>
                            <th width="50">排序</th>
                            <th width='100'>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($helpCatList)) foreach($helpCatList as $key => $item){?>
                            <tr class="text-c">
                                <td><input type="checkbox" value="" name="check"></td>
                                <td><u style="cursor:pointer" class="text-primary" ><?php echo isset($item['name'])?$item['name']:"";?></u></td>
                                <td class="td-status">
                                    <?php if($item['status'] == 1){?>
                                        <span class="label label-success radius" >已启用</span>
                                    <?php }else{?>
                                        <span class="label label-error radius">停用</span>
                                    <?php }?>
                                </td>
                                <td><?php echo isset($item['sort'])?$item['sort']:"";?></td>
                                <td class="td-manage">
                                    <?php if($item['status'] == 1){?>
                                        <a style="text-decoration:none" href="javascript:;" title="停用" ajax_status=0 ajax_url="http://localhost/nnzx/nnys-admin/tool/help/setcatstatus/id/<?php echo $item['id'];?>"><i class="icon-pause fa-pause"></i></a>
                                    <?php }elseif($item['status'] == 0){?>
                                        <a style="text-decoration:none" href="javascript:;" title="启用" ajax_status=1 ajax_url="http://localhost/nnzx/nnys-admin/tool/help/setcatstatus/id/<?php echo $item['id'];?>"><i class="icon-play fa-play"></i></a>
                                    <?php }?>
                                    <a title="编辑" href="http://localhost/nnzx/nnys-admin//tool/help/helpCatAdd/?id=<?php echo isset($item['id'])?$item['id']:"";?>" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
                                    <a title="删除" href="javascript:void(0);" ajax_status=-1 ajax_url="http://localhost/nnzx/nnys-admin/tool/help/delhelpcat/id/<?php echo $item['id'];?>" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
                            </tr>
                        <?php }?>
                        </tbody>
                        <script type="text/javascript">
                            function delFundOut(name,obj){
                                var obj=$(obj);
                                var name=name;
                                var url="http://localhost/nnzx/nnys-admin//tool/help/delHelpCat/";
                                if(confirm("确定要删除吗")){
                                    $.ajax({
                                        type:'get',
                                        cache:false,
                                        data:{id:name},
                                        url:url,
                                        dataType:'json',
                                        success:function(msg){
                                            if(msg['success']==1){

                                                obj.parents("tr").remove();
                                            }else{
                                                alert(msg['info']);
                                            }
                                        }
                                    });
                                }
                            }
                        </script>
                    </table>
                    <?php echo isset($pageBar)?$pageBar:"";?>
                </div>
            </div>


</body>
</html>