{if: $stop == 1}
<div class="user_c_list">    
<img src="{views:images/weituo.png}" style="width:100%;">
</div>

{else:}

<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<div class="class_jy" id="cate_box" style="display:none;">
    <span class="jy_title"></span>
    <ul>
        <!-- <li value=""   class="a_choose" ><a></a></li>
-->
    </ul>

    <ul class="infoslider" style="display: none;">
        <li value=""   class="a_choose"  ><a></a></li>

    </ul>
    <div class="sl_ext">
     <!--   <a href="javascript:;" class="sl_e_more info-show" style="visibility: visible;">展开</a>-->
    </div>

</div>

       <input type="hidden" name="attr_url" value="{url:/ManagerDeal/ajaxGetCategory}"  />
<script type="text/javascript" src="{views:js/product/attr.js}" ></script>
            <div class="user_c">
                <div class="user_zhxi pro_classify">
                    <div class="zhxi_tit">
                        <p><a>产品管理</a>><a>委托报盘</a></p>
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
                        <input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
                    <form action="{url:/ManagerDeal/doDeputeOffer}" method="POST" auto_submit redirect_url="{url:/managerdeal/indexoffer}">
                        {include:/layout/product.tpl}
                            <tr>
                                <td></td>
                                <td>
                                    <span>

                                        <div>请您下载<a href="{root:down/耐耐网委托报盘协议书.docx}" style="color:#1852ca;font-size:14px;">《耐耐网委托报盘协议书》</a>，并签字扫描上传

                                         </div>
                                       <div class="zhxi_con">

                                           <div>
                                               <input type="file" name="file1" id="file1"  onchange="javascript:uploadImg(this);" />

                                           </div>
                                           <div  >
                                               <img name="file1" src=""/>
                                               <input type="hidden"  name="imgfile1" value=""  alt="请上传图片" />
                                           </div>


                                       </div>
                                    </span>
                                </td>
                            </tr>   
                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">
                            <input type="hidden" name='cate_id' id="cate_id" value="{$cate_id}">
                            <input type="hidden" name='mode' id="mode" value="weitou">
                                <input type="hidden" name="token" value="{$token}" />
                                <input  type="submit"  value="提交审核" />
                                {if:$is_vip}
                                    <span class="color">您是收费会员,无需支付委托费</span>
                                {else:}
                                    <span class="color">需支付总金额<span id='weitou'>{if:!empty($rate)}{$rate['value']}{if:$rate['type'] == 0}%{else:}元{/if}{else:}0{/if}</span>的委托金</span>
                                {/if}
                            </td>
                        </tr>

                 </table>
                </form>

                    </div>
                </div>
            </div>

{/if}


