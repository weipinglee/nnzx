
        
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
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />编辑会员分组
</h1>
                
<div class="bloc">
    <div class="title">
       编辑会员分组
    </div>
   <div class="pd-20">
  <form action="{url:/member/usergroup/groupEdit}" method="post" class="form form-horizontal" id="form-usergroup-edit" auto_submit redirect_url = "{url:/member/usergroup/groupList}">
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>分组名：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$info['group_name']}" placeholder="" id="group_name" name="group_name" datatype="*2-16" nullmsg="分组名不能为空">
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>信誉值分界线:</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$info['credit']}" placeholder="" id="credit" name="credit"  datatype="n" nullmsg="信誉制分界线不能为空">
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3">分组图标：</label>
      <div class="formControls col-5"> 
        <span class="btn-upload form-group">
          <input type="file" name="file2" id="file2"  onchange="javascript:uploadImg(this);" />
        </span> 
      </div>

      <div  class="up_img" style="margin: 50px 0 10px 280px;">
        <img style="width:150px;height: 150px;" name="file2" src="{$info['icon_thumb']}"/>
        <input type="hidden"  name="imgfile2" value="{$info['icon']}" pattern="required" alt="请上传图片" />
      </div><!--img name属性与上传控件id相同-->
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>保证金比率：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$info['caution_fee']}" name="caution_fee" id="caution_fee" datatype="n" nullmsg="请输入保证金比率！">
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>自由报盘费用比率：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$info['free_fee']}" name="free_fee" id="free_fee" datatype="n" nullmsg="请输入自由报盘费用比率：！">
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>委托报盘手续费比率：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{$info['depute_fee']}" name="depute_fee" id="depute_fee" datatype="float" nullmsg="请输入委托报盘手续费比率！">
      </div>
      <div class="col-4"> </div>
    </div>
    
    
    
    <div class="row cl">
      <div class="col-9 col-offset-3">
        <input type="hidden" name="uploadUrl"  value="{url:/index/index/upload}" />
        <input type="hidden" value="{$info['id']}" name="id">
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        &emsp;<a class="btn btn-primary radius" href="{url:/member/usergroup/groupList}">&nbsp;&nbsp;返回&nbsp;&nbsp;</a>
      </div>
    </div>
  </form>
</div>
</div>
</div>

</div>
        
        
    </body>
</html>