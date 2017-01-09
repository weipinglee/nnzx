<div class="user_c">
    <div class="user_zhxi">
        <div class="zhxi_tit">
            <p><a>仓单管理</a>><a>仓单详情</a></p>
        </div>
        <div class="center_tabl">

                <table class="table2" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="spmx_title" colspan="8">入库详细信息</td>
                    </tr>

                    <tr>
                        <td colspan="2">仓库名称</td>
                        <td colspan="6">{$storeDetail['store_name']}</td>
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
                    {if:$storeDetail['user_time']}
                        <tr>
                            <td colspan="2">用户确认时间:</td>
                            <td colspan="6">
                                {$storeDetail['user_time']}
                            </td>
                        </tr>
                    {/if}
                    {if:$storeDetail['market_time']}
                        <tr>
                            <td colspan="2">市场审核时间:</td>
                            <td colspan="6">
                                {$storeDetail['market_time']}
                            </td>
                        </tr>
                    {/if}
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
                            {$storeDetail['product_name']}
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
                        <td colspan="2">图片预览</td>
                        <td colspan="6">
                            <span class="zhs_img">
                                    {foreach: items=$storeDetail['photos'] item=$url}
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
                        <td colspan="2">质检证书：</td>
                        <td colspan="6"> <img src="{$storeDetail['quality_thumb']}" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">产品描述：</td>
                        <td colspan="6">
                            {$storeDetail['note']}
                        </td>
                    </tr>
                    {if:$storeDetail['status']==\nainai\store::STOREMANAGER_SIGN}
                    <form method="post" action="{url:/Managerdeal/userMakeSure}" auto_submit="1" >
                        <tr>
                            <td colspan="2">用户确认：</td>
                            <td colspan="6">
                                <input type="radio" name="status" checked value="1"> 通过
                                <input type="radio" name="status" value="0"> 驳回
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">审核意见：</td>
                            <td colspan="6">
                                <textarea name="msg"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" class="btn">
                                <input class="cg_fb" type="button" value="返回" onclick="history.go(-1)"/>
                                <input type="hidden" value="{$storeDetail['id']}" name="id">
                                <input type="submit" value="提交">
                            </td>
                        </tr>
                    </form>
                        {else:}
                        <tr>
                            <td colspan="2">用户审核意见：</td>
                            <td colspan="6">
                            {$storeDetail['msg']}
                            </td>
                        </tr>
                         <tr>
                            <td colspan="2">管理员审核意见：</td>
                            <td colspan="6">
                            {$storeDetail['admin_msg']}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" class="btn">
                                <input class="cg_fb" type="button" value="返回" onclick="history.go(-1)"/>
                            </td>
                        </tr>
                    {/if}
                </table>


        </div>
    </div>
</div>




