
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="img/icons/dashboard.png" alt="" /> 保险费率
</h1>
                
<div class="bloc">
    <div class="title">
       保险费率设置
    </div>
 <div class="pd-20">
	  <form action="{url:Trade/Insurance/rateAdd}" method="post" class="form form-horizontal" id="form-user-add" auto_submit redirect_url="{url:Trade/Insurance/rateList}">

		<div class="row cl">
			<label class="form-label col-3">选择分类：</label>
			<div class="formControls col-5">
               {if: !empty($tree)}
				<select class="select" name="cate_id" size="1" id="cate_id">
                    <option value="0">请选择</option>
					 {foreach: items=$tree}
                    <option value="{$item['id']}" {if:isset($cate['pid']) && $item['id']==$cate['pid']}selected{/if}>{echo:str_repeat('--',$item['level'])}{$item['name']}</option>

                {/foreach}
				</select>
                    {else:}
                         <label>{$cate['name']}</label>
                    {/if}
			</div>
		</div>

    <div class="row cl">
      <label class="form-label col-2">设置保险：</label>
      {if: !empty($list)}
              {foreach: items=$list}
          <div class="row cl">
               <label class="form-label col-3"></label>
               <div class="formControls col-5">
                    <label><input type="checkbox" name="bid[{$key}]" class="bid" value="{$item['id']}"{if: !empty($cate['risk_data']) && in_array($item['id'], $cate['risk_data'])}checked='true'{/if} /> 险种： {$item['name']} ({$item['company']}) 保险方式： </label>
                    <label>{if:$item['mode']==1}比例 : {$item['fee']}(‰)
                                {else:}定额 : ({$item['fee']}){/if}</label> 
                    <span>提示: {$item['note']}</span>
               </div>
               <div class="col-4"></div>
          </div>
          {/foreach}
          {else:}
          <div class="row cl">
          <label class="form-label col-3"></label>
               <div class="formControls col-5">
                  <label>请去交易管理-保险管理中添加保险产品并且启用产品</label>
          </div>
               <div class="col-4"></div>
          </div>
          {/if}
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
        
