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

<link rel="stylesheet" href="/nnys-admin/views/pc/content/settings/style.css" />
<script type="text/javascript" src="/nnys-admin/views/pc/js/My97DatePicker/WdatePicker.js"></script>




<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="/nnys-admin/views/pc/img/icons/posts.png" alt="" />广告修改</h1>
    <div class="bloc">
        <div class="title">
            广告修改
        </div>
        <div >
            <div class="pd-20">
                <form action="http://info.nainaiwang.com/nnys-admin/tool/advert/admanageedit" method="post"  class="form form-horizontal"
                      id="adPositionAdd" auto_submit redirect_url="http://info.nainaiwang.com/nnys-admin/tool/advert/admanagelist">

                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-2">
                            <input type="text" name="name" class="input-text" value="<?php echo isset($info['name'])?$info['name']:"";?>" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">图片：</label>
                        <div class="formControls col-2">
                            <img name="file2" src="<?php echo isset($info['content'])?$info['content']:"";?>">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">上传图片就替换原图片：</label>
                        <div class="formControls col-2">
                            <input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this,'http://info.nainaiwang.com/nnys-admin//upload/upload');" />
                        </div>
                        <div>
                            <input type="hidden" name="imgfile2"  />

                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">广告位：</label>
                        <div class="formControls col-2">
                            <select name="position_id">
                                <option value="">请选择...</option>
                                <?php if(!empty($adPoDate)) foreach($adPoDate as $key => $item){?>
                                <option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($item['id']==$info['position_id']){?>selected<?php }?>>
                                    <?php echo isset($item['name'])?$item['name']:"";?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">链接地址：</label>
                        <div class="formControls col-2">
                            <input type="text" name="link" class="input-text" value="<?php echo isset($info['link'])?$info['link']:"";?>" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">排序：</label>
                        <div class="formControls col-2">
                            <input type="text" name="order" class="input-text" value="<?php echo isset($info['order'])?$info['order']:"";?>" /> 数字越小，排列越靠前
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">开始时间：</label>
                        <div class="formControls col-2">
                            <input class="Wdate input-text" onclick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" name="start_time" value="<?php echo isset($info['start_time'])?$info['start_time']:"";?>"/>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">结束时间：</label>
                        <div class="formControls col-2">
                            <input class="Wdate input-text" onclick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" name="end_time" value="<?php echo isset($info['end_time'])?$info['end_time']:"";?>" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">描述：</label>
                        <div class="formControls col-2">
                            <input type="text" name="description" class="input-text" value="<?php echo isset($info['description'])?$info['description']:"";?>"/>
                        </div>
                    </div>
                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <input type='hidden' value="<?php echo isset($info['id'])?$info['id']:"";?>" name='id' />
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>

            </form>
        </div>


</body>
</html>