<link rel="stylesheet" href="{views:css/cate.css}" />
<script type="text/javascript" src="{views:js/product/cate.js}"></script>
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 保险管理</h1>
<div class="bloc">
    <div class="title">
        费率列表
    </div>
    <div class="content">
        <div class="pd-20">

     <div class="cl pd-5 bg-1 bk-gray">
         <span class="l">

             <a class="btn btn-primary radius" href="{url:trade/Insurance/rateAdd}">
                 <i class=" icon-plus fa-plus"></i> 设置分类费率
             </a>
         </span>

     </div>
    <div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
            <tr class="text-c">
                <th width="100">分类名称</th>
                <th width="150">保险公司/保险名称/保险方式（比例/定额）</th>
                <th width="100">操作</th>
            </tr>
        </thead>
        <tbody>
        {foreach:items=$cate}
            {set:$class=''}
            {if:$item['level']!=0}{set:$class='hide'}{/if}

            <tr class="text-c {$class}"  title="{$item['level']}">

                <td><u style="cursor:pointer" class="text-primary" ><p class="cateclose he" style="width:80px;margin-left:{echo:$item['level']*15}px" ></p>{$item['name']}</u></td>

                <td>{if: !empty($item['risk_data'])}
                    {foreach: items=$item['risk_data'] item=$value}
                    {$value['company']} / {$value['name']}/ {if: $value['mode'] == 1}比例（{$value['fee']}‰）<br />{else:}定额（{$value['fee']}）<br />{/if}
                    {/foreach}
                {/if}</td>
                <td class="td-manage">
                   <a title="编辑" href="{url:trade/Insurance/rateAdd?cid=$item['id']}" class="ml-5" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a>
            </tr>

        {/foreach}
        </tbody>

    </table>
        {$bar}
    </div>
</div>

