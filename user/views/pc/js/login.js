 $(function(){
                    
    var defaultInd = 0;
    var list = $('#js_ban_content').children();
    var count = 0;
    var change = function(newInd, callback){
        if(count) return;
        count = 2;
        $(list[defaultInd]).fadeOut(400, function(){
            count--;
            if(count <= 0){
                if(start.timer) window.clearTimeout(start.timer);
                callback && callback();
            }
        });
        $(list[newInd]).fadeIn(400, function(){
            defaultInd = newInd;
            count--;
            if(count <= 0){
                if(start.timer) window.clearTimeout(start.timer);
                callback && callback();
            }
        });
    }

    var next = function(callback){
        var newInd = defaultInd + 1;
        if(newInd >= list.length){
            newInd = 0;
        }
        change(newInd, callback);
    }

    var start = function(){
        if(start.timer) window.clearTimeout(start.timer);
        start.timer = window.setTimeout(function(){
            next(function(){
                start();
            });
        }, 8000);
    }

    start();

    $('#js_ban_button_box').on('click', 'a', function(){
        var btn = $(this);
        if(btn.hasClass('right')){
            //next
            next(function(){
                start();
            });
        }
        else{
            //prev
            var newInd = defaultInd - 1;
            if(newInd < 0){
                newInd = list.length - 1;
            }
            change(newInd, function(){
                start();
            });
        }
        return false;
    });

})


 function button_recover() {
     logining = 0;
     $('#js-mobile_btn').removeAttr("disabled");
     $("#js-mobile_btn").text("立即登录");
 }
 function showErrInfo(text,d){
     $("#error_info").text(text).show();
     if (d != null) {
         d.focus();
     }
 }
var logining = 0;
 function chgCode(){
     $('#chgCode').trigger('click');
 }
 function double_submit() {
     if(logining==1)
        return false;
     $("#js-mobile_btn").attr("disabled", "disabled");
     $("#js-mobile_btn").text("登录中...");

     $("#error_info").hide();
     var account = $.trim($('input[name=mobile]').val());
     var password = $.trim($('input[name=passwd]').val());
     var captcha = $.trim($('input[name=code]').val());

     if(account==''){
        showErrInfo('用户名或手机号不能为空',$('input[name=mobile]'));
         return false;
     }
     if(password==''){
         showErrInfo('密码不能为空',$('input[name=passwd]'));
         return false;
     }
     if(captcha==''){
         showErrInfo('请填写验证码 ',$('input[name=code]'));
         return false;
     }
     logining = 1;
     var data = {account : account ,password : password,captcha:captcha,callback:$('input[name=callback]').val()};
     $.ajax({
         type:'post',
         data:data,
         dataType:'json',
         url:logPath,
         beforeSend:function(){

         },
         success:function(e){
             if (e) {
                 if(e.errorCode !=0){
                     switch(e.errorCode){
                         case 1 :{
                             showErrInfo("账号不能为空",$('input[name=mobile]'));
                             break;
                         }
                         case 2 : {
                             showErrInfo( "密码不能为空",$('input[name=passwd]'));
                             break;
                         }
                         case 3 : {
                             showErrInfo( "验证码不能为空",$('input[name=code]'));
                             break;
                         }
                         case 4 : {
                             showErrInfo( "验证码错误",$('input[name=code]'));
                             chgCode();
                             break;
                         }
                         case 5 : {
                             showErrInfo( "账户或密码错误",$('input[name=mobile]'));
                             chgCode();
                             break;
                         }

                     }
                     button_recover();

                 }else{
                         if(e.returnUrl)
                             window.location = e.returnUrl;
                         return;

                 }

             }
         },
         complete:function(){
         },
         timeout:1000
     })



 }
