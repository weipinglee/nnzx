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
       日结时间设置
    </div>
    <div class="content dashboard">
        <div>
            <form action="{url:balance/open/day}" method="post" class="form form-horizontal" id="form-scaleoffer-add" auto_submit redirect_url='{url:balance/open/day}'>
        <div id="tab-system" class="HuiTab">
            
            <div class="tabCon" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>当前日结时间</label>
                    <div class="formControls col-10">
                        <input type="text" value="{$detail['daily']}" name='daily' readonly="readonly"> 当前状态为：{$detail['status']}
                    </div>
                </div>

                 <div class="tabCon" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>下一日结时间</label>
                    <div class="formControls col-10">
                    <input type="text" name="nexttime" onclick="WdatePicker({dateFmt:'yyyy-MM-dd', minDate:'%y-%M-%d'})">
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
    <div class="tabCon" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-2"></label>
                    <div class="formControls col-10">点击手工开市后系统立马进入到交易状态，手工开市不受日结时间限制
                    </div>
                </div>

            <div class="cb">
                
            </div>

        <div class="row cl">
            <div class="col-10 col-offset-2">
            {if: $detail['is_show'] == 1}
              <input type="submit"  class="btn btn-primary radius"  name="submit" value="日结">
              {/if}
               <input type="hidden" name="type" >
              <input type="submit"  class="btn btn-primary radius"  name="open" value="手工开市">
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
<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="open"]').on('click', function(){
            $('input[name="type"]').val('daily');
        })

        $('input[name="submit"]').on('click', function(){
            $('input[name="type"]').val('submit');
        })
    });
</script>