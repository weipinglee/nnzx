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
			<div class="user_c_list">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>仓单管理</a>><a>仓单列表</a></p>
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

							<table border="0"  cellpadding="" cellspacing="">
								<tr class="title">
									<td>序号</td>
									<td>商品名称</td>
									<td>市场分类</td>
									<td>规格</td>
									<td>重量</td>
                                                                                <td>仓单状态</td>
                                                                                <td>所在库</td>
                                                                                <td>操作</td>
								</tr>
								<?php if(!empty($data['list'])){?>
                                                                                        <?php if(!empty($data['list'])) foreach($data['list'] as $key => $list){?>
                                                                                        <?php $key++; ?>
                                                                                        <tr>
                                                                                                <td><?php echo isset($key)?$key:"";?></td>
                                                                                                <td><?php echo isset($list['pname'])?$list['pname']:"";?></td>
                                                                                                <td><?php echo isset($list['cname'])?$list['cname']:"";?></td>
                                                                                                <td>
                                                                                                		<ul>
																											<?php if(!empty($list['attribute'])){?>
                                                                                                		<?php if(!empty($list['attribute'])) foreach($list['attribute'] as $aid => $attr){?>
                                                                                                		<li><?php echo isset($data['attrs'][$aid])?$data['attrs'][$aid]:"";?> : <?php echo isset($attr)?$attr:"";?></li>
                                                                                                		<?php }?>
																											<?php }?>
                                                                                                		</ul>
                                                                                                </td>
                                                                                                <td><?php echo \nainai\offer\product::floatForm($list['quantity']);?>(<?php echo isset($list['unit'])?$list['unit']:"";?>)</td>
                                                                                                <td><?php echo isset($statuList[$list['status']])?$statuList[$list['status']]:"";?></td>
                                                                                                <td><?php echo isset($list['sname'])?$list['sname']:"";?></td>
                                                                                                <td>
                                                                                                <a href='http://localhost/nn2/user/managerdeal/table/id/<?php echo $list["id"];?>' target="_blank">打印预览</a>
                                                                                                <a href='http://localhost/nn2/user/managerdeal/storeproductdetail/id/<?php echo $list['id'];?>'>查看</a>
                                                                                                </td>

                                                                                        </tr>
                                                                                      <?php }?>
                                                                             <?php }?>
							</table>

						</div>
						
						<!-- <div class="tab_bt">
							<div class="t_bt">
								<a class="a_1" title="编辑" href="user_cd.html"></a>
								<a class="a_2" title="添加" href="user_cd.html"></a>
								<a class="a_3" title="删除" href="user_cd.html"></a>
							</div>
						</div> -->
						<div class="page_num">
<!-- 							共0条记录&nbsp;当前第<font color="#FF0000">1</font>/0页&nbsp;
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