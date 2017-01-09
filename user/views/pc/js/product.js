jQuery(document).ready(function($){
    //点击显示下拉菜单
    $(".icon_color").on('click', function(){
         $(this).parents(".cz").find("ul").toggle();
        
    });
    /*图片弹出层*/
    //open popup
    $('.pro_img').on('click', function(event){
    	 $("#bg").css("display","block")
        event.preventDefault();
        $('.cd-popup').addClass('is-visible');
    });
    
    //close popup
    $('.cd-popup').on('click', function(event){
        if( $(event.target).is('.pop_qx') || $(event.target).is('.cd-popup') ) {
        	 $("#bg").css("display","none")
            event.preventDefault();
            $(this).removeClass('is-visible');
        }
    });
    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
        	 $("#bg").css("display","none")
            $('.cd-popup').removeClass('is-visible');
        }
    });
    /*图片弹出层 end*/
    /*订单弹出层*/
        //open popup
    $('.pro_xd').on('click', function(event){
    	 $("#bg").css("display","block")
        event.preventDefault();
        $('.cd-popup_d').addClass('is-visible');
    });
    
    //close popup
    $('.cd-popup_d').on('click', function(event){
        if( $(event.target).is('.pop_qx') || $(event.target).is('.cd-popup_d') ) {
        	 $("#bg").css("display","none")
            event.preventDefault();
            $(this).removeClass('is-visible');
        }
    });
    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
        	 $("#bg").css("display","none")
            $('.cd-popup_d').removeClass('is-visible');
        }
    });
    /*订单弹出层 end*/
       /*合同弹出层*/
        //open popup
    $('.pro_ht').on('click', function(event){
        event.preventDefault();
        $("#bg").css("display","block")
        $('.cd-popup_ht').addClass('is-visible');
        
    });
    
    //close popup
    $('.cd-popup_ht').on('click', function(event){
        if( $(event.target).is('.pop_qx') || $(event.target).is('.cd-popup_ht') ) {
            event.preventDefault();
             $("#bg").css("display","none");
            $(this).removeClass('is-visible');
            
        }
    });
    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
            $('.cd-popup_ht').removeClass('is-visible');
             $("#bg").css("display","none");
        }
    });
    /*合同弹出层 end*/
});

/*数量加减控件*/
$(document).ready(function(){
$("#add").click(function(){
  var n=$("#num").val();
  var num=parseInt(n)+1;
 if(num==0){alert("cc");}
  $("#num").val(num);
});
$("#jian").click(function(){
  var n=$("#num").val();
  var num=parseInt(n)-1;
 if(num==0){alert("不能为0!"); return}
  $("#num").val(num);
  });
});


