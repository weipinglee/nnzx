<!DOCTYPE html>
<html>
 <head>
        <title>编辑管理员</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        
        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
      <link rel="stylesheet" href="css/min.css" />
        <script type="text/javascript" src="js/min.js"></script>
     <script type="text/javascript" src="{views:js/validform/validform.js}"></script>
     <script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
     <script type="text/javascript" src="{views:js/layer/layer.js}"></script>

		<link rel="stylesheet" type="text/css" href="css/H-ui.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css" />
    </head>
    <body>     
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />系统管理
</h1>
                
<div class="bloc">
    <div class="title">
       编辑管理员
    </div>
   <div class="pd-20">
  <form action="{url:system/admin/adminUpdate}" method="post"  class="form form-horizontal" id="form-admin-update" auto_submit redirect_url="{url:system/admin/adminList}">
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>管理员分组：</label>

      <div class="formControls col-5">
        <select class='input-select roles' name='admin-role' nullmsg = '请选择分组' dataType="/^[1-9]\d*$/">
          <option value='-1'>请选择分组</option>
            {foreach:items=$admin_roles}
              <option value="{$item['id']}" {if:$info['role'] == $item['id']}selected{/if}>{$item['name']}</option>
            {/foreach}
        </select>
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>用户名：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" placeholder="" id="admin-name" name="admin-name" value="{$info['name']}" datatype="s2-16" nullmsg="用户名不能为空">
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
      <label class="form-label col-3"><span class="c-red">*</span>邮箱：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" placeholder="@" name="admin-email" value="{$info['email']}" id="admin-email" datatype="e" nullmsg="请输入邮箱！">
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <div class="col-9 col-offset-3">
        <input type="hidden" name="admin-id" value="{$info['id']}"/>
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        &emsp;<a class="btn btn-primary radius" href="{url:/system/admin/adminList}">&nbsp;&nbsp;返回&nbsp;&nbsp;</a>
      </div>
    </div>
  </form>
</div>
</div>
</div>

</div>
    
    </body>
</html>