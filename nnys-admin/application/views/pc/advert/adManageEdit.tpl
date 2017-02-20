<script type="text/javascript" src="{views:content/settings/main.js}"></script>
<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/validform/validform.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src='{root:js/upload/ajaxfileupload.js}'></script>
<script type="text/javascript" src='{root:js/upload/upload.js}'></script>

<link rel="stylesheet" href="{views:content/settings/style.css}" />
<script type="text/javascript" src="{views:js/My97DatePicker/WdatePicker.js}"></script>




<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" />广告修改</h1>
    <div class="bloc">
        <div class="title">
            广告修改
        </div>
        <div >
            <div class="pd-20">
                <form action="{url:tool/advert/adManageEdit}" method="post"  class="form form-horizontal"
                      id="adPositionAdd" auto_submit redirect_url="{url:tool/advert/adManageList}">

                    <div class="row cl">
                        <label class="form-label col-2">名称：</label>
                        <div class="formControls col-2">
                            <input type="text" name="name" class="input-text" value="{$info['name']}" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">图片：</label>
                        <div class="formControls col-2">
                            <img name="file2" src="{$info['content']}">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">上传图片就替换原图片：</label>
                        <div class="formControls col-2">
                            <input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this,'{url:/upload/upload}');" />
                        </div>
                        <div>
                            <input type="hidden" name="imgfile2"  />

                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">广告位：</label>
                        <div class="formControls col-2">
                            <select name="position_id">
                                <option value="">请选择...</option>
                                {foreach: items=$adPoDate}
                                <option value="{$item['id']}" {if:$item['id']==$info['position_id']}selected{/if}>
                                    {$item['name']}
                                </option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">链接地址：</label>
                        <div class="formControls col-2">
                            <input type="text" name="link" class="input-text" value="{$info['link']}" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">排序：</label>
                        <div class="formControls col-2">
                            <input type="text" name="order" class="input-text" value="{$info['order']}" /> 数字越小，排列越靠前
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">开始时间：</label>
                        <div class="formControls col-2">
                            <input class="Wdate input-text" onclick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" name="start_time" value="{$info['start_time']}"/>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">结束时间：</label>
                        <div class="formControls col-2">
                            <input class="Wdate input-text" onclick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" name="end_time" value="{$info['end_time']}" />
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-2">描述：</label>
                        <div class="formControls col-2">
                            <input type="text" name="description" class="input-text" value="{$info['description']}"/>
                        </div>
                    </div>
                    <div class="row cl">
                        <div class="col-10 col-offset-2">
                            <input type='hidden' value="{$info['id']}" name='id' />
                            <button type="submit" class="btn btn-success radius" id="offline-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
                        </div>
                    </div>


            </div>

            </form>
        </div>