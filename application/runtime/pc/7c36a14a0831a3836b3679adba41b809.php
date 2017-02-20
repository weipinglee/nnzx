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
        })
    </script>
    
    <div class="in_nav" id="in_nav">
        <ul>
            <img src="/views/pc/images/nav_top.png" class="in_nav_top">

            <?php if(!empty($cates)) foreach($cates as $key => $item){?>
            <li>
                <a class="title_a" href="http://info.nainaiwang.com//hangye/index/type/3/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?>
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
	
	<div class="main_left">
		<p class="position">您现在的位置： <a href="http://info.nainaiwang.com//index/index">首页</a>&nbsp;>&nbsp;数据</p>
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
					<a href="javascript:;"><h1><?php echo isset($item['name'])?$item['name']:"";?></h1></a>
					<a href="http://info.nainaiwang.com//more/index/type/<?php echo isset($data[$item['id']][0][0]['type'])?$data[$item['id']][0][0]['type']:"";?>"><span>更多</span></a>
				</div>
				<div class="data_content">
					<div class="hot_news">
						<a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($data[$item['id']][0][0]['id'])?$data[$item['id']][0][0]['id']:"";?>"><img src="<?php echo isset($data[$item['id']][0][0]['cover'][0])?$data[$item['id']][0][0]['cover'][0]:"";?>"></a>
						<div class="hot_point">
							<a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($data[$item['id']][0][0]['id'])?$data[$item['id']][0][0]['id']:"";?>"><?php echo isset($data[$item['id']][0][0]['name'])?$data[$item['id']][0][0]['name']:"";?></a>
						</div>
					</div>
					<ul>
						<?php if(isset($data[$item['id']][0][1]['id'])){?>
						<li>
							<a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($data[$item['id']][0][1]['id'])?$data[$item['id']][0][1]['id']:"";?>"><img src="<?php echo isset($data[$item['id']][0][1]['cover'][0])?$data[$item['id']][0][1]['cover'][0]:"";?>" title="<?php echo isset($data[$item['id']][0][1]['name'])?$data[$item['id']][0][1]['name']:"";?>" class="list_hot"></a>
							<span class="list_hot_cont">
								<!-- 此处需要控制字数 -->
								<p><a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($data[$item['id']][0][1]['id'])?$data[$item['id']][0][1]['id']:"";?>"><?php echo isset($data[$item['id']][0][1]['name'])?$data[$item['id']][0][1]['name']:"";?></a></p>
								<p><a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($data[$item['id']][0][1]['id'])?$data[$item['id']][0][1]['id']:"";?>"><?php echo isset($data[$item['id']][0][1]['short_content'])?$data[$item['id']][0][1]['short_content']:"";?></a></p>
							</span>
						</li>
						<?php }?>
						<?php if(!empty($data[$item['id']][0])) foreach($data[$item['id']][0] as $key => $item){?>
							<?php if($key>1&&$key<6){?>
							<li><a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
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
					<a href="javascript:;"><h3>数据</h3></a>
					<a href="http://info.nainaiwang.com//more/index/type/4"><span>更多</span></a>
				</li>
				<?php if(!empty($main_data[0])) foreach($main_data[0] as $key => $item){?>
				<li><a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
				<?php }?>
			</ul>
		</div>
		<?php echo \Library\Ad::commonshow('shuju');?>
		
	</div>

</div>	


</body>

</html>