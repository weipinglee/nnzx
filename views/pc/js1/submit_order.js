


/*购置数量加减*/
;(function ($) {
  $.fn.spinner = function (opts) {
    return this.each(function () {
      var defaults = {value:0, min:0}
      var options = $.extend(defaults, opts)
      var keyCodes = {up:38, down:40}
      var container = $('<div></div>')
      container.addClass('spinner')
      var textField = $(this).addClass('value').attr('maxlength', '2').val(options.value)
        .bind('keyup paste change', function (e) {
          var field = $(this)
          if (e.keyCode == keyCodes.up) changeValue(1)
          else if (e.keyCode == keyCodes.down) changeValue(-1)
          else if (getValue(field) != container.data('lastValidValue')) validateAndTrigger(field)
        })
      textField.wrap(container)

      var increaseButton = $('<button class="increase">+</button>').click(function () { changeValue(1) })
      var decreaseButton = $('<button class="decrease">-</button>').click(function () { changeValue(-1) })

      validate(textField)
      container.data('lastValidValue', options.value)
      textField.before(decreaseButton)
      textField.after(increaseButton)

      function changeValue(delta) {
        textField.val(getValue() + delta)
        validateAndTrigger(textField)
      }

      function validateAndTrigger(field) {
        clearTimeout(container.data('timeout'))
        var value = validate(field)
        if (!isInvalid(value)) {
          textField.trigger('update', [field, value])
        }
      }

      function validate(field) {
        var value = getValue()
        if (value <= options.min) decreaseButton.attr('disabled', 'disabled')
        else decreaseButton.removeAttr('disabled')
        field.toggleClass('invalid', isInvalid(value)).toggleClass('passive', value === 0)

        if (isInvalid(value)) {
          var timeout = setTimeout(function () {
            textField.val(container.data('lastValidValue'))
            validate(field)
          }, 500)
          container.data('timeout', timeout)
        } else {
          container.data('lastValidValue', value)
        }
        return value
      }

      function isInvalid(value) { return isNaN(+value) || value < options.min; }

      function getValue(field) {
        field = field || textField;
        return parseInt(field.val() || 0, 10)
      }
    })
  }
})(jQuery)




/*新增收货地址*/

	         //弹窗
	        $(document).ready(function(){
	         $('.operate').click(function(){
		     if($(this).next('div').is(":hidden"))
		       {
			 $(this).next('div').show();
			
		       }
		    else
		       {
			 $(this).next('div').hide();
			
		       }
		
	        $("h4").toggleClass("tclick")	
			
			 $(".delba").click(function(){
            //	alert(0)
	         $(this).parent().parent().css("display","none");
			 $("h4").toggleClass("tclick")
              })
			

	      });
		  
		 /*支付方式*/ 
		 
		  $("input:radio[name=aa]").on("click",function(){
        console.log($(this).next("img")[0].src);
        $("#curimg1").attr("src",$(this).next("img")[0].src);
        $("#inputspan").text($(this).val());
        //curimg1
        $("#inputr1").attr("checked","true");
$($(".xuanzzf")[0]).trigger("click");

      })
		  
	   });
	
          