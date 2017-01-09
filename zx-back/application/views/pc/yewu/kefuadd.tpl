<!DOCTYPE html>
<html>
 <head>
        <title>添加业务员</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        
        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
      <script type="text/javascript" src="{views:js/validform/validform.js}"></script>
        <script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <script type="text/javascript" src="{views:js/layer/layer.js}"></script>
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
       添加业务员
    </div>
   <div class="pd-20">
  <form action="{url:system/yewu/kefuAdd}" method="post" class="form form-horizontal" id="form-admin-add" auto_submit redirect_url="{url:system/yewu/kefuList}">

      <input type="hidden" name="admin_id" value="{$data['admin_id']}" />
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>用户名：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$data['name']}" placeholder="" id="admin-name" name="admin-name" datatype="s2-16" nullmsg="用户名不能为空">
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>密码：</label>
      <div class="formControls col-5">
        <input type="password" class="input-text" value="" placeholder="" id="admin-pwd" name="admin-pwd" {if:isset($data)}ignore="ignore"{/if} datatype="*6-15" nullmsg="密码不能为空">
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>确认密码：</label>
      <div class="formControls col-5">
        <input type="password" class="input-text" value="" placeholder="" id="admin-pwd-repeat" name="admin-pwd-repeat" {if:isset($data)}ignore="ignore"{/if} datatype="*" recheck="admin-pwd" nullmsg="请确认密码">
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>邮箱：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$data['email']}" placeholder="@" name="admin-email" id="admin-email" datatype="e" nullmsg="请输入邮箱！">
      </div>
      <div class="col-4"> </div>
    </div>
      <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>业务员名称：</label>
          <div class="formControls col-5">
              <input type="text" class="input-text" value="{$data['ser_name']}" name="ser_name"  datatype="*" nullmsg="请输入客服名称！">
          </div>
          <div class="col-4"> </div>
      </div>
      <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>手机：</label>
          <div class="formControls col-5">
              <input type="text" class="input-text" value="{$data['phone']}" name="phone"  datatype="mobile" nullmsg="请输入电话！">
          </div>
          <div class="col-4"> </div>
      </div>
      <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>QQ：</label>
          <div class="formControls col-5">
              <input type="text" class="input-text" value="{$data['qq']}" name="qq"  datatype="qq" nullmsg="请输入客服QQ！">
          </div>
          <div class="col-4"> </div>
      </div>
    <div class="row cl">
      <div class="col-9 col-offset-3">
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        &emsp;<a class="btn btn-primary radius" href="{url:system/yewu/kefuList}">&nbsp;&nbsp;返回&nbsp;&nbsp;</a>
      </div>
    </div>
  </form>
</div>
</div>
</div>

</div>  
    </body>
</html>