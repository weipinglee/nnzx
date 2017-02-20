
<!--
      CONTENT
                -->
<div id="content" class="white">
    <h1><img src="{views:img/icons/posts.png}" alt="" /> 广告列表</h1>

    <div class="bloc">
        <div class="title">
            广告列表
        </div>
        <div class="content">
            <div class="pd-20">
                <div class="cl pd-5 bg-1 bk-gray"> <span class="l"><a class="btn btn-primary radius" href="{url:tool/advert/adManageAdd}"><i class=" icon-plus fa-plus"></i> 添加广告</a> </span>  </div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="checkall" value=""></th>
                            <th width="100">广告名称</th>
                            <th width="90">广告位名称</th>
                            <th width="60">排序</th>
                            <th width="150">开始时间</th>
                            <th width="100">结束时间</th>
                            <th width='100'>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach:items=$adManageList}
                        <tr class="text-c">
                            <td><input type="checkbox" value="" name="check"></td>
                            <td><u style="cursor:pointer" class="text-primary" >{$item['name']}</u></td>
                            <td>{$item['pname']}</td>
                            <td>{$item['order']}</td>
                            <td>{$item['start_time']}</td>
                            <td>{$item['end_time']}</td>
                            <td class="td-manage">
                                <a title="编辑" href="{url:tool/advert/adManageEdit}?id={$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
                                <a title="删除" href="javascript:void(0);" ajax_status=-1 ajax_url="{url:tool/advert/delManage?id=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
                        </tr>
                        {/foreach}
                        </tbody>

                    </table>
                    {$reBar}
                </div>
            </div>

