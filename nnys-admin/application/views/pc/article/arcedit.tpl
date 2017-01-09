<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/validform/validform.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:content/settings/main.js}"></script>
<link rel="stylesheet" href="{views:content/settings/style.css}" />
<link rel="stylesheet" type="text/css" href="{views:css/H-ui.admin.css}">
<script type="text/javascript" src="{views:js/My97DatePicker/WdatePicker.js}"></script>

<script type="text/javascript" src='{root:js/upload/ajaxfileupload.js}'></script>
<script type="text/javascript" src='{root:js/upload/upload.js}'></script>

<script type="text/javascript" src="{views:js/ueditor/ueditor.config.js}"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="{views:js/ueditor/ueditor.all.js}"></script>
<!--
      CONTENT
                -->
<div id="content" class="white">

    <h1><img src="{views:img/icons/dashboard.png}" alt="" />资讯管理

    </h1>

    <div class="bloc">
        <div class="title">
            {$oper}资讯
        </div>
        <div class="pd-20">
            
            <form action="{$url}" method="post" class="form form-horizontal" id="form-member-add" auto_submit redirect_url="{url:article/article/arcList}">
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 标题：</label>
                    <div class="formControls col-5">
                        <input type="text" name="name" class="input-text" value="{$info['name']}" datatype="s2-50" nullmsg="名称不能为空">
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>分类：</label>
                    <div class="formControls col-5">
                        <select name='cate_id'>
                            {$cateList}
                        </select>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3">封面：</label>
                    <div class="formControls col-1">
                        <input type='file' name="cover" id="cover" style="width:65px;" onchange="javascript:uploadImg(this,'{url:/index/index/upload}');" />
                    </div>
                    <div>
                        <input type="hidden" name="imgcover"  value="{$info['ori_covers'][0]}" />
                        <img src="{$info['cover'][0]}" name='cover' >
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3">内容：</label>
                    <div class="formControls col-5">
                        <!-- <input type="text" name="content" class="input-text" value="{$info['name']}" datatype="s2-50" nullmsg="名称不能为空"> -->
                        <textarea id="container" name="content" style="width: 800px; height: 400px; margin: 0 auto;">{$info['content']}</textarea>
                        <script type="text/javascript">var ue = UE.getEditor("container");</script>
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
                        {if:isset($info['id'])}<input type="hidden" name="id" value="{$info['id']}" />{/if}
                        
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>


