<!DOCTYPE html>
<html>
<head>
        <title>角色分组</title>
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
        <link rel="stylesheet" href="css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="css/H-ui.min.css">
    </head>
    <body>      
        <!--            
              CONTENT 
                        --> 
        <div id="content" class="white">
            <h1><img src="img/icons/posts.png" alt="" /> 角色分组</h1>
<div class="bloc">
    <div class="title">
        角色管理
    </div>
    <div class="content">
        <div class="pd-20">
		<div class="text-c"> 
			<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="">
			<button type="submit" class="btn btn-success" id="" name=""><i class=" icon-search fa-search"></i> 搜角色</button>
		</div>
		<div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-trash fa-trash"></i>批量删除</a> <a class="btn btn-primary radius" href="member-role-add.html"><i class=" icon-plus fa-plus"></i> 添加角色</a> </span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
    <table class="table table-border table-bordered table-hover table-bg">
        <thead>
            <tr>
                <th scope="col" colspan="6">角色管理</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" value="" name=""></th>
                <th width="40">ID</th>
                <th width="200">角色名</th>
                <th>用户名称</th>
                <th width="300">描述</th>
                <th width="70">操作</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>1</td>
                <td>钻石会员</td>
                <td><a href="#">admin</a></td>
                <td>拥有一人之下万人之上的权利</td>
               <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','2')" style="text-decoration:none"><i class=" icon-edit fa-edit"></i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
            </tr>
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>2</td>
                <td>黄金会员</td>
                <td><a href="#">张三</a></td>
                <td>具有添加、审核、发布、删除内容的权限</td>
               <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','2')" style="text-decoration:none"><i class="icon-edit fa-edit"></i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
            </tr>
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>3</td>
                <td>白银会员</td>
                <td><a href="#">李四</a>，<a href="#">王五</a></td>
                <td>只对所在栏目具有添加、审核、发布、删除内容的权限</td>
               <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','2')" style="text-decoration:none"><i class=" icon-edit fa-edit"></i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
            </tr>
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>4</td>
                <td>青铜会员</td>
                <td><a href="#">赵六</a>，<a href="#">钱七</a></td>
                <td>只对所在栏目具有添加、删除草稿等权利。</td>
                <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','2')" style="text-decoration:none"><i class=" icon-edit fa-edit"></i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
            </tr>
            <tr class="text-c">
                <td><input type="checkbox" value="" name=""></td>
                <td>4</td>
                <td>黑铁会员</td>
                <td><a href="#">赵六</a>，<a href="#">钱七</a></td>
                <td>只对所在栏目具有添加、删除草稿等权利。</td>
               <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','2')" style="text-decoration:none"><i class=" icon-edit fa-edit"></i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash fa-trash"></i></a></td>
            </tr>
        </tbody>
    </table>
</div>


     
        
    </body>
</html>