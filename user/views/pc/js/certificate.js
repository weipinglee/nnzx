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
            if(data.success==0){//ʧ��
                alert(data.info);
                location.href = data.return;
            }
            else{//��֤�ɹ�
                location.reload();
            }
        },
        complete:function(){

        },
        timeout:1000,

    })
}
