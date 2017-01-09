		<form method="post" action="{url:/Delivery/geneDelivery}" auto_submit=1 redirect_url="{url:delivery/delibuylist}">
			<!--start中间内容-->	
			<div class="user_c_list">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>交易管理</a>><a>申请提货</a></p>
					</div>
					<div class="chp_xx">
						
						<div class="xx_center">
							<table border="0" cellpadding="" cellspacing="">
								<tbody>
								<tr class="title">
									<td align="left" colspan="7">&nbsp;商品清单</td>
								</tr>
								<tr class="title_head">
									<th>图片</th>
									<th>商品名称</th>
									<th>商品数量</th>
									<th>可提数量</th>
									<th>提货数量</th>
									{if:$data['store_name']}
										<th>仓库</th>
									{/if}
								</tr>
								<tr>
									<td><img src="{$data['img']}"/></td>
									<td>{$data['name']}</td>
									<td>{$data['num']}{$data['unit']}</td>
									<td>{$data['left']}{$data['unit']}</td>
									<!-- 判断系统参数是否支持多次开单 如果单次开单则不能修改开单数量-->
									<td>
										<input type="text" class="thjs_input" name='num' datatype="float" nullmsg=' '>

									</td>
									{if:$data['store_name']}<td>{$data['store_name']}</td>{/if}

								</tr>
							</tbody></table>
						</div>
						<ul class="methed">
							<li class="clearfix">
								<label>预计提货日期：</label>
								<div>
					                <input name="expect_time" id="date_start" type="text" datatype="date" onclick="WdatePicker({dateFmt:'yyyy-MM-dd', minDate:'%y-%M-%d'});" class="Wdate gyctht_input" >
									记重方式：{$data['weight_type']}
						            <input type="hidden" id="weight_type" value="A">
						         </div>

				            </li>
							<li class="clearfix">
								<!-- <label>提货人：</label> -->
								<div>
									<p>
										<b></b>
										<label for="">提货人：</label><span id="man"><input type="text" datatype="s2-20" name="delivery_man"></span>
										<span></span>
									</p>
									<p>
										<b>  </b>
										<label for="">联系电话：</label><span id="tel"><input type="text" datatype="mobile" name="phone"></span><span></span>
									</p>
									<p>
										<b>  </b>
										<label for="">身份证号码：</label><span id="code"><input type="text" datatype="identify" name="idcard"/></span><span></span>
									</p>
									<p>
										<b>  </b>
										<label for="">车牌号：</label><span><input type="text" name="plate_number" datatype="*" placeholder="多个以逗号分隔"/></span><span></span>

									</p>
								</div>
							</li>
				            <li class="clearfix">
				                <label>备注：</label>
				                <div>
								    <textarea name="remark" cols="" rows="" id="REMARK" class="bz" maxlength="200"></textarea>最多输入200个字符
								</div>
				            </li>

						</ul>
						<div class="zhxi_con">	
							<input type="hidden" name="order_id" value="{$data['id']}" />
							<span><input class="submit_zz" type="submit" confirm=1 value="提交"></span>
							<span><input class="submit_zz reset_zz" type="reset" onclick="javascript:history.back();" value="返回"></span>
						</div>
						<!-- <div class="sjxx">
							<p>支付配送</p>
							<div class="sj_detal">
								<b class="sj_de_tit">收货人：</b>
								<span>&nbsp;laijjj</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">地址：</b>
								<span>&nbsp;山西省晋中市xxx县</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">邮编：</b>
								<span>&nbsp;045000</span>
							</div>
						</div> -->
					</div>
				</div>
			</div>
			<!--end中间内容-->	
			</form>
			<script type="text/javascript">
				$(function(){

				});

			</script>


		<!-- 弹出层 -->
	<!-- 	<div id="bgblock" style="width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 999; background-color: rgb(0, 0, 0); opacity: 0.6; display:none; background-position: initial initial; background-repeat: initial initial;"></div>

		<div id="ermblock" style="position: fixed; left: 427.5px; top: 10%; width: 1000px; height: 320px; z-index: 1000; display:none;">
			<div class="ermblock_main">
				<p><h2>添加提货人</h2></p>
				<form>
					<table cellspacing="0" align="center" class="table_form">
					<tbody><tr>
						<td class="tr fb" width="35%">提货人姓名：</td>
						<td class="four-content" colspan="3"><input type="text" name="pickman_name" maxlength="12" id="pickman_name" value=""> <span style="color:red;">*</span></td>
					</tr>
					<tr>
						<td class="tr fb">联系电话：</td>
						<td class="four-content" colspan="3"><input type="text" name="mobile" id="mobile" maxlength="14" value=""> <span style="color:red;">*</span></td>
					</tr>
						<tr>
						<td class="tr fb">身份证号码：</td>
						<td class="four-content" colspan="3"><input type="text" name="IDENTITY_NUM" id="IDENTITY_NUM" maxlength="18" value=""> <span style="color:red;">*</span></td>
					</tr>
					<tr>
						<td class="tr fb">车牌号码：</td>< <input type="text" name="truck_num" id="truck_num" value="" /> 
						<td class="four-content" colspan="3"><textarea id="truck_num" name="truck_num" maxlength="500" style="width: 153px; height: 50px;"></textarea> <span style="color:red;">* 多个以逗号分隔</span></td>
					</tr>
					</tbody></table>

						<div class="zhxi_con">	
							<span><input class="submit_zz" type="submit" value="提交"></span>
							<span><input class="submit_zz reset_zz" type="reset" value="返回" id="close"></span>
						</div>
				</form>
			</div>
		</div>
		
		<script type="text/javascript">
			 $(document).ready(function(){
			  $("#clickdd").click(function(){
			   $("#ermblock").show();
			   $("#bgblock").show();
			     });
			  $(document).click(function(e){
			   var target = $(e.target);
			   if(target.closest("#clickdd").length == 0){
			    $("#ermblock").hide();
			    $("#bgblock").hide();
			   }
			      }); 
			 }); 
		</script> -->
		<!-- 弹出层 -->