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
                <form action="{url:tool/friendlyLink/editLink}" method="post"  class="form form-horizontal"
                      id="" auto_submit redirect_url="{url:tool/friendlyLink/frdLinkList}">

                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-5">
                            <input type="text" name="name" class="input-text" value="{$linkInfo['name']}" datatype="s2-50" nullmsg="名称不能为空"  />
                        </div>
                        <div class="col-4"> </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">链接：</label>
                        <div class="formControls col-5">
                            <input type="text" name="link" class="input-text"  value="{$linkInfo['link']}" datatype="*" nullmsg="链接不能为空" />
                        </div>
                        <div class="col-4"> </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-2">排序：</label>
                        <div class="formControls col-5">
                            <input type="text" name="order"  class="input-text" value="{$linkInfo['order']}"  datatype="n1-20"  errormsg="请填写排序" /> 数字越小，排列越靠前
                        </div>
                        <div class="col-4"> </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-3"><span class="c-red">*</span>是否开启：</label>
                        <div class="formControls col-5">

                            <input type="radio" name="status" value='1' {if:$linkInfo['status']==1}checked="checked"{/if} id="">是
                            <input type="radio" name="status" value='0'{if:$linkInfo['status']==0}checked="checked"{/if} id="">否

                        </div>
                        <div class="col-4"> </div>
                    </div>
                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <input type="hidden" value="{$linkInfo['id']}" name="id">
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>

            </form>
        </div>