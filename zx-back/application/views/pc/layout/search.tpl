
{if:$data['search']!=''}
    {if: empty($begin)}
    {set:$begin=\Library\safe::filterGet('begin');}
    {/if}
    {if: empty($end)}
    {set:$end=\Library\safe::filterGet('end');}
    {/if}

    {set:$like=\Library\safe::filterGet('like');}
    {set:$min=\Library\safe::filterGet('min');}
    {set:$max=\Library\safe::filterGet('max');}
    {set:$select=\Library\safe::filterGet('select');}

    {if:$select==='all' || !isset($_GET['select']) }
        {set:$select = -9999}
    {/if}

    <form action="" method="get" >
        <div class="text-c">
            {if:isset($data['search']['time'])}
                {$data['search']['time']}：

                <input type="text" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm:ss' })" id="datemin" class="input-text Wdate" name="begin" value="{$begin}" style="width:120px;">
                -
                <input type="text" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm:ss' })"id="datemax" class="input-text Wdate" name="end" value="{$end}" style="width:120px;">
            {/if}

            {if:isset($data['search']['like'])}
                <input type="text" class="input-text" style="width:250px" placeholder="输入{$data['search']['like']}" id="" name="like" value="{$like}">
            {/if}
            {if: !empty($data['search']['likes'])}
                {foreach: items=$data['search']['likes']}
                    {$item}：<input type="text" class="input-text" style="width:250px" placeholder="输入{$item}"  name="{$key}" value="{$data['search']['likesval'][$key]}">
                {/foreach}
            {/if}
            {if:isset($data['search']['between'])}
                {$data['search']['between']}:
                <input type="text" class="input-text" style="width:100px"  id="" name="min" value="{$min}">-
                <input type="text" class="input-text" style="width:100px"  id="" name="max" value="{$max}">
            {/if}
            {if:isset($data['search']['select'])}
                {$data['search']['select']}：
                <select name="select" >
                    <option value="all">所有</option>
                    {foreach:items=$data['search']['selectData']}
                        <option value="{$key}" {if:$select==$key}selected=true{/if}>{$item}</option>
                    {/foreach}
                </select>
            {/if}
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="icon-search fa-search"></i> 搜索</button>
            
            {if: isset($data['search']['down']) && $data['search']['down']==1}
            <button type="submit" class="btn btn-success radius" id="" name="down" value="1"><i class="icon-search fa-search"></i> 导出</button>
            {/if}

        </div>
    </form>
{/if}
