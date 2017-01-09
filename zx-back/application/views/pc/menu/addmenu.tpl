      
                
                <script type="text/javascript" src="{views:js/product/cate.js}"></script>
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="img/icons/posts.png" alt="" /> 菜单管理</h1>
<div class="bloc">
    <div class="title">
        添加菜单
    </div>
    <div class="content">
        <div class="pd-20">

            <div class="zhannei">
             <form action="{url:member/Menu/addMenu}" method="post" class="form form-horizontal" id="form-user-character-add">

                <div class="row cl">
                    <label class="form-label col-2">菜单名称：</label>
                    <div class="formControls col-10">
                        <input type="text" class="input-text" value="" placeholder="" id="" name="name">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2">菜单链接：</label>
                    <div class="formControls col-10">
                        <input type="text" class="input-text" value="" placeholder="" id="" name="url">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-2">菜单位置：</label>
                    <div class="formControls col-10">
                        <input type="radio" name="position" value="0" checked>用户中心<input type="radio" name="position" value="1">首页
                    </div>
                </div>
                
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>上级分类:</label>
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
                        <input type="text" class="input-text" value="" placeholder="" id="" name="sort">
                    </div>
                </div>

                  <div class="row cl">
                    <label class="form-label col-2">是否显示：</label>
                    <div class="formControls col-10">
                    <input type="radio" name="status" value="0" checked>否<input type="radio" name="status" value="1">是
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-2">子账户是否显示：</label>
                    <div class="formControls col-10">
                    <input type="radio" name="subacc_show" value="0" >否<input type="radio" name="subacc_show" value="1" checked>是
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
