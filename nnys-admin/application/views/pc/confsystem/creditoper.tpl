
        
        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
        <script type="text/javascript" src="js/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{views:js/validform/validform.js}"></script>
        <script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <script type="text/javascript" src="{views:js/layer/layer.js}"></script>
        <script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
        <script type="text/javascript" src="{root:js/upload/upload.js}"></script>


        <link rel="stylesheet" href="css/min.css" />
        <script type="text/javascript" src="js/min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/H-ui.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" />   
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />{$oper}信誉值配置
</h1>

<div class="bloc">
    <div class="title">
       {$oper}信誉值配置
    </div>
   <div class="pd-20">
  <form action="{url:system/Confsystem/creditOper}" method="post" class="form form-horizontal" id="form-credit-add" auto_submit redirect_url = "{url:/system/Confsystem/creditList}">
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>参数名：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$info['name']}" placeholder="" id="name" name="name" datatype="*2-30" nullmsg="参数名不能为空">
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>中文名:</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$info['name_zh']}" placeholder="" id="name_zh" name="name_zh"  datatype="/^[\u2E80-\uFE4F]{2,10}$/" nullmsg="中文名不能为空">
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>参数类型：</label>
      <div class="formControls col-5">
        <select name="type" class='select' value="{$info['type']}">
          <option value="0">数值</option>
          <option value="1">百分比</option>
        </select>
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>处理方式：</label>
      <div class="formControls col-5">
        <select name="sign" class='select' value="{$info['sign']}">
          <option value="0">增加</option>
          <option value="1">减少</option>
        </select>
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>参数值：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text"  value="{$info['value']}" name="value" id="value" datatype="float" nullmsg="请输入参数值！">
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>排序：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$info['sort']}" name="sort" id="sort" datatype="n" nullmsg="请输入参数值！">
      </div>
      <div class="col-4"> </div>
    </div>   

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red"></span>解释：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$info['note']}" name="note" id="note" >
      </div>
      <div class="col-4"> </div>
    </div>    
    
    
    <div class="row cl">
      <div class="col-9 col-offset-3">
        {if:$oper_type==2}<input type="hidden" name="ori_name" value="{$info['name']}" />{/if}
        <input type="hidden" name="oper_type" value="{$oper_type}"/>
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        &emsp;<a class="btn btn-primary radius" href="{url:/system/Confsystem/creditList}">&nbsp;&nbsp;返回&nbsp;&nbsp;</a>
      </div>
    </div>
  </form>
</div>
</div>
</div>

</div>
    </body>
</html>