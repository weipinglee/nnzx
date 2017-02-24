<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>资讯中心</title>


    <script src="/views/pc/js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
    <script src="/views/pc/js/new-slide.js" type="text/javascript" language="javascript"></script>
    <script src="/views/pc/js/style.js" type="text/javascript" language="javascript"></script>
    <script src="/views/pc/js/new-nav.js" type="text/javascript" language="javascript"></script>
    <link rel="stylesheet" type="text/css" href="/views/pc/css/new-style.css">
</head>
<body>



<body>
<div class="header">
    <div class="content">
        <div class="logo"></div>
        <ul class="nav">
            <li><a href='http://info.nainaiwang.com//index/index' <?php if($type_id == 0){?>class='on'<?php }?>>首页</a></li>
            <li id="industry"><a href='http://info.nainaiwang.com//hangye/index/type/<?php echo isset($typelist[0]['id'])?$typelist[0]['id']:"";?>' <?php if($type_id ==$typelist[0]['id']){?>class="on"<?php }?>>行业</a></li>

            <li><a href="http://info.nainaiwang.com//shuju/index/type/<?php echo isset($typelist[1]['id'])?$typelist[1]['id']:"";?>" <?php if($type_id == $typelist[1]['id']){?>class="on"<?php }?>>数据</a></li>
            <li><a href='http://info.nainaiwang.com//guandian/index/type/<?php echo isset($typelist[2]['id'])?$typelist[2]['id']:"";?>' <?php if($type_id == $typelist[2]['id']){?>class="on"<?php }?>>观点</a></li>
        </ul>
        <form class="search">
            <input type="text" placeholder="请输入关键字查询" class="text"><input type="button" value="搜索" class="button">
        </form>
    </div>
    <script type="text/javascript">
        $(function(){
            $('.search .button').click(function(){
                var k = $(this).siblings('input').val();
                if(k != '' && k != '请输入关键字查询')
                window.location.href = "http://info.nainaiwang.com//search/index/keyword/"+k;
            });
            $('.search .text').keydown(function(e){
                if(e.keyCode == 13){
                    e.preventDefault();
                    var k = $(this).val();
                    if(k != '' && k != '请输入关键字查询')
                        window.location.href = "http://info.nainaiwang.com//search/index/keyword/"+k;
                    return;
                }
            });
        })
    </script>
    
    <div class="in_nav" id="in_nav">
        <ul>
            <img src="/views/pc/images/nav_top.png" class="in_nav_top">

            <?php if(!empty($cates)) foreach($cates as $key => $item){?>
            <li>
                <img src="<?php echo isset($item['img'])?$item['img']:"";?>"/>
                <a class="title_a" href="http://info.nainaiwang.com//hangye/index/type/3/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?>
                    <!-- <div class="c-tip-arrow" style="left: 38px;"><em></em></div> -->
                </a>
            </li>
            <?php }?>
            <!-- <li class="industry1"><a href>建材行业</a></li> -->
        </ul>
    </div>
    </div>

	<div class="clear"></div>
</div>
<div class="main">
	<div class="nav_top">您现在的位置：<a>首页</a>><a><?php echo isset($bread)?$bread:"";?></a></div>
	<div class="main_left">
		<div class="new_list quotation_margin_top">
			<div class="content_title clear">
			<ul class="content_title_ul">
				<li>
					<a class="title_a <?php if($id==0){?>on<?php }?>" href="http://info.nainaiwang.com//more/index/type/<?php echo isset($type_id)?$type_id:"";?>">全部
						<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
					</a>
				</li>
				<?php if(!empty($cates)) foreach($cates as $key => $item){?>
				<li>
					<a class="title_a <?php if($id==$item['id']){?>on<?php }?>" href="http://info.nainaiwang.com//more/index/type/<?php echo isset($type_id)?$type_id:"";?>/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?>
						<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
					</a>
				</li>
				<?php }?>
			</ul>
		</div>
			<?php if(!empty($main_data)) foreach($main_data as $key => $item){?>
				<div class="news">
					<?php if(isset($item['cover'][0])){?>
						<img src="/views/pc/images/20170123161308.jpg" class="news_pic">
						<div class="news_content">
							<h3>
								<a href="http://info.nainaiwang.com//more/index/type/<?php echo isset($item['type'])?$item['type']:"";?>/id/<?php echo isset($item['cate_id'])?$item['cate_id']:"";?>"><span class="trade"><?php echo isset($item['cate_name'])?$item['cate_name']:"";?></span></a>
								<a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><span class="title"><?php echo isset($item['name'])?$item['name']:"";?></span></a><!-- 标题处后台需限制输入字数 -->
							</h3>
							<!-- 程序能否控制这里输出的字数，最后加个省略号 -->
							<p><?php echo isset($item['short_content'])?$item['short_content']:"";?></p>
							<p class="author">
								<img src="/views/pc/images/20170123161308.jpg" class="head_pic">
								<span class="time"><?php echo isset($item['create_time'])?$item['create_time']:"";?></span>
								<span class="count"><?php echo isset($item['collect_num'])?$item['collect_num']:"";?>次</span>
								
							</p>

						</div>
					<?php }else{?>
						<div class="news_content no_pic">
							<h3>
								<a href="http://info.nainaiwang.com//more/index/type/<?php echo isset($item['type'])?$item['type']:"";?>/id/<?php echo isset($item['cate_id'])?$item['cate_id']:"";?>"><span class="trade"><?php echo isset($item['cate_name'])?$item['cate_name']:"";?></span></a>
								<a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><span class="title"><?php echo isset($item['name'])?$item['name']:"";?></span></a><!-- 标题处后台需限制输入字数 -->
							</h3>
							<!-- 程序能否控制这里输出的字数，最后加个省略号 -->
							<p><?php echo isset($item['short_content'])?$item['short_content']:"";?></p>
							<p class="author">
								<img src="/views/pc/images/20170123161308.jpg" class="head_pic">
								<span class="time"><?php echo isset($item['create_time'])?$item['create_time']:"";?></span>
								<span class="count"><?php echo isset($item['collect_num'])?$item['collect_num']:"";?>次</span>
								
							</p>

						</div>
					<?php }?>
				</div>
			<?php }?>
			<div class="page">
				<?php echo isset($pageBar)?$pageBar:"";?>
			</div>
		</div>
	<!-- 	<div class="load_but">
			<span>
				加载更多
			</span>
		</div> -->
	</div>
	<div class="list_right">
		<?php if(isset($data[0]['id'])){?>
		<div class="data_box quotation_top">
			<ul class="data_list addpic">
				<li class="title">
					<a href='javascript:;'><h3><?php echo isset($data[0]['name'])?$data[0]['name']:"";?></h3></a>
					<a href="http://info.nainaiwang.com//more/index/type/<?php echo isset($data[0]['id'])?$data[0]['id']:"";?>"><span>更多</span></a>
				</li>
				<?php if(!empty($data[0][0])) foreach($data[0][0] as $key => $item){?>
				<li>
					<a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>">
						<img src="<?php echo isset($item['cover'][0])?$item['cover'][0]:"";?>" title="新闻图片" class="list_news_pic">
					</a>
					<span class="list_news_title">
						<p>
							<a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
						</p>
						<p>
							<span class="time"><?php echo isset($item['create_time'])?$item['create_time']:"";?></span>
							<span class="count"><?php echo isset($item['collect_num'])?$item['collect_num']:"";?>次</span>
						</p>
					</span>
				</li>
				<?php }?>
			</ul>
		</div>
		<?php }?>
		<?php echo \Library\Ad::commonshow('more',0,1);?>
		<?php if(isset($data[1]['id'])){?>
		<div class="data_box">
			<ul class="data_list">
				<li class="title">
					<a href="javascript:;"><h3><?php echo isset($data[1]['name'])?$data[1]['name']:"";?></h3></a>
					<a href="http://info.nainaiwang.com//more/index/type/<?php echo isset($data[1]['id'])?$data[1]['id']:"";?>"><span>更多</span></a>
				</li>
				<?php if(!empty($data[1][0])) foreach($data[1][0] as $key => $item){?>
					<li><a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
				<?php }?>
			</ul>
		</div>
		<?php }?>
		<?php echo \Library\Ad::commonshow('more',1);?>
		
	</div>

</div>	



<!--公用底部控件 开始-->
<link href="/views/pc/css/footer.css" rel="stylesheet" type="text/css">
<div class="clear"></div>
<div id="footer">



    <div class="footer_link clearfix">
        <!-- <div class="foter_width">
            <ul>
                <?php if(!empty($helpList2)) foreach($helpList2 as $key => $item){?>
                    <li class="footer_li">
                        <a class="fotter_div" target="_blank"><b><?php echo isset($item['name'])?$item['name']:"";?></b></a>
                        <?php if(!empty($item['data'])) foreach($item['data'] as $k => $v){?>
                            <?php if($v['link']){?>
                                <a class="fotter_a" href="<?php echo isset($v['link'])?$v['link']:"";?>" target="_blank"><?php echo isset($v['name'])?$v['name']:"";?></a>

                            <?php }else{?>
                                <a class="fotter_a" href="http://info.nainaiwang.com//help/help?cat_id=<?php echo isset($v['cat_id'])?$v['cat_id']:"";?>&id=<?php echo isset($v['id'])?$v['id']:"";?>" target="_blank"><?php echo isset($v['name'])?$v['name']:"";?></a>

                            <?php }?>
                         <?php }?>
                    </li>
                <?php }?>

            </ul>
            <ul class="ewm_ul">
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注耐火频道</b></div>
                    <div><img src="/views/pc/images/index/a_naih.png"></div>
                </li>
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注耐耐网</b></div>
                    <div><img src="/views/pc/images/index/a_nain.png"></div>
                </li>
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注建材频道</b></div>
                    <div><img src="/views/pc/images/index/a_jianc.png"></div>
                </li>
            </ul>
        </div> -->
    </div>
    <div class="fotter_bq ">
        <div>
            Copyright&nbsp;&nbsp; © 2000-2015&nbsp;&nbsp;耐耐云商科技有限公司&nbsp;版权所有&nbsp;&nbsp; 网站备案/许可证号:沪ICP备15028925号
        </div>
        <div>
            服务电话：4006238086 地址:上海浦东新区唐镇上丰路977号b座
        </div>
        <div>
            增值电信业务经营许可证沪B2-20150196
        </div>
        <div>
            违法信息举报邮箱：shensu@nainaiwang.com
        </div>
        <div>
            技术支持：耐耐云商科技有限公司技术部
        </div>

            <!-- <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1260482243'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1260482243%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script> -->
    </div>

</div>




<!--公用底部控件 结束-->
</body>
</body>