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
            <li><a href='http://localhost/nnzx//index/index' class="on">首页</a></li>
            <li id="industry"><a href='http://localhost/nnzx//hangye/index/type/<?php echo isset($typelist[0]['id'])?$typelist[0]['id']:"";?>'>行业</a></li>
            <li><a href="http://localhost/nnzx//shuju/index/type/<?php echo isset($typelist[1]['id'])?$typelist[1]['id']:"";?>">数据</a></li>
            <li><a href='http://localhost/nnzx//guandian/index/type/<?php echo isset($typelist[2]['id'])?$typelist[2]['id']:"";?>'>观点</a></li>
        </ul>
        <form class="search">
            <input type="text" value="请输入关键字查询" class="text"><input type="button" value="搜索" class="button">
        </form>
    </div>




	<div class="in_nav" id="in_nav">
		<ul>
			<img src="/nnzx/views/pc/images/nav_top.png" class="in_nav_top">
			<li class="industry1"><a href>建材行业</a></li>
			<li class="industry2"><a href>耐火行业</a></li>
			<li class="industry3"><a href>钢铁行业</a></li>
			<li class="industry4"><a href>冶金化工行业</a></li>
			<li class="industry5"><a href>设备行业</a></li>
			<li class="industry6"><a href>其他行业</a></li>
		</ul>
	</div>
	<div class="clear"></div>
</div>
<div class="main">
	
	<div class="main_left">
	<p class="position">您现在的位置： <a href="http://localhost/nnzx//index/index">首页</a>&nbsp;>&nbsp;观点</p>
		<!-- 轮播代码 -->
		<div id="banner">

			<div id="banner_bg"></div>

			<!--标题背景-->

			<div id="banner_info"></div>

			<!--标题-->

			<ul>
				<li class="on"></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>

			<div id="banner_list"> 

				<?php if(!empty($slides)) foreach($slides as $key => $item){?>
				<a href="#" target="_blank"><img src="<?php echo isset($item['img'])?$item['img']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>"/></a> 
				<?php }?>
			</div>

		</div>
		<!-- 轮播代码 -->
		<div class="new_list">
			<?php if(!empty($data)) foreach($data as $key => $item){?>
				<div class="news first">
					<?php if(isset($item['cover'][0])){?>
						<img src="<?php echo isset($item['cover'][0])?$item['cover'][0]:"";?>" class="news_pic">
						<div class="news_content">
							<h3>
								<a href><span class="trade"><?php echo isset($item['cate_name'])?$item['cate_name']:"";?></span></a>
								<a href><span class="title"><?php echo isset($item['name'])?$item['name']:"";?></span></a><!-- 标题处后台需限制输入字数 -->
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
								<a href><span class="trade"><?php echo isset($item['cate_name'])?$item['cate_name']:"";?></span></a>
								<a href><span class="title"><?php echo isset($item['name'])?$item['name']:"";?></span></a><!-- 标题处后台需限制输入字数 -->
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
	</div>
	<div class="list_right">
		<div class="data_box news">
			<div class="news_top clear">
				<div class="news_top_img"><img src="/nnzx/views/pc/images/ad.png"/></div>
				<div class="news_top_right">
					<h3>耐耐咨讯</h3>
					<p>浏览量：525212次</p>
					<p>文&nbsp;&nbsp;&nbsp;章：15236条</p>
				</div>
			</div>
			<div class="news_mail">
				<a class="mail_infor">投稿邮箱：nnw@nainaiwang</a>
			</div>
		</div>
		
		<div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href><h3>推荐文章</h3></a>
					<a href><span>更多</span></a>
				</li>
				<?php if(!empty($recommend_list)) foreach($recommend_list as $key => $item){?>
					<li>
						<a href>
							<img src="<?php echo isset($item['cover'][0])?$item['cover'][0]:"";?>" title="新闻图片" class="list_news_pic">
						</a>
						<span class="list_news_title">
							<p>
								<a href><?php echo isset($item['name'])?$item['name']:"";?></a>
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
		<a href><img src="/nnzx/views/pc/images/ad.png" class="ad_box"></a>
		<a href><img src="/nnzx/views/pc/images/ad.png" class="ad_box"></a>
	</div>

</div>	



</body>

</html>