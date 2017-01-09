
			<!--start中间内容-->	
			<div class="user_c_list">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>仓单管理</a>><a>仓单列表</a></p>
					</div>
					<div class="chp_xx">
						{include:layout/search.tpl}
						<div class="xx_center">

							<table border="0"  cellpadding="" cellspacing="">
								<tr class="title">
									<td>序号</td>
									<td>商品名称</td>
									<td>市场分类</td>
									<td>规格</td>
									<td>重量</td>
                                                                                <td>仓单状态</td>
                                                                                <td>所在库</td>
                                                                                <td>操作</td>
								</tr>
								{if:!empty($data['list'])}
                                                                                        {foreach:  items=$data['list'] item=$list}
                                                                                        {set:$key++}
                                                                                        <tr>
                                                                                                <td>{$key}</td>
                                                                                                <td>{$list['pname']}</td>
                                                                                                <td>{$list['cname']}</td>
                                                                                                <td>
                                                                                                		<ul>
																											{if:!empty($list['attribute'])}
                                                                                                		{foreach: items=$list['attribute'] key=$aid item=$attr}
                                                                                                		<li>{$data['attrs'][$aid]} : {$attr}</li>
                                                                                                		{/foreach}
																											{/if}
                                                                                                		</ul>
                                                                                                </td>
                                                                                                <td>{echo:\nainai\offer\product::floatForm($list['quantity'])}({$list['unit']})</td>
                                                                                                <td>{$statuList[$list['status']]}</td>
                                                                                                <td>{$list['sname']}</td>
                                                                                                <td>
                                                                                                <a href='{url:/Managerdeal/table?id=$list["id"]}' target="_blank">打印预览</a>
                                                                                                <a href='{url:/Managerdeal/storeProductDetail?id=$list['id']}'>查看</a>
                                                                                                </td>

                                                                                        </tr>
                                                                                      {/foreach}
                                                                             {/if}
							</table>

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
	{$data['bar']}
						</div>
					</div>
				</div>
				
				
			</div>
			