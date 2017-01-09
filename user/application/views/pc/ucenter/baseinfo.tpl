
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>账户管理</a>><a>基本信息</a></p>
					</div>
					<div style="float:left">

						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>用户名：</span>
							<span><input class="text" type="text" disabled="disabled" value="{$user['username']}" name="username"/>
						</div>
						<div class="zhxi_con">
							<span class="con_tit"><i></i>手机号码：</span>
							<span><input class="text" disabled="disabled" value="{$user['mobile']}" type="text" name="mobile"/>
							<a href="{url:/ucenter/mobileEdit}"><i class="icon-info-sign"></i>点击修改手机号码</a>
							<!-- <input type="text" readonly="readonly" name="checkh" class="mobile_no"/></span> -->
						</div>
						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>电子邮箱：</span>
							<span><input class="text" type="text" disabled="disabled" value="{$user['email']}" name="email"/>
						</div>


						<div class="zhxi_con">
							<span><a class="submit" href="{url:/ucenter/baseEdit}">修改</a></span>
						</div>

					</div>
					<div style="clear:both;"></div>
				</div>
			</div>
