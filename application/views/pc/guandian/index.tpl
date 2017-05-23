
	<div class="clear"></div>
</div>
<div class="main">
	
	<div class="main_left">
	<p class="position">您现在的位置： <a href="{url:/index/index}">首页</a>&nbsp;>&nbsp;观点</p>
		<!-- 轮播代码 -->
		
		{echo:\nainai\system\slide::combineShow('pcguandian')}
		<script type="text/javascript">

		</script>
		<div class="clear"></div>
		<!-- 轮播代码 -->
		<div class="new_list">
			{foreach:items=$data}
				<div class="news first">
					{if:isset($item['cover'][0])}
						<img src="{$item['cover'][0]}" class="news_pic">
						<div class="news_content">
							<h3>
								<a href="{url:/More/index}/type/{$item['type']}/id/{$item['cate_id']}"><span class="trade">{$item['cate_name']}</span></a>
								<a href="{url:/detail/index}/id/{$item['id']}"><span class="title">{$item['name']}</span></a><!-- 标题处后台需限制输入字数 -->
							</h3>
							<!-- 程序能否控制这里输出的字数，最后加个省略号 -->
							<p>{$item['short_content']}</p>
							<p class="author">
								<img src="{views:images/20170123161308.jpg}" class="head_pic">
								<span class="time">{$item['create_time']}</span>
								<span class="count">{$item['collect_num']}次</span>
								
							</p>

						</div>
					{else:}
						<div class="news_content no_pic">
							<h3>
								<a href="{url:/More/index}/type/{$item['type']}/id/{$item['cate_id']}"><span class="trade">{$item['cate_name']}</span></a>
								<a href="{url:/detail/index}/id/{$item['id']}"><span class="title">{$item['name']}</span></a><!-- 标题处后台需限制输入字数 -->
							</h3>
							<!-- 程序能否控制这里输出的字数，最后加个省略号 -->
							<p>{$item['short_content']}</p>
							<p class="author">
								<img src="{views:images/20170123161308.jpg}" class="head_pic">
								<span class="time">{$item['create_time']}</span>
								<span class="count">{$item['collect_num']}次</span>
								
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
				<div class="news_top_img"><img src="{views:images/nnzx.png}"/></div>
				<div class="news_top_right">
					<h3>耐耐资讯</h3>
					<p>浏览量：525212次</p>
					<p>文&nbsp;&nbsp;&nbsp;章：15236条</p>
				</div>
			</div>
			<div class="news_mail">
				<a class="mail_infor">投稿邮箱：nnw@nainaiwang.com</a>
			</div>
		</div>
		
		<div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href="#"><h3>推荐文章</h3></a>
					<!-- <a href><span>更多</span></a> -->
				</li>
				{foreach:items=$recommend_list}
					<li>
						<a href>
							<img src="{$item['cover_pic']}" title="新闻图片" class="list_news_pic">
						</a>
						<span class="list_news_title">
							<p>
								<a href="{url:/detail/index}/id/{$item['id']}">{$item['name']}</a>
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


