 <link rel="stylesheet" type="text/css" href="{views:css/shopdetail.css}">
<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>

 <form action="{url:/ucenter/shopinfo}" method="POST" auto_submit> 
 <div class="user_c">
                <div class="user_zhxi">
                    <div class="zhxi_tit">
                        <p><a>账户管理</a>><a>商铺信息</a></p>
                    </div>
                    <div style="float:left">
        <!--店铺广告位start  -->
         <div class="dex_ad">
             
            <div class="dex_ad_lf">
                <div class="ad_box_log"></div>

            </div>
            <div class="dex_ad_rg">
                <h1>{$companyInfo['company_name']}</h1>
                <h2>主营产品：<input type="text" name="type" value="{$shopData['products']}" datatype="s1-30" errormsg="填写主营产品">   </h2>
                <h3>联系电话：<input type="text" name="tel" value="{$shopData['tel']}" datatype="/^[0-9\-]{6,12}$/" errormsg="格式错误">  </h3>


            </div>

         </div>

           <!--店铺广告位end  -->

  <!--店铺公司介绍start  -->

       <div class="pany_intro topnone">
            
        <div class="intro_lf">
          <h3><i></i><b>公司介绍</b></h3>
          <div class="intro_box" id='imgContainer'>{if:!empty($shopData['logo_url'])}<img src="{$shopData['logo_url']}">{/if}</div>

上传logo：
                                    <span>
                                        <div>

                                            <input id="pickfiles"  type="button" value="选择文件">
                                            <input type="button"  id='uploadfiles' class="tj" value="上传">
                                        </div>
                                        <div id="filelist"></div>
                                        <pre id="console"></pre>
                                    </span>

          </div>







        <div class="intro_rg">

                <p> <textarea cols="31" rows="15" name="info">
                    {$shopData['info']}</textarea> 。</p>

            
          </div>



       </div>

           <!--店铺公司介绍end  -->

   <!-- 联系我们start -->


   <div class="pany_intro">
            
        <div class="intro_lf">
          <h3><i></i><b>联系我们</b></h3>
          <div class="intro_word">
              <p>公司名称：{$companyInfo['company_name']}</p>
              <p>联系人：{$companyInfo['contact']}</p>
              <p>电话：{$companyInfo['contact_phone']}</p>
              <p>地址：<span id="area">{areatext: data=$companyInfo['area'] id=area}</span></p>
          </div>
      
            
          </div>

        <div class="intro_rg" >

           <div class="intro_map" id="showimg1">{if: !empty($shopData['map_url'])}<img src="{$shopData['map_url']}" alt="" />{/if}</div>     

            
          </div>
                      <span>
                                        <div>
                                                    <input id="pickfiles3"  type="button" value="选择文件">
            <input type="button"  id='uploadfiles3' class="tj" value="上传">
                                        </div>
                                    </span>
       </div>
    
{$mapPlupload}

       <!-- 联系我们end -->
<!-- 商户资质start -->


     <div class="pany_intro">
               
          <h3><i></i><b>商户资质</b></h3>
                      <span>
                                        <div>
                                                    <input id="pickfiles1"  type="button" value="选择文件">
            <input type="button"  id='uploadfiles1' class="tj" value="上传">
                                        </div>
                                    </span>
          <div id="showimg">
            {if: empty($photosList['qa'])}
              <h5>暂无数据</h5>
              {else:}
                {foreach: items=$photosList['qa']}
                    <img src="{$item['img_url']}">
                {/foreach}
              {/if}
          </div>
           

       </div>

 {$qaPlupload}










    <!-- 用户资质end -->


<!-- 商户形象start -->

     <div class="pany_intro">
            
        
          <h3><i></i><b>商户形象</b></h3>
                                <span>
                                        <div>
                                                    <input id="pickfiles2"  type="button" value="选择文件">
            <input type="button"  id='uploadfiles2' class="tj" value="上传">
                                        </div>
                                    </span>
                                     <div id="showimgs">
           {if: empty($photosList['im'])}
              <h5>暂无数据</h5>
              {else:}
                {foreach: items=$photosList['im']}
                    <img src="{$item['img_url']}">
                {/foreach}
              {/if}
           </div>

       </div>
{$imPlupload}

<div class="zhxi_con">
                           <span><input class="submit" type="submit" value="保存"/></span>
                        </div>
</div>
</form>

    <!-- 商户形象end -->

        {$logoplupload}