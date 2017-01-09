<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>

<div class="class_jy" id="cate_box" style="display:none;">
    <span class="jy_title"></span>
    <ul>
        <!-- <li value=""   class="a_choose" ><a></a></li>
-->
    </ul>

    <ul class="infoslider" style="display: none;">
        <li value=""   class="a_choose"  ><a></a></li>

    </ul>
    <!--<div class="sl_ext">
        <a href="javascript:;" class="sl_e_more info-show" style="visibility: visible;">展开</a>
    </div>-->

</div>

       <input type="hidden" name="attr_url" value="{url:/ManagerDeal/ajaxGetCategory}"  />
<script type="text/javascript" src="{views:js/product/attr.js}" ></script>
            <!--start中间内容-->    
            <div class="user_c">
                <div class="user_zhxi pro_classify">
                    <div class="zhxi_tit">
                        <p><a>产品管理</a>><a>保证金报盘</a></p>
                    </div>
                    <div class="center_tabl">
                    <div class="lx_gg">
                        <b>商品类型</b>
                    </div>

                    {if: !empty($categorys)}

                        {foreach: items=$categorys item=$category key=$level}
                            <div class="class_jy" id="level{$level}">
                                <span class="jy_title">
                                    {if: isset($childName)}
                                        {$childName}：
                                    {else:}
                                        市场类型：
                                    {/if}
                                </span>
                                <ul>
                                    {foreach: items=$category['show'] item=$cate}
                                    <li value="{$cate['id']}"  {if: $key==0} class="a_choose" {/if} ><a>{$cate['name']}</a></li>
                                    {if: $key == 0}
                                    {set: $childName = $cate['childname']}
                                    {/if}
                                    {/foreach}
                                </ul>


                            </div>
                        {/foreach}
                        {/if}


                    <form action="{url:/ManagerDeal/doDepositOffer}" method="POST" auto_submit redirect_url="{url:/managerdeal/indexoffer}">
                        {include:/layout/product.tpl}
                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">
                            <input type="hidden" name='cate_id' id="cate_id" value="{$cate_id}">
                                <input type="hidden" name="token" value="{$token}" />
                                <input  type="submit"  value="提交审核" />
                                <span class="color">买方付首款后需缴纳报盘总金额的{$rate}%的保证金，合同完成后退还</span>
                            </td>
                        </tr>
                         
                 </table>
                </form>
        <script type="text/javascript">
            $(function(){
                getCategory({$cate_id});
            })
        </script>
                    </div>
                </div>
            </div>




