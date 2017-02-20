<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/validform/validform.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:content/settings/main.js}"></script>
<link rel="stylesheet" href="{views:content/settings/style.css}" />
<link rel="stylesheet" type="text/css" href="{views:css/H-ui.admin.css}">
<script type="text/javascript" src="{views:js/My97DatePicker/WdatePicker.js}"></script>
<!--
      CONTENT
                -->
<div id="content" class="white">

    <h1><img src="{views:img/icons/dashboard.png}" alt="" />分类管理

    </h1>

    <div class="bloc">
        <div class="title">
            {$oper}分类
        </div>
        <div class="pd-20">
            
            <form action="{$url}" method="post" class="form form-horizontal" id="form-member-add" auto_submit redirect_url="{url:category/arcType/typeList}">
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 名称：</label>
                    <div class="formControls col-5">
                        <input type="text" name="name" class="input-text" value="{$info['name']}" datatype="s2-50" nullmsg="名称不能为空">
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>父级分类：</label>
                    <div class="formControls col-5">
                        <select name='pid'>
                            {$typelist}
                        </select>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>同级排序：</label>
                    <div class="formControls col-5">
                        <input type="text" name="sort" value="{$info['sort']}" class="input-text" datatype="n1-10"  errormsg="请填写排序">排序字段为数字,越小越靠前
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>是否启用：</label>
                    <div class="formControls col-5">
                            
                            <input type="radio" name="status" value='1' {if:(isset($info) && $info['status']==1) || !isset($info)}checked=1{/if}>是
                            <input type="radio" name="status" value='0' {if:(isset($info)&&$info['status']==0)}checked=1{/if}>否

                    </div>
                    <div class="col-4"> </div>
                </div>

                <div class="row cl">
                    <div class="col-9 col-offset-3">
                        {if:isset($id)}<input type="hidden" name="id" value="{$id}" />{/if}
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>


