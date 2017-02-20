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