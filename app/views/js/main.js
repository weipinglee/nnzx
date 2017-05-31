 $(function(){
        $(".collect").click(function(){
            var value=$("#collect").attr("value");
       
            if(value == "collect"){ 
                $("#collect").attr("src","/nnzx/app/views///images/savebtnyes.png");
                $("#collect").val("collected");
                
            }else if(value == "collected"){              
                $("#collect").attr("src","/nnzx/app/views///images/savebtnno.png");
                $("#collect").val("collect");
            }
        });


    });



$(function() {
    $("#share").click(function(){
      $(".screenW").show();
      $(".subW").animate({bottom:"14px"});
    }); 
    $(".screenW,.close").click(function(){
      $(".subW").animate({bottom:"-260px"});
      $(".screenW").hide();
    });

    /*百度分享js*/
    window._bd_share_config = {
        "common": {
            "bdSnsKey": {},
            "bdText": "",
            "bdMini": "2",
            "bdMiniList": false,
            "bdPic": "",
            "bdStyle": "0",
            "bdSize": "16"
        },
        "share": {},
        "image": {
            "viewList": ["qzone", "tsina", "sqq", "tqq", "weixin"],
            "viewText": "分享到：",
            "viewSize": "16"
        },
        "selectShare": {
            "bdContainerClass": null,
            "bdSelectMiniList": ["qzone", "tsina", "sqq", "tqq", "weixin"]
        }
    };
    with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
});
