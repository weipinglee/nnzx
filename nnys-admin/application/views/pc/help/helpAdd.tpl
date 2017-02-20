<script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
<script type="text/javascript" src="{views:js/validform/validform.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
<script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:content/settings/main.js}"></script>
<link rel="stylesheet" href="{views:content/settings/style.css}" />
<link rel="stylesheet" type="text/css" href="{views:css/H-ui.admin.css}">
<script type="text/javascript" charset="utf-8" src="{views:js/ueditor/ueditor.config.js}"></script>
<script type="text/javascript" charset="UTF-8" src="{views:js/ueditor/ueditor.all.js}"></script>
<script type="text/javascript" charset="UTF-8" src="{views:js/ueditor/lang/zh-cn/zh-cn.js}"></script>
<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<!--
      CONTENT
                -->
<div id="content" class="white">

    <h1><img src="{views:img/icons/dashboard.png}" alt="" />帮助管理

    </h1>

    <div class="bloc">
        <div class="title">
            添加帮助
        </div>
        <div class="pd-20">

            <form action="{url:tool/help/helpAdd}" method="post" class="form form-horizontal" id="form-member-add" auto_submit redirect_url="{url:tool/help/helpList}">
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 名称：</label>
                    <div class="formControls col-5">
                        <input type="text" name="name" value="{if:isset($helpInfo)}{$helpInfo['name']}{/if}" class="input-text" datatype="s2-50" nullmsg="名称不能为空" />
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 分类：</label>
                    <div class="formControls col-5">
                        <select name="cat_id" datatype="*" nullmsg="请选择分类！">
                            <option value="">请选择分类</option>
                            {foreach: $items=$catList}
                            <option value="{$item['id']}"
                            {if:isset($helpInfo)}
                                {if:$helpInfo['cat_id']==$item['id']}
                            selected="selected"
                                    {/if}
                            {/if}
                            >{$item['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 排序：</label>
                    <div class="formControls col-5">
                        <input type="text" name="sort"  value="{if:isset($helpInfo)}{$helpInfo['sort']}{else:}100{/if}" class="input-text" datatype="n1-50" nullmsg="排序不能为空" errormsg='排序为数字'/>
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="col-4"> </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span> 指向链接：</label>
                    <div class="formControls col-5">
                        <input type="text" name="link" value="{if:isset($helpInfo)}{$helpInfo['link']}{/if}"/>若填此项，将直接跳转到该地址
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="col-4"> </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>图片：</label>
                    <div class="formControls col-5">
                        <div class="">
                            <input type="hidden" name="uploadUrl"  value="{url:tool/slide/upload@admin}" />
                            <input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this);" />
                        </div>
                        <div>
                            <img name="file2" {if:isset($helpInfo)&&$helpInfo['img']!=''}src="{echo: \Library\Thumb::get($helpInfo['img'])}"{/if}/>
                            <input type="hidden" name="imgfile2" {if:isset($helpInfo)&&$helpInfo['img']!=''}value="{$helpInfo['img']}" {/if} />
                        </div>
                        </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>内容：</label>
                    <div class="formControls col-5">
                        <!--ueditor JS代码引入-->

                            <script language='JavaScript'>
                            var ue=UE.getEditor('introduce',{ toolbars: [[
                                'fullscreen', 'undo', 'redo', '|',
                                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                                'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                                'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                                'directionalityltr', 'directionalityrtl', 'indent', '|',
                                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                                'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                                'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'webapp', 'pagebreak', 'template', 'background', '|',
                                'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
                                'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                                'print', 'preview', 'searchreplace', 'help', 'drafts'
                            ]],
                                elementPathEnabled:false,maximumWords:100,initialFrameHeight:200,initialFrameWidth:800});
                        </script>
                        <textarea name="introduce" style="width:1000px;height:500px" id="introduce">{if:isset($helpInfo)}{$helpInfo['content']}{/if}</textarea>
                    </div>
                    <div class="col-4"> </div>
                </div>

                <div class="row cl">
                    <div class="col-9 col-offset-3">
                        <input type="hidden" name="id" value="{if:isset($helpInfo)}{$helpInfo['id']}{/if}">
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>



