
    
<style type="text/css">
	.news .news_content{width: 100%;min-height: 80px;}
	.main .main_left .new_list .first{height: 80px;}
	.news .news_content .title{font-size: 20px;font-weight: bold;}
	.bshare-custom.icon-medium-plus, .bshare-custom.icon-large{padding-left: 25px;}
</style>
	<div class="in_nav" id="in_nav">
		<ul>
			<img src="images/nav_top.png" class="in_nav_top">
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
	<div class="nav_top">您现在的位置：<a>首页</a>>{$info['type_name']}>{$info['cate_name']}</div>
	<div class="main_left">
		<div class="new_list quotation_margin_top">
			
			<div class="news first">
				<div class="news_content">
					<h3>
						<a href><span class="trade">{$info['cate_name']}</span></a>
						<a href><span class="title">{$info['name']}</span></a><!-- 标题处后台需限制输入字数 -->
					</h3>
					<p class="author">
						<img src="{views:images/20170123161308.jpg}" class="head_pic">
						<span class="time">{$info['create_time']}</span>
						<span class="count">{$info['collect_num']}次</span>
						<span style="left:300px;">
							作者：{$info['author']}
						</span>
						<span style="left:450px;">
							关键字：<a href>{$info['keywords_str']}</a>
						</span>
					</p>

				</div>
			</div>
			<div class="news_cont">
				<p>
					{$info['content']}
				</p>
				<!-- 分享代码 -->
				<div class="bshare-custom icon-medium-plus"><div class="bsPromo bsPromo2"></div><a title="分享到" href="http://www.bShare.cn/" id="bshare-shareto" class="bshare-more">分享到</a><a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a><a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a><a title="分享到QQ空间" class="bshare-qzone" href="javascript:void(0);"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
				<p class="line"></p>
				<div class="jump">
					<p>
						上一篇：<a href="{$info['siblings']['pre']['href']}">{$info['siblings']['pre']['title']}</a>
					</p>
					<p>
						下一篇：<a href="{$info['siblings']['next']['href']}">{$info['siblings']['next']['title']}</a>
					</p>
				</div>
			</div>
			
		</div>
	</div>
	<div class="list_right">
		<div class="data_box search_top">
			<h3 class="serch_hot">热门搜索</h3>
			<div class="search_word clear">
				{foreach:items=$keywords}<a href="{url:/search/index}/id/{$item['id']}">{$item['name']}</a>{/foreach}
			</div>
		</div>
		<div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href><h3>相关资讯</h3></a>
				</li>
				{foreach:items=$info['comArcList']}
				<li>
					<a href="{url:/Detail/index}/id/{$item['id']}">
						<img src="{$item['cover'][0]}" title="{$item['name']}" class="list_news_pic">
					</a>
					<span class="list_news_title">
						<p>
							<a href="{url:/Detail/index}/id/{$item['id']}">{$item['name']}</a>
						</p>
						<p>
							<span class="time">{$item['create_time']}</span>
							<span class="count">{$item['collect_num']}次</span>
						</p>
					</span>
				</li>
				{/foreach}
			</ul>
		</div>
		
		{echo:\Library\Ad::commonshow('detail')}
		
	</div>

</div>	


