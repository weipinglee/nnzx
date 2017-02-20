        <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
        <script type="text/javascript" src="{views:js/validform/validform.js}"></script>
        <script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <script type="text/javascript" src="{views:js/layer/layer.js}"></script>

        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" /> 系统设置
</h1>
                
<div class="bloc">
    <div class="title">
       商品排序设置
    </div>
    <div class="content dashboard">
        <div>
            <form action="{url:system/Confsystem/productset}" method="post" class="form form-horizontal" id="form-scaleoffer-add" auto_submit redirect_url='{url:system/Confsystem/productset}'>
        <div id="tab-system" class="HuiTab">
            
            <div class="tabCon" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>发布时间比例设置：</label>
                    <div class="formControls col-10">
                        <input type="text" value="{$detail['time']}" name='time' > 
                    </div>
                </div>
                <div class="tabCon" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>时间天数设置：</label>
                    <div class="formControls col-10">
                        <input type="text" value="{$detail['day']}" name='day' > 
                    </div>
                </div>
                <div class="tabCon" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>最大信誉值设置：</label>
                    <div class="formControls col-10">
                        <input type="text" value="{$detail['max_credit']}" name='max_credit' > 
                    </div>
                </div>

                 <div class="tabCon" style="display: block;">
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red">*</span>信誉值比例设置：</label>
                    <div class="formControls col-10">
                    <input type="text" name="credit" value="{$detail['credit']}">
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
            <div class="col-10 col-offset-2">
               <input type="submit"  class="btn btn-primary radius"  name="submit" value="保存">
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