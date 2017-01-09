
			<!--start中间内容-->	
			<div class="user_c">
				<!--start代理账户提现-->
				<div class="user_zhxi">
				<form action="{url:/fund/zztx}" method='post' auto_submit redirect_url="{url:/ucenter/subacclist}">
					<input type="hidden" name="token" value="{$token}" />
					<input type="hidden" name="uid" value="{$uid}" />
					<div class="zhxi_tit">
						<p>{$navi}</p>
					</div>
					<div class="pay_cot">
						<div class="zhxi_con">
							<span class="con_tit"><i></i>可转账金额：</span>
							<span><input class="text" type="text" disabled="disabled" style="border:none;" value="￥{$active}" /></span>
							<span></span>
						</div>

						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>转账金额：</span>
							<span><input class="text" type="text" errormsg="金额填写错误" datatype="money" name="amount"/></span>
							<span></span>
						</div>

						<div class="zhxi_con">
							<span class="con_tit"><i></i>转账说明：</span>
							<span><input class="text" type="text" name="note"/></span>
						</div>
						
						<div class="zhxi_con">
							<span><input class="submit" type="submit" value="转账"/></span>
						</div>
					</div>
				</form>
					
				</div>


			</div>

			
	<!--end中间内容-->		
	
