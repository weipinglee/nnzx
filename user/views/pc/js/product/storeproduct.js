/**
 * Created by lenovo on 2016/7/28.
 */

function fundUser(){

    var user = $('input[name=username]').val();
    if(user=='')return false;
    var url = $('input[name=getUserUrl]').val();
    $.post(url,{username:user},function(data){//alert(JSON.stringify(data));
        if(data.id){
            $('form').find('input[name=user_id]').val(data.id);
            var areaObj = new Area();
            data.area = areaObj.getAreaText(data.area);
            $('#userData').find('td').each(function(){
                var id = $(this).attr('id');
                $(this).text(data[id]);
            })
        }
    },'json');
}

//ÇÐ»»tab
function nextTab(step){
    if(step===undefined){
        $('.rz_ul').find('.cur').next('li').find('a').trigger('click');
    }
    else{
        $('.rz_ul').find('li.rz_li').eq(step-1).find('a').trigger('click');
    }


}



$(function(){
    $('.next_step').eq(0).on('click',function(){
        var user_id = $('input[name=user_id]').val();
        if(user_id=='')
            return false;
        else nextTab();

    });

    $('.next_step').eq(1).on('click',function(){
        formacc.ignore('.sh_jg input');
        if(formacc.check()){
            nextTab();
            formacc.unignore();
        }


    })

    $('input[name=unit]').on('blur',function(){
        $('.unit').text($(this).val());
    })




})
