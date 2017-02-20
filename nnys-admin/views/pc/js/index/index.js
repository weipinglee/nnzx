/**
 * Created by lenovo on 2016/8/13.
 * 后台外层框架加载的js,异步获取消息
 */


    window.setInterval(getMsg, 1000);
    var msgUrl = $('input[name=getMsgUrl]').val();

    //获取消息
    function getMsg(){
        $.ajax({
            type : 'post',
            url : msgUrl,
            dataType : 'json',
            success : function(data){
                if(data){
                    $.each(data,function(i,v){
                        layer.open({
                            type: 1 ,
                            title: data[i].title,
                            area: ['300px', '200px'],
                            shade: 0,
                            offset: 'rb',
                            content: '<a href="javascript:void(0)" class="layer_open_content" >'+data[i].content+'</a>'
                            //btn: ['全部关闭']

                        });
                        $('.layer_open_content').on('click',function(){
                                setIframeUrl(data[i].url);

                        });

                    })
                }
            }
        })
    }

    function setIframeUrl(url){
      window.frames['content'].location.href = url;
    }

    function clearCache(url){
        $.ajax({
            type : 'post',
            url : url,
            dataType : 'json',
            success : function(data){
                if(data['success']==1){
                    layer.msg('清除成功');

                }
                else{
                    layer.msg('清除失败');
                }
            },
            complete : function(){
            }
        })
    }



