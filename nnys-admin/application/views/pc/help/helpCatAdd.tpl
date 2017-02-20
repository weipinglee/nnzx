<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<div id="content" class="white">
    <h1><img src="{views:img/icons/dashboard.png}" alt="" />添加帮助分类
    </h1>

    <div class="bloc">
        <div class="title">
            添加帮助分类
        </div>
        <div class="pd-20">
            <form action="{url:tool/help/helpCatAdd}" method="post" class="form form-horizontal" id="form-member-add" auto_submit redirect_url="{url:tool/help/helpCatList}">
                <input type="hidden" name="id" value="{if:isset($helpCatInfo)}{$helpCatInfo['id']}{/if}" />
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>名称：</label>
                    <div class="formControls col-5">
                        <input type="text" class="input-text" value="{if:isset($helpCatInfo)}{$helpCatInfo['name']}{/if}" id="" name="name" datatype="s2-50" nullmsg="分类名不能为空">
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>排序：</label>
                    <div class="formControls col-5">
                        <input type="text" class="input-text" value="{if:isset($helpCatInfo)}{$helpCatInfo['sort']}{else:}100{/if}" placeholder="" datatype="n1-20" name="sort" errormsg="排序为数字" >
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-3"><span class="c-red">*</span>是否开启：</label>
                    <div class="formControls col-5 skin-minimal">
                        <div class="radio-box">
                            <input type="radio"  name="status"  value="1" {if:!isset($helpCatInfo) ||$helpCatInfo['status']==1}checked{/if} >
                            <label >开启</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio"  name="status"  value="0" {if:isset($helpCatInfo) && $helpCatInfo['status']==0}checked{/if}>
                            <label >关闭</label>
                        </div>
                    </div>
                    <div class="col-4"> </div>
                </div>


                    </div>


                 <div class="row cl">
                     <div class="col-9 col-offset-3" style="padding:0 0 20px 10px;">
                         <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                     </div>
                 </div>
                    
                </div>
                    <div class="col-4"> </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

</div>
