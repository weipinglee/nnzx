        <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
        <script type="text/javascript" src="{views:js/validform/validform.js}"></script>
        <script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <script type="text/javascript" src="{views:js/layer/layer.js}"></script>
        <!--            
              CONTENT 
                        -->
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />开户详情
</h1>

<div class="bloc">
    <div class="title">
       开户审核
    </div>
     <div class="pd-20">

     <form action="{url:balance/accManage/checkBankDetail}" method="POST" auto_submit redirect_url="{url:balance/accManage/checkBankList}">


	 	 <table class="table table-border table-bordered table-bg">

	 		<tr>
	 			<th>用户名称</th>
	 			<td>{$user['company_name']}{$user['true_name']}</td>
	 			<th>用户类型</th>
	 			<td>{$user['user_type']}</td>
	 			<th>用户行业</th>
	 			<td>{$user['category']}</td>
                <th></th>
                <td></td>
	 		</tr>
            <tr>
                {if:$user['type']==1}
                <th>联系人</th>
                <td>{$user['contact']}</td>
                <th>联系人电话</th>
                <td>{$user['contact_phone']}</td>
                {else:}
                    <th>联系人电话</th>
                    <td>{$user['mobile']}</td>
                {/if}

                <th>用户地区</th>
                <td><span id="area">{areatext:data=$user['area'] id=area}</span></td>
                <th>详细地址</th>
                <td>{$user['address']}</td>



            </tr>
      	 		<tr>
                    <th>银行名称</th>
                    <td >{$bank['bank_name']}</td>
                    <th>卡号</th>
                    <td >{$bank['card_no']}</td>
                    <th>卡类型</th>
                    <td >{$bank['card_type_text']}</td>
                    <th></th>
                    <td></td>
      	 		</tr>
             <tr>
                 <th>开户姓名</th>
                 <td >{$bank['true_name']}</td>
                 <th>开户身份证</th>
                 <td >{$bank['identify_no']}</td>
                 <th>申请时间</th>
                 <td >{$bank['apply_time']}</td>
                 <th></th>
                 <td></td>
            </tr>
            <tr>
                <th>凭证</th>
                <td colspan="5">
                        <ul>
                        <li>{img:data=$bank['proof'] width=200 height=200}</li>
                </td>
            </tr>
            <tr>

              <th>状态</th>
              <td colspan="5">{$bank['status_text']}</td>

            </tr>
            <tr>
                 <th>审核意见</th>
                  <th scope="col" colspan="7">
                      <textarea name='message'></textarea>
                 </th>
             </tr>
             <tr>
                 <th>处理结果</th>
                 <th scope="col" colspan="7">
                     <input  type="hidden" name="id" value="{$bank['user_id']}" />
                     <label><input type="radio" name="status" value="1" checked/>通过</label>
                     <label><input type="radio" name="status" value="0"/>不通过</label>


                 </th>
             </tr>
             <tr>
                 <th>操作</th>
                 <th scope="col" colspan="7">
                     <input type="submit" class="btn btn-primary radius" value="提交"/>
                     <a onclick="history.go(-1)" class="btn btn-default radius"><i class="icon-remove fa-remove"></i> 返回</a>
                 </th>
             </tr>

	 	</table>
    </form>
 	</div>
</div>
</div>

        
    </body>
</html>