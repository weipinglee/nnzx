
	<div class="clear"></div>
</div>
<div class="main">
	<div class="nav_top">您现在的位置：<a href="{url:/index/index}">首页</a>>行业</div>
	<div class="main_left">
		<div class="new_list quotation_margin_top">
			<div class="content_title clear">
			<ul class="content_title_ul">
				<li>
					<a class="title_a {if:$id==0}on{/if}" href="{url:/Hangye/index}/type/{$type_id}">全部
						<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
					</a>
				</li>
				{foreach:items=$cates}
				<li>
					<a class="title_a {if:$id==$item['id']}on{/if}" href="{url:/Hangye/index}/type/{$type_id}/id/{$item['id']}">{$item['name']}
						<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
					</a>
				</li>
				{/foreach}
			</ul>
		</div>
			{foreach:items=$main_data}
			<div class="news">
				{if:isset($item['cover'][0])}
					<img src="{$item['cover'][0]}" class="news_pic">
					<div class="news_content">
						<h3>
							<a href="{url:/Hangye/index}/type/{$item['type']}/id/{$item['cate_id']}"><span class="trade">{$item['cate_name']}</span></a>
							<a href="{url:/Detail/index}/id/{$item['id']}"><span class="title">{$item['name']}</span></a><!-- 标题处后台需限制输入字数 -->
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
							<a href="{url:/Hangye/index}/type/{$item['type']}/id/{$item['cate_id']}"><span class="trade">{$item['cate_name']}</span></a>
							<a href="{url:/Detail/index}/id/{$item['id']}"><span class="title">{$item['name']}</span></a><!-- 标题处后台需限制输入字数 -->
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
					<a href="javascript:;"><h3>{$type[0]['name']}</h3></a>
					<a href="{url:/more/index}/type/{$data[0][0]['type']}"><span>更多</span></a>
				</li>
				{foreach:items=$data[0]}
				<li>
					<a href="{url:/detail/index}/id/{$item['id']}">
						<img src="{$item['cover'][0]}" title="新闻图片" class="list_news_pic">
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
		{echo:\Library\Ad::commonshow('hangye',0,1)}
		<div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href="javascript:;"><h3>{$type[1]['name']}</h3></a>
					<a href="{url:/more/index}/type/{$data[1][0]['type']}"><span>更多</span></a>
				</li>
				{foreach:items=$data[1]}
				<li>
					<a href="{url:/detail/index}/id/{$item['id']}">
						<img src="{$item['cover'][0]}" title="新闻图片" class="list_news_pic">
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
		{echo:\Library\Ad::commonshow('hangye',1)}
		
	</div>

</div>	


