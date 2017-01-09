
<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" /> 业务员管理</h1>
    <div class="bloc">
        <div class="title">
            业务员列表
        </div>
        <div class="content">
            <div class="cl pd-5 bg-1 bk-gray"> <a class="btn btn-primary radius" href="{url:system/yewu/kefuAdd}"><i class="icon-plus fa-plus "></i> 添加业务员</a> </span>  </div>
            <div class="pd-20">

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="100">用户名</th>
                            <th width="100">业务员名称</th>
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
                                    <a title="编辑" href="{url:system/yewu/kefuAdd?id=$item['admin_id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
                                    <a title="删除" href="javascript:void(0);"  ajax_status=-1 ajax_url="{url:system/yewu/del?id=$item['admin_id']}"  class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
                            </tr>
                        {/foreach}
                        </tbody>

                    </table>
                    {$bar}
                </div>
            </div>