
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no minimal-ui"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="white">
<meta name="baidu-tc-cerfication" content="e08afafaa2ad8ee624b1d14e86f076b0" />
<link rel="apple-touch-icon-precomposed" href=http://wap.baidu.com/static/img/webapp/img/icon_114.png/>
<meta name="apple-itunes-app" content="app-id=869266629, app-argument=mlj://" />
<link href="/nnzx/app/views///css/m1102.css" rel="stylesheet" />

<title>APP详情页</title>
</head>
<body>
<div id="main" class="wrapper" FullScreen="false">
<section id="staticpage" class="page current" style="display:block;">
    <!-- <div class="top-nav-box">
        <div class="top-nav">
            <a class="tnav-btn tnav-left tnav-back" href="#" onClick="backPage();return false;"></a>
            <span class="nav-title">耐耐资讯</span>
        </div>
    </div> -->
    <div class="main-body">
        <div class="body-scroll">
            <div class="settings">
                <div class="item userinfo">
                        <p class="nick"><?php echo isset($info['name'])?$info['name']:"";?></p>
                        <p class="location"><span class="author"><?php echo isset($info['author'])?$info['author']:"";?></span><span class="time"><?php echo isset($info['create_time'])?$info['create_time']:"";?></span></p>

                </div>
            </div>
            <div class="settings">
                <div class="item userinfo">
                    <!-- <img class="face" src="<?php echo isset($info['cover'][0])?$info['cover'][0]:"";?>" /> -->
                    <div class="info">
                        <?php echo isset($info['content'])?$info['content']:"";?>
                    </div>
                </div>
            </div>
            <div class="settings-space"></div>
            <div class="settings">
                <div class="item normal">
                    <span class="title">相关推荐</span>
                </div>
            </div>
            <div class="settings">
                <?php if(!empty($info['comArcList'])) foreach($info['comArcList'] as $key => $item){?>
                <a href="http://124.166.246.120:8000/nnzx/app/article/arcinfo/id/<?php echo isset($item['id'])?$item['id']:"";?>">
                    <div class="item userinfo">
                        <img class="little-face" src="<?php echo isset($item['cover'][0])?$item['cover'][0]:"";?>" />
                        <div class="info-title">
                            <p class="nick"><?php echo isset($item['name'])?$item['name']:"";?></p>
                            <p class="location"><span class="author"><?php echo isset($item['author'])?$item['author']:"";?></span><span class="time"><?php echo isset($item['create_time'])?$item['create_time']:"";?></span></p>
                        </div>
                    </div>
                </a>
                <?php }?>
            </div>
               
            <div style='margin-bottom:100px'></div>

</body>
</html>