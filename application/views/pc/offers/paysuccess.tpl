   <div class="toplog_bor">
    <div class="m_log w1200">
        <div class="logoimg_left">
            <div class="img_box"><img class="shouy" src="{views:images/password/logo.png}" id="btnImg"></div>
            <div class="word_box">支付完成</div>
        </div>
         <div class="logoimg_box">
           <div class="sure_order">
            <img class="" src="{views:images/password/small_1q.png}"> 
            <p>确认订单</p>
           </div>
            <div class="pay_order">
            <img class="" src="{views:images/password/small_2q.png}"> 
            <p>支付货款</p>
           </div>
            <div class="plete_order">
            <img class="" src="{views:images/password/small_3s.png}"> 
            <p>支付完成</p>
           </div>
         </div>
        
    </div>
   </div> 
<div class="clearfix"></div> 
 

    <!--主要内容 开始-->
    <div id="mainContent" style="background:#FFF;"> 

          <div class="pay_succeed">
            <div class="sued_top">
              <img src="{views:images/password/succeed.png}" alt="" />
              <p>{if:$info}{$info}{else:}支付完成，订单已生成！{/if}</p>
            </div>
            <div class="sued_cen">
              <ul>
                <li><b>订单号：</b><span>{$order_no}</span></li>
                <li><b>订单总额：</b><span>￥<i>{$amount}<i></span></li>
                <li><b>已支付：  </b><span class="bfpay">￥<i>{$pay_deposit}<i></span></li>
              </ul>

            </div>

            <div class="sued_bottom">
              <a class="goon_look" href="{url:/Offers/offerList}">继续浏览</a>
              <a class="hetong_look" href="{url:/contract/buyerDetail?id=$id@user}">查看合同</a>
            </div>
          </div>

    </div> 
    <div class="line_dashed"></div>


