        <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
        <script type="text/javascript" src="{views:js/validform/validform.js}"></script>
        <script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <script type="text/javascript" src="{views:js/layer/layer.js}"></script>

        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" /> 开闭市设置
</h1>
                
<div class="bloc">
    <div class="title">
       交易日历
    </div>
    <div class="content dashboard">
        <div>
            <form action="{url:balance/open/calendar}" method="post" class="form form-horizontal" id="form-scaleoffer-add" auto_submit no_redirect='1'>
        <div id="tab-system" class="HuiTab">
            <input type="hidden" name="date" value="{$deal['date']}" />
            <div class="tabCon" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>可交易时间</label>
                    <div class="formControls col-10">
                        <input type="checkbox" name="weeks[]" value="1" {if: in_array(1, $deal['weeks'])} checked {/if}>周一
                        <input type="checkbox" name="weeks[]" value="2" {if: in_array(2, $deal['weeks'])} checked {/if}>周二
                        <input type="checkbox" name="weeks[]" value="3" {if: in_array(3, $deal['weeks'])} checked {/if}>周三
                        <input type="checkbox" name="weeks[]" value="4" {if: in_array(4, $deal['weeks'])} checked {/if}>周四
                        <input type="checkbox" name="weeks[]" value="5" {if: in_array(5, $deal['weeks'])} checked {/if}>周五
                        <input type="checkbox" name="weeks[]" value="6" {if: in_array(6, $deal['weeks'])} checked {/if}>周六
                        <input type="checkbox" name="weeks[]" value="0" {if: in_array(0, $deal['weeks'])} checked {/if}>周日
                    </div>
                </div>
            <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>开市时间</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-title" onclick="WdatePicker({dateFmt:'HH:mm:ss',minDate:'08:00:00',quickSel:['%H-00-00','%H-15-00','%H-30-00','%H-45-00']})"  name='start_time' value="{$deal['start_time']}" >
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>闭市时间</label>
                    <div class="formControls col-10"> <input type="text" id="website-title" onclick="WdatePicker({dateFmt:'HH:mm:ss',minDate:'08:00:00',quickSel:['%H-00-00','%H-15-00','%H-30-00','%H-45-00']})"  name='end_time' value="{$deal['end_time']}" class="text">
                    </div>
                </div>
                <!-- 
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>关键词：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-Keywords" placeholder="5个左右,8汉字以内,用英文,隔开" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>描述：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-description" placeholder="空制在80个汉字，160个字符以内" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>css、js、images路径配置：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-static" placeholder="默认为空，为相对路径" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>上传目录配置：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-uploadfile" placeholder="默认为uploadfile" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>底部版权信息：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-copyright" placeholder="© 2014 H-ui.net" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2">备案号：</label>
                    <div class="formControls col-10">
                        <input type="text" id="website-icp" placeholder="京ICP备00000000号" value="" class="input-text">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2">统计代码：</label>
                    <div class="formControls col-10">
                        <textarea class="textarea"></textarea>
                    </div>
                </div> -->
            </div>            
        </div>


            <div class="cb">
                
            </div>

        <div class="row cl">
            <div class="col-10 col-offset-2">
               <button  class="btn btn-primary radius" type="submit"><i class="icon-save fa-save"></i> 保存</button>(以上设置保存后，第二天生效！)
                <!-- <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
            </div>
        </div>
        </form>
        </div>
    </div>
</div>


                
       
</form>
</div>
        
        
    </body>
</html>