
<link rel="stylesheet" href="{views:css/found.css}">
<style type="text/css">
#localDistrict_div{float: none;}
#placeDistrict_div{float: none;}
.found ul li.errnotice{line-height: 15px;padding-left: 42px;color: red;}
</style>
    <!--主要内容 开始-->
    <div id="mainContent">
        <div class="page_width">  
        <form class="found" action="{url:/index/doFound}" method="post" auto_submit redirect_url="{url:/index/index}">
            <!----第一行搜索  开始---->
            <div class="mainRow4">
                <h2 class="title">找货需求单</h2>
                <div class="line"></div>
                    <ul class="">
                        <li><span>名称：</span><input type="text" class="text" name="name" datatype="*" nullmsg="请填写名称" errormsg="名称格式不正确"></li>
                        <li class="errnotice"><span></span></li>
                        <li><span>规格：</span><input type="text" class="text" name="spec" datatype="*" nullmsg="请填写规格" errormsg="规格格式不正确"></li>
                        <li class="errnotice"><span></span></li>
                        <li><span>数量：</span><input type="text" class="text" name="num" datatype="*" nullmsg="请填写数量" errormsg="数量格式不正确"></li>
                        <li class="errnotice"><span></span></li>
                        <li><span>产地：</span>
                        {area:provinceID=placeProv cityID=placeCity districtID=placeDistrict inputName=place}
                        <!--<select class="select_found">
                            <option>请选择</option>
                        </select>
                        <select class="select_found">
                            <option>请选择</option>
                        </select>
                        <select class="select_found">
                            <option>请选择</option>
                        </select>--></li>
                        <li class="errnotice"><span></span></li>
                        <li><span>备注：</span><input type="textarea" class="textarea" name="desc"></li>
                    </ul>
                <div class="pic"><img src="{views:images/found.png}"></div>
            </div>
            <!-----第一行搜索  结束---->

            <!----五大类  开始---->
            <div class="mainRow3" style="background:#fff;">                
                <link rel="stylesheet" type="text/css" href="{views:css/style_main.css}">
                
                <div class="found">
                    <ul>
                        <li><span>联系人：</span><input type="text" class="text" name="username" datatype="zh2-20" nullmsg="请填写联系人" errormsg="请输入2-20个中文字符"></li>
                        <li class="errnotice"><span></span></li>
                        <li><span style="margin-left:-28px">联系电话：</span><input type="text" class="text" name="phone" datatype="mobile" nullmsg="请填写联系电话" errormsg="联系电话格式不正确"></li>
                        <li class="errnotice"><span></span></li>
                        <li><span>所在地：</span>
                        {area:provinceID=localProv cityID=localCity districtID=localDistrict inputName=local}
                        <!--<select class="select_found">
                            <option>请选择</option>
                        </select>
                        <select class="select_found">
                            <option>请选择</option>
                        </select>
                        <select class="select_found">
                            <option>请选择</option>
                        </select>--></li>
                        <li class="errnotice"><span></span></li>
                        <li class="but"><input type="submit" value="提交" class="button submit_edit" style="left:100px;"><span style="">提交后业务员会及时处理，请您耐心等待</span></li>
                    </ul>
               
            </div>
            <!----五大类  结束---->
            </form>
        </div>
    </div>  
    <script type="text/javascript">

    $(function(){
        var validObj = formacc;

        //为地址选择框添加验证规则
        var rules = [{
            ele:"input[name=place]",
            datatype:"n4-6",
            nullmsg:"请选择产地！",
            errormsg:"请选择产地！"
        }];
        validObj.addRule(rules);
        //为地址选择框添加验证规则
        var rules1 = [{
            ele:"input[name=local]",
            datatype:"n4-6",
            nullmsg:"请选择所在地！",
            errormsg:"请选择所在地！"
        }];
        validObj.addRule(rules1);

    })
</script>
    <!--主要内容 结束-->
