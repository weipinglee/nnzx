
			<!-- start 依据条件显示HTML-->
			<div class="user_c_list">
				<!-- start 是否选择去认证
				<div class="check-approve">
					<img src="../images/icon/check-approve.jpg">
					<p class="p-title zn-f18">您的基本资料未填写完成</p>
					<p class="p-con  zn-f14">请完善您的基本资料并申请正式会员，享受更多会员服务</p>
					<p class="p-btn">
						<a href="identity/zh_rez.html" class="zn-f16 go-now">资质认证</a>
						<a class="zn-f16 not-go">暂不认证</a>
					</p>
				</div>  end 是否选择去认证 -->	
			<!-- start 暂不认证 -->	
				<div class="user_zbrz noshow">
					<div class="user_nrz">
						<div class="nrz_tit"><span>账户信息</span><a class="gengduo" href="user_dd.html"></a></div>
						<div class="nrz_dd">
							<table class="hy_info" width="100%">
								<tr>
									<td width="450px" style="border-right:1px solid #eee;">
										<ul class="dj">
											<li>会员等级：<span><img src="{$group['icon']}"/>{$group['group_name']}</span></li>
											<li><a href="http://company.nainaiwang.com/product.php?id=67"><span class="colaa0707" style="padding-left:30px;text-decoration:underline;">会员升级</span></a></li>

											<li style="clear:both;"><span>信誉分值：{$creditGap} 分</span></li>
										</ul>
									</td>
									<td style="padding-bottom:0px;">
										<span>结算账号资金总额</span>
										<span class="colaa0707"><b class="font-size ">￥{$count}</b><br/>
											<span style="line-height: 30px;padding-left: 120px;"></span>
										</span>
									</td>
								</tr>
								<tr>
									<td width="280px" style="border-right:1px solid #eee;">
										<div class="icon_rz">
											{foreach:items=$cert}
												{if:$cert[$key]==1}
												<span><img src="{views:/images/center/icon_yrz.png}">{echo:\nainai\cert\certificate::$certRoleText[$key]}已认证</span>
												{else:}
												<span><img src="{views:/images/center/icon_wrz.png}">{echo:\nainai\cert\certificate::$certRoleText[$key]}未认证</span>

												{/if}
											{/foreach}
											{if:$href}
												<a href="{$href}"><span class="colaa0707" style="padding-left:30px;text-decoration:underline;">去认证</span></a>
											{/if}
										</div>
									</td>
									<td>
										<span class="rz_an_index">
											<a href="{url:/fund/cz}" class="zj_a cz">充值</a>
											<a href="{url:/fund/tx}" class="zj_a tx">提现</a>
										</span>
									</td>
								</tr>
								
							</table>
							
						</div>
					</div>
					<div class="user_nrz">
						<div class="nrz_tit"><span>最新购买合同</span><a class="gengduo" href="{url:/contract/buyerList}">更多>></a></div>
						<div class="nrz_gz">
							{if:!empty($contract2)}
							<table width="100%">
								<tr>
									<td width="220px" style="min-height:80px;">
										<div style="padding:5px 10px;">
											<div class="div_height">&nbsp;{$contract2['product_name']}</div>
										</div>

									</td>
									<td width="380px" >
										<a href="{url:/contract/buyerdetail?id=$contract2['id']}">{$contract2['order_no']}</a>
									</td>
									<td width="200px">
										<div class="div_heights colaa0707">合同总额：￥{$contract2['amount']}</div>

									</td>


									<td>
										<div class="div_heights">
										{if:$contract2['action_href']}
											<a href="{$contract2['action_href']}"><b>{$contract2['title']}<b></b></b></a>
										{else:}
											{$contract2['title']}
										{/if}
										</div><b><b>
											</b></b></td>
								</tr>
							</table>
							{else:}
								<table width="100%">
									<tr>
										<td colspan="4">
											<img src="{views:/images/center/no-data.png}">
											<p class="no-data">暂无购买合同</p>
										</td>
									</tr>
								</table>
							{/if}

						</div>
					</div>
					{if: $user_type == 1}
					<!-- 最新销售合同 -->
					<div class="user_nrz">
						<div class="nrz_tit"><span>最新销售合同</span><a class="gengduo" href="{url:/contract/sellerList}">更多>></a></div>
						<div class="nrz_gz">
							{if:!empty($contract1)}
							<table width="100%">
								<tr>
									<td width="220px" style="min-height:80px;">
										<div style="padding:5px 10px;">
											<div class="div_height">&nbsp;{$contract1['product_name']}</div>
										</div>
										
									</td>
									<td width="380px" >
										<a href="{url:/contract/sellerdetail?id=$contract1['id']}">{$contract1['order_no']}</a>
									</td>
									<td width="200px">
										<div class="div_heights colaa0707">合同总额：￥{$contract1['amount']}</div>

									</td>

									
									<td>
										<div class="div_heights">
											{if:$contract1['action_href']}
											<a href='{$contract1['action_href']}'><b>{$contract1['action']}<b></b></b></a>
											{else:}
											<b>{$contract1['action']}<b></b></b>
											{/if}
										</div><b><b>
									</b></b></td>
								</tr>

							</table>
							{else:}
							<table width="100%">
								<tr>
									<td colspan="4">
										<img src="{views:/images/center/no-data.png}">
										<p class="no-data">暂无销售合同</p>
									</td>
								</tr>
								</table>
							{/if}
							
						</div>
					</div>
					{/if}
					<!-- 最新销售合同end -->
					<!-- 关注推荐 start
					<div class="user_nrz chp_xx">
						<div class="nrz_tit"><span>关注推荐</span><a class="gengduo" href="user_gz.html">更多>></a></div>
						<div class="xx_center">
							<table width="100%">
								<tr>
									<td>编号</td>
									<td>供求</td>
									<td>品名</td>
									<td>服务</td>
									<td>规格</td>
									<td>数量（吨）</td>
									<td>剩余（吨）</td>
									<td>价格（元）</td>
									<td>产地</td>
									<td>交货地</td>
									<td>操作</td>
								</tr>
								<tr>
									<td>GF0000001</td>
									<td><span class="col12aa07">供</span></td>
									<td>高铝砖</td>
									<td><img src="../images/center/icon_b.jpg">
										<img src="../images/center/icon_c.jpg">
									</td>
									<td>95%</td>
									<td>200</td>
									<td>300</td>
									<td>￥1780</td>
									<td>山西</td>
									<td>耐耐网一号库</td>
									<td>
										<a><img src="../images/center/icon_serch.jpg"/></a>
										<a><img src="../images/center/icon_yy.jpg"/></a>
										<a><img src="../images/center/icon_qq.jpg"/></a>
									</td>
								</tr>
								<tr>
									<td>GF0000001</td>
									<td><span class="col12aa07">供</span></td>
									<td>高铝砖</td>
									<td><img src="../images/center/icon_b.jpg">
										<img src="../images/center/icon_c.jpg">
									</td>
									<td>95%</td>
									<td>200</td>
									<td>300</td>
									<td>￥1780</td>
									<td>山西</td>
									<td>耐耐网一号库</td>
									<td>
										<a><img src="../images/center/icon_serch.jpg"/></a>
										<a><img src="../images/center/icon_yy.jpg"/></a>
										<a><img src="../images/center/icon_qq.jpg"/></a>
									</td>
								</tr>
							</table>
							
						</div>
					</div>
					关注推荐 end -->
				</div>
			<!-- end 暂不认证 -->	
			</div>
