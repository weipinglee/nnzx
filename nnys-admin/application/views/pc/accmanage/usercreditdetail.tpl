
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />信誉保证金账户
</h1>
                
<div class="bloc">
    <div class="title">
       用户信息
    </div>
    <form action="{url:balance/accManage/userCreditAdd}" method="post" auto_submit redirect_url='{url:/balance/accManage/userCreditList}'>
         <div class="pd-20">
             <table class="table table-border table-bordered table-bg">
                 <tr>
                     <th>用户名</th>
                     <td>{$info['username']}</td>
                     <th>注册手机号</th>
                     <td>{$info['mobile']}</td>
                     <th>邮箱</th>
                     <td>{$info['email']}</td>
                 </tr>
                 <tr>
                     <th>企业名称</th>
                     <td>{$info['company_name']}</td>
                     <th>法人</th>
                     <td>{$info['legal_person']}</td>
                     <th>注册资金</th>
                     <td>{$info['reg_fund']}</td>
                 </tr>
                 <tr>
                     <th>企业详细地址</th>
                     <td id='area'>{areatext:data=$info['area'] id=area}&nbsp;{$info['address']}</td>
                     <th>联系人</th>
                     <td>{$info['contact']}</td>
                     <th>联系人电话</th>
                     <td>{$info['contact_phone']}</td>
                     

                 </tr>
                <tr>
                    <th scope="col" colspan="1">信誉保证金充值</th>
                    <td colspan="5"><input type="text" class="text" datatype='n' style="width:200px;height: 30px;" name="credit"/></td>
                </tr>
                <tr>
                  <th scope="col" colspan="6">
                    <input type="hidden" name="user_id" value="{$info['user_id']}">
                     <a onclick="javascript:$('form').submit();" class="btn btn-success radius"><i class="icon-ok fa-ok"></i> 确认</a>
                     <a onclick="history.go(-1)" class="btn btn-default radius"><i class="icon-remove fa-remove"></i> 返回</a>
                  </th>
                </tr>
            </table>
        </div>
    </form>
</div>

</div>
        
        
    </body>
</html>