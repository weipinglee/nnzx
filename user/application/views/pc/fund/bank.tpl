
			<!--start中间内容-->	

<script type="text/javascript" src='{root:js/upload/ajaxfileupload.js}'></script>
<script type="text/javascript" src='{root:js/upload/upload.js}'></script>
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>资金管理</a>><a>开户信息管理</a></p>
					</div>
					<div id="bank1" {if: $status!='未申请'}style="display: none"{/if}>

						<form action="{url:/fund/bank}" enctype="multipart/form-data" method='post' auto_submit>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户状态：</span>
								<span class="con_con">{$status}</span>


							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户银行：</span>
								<span><input class="text" type="text" datatype="s2-50" nullmsg="填写开户行" name="bank_name" value="{$bank['bank_name']}"></span>
								<span></span>

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行卡类型：</span>
								<span><select class="text" type="text" name="card_type" datatype="n1-2" style="width:250px;">
										{foreach:items=$type}
										<option value="{$key}" {if:$key==$bank['card_type']}selected{/if}>{$item}</option>
										{/foreach}
										</select>
								</span>
								<span></span>
								
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>{if: $user_type==1}公司名称：{else:}姓名：{/if}</span>
								<span><input class="text" type="text" datatype="s2-20" name="true_name" value="{$bank['true_name']}"></span>
								<span></span>
							</div>
							{if:$user_type!=1}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>身份证：</span>
								<span>
									<input class="text" type="text" name="identify" datatype="/^\d{15,18}$/i" value="{$bank['identify_no']}" >
								</span>
								<span></span>
								
							</div>
							{/if}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行账号：</span>
								<span><input class="text" type="text" name="card_no" datatype="/^[0-9a-zA-Z]{8,30}$/i" value="{$bank['card_no']}" errormsg='请填写8-30位数字或字母'></span>
								<span></span>
								
							</div>
							{if:$user_type!=1}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行卡正面： </span>
								<span>
									 <input type="hidden" name="uploadUrl"  value="{url:/fund/upload}" />
                        			<span class="input-file" style="top:0;">选择文件<input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this);" /></span>

								</span>
							</div>
								{else:}
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>请上传公司的银行许可证： </span>
								<span>
									 <input type="hidden" name="uploadUrl"  value="{url:/fund/upload}" />
                        			 <span class="input-file" style="top:0;">选择文件<input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this);" /></span>
								</span>
									<p class="con_title"></p>
								</div>
							{/if}
							 <div class="zhxi_con">
								 <span  class="con_tit">图片预览：</span>
								 <span>
									 <img name="file2" src="{$bank['proof_thumb']}"/>
					                    <input type="hidden" name="imgfile2" value="{$bank['proof']}" />
								 </span>


					          </div>
							<div class="zhxi_con">	
								<span><input class="submit_zz" type="submit" value="提交"></span>
							</div>
						</form>
					</div>
					<div id="bank2" {if: $status=='未申请'} style="display: none" {/if}>
                            <div class="zhxi_con">
                                <span class="con_tit"><i>*</i>开户状态：</span>
                                <span class="con_con">{$status}</span>


                            </div>
                            {if:$bank['message']}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>审核意见：</span>
								<span class="con_con">{$bank['message']}</span>


							</div>
                            {/if}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户银行：</span>
								<span class="con_con">{$bank['bank_name']}</span>
								<span></span>

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行卡类型：</span>
								<span class="con_con">{$type[$bank['card_type']]}</span>

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>{if: $user_type==1}公司名称：{else:}姓名：{/if}</span>
								<span class="con_con">{$bank['true_name']}</span>
								<span></span>
							</div>
							{if: $user_type!=1}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>身份证：</span>
								<span class="con_con">
									{$bank['identify_no']}
								</span>
								<span></span>

							</div>
							{/if}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行账号：</span>
								<span class="con_con">{$bank['card_no']}
								<span></span>

							</div>
						{if:$user_type!=1}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>打款凭证： </span>
								<span class="con_tit">
									<img name="file2" src="{$bank['proof_thumb']}"/>

								</span>
							</div>
							{else:}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>公司的银行许可证： </span>
								<span class="con_tit">
									<img name="file2" src="{$bank['proof_thumb']}"/>

								</span>
							</div>
						{/if}
							<div class="zhxi_con"  style="cursor:hand;clear:both;">
								<span><input class="submit_zz" type="button" id="bankBtn" value="修改" ></span>
							</div>
					</div>
				
					<div style="clear:both;"></div>
				</div>
			</div>
			<script type="text/javascript">
				$('#bankBtn').click(function(){
					$('#bank2').css('display','none');
					$('#bank1').css('display','block');
				});
			</script>
	<!--end中间内容-->		

