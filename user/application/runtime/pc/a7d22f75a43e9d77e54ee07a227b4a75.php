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
			<!-- start 依据条件显示HTML-->
			<div class="user_c_list">
				<!-- start 是否选择去认证
				<div class="check-approve">
					<img src="../images/icon/check-approve.jpg">
					<p class="p-title zn-f18">您的基本资料未填写完成</p>
					<p class="p-con  zn-f14">请完善您的基本资料并申请正式会员，享受更多会员服务</p>
					<p class="p-btn">
						<a href="identity/zh_rez.html" class="zn-f16 go-now">资质认证</a>
						<a class="zn-f16 not-go">暂不认证</a>
					</p>
				</div>  end 是否选择去认证 -->	
			<!-- start 暂不认证 -->	
				<div class="user_zbrz noshow">
					<div class="user_nrz">
						<div class="nrz_tit"><span>账户信息</span><a class="gengduo" href="user_dd.html"></a></div>
						<div class="nrz_dd">
							<table class="hy_info" width="100%">
								<tr>
									<td width="450px" style="border-right:1px solid #eee;">
										<ul class="dj">
											<li>会员等级：<span><img src="<?php echo isset($group['icon'])?$group['icon']:"";?>"/><?php echo isset($group['group_name'])?$group['group_name']:"";?></span></li>
											<li><a href="http://company.nainaiwang.com/product.php?id=67"><span class="colaa0707" style="padding-left:30px;text-decoration:underline;">会员升级</span></a></li>

											<li style="clear:both;"><span>信誉分值：<?php echo isset($creditGap)?$creditGap:"";?> 分</span></li>
										</ul>
									</td>
									<td style="padding-bottom:0px;">
										<span>结算账号资金总额</span>
										<span class="colaa0707"><b class="font-size ">￥<?php echo isset($count)?$count:"";?></b><br/>
											<span style="line-height: 30px;padding-left: 120px;"></span>
										</span>
									</td>
								</tr>
								<tr>
									<td width="280px" style="border-right:1px solid #eee;">
										<div class="icon_rz">
											<?php if(!empty($cert)) foreach($cert as $key => $item){?>
												<?php if($cert[$key]==1){?>
												<span><img src="/nn2/user/views/pc/images/center/icon_yrz.png"><?php echo \nainai\cert\certificate::$certRoleText[$key];?>已认证</span>
												<?php }else{?>
												<span><img src="/nn2/user/views/pc/images/center/icon_wrz.png"><?php echo \nainai\cert\certificate::$certRoleText[$key];?>未认证</span>

												<?php }?>
											<?php }?>
											<?php if($href){?>
												<a href="<?php echo isset($href)?$href:"";?>"><span class="colaa0707" style="padding-left:30px;text-decoration:underline;">去认证</span></a>
											<?php }?>
										</div>
									</td>
									<td>
										<span class="rz_an_index">
											<a href="http://localhost/nn2/user/fund/cz" class="zj_a cz">充值</a>
											<a href="http://localhost/nn2/user/fund/tx" class="zj_a tx">提现</a>
										</span>
									</td>
								</tr>
								
							</table>
							
						</div>
					</div>
					<div class="user_nrz">
						<div class="nrz_tit"><span>最新购买合同</span><a class="gengduo" href="http://localhost/nn2/user/contract/buyerlist">更多>></a></div>
						<div class="nrz_gz">
							<?php if(!empty($contract2)){?>
							<table width="100%">
								<tr>
									<td width="220px" style="min-height:80px;">
										<div style="padding:5px 10px;">
											<div class="div_height">&nbsp;<?php echo isset($contract2['product_name'])?$contract2['product_name']:"";?></div>
										</div>

									</td>
									<td width="380px" >
										<a href="http://localhost/nn2/user/contract/buyerdetail/id/<?php echo $contract2['id'];?>"><?php echo isset($contract2['order_no'])?$contract2['order_no']:"";?></a>
									</td>
									<td width="200px">
										<div class="div_heights colaa0707">合同总额：￥<?php echo isset($contract2['amount'])?$contract2['amount']:"";?></div>

									</td>


									<td>
										<div class="div_heights">
										<?php if($contract2['action_href']){?>
											<a href="<?php echo isset($contract2['action_href'])?$contract2['action_href']:"";?>"><b><?php echo isset($contract2['title'])?$contract2['title']:"";?><b></b></b></a>
										<?php }else{?>
											<?php echo isset($contract2['title'])?$contract2['title']:"";?>
										<?php }?>
										</div><b><b>
											</b></b></td>
								</tr>
							</table>
							<?php }else{?>
								<table width="100%">
									<tr>
										<td colspan="4">
											<img src="/nn2/user/views/pc/images/center/no-data.png">
											<p class="no-data">暂无购买合同</p>
										</td>
									</tr>
								</table>
							<?php }?>

						</div>
					</div>
					<?php if( $user_type == 1){?>
					<!-- 最新销售合同 -->
					<div class="user_nrz">
						<div class="nrz_tit"><span>最新销售合同</span><a class="gengduo" href="http://localhost/nn2/user/contract/sellerlist">更多>></a></div>
						<div class="nrz_gz">
							<?php if(!empty($contract1)){?>
							<table width="100%">
								<tr>
									<td width="220px" style="min-height:80px;">
										<div style="padding:5px 10px;">
											<div class="div_height">&nbsp;<?php echo isset($contract1['product_name'])?$contract1['product_name']:"";?></div>
										</div>
										
									</td>
									<td width="380px" >
										<a href="http://localhost/nn2/user/contract/sellerdetail/id/<?php echo $contract1['id'];?>"><?php echo isset($contract1['order_no'])?$contract1['order_no']:"";?></a>
									</td>
									<td width="200px">
										<div class="div_heights colaa0707">合同总额：￥<?php echo isset($contract1['amount'])?$contract1['amount']:"";?></div>

									</td>

									
									<td>
										<div class="div_heights">
											<?php if($contract1['action_href']){?>
											<a href='<?php echo isset($contract1['action_href'])?$contract1['action_href']:"";?>'><b><?php echo isset($contract1['action'])?$contract1['action']:"";?><b></b></b></a>
											<?php }else{?>
											<b><?php echo isset($contract1['action'])?$contract1['action']:"";?><b></b></b>
											<?php }?>
										</div><b><b>
									</b></b></td>
								</tr>

							</table>
							<?php }else{?>
							<table width="100%">
								<tr>
									<td colspan="4">
										<img src="/nn2/user/views/pc/images/center/no-data.png">
										<p class="no-data">暂无销售合同</p>
									</td>
								</tr>
								</table>
							<?php }?>
							
						</div>
					</div>
					<?php }?>
					<!-- 最新销售合同end -->
					<!-- 关注推荐 start
					<div class="user_nrz chp_xx">
						<div class="nrz_tit"><span>关注推荐</span><a class="gengduo" href="user_gz.html">更多>></a></div>
						<div class="xx_center">
							<table width="100%">
								<tr>
									<td>编号</td>
									<td>供求</td>
									<td>品名</td>
									<td>服务</td>
									<td>规格</td>
									<td>数量（吨）</td>
									<td>剩余（吨）</td>
									<td>价格（元）</td>
									<td>产地</td>
									<td>交货地</td>
									<td>操作</td>
								</tr>
								<tr>
									<td>GF0000001</td>
									<td><span class="col12aa07">供</span></td>
									<td>高铝砖</td>
									<td><img src="../images/center/icon_b.jpg">
										<img src="../images/center/icon_c.jpg">
									</td>
									<td>95%</td>
									<td>200</td>
									<td>300</td>
									<td>￥1780</td>
									<td>山西</td>
									<td>耐耐网一号库</td>
									<td>
										<a><img src="../images/center/icon_serch.jpg"/></a>
										<a><img src="../images/center/icon_yy.jpg"/></a>
										<a><img src="../images/center/icon_qq.jpg"/></a>
									</td>
								</tr>
								<tr>
									<td>GF0000001</td>
									<td><span class="col12aa07">供</span></td>
									<td>高铝砖</td>
									<td><img src="../images/center/icon_b.jpg">
										<img src="../images/center/icon_c.jpg">
									</td>
									<td>95%</td>
									<td>200</td>
									<td>300</td>
									<td>￥1780</td>
									<td>山西</td>
									<td>耐耐网一号库</td>
									<td>
										<a><img src="../images/center/icon_serch.jpg"/></a>
										<a><img src="../images/center/icon_yy.jpg"/></a>
										<a><img src="../images/center/icon_qq.jpg"/></a>
									</td>
								</tr>
							</table>
							
						</div>
					</div>
					关注推荐 end -->
				</div>
			<!-- end 暂不认证 -->	
			</div>
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