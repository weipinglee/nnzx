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
            <div id="cont">﻿	
			<!--start中间内容-->	
			<div class="user_c" style="width:79%">
				<div class="user_zhxi">
				<form action="" method="get">
					<div class="zhxi_tit">
						<p><a>资金管理</a>><a>代理账户管理</a></p>
					</div>
					<div>
						<div class="zj_gl">
							<div class="zj_l">
								<a href="http://localhost/nn2/user/fund/cz" class="zj_a cz">充值</a>
								<a href="http://localhost/nn2/user/fund/tx" class="zj_a tx">提现</a>
								<p class="re_t">结算账号资金总额</p>
								<h1 class="rental">￥<?php echo $active+$freeze;?></h1>
								<p class="state"></p>
							</div>
							<div class="zj_r">
								<div class="zj_price"></div>
								<div class="zj_column">
									<span class="column_yes" style="width:<?php echo $freeze/($active+$freeze)*300;?>px;" title="<?php echo isset($freeze)?$freeze:"";?>"></span>
									<span class="column_no" style="width:<?php echo $active/($active+$freeze)*300;?>px;" title="<?php echo isset($active)?$active:"";?>"></span>
									<div class="clear"></div>
								</div>
								<div class="price">
									<span class="price_l">
										<i class="pr_l"></i>
										<span>可用资金</span>
									</span>
									<span class="price_r">
										<i class="pr_r"></i>
										<span>冻结资金</span>
									</span>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						
					</div>
                    <div class="zj_mx">
                    	<div class="mx_l">结算账户资金明细</div>
						<form action="http://localhost/nn2/user/fund/index" method="GET" name="">
                        <div class="mx_r">
							 交易时间：<input class="Wdate" name="begin" type="text" value="<?php echo isset($cond['begin'])?$cond['begin']:"";?>" onClick="WdatePicker()">
							<span class="js_span1">-</span>
							<input class="Wdate" type="text" name="end" value="<?php echo isset($cond['end'])?$cond['end']:"";?>" onClick="WdatePicker()">
							<span class="js_span2">交易号：</span><input type="text" value="<?php echo isset($cond['no'])?$cond['no']:"";?>" name="Sn">
							<select name="day" >
								<option value="7" <?php if($cond['day']==7){?>selected<?php }?>>一周内</option>
								<option value="30" <?php if($cond['day']==30){?>selected<?php }?>>一个月内</option>
								<option value="365" <?php if($cond['day']==365){?>selected<?php }?>>一年内</option>
							</select>
							<button class="search_an" type="submit">搜索</button> 					
						</div>
							</form>
                    </div>
					<div class="jy_xq">
                    <table cellpadding="0" cellspacing="0">
				        <tr>
				            <th>交易号</th>
				            <th>交易时间</th>
				            <th>收入</th>
				            <th>支出</th>
				            <th>冻结</th>
							<th>总金额</th>
							<th>可用金额</th>
				            <th>摘要备注</th>
				        </tr>
						<?php if(!empty($flow)) foreach($flow as $key => $item){?>
						<tr>

							<td><?php echo isset($item['flow_no'])?$item['flow_no']:"";?></td>
							<td><?php echo isset($item['time'])?$item['time']:"";?></td>
							<td><?php echo isset($item['fund_in'])?$item['fund_in']:"";?></td>
							<td><?php echo isset($item['fund_out'])?$item['fund_out']:"";?></td>
							<td><?php echo $item['total'] -$item['active'] ;?></td>
							<td><?php echo isset($item['total'])?$item['total']:"";?></td>
							<td><?php echo isset($item['active'])?$item['active']:"";?></td>
							<td><?php echo isset($item['note'])?$item['note']:"";?></td>

						</tr>
						<?php }?>
                    </table>
					</div>
				</form>
				</div>
			</div>
			
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