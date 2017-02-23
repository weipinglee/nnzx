
        
        <script type="text/javascript" src="{views:content/settings/main.js}"></script>
<link rel="stylesheet" href="{views:content/settings/style.css}" />
<link rel="stylesheet" type="text/css" href="{views:css/H-ui.admin.css}">

          
            
                
                
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="{views:img/icons/posts.png}" alt="" /> 子账户角色添加</h1>
<div class="bloc">
    <div class="title">
        子账户角色
    </div>
    <div class="content">
        <div class="pd-20">
    <form action="{url:member/member/doRoleAdd}" method="post" class="form form-horizontal" id="form-user-character-add">
        <input name='role_id' type="hidden" value="{if:isset($roleData['id'])}{$roleData['id']}{/if}" />
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>角色名称：</label>
            <div class="formControls col-10">
                <input type="text" class="input-text" value="{if:isset($roleData['name'])}{$roleData['name']}{/if}" placeholder="" id="user-name" name="role_name" datatype="*4-16" nullmsg="用户账户不能为空">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>是否启用：</label>
            <div class="formControls col-10">
                <input type="radio" class="input-text"  value="1" name="status" {if:!isset($roleData['status']) || $roleData['status']==1}checked{/if} >启用
                <input type="radio" class="input-text" value="0"   name="status" {if:isset($roleData['status']) && $roleData['status']==0}checked{/if} >关闭
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2">备注：</label>
            <div class="formControls col-10">
                <input type="text" class="input-text" value="{if:isset($roleData['note'])}{$roleData['note']}{/if}" placeholder="" id="" name="role_note">
            </div>
        </div>
          <div class="row cl">
            <label class="form-label col-2">菜单角色组：</label>
            <input type="hidden" name="id" value="{$userDetail['id']}">
            <div class="formControls col-10">
                {if: !empty($usergroupList)}
                    {foreach: items=$usergroupList item=$list}
                        <input type="checkbox" name="gid[]" value="{$list['id']}" {if: !empty($userDetail['gid']) && in_array($list['id'], $userDetail['gid'])}checked='true'{/if} /> {$list['name']}
                    {/foreach}
                {/if}
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2">网站角色：</label>
            <div class="formControls col-10">
                {foreach:items=$tree item=$first}
                <dl class="permission-list">
                {set:$first_check=false}
                    {if:isset($roleData['right']) && in_array($first['id'],$roleData['right'])}
                        {set:$first_check=true}
                    {/if}
                    <dt>
                        <label>
                            <input type="checkbox" value="{$first['id']}" {if:$first_check==true}checked{/if} name="first_role_id[]" id="user-Character-0">
                            {$first['note']}</label>
                    </dt>

                    <dd>
                        {foreach:items=$first['child'] item=$second}
                            {set:$second_check= false}
                            {if:isset($roleData['right']) && in_array($second['id'],$roleData['right'])}
                                {set:$second_check=true}
                            {/if}
                        <dl class="cl permission-list2">
                            <dt>
                                <label class="">
                                    <input type="checkbox" value="{$second['id']}" {if:$first_check || $second_check}checked{/if} name="second_role_id[{$first['id']}][]" id="user-Character-0-0">
                                    {$second['note']}</label>
                            </dt>
                            <dd>
                                {foreach:items=$second['child'] }
                                    {set:$third_check=false}
                                    {if:isset($roleData['right']) && in_array($item['id'],$roleData['right'])}
                                        {set:$third_check=true}
                                    {/if}
                                <label class="">
                                    <input type="checkbox" value="{$item['id']}" {if:$first_check || $second_check || $third_check}checked{/if} name="third_role_id[{$first['id']}][{$second['id']}][]" id="user-Character-0-0-0">
                                    {$item['note']}</label>
                                {/foreach}
                            </dd>
                        </dl>

                        {/foreach}
                    </dd>

                </dl>
                {/foreach}
            </div>
        </div>
        <div class="row cl">
            <div class="col-10 col-offset-2">
                <button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok fa-ok"></i> 确定</button>
            </div>
        </div>
    </form>
</div>

