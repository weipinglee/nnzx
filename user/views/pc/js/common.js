/**
 * Created by lenovo on 2016/3/2.
 */

//ÇÐ»»ÑéÖ¤Âë
function changeCaptcha(urlVal,imgObj)
{
    var radom = Math.random();
    if( urlVal.indexOf("?") == -1 )
    {
        urlVal = urlVal+'?'+radom;
    }
    else
    {
        urlVal = urlVal + '&random'+radom;
    }
    imgObj.attr('src',urlVal);
}
