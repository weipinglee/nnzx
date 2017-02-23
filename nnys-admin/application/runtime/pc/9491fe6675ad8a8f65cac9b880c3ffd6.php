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
    <h1><img src="/nnys-admin/views/pc/img/icons/posts.png" alt="" />幻灯片修改</h1>
    <div class="bloc">
        <div class="title">
            幻灯片修改
        </div>
        <div class="content">
            <div class="pd-20">
                <form action="http://info.nainaiwang.com/nnys-admin/tool/slide/editslide" method="post"  class="form form-horizontal"
                      id="adPositionAdd" auto_submit redirect_url="http://info.nainaiwang.com/nnys-admin/tool/slide/slidelist">
                    <div class="row cl">
                        <label class="form-label col-2"><span class="c-red">*</span> 位置：</label>
                        <div class="formControls col-5">
                            <select name='pos_id'>
                                <?php echo isset($pos_list)?$pos_list:"";?>
                            </select>
                        </div>
                        <div class="col-4"> </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-10">
                            <input type="text" name="name" value="<?php echo isset($slideInfo['name'])?$slideInfo['name']:"";?>" datatype="s2-50" nullmsg="名称不能为空" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">上传图片就替换原图片：</label>
                        <div class="formControls col-10">
                            <input type="hidden" name="uploadUrl"  value="http://info.nainaiwang.com/nnys-admin/tool/slide/upload" />
                            <input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this);" />
                        </div>
                        <div>
                            <img name="file2" src="<?php echo  \Library\Thumb::get($slideInfo['img']);?>"  />
                            <input type="hidden" name="imgfile2" value="<?php echo isset($slideInfo['img'])?$slideInfo['img']:"";?>" />

                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2"><span class="c-red"></span> 链接：</label>
                        <div class="formControls col-10">
                            <input type="text" name="link" class="input-text" value="<?php echo isset($slideInfo['link'])?$slideInfo['link']:"";?>" />
                        </div>
                        <div class="col-4"> </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-2">排序：</label>
                        <div class="formControls col-10">
                            <input type="text" name="order" value="<?php echo isset($slideInfo['order'])?$slideInfo['order']:"";?>" class="input-text" datatype="n1-100" nullmsg="排序字段不能为空" /> 数字越小，排列越靠前
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-3"><span class="c-red">*</span>是否开启：</label>
                        <div class="formControls col-5">

                            <input type="radio" name="status" value='1' <?php if($slideInfo['status']==1){?>checked="checked"<?php }?> id="">是
                            <input type="radio" name="status" value='0'<?php if($slideInfo['status']==0){?>checked="checked"<?php }?> id="">否

                        </div>
                        <div class="col-4"> </div>
                    </div>
                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <input type="hidden" value="<?php echo isset($slideInfo['id'])?$slideInfo['id']:"";?>" name="id">
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>

            </form>
        </div>


</body>
</html>