<script type="text/javascript" src="{root:/js/webuploader/webuploader.js}"></script>
<script type="text/javascript" src="{root:/js/webuploader/upload.js}"></script>
<link href="{root:/js/webuploader/webuploader.css}" rel="stylesheet" type="text/css" />
<link href="{root:/js/webuploader/demo.css}" rel="stylesheet" type="text/css" />


<div id="uploader" class="wu-example">
    <input type="hidden" name="uploadUrl" value="{url:/ucenter/upload}" />
    <input type="hidden" name="swfUrl" value="{root:/js/webuploader/Uploader.swf}" />
    <!--用来存放文件信息-->
    <ul id="filelist" class="filelist">
        {if:isset($imgData)}
            {foreach:items=$imgData}
                <li   class="file-item thumbnail">
                    <p>
                        <img width="110" src="{echo:\Library\thumb::get($item,110,110)}" />

                    </p>
                    <input type="hidden" name="imgData[]" value="{$item}" />
                </li>
            {/foreach}
        {/if}
    </ul>
    <div class="btns">
        {set:$filesize = \Library\tool::getConfig(array('application','uploadsize'))}
        {if:!$filesize}
            {set:$filesize = 2048;}
        {/if}
        {set:$filesize = $filesize / 1024;}
        <div id="picker" style="line-height:15px;">选择文件</div>
        <span>每张图片大小不能超过{$filesize}M,双击图片可以删除</span>
        <div class="totalprogress" style="display:none;">
            <span class="text">0%</span>
            <span class="percentage"></span>
        </div>
        <div class="info"></div>
    </div>
</div>