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

<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/ueditor/ueditor.config.js"></script>

<script src="/nnzx/nnys-admin/views/pc/js/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/nnzx/nnys-admin/views/pc/js/uploadify/uploadify.css"> 
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/ueditor/ueditor.all.js"></script>
<!--
      CONTENT
                -->
<style type="text/css">
    .upl {width: 75%;float: right;margin-top: -35px}
    .upl img{width: 200px;height: 200px;margin-left: 15px}
    .upl .images{margin-top: 30px;margin-bottom: 30px;height: 200px}
    .upl .images .to{position: relative;float: left;widows: 200px;}
    .upl .images .to span{position: absolute;right: -10px;top:-10px;background-color:#ddd;color: red;border-radius: 125px;padding: 1px;width: 20px;text-align: center;cursor: pointer;z-index: 99999}
</style>
<div id="content" class="white">

    <h1><img src="/nnzx/nnys-admin/views/pc/img/icons/dashboard.png" alt="" />资讯管理
    
    </h1>
    
    <div class="bloc">
        <div class="title">
            <?php echo isset($oper)?$oper:"";?>资讯
        </div>
        <div class="pd-20">
            
            <form action="<?php echo isset($url)?$url:"";?>" method="post" class="form form-horizontal" id="form-member-add" auto_submit redirect_url="http://localhost/nnzx/nnys-admin/article/article/arclist">
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 标题：</label>
                    <div class="formControls col-5">
                        <input type="text" name="name" class="input-text" value="<?php echo isset($info['name'])?$info['name']:"";?>" datatype="s2-50" nullmsg="名称不能为空">
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 关键字(英文分号分隔)：</label>
                    <div class="formControls col-5">
                        <input type="text" name="keywords" class="input-text" value="<?php echo isset($info['keywords'])?$info['keywords']:"";?>" datatype="*2-100" nullmsg="关键字不能为空">
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>分类：</label>
                    <div class="formControls col-5">
                        <select name='cate_id'>
                            <?php echo isset($cateList)?$cateList:"";?>
                        </select>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>类型：</label>
                    <div class="formControls col-5">
                        <select name='type'>
                            <?php echo isset($typelist)?$typelist:"";?>
                        </select>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>是否启用：</label>
                    <div class="formControls col-5">
                            
                            <input type="radio" name="status" value='1' <?php if((isset($info) && $info['status']==1) || !isset($info)){?>checked=1<?php }?>>是
                            <input type="radio" name="status" value='0' <?php if((isset($info)&&$info['status']==0)){?>checked=1<?php }?>>否

                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>是否推荐：</label>
                    <div class="formControls col-5">
                            
                            <input type="radio" name="recommend" value='1' <?php if((isset($info) && $info['recommend']==1) || !isset($info)){?>checked=1<?php }?>>是
                            <input type="radio" name="recommend" value='0' <?php if((isset($info)&&$info['recommend']==0)){?>checked=1<?php }?>>否

                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3">封面：</label>
                    <!-- <div class="formControls col-1">
                        <input type='file' name="cover" id="cover" style="width:65px;" onchange="javascript:uploadImg(this,'http://localhost/nnzx/nnys-admin//index/index/upload/');" />
                    </div> -->
                    
                    <!-- <div>
                        <input type="hidden" name="imgcover"  value="<?php echo isset($info['ori_covers'][0])?$info['ori_covers'][0]:"";?>" />
                        <img src="<?php echo isset($info['cover'][0])?$info['cover'][0]:"";?>" name='cover' >
                    </div> -->
                </div>
                <div class="upl">
                    
                    <div id="queue"></div>  
                    <input id="file_upload" name="file_upload" type="file" multiple="true">  
                    <div class='images'>
                        <?php if(!empty($info['cover'])) foreach($info['cover'] as $key => $item){?>
                            <div class="to"><img src='<?php echo isset($item)?$item:"";?>'/><span>x</span></div>
                        <?php }?>
                    </div>   
                    <div class='imgcover'>
                        <?php if(!empty($info['ori_covers'])) foreach($info['ori_covers'] as $key => $item){?>
                            <input type='hidden' name='imgcover[]' value='<?php echo isset($item)?$item:"";?>'/>
                        <?php }?>
                    </div>
                </div>
                
                <div class="row cl">
                    <label class="form-label col-3">内容：</label>
                    <div class="formControls col-5">
                        <!-- <input type="text" name="content" class="input-text" value="<?php echo isset($info['name'])?$info['name']:"";?>" datatype="s2-50" nullmsg="名称不能为空"> -->
                        <textarea id="container" name="content" style="width: 800px; height: 400px; margin: 0 auto;"><?php echo isset($info['content'])?$info['content']:"";?></textarea>
                        <script type="text/javascript">var ue = UE.getEditor("container");</script>
                    </div>
                    <div class="col-4"> </div>
                </div>
                

                <div class="row cl">
                    <div class="col-9 col-offset-3">
                        <?php if(isset($info['id'])){?><input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:"";?>" /><?php }?>
                        
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>


<script type="text/javascript">
$(function(){
            binfdel();
            $('#file_upload').uploadify({  
                'debug'         : false,  
                'auto'          : true,             //是否自动上传,  
                'buttonClass'   : 'haha',           //按钮辅助class  
                'buttonText'    : '上传图片',       //按钮文字  
                'height'        : 30,               //按钮高度  
                'width'         : 100,              //按钮宽度  
                'checkExisting' : 'check-exists.php',//是否检测图片存在,不检测:false  
                'fileObjName'   : 'files',           //默认 Filedata, $_FILES控件名称  
                'fileSizeLimit' : '2048KB',          //文件大小限制 0为无限制 默认KB  
                'fileTypeDesc'  : 'All Files',       //图片选择描述  
                'fileTypeExts'  : '*.gif; *.jpg; *.png',//文件后缀限制 默认：'*.*'  
                'formData'      : {'someKey' : 'someValue', 'someOtherKey' : 1},//传输数据JSON格式  
                //'overrideEvents': ['onUploadProgress'],  // The progress will not be updated  
                //'progressData' : 'speed',             //默认percentage 进度显示方式  
                'queueID'       : 'queue',              //默认队列ID  
                'queueSizeLimit': 20,                   //一个队列上传文件数限制  
                'removeCompleted' : true,               //完成时是否清除队列 默认true  
                'removeTimeout'   : 3,                  //完成时清除队列显示秒数,默认3秒  
                'requeueErrors'   : false,              //队列上传出错，是否继续回滚队列  
                'successTimeout'  : 5,                  //上传超时  
                'uploadLimit'     : 99,                 //允许上传的最多张数  
                'swf'  : '/nnzx/nnys-admin/views/pc/js/uploadify/uploadify.swf', //swfUpload  
                'uploader': 'http://localhost/nnzx/nnys-admin//article/article/uploadify/', //服务器端脚本  
                
                
                //修改formData数据  
                'onUploadStart' : function(file) {  
                    //$("#file_upload").uploadify("settings", "someOtherKey", 2);  
                },  
                //删除时触发  
                'onCancel' : function(file) {  
                    //alert('The file ' + file.name + '--' + file.size + ' was cancelled.');  
                },  
                //清除队列  
                'onClearQueue' : function(queueItemCount) {  
                    //alert(queueItemCount + ' file(s) were removed from the queue');  
                },  
                //调用destroy是触发  
                'onDestroy' : function() {  
                    alert('我被销毁了');  
                },  
                //每次初始化一个队列是触发  
                'onInit' : function(instance){  
                    //alert('The queue ID is ' + instance.settings.queueID);  
                },  
                //上传成功  
                'onUploadSuccess' : function(file, data, response) {
                    data = JSON.parse(data);
                    if(data.success == '1'){
                        var img = data.info;
                        $('.images').append("<div class='to'><img src='"+img+"'/><span>x</span></div>");
                        $('.imgcover').append("<input type='hidden' name='imgcover[]' value='"+img+"'/>");
                        binfdel();
                    }
                },  
                //上传错误  
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {  
                    //alert('The file ' + file.name + ' could not be uploaded: ' + errorString);  
                },  
                //上传汇总  
                'onUploadProgress' : function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {  
                    $('#progress').html(totalBytesUploaded + ' bytes uploaded of ' + totalBytesTotal + ' bytes.');  
                },  
                //上传完成  
                'onUploadComplete' : function(file) {  
                    //alert('The file ' + file.name + ' finished processing.');  
                },  
               
            });  
        });  
  
        
        //变换按钮  
        function changeBtnText() {  
            $('#file_upload').uploadify('settings','buttonText','继续上传');  
        }  
  
  
        //返回按钮  
        function returnBtnText() {  
            alert('The button says ' + $('#file_upload').uploadify('settings','buttonText'));  
        }  

        function binfdel(){
            $('.to span').click(function(){
                var _this = $(this);
                layer.confirm('确定删除',function(i){
                    var index = _this.parent('.to').index();
                    _this.parent('.to').remove();
                    $('.imgcover input').eq(index).remove();
                    layer.closeAll();
                });
            })
        }
    </script>  




</body>
</html>