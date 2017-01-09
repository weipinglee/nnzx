/**
 * adLoader
 * @author wplee
 * @修改原先的广告加载函数，添加轮播条的功能
 */
function adLoader()
{
	var _self        = this;
	var _id          = null;
	var adKey        = null;
	var positionData = null;
	var adData       = [];
	var length       = 0;//广告数
	var scrollId     = 0;
	/**
	 * @brief 加载广告数据
	 * @param positionJson 广告位数据
	 * @param adArray      广告列表数据
	 * @param boxId        广告容器ID<li class="nonce" ></li>
	 */
	this.load = function(positionJson,adArray,boxId,nav)
	{
		_self.positionData = positionJson;
		_self.adData       = adArray;
		_self._id          = boxId;
		_self.length       = adArray.length;
		
		$('#'+_self._id).append('<div class="ad_box"></div>');
		if(nav){//如果存在导航条，则添加导航条元素并绑定事件
			$('#'+_self._id).addClass('ad_cycle').css('overflow','hidden').append('<div  class="number"><ul></ul></div>');
			$('#'+_self._id).find('.number').css('position','absolute').css('z-index','9999').css('right','10px').css('bottom','10px');
			for(var i=0;i<_self.length;i++){
				if(i==0){
						$('#'+_self._id).find('ul').append('<li class="nonce" num="'+i+'"></li>');
				}else
				$('#'+_self._id).find('ul').append('<li class="initial" num="'+i+'"></li>');
			}
			
			 $('#'+_self._id).find('li').on('mouseover',function(){
			 	 _self.stopHere($(this));
			 })
			  $('#'+_self._id).find('li').on('mouseout',function(){
			  	_self.startScroll();
			  })
			
			_self.slideHere();
			_self.startScroll();
		}else{
			_self.show();
		}
		
		
		
	}
	
	this.startScroll = function(){
	    _self.scrollId = setInterval(function(){
	        var nextImg = $('#'+_self._id).find('.nonce').next('.initial');
	        if(nextImg.length==0){
	            nextImg =  $('#'+_self._id).find('li').eq(0);
	        }
	       _self.slideHere(nextImg);
	    }, 3000);
	}
	this.stopScroll = function(){
	    clearInterval( _self.scrollId);
	}
	this.slideHere = function(imgObj){
		if(!imgObj){ _self.show_img_key();return;}
		_self.adKey = imgObj.attr('num');
	   $('#'+_self._id).find('.nonce').removeClass('nonce').addClass('initial');
	   imgObj.removeClass('initial').addClass('nonce');
	   _self.show_img_key();
	}
	this.stopHere = function(imgObj){
	    _self.slideHere(imgObj);
	    _self.stopScroll();
	}
	//
	this.show_img_key = function(){
		_self.adKey = (_self.adKey == null) ? 0 : _self.adKey;
		var adRow = _self.adData[_self.adKey];
		$('#'+_self._id).find('.ad_box').html(adRow.data);
	}
	/**
	 * @brief 展示广告位
	 */
	this.show = function()
	{
		//顺序显示
		if(_self.positionData.fashion == 1)
		{
			_self.adKey = (_self.adKey == null) ? 0 : _self.adKey+1;

			if(_self.adKey >= _self.adData.length)
			{
				_self.adKey = 0;
			}
		}
		//随机显示
		else
		{
			var rand = parseInt(Math.random()*1000);
			_self.adKey = rand % _self.adData.length;
		}

		var adRow = _self.adData[_self.adKey];

		if(adRow.type == 4)
		{
			$('#'+_self._id).find('.ad_box').html(eval(adRow.data));
		}
		else
		{
			$('#'+_self._id).find('.ad_box').html(adRow.data);
		}

		//多个广告数据要依次展示
		if(_self.adData.length > 1)
		{
			window.setTimeout(function(){_self.show();},5000);
		}
	}
}