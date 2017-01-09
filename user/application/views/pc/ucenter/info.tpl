<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{views:js/upload.js}"></script>
<script language="javascript" type="text/javascript" src="{views:/js/My97DatePicker/WdatePicker.js}"></script>


			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>账户管理</a>><a>基本信息</a></p>
					</div>
					<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
					{if:$type==0}
				<form method="post" action="{url:/ucenter/personUpdate}">
					<div style="float:left">

							<input type="hidden" name="id" value="{$user['id']}"  />
						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>用户名：</span>
							<span><input class="text" type="text" name="username" pattern="/^[a-zA-Z0-9_]{3,30}$/" alt="格式错误" value="{$user['username']}"/></span>
						</div>

						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>手机号：</span>
							<span><input class="text" type="text" name="mobile" disabled value="{$user['mobile']}"/></span>
						</div>

						<div class="zhxi_con">
							<span class="con_tit">邮箱：</span>
							<span><input class="text" type="text" name="email" empty pattern="email" alt="请正确填写邮箱" value="{$user['email']}"/></span>
						</div>

						<!--身份信息开始-->
						<div class="zhxi_con">
							<span class="con_tit"><i>*</i>真实姓名：</span>
							<span><input class="text" type="text" name="true_name" pattern="required" value="{$user['true_name']}"/></span>
						</div>

						<div class="zhxi_con">
							<span class="con_tit"><i></i>性别：</span>
							<span>
								<select class="select" name="sex">
									<option value="0" {if:$user['sex']==0}selected{/if}>男</option>
									<option value="1" {if:$user['sex']==1}selected{/if}>女</option>
								</select>
							</span>
						</div>
						<div class="zhxi_con">
							<span class="con_tit">生日：</span>
							<span><input class="Wdate text" name="birth" type="text" empty pattern="date" onClick="WdatePicker()" value="{$user['birth']}"></span>
						</div>
						<div class="zhxi_con">
							<span class="con_tit"><i></i>学历：</span>
						<span>
							<select class="select" name="education">
								<option value="0">请选择</option>
								<option value="1">初中</option>
								<option value="2">高中</option>
								<option value="3">专科</option>
								<option value="4">本科</option>
								<option value="5">硕士</option>
							</select>
						</span>
						</div>
						<div class="zhxi_con">
							<span class="con_tit">QQ号：</span>
							<span><input class="text" type="text" name="qq" empty pattern="qq" value="{$user['qq']}"/></span>
						</div>
						<div class="zhxi_con">
							<span class="con_tit">职称：</span>
							<span><input class="text" type="text" name="zhichen" value="{$user['zhichen']}"/></span>
						</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>身份证号：</span>
								<span><input class="text" type="text" name="identify_no" pattern="/^\d+$/" value="{$user['identify_no']}" /></span>
							</div>

							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>身份证正面照：</span>
								<div>
									<input type="file" name="file1" id="file1"  onchange="javascript:uploadImg(this);" />

								</div>
								<span class="con_tit">  &nbsp;&nbsp;</span>
								<div  class="up_img">
									<img name="file1" src="{if:$user['identify_front']==''}{views:/images/icon/wt.jpg}{else:}{$user['identify_front_thumb']}{/if}"/>
									<input type="hidden"  name="imgfile1" value="{$user['identify_front']}" pattern="required" alt="请上传图片" />
								</div><!--img name属性与上传控件id相同-->

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>身份证背面照：</span>
								<div>
									<input type="file" name="file2" id="file2"  onchange="javascript:uploadImg(this);" />

								</div>
								<span class="con_tit">  &nbsp;&nbsp;</span>
								<div  class="up_img">
									<img name="file2"  src="{if:$user['identify_back']==''}{views:/images/icon/wt.jpg}{else:}{$user['identify_back_thumb']}{/if}"/>
									<input type="hidden" name="imgfile2" value="{$user['identify_back']}" pattern="required" alt="请上传图片"/>
								</div>

							</div>




						<div class="zhxi_con">
							<span><input class="submit" type="submit" value="保存"/></span>
						</div>
						<!--身份信息结束-->


					</div>
					<div class="zhxi_upimg">
						<div id="dd" class="up_img"><img name="file3" src="{if:isset($user['head_photo_thumb'])}{$user['head_photo_thumb']}{else:}{views:/images/icon/wt.jpg}{/if}"/></div>
						<div>
							<input type="file" name="file3" id="file3"  onchange="javascript:uploadImg(this);" />
							<input type="hidden" name="imgfile3" value="{$user['head_photo']}" />
						</div>
					</div>
				</form>
					{else:}
						<form method="post" action="{url:/ucenter/companyUpdate}">
							<div style="float:left">

								<input type="hidden" name="id" value="{$user['id']}"  />
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>用户名：</span>
									<span><input class="text" type="text" name="username" pattern="/^[a-zA-Z0-9_]{3,30}$/" alt="格式错误" value="{$user['username']}"/></span>
								</div>

								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>手机号：</span>
									<span><input class="text" type="text" name="mobile" disabled value="{$user['mobile']}"/></span>
								</div>

								<div class="zhxi_con">
									<span class="con_tit">邮箱：</span>
									<span><input class="text" type="text" name="email" empty pattern="email" alt="请正确填写邮箱" value="{$user['email']}"/></span>
								</div>


								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>企业名称：</span>
									<span><input class="text" type="text" name="company_name" pattern="required" value="{$user['company_name']}"/></span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>企业地址：</span>
									<span>{area:data=$user['area'] pattern=area}</span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>详细地址：</span>
									<span><input class="text" type="text" name="address" pattern="required" value="{$user['address']}"/></span>
								</div>

								<div class="zhxi_con">
									<span class="con_tit"><i></i>企业类型：</span>
									<span>
										<select class="select" name="category" pattern="/^[1-9][0-9]?$/">
											<option value="0">请选择</option>
											<option value="1">初中</option>
											<option value="2">高中</option>
										</select>
									</span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i></i>企业性质：</span>
									<span>
										<select class="select" name="nature" pattern="/^[1-9][0-9]?$/" >
											<option value="0">请选择</option>
											<option value="1">初中</option>
											<option value="2">高中</option>
										</select>
									</span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>法人姓名：</span>
									<span><input class="text" type="text" name="legal_person" pattern="required" value="{$user['legal_person']}"/></span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>注册资金：</span>
									<span><input class="text" type="text" name="reg_fund" pattern="float" value="{$user['reg_fund']}"/>万</span>
								</div>

								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>联系人：</span>
									<span><input class="text" type="text" name="contact" pattern="required" value="{$user['contact']}"/></span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i></i>联系人职务：</span>
									<span>
										<select class="select" name="contact_duty" pattern="/^[1-9][0-9]?$/" >
											<option value="1">负责人</option>
											<option value="2">高级管理</option>
											<option value="3">员工</option>
										</select>
									</span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>联系人电话：</span>
									<span><input class="text" type="text" name="contact_phone" pattern="mobile" value="{$user['contact_phone']}"/></span>
								</div>

								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>收票人：</span>
									<span><input class="text" type="text" name="check_taker" pattern="required" value="{$user['check_taker']}"/></span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>收票人电话：</span>
									<span><input class="text" type="text" name="check_taker_phone" pattern="mobile" value="{$user['check_taker_phone']}"/></span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>收票人地址：</span>
									<span><input class="text" type="text" name="check_taker_add" pattern="required" value="{$user['check_taker_add']}"/></span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>开户行：</span>
									<span><input class="text" type="text" name="deposit_bank" pattern="required" value="{$user['deposit_bank']}"/></span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>银行账户：</span>
									<span><input class="text" type="text" name="bank_acc" pattern="int" value="{$user['bank_acc']}"/></span>
								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>税号：</span>
									<span><input class="text" type="text" name="tax_no" pattern="required" value="{$user['tax_no']}"/></span>
								</div>

								<div class="zhxi_con">
									<span class="con_tit">QQ号：</span>
									<span><input class="text" type="text" name="qq" empty pattern="qq" value="{$user['qq']}"/></span>
								</div>

								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>营业执照：</span>
									<div>
										<input type="file" name="file1" id="file1"  onchange="javascript:uploadImg(this);" />

									</div>
									<span class="con_tit">  &nbsp;&nbsp;</span>
									<div  class="up_img">
										<img name="file1" src="{if:$user['cert_bl']==''}{views:/images/icon/wt.jpg}{else:}{$user['cert_bl_thumb']}{/if}"/>
										<input type="hidden"  name="imgfile1" value="{$user['cert_bl']}" pattern="required" alt="请上传图片" />
									</div><!--img name属性与上传控件id相同-->

								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>组织机构代码证：</span>
									<div>
										<input type="file" name="file2" id="file2"  onchange="javascript:uploadImg(this);" />

									</div>
									<span class="con_tit">  &nbsp;&nbsp;</span>
									<div  class="up_img">
										<img name="file2" src="{if:$user['cert_oc']==''}{views:/images/icon/wt.jpg}{else:}{$user['cert_oc_thumb']}{/if}"/>
										<input type="hidden"  name="imgfile2" value="{$user['cert_oc']}" pattern="required" alt="请上传图片" />
									</div><!--img name属性与上传控件id相同-->

								</div>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>税务登记证：</span>
									<div>
										<input type="file" name="file3" id="file3"  onchange="javascript:uploadImg(this);" />

									</div>
									<span class="con_tit">  &nbsp;&nbsp;</span>
									<div  class="up_img">
										<img name="file3" src="{if:$user['cert_tax']==''}{views:/images/icon/wt.jpg}{else:}{$user['cert_tax_thumb']}{/if}"/>
										<input type="hidden"  name="imgfile3" value="{$user['cert_tax']}" pattern="required" alt="请上传图片" />
									</div><!--img name属性与上传控件id相同-->

								</div>

								<div class="zhxi_con">
									<span><input class="submit" type="submit" value="保存"/></span>
								</div>
								<!--身份信息结束-->


							</div>
							<div class="zhxi_upimg">
								<div id="dd" class="up_img"><img name="file4" src="{if:isset($user['head_photo_thumb'])}{$user['head_photo_thumb']}{else:}{views:/images/icon/wt.jpg}{/if}"/></div>
								<div>
									<input type="file" name="file4" id="file4"  onchange="javascript:uploadImg(this);" />
									<input type="hidden" name="imgfile4" value="{$user['head_photo']}" />
								</div>
							</div>
						</form>
					{/if}

					<div style="clear:both;"></div>
				</div>

			</div>

