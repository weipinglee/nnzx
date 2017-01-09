   <script type="text/javascript" src="{views:js/libs/jquery/1.11/jquery.min.js}"></script>
    <script type="text/javascript" src="{views:js/layer/layer.js}"></script>
<script type="text/javascript" src="{views:js/validform/formacc.js}"></script>
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 菜单管理</h1>
<div class="bloc">
    <div class="title">
        菜单列表
    </div>
        <div class="content">
        <div class="pd-20">
  
       <div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
    <thead>
      <tr class="text-c">
        <th width="25"><input type="checkbox" name="checkall" value=""></th>
        <th width="80">菜单名</th>
        <th width="80">菜单url</th>
        <th width="80">菜单位置</th>
        <th width="80">是否显示</th>
        <th width="80">子账户是否显示</th>
        <th width="100">操作</th>
      </tr>
    </thead>
    <tbody>

        {foreach: items=$lists item=$list}
<tr class="text-c">
        <td><input type="checkbox" value="" name="check"></td>
        <td>
        {set: echo str_repeat('&nbsp;&nbsp;', $list['level'] * 5)} 
        {if: !empty($icon[$list['level']])}{$icon[$list['level']]} {/if}
        {$list['menu_zn']}
        </td>
         <td>
         {$list['menu_url']}
        </td>
        <td>
        {if:$list['position'] == 1}
          首页
        {else:}
          用户中心
        {/if}
        </td>
        <td>
        {if:$list['status'] == 1}
          是
        {else:}
          否
        {/if}
        </td>
         <td>
        {if:$list['subacc_show'] == 1}
          是
        {else:}
          否
        {/if}
        </td>
        <td class="td-manage">
          <a title="编辑" href="{url: member/Menu/updateMenu?id=$list['id']}" class="ml-5" style="text-decoration:none">
            <i class="icon-edit fa-edit"></i>
          </a>
          <a title="删除" href="javascript:;" ajax_status=-1 ajax_url="{url:member/Menu/deleteMenu?id=$list['id']}"class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a>
          </a>

        </td>
      </tr>
      {/foreach}
      </tbody>
  </table>

  </div>
</div>


</div>
