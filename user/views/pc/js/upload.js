/**
 * 上传图片操作
 * @param _this input type=file控件
 * @param isHead 是否是头像
 */
function uploadImg(_this){
    var uploadUrl = $('input[name=uploadUrl]').val();
    var id = $(_this).attr('id');

    var imgInput = $('input[name=img'+id+']');
    $.ajaxFileUpload
    (
        {
            url: uploadUrl, //用于文件上传的服务器端请求地址
            secureuri: false,           //一般设置为false
            fileElementId: id, //文件上传控件的id属性  <input type="file" id="file" name="file" /> 注意，这里一定要有name值
            //$("form").serialize(),表单序列化。指把所有元素的ID，NAME 等全部发过去
            dataType: 'json',//返回值类型 一般设置为json
            complete: function () { //只要完成即执行，最后执行

            },
            success: function (data)  //服务器成功响应处理函数
            {
                if(data.flag==1){
                    $('img[name='+id+']').attr('src',data.thumb);
                    imgInput.val(data.img);
                    imgInput.trigger('change');//显示正确信息，消失错误信息
                }
                else{
                    alert(data.error);
                }

            },
            error: function (data)//服务器响应失败处理函数
            {
                alert(data);
            }
        }
    )
}
