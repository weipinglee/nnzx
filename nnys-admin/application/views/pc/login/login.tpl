<!DOCTYPE html>
<html>
 <head>
        <title>登录</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        
        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
        <script type="text/javascript" src="js/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="css/min.css" />
        <script type="text/javascript" src="js/min.js"></script>
        <script type="text/javascript" src="{views:js/validform/validform.js}"></script>
        <script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <script type="text/javascript" src="{views:js/layer/layer.js}"></script>

		<link rel="stylesheet" type="text/css" href="{views:css/H-ui.min.css}">
		<link rel="stylesheet" href="{views:css/font-awesome.min.css}" />
    </head>
    <body>     
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
</h1>
                
<div class="bloc" style="width: 30%;margin:0 auto;margin-top: 200px;">
   <div class="pd-20">
  <form action="{url:/login/loginHandler}" method="post" class="form form-horizontal" id="form-admin-add" auto_submit redirect_url="{url:/index/index}">
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>用户名：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="" placeholder="" id="admin-name" name="admin-name" datatype="s2-16" nullmsg="用户名不能为空">
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>密码：</label>
      <div class="formControls col-5">
        <input type="password" class="input-text" value="" placeholder="" id="admin-pwd" name="admin-pwd"  datatype="*6-15" nullmsg="密码不能为空">
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <div class="col-9 col-offset-3">
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;登录&nbsp;&nbsp;">
      </div>
    </div>
  </form>
</div>
</div>
</div>

</div>  
    </body>
</html>