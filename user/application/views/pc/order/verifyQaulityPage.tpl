


<div class="user_c">
	<div class="user_zhxi">
		<div class="zhxi_tit">
			<p><a>合同管理</a>><a>质量确认</a></p>
		</div>
		<div style="float:left">
			<form method="post" action="{url:/Order/verifyQaulity}" auto_submit redirect_url="{url:/contract/buyerlist}">
				<input type="hidden" name="order_id" value="{$order_id}"/>
				<div class="zhxi_con">
					<span class="con_tit"><i></i>定金数额：</span>
					<span><input class="text" type="text"  disabled="disabled" value="{$max_reduce}" style="border:none;" /></span>
					<span></span>
				</div>
				<div class="zhxi_con">
					<span class="con_tit"><i>*</i>扣减金额：</span>
					<span><input class="text" type="text"  name='amount' datatype="float" nullmsg="请填写扣减金额"  /></span>
					<span></span>
				</div>
				<div class="zhxi_con">
					<span class="con_tit"><i>*</i>扣减原因：</span>
					<span><textarea name="remark" datatype="*"></textarea></span>
					<span></span>

				</div>
				<div class="zhxi_con">
					<span class="con_tit"><i></i>扣减金额需小于定金数额</span>
					<span></span>
					<span></span>
				
				</div>
				<div class="zhxi_con">
					<span><input class="submit" type="submit" value="提交"/></span>
				</div>
			</form>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>
