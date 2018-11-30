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
<!--
      CONTENT
                -->
<div id="content" class="white">

    <h1><img src="{views:img/icons/dashboard.png}" alt="" />帮助管理

    </h1>

    <div class="bloc">
        <div class="title">
            编辑帮助
        </div>
        <div class="pd-20">

            <form action="{url:tool/help/helpAdd}" method="post" class="form form-horizontal" id="form-member-add" auto_submit redirect_url="{url:tool/help/helpList}">
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 名称：</label>
                    <div class="formControls col-5">
                        <input type="text" name="name" value="{$helpInfo['name']}"/>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 分类：</label>
                    <div class="formControls col-5">
                        <select name="cat_id">
                            <option value="0">请选择分类</option>
                            {foreach: $items=$catList}
                                <option value="{$item['id']}"
                                {if:$helpInfo['cat_id']==$item['id']}selected="selected"{/if}>{$item['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 排序：</label>
                    <div class="formControls col-5">
                        <input type="text" name="sort"  value="100"/>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="col-4"> </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 指向链接：</label>
                    <div class="formControls col-5">
                        <input type="text" name="link" />若填此项，将直接跳转到该地址
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="col-4"> </div>

                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>内容：</label>
                    <div class="formControls col-5">
                        <textarea name="content" ></textarea>
                    </div>
                    <div class="col-4"> </div>
                </div>

                <div class="row cl">
                    <div class="col-9 col-offset-3">
                        <input type="hidden" value="{$helpInfo['id']}" name="id" />
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>


