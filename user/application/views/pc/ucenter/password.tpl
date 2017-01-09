<script type="text/javascript" src="{root:js/jquery/jquery-1.7.2.min.js}"></script>
 <script type="text/javascript" src="{root:js/form/formacc.js}" ></script>
  <script type="text/javascript" src="{root:js/form/validform.js}" ></script>
			<div class="user_c">
				<div class="user_zhxi">
				<form method="post" action="{url:/ucenter/chgPass}" auto_submit >
					<div class="zhxi_tit">
						<p><a>账户管理</a>><a>修改密码</a></p>
					</div>
					<div style="float:left">

						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>原始密码：</span>
							<span><input class="text" type="password" datatype="*6-15" name="old_pass"/></span>
							<span></span>
							<span><a style="color:#0088cc;" href="{url:/login/PasswordReset}">忘记密码？</a></span>
						</div>
						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>新密码：</span>
							<span><input class="text" type="password" datatype="/^\S{6,15}$/" name="new_pass"/></span>
							<span></span>
						</div>
						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>确认新密码：</span>
							<span><input class="text" type="password" datatype="/^\S{6,15}$/" recheck="new_pass" errormsg="您两次输入的账户密码不一致！" name="new_repass"/></span>
							<span></span>
						</div>
						
						<div class="zhxi_con">
							<span><input class="submit" type="submit" value="保存"/></span>
						</div>
					</div>
					<div style="clear:both;"></div>
				</form>
				</div>
			</div>

