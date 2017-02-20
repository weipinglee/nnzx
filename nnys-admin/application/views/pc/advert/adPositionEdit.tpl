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
    <h1><img src="{views:img/icons/posts.png}" alt="" />广告位修改</h1>
    <div class="bloc">
        <div class="title">
            广告位修改
        </div>
        <div >
            <div class="pd-20">
                <form action="{url:tool/advert/adPositionEdit}" method="post"  class="form form-horizontal"
                      id="adPositionAdd" auto_submit redirect_url="{url:tool/advert/adPositionList}">
                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-10">
                            <input type="text" class="input-text" name="name" value="{$info['name']}"/>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">宽x高：</label>
                        <div class="formControls col-10">
                            <input type="text" name="width" value="{$info['width']}" />x<input type="text" name="height" value="{$info['height']}"/>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">是否开启：</label>
                        <div class="formControls col-10">
                            <input type="radio" class="input-text" value="1"   name="status" {if:$info['status']==1}checked{/if}>开启
                            <input type="radio" class="input-text"  value="0" name="status" {if:$info['status']==0}checked{/if}>关闭
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">代码：</label>
                        <div class="formControls col-10">
                            将以下代码Copy到你想放置广告的任何地方<br />
                            <code style="font-weight:normal;font-family:'Courier New';font-size:16px;display:block;background:#333;color:#fff;padding:5px;margin-right:30px;">
                                &#123;echo&#58; \Library\Ad::show("{$info['name']}")&#125;						</code>
                        </div>
                    </div>
                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <input type="hidden" value="{$info['id']}" name="id" />
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>
            </form>
        </div>