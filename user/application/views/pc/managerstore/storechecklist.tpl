
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>仓单管理</a>><a>仓单出库审核</a></p>
					</div>
					<div class="chp_xx">
						
						<div class="xx_center">

							<table border="0"  cellpadding="" cellspacing="">
								<tr class="title">
									<td>订单号</td>
									<td>商品名称</td>
									<td>商品总量</td>
									<td>出库数量</td>
                                    <td>仓库名称</td>
                                    <td>操作</td>
								</tr>
                                    {foreach:  items=$data item=$list}
                                    <tr>
                                            <td>{$list['order_no']}</td>
                                            <td>{$list['product_name']}</td>
                                            <td>{$list['order_num']}({$list['unit']})</td>
                                            <td>{$list['delivery_num']}({$list['unit']})</td>
                                            
                                            <td>{$list['store_name']}</td>
                                            
											<td><a href='{url:/ManagerStore/storecheckdetail?id=$list["id"]}'>查看</a></td>
                                            
                                    </tr>
                                  {/foreach}
							</table>
							<div class="page_num">
							{$page}
							</div>
						</div>
						
						<!-- <div class="tab_bt">
							<div class="t_bt">
								<a class="a_1" title="编辑" href="user_cd.html"></a>
								<a class="a_2" title="添加" href="user_cd.html"></a>
								<a class="a_3" title="删除" href="user_cd.html"></a>
							</div>
						</div> -->
						<div class="page_num">
<!-- 							共0条记录&nbsp;当前第<font color="#FF0000">1</font>/0页&nbsp;
<a href="#">第一页</a>&nbsp;
<a href="#">上一页</a>&nbsp;
<a href="#">下一页</a>&nbsp;
<a href="#">最后页</a>&nbsp; 
跳转到第 <input name="pagefind" id="pagefind" type="text" style="width:20px;font-size: 12px;" maxlength="5" value="1"> 页 
<a><span class="style1">确定</span></a> -->
	{$pageHtml}
						</div>
					</div>
				</div>
				
				
			</div>
			