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
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/validform/validform.js"></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/validform/formacc.js"></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/layer/layer.js"></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/content/settings/main.js"></script>
<link rel="stylesheet" href="/nnzx/nnys-admin/views/pc/content/settings/style.css" />
<link rel="stylesheet" type="text/css" href="/nnzx/nnys-admin/views/pc/css/H-ui.admin.css">
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src='/nnzx/nnys-admin/js/upload/ajaxfileupload.js'></script>
<script type="text/javascript" src='/nnzx/nnys-admin/js/upload/upload.js'></script>
<!--
      CONTENT
                -->
<div id="content" class="white">

    <h1><img src="/nnzx/nnys-admin/views/pc/img/icons/dashboard.png" alt="" />幻灯片管理

    </h1>

    <div class="bloc">
        <div class="title">
            添加幻灯片
        </div>
        <div class="pd-20">

            <form action="http://localhost/nnzx/nnys-admin/tool/slide/addslide" method="post" class="form form-horizontal" id="form-member-add" auto_submit redirect_url="http://localhost/nnzx/nnys-admin/tool/slide/slidelist">
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 位置：</label>
                    <div class="formControls col-5">
                        <select name='pos_id'>
                            <?php echo isset($pos_list)?$pos_list:"";?>
                        </select>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 名称：</label>
                    <div class="formControls col-5">
                        <input type="text" name="name" class="input-text" datatype="s2-50" nullmsg="名称不能为空" />
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>图片：</label>
                    <div class="formControls col-5">
                        <div class="">
                            <input type="hidden" name="uploadUrl"  value="http://info.nainaiwang.com/nnzx/nnys-admin/tool/slide/upload" />
                            <input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this);" />
                        </div>
                        <div>
                            <img name="file2" />
                            <input type="hidden" name="imgfile2" />

                        </div>

                    </div>
                    <div class="col-4"> </div>

                </div>
                
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red"></span> 背景颜色：</label>
                    <div class="formControls col-5">
                        <input type="text" name="bgcolor" class="input-text" />
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>排序：</label>
                    <div class="formControls col-5">
                        <input type="text" name="order" value="100" class="input-text" datatype="n1-100" nullmsg="排序字段不能为空">排序字段为数字,越小越靠前
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>是否开启：</label>
                    <div class="formControls col-5">

                            <input type="radio" name="status" value='1' checked='1' id="">是
                            <input type="radio" name="status" value='0' id="">否

                    </div>
                    <div class="col-4"> </div>
                </div>

                <div class="row cl">
                    <div class="col-9 col-offset-3">
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>





</body>
</html>