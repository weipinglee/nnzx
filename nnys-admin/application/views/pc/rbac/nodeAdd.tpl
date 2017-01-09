<!DOCTYPE html>
<html>
 <head>
        <title>添加权限节点</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        
        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
        <script type="text/javascript" src="js/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
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
       添加权限节点
    </div>
   <div class="pd-20">
  <form action="{url:system/rbac/nodeAdd}" method="post" class="form form-horizontal" id="form-node-add" auto_submit>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>模块名：</label>
      <div class="formControls col-5">
        <select class='input-select module' name='module' nullmsg = '请选择模块名' dataType="*2-50">
          <option value='-1'>请选择</option>
            {foreach:items=$modules}
              <option value="{$item}">{$item}</option>
            {/foreach}
        </select>
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>模块标题：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" placeholder="" name="module_title" id="node-module-title" dataType='*2-20' nullmsg='请填写模块标题'/>
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red"></span>控制器名(可选)：</label>
      <div class="formControls col-5">
        <select class='input-select controller' name='controller'>
          <option value="-1">请选择</option>
        </select>
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red"></span>控制器标题：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" placeholder="" name="controller_title" id="node-controller-title" dataType='*0-20' />
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red"></span>动作方法名(可选)：</label>
      <div class="formControls col-5">
        <select class='input-select action' name='action'>
          <option value="-1">请选择</option>
        </select>
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red"></span>方法标题：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" placeholder="" name="action_title" id="node-action-title" dataType='*0-20' />
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <div class="col-9 col-offset-3">
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        &emsp;<a class="btn btn-primary radius" href="{url:/system/rbac/accessList}">&nbsp;&nbsp;前往权限分配&nbsp;&nbsp;</a>
      </div>

    </div>
  </form>
</div>
</div>
</div>

</div>  
    </body>

    <script type="text/javascript">
      $(function(){

        var formacc_sel = new nn_panduo.formacc();
        
        $('.module').change(function(){
          var module_name = $(this).val();
          $('.controller').html('<option value="">请选择</option>');
          $('.action').html('<option value="">请选择</option>');
          $('input[name=controller_title]').val('');
          $('input[name=action_title]').val('');
          $('input[name=module_title]').val('');
          if(module_name == -1) return false;
          formacc_sel.ajax_post("{url:/system/rbac/controllerList}",{module:module_name},function(){
            $('.controller').html(formacc_sel.ajax_return_data.controllers);
            $('input[name=module_title]').val(formacc_sel.ajax_return_data.title);
          },function(){
            $('.controller').html("<option value=''>无控制器</option>");
          });
        });
        $('.controller').change(function(){
          var controller_name = $(this).val();
          var module_name = $('.module').val()
          $('.action').html('');
          $('input[name=action_title]').val('');
          $('input[name=controller_title]').val('');
          if(controller_name == -1) return false;
          formacc_sel.ajax_post("{url:/system/rbac/actionList}",{controller:controller_name,module:module_name},function(){
            $('.action').html(formacc_sel.ajax_return_data.actions);
            $('input[name=controller_title]').val(formacc_sel.ajax_return_data.title);
          },function(){
            $('.action').html("<option value=''>无方法</option>");
          });
        });

        $('.action').change(function(){
          var action_name = $(this).val();
          var module_name = $('.module').val();
          var controller_name = $('.controller').val();
          $('input[name=action_title]').val('');
          if(action_name == -1) {
            return false;
          }else{
            formacc_sel.ajax_post("{url:/system/rbac/actionTitle}",{controller:controller_name,module:module_name,action:action_name},function(){
              $('input[name=action_title]').val(formacc_sel.ajax_return_data.action_title);
            },function(){});
          }
        });
      }); 
    </script>
</html>