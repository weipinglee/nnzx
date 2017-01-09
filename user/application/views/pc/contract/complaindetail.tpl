
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>申述管理</a>><a>申述详情</a></p>
					</div>
					<div class="center_tabl">
                    <form action="" method="">
					   <table class="table2" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="spmx_title" colspan="8">申述明细</td>
                            </tr>
                            <tr>
                                <td colspan="2">订单号</td>
                                <td colspan="6">{$complainDetail['order_no']}</td>
                            </tr>
                            <tr>
                                <td colspan="2">申述标题</td>
                                <td colspan="6">{$complainDetail['title']}</td>
                            </tr>
                            <tr>
                                <td colspan="2">申述类型</td>
                                 <td colspan="6">{$complainDetail['type']}</td>
                            </tr>
                             <tr>
                                <td colspan="2">申述状态</td>
                                 <td colspan="6">{$complainDetail['statuscn']}</td>
                            </tr>
                            <tr>
                                <td colspan="2">申述内容</td>
                                <td colspan="6">{$complainDetail['detail']}</td>
                            </tr>
                            <tr>
                                <td colspan="2">申述时间</td>
                                <td colspan="6">{$complainDetail['apply_time']}</td>
                            </tr>
                         <tr>
                                <td colspan="2">申述凭证</td>
                                <td colspan="6">
                                    {foreach: items=$complainDetail['proof'] item=$img}
                                        <img src="{$img}">
                                    {/foreach}
                                </td>
                            </tr>

                           <tr>
                                <td colspan="2">审核意见</td>
                                <td colspan="6">{$complainDetail['check_msg']}</td>
                            </tr>
                            <tr>
                                <td colspan="2">审核时间</td>
                                <td colspan="6">{$complainDetail['check_time']}</td>
                            </tr>
                            <tr>
                                <td colspan="2">处理意见</td>
                                <td colspan="6">{$complainDetail['handle_msg']}</td>
                            </tr>
                            <tr>
                                <td colspan="2">处理时间</td>
                                <td colspan="6">{$complainDetail['handle_time']}</td>
                            </tr>
                             <tr>
                                <td colspan="8">
                                   <input class="cg_fb" type="button" value="返回" onclick="history.go(-1)"/>
                                </td>
                            </tr>
                        </table>
            	    </form>
						
					</div>
				</div>
			</div>
			<!--end中间内容-->	
			