
	<div class="clear"></div>
</div>
<div class="main">
	<div class="nav_top">您现在的位置：<a>首页</a>><a>搜索</a></div>
	<div class="main_left">
		<div class="new_list quotation_margin_top">
			<div class="search_result">搜索：<span class="color_c">{$keyword}</span></div>
			<!-- <div class="content_title clear">
				<ul class="content_title_ul">
					<li>
						<a class="title_a on">全部
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">建材行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">钢铁行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">冶金化工
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">耐火行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">设备行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
					<li>
						<a class="title_a">其他行业
							<div class="c-tip-arrow" style="left: 38px;"><em></em></div>
						</a>
					</li>
				</ul>
			</div> -->
			{foreach:items=$list}
				<div class="news">
					{if:isset($item['cover'][0])}
						<img src="images/20170123161308.jpg" class="news_pic">
						<div class="news_content">
							<h3>
								<a href="{url:/Hangye/index}/type/{$type_id}/id/{$item['cate_id']}"><span class="trade">{$item['cate_name']}</span></a>
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
								<a href="{url:/Hangye/index}/type/{type_id}/id/{$item['cate_id']}"><span class="trade">{$item['cate_name']}</span></a>
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
		<div class="data_box search_top">
			<h3 class="serch_hot">热门搜索</h3>
			<div class="search_word clear">
				{foreach:items=$keywords}<a href="{url:/search/index}/keyword/{$item['name']}">{$item['name']}</a>{/foreach}
			</div>
		</div>
		<!-- <div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href><h3>热门咨询</h3></a>
					<a href><span>更多</span></a>
				</li>
				<li>
					<a href>
						<img src="images/ad.png" title="新闻图片" class="list_news_pic">
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
						<img src="images/ad.png" title="新闻图片" class="list_news_pic">
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
						<img src="images/ad.png" title="新闻图片" class="list_news_pic">
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
		</div> -->
		{echo:\Library\Ad::commonshow('search')}
		
	</div>

</div>	


