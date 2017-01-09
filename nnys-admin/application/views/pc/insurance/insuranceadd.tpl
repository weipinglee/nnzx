
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" /> 添加保险产品
</h1>
                
<div class="bloc">
    <div class="title">
     保险产品
    </div>
 <div class="pd-20">
  <form action="{url:Trade/Insurance/insuranceAdd}" method="post" class="form form-horizontal" id="form-user-add" auto_submit redirect_url="{url:Trade/Insurance/insuranceList}">
    <div class="row cl">
      <label class="form-label col-2"><span class="c-red">*</span>保险产品名称：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" value="{if:isset($attr)}{$attr['name']}{/if}" datatype="s1-20" errormsg="请正确填写属性名" placeholder="" name="name">
      </div>
      <div class="col-5"> </div>
    </div>
      <div class="row cl">
          <label class="form-label col-2"><span class="c-red"></span>保险公司：</label>
          <div class="formControls col-5">
            <select name="company">
            {foreach: items=$company}
              <option value="{$key}">{$item}</option>
            {/foreahc}
            </select>
          </div>
          <div class="col-5"> </div>
      </div>
      <div class="row cl">
          <label class="form-label col-2"><span class="c-red"></span>保险产品编码：</label>
          <div class="formControls col-5">
              <input type="text" class="input-text" ignore="ignore" datatype="s1-20"  value="{if:isset($attr)}{$attr['value']}{/if}" placeholder="" name="code">
          </div>
          <div class="col-5"> </div>
      </div>

        <div class="row cl" >
          <label class="form-label col-2"><span class="c-red"></span>定额代码：</label>
          <div class="formControls col-5">
          <input type="text" class="input-text" ignore="ignore" datatype="s1-20"   value="{if:isset($attr)}{$attr['value']}{/if}" placeholder="" name="projectCode">
          </div>
          <div class="col-5"> </div>
      </div>

      <div class="row cl">
          <label class="form-label col-2"><span class="c-red"></span>计费类型：</label>
          <div class="formControls col-5">
              <input type="radio" name="type" class="mode" value="1" checked="true">比例<input type="radio" class="mode" name="type" value="2">定额
          </div>
          <div class="col-5"> </div>
      </div>

            <div class="row cl" id="rate">
          <label class="form-label col-2"><span class="c-red"></span>保险费率(‰)：</label>
          <div class="formControls col-5">
          <input type="text" class="input-text" ignore="ignore" datatype="s1-20"   value="{if:isset($attr)}{$attr['value']}{/if}" placeholder="" name="rate">
          </div>
          <div class="col-5"> </div>
      </div>

            <div class="row cl" id="fee" style="display:none;">
          <label class="form-label col-2"><span class="c-red"></span>保险保额：</label>
          <div class="formControls col-5">
          <input type="text" class="input-text" ignore="ignore" datatype="s1-20"  value="{if:isset($attr)}{$attr['value']}{/if}" placeholder="" name="fee">
          </div>
          <div class="col-5"> </div>
      </div>

      <div class="row cl" >
          <label class="form-label col-2"><span class="c-red"></span>保额：</label>
          <div class="formControls col-5">
          <input type="text" class="input-text" ignore="ignore" datatype="s1-20"   value="{if:isset($attr)}{$attr['value']}{/if}" placeholder="" name="limit">
          </div>
          <div class="col-5"> </div>
      </div>

         <div class="row cl">
          <label class="form-label col-2"><span class="c-red"></span>是否开启：</label>
          <div class="formControls col-5">
              <input type="radio" name="status"  value="0" checked="true">关闭<input type="radio"  name="status" value="1" > 开启
          </div>
          <div class="col-5"> </div>
      </div>

    <div class="row cl">
      <label class="form-label col-2">备注：</label>
      <div class="formControls col-5">
        <textarea name="note" cols="" rows="" class="textarea"  placeholder="说点什么..." datatype="*0-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,100)">{if:isset($attr)}{$attr['note']}{/if}</textarea>
      </div>
      <div class="col-5"> </div>
    </div>
    <div class="row cl">
      <div class="col-9 col-offset-2">
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
      </div>
    </div>
  </form>
</div>
</div>

</div>

</div>

<script type="text/javascript">
  $(document).ready(function(){    
    $('.mode').on('click', function(){
      if ($(this).val() == 1) {
        $('#rate').show();
        $('#fee').hide();
      }else if($(this).val() == 2){
        $('#rate').hide();
        $('#fee').show();
      }
    })
  });
</script>
