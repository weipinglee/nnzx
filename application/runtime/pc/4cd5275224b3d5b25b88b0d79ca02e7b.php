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
            <li><a href='http://localhost/nnzx//index/index' <?php if($type_id == 0){?>class='on'<?php }?>>首页</a></li>
            <li id="industry"><a href='http://localhost/nnzx//hangye/index/type/<?php echo isset($typelist[0]['id'])?$typelist[0]['id']:"";?>' <?php if($type_id ==$typelist[0]['id']){?>class="on"<?php }?>>行业</a></li>

            <li><a href="http://localhost/nnzx//shuju/index/type/<?php echo isset($typelist[1]['id'])?$typelist[1]['id']:"";?>" <?php if($type_id == $typelist[1]['id']){?>class="on"<?php }?>>数据</a></li>
            <li><a href='http://localhost/nnzx//guandian/index/type/<?php echo isset($typelist[2]['id'])?$typelist[2]['id']:"";?>' <?php if($type_id == $typelist[2]['id']){?>class="on"<?php }?>>观点</a></li>
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
                window.location.href = "http://localhost/nnzx//search/index/keyword/"+k;
            });
            $('.search .text').keydown(function(e){
                if(e.keyCode == 13){
                    e.preventDefault();
                    var k = $(this).val();
                    if(k != '' && k != '请输入关键字查询')
                        window.location.href = "http://localhost/nnzx//search/index/keyword/"+k;
                    return;
                }
            });
        })
    </script>
    
    <div class="in_nav" id="in_nav">
        <ul>
            <img src="/nnzx/views/pc/images/nav_top.png" class="in_nav_top">

            <?php if(!empty($cates)) foreach($cates as $key => $item){?>
            <li>
                <img src="<?php echo isset($item['img'])?$item['img']:"";?>"/>
                <a class="title_a" href="http://localhost/nnzx//hangye/index/type/3/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?>
                    <!-- <div class="c-tip-arrow" style="left: 38px;"><em></em></div> -->
                </a>
            </li>
            <?php }?>
            <!-- <li class="industry1"><a href>建材行业</a></li> -->
        </ul>
    </div>
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
						<img src="/nnzx/views/pc/images/20170123161308.jpg" class="head_pic">
						<span class="time"><?php echo isset($info['create_time'])?$info['create_time']:"";?></span>
						<span class="count"><?php echo isset($info['collect_num'])?$info['collect_num']:"";?>次</span>
						<span style="left:300px;">
							作者：<?php echo isset($info['author'])?$info['author']:"";?>
						</span>
						<span style="left:450px;">
							关键字：<a href><?php echo isset($info['ori_keywords'])?$info['ori_keywords']:"";?></a>
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
				<?php if(!empty($keywords)) foreach($keywords as $key => $item){?><a href="http://localhost/nnzx//search/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a><?php }?>
			</div>
		</div>
		<div class="data_box">
			<ul class="data_list addpic">
				<li class="title">
					<a href><h3>相关资讯</h3></a>
				</li>
				<?php if(!empty($info['comArcList'])) foreach($info['comArcList'] as $key => $item){?>
				<li>
					<a href="http://localhost/nnzx//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>">
						<img src="<?php echo isset($item['cover'][0])?$item['cover'][0]:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" class="list_news_pic">
					</a>
					<span class="list_news_title">
						<p>
							<a href="http://localhost/nnzx//detail/index/id/<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
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




<!--公用底部控件 开始-->
<link href="/nnzx/views/pc/css/footer.css" rel="stylesheet" type="text/css">
<div class="clear"></div>
<div id="footer">



    <div class="footer_link clearfix">
        <!-- <div class="foter_width">
            <ul>
                <?php if(!empty($helpList2)) foreach($helpList2 as $key => $item){?>
                    <li class="footer_li">
                        <a class="fotter_div" target="_blank"><b><?php echo isset($item['name'])?$item['name']:"";?></b></a>
                        <?php if(!empty($item['data'])) foreach($item['data'] as $k => $v){?>
                            <?php if($v['link']){?>
                                <a class="fotter_a" href="<?php echo isset($v['link'])?$v['link']:"";?>" target="_blank"><?php echo isset($v['name'])?$v['name']:"";?></a>

                            <?php }else{?>
                                <a class="fotter_a" href="http://localhost/nnzx//help/help?cat_id=<?php echo isset($v['cat_id'])?$v['cat_id']:"";?>&id=<?php echo isset($v['id'])?$v['id']:"";?>" target="_blank"><?php echo isset($v['name'])?$v['name']:"";?></a>

                            <?php }?>
                         <?php }?>
                    </li>
                <?php }?>

            </ul>
            <ul class="ewm_ul">
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注耐火频道</b></div>
                    <div><img src="/nnzx/views/pc/images/index/a_naih.png"></div>
                </li>
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注耐耐网</b></div>
                    <div><img src="/nnzx/views/pc/images/index/a_nain.png"></div>
                </li>
                <li class="ewm_li">
                    <div class="fotter_div" target="_blank"><b>关注建材频道</b></div>
                    <div><img src="/nnzx/views/pc/images/index/a_jianc.png"></div>
                </li>
            </ul>
        </div> -->
    </div>
    <div class="fotter_bq ">
        <div>
            Copyright&nbsp;&nbsp; © 2000-2015&nbsp;&nbsp;耐耐云商科技有限公司&nbsp;版权所有&nbsp;&nbsp; 网站备案/许可证号:沪ICP备15028925号
        </div>
        <div>
            服务电话：4006238086 地址:上海浦东新区唐镇上丰路977号b座
        </div>
        <div>
            增值电信业务经营许可证沪B2-20150196
        </div>
        <div>
            违法信息举报邮箱：shensu@nainaiwang.com
        </div>
        <div>
            技术支持：耐耐云商科技有限公司技术部
        </div>

            <!-- <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1260482243'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1260482243%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script> -->
    </div>

</div>




<!--公用底部控件 结束-->
</body>
</body>