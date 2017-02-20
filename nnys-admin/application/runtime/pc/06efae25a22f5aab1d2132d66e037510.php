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

<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/content/settings/main.js"></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/libs/jquery/1.11/jquery.min.js"></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/validform/validform.js"></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/validform/formacc.js"></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/layer/layer.js"></script>
<script type="text/javascript" src='/nnzx/nnys-admin/js/upload/ajaxfileupload.js'></script>
<script type="text/javascript" src='/nnzx/nnys-admin/js/upload/upload.js'></script>
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/My97DatePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/nnzx/nnys-admin/views/pc/content/settings/style.css" />





<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="/nnzx/nnys-admin/views/pc/img/icons/posts.png" alt="" />广告添加</h1>

    <div class="bloc">
        <div class="title">
            广告添加
        </div>
        <div >
            <div class="pd-20">
                <form action="http://localhost/nnzx/nnys-admin/tool/advert/admanageadd" method="post"  class="form form-horizontal"
                      id="adPositionAdd" auto_submit redirect_url="http://localhost/nnzx/nnys-admin/tool/advert/admanagelist">

                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-2">
                            <input class="input-text" type="text" name="name" />
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-2">图片：</label>
                        <div class="formControls col-10">
                            <input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this,'http://localhost/nnzx/nnys-admin//upload/upload');" />
                        </div>
                        <div>
                            <img name="file2" />
                            <input type="hidden" name="imgfile2"  />

                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">广告位：</label>
                        <div class="formControls col-10">
                            <select name="position_id" >
                                <option value="0">选择广告位</option>
                                <?php if(!empty($adPoDate)) foreach($adPoDate as $key => $item){?>
                                <option value="<?php echo isset($item['id'])?$item['id']:"";?>">
                                    <?php echo isset($item['name'])?$item['name']:"";?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">链接地址：</label>
                        <div class="formControls col-2">
                            <input type="text" class="input-text" name="link" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">排序：</label>
                        <div class="formControls col-2">
                            <input type="text" class="input-text" name="order" /> 数字越小，排列越靠前
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">开始时间：</label>
                        <div class="formControls col-2">
                            <input class="Wdate input-text"  onclick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" name="start_time" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">结束时间：</label>
                        <div class="formControls col-2">
                            <input class="Wdate input-text" onclick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})"  type="text" name="end_time" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">描述：</label>
                        <div class="formControls col-2">
                            <input type="text" name="description" class="input-text"/>
                        </div>
                    </div>
                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>

            </form>
        </div>


</body>
</html>