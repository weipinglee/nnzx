
<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" /> 委托费率</h1>
    <div class="bloc">
        <div class="title">
            委托费率列表
        </div>
        <div class="content">
            <div class="cl pd-5 bg-1 bk-gray"> <a class="btn btn-primary radius" href="{url:system/Confsystem/entrustadd}"><i class=" icon-plus"></i> 添加委托费率</a> </span>  </div>
            <div class="pd-20">
              {include:layout/search.tpl}
                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="100">编号</th>
                            <th width="100">商品类别</th>
                            <th width="90"> 费率类型</th>
                            <th width="90"> 费率值</th>
                            <th width="90"> 备注</th>
                            <th width="50">状态</th>
                            <th width='100'>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach:items=$data['list']}
                            <tr class="text-c">
                                <td><u style="cursor:pointer" class="text-primary" >{$item['id']}</u></td>
                               <td><u style="cursor:pointer" class="text-primary" >{$item['name']}</u></td>
                                <td class="text-primary" >{if: $item['type'] == 1}定值{else:}百分比{/if}</td>
                                <td class="text-primary" >{$item['value']}</td>
                                <td class="text-primary" >{$item['note']}</td>
                                <td class="td-status">
                                    {if:$item['status'] == 1}
                                        <span class="label label-success radius">已启用</span>
                                    {else:}
                                        <span class="label label-error radius">停用</span>
                                    {/if}
                                </td>
                                <td class="td-manage">
                                {if:$item['status'] == 1}
                                    <a style="text-decoration:none" href="javascript:;" title="停用" ajax_status=0 ajax_url="{url:system/Confsystem/entrustupdatestatus?id=$item['id']}"><i class="icon-pause"></i></a>
                                {elseif:$item['status'] == 0}
                                    <a style="text-decoration:none" href="javascript:;" title="启用" ajax_status=1 ajax_url="{url:system/Confsystem/entrustupdatestatus?id=$item['id']}"><i class="icon-play"></i></a>
                                {/if}
                                    <a title="编辑" href="{url:system/Confsystem/entrustupdate?id=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit"></i></a>
                                    <a title="删除" href="javascript:void(0);"  ajax_status=-1 ajax_url="{url:system/Confsystem/entrustdel?id=$item['id']}"  class="ml-5" style="text-decoration:none"><i class="icon-trash"></i></a></td>
                            </tr>
                        {/foreach}
                        </tbody>

                    </table>
                    {$bar}
                </div>
            </div>