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
		<p class="position">您现在的位置： <a href="http://localhost/nnzx//index/index">首页</a>&nbsp;>&nbsp;数据</p>
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
		<?php if(!empty($type)) foreach($type as $key => $item){?>
			<div class="data_list">
				<div class="data_title">
					<a href><h1><?php echo isset($item['name'])?$item['name']:"";?></h1></a>
					<a href="http://localhost/nnzx//more/index/type/<?php echo isset($item['id'])?$item['id']:"";?>"><span>更多</span></a>
				</div>
				<div class="data_content">
					<div class="hot_news">
						<a href><img src="<?php echo isset($data[$item['id']][0][0]['cover'][0])?$data[$item['id']][0][0]['cover'][0]:"";?>"></a>
						<div class="hot_point">
							<a href><?php echo isset($data[$item['id']][0][0]['name'])?$data[$item['id']][0][0]['name']:"";?></a>
						</div>
					</div>
					<ul>
						<?php if(isset($data[$item['id']][0][1]['id'])){?>
						<li>
							<a href><img src="<?php echo isset($data[$item['id']][0][1]['cover'][0])?$data[$item['id']][0][1]['cover'][0]:"";?>" title="<?php echo isset($data[$item['id']][0][1]['name'])?$data[$item['id']][0][1]['name']:"";?>" class="list_hot"></a>
							<span class="list_hot_cont">
								<!-- 此处需要控制字数 -->
								<p><a href><?php echo isset($data[$item['id']][0][1]['name'])?$data[$item['id']][0][1]['name']:"";?></a></p>
								<p><a href><?php echo isset($data[$item['id']][0][1]['short_content'])?$data[$item['id']][0][1]['short_content']:"";?></a></p>
							</span>
						</li>
						<?php }?>
						<?php if(!empty($data[$item['id']][0])) foreach($data[$item['id']][0] as $key => $item){?>
							<?php if($key>1&&$key<6){?>
							<li><a href><?php echo isset($item['name'])?$item['name']:"";?></a></li>
							<?php }?>
						<?php }?>
					</ul>
				</div>
			</div>
		<?php }?>
	</div>
	<div class="list_right" style="margin-top:24px;">
		<div class="data_box">
			<ul class="data_list">
				<li class="title">
					<a href><h3>数据</h3></a>
					<a href><span>更多</span></a>
				</li>
				<?php if(!empty($main_data[0])) foreach($main_data[0] as $key => $item){?>
				<li><a href="http://localhost/nnzx//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
				<?php }?>
			</ul>
		</div>
		<a href><img src="/nnzx/views/pc/images/ad.png" class="ad_box"></a>
		
	</div>

</div>	


</body>

</html>