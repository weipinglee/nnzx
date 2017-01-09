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
            <div id="cont">			<!--start中间内容-->	
			<div class="user_c_list">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>合同管理</a>><a>销售合同</a></p>
					</div>
					<div class="chp_xx">

						<?php if($data['search']!=''){?>
    <?php $begin=\Library\safe::filterGet('begin');; ?>
    <?php $end=\Library\safe::filterGet('end');; ?>
    <?php $like=\Library\safe::filterGet('like');; ?>
    <?php $min=\Library\safe::filterGet('min');; ?>
    <?php $max=\Library\safe::filterGet('max');; ?>
    <?php $select=\Library\safe::filterGet('select');; ?>
<div class="xx_top">
    <form action="" method="get" >
        <ul>
            <?php if(isset($data['search']['like'])){?>
            <li><?php echo isset($data['search']['like'])?$data['search']['like']:"";?>：<input id="warename" name="like" value="<?php echo isset($like)?$like:"";?>" type="text" style="width:150px;"></li>
            <?php }?>
            <?php if(isset($data['search']['time'])){?>
             <li>
                 <?php echo isset($data['search']['time'])?$data['search']['time']:"";?>：
                 <input class="Wdate" type="text" onclick="WdatePicker()" name="begin" value="<?php echo isset($begin)?$begin:"";?>"> <span style="position: relative;left: -3px;">—</span>
                 <input class="Wdate" type="text" onclick="WdatePicker()" name="end" value="<?php echo isset($end)?$end:"";?>">

             </li>
            <?php }?>

            <?php if(isset($data['search']['between'])){?>
                <?php echo isset($data['search']['between'])?$data['search']['between']:"";?>:
                <input type="text" class="input-text" style="width:100px"  id="" name="min" value="<?php echo isset($min)?$min:"";?>">-
                <input type="text" class="input-text" style="width:100px"  id="" name="max" value="<?php echo isset($max)?$max:"";?>">
            <?php }?>
            <?php if(isset($data['search']['select'])){?>

            <li> <?php echo isset($data['search']['select'])?$data['search']['select']:"";?>：
                <select  name="select" style="width:60px;">
                    <option value="all">全部</option>
                    <?php if(!empty($data['search']['selectData'])) foreach($data['search']['selectData'] as $key => $item){?>
                        <option value="<?php echo isset($key)?$key:"";?>" <?php if($select==$key){?>selected=true<?php }?>><?php echo isset($item)?$item:"";?></option>
                    <?php }?>
                </select></li>
            <?php }?>
            <li> <a class="chaz" onclick="javascript:$(this).parents('form').submit();">查找</a></li>
        </ul>
    </form>
    <div style="clear:both;"></div>
</div>
<?php }?>

						<div class="xx_center">
							<table class="sales_table" border="0"  cellpadding="0" cellspacing="0">
								<tr class="first_tr">
									<td width="80px"><input onclick="selectAll1();" name="controlAll" style="controlAll" id="controlAll" type="checkbox" class="controlAll">全选
									</td>
									<td width="180px">产品详情</td>
									<td width="260px">金额及付款方式</td>
									<td width="200px">主要指标</td>
									<td>交易操作</td>
								</tr>
                                <tr>
									<td colspan="6">&nbsp;</td>
								</tr>
                                
								
                                <?php if(!empty($data['list'])) foreach($data['list'] as $key => $item){?>
									<tr class="title">
										<td colspan="6">
											<input id="controlAll" type="checkbox" class="controlAll">
											单号:<a href="http://localhost/nn2/user/contract/sellerdetail/id/<?php echo $item['id'];?>"><span class="col2517EF"><?php echo isset($item['order_no'])?$item['order_no']:"";?></span></a>
											<span class="colaa0707 ht_padd"></span>
											<span><img class="middle_img" src="/nn2/user/views/pc/images/center/ico_cj.png"><?php if($item['company_name']){?>购买单位：<?php echo isset($item['company_name'])?$item['company_name']:"";?><?php }else{?>购买个人：<?php echo isset($item['true_name'])?$item['true_name']:"";?><?php }?></span>
											<span class="ht_padd">
												<!-- <img class="middle_img" src="/nn2/user/views/pc/images/center/ico_kf.png">  客服 -->
											</span>
										</td>
										
										<td colspan="3"></td>
									</tr>
									<tr>
										<td colspan="2">
											<img class="middle_img" src="<?php echo \Library\thumb::get($item['img'],100,100);?>" align="left" width="100px"/>
											<div class="div_height">&nbsp;<?php echo isset($item['product_name'])?$item['product_name']:"";?></div>
											<!-- <div class="div_height">&nbsp;是否含税：是</div>
											<div class="div_height">&nbsp;是否含保险：是</div> -->
											<?php if(isset($item['store_name']) && $item['mode'] == \nainai\order\Order::ORDER_STORE){?>
											<div class="div_height">&nbsp;所在地：<?php echo isset($item['store_name'])?$item['store_name']:"";?></div>
											<?php }?>
										</td>
										<td>
											<div class="div_heights colaa0707">合同总额：￥<?php echo isset($item['amount'])?$item['amount']:"";?></div>
											<!-- <div class="div_heights colA39F9F">等级折扣：￥10.00</div> -->
											<div class="hr"></div>
											<!-- <div class="div_heights">保证金支付（<?php echo isset($item['percent'])?$item['percent']:"";?>%）</div> -->
										</td>
										<td>
											<!-- <div class="div_heights">规格：230*114*65</div> -->
											<!-- <div class="div_heights">材质：高铝质</div> -->
											<div class="div_heights">数量：<?php echo isset($item['num'])?$item['num']:"";?><?php echo isset($item['unit'])?$item['unit']:"";?></div>
										</td>
										<td>
											<div class="div_heights">
												<?php if($item['action_href']){?>
													<a href='<?php echo isset($item['action_href'])?$item['action_href']:"";?>' <?php if($item['confirm']){?>confirm=1<?php }?>><b><?php echo isset($item['action'])?$item['action']:"";?><b></a>
												<?php }else{?>
													<?php echo isset($item['action'])?$item['action']:"";?>
												<?php }?>
											</div>
										</td>
									</tr>
								<?php }?>
										
							</table>

						</div>
						
						<div class="page_num">
							<!-- 共0条记录&nbsp;当前第<font color="#FF0000">1</font>/0页&nbsp;
							<a href="#">第一页</a>&nbsp;
							<a href="#">上一页</a>&nbsp;
							<a href="#">下一页</a>&nbsp;
							<a href="#">最后页</a>&nbsp; 
							跳转到第 <input name="pagefind" id="pagefind" type="text" style="width:20px;font-size: 12px;" maxlength="5" value="1"> 页 
							<a><span class="style1">确定</span></a> -->

							<?php echo isset($data['bar'])?$data['bar']:"";?>
						</div>

					</div>
				</div>
				
				
			</div>
			<!--end中间内容-->	</div>

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