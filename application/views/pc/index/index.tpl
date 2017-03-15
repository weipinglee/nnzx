
	<div class="clear"></div>
</div>
<div class="main clear">
	
	<div class="main_left">
		<!-- 轮播代码 -->
		
		 {echo:\nainai\system\slide::combineShow('pchome')}
		<script type="text/javascript">

		</script>
		<div class="clear"></div>
		<!-- 轮播代码 -->
		<div class="new_list">
			{foreach:items=$main_data[0]}
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
							
							</p>
						
						</div>
					{/if}
				</div>
			{/foreach}
			<div class="page">
			<span>
				{$main_data[1]}
			</span>
			</div>
		</div>
	</div>
	<div class="list_right">
		<div class="data_box">
			<ul class="data_list">
				<li class="title">
					<a href><h3>{$data[2]['name']}</h3></a>
					<a href="{url:/More/index}/type/{$data[2]['id']}"><span>更多</span></a>
				</li>
				{foreach:items=$data[2][0]}
				<li><a href="{url:/Detail/index}/id/{$item['id']}">{$item['name']}</a></li>
				{/foreach}
			</ul>
		</div>
		<div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href><h3>{$data[1]['name']}</h3></a>
					<a href="{url:/More/index}/type/{$data[1]['id']}"><span>更多</span></a>
				</li>
				{foreach:items=$data[1][0]}
				<li>
					<a href="{url:/Detail/index}/id/{$item['id']}">
						<img src="{$item['cover_pic']}" title="新闻图片" class="list_news_pic">
					</a>
					<span class="list_news_title">
						<p>
							<a href="{url:/Detail/index}/id/{$item['id']}">{$item['name']}</a>
						</p>
						<p>
							<span class="time">2016-12-13</span>
							<span class="count">225次</span>
						</p>
					</span>
				</li>
				{/foreach}
			</ul>
		</div>
		
		{echo:\Library\Ad::commonshow('index')}
		<div class="data_box">
			<ul class="data_list">
				<li class="title">
					<a href><h3>{$data[0]['name']}</h3></a>
					<a href="{url:/More/index}/type/{$data[0]['id']}"><span>更多</span></a>
				</li>
				{foreach:items=$data[0][0]}
				<li><a href="{url:/Detail/index}/id/{$item['id']}">{$item['name']}</a></li>
				{/foreach}
			</ul>
		</div>
		<div class="data_box marig-top ">
			<ul class="data_list addpic">
				<li class="title">
					<a href="javascript:;"><h3>品牌企业</h3></a>
					<!-- <a href><span>更多</span></a> -->
				</li>
			</ul>
			{echo:\Library\Ad::combineshow('index_firm')}
		</div>
	</div>

</div>
<!-- 底部 strat -->	


