
<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" /> 保险管理</h1>
    <div class="bloc">
        <div class="title">
            保险产品列表
        </div>
        <div class="content">
            <div class="cl pd-5 bg-1 bk-gray"> <a class="btn btn-primary radius" href="{url:Trade/Insurance/insuranceAdd}"><i class=" icon-plus"></i> 添加保险产品</a> </span>  </div>
            <div class="pd-20">

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="100">保险产品名称</th>
                            <th width="100">保险公司</th>
                            <th width="90"> 保额方式</th>
                            <th width="50">状态</th>
                            <th width='100'>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach:items=$list}
                            <tr class="text-c">
                                <td><u style="cursor:pointer" class="text-primary" >{$item['name']}</u></td>
                               <td><u style="cursor:pointer" class="text-primary" >{$company[$item['company']]}</u></td>
                                <td class="text-primary" >{if:$item['mode']==1}比例 : {$item['rate']}(‰)
                                {else:}定额 : ({$item['fee']}){/if}</td>
                                <td class="td-status">
                                    {if:$item['status'] == 1}
                                        <span class="label label-success radius">已启用</span>
                                    {else:}
                                        <span class="label label-error radius">停用</span>
                                    {/if}
                                </td>
                                <td class="td-manage">
                                {if:$item['status'] == 1}
                                    <a style="text-decoration:none" href="javascript:;" title="停用" ajax_status=0 ajax_url="{url:trade/insurance/ajaxUpdateStatus?id=$item['id']}"><i class="icon-pause"></i></a>
                                {elseif:$item['status'] == 0}
                                    <a style="text-decoration:none" href="javascript:;" title="启用" ajax_status=1 ajax_url="{url:trade/insurance/ajaxUpdateStatus?id=$item['id']}"><i class="icon-play"></i></a>
                                {/if}
                                    <a title="编辑" href="{url:trade/insurance/detail?id=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit"></i></a>
                                    <a title="删除" href="javascript:void(0);"  ajax_status=-1 ajax_url="{url:trade/insurance/delete?id=$item['id']}"  class="ml-5" style="text-decoration:none"><i class="icon-trash"></i></a></td>
                            </tr>
                        {/foreach}
                        </tbody>

                    </table>
                    {$bar}
                </div>
            </div>