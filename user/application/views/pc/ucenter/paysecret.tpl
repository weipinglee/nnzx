
<div class="user_c">
	<div class="user_zhxi">
		<div class="zhxi_tit">
			<p><a>账户管理</a>><a>{if:!empty($pay_secret)}修改支付密码{else:}设置支付密码{/if}</a></p>
		</div>
		<div style="float:left">
			<form action="{url:/ucenter/paysecret}" auto_submit redirect_url="{url:/ucenter/baseinfo}">
				{if:!empty($pay_secret)}
					<div class="zhxi_con">
						<span class="con_tit"><i>*</i>原支付密码：</span>
						<span><input class="text" type="password"  name="ori_secret" datatype='*6-10' errormsg='6-10位支付密码'/>
							<span>忘记原密码？试试<a style="color:#0088cc;" href="{url:/ucenter/paysecrets}">申诉找回</a></span>
					</div>
					<div class="zhxi_con">
						<span class="con_tit"><i>*</i>新支付密码：</span>
						<span><input class="text" type="password" name="new_secret" datatype='*6-10' errormsg='请填写新的支付密码'/>
					</div>
					<div class="zhxi_con">
						<span class="con_tit"><i>*</i>重复支付密码：</span>
						<span><input class="text" type="password"  name="re_secret" datatype='*' recheck='new_secret' errormsg='两次输入的密码不一致'/></span>
					<span></span>
					</div> 
					<input type="hidden" name="oper" value="edit"/>
					<div class="zhxi_con">
						<span><input class="submit_edit" type="submit" value="修改"/></span>
					</div>
				{else:}
					<div class="zhxi_con">
						<span class="con_tit"><i>*</i>支付密码：</span>
						<span><input class="text" type="password" name="pay_secret"/>
					</div>
					<div class="zhxi_con">
						<span class="con_tit"><i>*</i>重复支付密码：</span>
						<span><input class="text" type="password"  name="re_secret" datatype='*' recheck='pay_secret' errormsg='两次输入的密码不一致'/></span>
						<span></span>
					</div>
					<input type="hidden" name="oper" value="add"/>
					<div class="zhxi_con">
					<input type="hidden" name="callback" value="{$callback}" />		
						<span><input class="submit_edit" type="submit" value="提交"/></span>
					</div>
				{/if}


			</form>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>
