

			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>账户管理</a>><a>开票信息管理</a></p>
					</div>
					<div {if: empty($data)}style="display:block"{else:}style="display: none" {/if} id="invoice1">

						<form action="{url:/ucenter/invoice}" method="post" auto_submit >
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>发票抬头：</span>
								<span><input class="text" type="text" name="title" value="{$data['title']}" datatype="s2-30" errormsg="格式错误">
                                </span>
                                <span></span>

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>纳税人识别号：</span>
								<span><input class="text" type="text" name="tax_no" value="{$data['tax_no']}" datatype="/^[a-zA-Z0-9_]{15,20}$/" errormsg="格式错误">
								</span>
                                <span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>地址：</span>
								<span><input class="text" type="text" name="address" value="{$data['address']}" datatype="*2-40" errormsg="格式错误">
								</span>
                                <span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>电话：</span>
								<span><input class="text" type="text" name="tel" value="{$data['phone']}" datatype="/^[0-9\-]{6,15}$/" errormsg="格式错误">
								</span>
                                <span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户行：</span>
								<span><input class="text" type="text" name="bankName" value="{$data['bank_name']}" datatype="s2-20" errormsg="格式错误" >
								</span>
                                <span></span>
							</div>
                            <div class="zhxi_con">
                                <span class="con_tit"><i>*</i>银行账户：</span>
								<span><input class="text" type="text" name="bankAccount" value="{$data['bank_no']}" datatype="s8-30" errormsg="格式错误">
								</span>
                                <span></span>
                            </div>
							<div class="zhxi_con">	
								<span><input class="submit_zz" type="submit" value="保存"></span>
							</div>
						</form>
					</div>
					<div style="clear:both;"></div>
					<div {if:!empty($data)}style="display:block"{else:}style="display: none"{/if} id="invoice2">
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>发票抬头：</span>
								<span class="con_con">{$data['title']}
                                </span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>纳税人识别号：</span>
								<span class="con_con">{$data['tax_no']}</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>地址：</span>
								<span class="con_con">{$data['address']}</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>电话：</span>
								<span class="con_con">{$data['phone']}</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户行：</span>
								<span class="con_con">{$data['bank_name']}</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行账户：</span>
								<span class="con_con">{$data['bank_no']}</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span><input class="submit_zz" type="button" value="修改" onclick="changeDiv()"></span>
							</div>
					</div>
				
					<div style="clear:both;"></div>
				</div>
			</div>
<script type="text/javascript">
	function changeDiv(){
		$('#invoice2').css('display','none');
		$('#invoice1').css('display','block');
	}

</script>