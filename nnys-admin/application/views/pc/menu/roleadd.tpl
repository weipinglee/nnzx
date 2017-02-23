
          
            
                
                <script type="text/javascript" src="{views:js/product/cate.js}"></script>
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="img/icons/posts.png" alt="" /> 菜单管理</h1>
<div class="bloc">
    <div class="title">
        添加菜单角色
    </div>
    <div class="content">
        <div class="pd-20">

            <div class="zhannei">
             <form action="{url:member/Menu/RoleAdd}" method="post" class="form form-horizontal" id="form-user-character-add">

                <div class="row cl">
                    <label class="form-label col-2">角色名称：</label>
                    <div class="formControls col-10">
                        <input type="text" class="input-text" value="" placeholder="" id="" name="name">
                    </div>
                </div>
                 <div class="row cl">
                     <label class="form-label col-2">认证角色：</label>
                     <div class="formControls col-10">
                         <select name="name_en" >
                             <option value="public" >公共菜单</option>
                             {set:$cert = \nainai\cert\certificate::$certText }
                             {foreach:items=$cert}
                                 <option value="{$key}" >{$item}</option>
                             {/foreach}
                         </select>
                     </div>
                 </div>
                <div class="row cl">
                    <label class="form-label col-2">角色描述：</label>
                    <div class="formControls col-10">
                        <textarea name="comment" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
                


                <div class="row cl">
                    <div class="col-10 col-offset-2">
                        <button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 提交</button>
                    </div>
                </div>
            </form>
        </div>
       
</div>

