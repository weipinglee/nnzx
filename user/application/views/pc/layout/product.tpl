<table border="0" >

    <tr>
        <th colspan="3">基本挂牌信息</th>
    </tr>
    <tr>
        <td nowrap="nowrap"><span></span>商品标题：</td>
        <td colspan="2">
            <span><input class="text" type="text" datatype="s1-30" value="{$product['product_name']}" errormsg="填写商品标题" name="warename"></span>
            <span></span>
        </td>

    </tr>
    <tr>
        <td nowrap="nowrap"><span></span>商品单价：</td>
        <td>
            <span> <input class="text" type="text" datatype="money" value="{$offer['price']}" errormsg="请正确填写单价" name="price"></span>
            <span></span>
        </td>
        <!--                                 <td>
            请选择付款方式：
            <input type ="radio" name ="safe" checked="checked" style="width:auto;height:auto;"> 线上
            <input type ="radio" name ="safe" style="width:auto;height:auto;"> 线下
        </td> -->
    </tr>
    <tr>
        <td nowrap="nowrap"><span></span>数量：</td>
        <td>
            <span><input class="text" value="{$product['quantity']}" type="text" datatype="/^\d{1,10}(\.\d{0,5})?$/" errormsg="请正确填写数量" name="quantity"></span>
            <span></span>
        </td>
        <span></span>
        <!--  <td>
            请选择支付保证金比例：
            <input type="button" id="jian" value="-"><input type="text" id="num" value="1"><input type="button" id="add" value="+">

        </td> -->
    </tr>
    <tr>
        <td nowrap="nowrap"><span></span>单位：</td>
        <td>
            <input class="text" type="text" name="unit" value="{$product['unit']}"/>
        </td>
        <!--  <td>
            请选择支付保证金比例：
            <input type="button" id="jian" value="-"><input type="text" id="num" value="1"><input type="button" id="add" value="+">

        </td> -->
    </tr>

    <tr style="display:none" id='productAdd'>
                            <td ></td>
                            <td ></td>
     </tr>
                            
    <!-- <tr>
        <td nowrap="nowrap"><span></span>是否投保：</td>
        <td>
            <span> <input type="radio" name="insurance" value="1"  checked="true">是 <input type="radio" name="insurance" value="0" >否</span>
        </td>
    </tr>

    <tr id="riskdata" >
        <td ><span></span>保险：</td>
        <td>
            <span> 

            </span>
        </td>
    </tr> -->
    <input type="hidden" name="cate_id" id="cid">
    <input type="hidden" name="ajax_url" id="ajax_url" value="{url: Trade/Insurance/ajaxGetCate}">

    <tr>
        <td>产地：</td>
        <td colspan="2">
            <span id="areabox">{area:data=$product['produce_area']}</span>
            <span></span>
        </td>

    </tr>

    <tr>
        <td>有效期：</td>
        <td colspan="2">
             <span><input class="Wdate text" datatype="*" value="{$offer['expire_time']}" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'%y-%M-#{%d+1}'})"
                           name="expire_time" value="">
                           有效期不能超过二十年
                 </span>
            <span></span>
        </td>

    </tr>


    <tr>
        <td style="vertical-align:top;">上传图片：</td>
        <td>

            <script type="text/javascript" src="{root:/js/webuploader/webuploader.js}"></script>
            <script type="text/javascript" src="{root:/js/webuploader/upload.js}"></script>
            <link href="{root:/js/webuploader/webuploader.css}" rel="stylesheet" type="text/css" />
            <link href="{root:/js/webuploader/demo.css}" rel="stylesheet" type="text/css" />


            <div id="uploader" class="wu-example">
                <input type="hidden" name="uploadUrl" value="{url:/ucenter/upload}" />
                <input type="hidden" name="swfUrl" value="{root:/js/webuploader/Uploader.swf}" />
                <!--用来存放文件信息-->
                <ul id="filelist" class="filelist">
                    {if:isset($product['imgData'])}
                        {foreach:items=$product['imgData']}
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
                    <div id="picker" style="line-height:15px;">选择文件</div><span>每张图片大小不能超过{$filesize}M,双击图片可以删除</span>
                    <div class="totalprogress" style="display:none;">
                        <span class="text">0%</span>
                        <span class="percentage"></span>
                    </div>
                    <div class="info"></div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="3"><b>详细信息</b></th>
    </tr>

    <tr>
        <td><span>*</span>是否可拆分：</td>
        <td>
            <select name="divide" id="divide">
                <option value="1"  >是</option>
                <option value="0" {if:$offer['divide']==0}selected{/if}>否</option>
            </select>
        </td>
    </tr>
    <tr class='nowrap' {if:!isset($offer['divide']) || $offer['divide']==0}style="display: none"{/if}>
        <td nowrap="nowrap" ><span>*</span>最小起订量：</td>
        <td>
            <span><input name="minimum" id="" type="text" class="text" value="{$offer['minimum']}" /></span>
            <span></span>
        </td>
    </tr>
    <tr class='nowrap' {if:!isset($offer['divide']) || $offer['divide']==0}style="display: none"{/if}>
        <td nowrap="nowrap" ><span>*</span>最小递增量：</td>
        <td>
            <span><input name="minstep" id="" type="text" class="text" value="{$offer['minstep']}" /></span>
            <span></span>
        </td>
    </tr>
    <tr>
        <td><span>*</span>交收地点：</td>
        <td colspan="2">

            <span><input type="text" class='text' datatype="s1-30" value="{$offer['accept_area']}" errormsg="请填写有效地址" nullmsg="请填写交收地点" name="accept_area"></span>

            <span></span>
        </td>
    </tr>
    <tr>
    <td><span>*</span>交收时间：</td>
    <td colspan="2">
        <span>T+<input type="text" class='text' datatype="/[1-9]\d{0,5}/" value="{$offer['accept_day']}" name="accept_day" style="width:50px;">天</span>
        <span></span>
    </td>
    </tr>

    <tr>
    <td>记重方式：</td>
    <td colspan="2">
        <span>
            <select name="weight_type">
                <option value="理论值">理论值</option>
                <option value="过磅">过磅</option>
                <option value="轨道衡">轨道衡</option>
                <option value="吃水">吃水</option>
            </select>
        </span>
        <span></span>
    </td>
    </tr>

    <tr>
        <!--  <td>是否投保：</td>
         <td colspan="2">
<input type ="radio" name ="safe" checked="checked" style="width:auto;height:auto;">投保
<input type ="radio" name ="safe" style="width:auto;height:auto;"> 不投保
         </td>
     </tr>  -->
    <tr>
        <td>产品描述：</td>
        <td colspan="2">
            <textarea name="note" >{$product['note']}</textarea>
        </td>
    </tr>

    <tr>
        <td>补充条款：</td>
        <td colspan="2">
            <textarea name="other">{$offer['other']}</textarea>
        </td>
    </tr>
