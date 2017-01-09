
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 已审核开户信息</h1>
<div class="bloc">
    <div class="title">
        开户列表
    </div>
    <div class="content">
        <div class="pd-20">
            {include:layout/search.tpl}
    <div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="checkall" value=""></th>
				<th width="60">会员号</th>
                <th width="100">用户名</th>
                <th width="90">开户银行</th>
                <th width="60">银行卡类型</th>
                <th width="50">姓名</th>
                <th width="100">身份证号</th>
                <th width="50">状态</th>
                <th width='100'>操作</th>
            </tr>
        </thead>
        <tbody>
        {set:$bankObj = new \nainai\user\userBank();$card_type = $bankObj->getCardType()}
        {foreach:items=$data['list']}
            {if:$item['status']==0}{set:$status=0}{else:}{set:$status=$item['status']}{/if}
            <tr class="text-c">
                <td><input type="checkbox" value="" name="check"></td>
				<td>{$item['user_no']}</td>
                <td><u style="cursor:pointer" class="text-primary" >{$item['username']}</u></td>
                <td>{$item['bank_name']}</td>
                <td>{$item['card_type']}</td>
                <td>{$item['true_name']}</td>
                <td>{$item['identify_no']}</td>
                <td>{$item['status_text']}</td>
                <td class="td-manage">
                    <a title="查看明细" href="{url:balance/accManage/checkedBankDetail}?user_id={$item['user_id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
            </tr>
        {/foreach}
        </tbody>

    </table>
        {$data['bar']}
    </div>
</div>