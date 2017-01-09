
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 会员代理账户</h1>
<div class="bloc">
    <div class="title">
        账户列表
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
                <th width="70">用户名</th>
                <th width="90">手机号</th>
                <th width="60">总金额</th>
                <th width="50">可用资金</th>
                <th width="100">冻结资金</th>
                <th width='100'>操作</th>
            </tr>
        </thead>
        <tbody>
        {foreach:items=$data['list']}
            <tr class="text-c">
                <td><input type="checkbox" value="" name="check"></td>
				 <td>{$item['user_no']}</td>
                <td><u style="cursor:pointer" class="text-primary" >{$item['username']}</u></td>
                <td>{$item['mobile']}</td>
                <td>{$item['amount']}</td>
                <td>{$item['fund']}</td>
                <td>{$item['freeze']}</td>
                <td class="td-manage">
                    <a title="查看明细" href="{url:/balance/accManage/userAccInfo}?user_id={$item['user_id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
            </tr>
        {/foreach}
        </tbody>
    <script type="text/javascript">
    function delFundOut(id,obj){
        var obj=$(obj);
        var url="{url:/balance/fundOut/del}";
        if(confirm("确定要删除吗")){
            $.ajax({
                type:'get',
                cache:false,
                data:{id:id},
                url:url,
                dataType:'json',
                success:function(msg){
                    if(msg['code']==1){

                        obj.parents("tr").remove(); 
                    }else{
                        alert(msg['info']);
                    }
                }           
            });
        }
    }
</script>
    </table>
        {$data['bar']}
    </div>
</div>