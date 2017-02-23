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

<!DOCTYPE html>
<html>
 <head>
        <title>添加分组</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        
        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="/nnys-admin/views/pc/js/libs/jquery/1.11/jquery.min.js"></script>
        <script type="text/javascript" src="js/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="css/min.css" />
        <script type="text/javascript" src="js/min.js"></script>
        <script type="text/javascript" src="/nnys-admin/views/pc/js/validform/validform.js"></script>
        <script type="text/javascript" src="/nnys-admin/views/pc/js/validform/formacc.js"></script>
        <script type="text/javascript" src="/nnys-admin/views/pc/js/layer/layer.js"></script>

		<link rel="stylesheet" type="text/css" href="css/H-ui.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css" />
    </head>
    <body>     
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="/nnys-admin/views/pc/img/icons/dashboard.png" alt="" />系统管理
</h1>
                
<div class="bloc">
    <div class="title">
       添加分组
    </div>
   <div class="pd-20">
  <form action="http://info.nainaiwang.com/nnys-admin/system/rbac/roleadd" method="post" class="form form-horizontal" id="form-role-add" auto_submit redirect_url="http://info.nainaiwang.com/nnys-admin//system/rbac/roleList/">
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>分组名：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="" placeholder="" id="role-name" name="role-name" datatype="s2-16" nullmsg="分组名不能为空">
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>备注：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" placeholder="@" name="role-remark" id="role-remark">
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


</body>
</html>