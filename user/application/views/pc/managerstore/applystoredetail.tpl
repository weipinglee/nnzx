<div class="user_c">
    <div class="user_zhxi">
        <div class="zhxi_tit">
            <p><a>仓单管理</a>><a>仓单详情</a></p>
        </div>
        <div class="center_tabl">
            <form action="" method="">
                <table class="table2" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="spmx_title" colspan="8">入库详细信息</td>
                    </tr>

                    <tr>
                        <td colspan="2">仓库名称</td>
                        <td colspan="6">{$storeDetail['sname']}</td>
                    </tr>


                    <tr>
                        <td colspan="2">状态</td>
                        <td colspan="6">
                            {$storeDetail['status_txt']}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">库位</td>
                        <td colspan="6">
                            {$storeDetail['store_pos']}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"> 仓位</td>
                        <td colspan="6"> {$storeDetail['cang_pos']}</td>
                    </tr>
                    <tr>
                        <td colspan="2"> 租库价格</td>
                        <td colspan="6"> {$storeDetail['store_price']}（元/{$storeDetail['unit']}/{echo:\nainai\store::getTimeUnit($storeDetail['store_unit'])}） </td>
                    </tr>
                    <tr>
                        <td colspan="2">签发时间</td>
                        <td colspan="6">{$storeDetail['sign_time']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">用户确认时间</td>
                        <td colspan="6">{$storeDetail['user_time']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">后台审核时间</td>
                        <td colspan="6">{$storeDetail['market_time']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">入库日期</td>
                        <td colspan="6">{$storeDetail['in_time']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">租库日期</td>
                        <td colspan="6">{$storeDetail['rent_time']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">检测机构</td>
                        <td colspan="6">{$storeDetail['check_org']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">质检证书编号</td>
                        <td colspan="6">{$storeDetail['check_no']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">是否包装</td>
                        <td colspan="6"> {if: $storeDetail['package'] == 1} 是 {else:} 否{/if}</td>
                    </tr>

                    {if: $storeDetail['package'] == 1}
                        <tr  >
                            <td colspan="2"> 包装单位：</td>
                            <td colspan="6">
                                {$storeDetail['package_unit']}
                            </td>
                        </tr>
                        <tr >
                            <td colspan="2">包装数量：</td>
                            <td colspan="6">
                                {$storeDetail['package_num']}
                            </td>
                        </tr>
                        <tr  >
                            <td colspan="2">包装重量：</td>
                            <td colspan="6">
                                {$storeDetail['package_weight']}({$storeDetail['package_units']})
                            </td>
                        </tr>
                    {/if}
                    <tr>
                        <td class="spmx_title" colspan="8">商品信息</td>
                    </tr>
                    <tr>
                        <td colspan="2">商品名称</td>
                        <td colspan="6">
                            {$storeDetail['pname']}
                        </td>
                    </tr>


                    <tr>
                        <td colspan="2">属性</td>
                        <td colspan="6"> {$storeDetail['attrs']}</td>
                    </tr>

                    <tr>
                        <td colspan="2">分类</td>
                        <td colspan="6">
                            {foreach:items=$storeDetail['cate'] item=$cate key=$k}
                                {if:$k==0}
                                    {$cate['name']}
                                {else:}
                                    > {$cate['name']}
                                {/if}

                            {/foreach}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">重量</td>
                        <td colspan="6">{$storeDetail['quantity']}({$storeDetail['unit']})</td>
                    </tr>
                    <tr>
                        <td colspan="2">产地</td>
                        <td colspan="6">{areatext:data=$storeDetail['produce_area']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">商品描述</td>
                        <td colspan="6">{$storeDetail['note']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">用户审核意见</td>
                        <td colspan="6">{$storeDetail['msg']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">管理员审核意见</td>
                        <td colspan="6">{$storeDetail['admin_msg']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">图片预览</td>
                        <td colspan="6">
                            <span class="zhs_img">
                           
                                    {foreach: items=$photos item=$url}
                                        <img src="{$url}"/>
                                    {/foreach}
    				        </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">签字入库单</td>
                        <td colspan="6"> <img src="{$storeDetail['confirm_thumb']}" /></td>
                    </tr>
<tr>
                        <td colspan="2">质检证书</td>
                        <td colspan="6"> <img src="{$storeDetail['quality_thumb']}" /></td>
                    </tr>
                    <tr>
                        <td class="spmx_title" colspan="8">用户信息</td>
                    </tr>
                    <tr>
                        <td colspan="2">用户名</td>
                        <td colspan="6">
                            {$user['username']}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">手机号</td>
                        <td colspan="6"> {$user['mobile']}</td>
                    </tr>
                    <tr>
                        <td colspan="2">地区</td>
                        <td colspan="6"> {areatext:data=$user['area'] id=userarea}</td>
                    </tr>
                    <tr>
                        <td colspan="2">地址</td>
                        <td colspan="6">{$user['address']} </td>
                    </tr>
                    <tr>
                        <td colspan="2">公司名称</td>
                        <td colspan="6">{$user['company_name']} </td>
                    </tr>
                    <tr>
                        <td colspan="2">联系人</td>
                        <td colspan="6">{$user['contact']} </td>
                    </tr>
                    <tr>
                        <td colspan="2">联系电话</td>
                        <td colspan="6">{$user['contact_phone']}</td>
                    </tr>

                    <tr id="operate">
                        <td colspan="8">
                           
                            <input class="cg_fb" type="button" value="返回" onclick="history.go(-1)"/>
                              <a class="btoncomit submit_chag" href="{url:/managerstore/updateStore}?{set: echo http_build_query(array('id'=>$storeDetail['sid']))}" style="margin:5px 10px;">修改仓单</a>
                        </td>

                    </tr>
                </table>
            </form>

        </div>
    </div>
</div>



