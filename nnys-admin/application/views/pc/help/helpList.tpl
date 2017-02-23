
<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" /> 帮助管理</h1>
    <div class="bloc">
        <div class="title">
            帮助列表
        </div>
        <div class="content">
            <div class="cl pd-5 bg-1 bk-gray"> <a class="btn btn-primary radius" href="{url:/tool/help/helpAdd}"><i class=" icon-plus fa-plus"></i> 添加帮助</a> </span>  </div>
            <div class="pd-20">

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="checkall" value=""></th>
                            <th width="100">名称</th>
                            <th width="90"> 帮助分类</th>
                            <th width="50">排序</th>
                            <th width='100'>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach:items=$helpList}
                            <tr class="text-c">
                                <td><input type="checkbox" value="" name="check"></td>
                                <td><u style="cursor:pointer" class="text-primary" >{$item['name']}</u></td>
                                <td class="text-primary" >{$item['cname']}</td>
                                <td>{$item['sort']}</td>
                                <td class="td-manage">
                                    <a title="编辑" href="{url:/tool/help/helpAdd}?id={$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
                                    <a title="删除" href="javascript:void(0);"  ajax_status=-1 ajax_url="{url:tool/help/delHelp?id=$item['id']}"  class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
                            </tr>
                        {/foreach}
                        </tbody>
                        <script type="text/javascript">
                            function delFundOut(name,obj){
                                var obj=$(obj);
                                var name=name;
                                var url="{url:/tool/help/delHelp}";
                                if(confirm("确定要删除吗")){
                                    $.ajax({
                                        type:'get',
                                        cache:false,
                                        data:{id:name},
                                        url:url,
                                        dataType:'json',
                                        success:function(msg){
                                            if(msg['success']==1){

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
                    {$pageBar}
                </div>
            </div>