$(document).ready(function (){ 
	$(".com_cont .top_tit").on('click', function(){
		$(".com_cont .top_tit").removeClass("top_tit_cur");
		$(this).addClass("top_tit_cur");
	})

	  /*招标评论弹出层*/
        //open popup
    $('.fa_com').on('click', function(event){
    	 $("#bg").css("display","block")
        event.preventDefault();
        $('.cd-popup_fabu').addClass('is-visible');
    });
    
    //close popup
    $('.cd-popup_fabu').on('click', function(event){
        if( $(event.target).is('.pop_qx') || $(event.target).is('.cd-popup_fabu') ) {
        	 $("#bg").css("display","none")
            event.preventDefault();
            $(this).removeClass('is-visible');
        }
    });
    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
        	 $("#bg").css("display","none")
            $('.cd-popup_fabu').removeClass('is-visible');
        }
    });
    /*招标评论弹出层 end*/
    /*投标信息弹出层*/
        //open popup
    $('.fa_xinxi').on('click', function(event){
         $("#bg").css("display","block")
        event.preventDefault();
        $('.cd-popup_toubiao').addClass('is-visible');
    });
    
    //close popup
    $('.cd-popup_toubiao').on('click', function(event){
        if( $(event.target).is('.pop_qx') || $(event.target).is('.cd-popup_toubiao') ) {
             $("#bg").css("display","none")
            event.preventDefault();
            $(this).removeClass('is-visible');
        }
    });
    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
             $("#bg").css("display","none")
            $('.cd-popup_toubiao').removeClass('is-visible');
        }
    });
    /*投标信息弹出层 end*/


})


    