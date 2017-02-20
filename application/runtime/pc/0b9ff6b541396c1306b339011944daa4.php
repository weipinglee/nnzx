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
	<div class="nav_top">您现在的位置：<a href="http://localhost/nnzx//index/index">首页</a>>行业</div>
	<div class="main_left">
		<div class="new_list quotation_margin_top">
			<div class="content_title clear">
			<ul class="content_title_ul">
				<li>
					<a class="title_a <?php if($id==0){?>on<?php }?>" href="http://localhost/nnzx//hangye/index/type/<?php echo isset($type)?$type:"";?>">全部
						<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
					</a>
				</li>
				<?php if(!empty($cates)) foreach($cates as $key => $item){?>
				<li>
					<a class="title_a <?php if($id==$item['id']){?>on<?php }?>" href="http://localhost/nnzx//hangye/index/type/<?php echo isset($type)?$type:"";?>/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?>
						<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
					</a>
				</li>
				<?php }?>
			</ul>
		</div>
			<?php if(!empty($data)) foreach($data as $key => $item){?>
			<div class="news">
				<?php if(isset($item['cover'][0])){?>
					<img src="<?php echo isset($item['cover'][0])?$item['cover'][0]:"";?>" class="news_pic">
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
		<div class="data_box quotation_top">
			<ul class="data_list addpic">
				<li class="title">
					<a href><h3>下游信息</h3></a>
					<a href><span>更多</span></a>
				</li>
				<li>
					<a href>
						<img src="/nnzx/views/pc/images/ad.png" title="新闻图片" class="list_news_pic">
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
						<img src="/nnzx/views/pc/images/ad.png" title="新闻图片" class="list_news_pic">
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
						<img src="/nnzx/views/pc/images/ad.png" title="新闻图片" class="list_news_pic">
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
		</div>
		<a href><img src="/nnzx/views/pc/images/ad.png" class="ad_box"></a>
		<div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href><h3>展会动态</h3></a>
					<a href><span>更多</span></a>
				</li>
				<li>
					<a href>
						<img src="/nnzx/views/pc/images/ad.png" title="新闻图片" class="list_news_pic">
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
						<img src="/nnzx/views/pc/images/ad.png" title="新闻图片" class="list_news_pic">
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
						<img src="/nnzx/views/pc/images/ad.png" title="新闻图片" class="list_news_pic">
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
		</div>
		<a href><img src="/nnzx/views/pc/images/ad.png" class="ad_box"></a>
		<a href><img src="/nnzx/views/pc/images/ad.png" class="ad_box"></a>
		
	</div>

</div>	



</body>

</html>