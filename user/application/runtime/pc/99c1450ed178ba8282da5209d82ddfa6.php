<!DOCTYPE html>
<html>
<head>
  <title>个人中心</title>
  <meta name="keywords"/>
  <meta name="description"/>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
  <link href="/nn2/user/views/pc/css/user_index.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="/nn2/user/js/jquery/jquery-1.7.2.min.js"></script>



  <script language="javascript" type="text/javascript" src="/nn2/user/views/pc/js/My97DatePicker/WdatePicker.js"></script>
  <script type="text/javascript" src="/nn2/user/views/pc/js/regular.js"></script>
   <script src="/nn2/user/views/pc/js/center.js" type="text/javascript"></script>
  <link href="/nn2/user/views/pc/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
   <!-- 头部控制 -->
  <link href="/nn2/user/views/pc/css/topnav20141027.css" rel="stylesheet" type="text/css">
  <script src="/nn2/user/views/pc/js/topnav20141027.js" type="text/javascript"></script>
    <!-- 头部控制 -->

    <script type="text/javascript" src="/nn2/user/js/form/validform.js" ></script>
    <script type="text/javascript" src="/nn2/user/js/form/formacc.js" ></script>
    <script type="text/javascript" src="/nn2/user/js/layer/layer.js"></script>
    <script type="text/javascript" src="/nn2/user/js/layer/extend/layer.ext.js"></script>

     <link href="/nn2/user/js/form/validate/error.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="/nn2/user/js/area/AreaData_min.js" ></script>
    <script type="text/javascript" src="/nn2/user/js/area/Area.js" ></script>

</head>
<body>
<!--    公用头部控件 -->
    <div class="bg_topnav">
    <div class="topnav_width">
        <div class="topnav_left">
            <div class="top_index">
                <img class="index_img" src="/nn2/user/views/pc/images/icon/icon_index.png"/>
                <a rel="external nofollow" href="http://124.166.246.120:8000/user//index/index" target="_blank" >耐耐网首页</a>
            </div>

            <div class="index_user">
            <?php if(isset($username)){?>
                <a rel="external nofollow"  href="http://localhost/nn2/user/ucenterindex/index"  target="_blank" class="">您好，<?php echo isset($username)?$username:"";?></a>
                <?php }else{?>
                <span>您好，欢迎进入耐耐网</span>
                <?php }?>
            </div>
            <?php if($login==0){?>
            <div class="login_link" id="toploginbox">
                <a rel="external nofollow" href="http://localhost/nn2/user/login/login" target="_blank" class="topnav_login">请登录</a>
            </div>
            <div class="topnav_regsiter">
                <a rel="external nofollow" href="http://localhost/nn2/user/login/register" target="_blank">免费注册</a>
            </div>
            <?php }else{?>
            <div class="login_link" id="toploginbox">
                <a rel="external nofollow" href="http://localhost/nn2/user/login/logout" target="_blank" class="topnav_login">退出</a>
            </div>
            <?php }?>
        </div>
        <div class="topnav_right">
            <ul>
                <?php if($login!=0){?>
                 <li>
                   <a href="http://localhost/nn2/user/ucenterindex/index">会员中心</a><span class="line_l">|<span>
                </li>
                <li>
                    <?php if($usertype==1){?>
                        <a href="http://localhost/nn2/user/contract/sellerlist">我的合同</a>
                    <?php }else{?>
                        <a href="http://localhost/nn2/user/contract/buyerlist">我的合同</a>
                    <?php }?>
                    <span class="line_l">|<span>
                </li>
                <?php }?>
                <li>
                    <a href="http://localhost/nn2/user/message/usermail">消息中心<?php if($mess!=0){?><em class="information"><?php echo isset($mess)?$mess:"";?></em><?php }?></a><span class="line_l">|<span>
                </li>
                <!--<li>
                    <img class="iphon_img" src="/nn2/user/views/pc/images/icon/icon_iphon.png"/>
                    <a href="">手机版</a><span class="line_l">|<span>
                </li>-->
                <li>
                    <a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=4006238086&aty=0&a=0&curl=&ty=1" target="_blank" ><!--onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&sid=279020473&o=new.nainaiwang.com&q=7', '_blank', 'height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');" --> 在线客服</a><span class="line_l">|<span>
                </li>
                <li style="padding-top:2px;">
                    <span>交易时间：<?php echo isset($deal['start_time'])?$deal['start_time']:"";?>--<?php echo isset($deal['end_time'])?$deal['end_time']:"";?></span>
                </li>

            </ul>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!-- 公用头部控件 -->
<div class="header">
		<div class="nav">
            <div class="logo-box zn-l">
                <a href="http://124.166.246.120:8000/user//index/index" alt="返回耐耐首页"><img src="/nn2/user/views/pc/images/icon/nainaiwang.png"/></a></dd>
            </div>
			<div class="nav-tit">
                <ul class="nav-list">
                    <?php if(!empty($topArray)) foreach($topArray as $key => $topList){?>
                        <li>
                            <a href="<?php echo isset($topList['url'])?$topList['url']:"";?>" <?php if( isset($topList['isSelect']) && $topList['isSelect'] == 1){?> class="cur" <?php }?>><?php echo isset($topList['title'])?$topList['title']:"";?></a>
                        </li>
                    <?php }?>

                </ul>
			</div>
		</div>
	</div>
	<div class="user_body">
		<div class="user_b">
			<!--start左侧导航--> 
            <div class="user_l">
                <?php if(!empty($leftArray) && count($leftArray)>1){?>
                <div class="left_navigation">
                    <ul>

                    	<?php if(!empty($leftArray)) foreach($leftArray as $k => $leftList){?>
                    		<?php if( $k == 0){?>
                    		<li class="let_nav_tit"><h3><?php echo isset($leftList['title'])?$leftList['title']:"";?></h3></li>
                    		<?php }else{?>
                            <li class="btn1" id="btn<?php echo isset($k)?$k:"";?>">
                                <a class="nav-first <?php if($action==$leftList['action']){?>cur<?php }?>" <?php if( !empty($leftList['url'])){?> href="<?php echo isset($leftList['url'])?$leftList['url']:"";?>"<?php }?> >
                                    <?php echo isset($leftList['title'])?$leftList['title']:"";?>
                                    <i class="icon-caret-down"></i>
                                </a>
                                <?php if( !empty($leftList['list'])){?>
                                    <ul class="zj_zh" >
                                        <?php if(!empty($leftList['list'])) foreach($leftList['list'] as $key => $list){?>
                                            <li><a  href="<?php echo isset($list['url'])?$list['url']:"";?>" <?php if( in_array($action, $list['action'])){?>class="cur"<?php }?> ><?php echo isset($list['title'])?$list['title']:"";?></a></li>
                                        <?php }?>
                                    </ul>
                                <?php }?>
                            </li>

                    		<?php }?>



                    	<?php }?>
                        
                      
                    </ul>
                </div>
                <?php }else{?>
                    <div class="wrap_con">
                        <div class="personal_data">
                            <div class="head_portrait">
                                <a href="#">
                                    <img src="/nn2/user/views/pc/images/icon/head_portrait.jpg">
                                </a>
                            </div>
                            <div class="per_username">
                                <p class="username_p"><b>您好，<?php echo isset($username)?$username:"";?></b></p>
                                <p class="username_p"><!--<img src="<?php echo isset($group['icon'])?$group['icon']:"";?>">--><?php echo isset($group['group_name'])?$group['group_name']:"";?></p>
                                <p class="username_p">消息提醒：<a href="http://localhost/nn2/user/message/usermail"><b class="colaa0707"><?php echo isset($mess)?$mess:"";?></b></a></p>
                            </div>
                            <div class="per_function">
                                <a href="http://localhost/nn2/user/ucenter/baseinfo">基本信息设置</a>
                                <a href="http://localhost/nn2/user/ucenter/password">修改密码</a>
                            </div>

                        </div>
                    </div>
                <?php }?>
            </div>
            <!--end左侧导航-->
            <div id="cont">
			<!--start中间内容-->	

<script type="text/javascript" src='/nn2/user/js/upload/ajaxfileupload.js'></script>
<script type="text/javascript" src='/nn2/user/js/upload/upload.js'></script>
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>资金管理</a>><a>开户信息管理</a></p>
					</div>
					<div id="bank1" <?php if( $status!='未申请'){?>style="display: none"<?php }?>>

						<form action="http://localhost/nn2/user/fund/bank" enctype="multipart/form-data" method='post' auto_submit>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户状态：</span>
								<span class="con_con"><?php echo isset($status)?$status:"";?></span>


							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户银行：</span>
								<span><input class="text" type="text" datatype="s2-50" nullmsg="填写开户行" name="bank_name" value="<?php echo isset($bank['bank_name'])?$bank['bank_name']:"";?>"></span>
								<span></span>

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行卡类型：</span>
								<span><select class="text" type="text" name="card_type" datatype="n1-2" style="width:250px;">
										<?php if(!empty($type)) foreach($type as $key => $item){?>
										<option value="<?php echo isset($key)?$key:"";?>" <?php if($key==$bank['card_type']){?>selected<?php }?>><?php echo isset($item)?$item:"";?></option>
										<?php }?>
										</select>
								</span>
								<span></span>
								
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i><?php if( $user_type==1){?>公司名称：<?php }else{?>姓名：<?php }?></span>
								<span><input class="text" type="text" datatype="s2-20" name="true_name" value="<?php echo isset($bank['true_name'])?$bank['true_name']:"";?>"></span>
								<span></span>
							</div>
							<?php if($user_type!=1){?>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>身份证：</span>
								<span>
									<input class="text" type="text" name="identify" datatype="/^\d{15,18}$/i" value="<?php echo isset($bank['identify_no'])?$bank['identify_no']:"";?>" >
								</span>
								<span></span>
								
							</div>
							<?php }?>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行账号：</span>
								<span><input class="text" type="text" name="card_no" datatype="/^[0-9a-zA-Z]{8,30}$/i" value="<?php echo isset($bank['card_no'])?$bank['card_no']:"";?>" errormsg='请填写8-30位数字或字母'></span>
								<span></span>
								
							</div>
							<?php if($user_type!=1){?>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行卡正面： </span>
								<span>
									 <input type="hidden" name="uploadUrl"  value="http://localhost/nn2/user/fund/upload" />
                        			<span class="input-file" style="top:0;">选择文件<input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this);" /></span>

								</span>
							</div>
								<?php }else{?>
								<div class="zhxi_con">
									<span class="con_tit"><i>*</i>请上传公司的银行许可证： </span>
								<span>
									 <input type="hidden" name="uploadUrl"  value="http://localhost/nn2/user/fund/upload" />
                        			 <span class="input-file" style="top:0;">选择文件<input type='file' name="file2" id="file2"  onchange="javascript:uploadImg(this);" /></span>
								</span>
									<p class="con_title"></p>
								</div>
							<?php }?>
							 <div class="zhxi_con">
								 <span  class="con_tit">图片预览：</span>
								 <span>
									 <img name="file2" src="<?php echo isset($bank['proof_thumb'])?$bank['proof_thumb']:"";?>"/>
					                    <input type="hidden" name="imgfile2" value="<?php echo isset($bank['proof'])?$bank['proof']:"";?>" />
								 </span>


					          </div>
							<div class="zhxi_con">	
								<span><input class="submit_zz" type="submit" value="提交"></span>
							</div>
						</form>
					</div>
					<div id="bank2" <?php if( $status=='未申请'){?> style="display: none" <?php }?>>
                            <div class="zhxi_con">
                                <span class="con_tit"><i>*</i>开户状态：</span>
                                <span class="con_con"><?php echo isset($status)?$status:"";?></span>


                            </div>
                            <?php if($bank['message']){?>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>审核意见：</span>
								<span class="con_con"><?php echo isset($bank['message'])?$bank['message']:"";?></span>


							</div>
                            <?php }?>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>开户银行：</span>
								<span class="con_con"><?php echo isset($bank['bank_name'])?$bank['bank_name']:"";?></span>
								<span></span>

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行卡类型：</span>
								<span class="con_con"><?php echo isset($type[$bank['card_type']])?$type[$bank['card_type']]:"";?></span>

							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i><?php if( $user_type==1){?>公司名称：<?php }else{?>姓名：<?php }?></span>
								<span class="con_con"><?php echo isset($bank['true_name'])?$bank['true_name']:"";?></span>
								<span></span>
							</div>
							<?php if( $user_type!=1){?>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>身份证：</span>
								<span class="con_con">
									<?php echo isset($bank['identify_no'])?$bank['identify_no']:"";?>
								</span>
								<span></span>

							</div>
							<?php }?>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>银行账号：</span>
								<span class="con_con"><?php echo isset($bank['card_no'])?$bank['card_no']:"";?>
								<span></span>

							</div>
						<?php if($user_type!=1){?>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>打款凭证： </span>
								<span class="con_tit">
									<img name="file2" src="<?php echo isset($bank['proof_thumb'])?$bank['proof_thumb']:"";?>"/>

								</span>
							</div>
							<?php }else{?>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>公司的银行许可证： </span>
								<span class="con_tit">
									<img name="file2" src="<?php echo isset($bank['proof_thumb'])?$bank['proof_thumb']:"";?>"/>

								</span>
							</div>
						<?php }?>
							<div class="zhxi_con"  style="cursor:hand;clear:both;">
								<span><input class="submit_zz" type="button" id="bankBtn" value="修改" ></span>
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

</div>

				<!--end中间内容-->	
			
		</div>
	</div>
<script type="text/javascript">
    $(function() {
        $('.left_navigation ').find('.cur').parents('.btn1').find('.nav-first').trigger('click');
    })
</script>
</body>
</html>