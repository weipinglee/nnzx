<script type="text/javascript" src="{views:content/settings/main.js}"></script>
<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/validform/validform.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src='{root:js/upload/ajaxfileupload.js}'></script>

<script type="text/javascript" src='{root:js/upload/upload.js}'></script>
<link rel="stylesheet" href="{views:content/settings/style.css}" />





<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" />广告位添加</h1>
    <div class="bloc">
        <div class="title">
            广告位添加
        </div>
        <div >
            <div class="pd-20">
                <form action="{url:tool/advert/adPositionAdd}" method="post"  class="form form-horizontal"
                      id="adPositionAdd" auto_submit redirect_url="{url:tool/advert/adPositionList}">

                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-2">
                            <input type="text" class="input-text" name="name" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">宽x高：</label>
                        <div class="formControls col-2">
                            <input type="text" name="width"  />x<input type="text" name="height" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">是否开启：</label>
                        <div class="formControls col-10">
                            <input type="radio" class="input-text" value="1"   name="status" checked>开启
                            <input type="radio" class="input-text"  value="0" name="status" >关闭
                        </div>
                    </div>

                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>

            </form>
        </div>