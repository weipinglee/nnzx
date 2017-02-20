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

    
<style type="text/css">
	.news .news_content{width: 100%;min-height: 80px;}
	.main .main_left .new_list .first{height: 80px;}
	.news .news_content .title{font-size: 20px;font-weight: bold;}
	.bshare-custom.icon-medium-plus, .bshare-custom.icon-large{padding-left: 25px;}
</style>
	
	<div class="clear"></div>
</div>
<div class="main">
	<div class="nav_top">您现在的位置：<a>首页</a>><?php echo isset($info['type_name'])?$info['type_name']:"";?>><?php echo isset($info['cate_name'])?$info['cate_name']:"";?></div>
	<div class="main_left">
		<div class="new_list quotation_margin_top">
			
			<div class="news first">
				<div class="news_content">
					<h3>
						<a href><span class="trade"><?php echo isset($info['cate_name'])?$info['cate_name']:"";?></span></a>
						<a href><span class="title"><?php echo isset($info['name'])?$info['name']:"";?></span></a><!-- 标题处后台需限制输入字数 -->
					</h3>
					<p class="author">
						<img src="/views/pc/images/20170123161308.jpg" class="head_pic">
						<span class="time"><?php echo isset($info['create_time'])?$info['create_time']:"";?></span>
						<span class="count"><?php echo isset($info['collect_num'])?$info['collect_num']:"";?>次</span>
						<span style="left:300px;">
							作者：<?php echo isset($info['author'])?$info['author']:"";?>
						</span>
						<span style="left:450px;">
							关键字：<a href><?php echo isset($info['keywords_str'])?$info['keywords_str']:"";?></a>
						</span>
					</p>

				</div>
			</div>
			<div class="news_cont">
				<p>
					<?php echo isset($info['content'])?$info['content']:"";?>
				</p>
				<!-- 分享代码 -->
				<div class="bshare-custom icon-medium-plus"><div class="bsPromo bsPromo2"></div><a title="分享到" href="http://www.bShare.cn/" id="bshare-shareto" class="bshare-more">分享到</a><a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a><a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a><a title="分享到QQ空间" class="bshare-qzone" href="javascript:void(0);"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
				<p class="line"></p>
				<div class="jump">
					<p>
						上一篇：<a href="<?php echo isset($info['siblings']['pre']['href'])?$info['siblings']['pre']['href']:"";?>"><?php echo isset($info['siblings']['pre']['title'])?$info['siblings']['pre']['title']:"";?></a>
					</p>
					<p>
						下一篇：<a href="<?php echo isset($info['siblings']['next']['href'])?$info['siblings']['next']['href']:"";?>"><?php echo isset($info['siblings']['next']['title'])?$info['siblings']['next']['title']:"";?></a>
					</p>
				</div>
			</div>
			
		</div>
	</div>
	<div class="list_right">
		<div class="data_box search_top">
			<h3 class="serch_hot">热门搜索</h3>
			<div class="search_word clear">
				<?php if(!empty($keywords)) foreach($keywords as $key => $item){?><a href="http://info.nainaiwang.com//search/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a><?php }?>
			</div>
		</div>
		<div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href><h3>相关资讯</h3></a>
				</li>
				<?php if(!empty($info['comArcList'])) foreach($info['comArcList'] as $key => $item){?>
				<li>
					<a href="http://info.nainaiwang.com//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>">
						<img src="<?php echo isset($item['cover'][0])?$item['cover'][0]:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" class="list_news_pic">
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
		
		<?php echo \Library\Ad::commonshow('detail');?>
		
	</div>

</div>	



</body>

</html>