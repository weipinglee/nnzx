<!DOCTYPE html>
<html>
<head>
        <title>会员审核</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        
        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="js/libs/jquery/1.6/jquery.min.js"></script>
        <script type="text/javascript" src="js/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
        
        <!-- Compressed Version
        <link type="text/css" rel="stylesheet" href="min/b=CoreAdmin&f=css/reset.css,css/style.css,css/jqueryui/jqueryui.css,js/jwysiwyg/jquery.wysiwyg.old-school.css,js/zoombox/zoombox.css" />
        <script type="text/javascript" src="min/b=CoreAdmin/js&f=cookie/jquery.cookie.js,jwysiwyg/jquery.wysiwyg.js,tooltipsy.min.js,iphone-style-checkboxes.js,excanvas.js,zoombox/zoombox.js,visualize.jQuery.js,jquery.uniform.min.js,main.js"></script>
        -->
        <link rel="stylesheet" href="css/min.css" />
        <script type="text/javascript" src="js/min.js"></script>
        
    </head>
    <body>
		<link rel="stylesheet" href="css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="css/H-ui.min.css">

          
            
                
                
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="img/icons/posts.png" alt="" /> 会员审核</h1>
<div class="bloc">
    <div class="title">
        会员审核
    </div>
    <div class="content">
        <div class="pd-20">
            <div class="text-c">
                <form class="Huiform" method="post" action="" target="_self">
                    <input type="text" class="input-text" style="width:250px" placeholder="会员名称" id="" name="">
                    <button type="submit" class="btn btn-success" id="" name=""><i class="icon-search fa-search"></i> 搜索会员</button>
                </form>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-ok fa-ok"></i> 通过</a> <a href="member-audit_add.html"  class="btn btn-primary radius"><i class="icon-remove fa-remove"></i> 不通过</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
             <table class="table table-border table-bordered table-hover table-bg">
        <thead>
            <tr>
                <th scope="col" colspan="9">会员账户</th>
            </tr>
            <tr class="text-c">
                <th><input type="checkbox" value="" name=""></th>
                <th>ID</th>
                <th >登录账号</th>
                <th>会员名称</th>
                <th>会员类型</th>
                <th>手机号</th>
				<th>会员状态</th>
				<th>注册日期</th>
				<th>操作</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>1</td>
                <td>超级管理员</td>
                <td><a href="#">admin</a></td>
                <td>买方会员</td>
				<td>11234567890</td>
				<td>正常</td>
				<td>2016-02-03</td>
                <td class="f-14"><a title="编辑" href="javascript:;"  style="text-decoration:none"><i class=" icon-edit fa-edit"></i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
				
            </tr>
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>2</td>
                <td>总编</td>
                <td><a href="#">张三</a></td>
               <td>买方会员</td>
				<td>11234567890</td>
				<td>正常</td>
				<td>2016-02-03</td>
                <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','2')" style="text-decoration:none"><i class=" icon-edit fa-edit"></i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
            </tr>
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>3</td>
                <td>栏目主辑</td>
                <td><a href="#">李四</a>，<a href="#">王五</a></td>
				<td>买方会员</td>
				<td>11234567890</td>
				<td>正常</td>
				<td>2016-02-03</td>
                <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','3')" style="text-decoration:none"><i class=" icon-edit fa-edit"></i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
            </tr>
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>4</td>
                <td>栏目编辑</td>
                <td><a href="#">赵六</a>，<a href="#">钱七</a></td>
              <td>买方会员</td>
				<td>11234567890</td>
				<td>正常</td>
				<td>2016-02-03</td>
                <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','4')" style="text-decoration:none"><i class=" icon-edit fa-edit"></i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
            </tr>
        </tbody>
    </table>
        </div>        
       
    </div>
</div>


     
        
    </body>
</html>