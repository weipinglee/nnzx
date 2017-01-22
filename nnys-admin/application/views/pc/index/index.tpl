<!DOCTYPE html>
<html>
 <head>
        <title>交易管理后台</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="x-ua-compatible" content="IE=edge" >

        
        <!-- jQuery AND jQueryUI -->
     <script type="text/javascript" src="{root:js/jquery/jquery-1.7.2.min.js}"></script>

     <script type="text/javascript" src="{views:js/libs/jqueryui/1.8.13/jquery-ui.min.js}"></script>
     <script type="text/javascript" src="{views:js/layer/layer.js}"></script>
        <link rel="stylesheet" href="{views:css/min.css}" />
        <script type="text/javascript" src="{views:js/min.js}"></script>
        <style type="text/css">
            html { overflow-y:hidden; }
        </style>
        
    </head>
    <body>
        
        <script type="text/javascript" src="{views:content/settings/main.js}"></script>
		  <script type="text/javascript">
		  $(function(){
		      var h = $(window).height() -42;
		      $('iframe').attr('height',h+'px');
		  })
		  
		  
		</script>
<link rel="stylesheet" href="{views:content/settings/style.css}" />
        <div id="head">
            <div class="left">
                <a href="#" class="button profile"><img src="{views:img/icons/top/huser.png}" alt="" /></a>
                {$info['role']}
                <a href="#">{$info['name']}</a>
                |
                <a href="{url:/login/logout}">退出</a>
                <a href="{url:/index/index@deal}">返回网站首页</a>
                <a name='clearCache' href="javascript:void(0)" onclick="clearCache('{url:/index/clearCache}')">清除缓存</a>
                <a name='clearCache' href="{url:system/admin/comadminPwd?id=$info['id']}" target="content">修改密码</a>

            </div>
          <!--   <div class="right">
                <form action="#" id="search" class="search placeholder">
                    <label>查找</label>
                    <input type="text" value="" name="q" class="text"/>
                    <input type="submit" value="rechercher" class="submit"/>
                </form>
            </div> -->
        </div>
                
                
        <!--            
                SIDEBAR
                         --> 
        <div id="sidebar">
            <ul>
                <li>
                    <a href="#" no_access='no_access'>
                        <img src="{views:img/icons/menu/inbox.png}" alt="" />
                        耐耐网后台管理系统
                    </a>
                </li>
                <li class="current"><a target="content"><img src="{views:img/icons/menu/layout.png}" alt="" />系统管理</a>
                    <ul>
                        <li class="current"><a target="content">权限管理</a>
                            <ul>
                                <li><a href="{url:system/rbac/roleList}" target="content">管理员分组</a></li>
                                <li><a href="{url:system/rbac/accessList}" target="content">权限分配</a></li>
                            </ul>
                        </li>
                        <li><a target="content">系统配置项</a>
                            <ul>
                                <li><a href="{url:system/Confsystem/creditList}" target="content">信誉值配置列表</a></li>
                                <li><a href="{url:system/Confsystem/scaleOfferOper}" target="content">报盘费率设置</a></li>
                                <li><a href="{url:system/Confsystem/entrustList}" target="content">委托费率设置</a></li>
                                <li><a href="{url:system/Confsystem/generalList}" target="content">一般设置</a></li>
                                <li><a href="{url:system/Confsystem/productset}" target="content">商品排序设置</a></li>
                            </ul>
                        </li>
                        <li><a target="content">管理员信息</a>
                            <ul>
                                <li><a href="{url:system/admin/adminAdd}" target="content">新增管理员</a></li>
                                <li><a href="{url:system/admin/adminList}" target="content">管理员列表</a></li>
                                <li><a href="{url:system/admin/logList}" target="content">管理员操作记录</a></li>
                            </ul>
                        </li>
                        <!-- <li><a  target="content">系统设置</a></li> -->

                    </ul>
                </li>
                
                <li><a   target="content"><img src="{views:img/icons/menu/comment.png}" alt="" /> 资讯管理</a>
                    <ul>
                        <li><a  target="content">分类管理</a>
                            <ul>
                                <li><a target="content" href="{url:category/arcCate/cateList}">分类列表</a></li>
                                <!-- <li><a href="{url:tool/advert/adManageList}" target="content">广告列表</a></li> -->
                            </ul>
                        </li>
                        <li><a  target="content">资讯管理</a>
                            <ul>
                                <li><a target="content" href="{url:article/article/arcList}">资讯列表</a></li>
                                <!-- <li><a href="{url:tool/advert/adManageList}" target="content">广告列表</a></li> -->
                            </ul>
                        </li>
                        
                    </ul>
                </li>
                <li><a   target="content"><img src="{views:img/icons/menu/comment.png}" alt="" /> 工具管理</a>
                    <ul>
                        <li><a  target="content">广告管理</a>
                            <ul>
                                <li><a target="content" href="{url:tool/advert/adPositionList}">广告位列表</a></li>
                                <li><a href="{url:tool/advert/adManageList}" target="content">广告列表</a></li>
                            </ul>
                        </li>
                        <li><a target="content">帮助管理</a>
                            <ul>
                                <li><a href="{url:tool/help/helpCatList}" target="content">帮助分类</a></li>
                                <li><a href="{url:tool/help/helpList}" target="content">帮助列表</a></li>
                            </ul>
                        </li>
                            <li><a href="{url:tool/friendlyLink/frdLinkList}" target="content">友情链接管理</a>
                                <ul>
                                    <li><a href="{url:tool/friendlyLink/addFrdLink}" target="content">新增友情链接</a></li>
                                    <li><a href="{url:tool/friendlyLink/frdLinkList}" target="content">友情链接列表</a></li>
                                </ul>
                            </li>
                            <li><a href="{url:tool/slide/slideList}" target="content">幻灯片管理</a>
                                <ul>
                                    <li><a href="{url:tool/slide/addSlide}" target="content">新增幻灯片</a></li>
                                    <li><a href="{url:tool/slide/slideList}" target="content">幻灯片列表</a></li>
                                </ul>
                            </li>
                    </ul>
                </li>


            </ul>


        </div>
        <script type="text/javascript">
            $(function(){
                var menus = {$menus};
                if(menus != 'admin'){
                    $('ul a').each(function(){
                        var href = $(this).attr('href');
                        if($(this).attr('no_access') != 'no_access'){
                            var flag = 0;
                            if(href){
                                for(var i=0;i<menus.length;i++){
                                    var href = href.toLocaleLowerCase();
                                    var len = menus[i].length-href.length;
                                    // if(href.indexOf(menus[i]) > 0){
                                    // console.log(menus[i].lastIndexOf(href));
                                    
                                    if(href.lastIndexOf(menus[i]) == -len){
                                        flag = 1;
                                    }
                                }
                            }else{
                                flag = 1;
                            }
                            if(flag == 0){
                                $(this).parent().remove();
                            }
                        }        
                    });
                    $("#sidebar>ul>li>ul>li>a").each(function(){
                        if($(this).siblings('ul').length == 0 || $(this).siblings('ul').children().length == 0){
                            if(!$(this).attr('href') || $(this).attr('href').length < 10){
                                $(this).parent().remove();
                            }
                        }
                    });
                    $("#sidebar>ul>li>ul>li>ul").each(function(){
                        if($(this).find('li').length == 0){
                            $(this).remove();
                        }
                    });
                    // $("#sidebar>ul>li>ul>li").each(function(){
                    //     if($(this).find('ul').length == 0){
                    //         $(this).remove();
                    //     }
                    // });
                    // 
                    
                    $("#sidebar>ul>li>ul").each(function(){
                        if($(this).find('li').length == 0){
                            $(this).remove();
                        }
                    });

                    $("#sidebar>ul>li:not(:first)").each(function(){
                        if($(this).find('ul').length == 0){
                            $(this).remove();
                        }
                    });

                    
                    // 
                    // 
                    


                }
            });    
        </script>
        
                
        <!--            
              CONTENT 
                        --> 
        <div class="main_content" id="content_1" >
            <iframe class="white" scrolling="yes" frameborder="0" src="{url:index/index/welcome}" name="content" marginheight="0" marginwidth="0" width="100%" height="728px"  id="iframe" style="overflow-y:scroll;"></iframe>

     </div>
</div>
        <!-- <input type="hidden" name="getMsgUrl" value="{url:/index/getMsg}" /> -->
        <!-- <script type="text/javascript" src="{views:js/index/index.js}"></script> -->

    </body>
</html>