
			<!--start中间内容-->	

<script type="text/javascript" src='{root:js/upload/ajaxfileupload.js}'></script>
<script type="text/javascript" src='{root:js/upload/upload.js}'></script>
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>签约账户管理</a>><a>绑定出金银行卡</a></p>
					</div>
					<div id="bank1" {if: isset($bank['status'])}style="display: none"{/if}>

						<form action="{url:/fund/outcard}" enctype="multipart/form-data" method='post' auto_submit>

							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户行全称：</span>
								<span><input class="text" type="text" datatype="s2-50" nullmsg="填写开户行" name="bank_name" value="{$bank['bank_name']}"></span>
								<span></span>
							
							</div>
							
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行账号：</span>
								<span><input class="text" type="text" name="no" datatype="/^[0-9a-zA-Z]{8,20}$/i" value="{$bank['no']}" ></span>
								<span></span>
								
							</div>

							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>姓名：</span>
								<span><input class="text" type="text" datatype="s2-20" name="name" value="{$bank['name']}"></span>
								<span></span>
							</div>
							
							
							
							<div class="zhxi_con">	
								<span><input class="submit_zz" type="submit" value="提交"></span>
							</div>
						</form>
					</div>
					<div id="bank2" {if: !isset($bank['status'])} style="display: none" {/if}>
                            
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户银行：</span>
								<span class="con_con">{$bank['bank_name']}</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行账号：</span>
								<span class="con_con">{$bank['no']}</span>

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>姓名：</span>
								<span class="con_con">{$bank['name']}</span>
								<span></span>
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

