tinyMCEPopup.requireLangPack();

function init() {
	tinyMCEPopup.resizeToInnerSize();
	
	document.getElementById('wstb_fcolor_pickcontainer').innerHTML = getColorPickerHTML('wstb_fcolor_pick','wstb_fcolor');
	document.getElementById('wstb_cfcolor_pickcontainer').innerHTML = getColorPickerHTML('wstb_cfcolor_pick','wstb_cfcolor');
	document.getElementById('wstb_bgcolor_pickcontainer').innerHTML = getColorPickerHTML('wstb_bgcolor_pick','wstb_bgcolor');
	document.getElementById('wstb_cbgcolor_pickcontainer').innerHTML = getColorPickerHTML('wstb_cbgcolor_pick','wstb_cbgcolor');
	document.getElementById('wstb_bcolor_pickcontainer').innerHTML = getColorPickerHTML('wstb_bcolor_pick','wstb_bcolor');
	
	TinyMCE_EditableSelects.init();
}

function insertWSTBCode() {
	
	var wstbCode;
	
	var f = document.forms[0];
	var radio = f.elements.wstb_collapsed;
  var cRadio = f.elements.wstb_collapsing;
	
	var wstbID = f.elements.wstb_id.value;
	var wstbCaption = f.elements.wstb_caption.value;
	var wstbFloat = f.elements.wstb_float.checked;
	var wstbAlign = f.elements.wstb_align.value;
	var wstbWidth = f.elements.wstb_width.value;
	var wstbColor = f.elements.wstb_fcolor.value.replace("#", "");
	var wstbCColor = f.elements.wstb_cfcolor.value.replace("#", "");
	var wstbBGColor = f.elements.wstb_bgcolor.value.replace("#", "");
	var wstbCBGColor = f.elements.wstb_cbgcolor.value.replace("#", "");
	var wstbBColor = f.elements.wstb_bcolor.value.replace("#", "");
	var wstbImage = f.elements.wstb_image_url.value;
	var wstbBigImage = f.elements.wstb_big_image.checked;
	var wstbNoImage = f.elements.wstb_noimage.checked;
  var wstbLeftMargin = f.elements.wstb_left_margin.value;
  var wstbRightMargin = f.elements.wstb_right_margin.value;
  var wstbTopMargin = f.elements.wstb_top_margin.value;
  var wstbBottomMargin = f.elements.wstb_bottom_margin.value;
  var wstbCollapsing = 0;
	var wstbCollapsed = 0;
  
	if(cRadio[0].checked) wstbCollapsing = 1;
  else if(cRadio[1].checked) wstbCollapsing = 2;
  
  if(radio[0].checked) wstbCollapsed = 1;
	else if(radio[1].checked) wstbCollapsed = 2;
	
	var contentObj = tinyMCE.getInstanceById('content');
	var wstbBody = contentObj.selection.getContent();
	
	wstbCode = ' [stextbox id="' + wstbID + '"'; 
	if (wstbCaption != '') { 
		wstbCode += ' caption="' + wstbCaption + '"';
		
    if (wstbCollapsing == 1) wstbCode += ' collapsing="true"';
    else if(wstbCollapsing == 2) wstbCode += ' collapsing="false"';
    
    if ((wstbCollapsed == 1) && (wstbCollapsing != 2)) wstbCode += ' collapsed="true"';
		else if(wstbCollapsed == 2) wstbCode += ' collapsed="false"';
	}
	if (wstbFloat) {
		wstbCode += ' float="true"';
		if (wstbAlign != 'left') wstbCode += ' align="right"';
		if (wstbWidth != '') wstbCode += ' width="' + wstbWidth + '"';
	}
	if (wstbColor != '') wstbCode += ' color="' + wstbColor + '"';
	if (wstbCColor != '') wstbCode += ' ccolor="' + wstbCColor + '"';
	if (wstbBColor != '') wstbCode += ' bcolor="' + wstbBColor + '"';
	if (wstbBGColor != '') wstbCode += ' bgcolor="' + wstbBGColor + '"';
	if (wstbCBGColor != '') wstbCode += ' cbgcolor="' + wstbCBGColor + '"';
  if (wstbLeftMargin != '') wstbCode += ' mleft="' + wstbLeftMargin + '"';
  if (wstbRightMargin != '') wstbCode += ' mright="' + wstbRightMargin + '"';
  if (wstbTopMargin != '') wstbCode += ' mtop="' + wstbTopMargin + '"';
  if (wstbBottomMargin != '') wstbCode += ' mbottom="' + wstbBottomMargin + '"';
	if ((wstbImage != '') & !wstbNoImage) wstbCode += ' image="' + wstbImage + '"';
	if (wstbBigImage) wstbCode += ' big="' + wstbBigImage.toString() + '"';
	if (wstbNoImage) wstbCode += ' image="null"';
	wstbCode += ']' + wstbBody + '[/stextbox]';
	
	window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, wstbCode);
	tinyMCEPopup.editor.execCommand('mceRepaint');
	tinyMCEPopup.close();
	return;
}

tinyMCEPopup.onInit.add(init);