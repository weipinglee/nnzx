window.onload=function()
    {
        var ooEm=document.getElementById('yListr');
        var oBo=document.getElementById('bain_bo');
        var aEm=ooEm.getElementsByTagName('em');
        var aaDiv=oBo.getElementsByTagName('div');
        var i=0;
        for(i=0; i<aEm.length; i++)
        {
            aEm[i].index=i;
            aEm[i].onclick=function()
            {
                for(i=0; i<aEm.length; i++)
                {
               
                      aaDiv[i].style.display='none';
                   
                 }
                     aaDiv[this.index].style.display='block';
            };
            
        };
    };