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
    <h1><img src="{views:img/icons/posts.png}" alt="" />幻灯片位置修改</h1>
    <div class="bloc">
        <div class="title">
            幻灯片位置修改
        </div>
        <div class="content">
            <div class="pd-20">
                <form action="{url:tool/slidepos/editSlidepos}" method="post"  class="form form-horizontal"
                      id="adPositionAdd" auto_submit redirect_url="{url:tool/slidepos/slideposList}">

                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-10">
                            <input type="text" name="name" value="{$slideposInfo['name']}" datatype="s2-50" nullmsg="名称不能为空" />
                        </div>
                    </div>
                    
                    <div class="row cl">
                        <label class="form-label col-2">描述：</label>
                        <div class="formControls col-10">
                            <input type="text" name="intro" value="{$slideposInfo['intro']}" class="input-text" datatype="*1-100" nullmsg="描述不能为空" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-3"><span class="c-red">*</span>是否开启：</label>
                        <div class="formControls col-5">

                            <input type="radio" name="status" value='1' {if:$slideposInfo['status']==1}checked="checked"{/if} id="">是
                            <input type="radio" name="status" value='0'{if:$slideposInfo['status']==0}checked="checked"{/if} id="">否

                        </div>
                        <div class="col-4"> </div>
                    </div>
                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <input type="hidden" value="{$slideposInfo['id']}" name="id">
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>

            </form>
        </div>