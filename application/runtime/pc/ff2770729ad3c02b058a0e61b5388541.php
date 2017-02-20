<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>资讯中心</title>


    <script src="/nnzx/views/pc/js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
    <script src="/nnzx/views/pc/js/new-slide.js" type="text/javascript" language="javascript"></script>
    <script src="/nnzx/views/pc/js/style.js" type="text/javascript" language="javascript"></script>
    <script src="/nnzx/views/pc/js/new-nav.js" type="text/javascript" language="javascript"></script>
    <link rel="stylesheet" type="text/css" href="/nnzx/views/pc/css/new-style.css">
</head>
<body>



<body>
<div class="header">
    <div class="content">
        <div class="logo"></div>
        <ul class="nav">
            <li><a href='http://localhost/nnzx//index/index' <?php if($type_id == 0){?>class='on'<?php }?>>首页</a></li>
            <li id="industry"><a href='http://localhost/nnzx//hangye/index/type/<?php echo isset($typelist[0]['id'])?$typelist[0]['id']:"";?>' <?php if($type_id ==$typelist[0]['id']){?>class="on"<?php }?>>行业</a></li>

            <li><a href="http://localhost/nnzx//shuju/index/type/<?php echo isset($typelist[1]['id'])?$typelist[1]['id']:"";?>" <?php if($type_id == $typelist[1]['id']){?>class="on"<?php }?>>数据</a></li>
            <li><a href='http://localhost/nnzx//guandian/index/type/<?php echo isset($typelist[2]['id'])?$typelist[2]['id']:"";?>' <?php if($type_id == $typelist[2]['id']){?>class="on"<?php }?>>观点</a></li>
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
                window.location.href = "http://localhost/nnzx//search/index/keyword/"+k;
            });
        })
    </script>
    
    <div class="in_nav" id="in_nav">
        <ul>
            <img src="/nnzx/views/pc/images/nav_top.png" class="in_nav_top">

            <?php if(!empty($cates)) foreach($cates as $key => $item){?>
            <li>
                <a class="title_a" href="http://localhost/nnzx//hangye/index/type/3/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?>
                    <div class="c-tip-arrow" style="left: 38px;"><em></em></div>
                </a>
            </li>
            <?php }?>
            <!-- <li class="industry1"><a href>建材行业</a></li> -->
        </ul>
    </div>

	<div class="clear"></div>
</div>
<div class="main">
	<div class="nav_top">您现在的位置：<a>首页</a>><a>搜索</a></div>
	<div class="main_left">
		<div class="new_list quotation_margin_top">
			<div class="search_result">搜索：<span class="color_c"><?php echo isset($keyword)?$keyword:"";?></span></div>
			<!-- <div class="content_title clear">
				<ul class="content_title_ul">
					<li>
						<a class="title_a on">全部
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">建材行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">钢铁行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">冶金化工
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">耐火行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">设备行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">其他行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
				</ul>
			</div> -->
			<?php if(!empty($list)) foreach($list as $key => $item){?>
				<div class="news">
					<?php if(isset($item['cover'][0])){?>
						<img src="images/20170123161308.jpg" class="news_pic">
						<div class="news_content">
							<h3>
								<a href="http://localhost/nnzx//hangye/index/type/<?php echo isset($type)?$type:"";?>/id/<?php echo isset($item['cate_id'])?$item['cate_id']:"";?>"><span class="trade"><?php echo isset($item['cate_name'])?$item['cate_name']:"";?></span></a>
								<a href="http://localhost/nnzx//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><span class="title"><?php echo isset($item['name'])?$item['name']:"";?></span></a><!-- 标题处后台需限制输入字数 -->
							</h3>
							<!-- 程序能否控制这里输出的字数，最后加个省略号 -->
							<p><?php echo isset($item['short_content'])?$item['short_content']:"";?></p>
							<p class="author">
								<img src="/nnzx/views/pc/images/20170123161308.jpg" class="head_pic">
								<span class="time"><?php echo isset($item['create_time'])?$item['create_time']:"";?></span>
								<span class="count"><?php echo isset($item['collect_num'])?$item['collect_num']:"";?>次</span>
								<span class="share">
									
								</span>
							</p>

						</div>
					<?php }else{?>
						<div class="news_content no_pic">
							<h3>
								<a href="http://localhost/nnzx//hangye/index/type/<?php echo isset($type)?$type:"";?>/id/<?php echo isset($item['cate_id'])?$item['cate_id']:"";?>"><span class="trade"><?php echo isset($item['cate_name'])?$item['cate_name']:"";?></span></a>
								<a href="http://localhost/nnzx//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><span class="title"><?php echo isset($item['name'])?$item['name']:"";?></span></a><!-- 标题处后台需限制输入字数 -->
							</h3>
							<!-- 程序能否控制这里输出的字数，最后加个省略号 -->
							<p><?php echo isset($item['short_content'])?$item['short_content']:"";?></p>
							<p class="author">
								<img src="/nnzx/views/pc/images/20170123161308.jpg" class="head_pic">
								<span class="time"><?php echo isset($item['create_time'])?$item['create_time']:"";?></span>
								<span class="count"><?php echo isset($item['collect_num'])?$item['collect_num']:"";?>次</span>
								<span class="share">
									
								</span>
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
		<div class="data_box search_top">
			<h3 class="serch_hot">热门搜索</h3>
			<div class="search_word clear">
				<?php if(!empty($keywords)) foreach($keywords as $key => $item){?><a href="http://localhost/nnzx//search/index/keyword/<?php echo isset($item['name'])?$item['name']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a><?php }?>
			</div>
		</div>
		<!-- <div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href><h3>热门咨询</h3></a>
					<a href><span>更多</span></a>
				</li>
				<li>
					<a href>
						<img src="images/ad.png" title="新闻图片" class="list_news_pic">
					</a>
					<span class="list_news_title">
						<p>
							<a href>福州制造业税收见涨高端制造业表现抢眼</a>
						</p>
						<p>
							<span class="time">2016-12-13</span>
							<span class="count">225次</span>
						</p>
					</span>
				</li>
				<li>
					<a href>
						<img src="images/ad.png" title="新闻图片" class="list_news_pic">
					</a>
					<span class="list_news_title">
						<p>
							<a href>福州制造业税收见涨高端制造业表现抢眼</a>
						</p>
						<p>
							<span class="time">2016-12-13</span>
							<span class="count">225次</span>
						</p>
					</span>
				</li>
				<li>
					<a href>
						<img src="images/ad.png" title="新闻图片" class="list_news_pic">
					</a>
					<span class="list_news_title">
						<p>
							<a href>福州制造业税收见涨高端制造业表现抢眼</a>
						</p>
						<p>
							<span class="time">2016-12-13</span>
							<span class="count">225次</span>
						</p>
					</span>
				</li>
			</ul>
		</div> -->
		<?php echo \Library\Ad::commonshow('search');?>
		
	</div>

</div>	



</body>

</html>