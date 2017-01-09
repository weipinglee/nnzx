
			<!--start中间内容-->	

<script type="text/javascript" src='{root:js/upload/ajaxfileupload.js}'></script>
<script type="text/javascript" src='{root:js/upload/upload.js}'></script>
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>资金管理</a>><a>中信银行附属账户信息</a></p>
					</div>
					<div>
						<form action="{url:/fund/zxpage}"  method='post' auto_submit>
							

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>附属账户名称：</span>
								<span><input class="text" type="text" datatype="zh2-10" nullmsg="填写附属账户名称" name="name" value="{$info['name']}"></span>
								<span></span>

							</div>

					{if:$info['no']}
						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>附属账号：</span>
							<span><input class="text" type="text" value="{$info['no']}"></span>
							<span></span>
						</div>
					{/if}

					<div class="zhxi_con">
								<span class="con_tit"><i>*</i>法人名称：</span>
								<span><input class="text" type="text" datatype="zh2-10" nullmsg="填写法人名称" name="legal" value="{$info['legal']}"></span>
								<span></span>
								
							</div>
							<!-- <div class="zhxi_con">
								<span class="con_tit"><i>*</i>姓名：</span>
								<span><input class="text" type="text" datatype="s2-20" name="true_name" value="{$bank['true_name']}"></span>
								<span></span>
							</div> -->
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>身份证：</span>
								<span>
									<input class="text" type="text" name="id_card" datatype="/^\d{15,18}$/i" value="{$info['id_card']}" />
								</span>
								<span></span>
								
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>通讯地址：</span>
								<span><input class="text" type="text" name="address" datatype="*" value="{$info['address']}" /></span>
								<span></span>
								
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>联系人姓名：</span>
								<span><input class="text" type="text" name="contact_name" datatype="*" value="{$info['contact_name']}" /></span>
								<span></span>
								
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>联系电话：</span>
								<span><input class="text" type="text" name="contact_phone" datatype="*" value="{$info['contact_phone']}" /></span>
								<span></span>
								
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>电子邮箱：</span>
								<span><input class="text" type="text" name="mail_address" datatype="*" value="{$info['mail_address']}" /></span>
								<span></span>
								
							</div>
							
							{if:!$info}
							<div class="zhxi_con">
								<span class="con_tit"><i></i></span>
								<span style="color:red">为了保证您签约顺利，请务必填写正确信息</span>
								
							</div>
							<div class="zhxi_con">	
								<span><input class="submit_zz" type="submit" value="提交"></span>
							</div>
							{/if}
						</form>
					</div>
					
				
					<div style="clear:both;"></div>

				</div>
			</div>
	<!--end中间内容-->		
<script type="text/javascript">
	
	$(function(){
		if({$info['user_id']}){
			$('input').attr('disabled','disabled').css({border:'none'});
		}
	})
</script>
