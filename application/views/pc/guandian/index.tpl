

	<div class="in_nav" id="in_nav">
		<ul>
			<img src="{views:images/nav_top.png}" class="in_nav_top">
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
	<p class="position">您现在的位置： <a href="{url:/index/index}">首页</a>&nbsp;>&nbsp;观点</p>
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

				{foreach:items=$slides}
				<a href="#" target="_blank"><img src="{$item['img']}" title="{$item['name']}" alt="{$item['name']}"/></a> 
				{/foreach}
			</div>

		</div>
		<!-- 轮播代码 -->
		<div class="new_list">
			{foreach:items=$data}
				<div class="news first">
					{if:isset($item['cover'][0])}
						<img src="{$item['cover'][0]}" class="news_pic">
						<div class="news_content">
							<h3>
								<a href><span class="trade">{$item['cate_name']}</span></a>
								<a href><span class="title">{$item['name']}</span></a><!-- 标题处后台需限制输入字数 -->
							</h3>
							<!-- 程序能否控制这里输出的字数，最后加个省略号 -->
							<p>{$item['short_content']}</p>
							<p class="author">
								<img src="{views:images/20170123161308.jpg}" class="head_pic">
								<span class="time">{$item['create_time']}</span>
								<span class="count">{$item['collect_num']}次</span>
								<span class="share">
									
								</span>
							</p>

						</div>
					{else:}
						<div class="news_content no_pic">
							<h3>
								<a href><span class="trade">{$item['cate_name']}</span></a>
								<a href><span class="title">{$item['name']}</span></a><!-- 标题处后台需限制输入字数 -->
							</h3>
							<!-- 程序能否控制这里输出的字数，最后加个省略号 -->
							<p>{$item['short_content']}</p>
							<p class="author">
								<img src="{views:images/20170123161308.jpg}" class="head_pic">
								<span class="time">{$item['create_time']}</span>
								<span class="count">{$item['collect_num']}次</span>
								<span class="share">
									
								</span>
							</p>

						</div>
					{/if}
				</div>
			{/foreach}
			<div class="page">
				{$pageBar}
			</div>
		</div>
	</div>
	<div class="list_right">
		<div class="data_box news">
			<div class="news_top clear">
				<div class="news_top_img"><img src="{views:images/ad.png}"/></div>
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
				{foreach:items=$recommend_list}
					<li>
						<a href>
							<img src="{$item['cover'][0]}" title="新闻图片" class="list_news_pic">
						</a>
						<span class="list_news_title">
							<p>
								<a href>{$item['name']}</a>
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
		{echo:\Library\Ad::commonshow('guandian')}
	</div>

</div>	


