//倒计时
var countdownonline=function()
{
    var _self=this;
    this.handle={};
    this.parent={'second':'minute','minute':'hour','hour':'day','day':''};
    this.add=function(id)
    {
        _self.handle.id=setInterval(function(){_self.work(id,'second');},1000);
    };
    this.work=function(id,type)
    {
        if(type=="")
        {
            return false;
        }
        var e = document.getElementById("cd_"+type+"_"+id);
        var value=parseInt(e.innerHTML);
        if( value == 0 && _self.work( id,_self.parent[type] )==false )
        {
            clearInterval(_self.handle.id);
            return false;
        }
        else
        {var val=0;
            if(value==0){
                val=(type=='hour') ? 23 : 59;
            }else if(value<=10 ){
                if(type=='day')val=value-1;
                else val= '0'+(value-1);
            }else val=value-1;
            e.innerHTML = val;
            return true;
        }
    };
};