
<link rel="stylesheet" type="text/css" href="{views:css/submit_order.css}"/>
<style type="text/css">
    /*临时顶部图片style 要remove的*/
    body{behavior:url(css/csshover.htc);}
    #close_banner
    {
        font-size: 30px;
        color: #000;
        position: absolute;
        right: 10px;
        font-family: Times New Roman;
        top: 5px;
        display: block;
        width: 14px;
        line-height: 17px;
        height: 14px;
    }
    #close_banner:hover
    {
        text-decoration: none;
        margin-top: 1px;
    }
    #banner_bar
    {
        text-align: center;
        position: relative;
        height:153px;
        background:url(images/top_index_bg1.jpg) no-repeat center #fff;
    }
</style>
    <!------------------导航 开始-------------------->
    <form method="post" action="" id="form1">
        <div class="aspNetHidden">
        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="b7kHdN58Jsi2cPaAmmpEqXjSD5M7lilMmnUNdKzTkgYwpBrDsYEml4gvo/iOj8sf">
        </div>
    </form>


    <input type="hidden" id="UserID">
    <!--主要内容 开始-->
    <div id="mainContent" style="background:#FFF;"> 
    
    
    
    
    
        <div class="page_width">

            
            <!----第一行搜索  开始---->
            <div class="mainRow1">
                <!--搜索条件 开始-->
                    
            
 
            
              
             <!------------------交易 开始-------------------->
            <div class="submit">
             
             <!--头部开始-->
             <div class="submit_word">
             <span>支付货款</span>
             <span>支付完成</span>
             </div>  
            <div class="submit_photo">
              <img src="{views:images/order/oder-5.jpg}" width="209" height="47" alt="第一步" /> 
              <img src="{views:images/order/oder-7.jpg}" width="203" height="47" alt="第二步" />
              </div> 
              <!--头部结束--> 
              <div class="alreaor">
             <h1>{if:$info}{$info}{else:}支付完成，订单已生成！{/if}</h1>
               
               
               
               
               <div class="bormin">
               <p>订单号<i class="spsce">：</i>{$order_no}</p>
               <p>订单总额<i>：</i>￥{$amount}</p>
               <p>已支付<i>：</i>￥{$pay_deposit}</p>
<!-- 
               <p>交货地点<i>:</i>4</p> -->

               <div class="od_buton">
                <a class="fanhod" href="{url:/Offers/offerList}">继续浏览</a>
                <a class="fanhod" href="{url:/contract/buyerDetail?id=$id@user}">查看合同</a>
                
                
                </div>

               
               </div>
               
               
               
               
               
               
               
               
               
               
            </div>
            

             </div>
       <!------------------交易 结束-------------------->



       


                  
