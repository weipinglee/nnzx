

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
		<p class="position">您现在的位置： <a href="{url:/index/index}">首页</a>&nbsp;>&nbsp;数据</p>
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
		{foreach:items=$type}
			<div class="data_list">
				<div class="data_title">
					<a href><h1>{$item['name']}</h1></a>
					<a href="{url:/more/index}/type/{$item['id']}"><span>更多</span></a>
				</div>
				<div class="data_content">
					<div class="hot_news">
						<a href><img src="{$data[$item['id']][0][0]['cover'][0]}"></a>
						<div class="hot_point">
							<a href>{$data[$item['id']][0][0]['name']}</a>
						</div>
					</div>
					<ul>
						{if:isset($data[$item['id']][0][1]['id'])}
						<li>
							<a href><img src="{$data[$item['id']][0][1]['cover'][0]}" title="{$data[$item['id']][0][1]['name']}" class="list_hot"></a>
							<span class="list_hot_cont">
								<!-- 此处需要控制字数 -->
								<p><a href>{$data[$item['id']][0][1]['name']}</a></p>
								<p><a href>{$data[$item['id']][0][1]['short_content']}</a></p>
							</span>
						</li>
						{/if}
						{foreach:items=$data[$item['id']][0]}
							{if:$key>1&&$key<6}
							<li><a href>{$item['name']}</a></li>
							{/if}
						{/foreach}
					</ul>
				</div>
			</div>
		{/foreach}
	</div>
	<div class="list_right" style="margin-top:24px;">
		<div class="data_box">
			<ul class="data_list">
				<li class="title">
					<a href><h3>数据</h3></a>
					<a href><span>更多</span></a>
				</li>
				{foreach:items=$main_data[0]}
				<li><a href="{url:/Detail/index}/id/{$item['id']}">{$item['name']}</a></li>
				{/foreach}
			</ul>
		</div>
		{echo:\Library\Ad::commonshow('shuju')}
		
	</div>

</div>	

