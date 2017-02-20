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

    <h1><img src="{views:img/icons/dashboard.png}" alt="" />帮助分类管理

    </h1>

    <div class="bloc">
        <div class="title">
            添加帮助分类
        </div>
        <div class="pd-20">

            <form action="{url:tool/help/helpCatAdd}" method="post" class="form form-horizontal" id="form-member-add" auto_submit redirect_url="{url:tool/help/helpCatList}">
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 名称：</label>
                    <div class="formControls col-5">
                        <input type="text" name="name" value="{$helpCatInfo['name']}" />
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>在帮助系统左侧显示：</label>
                    <div class="formControls col-5">
                        <input type="radio" name="position_left" value="1" {if:$helpCatInfo['position_left']==1}checked="checked"{/if} />是
                        <input type="radio" name="position_left" value="0"{if:$helpCatInfo['position_left']==0}checked="checked"{/if}/>否
                    </div>
                </div>
                <div class="col-4"> </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>在站点下方显示：</label>
                    <div class="formControls col-5">
                        <input type="radio" name="position_foot" value="1" {if:$helpCatInfo['position_left']==1}checked="checked"{/if} />是
                        <input type="radio" name="position_foot" value="0" {if:$helpCatInfo['position_left']==0}checked="checked"{/if} />否
                    </div>
                </div>
                <div class="col-4"> </div>


                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>排序：</label>
                    <div class="formControls col-5">
                        <input type="text" name="sort" value="{$helpCatInfo['sort']}">排序字段为数字,越小越靠前
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2">上传图片就替换原图片：</label>
                    <div class="formControls col-10">
                        <input type="hidden" name="uploadUrl"  value="{url:system/slide/upload@admin}" />
                        <input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this);" />
                    </div>
                    <div>
                        <img name="file2" src="{echo: \Library\Thumb::get($slideInfo['img'])}"  />
                        <input type="hidden" name="imgfile2" value="{$slideInfo['img']}" />

                    </div>
                </div>
                <div class="row cl">
                    <div class="col-9 col-offset-3">
                        <input type="hidden" value="{$helpCatInfo['id']}" name="id" />
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>


