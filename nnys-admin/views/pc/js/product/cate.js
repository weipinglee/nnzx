/**
 * Created by weipinglee on 2016/4/18.
 */
//给分类添加属性
function addAttr(){
    var attr_id = $('#all_attr').val();
    var attr_text = $('#all_attr').find('option:selected').text();
    var end = false;
    $('#attr_box').find('input[name^=attr_id]').each(function(){
        if($(this).val()==attr_id)
            end = true;
    })
    if(end)
        return false;
    var attr_input = $('.attr').clone();
    attr_input.find('input').eq(0).val(attr_text).attr('readonly', 'readonly');
    attr_input.find('input').eq(1).val(attr_id).attr('name','attr_id[]');
    attr_input.css('display','block').removeClass('attr');
    attr_input.find('a').bind('click',delAttr);
    $('#attr_box').append(attr_input);
}
//属性删除
function delAttr(){
    $(this).parent('div').remove();
}

$(function(){
    $('#attr_box').find('a').bind('click',delAttr);
})

/**
 * 根据导航栏的类型来切换分类数据
 * @param  {[Int]} type [导航栏类型]
 * @param  {[Int]} url  [请求的地址]
 */
function changeGuideCategory(type, url){
    $.ajax({
             'url' :  url,
            'type' : 'post',
            'data' : {type : type},
            'dataType': 'json',
            success:function(data){
                $('#pid').html('<option value="0" selected>顶级分类</option>' + data.info);
            }
        });
}

/**
 * 分类列表展开合并
 */
$(function() {
    $('p.he').on('click', function() {
        var level = parseInt($(this).parents('tr').attr('title'));

        if($(this).hasClass('cateopen')){//合住
            $(this).addClass('cateclose').removeClass('cateopen');
            $(this).parents('tr').nextAll('tr').each(function(index){
                if($(this).attr('title')>=level+1){
                    $(this).addClass('hide');
                }
                else if($(this).attr('title') <= level){
                    return false;
                }
            })

        }
        else{//打开
            $(this).addClass('cateopen').removeClass('cateclose');
            $(this).parents('tr').nextAll('tr').each(function(index){
                if($(this).attr('title')==level+1){
                    $(this).removeClass('hide');
                }
                else if($(this).attr('title') < level+1){
                    return false;
                }
            })
        }


    });

    //搜索属性
    $('.js_blur_search').keyup(function(){
        var _k = $(this).val()
            ,_obj = $(this).prev('select').find('option');
        $(_obj).each(function(){
            if($(this).text().indexOf(_k) == -1)
            {
                $(this).hide();
            }
            else
            {
                $(this).show()
            }
        })
    })

})
