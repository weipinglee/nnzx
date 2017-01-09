
<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" /> 客服管理</h1>
    <div class="bloc">
        <div class="title">
            客服列表
        </div>
        <div class="content">
            <div class="cl pd-5 bg-1 bk-gray"> <a class="btn btn-primary radius" href="{url:system/kefu/kefuAdd}"><i class=" icon-plus fa-plus"></i> 添加客服</a> </span>  </div>
            <div class="pd-20">

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="100">用户名</th>
                            <th width="100">客服名称</th>
                            <th width="90"> 手机</th>
                            <th width="50">QQ</th>
                            <th width='100'>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach:items=$data}
                            <tr class="text-c">
                                <td><u style="cursor:pointer" class="text-primary" >{$item['name']}</u></td>
                               <td><u style="cursor:pointer" class="text-primary" >{$item['ser_name']}</u></td>
                                <td class="text-primary" >{$item['phone']}</td>
                                <td>{$item['qq']}</td>
                                <td class="td-manage">
                                    <a title="编辑" href="{url:system/kefu/kefuAdd?id=$item['admin_id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
                                    <a title="删除" href="javascript:void(0);"  ajax_status=-1 ajax_url="{url:system/kefu/del?id=$item['admin_id']}"  class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
                            </tr>
                        {/foreach}
                        </tbody>

                    </table>
                    {$bar}
                </div>
            </div>