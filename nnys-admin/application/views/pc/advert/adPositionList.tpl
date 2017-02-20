
<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" /> 广告位列表</h1>
    <div class="bloc">
        <div class="title">
            广告位列表
        </div>
        <div class="content">
            <div class="pd-20">
                <div class="cl pd-5 bg-1 bk-gray"> <span class="l"><a class="btn btn-primary radius" href="{url:tool/advert/adPositionAdd}"><i class=" icon-plus fa-plus"></i> 添加广告位</a> </span>  </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="checkall" value=""></th>
                            <th width="100">广告位名称</th>
                            <th width="60">宽高</th>
                            <th width="80">开启状态 </th>

                            <th width='100'>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach:items=$adPositionList}
                        <tr class="text-c">
                            <td><input type="checkbox" value="" name="check"></td>
                            <td><u style="cursor:pointer" class="text-primary" >{$item['name']}</u></td>
                            <td>{$item['width']}x{$item['height']}</td>
                            <td>
                                {if:$item['status']==1}
                                开启
                                {else:}
                                关闭
                                {/if}
                            </td>
                            <td class="td-manage">
                                <a title="编辑" href="{url:tool/advert/adPositionEdit}?id={$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
                                <a title="删除" href="javascript:void(0);" ajax_status=-1 ajax_url="{url:tool/advert/delPosition?id=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
                        </tr>
                        {/foreach}
                        </tbody>

                    </table>
                    {$reBar}
                </div>
            </div>

