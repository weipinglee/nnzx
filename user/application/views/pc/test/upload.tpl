

<script type="text/javascript" src="{root:/js/webuploader/webuploader.js}"></script>
<script type="text/javascript" src="{root:/js/webuploader/upload.js}"></script>
<link href="{root:/js/webuploader/webuploader.css}" rel="stylesheet" type="text/css" />
<link href="{root:/js/webuploader/demo.css}" rel="stylesheet" type="text/css" />


<div id="uploader" class="wu-example">
    <input type="hidden" name="uploadUrl" value="{url:/ucenter/upload}" />
    <input type="hidden" name="swfUrl" value="{root:/js/webuploader/Uploader.swf}" />
    <!--用来存放文件信息-->
    <ul id="filelist" class="filelist">
    </ul>
    <div class="btns">

        <div id="picker" style="line-height:15px;">选择文件</div>
        <button id="beginUpload" class="btn btn-default">开始上传</button>
        <div class="totalprogress" style="display:none;">
            <span class="text">0%</span>
            <span class="percentage"></span>
        </div>
        <div class="info"></div>
    </div>
</div>
<style>

</style>