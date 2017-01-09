/**
 * �ϴ�ͼƬ����
 * @param _this input type=file�ؼ�
 * @param isHead �Ƿ���ͷ��
 */
function uploadImg(_this,uploadUrl){
    if(uploadUrl==undefined)
        var uploadUrl = $('input[name=uploadUrl]').val();
    var id = $(_this).attr('id');

    var imgInput = $('input[name=img'+id+']');
    $.ajaxFileUpload
    (
        {
            url: uploadUrl, //�����ļ��ϴ��ķ������������ַ
            secureuri: false,           //һ������Ϊfalse
            fileElementId: id, //�ļ��ϴ��ؼ���id����  <input type="file" id="file" name="file" /> ע�⣬����һ��Ҫ��nameֵ
            //$("form").serialize(),�����л���ָ������Ԫ�ص�ID��NAME ��ȫ������ȥ
            dataType: 'json',//����ֵ���� һ������Ϊjson
            complete: function () { //ֻҪ��ɼ�ִ�У����ִ��

            },
            success: function (data)  //�������ɹ���Ӧ������
            {//alert(JSON.stringify(data));
                 if(data.flag==1){
                    $('img[name='+id+']').attr('src',data.thumb);
                    imgInput.val(data.img);
                    imgInput.trigger('change');//��ʾ��ȷ��Ϣ����ʧ������Ϣ
                }
                else{
                    alert(data.error);
                }

            },
            error: function (data)//��������Ӧʧ�ܴ�����
            {
                alert(JSON.stringify(data));
            }
        }
    )
}
