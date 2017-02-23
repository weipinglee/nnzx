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

<script type="text/javascript" src="/nnys-admin/views/pc/content/settings/main.js"></script>
<script type="text/javascript" src="/nnys-admin/views/pc/js/libs/jquery/1.11/jquery.min.js"></script>
<script type="text/javascript" src="/nnys-admin/views/pc/js/validform/validform.js"></script>
<script type="text/javascript" src="/nnys-admin/views/pc/js/validform/formacc.js"></script>
<script type="text/javascript" src="/nnys-admin/views/pc/js/layer/layer.js"></script>
<script type="text/javascript" src='/nnys-admin/js/upload/ajaxfileupload.js'></script>
<script type="text/javascript" src='/nnys-admin/js/upload/upload.js'></script>
<script type="text/javascript" src="/nnys-admin/views/pc/js/time/WdatePicker.js"></script>
<link rel="stylesheet" href="/nnys-admin/views/pc/content/settings/style.css" />





<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="/nnys-admin/views/pc/img/icons/posts.png" alt="" />幻灯片位置修改</h1>
    <div class="bloc">
        <div class="title">
            幻灯片位置修改
        </div>
        <div class="content">
            <div class="pd-20">
                <form action="http://info.nainaiwang.com/nnys-admin/tool/slidepos/editslidepos" method="post"  class="form form-horizontal"
                      id="adPositionAdd" auto_submit redirect_url="http://info.nainaiwang.com/nnys-admin/tool/slidepos/slideposlist">

                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-10">
                            <input type="text" name="name" value="<?php echo isset($slideposInfo['name'])?$slideposInfo['name']:"";?>" datatype="s2-50" nullmsg="名称不能为空" />
                        </div>
                    </div>
                    
                    <div class="row cl">
                        <label class="form-label col-2">描述：</label>
                        <div class="formControls col-10">
                            <input type="text" name="intro" value="<?php echo isset($slideposInfo['intro'])?$slideposInfo['intro']:"";?>" class="input-text" datatype="*1-100" nullmsg="描述不能为空" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-3"><span class="c-red">*</span>是否开启：</label>
                        <div class="formControls col-5">

                            <input type="radio" name="status" value='1' <?php if($slideposInfo['status']==1){?>checked="checked"<?php }?> id="">是
                            <input type="radio" name="status" value='0'<?php if($slideposInfo['status']==0){?>checked="checked"<?php }?> id="">否

                        </div>
                        <div class="col-4"> </div>
                    </div>
                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <input type="hidden" value="<?php echo isset($slideposInfo['id'])?$slideposInfo['id']:"";?>" name="id">
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>

            </form>
        </div>


</body>
</html>