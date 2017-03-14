 $(document).ready(function(){
        $('#industry').hover(function() {
            $("#in_nav").show();
        }, function() {
           $("#in_nav").hide();
        });
            $("#in_nav").hover(function() {
                $(this).show();
            }, function() {
                $(this).hide();
            });
 })
 //楼层电梯 

$(function () {
    $(window).scroll(function () {
        var scrollTop = $(document).scrollTop();
        console.info(scrollTop);
       
        if(scrollTop>400){
            $(".floor_left_box").css("display","block");
        }else{
             $(".floor_left_box").css("display","none");
        }

    });
});