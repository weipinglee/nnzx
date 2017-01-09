
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<script type="text/javascript" src="{views:js/cert/cert.js}"></script>
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
			<div class="user_c">
				<div class="user_zhxi">

					<div class="zhxi_tit">
						<p><a>账户管理</a>><a>身份认证</a>><a>企业认证</a></p>
					</div>
					<div class="rz_title">
						<ul class="rz_ul">
							<li class="rz_start"></li>
							<li class="rz_li cur"><a class="rz">认证信息</a></li>
							<li class="rz_li"><a class="yz">资质照片</a></li>
							<li class="rz_li"><a class="shjg">审核结果</a></li>
							<li class="rz_end"></li>
						</ul>

					</div>
					<form method="post" action="{url:/ucenter/doDealCert}" auto_submit>
					<div class="re_xx">

						<!--公司信息-->
						{if:$userType==1}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>公司名：</span>
								<span>
									<input class="text" type="text" name="company_name" datatype="s2-20" errormsg="请输入2-20位中文或字母数字下划线点" value="{$certData['company_name']}"/>
								</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>法定代表人：</span>
							<span>
								<input class="text" type="text" name="legal_person" datatype="zh2-20" errormsg="请输入2-20个中文字符" value="{$certData['legal_person']}"/>
							</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>联系人：</span>
							<span>
								<input class="text" type="text" name="contact" datatype="zh2-20" errormsg="请输入2-20个中文字符" value="{$certData['contact']}"/>
							</span>
								<span></span>
							</div>

							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>联系电话：</span>
							<span>
								<input class="text" type="text" name="phone" datatype="mobile" value="{$certData['contact_phone']}"/>
							</span>
								<span></span>
							</div>

							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>地区：</span>
								<span id="areabox">
										{area:data=$certData['area']}

								</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>详细地址：</span>
							<span>
								<input class="text" type="text" name="address" datatype="*2-100" errormsg="请至少填写2位字符" value="{$certData['address']}"/>
							</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>主营品种：</span>
							<span>
								<input class="text" type="text" datatype="*1-100" name="zhuying" value="{$certData['business']}" errormsg="请填写主营品种" />
							</span>
								<span></span>
							</div>



						{else:}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>真实姓名：</span>
								<span>
									<input class="text" type="text" name="name" datatype="zh2-20" errormsg="请填写姓名" value="{$certData['true_name']}"/>
								</span>
								<span></span>
							</div>


							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>身份证号：</span>
							<span>
								<input class="text" type="text" name="no" datatype="identify" errormsg="请正确填写身份证号" value="{$certData['identify_no']}"/>
							</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>地区：</span>
								<span id="area">
										{area:data=$certData['area']}

								</span>
								<span></span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>详细地址：</span>
							<span>
								<input class="text" type="text" name="address" datatype="*2-100" errormsg="请正确填写地址" value="{$certData['address']}"/>
							</span>
								<span></span>
							</div>


						{/if}
						<div class="zhxi_con">
							<span><input class="submit" id="next_step" type="button"  value="下一步"/></span>
						</div>

					</div>

					<div class="yz_img">
						{if:$userType==1}
						<div class="zhxi_con">
							<span class="con_tit"><i></i>营业执照：</span>
							<span class="input-file">选择文件<input class="doc" type="file" name="file1" id="file1" onchange="javascript:uploadImg(this);" ></span>
							<input type="hidden" name="imgfile1" value="{$certData['cert_bl']}" />
							
						</div>
							<span></span>
						<div class="zhxi_con">
							<span class="con_tit tit_img"><i></i></span>
							<span class="zh_img">
								<img name="file1" src="{if:isset($certData['cert_bl_thumb'])}{$certData['cert_bl_thumb']}{else:}{views:/images/icon/wt.jpg}{/if}"/>
							</span>
						</div>
						<div class="zhxi_con">
							<span class="con_tit"><i></i>税务登记证：</span>
							<span class="input-file">选择文件<input class="doc" type="file" name="file2" id="file2" onchange="javascript:uploadImg(this);" ></span>
							<input type="hidden" name="imgfile2" value="{$certData['cert_tax']}" />

						</div>
							<span></span>
						<div class="zhxi_con">
							<span class="con_tit tit_img"><i></i></span>
							<span class="zh_img">
								<img name="file2" src="{if:isset($certData['cert_tax_thumb'])}{$certData['cert_tax_thumb']}{else:}{views:/images/icon/wt.jpg}{/if}"/>
							</span>
						</div>
						<div class="zhxi_con">
							<span class="con_tit"><i></i>组织机构代码证：</span>
							<span class="input-file">选择文件<input class="doc" type="file" name="file3" id="file3" onchange="javascript:uploadImg(this);" ></span>
							<input type="hidden" name="imgfile3" value="{$certData['cert_oc']}" />

						</div>
							<span></span>
						<div class="zhxi_con">
							<span class="con_tit tit_img"><i></i></span>
							<span class="zh_img">
								<img name="file3" src="{if:isset($certData['cert_oc_thumb'])}{$certData['cert_oc_thumb']}{else:}{views:/images/icon/wt.jpg}{/if}"/>
							</span>
						</div>
						<div class="zhxi_con">
							<p class="font-color">1.业务认证须提供有效期3个月以上的营业执照</p>
							<p class="font-color">2.请保证营业执照上的信息清晰可见</p>
							<p class="font-color">3.支持jpg,bmp,png,gif,文件不超过4MB</p>
							<p class="font-color">4.为了您方便交易请您上传完整的资质证书</p>
						</div>

						{else:}
							<div class="zhxi_con">
								<span class="con_tit"><i></i>身份证正面：</span>
								<span class="input-file">选择文件<input class="doc" type="file" name="file1" id="file1" onchange="javascript:uploadImg(this);" ></span>
								<input type="hidden" name="imgfile1" value="{$certData['identify_front']}" />

							</div>
							<div class="zhxi_con">
								<span class="con_tit tit_img"><i></i></span>
								<span class="zh_img">
									<img name="file1" src="{if:isset($certData['identify_front_thumb'])}{$certData['identify_front_thumb']}{else:}{views:/images/icon/wt.jpg}{/if}"/>
								</span>
							</div>

							<div class="zhxi_con">
								<span class="con_tit"><i></i>身份证背面：</span>
								<span class="input-file">选择文件<input class="doc" type="file" name="file2" id="file2" onchange="javascript:uploadImg(this);" ></span>
								<input type="hidden" name="imgfile2" value="{$certData['identify_back']}" />

							</div>
							<div class="zhxi_con">
								<span class="con_tit tit_img"><i></i></span>
								<span class="zh_img">
									<img name="file2" src="{if:isset($certData['identify_back_thumb'])}{$certData['identify_back_thumb']}{else:}{views:/images/icon/wt.jpg}{/if}"/>
								</span>
							</div>

							<div class="zhxi_con">
								<p class="font-color">1.请保证证件上的信息清晰可见</p>
								<p class="font-color">2.支持jpg,bmp,png,gif,文件不超过2MB</p>
							</div>
						{/if}
						<div class="zhxi_con">
							<span><input class="submit"  type="submit" value="提交审核"></span>
						</div>
					</div>
					</form>
					<div class="sh_jg">
						<div class="success_text">
							<p><b class="b_size">认证状态：{$certShow['status_text']}</b></p>
							{if:$certData['cert_status']==\nainai\cert\certificate::CERT_SUCCESS || $certData['cert_status']==\nainai\cert\certificate::CERT_FAIL}<p>审核意见：{$certData['message']}</p>{/if}
							{if:$certShow['button_show']===true}
							<p>您还可以进行以下操作:</p>
							<p><a class="look" href="javascript:void(0)" onclick="nextTab(1)">{$certShow['button_text']}</a>
							{/if}
						</div>
					</div>
				</form>
				</div>
			</div>
<script type="text/javascript">
	$(function(){
		nextTab({$certShow['step']});
	})
</script>