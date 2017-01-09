/**
 * 认证页面js
 * author:weipinglee
 * date:2016/4/29
 */

//切换tab
function nextTab(step){
    if(step===undefined){
        $('.rz_ul').find('.cur').next('li').find('a').trigger('click');
    }
   else{
        $('.rz_ul').find('li.rz_li').eq(step-1).find('a').trigger('click');
    }
}

$(function(){
    //var validObj = formacc;

    $('#next_step').on('click',function(){
        formacc.ignore('.yz_img input');
        if(formacc.check()){
            nextTab();
            formacc.unignore();
        }
    })

   


})


