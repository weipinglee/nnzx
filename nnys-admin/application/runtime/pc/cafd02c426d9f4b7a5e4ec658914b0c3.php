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

<!DOCTYPE html>
<html>
 <head>
        <title>编辑角色</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        
        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/libs/jquery/1.11/jquery.min.js"></script>
        <script type="text/javascript" src="js/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="css/min.css" />
        <script type="text/javascript" src="js/min.js"></script>
        <script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/validform/validform.js"></script>
        <script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/validform/formacc.js"></script>
        <script type="text/javascript" src="/nnzx/nnys-admin/views/pc/js/layer/layer.js"></script>
		<link rel="stylesheet" type="text/css" href="css/H-ui.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css" />
    </head>
    <body>     
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="/nnzx/nnys-admin/views/pc/img/icons/dashboard.png" alt="" />系统管理
</h1>
                
<div class="bloc">
    <div class="title">
       编辑分组
    </div>
   <div class="pd-20">
  <form action="http://localhost/nnzx/nnys-admin//system/rbac/roleUpdate/" method="post" class="form form-horizontal" id="form-role-update" auto_submit redirect_url="http://localhost/nnzx/nnys-admin//system/rbac/roleList/">
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>分组名：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" placeholder="" id="role-name" name="role-name" value="<?php echo isset($info['name'])?$info['name']:"";?>" datatype="s2-16" nullmsg="分组名不能为空">
      </div>
      <div class="col-4"> </div>
    </div>
    <!-- <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>密码：</label>
      <div class="formControls col-5">
        <input type="password" class="input-text" value="" placeholder="" id="admin-pwd" name="admin-pwd" value="" datatype="*6-15" nullmsg="密码不能为空">
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>确认密码：</label>
      <div class="formControls col-5">
        <input type="password" class="input-text" value="" placeholder="" id="admin-pwd-repeat" name="admin-pwd-repeat"  datatype="*" recheck="admin-pwd" nullmsg="请确认密码">
      </div>
      <div class="col-4"> </div>
    </div> -->
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>备注：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" placeholder="" name="role-remark" value="<?php echo isset($info['remark'])?$info['remark']:"";?>" id="role-remark" datatype="*2-30">
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <div class="col-9 col-offset-3">
        <input type="hidden" name="role-id" value="<?php echo isset($info['id'])?$info['id']:"";?>"/>
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


</body>
</html>