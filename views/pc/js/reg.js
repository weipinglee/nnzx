 $(function(){
    $(".register_top .reg_zc").click(function(){
        $(".reg_zc").removeClass("border_bom");
        $(this).addClass("border_bom");
    });
    $(".register_top .register_l").click(function(){
        $(".gr_reg").css({'display':'block'});
        $(".qy_reg").css({'display':'none'}); 
    });
    $(".register_top .register_r").click(function(){
        $(".gr_reg").css({'display':'none'});
        $(".qy_reg").css({'display':'block'}); 
    });
    
window.onload=function(){
    setup();
    preselect('');
    promptinfo();
}
function promptinfo()
{
  var address = document.getElementById('address');
  var s1 = document.getElementById('s1');
  var s2 = document.getElementById('s2');
  var s3 = document.getElementById('s3');
  address.value = s1.value + s2.value + s3.value;
}

                    
})
