
			<!--end左侧导航-->	
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>保险管理</a>><a>申请详情</a></p>
					</div>
					<div class="center_tabl">

                    <form action="{url:/Purchase/doApplyReport}" method="POST" auto_submit redirect_url="{url:/Purchase/reportlists}">
						 <table class="table2" cellpadding="0" cellspacing="0">
      <tr>
                                <td class="spmx_title" colspan="2">基本商品信息</td>
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
                                <td class="spmx_title" colspan="2">申请保险信息</td>
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
                            <td>申请描述：</td>
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
                            <tr>
                                <td nowrap="nowrap"><span></span>审核时间: </td>
                                <td>
                                    {$detail['check_time']}
                                </td>
                            </tr>
                      

                        <tr>
                            <td colspan="2" class="btn">
                              <input class="cg_fb" type="button" value="返回" onclick="history.go(-1)"/>
                                <!-- <span class="color">审核将收取N元/条的人工费用，请仔细填写</span> -->
                                
                            </td>
                        </tr>
                         
                 </table>
            	</form>
						
					</div>
				</div>
			</div>
			<!--end中间内容-->	
			
		</div>
      <script type="text/javascript" src="{views:js/product/attr.js}" ></script>