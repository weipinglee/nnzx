
          
            
                  <script type="text/javascript" src="{views:js/product/cate.js}"></script>
                
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="img/icons/posts.png" alt="" /> 导航栏目管理</h1>
<div class="bloc">
    <div class="title">
        添加导航
    </div>
    <div class="content">
        <div class="pd-20">
            <div class="header_tit">
                <ul>
                    <li><a class="header_nav zhn  cur">添加站内导航</a></li>
                </ul>
            </div>
            <div class="zhannei">
             <form action="{url:/guide/updateGuide}" method="post" class="form form-horizontal" id="form-user-character-add">

                <div class="row cl">
                    <label class="form-label col-2">导航名称：</label>
                    <div class="formControls col-10">
                        <input type="text" class="input-text" value="{$guideData['name']}" placeholder="" id="" name="name">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2">导航链接：</label>
                    <div class="formControls col-10">
                        <input type="text" class="input-text" value="{$guideData['link']}" placeholder="" id="" name="url">
                    </div>
                </div>
                 <div class="row cl">
                    <label class="form-label col-2">位置：</label>
                    <div class="formControls col-10">
                        {foreach: items=$bar item=$value key=$key}
                        <input type="radio" name="type"  onclick="changeGuideCategory({$key}, '{url:/guide/ajaxGetGuideCategory}')"  value="{$key}" {if: $key==$guideData['type']}checked="true"{/if}><span>{$value}</span>
                        {/foreach}

                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>上级分类：</label>
                    <div class="formControls col-10">
                         <select name="pid" id="pid">
                         <option value="0">顶级分类</option>
                        {$category}
                        </select>    
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2">排序：</label>
                    <div class="formControls col-10">
                        <input type="text" class="input-text" value="{$guideData['sort']}"placeholder="" id="" name="sort">
                    </div>
                </div>
                <input type="hidden" name="id" value="{$guideData['id']}">
                <div class="row cl">
                    <div class="col-10 col-offset-2">
                        <button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 提交</button>
                    </div>
                </div>
            </form>
        </div>
       
</div>

