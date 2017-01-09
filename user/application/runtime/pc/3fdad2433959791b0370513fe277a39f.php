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
            <div id="cont">﻿<script type="text/javascript" src="/nn2/user/js/upload/ajaxfileupload.js"></script>
<script type="text/javascript" src="/nn2/user/js/upload/upload.js"></script>
<!--start中间内容-->
            <div class="user_c">
                <!--start代理账户充值-->
                <div class="user_zhxi">
                
                    <div class="zhxi_tit">
                        <p><a>资金管理</a>><a>代理账户管理</a>><a>充值</a>
                        </p>
                    </div>
                    <div class="pay_cot">
                        <div class="zhxi_con font_set">
                            <span class="con_tit">账户余额：</span>
                            <span><i>￥</i><i class="bold"><?php echo isset($total)?$total:"";?></i></span>
                        </div>
                        <form auto_submit>
                            <div class="zhxi_con font_set">
                                <span class="con_tit">充值金额：</span>
                                <span><input class="text potwt" type="text" errormsg="金额填写错误" datatype="money" name='recharge'/>元</span>
                                <span></span>
                            </div>
                        </form>
        <!--TAB切换start  -->
            <div class="tabs_total">
                
                <div class="tabPanel">

                    
                    <ul>
                        <li class='hit'>银联在线支付</li> 
                        <li class=''>银联在线支付b2b</li> 
                        <li class="" >线下支付</li>
                    </ul>
                    <form method='post' class="js_redi_o" action="http://localhost/nn2/user/fund/dofundin" auto_submit redirect_url="http://localhost/nn2/user/fund/index">
                        <div class="js_tab_choose cont" >
                           <div class="" >
                                <div class="zhxi_con">
                                    <input class="text potwt" type="hidden" name='recharge'/>
                                    <input type="hidden" name='payment_id' value='3'/>
                                    <span><input class="submit" type="submit" value="下一步"/></span>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                    <form method='post' class="js_redi_o" action="http://localhost/nn2/user/fund/dofundin" auto_submit redirect_url="http://localhost/nn2/user/fund/index">
                        <div class="js_tab_choose  cont" style="display:none">
                           <div class="" >
                                <div class="zhxi_con">
                                    <input class="text potwt" type="hidden" name='recharge'/>
                                    <input type="hidden" name='payment_id' value='4'/>
                                    <span><input class="submit" type="submit" value="下一步"/></span>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                    <form method='post' class="js_redi_o" action="http://localhost/nn2/user/fund/dofundin" enctype="multipart/form-data" auto_submit redirect_url="http://localhost/nn2/user/fund/index">
                        <div class="pane js_show_payment_choose cont">
                            <div class="pane" style="display: block">
                                <div class="zhxi_con">
                                    <!-- <span class="con_tit">充值方式二：</span>
                                    <span class="con_con" style="float:none;">转账汇款</span> -->
                                    
                                </div>
                                <div class="zhxi_con">
                                    <?php if(!empty($acc)) foreach($acc as $key => $item){?>
                                        <p class="zf_an"><?php echo isset($item['name_zh'])?$item['name_zh']:"";?>：<?php echo isset($item['value'])?$item['value']:"";?></p>
                                    <?php }?>

                                </div>
                                
                                <!-- 单据上传start -->
                                <input type="hidden" name="uploadUrl"  value="http://localhost/nn2/user/ucenter/upload" />
                                <div class="huikod" >

                                  <label for="female">上传汇款单据</label>

                                    <span class="input-file" style="top:0;">选择文件<input type="file" name="file1" id="file1"  onchange="javascript:uploadImg(this);" /></span>

                                    <div id="preview">
                                        <img name="file1" src=""/>
                                        <input type="hidden"  name="imgfile1" datatype="*"  />

                                    </div>
                                    <span></span>
                                </div>
                                

                                <!-- 单据上传end -->
                                <div class="zhxi_con">
                                    <input class="text potwt" type="hidden" name='recharge'/>
                                    <span><input class="submit" type="submit" value="提交"/></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>  


        <!--TAB切换end  -->
                    </div>
                
           <script type="text/javascript">
           $(function(){  
            $('input[name=recharge]').eq(0).change(function(){
                var v = $(this).val();
                $('input[name=recharge]').val(v);
            })
           // $('.js_show_payment_choose').html($('.js_tab_choose>div:eq(0)').clone());   
               $('.tabPanel ul li').click(function(){

                     $(this).addClass('hit').siblings().removeClass('hit');
                   // $('.js_show_payment_choose').html($('.js_tab_choose>div:eq('+$(this).index()+')').clone().css('display', 'block'));
                   $('.cont').hide().eq($(this).index()).show();

               })
           })
           var submit_pay = "http://localhost/nn2/user/fund/dofundin";
           </script>
                    
                    <div class="zj_mx">
    
                        <div class="mx_l">代理账户充值明细</div>
                        
                        <form action="http://localhost/nn2/user/fund/cz" method="GET" name="">
                            <div class="mx_r">
                                交易时间：<input class="Wdate" name="begin" type="text" value="<?php echo isset($cond['begin'])?$cond['begin']:"";?>" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'})">
                                -
                                <input class="Wdate" type="text" name="end" value="<?php echo isset($cond['end'])?$cond['end']:"";?>" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'})">
                                交易号：<input type="text" value="<?php echo isset($cond['no'])?$cond['no']:"";?>" name="Sn">
                                <select name="day" >
                                    <option value="7" <?php if($cond['day']==7){?>selected<?php }?>>一周内</option>
                                    <option value="30" <?php if($cond['day']==30){?>selected<?php }?>>一个月内</option>
                                    <option value="365" <?php if($cond['day']==365){?>selected<?php }?>>一年内</option>
                                </select>
                                <button type="submit" class="search_an">搜索</button>
                            </div>
                        </form>
                    </div>
                    <div class="jy_xq">

                        <table cellpadding="0" cellspacing="0" style="">

                            <tr>
                                <th>交易号</th>
                                <th>交易时间</th>
                                <th>金额</th>
                                <th>状态</th>
                                <th>审核意见</th>
                            </tr>
                            <?php if(!empty($flow)) foreach($flow as $key => $item){?>
                                <tr>

                                    <td><?php echo isset($item['order_no'])?$item['order_no']:"";?></td>
                                    <td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
                                    <td><?php echo isset($item['amount'])?$item['amount']:"";?></td>
                                    <td><?php echo isset($item['status'])?$item['status']:"";?></td>
                                    <?php if( $item['first_time']!=null&&$item['final_time']==null){?>
                                        <td><?php echo isset($item['first_message'])?$item['first_message']:"";?></td>
                                    <?php }elseif( $item['first_time']!=null&&$item['final_time']!=null){?>
                                    <td><?php echo isset($item['final_message'])?$item['final_message']:"";?></td>
                                    <?php }else{?>
                                        <td></td>
                                    <?php }?>
                                </tr>
                            <?php }?>
                            <tr>
                                <td colspan="100"><div class="page_num"><?php echo isset($pageBar)?$pageBar:"";?></div></td>
                            </tr>
                        </table>

                    </div>

                </div>
            </div>
            
    <!--end中间内容-->    </div>

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