(function($){
	var initLayout = function(){
  	$('#cb_color, #cb_caption_color, #cb_background, #cb_caption_background, #cb_border_color').ColorPicker({
  		onSubmit: function(hsb, hex, rgb, el){
  			$(el).val(hex);
  			$(el).ColorPickerHide();
  		},
  		onBeforeShow: function(){
  			$(this).ColorPickerSetColor(this.value);
  		}
  	}).bind('keyup', function(){
  		$(this).ColorPickerSetColor(this.value);
  	});
  };
	EYE.register(initLayout, 'init');
})(jQuery)
