<script type="text/javascript" src="{views:content/settings/main.js}"></script>
<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/validform/validform.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src='{root:js/upload/ajaxfileupload.js}'></script>
<script type="text/javascript" src='{root:js/upload/upload.js}'></script>
<script type="text/javascript" src="{views:js/time/WdatePicker.js}"></script>
<link rel="stylesheet" href="{views:content/settings/style.css}" />





<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" />幻灯片修改</h1>
    <div class="bloc">
        <div class="title">
            幻灯片修改
        </div>
        <div class="content">
            <div class="pd-20">
                <form action="{url:tool/slide/editSlide}" method="post"  class="form form-horizontal"
                      id="adPositionAdd" auto_submit redirect_url="{url:tool/slide/slideList}">

                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-10">
                            <input type="text" name="name" value="{$slideInfo['name']}" datatype="s2-50" nullmsg="名称不能为空" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">上传图片就替换原图片：</label>
                        <div class="formControls col-10">
                            <input type="hidden" name="uploadUrl"  value="{url:tool/slide/upload@admin}" />
                            <input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this);" />
                        </div>
                        <div>
                            <img name="file2" src="{echo: \Library\Thumb::get($slideInfo['img'])}"  />
                            <input type="hidden" name="imgfile2" value="{$slideInfo['img']}" />

                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2"><span class="c-red"></span> 背景颜色：</label>
                        <div class="formControls col-10">
                            <input type="text" name="bgcolor" class="input-text" value="{$slideInfo['bgcolor']}" />
                        </div>
                        <div class="col-4"> </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-2">排序：</label>
                        <div class="formControls col-10">
                            <input type="text" name="order" value="{$slideInfo['order']}" class="input-text" datatype="n1-100" nullmsg="排序字段不能为空" /> 数字越小，排列越靠前
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-3"><span class="c-red">*</span>是否开启：</label>
                        <div class="formControls col-5">

                            <input type="radio" name="status" value='1' {if:$slideInfo['status']==1}checked="checked"{/if} id="">是
                            <input type="radio" name="status" value='0'{if:$slideInfo['status']==0}checked="checked"{/if} id="">否

                        </div>
                        <div class="col-4"> </div>
                    </div>
                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <input type="hidden" value="{$slideInfo['id']}" name="id">
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>

            </form>
        </div>