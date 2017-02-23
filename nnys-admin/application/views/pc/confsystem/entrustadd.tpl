
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="img/icons/dashboard.png" alt="" /> 委托费率
</h1>
                
<div class="bloc">
    <div class="title">
       委托费率设置
    </div>
 <div class="pd-20">
	  <form action="{url:system/Confsystem/entrustadd}" method="post" class="form form-horizontal" id="form-user-add" auto_submit redirect_url="{url:system/Confsystem/entrustlist}">

		<div class="row cl">
			<label class="form-label col-3">选择分类：</label>
			<div class="formControls col-5">
               {if: !empty($tree)}
				<select class="select" name="cate_id" size="1" id="cate_id">
                    <option value="0">请选择</option>
					 {foreach: items=$tree}
                  {if: !in_array($item['id'], $data)}
                    <option value="{$item['id']}" {if:isset($cate['pid']) && $item['id']==$cate['pid']}selected{/if}>{echo:str_repeat('--',$item['level'])}{$item['name']}</option>
                    {/if}
                {/foreach}
				</select>
                    {else:}
                         <label>{$cate['name']}</label>
                    {/if}
			</div>
		</div>

      <div class="row cl">
      <label class="form-label col-3">费率类型：</label>
      <div class="formControls col-5">
             <select name="type">
               <option value="0">百分比</option>
               <option value="1">定值</option>
             </select>
      </div>
    </div>

     <div class="row cl">
      <label class="form-label col-3">费率值：</label>
      <div class="formControls col-5">
        <input class="input-text" name="value" class="text"  nullmsg='请填写费率值'>
      </div>
    </div>

     <div class="row cl">
      <label class="form-label col-3">备注：</label>
      <div class="formControls col-5">
        <textarea name="note"></textarea>
      </div>
    </div>
<div class="row cl">
      <label class="form-label col-3">状态：</label>
      <div class="formControls col-5">
        <input type="radio" name="status" value="0" checked="true">停用<input type="radio" name="status" value="1">启用
      </div>
    </div>
		
		<input type="hidden" name="ajax_url" id="ajax_url" value="{url: Trade/Insurance/ajaxGetCate}">
          <input type="hidden" name="id" id="id" value="{$cate['id']}">
		<div class="row cl">
			<div class="col-9 col-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</div>
</div>

</div>
<script type="text/javascript">
     
$(document).ready(function(){

     $('#cate_id').on('change', function(){
          var cate_id = $(this).val();
          $('#id').val(cate_id);
          if (cate_id <= 0) {return;}
          $.ajax({
               'url' :  $('#ajax_url').val(),
               'type' : 'post',
               'async':true,
               'data' : {cate_id : cate_id},
               'dataType': 'json',
               success:function(data){//alert(JSON.stringify(data));
                    for (var i = 0; i < $('.bid').length; i++) {
                        $('.bid').eq(i).removeAttr('checked');
                        $('.input-text').eq(i).val('');
                    }
                    if (data.risk_data != undefined) {
                         $.each(data.risk_data, function(k, val){
                              for (var i = 0; i < $('.bid').length; i++) {
                                   if ($('.bid').eq(i).val() == val) {
                                        $('.bid').eq(i).prop('checked', 'checked');
                                   }
                              }
                         })
                    }
               }
          });
     })
})
</script>
        
