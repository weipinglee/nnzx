
            <!--end左侧导航-->  
            <!--start中间内容-->    
            <div class="user_c">
                <div class="user_zhxi">
                    <div class="zhxi_tit">
                        <p><a>仓单管理</a>><a>仓单详情</a></p>
                    </div>
                    <div class="center_tabl">


                        <table border="0">
                            <tr>
                                <th colspan="3">买方信息</th>
                            </tr>
                            <tr>
                                <td nowrap="nowrap">用户名:</td>
                                <td colspan="2">
                                    {$detail['username']}
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap">单位类型:</td>
                                <td colspan="2">
                                    {$detail['store_name']}
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap">企业名称:</td>
                                <td colspan="2">
                                    {$detail['company_name']}
                                </td>
                            </tr>
                                <tr>
                                    <td nowrap="nowrap">会员等级:</td>
                                    <td colspan="2">
                                        {$detail['cang_pos']}
                                    </td>
                                </tr>
                        <tr>
                            <th colspan="3">报盘信息</th>
                            </tr>
                              <tr>
                                <td nowrap="nowrap"><span></span>商品名称:</td>
                                <td>
                                    {$detail['name']}
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap"><span></span>报盘序号:</td>
                                <td>
                                    {$detail['offer_id']}
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>报盘类型:</td>
                                <td>
                                    {$detail['typeText']}
                                </td>

                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>购买数量:</td>
                                <td>
                                    {$detail['quantity']}
                                </td>

                            </tr>

                            <tr>
                            <th colspan="3">投保信息</th>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>申请保险: </td>
                                <td>
                                   {foreach: items=$detail['risk_data']}
                                    保险公司：{$item['company']} - 保险产品：{$item['name']} {if:$item['mode']==1}比例 : ({$item['fee']}){else:}定额 : ({$item['fee']}){/if}<br />
                                   {/foreach}
                                </td>
                            </tr>

                             <tr>
                                <td nowrap="nowrap"><span></span>申请状态: </td>
                                <td>
                                   {$status[$detail['status']]}
                                </td>
                            </tr>
 <tr>
                            <td nowrap="nowrap">申请描述：</td>
                            <td >
                                {$detail['note']}
                            </td>
                        </tr>
                             <tr>
                                <td nowrap="nowrap"><span></span>申请时间: </td>
                                <td>
                                    {$detail['apply_time']}
                                </td>
                            </tr>
                            {if:$detail['status']==0}
                                <form method="post" action="{url:/Insurance/insurancedetail}" auto_submit >
                                    <tr>
                                    <td>用户确认：</td>
                                    <td colspan="2">
                                        <input type="radio" name="status" checked value="1"> 通过
                                        <input type="radio" name="status" value="0"> 驳回
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td colspan="2" class="btn">
                                        <input type="hidden" value="{$detail['id']}" name="id">
                                        <input type="submit" value="提交">

                                    </td>
                                </tr>
                                </form>
                            {/if}

                         
                 </table>

                        
                    </div>
                </div>
            </div>
            <!--end中间内容-->  
            
        </div>
      <script type="text/javascript" src="{views:js/product/attr.js}" ></script>