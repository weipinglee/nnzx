 <link rel="stylesheet" type="text/css" href="{views:css/shopdetail.css}">
<script type="text/javascript" src="{views:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{views:js/area/Area.js}" ></script>

<div id="mainContent">
        <div class="page_width">
          <!--搜索条件 start
          <div class="pro_se">
        <table>
          <tr>
            <td><span>大类</span> <select><option>全部</option></select></td>
            <td><span>规格</span> <input type="text"/></td>
            <td><span>材质</span> <input type="text"/></td>
            <td><span>产地</span> <input type="text"/></td>
            <td><span>品名</span> <input type="text"/></td>
            <td><span>仓库</span> <input type="text"/></td>
            <td><a class="search"><i class="icon-search"></i> 搜索</a>
        
              <a class="pro_clear"><i class=""></i>清空</a>
            </td>
          </tr>
        </table>
          </div>
          <!--搜索条件 end-->
        <!--店铺广告位start  -->

         <div class="dex_ad">
             
            <div class="dex_ad_lf">
                <div class="ad_box_log">{if:!empty($shopData['logo_url'])}<img src="{$shopData['logo_url']}">{/if}</div>

            </div>
                        <div class="dex_ad_rg">
                <h1>{$companyInfo['company_name']}</h1>
                <h2>主营产品：{$shopData['products']}</h2>
                <h3>联系电话：{$shopData['tel']}</h3>


            </div>


         </div>

           <!--店铺广告位end  -->

  <!--店铺公司介绍start  -->

       <div class="pany_intro topnone">
            
        <div class="intro_lf">
          <h3><i></i><b>公司介绍</b></h3>
          <div class="intro_box" id='imgContainer'>{if:!empty($shopData['logo_url'])}<img src="{$shopData['logo_url']}">{/if}</div>
       

            
          </div>






        <div class="intro_rg">

                <p>  {$shopData['info']}</p>

            
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

        <div class="intro_rg">

           <div class="intro_map" id="showimg1">{if: !empty($shopData['map_url'])}<img src="{$shopData['map_url']}" alt="" />{/if}</div>     

            
          </div>

       </div>
    


       <!-- 联系我们end -->
<!-- 商户资质start -->


     <div class="pany_intro">
               
          <h3><i></i><b>商户资质</b></h3>
                                  {if: empty($photosList['qa'])}
              <h5>暂无数据</h5>
              {else:}
                {foreach: items=$photosList['qa']}
                    <img src="{$item['img_url']}">
                {/foreach}
              {/if}     

       </div>

    <!-- 用户资质end -->


<!-- 商户形象start -->

     <div class="pany_intro">
            
        
          <h3><i></i><b>商户形象</b></h3>
      {if: empty($photosList['im'])}
              <h5>暂无数据</h5>
              {else:}
                {foreach: items=$photosList['im']}
                    <img src="{$item['img_url']}">
                {/foreach}
              {/if}

       </div>

                  <div class="pro_classify">
                   <div class="pany_intro none">
                        <h3><i></i><b>商品列表</b></h3>
                  </div>