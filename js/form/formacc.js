
var nn_panduo = window.NameSpace || {};
nn_panduo.formacc = function(obj){
	this.event_obj = '';//当前事件对象
	this.ajax_return_data = '';//ajax返回数据
	this.no_redirect = false;
	this.validObj = '';
	if(obj){
		this.form = obj.form || '';//要提交的表单对象
		this.redirect_url = obj.redirect_url||'';//操作成功后自动跳转的地址
		this.no_redirect = $(this.form).attr('no_redirect');//是否开启自动跳转
		// this.status = obj.status||'';//列表中要更改的数据状态
		// this.ajax_url = obj.ajax_url||'';//处理接口地址
	}

}

nn_panduo.formacc.prototype = {
	form_init:function(){
		var _this = this;
		$("form[auto_submit]").each(function(i){
			_this.redirect_url = $(this).attr("redirect_url");
			_this.form = this;
			_this.no_redirect = $(this).attr('no_redirect') ? 1:0;
			_this.bind_select();
			_this.validform();

		});
		_this.validPaymentPassword();
	},
	/**
	 * 自动绑定select选中项
	 */
	bind_select:function(){
		$(this.form).find("select").each(function(){
			var value = $(this).attr('value');
			if(value != null && value != ''){
				var option = $(this).find("option[value='"+value+"']");
				var txt = $(option).text();
				$(option).attr("selected",'selected');
				$(this).siblings("span").text(txt);
			}
		});
		// $("select[name='type']").find("option[value='{$info['type']}']").attr("selected",'selected');
	},
	/**
	 * 表单提交
	 * @type {Object}
	 */
	validform:function(){
		var _this = this;
		if(this.form){

			this.validObj = $(this.form).Validform({
				tiptype : 2,
				ajaxPost:false,
				showAllError:false,
				postonce:true,

				datatype : {
					'float' : /^\d+\.?\d*$/i,
					"zh" : /^[\u4E00-\u9FA5\uf900-\ufa2d]$/,
					"zh2-5" : /^[\u4E00-\u9FFF\uf900-\ufa2d]{2,5}$/,
					'qq' : /^[1-9][0-9]{4,16}$/i,
					'zip' : /^\d{6}$/i,
					'mobile':/^1[2|3|4|5|6|7|8|9][0-9]\d{8}$/,
					'date':  /^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/i,
					'datetime':  /^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29) (?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9])$/i,
					'identify' : /^\d{17}(\d|x)$/i,
					'money' : function(gets){
						gets = $.trim(gets);
						if(gets.match(/^[1-9][0-9]{0,7}(\.\d{0,2})?$/)){
							return true;
						}
						if(gets.match(/^0\.[1-9][0-9]?$/)){
							return true;
						}
						if(gets.match(/^0\.0[1-9]$/)){
							return true;
						}
						return false;
					}

				},
				beforeSubmit:function(curform){ 
					var url = $(curform).attr('action');
					var data = $(curform).serialize();
					var pay_secret = $(curform).attr('pay_secret');
					var has_secret = $(curform).attr('has_secret');
					if(pay_secret){
						if(has_secret){
							_this.ajax_post(has_secret,{password:'pass'},function(){
								layer.closeAll();
								layer.config({
									extend: 'extend/layer.ext.js'
								});
								layer.prompt({title:'请输入支付密码',formType:1},function(pass){

									layer.closeAll();
									data += '&pay_secret=' + pass;
									// console.log(data);
									layer.load(2,{shade:[0.1,'gray']});
									_this.ajax_post(url,data,function(){
										layer.closeAll();
										if(!_this.no_redirect){
											layer.msg("操作成功!稍后自动跳转");
											setTimeout(function(){
												if(_this.redirect_url){
													window.location.href=_this.redirect_url;
												}else{
													window.location.reload();
												}
											},1000);
										}else{
											layer.msg('操作成功！');
										}
									});
								});
							});
						}
						else{
							layer.config({
								extend: 'extend/layer.ext.js'
							});
							layer.prompt({title:'请输入支付密码',formType:1},function(pass){

								layer.closeAll();
								data += '&pay_secret=' + pass;
								// console.log(data);
								layer.load(2,{shade:[0.1,'gray']});
								_this.ajax_post(url,data,function(){
									layer.closeAll();
									if(!_this.no_redirect){
										layer.msg("操作成功!稍后自动跳转");
										setTimeout(function(){
											if(_this.redirect_url){
												window.location.href=_this.redirect_url;
											}else{
												window.location.reload();
											}
										},1000);
									}else{
										layer.msg('操作成功！');
									}
								});
							});
						}


						

					}else{
						layer.load();
						_this.ajax_post(url,data,function(){
							layer.closeAll();
							if(!_this.no_redirect){
								layer.msg("操作成功!稍后自动跳转");
								setTimeout(function(){
									 if(_this.redirect_url){
										window.location.href=_this.redirect_url;
									}else{
										window.location.reload();
									}
								},1000);
							}else{
								layer.msg('操作成功！');
							}
						});
					}
					return false;
				}
			});
		}
	},
	//为a标签绑定认证支付密码事件
	validPaymentPassword:function(){
		$('a[pay_secret]').each(function(){
			$(this).click(function(){
				var href = $(this).attr('href');
				layer.prompt({title:'请输入支付密码',formType:1},function(pass){

					layer.closeAll();
					href += '/pay_secret/'+pass;
					window.location.href = href;
				});

				return false;
			});

		});
	},

	check:function(bool){
		return this.validObj.check(bool);
	},

	ignore:function(selecter){
		this.validObj.ignore(selecter);
	},
	unignore:function(selecter){
		this.validObj.unignore(selecter);
	},


	addRule :function(roles){
		this.validObj.addRule(roles);
	},

	/**
	 * 设置数据状态
	 * @return {[type]} [description]
	 */
	//初始化点击事件
	bind_status_handle:function(){
		var _this = this;
		$('a[ajax_status]').each(function(i){
			var url = $(this).attr('ajax_url');
			var status = $(this).attr("ajax_status");
			$(this).unbind('mouseover').unbind('click').click(function(){
				_this.event_obj = this;

				if($(this).prop("confirm") || status == -1){
					//删除提醒
					layer.confirm("确定吗？",function(){
						layer.closeAll();
						_this.setStatus(url,{status:status});
					});
				}else{
					_this.setStatus(url,{status:status});
				}
			});
		});
	},
	setStatus:function(url,data){
		var _this = this;
		this.ajax_post(url,data,function(){
			if($(_this.event_obj).attr("ajax_status") == -1){
				//删除
				$(_this.event_obj).parents("tr").remove();
				return;
			}
			if($(_this.event_obj).attr("to_list")){
				layer.msg("操作成功!");
				setTimeout(function(){
					window.location.reload();
				},1000);
			}else{
				$(_this.event_obj).attr("title","");//$(_this.event_obj).attr("title") == "启用" ? "停用" : "启用");
				$(_this.event_obj).attr("ajax_status",$(_this.event_obj).attr("ajax_status") == 1 ? 0 : 1);
				$(_this.event_obj).find('i').attr("class",$(_this.event_obj).find('i').attr("class") == "icon-pause" ? "icon-play" : "icon-pause");
				var td_status = $(_this.event_obj).parents("td").siblings(".td-status").find('span.label');
				if(td_status.hasClass('label-success')){
					td_status.removeClass('label-success').addClass('label-error').html("停用");
				}else if(td_status.hasClass('label-error')){
					td_status.removeClass('label-error').addClass('label-success').html("已启用");
				}
				_this.bind_status_handle();
			}
			//console.log(_this.event_obj);
		});
	},
	//ajax提交
	ajax_post:function(url,ajax_data,suc_callback,err_callback){
		var _this = this;
		$.ajax({
			type:'post',
			url:url,
			data:ajax_data,
			dataType:'json',
			success:function(data){
				layer.closeAll();
				if(data.success == 1){
					if(data.returnUrl){
						layer.msg(data.info);
						setTimeout(function(){
								window.location.href=data.returnUrl;
						},1000);
					}
					else{
						_this.ajax_return_data = data;
						if(typeof(eval(suc_callback)) == 'function'){
							suc_callback();
						}
						_this.ajax_return_data = '';
					}


				}else{
					if(data.returnUrl){
							layer.msg(data.info);
							setTimeout(function(){
								window.location.href=data.returnUrl;
							},1000);

					}
					else{
						if(typeof(eval(err_callback)) == 'function'){
							err_callback();
						}
						layer.msg(data.info);
					}

				}
			},
			error:function(data){
				layer.closeAll();
				layer.msg("服务器错误,请重试");
			}
		});
	}
}


$(function(){
	formacc = new nn_panduo.formacc();
	formacc.bind_status_handle();

	formacc.form_init();
	//地址验证，根据是两级或三级动态调整验证规则
	if($('#areabox').length && $('#areabox').length>0){
		$('#areabox').find('select').on('change',function(){
			var num = $('#areabox').find('select:visible').length;
			var rules = [{
				ele:"input[name=area]",
				datatype:"n"+num*2+"-6",
				nullmsg:"请选择地址！",
				errormsg:"请选择地址！"
			}];
			formacc.addRule(rules);

		})
		//为地址选择框添加验证规则
		var rules = [{
			ele:"input[name=area]",
			datatype:"n6-6",
			nullmsg:"请选择地址！",
			errormsg:"请选择地址！"
		}];
		formacc.addRule(rules);
	}

})









