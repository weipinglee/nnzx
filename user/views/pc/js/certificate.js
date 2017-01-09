/**
 * Created by lenovo on 2016/3/12.
 */

function dealCert(){
    $.ajax({
        type:'post',
        data:$('form').serializeArray(),
        dataType:'json',
        url:$('input[name=ajaxUrl]').val(),
        success:function(data){
            if(data.success==0){//失败
                alert(data.info);
                location.href = data.return;
            }
            else{//认证成功
                location.reload();
            }
        },
        complete:function(){

        },
        timeout:1000,

    })
}
