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
	var wstbIDObj = document.getElementById('wstb_id');
	var wstbID = wstbIDObj.value;
	var wstbCaptionObj = document.getElementById('wstb_caption');
	var wstbCaption = wstbCaptionObj.value;
	var wstbColorObj = document.getElementById('wstb_fcolor');
	var wstbColor = wstbColorObj.value.replace("#", "");
	var wstbCColorObj = document.getElementById('wstb_cfcolor');
	var wstbCColor = wstbCColorObj.value.replace("#", "");
	var wstbBGColorObj = document.getElementById('wstb_bgcolor');
	var wstbBGColor = wstbBGColorObj.value.replace("#", "");
	var wstbCBGColorObj = document.getElementById('wstb_cbgcolor');
	var wstbCBGColor = wstbCBGColorObj.value.replace("#", "");
	var wstbBColorObj = document.getElementById('wstb_bcolor');
	var wstbBColor = wstbBColorObj.value.replace("#", "");
	var wstbImageObj = document.getElementById('wstb_image_url');
	var wstbImage = wstbImageObj.value;
	var wstbBigImageObj = document.getElementById('wstb_big_image');
	var wstbBigImage = wstbBigImageObj.checked;
	var wstbNoImageObj = document.getElementById('wstb_noimage');
	var wstbNoImage = wstbNoImageObj.checked;
	var contentObj = tinyMCE.getInstanceById('content');
	var wstbBody = contentObj.selection.getContent();
	
	wstbCode = ' [stextbox id="' + wstbID + '"'; 
	if (wstbCaption != '') wstbCode += ' caption="' + wstbCaption + '"';
	if (wstbColor != '') wstbCode += ' color="' + wstbColor + '"';
	if (wstbCColor != '') wstbCode += ' ccolor="' + wstbCColor + '"';
	if (wstbBColor != '') wstbCode += ' bcolor="' + wstbBColor + '"';
	if (wstbBGColor != '') wstbCode += ' bgcolor="' + wstbBGColor + '"';
	if (wstbCBGColor != '') wstbCode += ' cbgcolor="' + wstbCBGColor + '"';
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