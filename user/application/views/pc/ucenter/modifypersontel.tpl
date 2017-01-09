<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
<input type="hidden" name="attr_url" value="{url:/Managerstore/ajaxGetCategory}"  />
    <script src="{views:js/passwordReset.js}"></script>
<link href="{views:css/center_top.css}" rel="stylesheet" type="text/css" />
<!-- 基本信息css -->
<link href="{views:css/center_date.css}" rel="stylesheet" type="text/css" />
<style type="text/css">.input-file{float: left;} body{background: #fff;}</style>
    <div class="right_c">
      <div class="r_c_title">
        <a class="tit_span">手机号申述修改</a>
      </div>
      <div class="rc_bate">
        <div class="jd_img">
          <img src="{views:images/icon/infor_jd2.jpg}">
          <div class="jd_ts">
            <img src="{views:images/icon/icon_ts.jpg}"/>
            <span>请填写真实准确的信息，有利于提高申诉成功率，耐耐网会保护您的个人信息。</span>
          </div>
        </div>
 <form action="{url:/ucenter/modifypersontel}" method="post" auto_submit redirect_url="{url:/ucenter/telend} " >

          <div class="bate-input clear">
            <span class="span_in_tit">
              真实姓名：
            </span>
            <span class="input_span"><input type="text" class="wbk" id="txtname" name="name" datatype="zh2-20" errormsg="请填写真实姓名" nullmsg="请填写真实姓名" /></span>
          </div>
          <div class="bate-input clear">
            <span class="span_in_tit">
              身份证号：
            </span>
            <span class="input_span"><input type="text" class="wbk" id="txtno" name="no" datatype="identify" errormsg="请填写身份证号" nullmsg="请填写身份证号" /></span>
          </div>
          <div class="bate-input clear">
            <span class="span_in_tit">
              新的手机号：
            </span>
            <span class="input_span"><input type="text" class="wbk" id="txtname" name="mobile" datatype="mobile" errormsg="请填写手机号" nullmsg="请填写手机号" /></span>
          </div>
          <div class="bate-input clear">
            <span class="span_in_tit">
              上传身份证：
            </span>
            <span class="input-file" style="float:left;top:13px;">选择文件
              <!-- <a class="flie_a">上传本人身份证照片</a> -->
               <input class="doc" type="file" name="file1" id="file1" onchange="javascript:uploadImg(this);" value="上传本人身份证照片" >
               <input type="hidden" name="imgfile1" value="" datatype="*" id="noimg" nullmsg="上传身份证" />
            </span> 
            <div class="cksl">
              <a class="ck_span">参考示例</a>
              <div class="cksl_bk" style="background: #fff; z-index: 99; margin-left:120px;">
                <div class="c-tip-arrow"><em></em><ins></ins></div>
                <h4 class="cksl_title">示例</h4>
                <div class="cksl_img">
                  <img src="{views:images/icon/ck_img.jpg}"/>
                </div>
                <div class="cksl_ts">照片需完整包括持卡人头部和身份证件，身份证件正面（带照片那一面）所有信息清晰可见。图片大小不超过2M。</div>
              </div>
            </div>            
          </div>


          <div class="bate-input clear">
            <span class="span_in_tit">
              身份证照片：
            </span>
            <span class="input_span">
              <div class="sfz_img">
                <img name="file1" />
              </div>
            </span>             
          </div>

          <div class="bate-input clear">
            <span class="span_in_tit">
              上传申请单：
            </span>
            <span class="input-file" style="float:left;top:13px;">选择文件
              <input class="doc" type="file" name="file2" id="file2" onchange="javascript:uploadImg(this);" >
              <input type="hidden" name="imgfile2" value="" datatype="*" id="applyimg" nullmsg="上传申请单" />
            </span> 
            <div class="cksl">
              <a class="ck_span2">要求说明</a>
              <div class="cksl_bk2" style="background: #fff; z-index: 99;margin-left:120px;">
                <div class="c-tip-arrow"><em></em><ins></ins></div>
                <h4 class="cksl_title2">要求说明</h4>
                <div class="cksl_ts">申请单内容至少包括申请人、原因,上传时请保证申请单图片上所有说明信息清晰可见，（企业账号需加盖企业公章），图片大小不超过2M</div>
              </div>
            </div>            
          </div>
          <div class="bate-input clear">
            <span class="span_in_tit">
              申请单图片：
            </span>
            <span class="input_span">
              <div class="sfz_img">
                    <img name="file2" />
              </div>
            </span>             
          </div>

          <div class="bate-input clear">
          <input type='hidden' value='{url:/ucenter/paysecretperson}' id='findUrl'>
          <div class="bate-input clear">
            <div class="but_div">
<input type="submit" value="下一步" class="but_in">
          </div>
      </div>
    </div>
    </form>