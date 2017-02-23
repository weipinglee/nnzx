
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 账户明细</h1>
<div class="bloc">
    <div class="title">
        账户明细
    </div>
    <div class="content">
        <div class="pd-20">

    <div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="100">用户名</th>
                <th width="90">流水号</th>
                <th width="50">收入</th>
                <th width="100">支出</th>
                <th width='100'>冻结</th>
                <th width='100'>总金额</th>
                <th width='100'>可用</th>
                <th width='100'>摘要</th>
                <th width='100'>交易时间</th>
            </tr>
        </thead>
        <tbody>
        {foreach:items=$userAccInfo}
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td><u style="cursor:pointer" class="text-primary" >{$item['username']}</u></td>
                <td>{$item['flow_no']}</td>
                <td>{$item['fund_in']}</td>
                <td>{$item['fund_out']}</td>
                <td>{$item['freeze']}</td>
                <td>{$item['total']}</td>
                <td>{$item['active']}</td>
                <td>{$item['note']}</td>
                <td>{$item['time']}</td>
<!--                 <td class="td-manage">
    <a title="查看明细" href="{url:/balance/accManage/userAccInfo}?user_id={$item['user_id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
            </tr> -->
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
        {$userAccBar}
    </div>
</div>