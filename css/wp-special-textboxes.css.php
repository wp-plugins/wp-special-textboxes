<?php

/**
 * @author minimus
 * @copyright 2009
 */

header("Content-type: text/css"); 
include("../../../../wp-load.php");
$stextboxesOptions = $stbObject->getAdminOptions();

?>

.stb-container {
	margin: 0px auto; 
	padding: 0px;
}
.stb-tool {
	float: right; 
	padding: 0px; 
	margin: 0px auto;
}
.stb-alert_box {
	background-color: #FFE7E6;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/alert<?php if($stextboxesOptions['bigImg'] === 'true') echo '-b'; ?>.png);
	<?php } ?>
	background-repeat: no-repeat;
	padding-top: 5px;
	padding-right: 5px;
	padding-bottom: 5px;
	border: 1px <?php echo $stextboxesOptions['border_style']; ?> #FF4F4A;
}
.stb-download_box {
	background-color: #DFF0FF;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/download<?php if($stextboxesOptions['bigImg'] === 'true') echo '-b'; ?>.png);
	<?php } ?>
	background-repeat: no-repeat;
	padding-top: 5px;
	padding-right: 5px;
	padding-bottom: 5px;
	border: 1px <?php echo $stextboxesOptions['border_style']; ?> #65ADFE;
}
.stb-grey_box {
	background: #EEEEEE;
	padding: 5px;
	margin: 10px;
	border: 1px <?php echo $stextboxesOptions['border_style']; ?> #BBBBBB;
}
.stb-info_box {
	background-color: #E2F8DE;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/info<?php if($stextboxesOptions['bigImg'] === 'true') echo '-b'; ?>.png);
	<?php } ?>
	background-repeat: no-repeat;
	background-position: left top;
	padding-top: 5px;
	padding-right: 5px;
	padding-bottom: 5px;
	border: 1px <?php echo $stextboxesOptions['border_style']; ?> #7AD975;
}
.stb-warning_box {
	background-color: #FEFFD5;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/warning<?php if($stextboxesOptions['bigImg'] === 'true') echo '-b'; ?>.png);
	<?php } ?>
	background-repeat: no-repeat;
	padding-top: 5px;
	padding-right: 5px;
	padding-bottom: 5px;
	border: 1px <?php echo $stextboxesOptions['border_style']; ?> #FE9A05;
}
.stb-black_box {
	background-color: #000000;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/earth<?php if($stextboxesOptions['bigImg'] === 'true') echo '-b'; ?>.png);
	<?php } ?>
	background-repeat: no-repeat;
	padding-top: 5px;
	padding-right: 5px;
	padding-bottom: 5px;
	color: #FFFFFF;
	border: 1px <?php echo $stextboxesOptions['border_style']; ?> #6E6E6E;
}
.stb-custom_box {
	padding-top: 5px;
	padding-right: 5px;
	padding-bottom: 5px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-width: 1px;
}
.stb-black-caption_box {
	font-weight: bold;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/earth.png);
	<?php } ?>
	background-repeat: no-repeat;
	background-color: #333333;
	color: #FFFFFF;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 0px;
	border-left-width: 1px;
	border-top-color: #333333;
	border-right-color: #333333;
	border-bottom-color: #333333;
	border-left-color: #333333;
}
.stb-black-body_box {
	background-color: #000000;
	padding: 5px;
	color: #FFFFFF;
	border-top-width: 0px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-color: #333333;
	border-right-color: #333333;
	border-bottom-color: #333333;
	border-left-color: #333333;
}
.stb-alert-caption_box {
	font-weight: bold;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/alert.png);
	<?php } ?>
	background-repeat: no-repeat;
	-webkit-background-origin: border;
	-webkit-background-clip: border;
	-moz-background-origin: border;
	-moz-background-clip: border;
	background-color: #FF4F4A;
	color: #FFFFFF;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 0px;
	border-left-width: 1px;
	border-left-style: solid;
	border-top-color: #FF4F4A;
	border-right-color: #FF4F4A;
	border-bottom-color: #FF4F4A;
	border-left-color: #FF4F4A;
}
.stb-alert-body_box {
	background-color: #FFE7E6;
	padding: 5px;
	color: #333333;
	border-top-width: 0px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-color: #FF4F4A;
	border-right-color: #FF4F4A;
	border-bottom-color: #FF4F4A;
	border-left-color: #FF4F4A;
}
.stb-download-caption_box {
	font-weight: bold;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/download.png);
	<?php } ?>
	background-repeat: no-repeat;
	-webkit-background-origin: border;
	-webkit-background-clip: border;
	-moz-background-origin: border;
	-moz-background-clip: border;
	background-color: #65ADFE;
	color: #FFFFFF;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 0px;
	border-left-width: 1px;
	border-top-color: #65ADFE;
	border-right-color: #65ADFE;
	border-bottom-color: #65ADFE;
	border-left-color: #65ADFE;
}
.stb-download-body_box {
	background-color: #DFF0FF;
	padding: 5px;
	color: #333333;
	border-top-width: 0px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-color: #65ADFE;
	border-right-color: #65ADFE;
	border-bottom-color: #65ADFE;
	border-left-color: #65ADFE;
}
.stb-info-caption_box {
	font-weight: bold;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/info.png);
	<?php } ?>
	background-repeat: no-repeat;
	-webkit-background-origin: border;
	-webkit-background-clip: border;
	-moz-background-origin: border;
	-moz-background-clip: border;
	background-color: #7AD975;
	color: #FFFFFF;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 0px;
	border-left-width: 1px;
	border-top-color: #7AD975;
	border-right-color: #7AD975;
	border-bottom-color: #7AD975;
	border-left-color: #7AD975;
}
.stb-info-body_box {
	background-color: #E2F8DE;
	padding: 5px;
	color: #333333;
	border-top-width: 0px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-color: #7AD975;
	border-right-color: #7AD975;
	border-bottom-color: #7AD975;
	border-left-color: #7AD975;
}
.stb-warning-caption_box {
	font-weight: bold;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(../images/warning.png);
	<?php } ?>
	background-repeat: no-repeat;
	-webkit-background-origin: border;
	-webkit-background-clip: border;
	-moz-background-origin: border;
	-moz-background-clip: border;
	background-color: #FE9A05;
	color: #FFFFFF;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 0px;
	border-left-width: 1px;
	border-top-color: #FE9A05;
	border-right-color: #FE9A05;
	border-bottom-color: #FE9A05;
	border-left-color: #FE9A05;
}
.stb-warning-body_box {
	background-color: #FEFFD5;
	padding: 5px;
	color: #333333;
	border-top-width: 0px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-color: #FE9A05;
	border-right-color: #FE9A05;
	border-bottom-color: #FE9A05;
	border-left-color: #FE9A05;
}
.stb-grey-caption_box {
	font-weight: bold;
	background-repeat: no-repeat;
	-webkit-background-origin: border;
	-webkit-background-clip: border;
	-moz-background-origin: border;
	-moz-background-clip: border;
	background-color: #BBBBBB;
	color: #FFFFFF;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
	padding-left: 5px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 0px;
	border-left-width: 1px;
	border-top-color: #BBBBBB;
	border-right-color: #BBBBBB;
	border-bottom-color: #BBBBBB;
	border-left-color: #BBBBBB;
}
.stb-grey-body_box {
	background-color: #EEEEEE;
	padding: 5px;
	color: #333333;
	border-top-width: 0px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-color: #BBBBBB;
	border-right-color: #BBBBBB;
	border-bottom-color: #BBBBBB;
	border-left-color: #BBBBBB;
}
.stb-custom-caption_box {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 0px;
	border-left-width: 1px;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
}
.stb-custom-body_box {
	border-top-width: 0px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
	padding-left: 5px;
}

<?php if ($stextboxesOptions['rounded_corners'] == "true") { ?>
.stb-alert_box,
.stb-download_box,
.stb-grey_box,
.stb-info_box ,
.stb-warning_box,
.stb-black_box,
.stb-custom_box  {
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}
.stb-black-caption_box,
.stb-alert-caption_box,
.stb-download-caption_box,
.stb-info-caption_box,
.stb-warning-caption_box,
.stb-grey-caption_box,
.stb-custom-caption_box  {
	-webkit-border-top-left-radius: 5px;
	-webkit-border-top-right-radius: 5px;
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-topright: 5px;
}
.stb-black-body_box,
.stb-alert-body_box,
.stb-download-body_box,
.stb-info-body_box,
.stb-warning-body_box,
.stb-grey-body_box,
.stb-custom-body_box {
	-webkit-border-bottom-left-radius: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-moz-border-radius-bottomleft: 5px;
	-moz-border-radius-bottomright: 5px;
}
<?php 
}
if ( $stextboxesOptions['box_shadow'] == "true" ) { ?>
.stb-alert_box,
.stb-download_box,
.stb-grey_box,
.stb-info_box ,
.stb-warning_box,
.stb-black_box,
.stb-black-body_box,
.stb-alert-body_box,
.stb-download-body_box,
.stb-info-body_box,
.stb-warning-body_box,
.stb-grey-body_box,
.stb-black-caption_box,
.stb-alert-caption_box,
.stb-download-caption_box,
.stb-info-caption_box,
.stb-warning-caption_box,
.stb-grey-caption_box,
.stb-custom_box,
.stb-custom-caption_box,
.stb-custom-body_box {
	-webkit-box-shadow: 3px 3px 3px #888;
	-moz-box-shadow: 3px 3px 3px #888;
	box-shadow: 3px 3px 3px #888;
}	
<?php 
} 

if ($stextboxesOptions['text_shadow'] == "true") {?>
.stb-alert_box,
.stb-download_box,
.stb-grey_box,
.stb-info_box,
.stb-warning_box,
.stb-black_box,
.stb-custom_box,
.stb-black-body_box,
.stb-alert-body_box,
.stb-download-body_box,
.stb-info-body_box,
.stb-warning-body_box,
.stb-grey-body_box,
.stb-custom-body_box {
	text-shadow: 1px 1px 2px #888;
}
<?php 
}
?>
.stb-black-caption_box { border: 1px <?php echo $stextboxesOptions['border_style']; ?> #6E6E6E; }
.black-body_box { border: 1px <?php echo $stextboxesOptions['border_style']; ?> #000000; }

.stb-alert_box, 
.stb-download_box,
.stb-info_box, 
.stb-warning_box, 
.stb-black_box {  
	margin-top: <?php echo $stextboxesOptions['top_margin']; ?>px;  
	margin-right: <?php echo $stextboxesOptions['right_margin']; ?>px;  
	margin-bottom: <?php echo $stextboxesOptions['bottom_margin']; ?>px;  
	margin-left: <?php echo $stextboxesOptions['left_margin']; ?>px;
	<?php if ($stextboxesOptions['showImg'] === 'true') { ?>
	padding-left: <?php echo (($stextboxesOptions['bigImg'] === 'true') ? '50' : '25' ); ?>px;
	min-height: <?php echo (($stextboxesOptions['bigImg'] === 'true') ? '40' : '20');?>px;
	<?php } else { ?>
	padding-left: 5px; 
	<?php } ?>
}
 
.stb-grey_box {  
	margin-top: <?php echo $stextboxesOptions['top_margin']; ?>px;  
	margin-right: <?php echo $stextboxesOptions['right_margin']; ?>px;  
	margin-bottom: <?php echo $stextboxesOptions['bottom_margin']; ?>px;  
	margin-left: <?php echo $stextboxesOptions['left_margin']; ?>px;
	padding-left: 5px;
}

.stb-alert-caption_box, 
.stb-download-caption_box, 
.stb-info-caption_box, 
.stb-warning-caption_box,
.stb-black-caption_box {  
	border-top-style: <?php echo $stextboxesOptions['border_style']; ?>;  
	border-right-style: <?php echo $stextboxesOptions['border_style']; ?>;  
	border-left-style: <?php echo $stextboxesOptions['border_style']; ?>;  
	margin-top: <?php echo $stextboxesOptions['top_margin']; ?>px;  
	margin-right: <?php echo $stextboxesOptions['right_margin']; ?>px;  
	margin-bottom: 0px;  
	margin-left: <?php echo $stextboxesOptions['left_margin']; ?>px;
	padding-left: <?php echo (($stextboxesOptions['showImg'] === 'true') ? '25' : '5' ); ?>px;
}

 
.stb-grey-caption_box {
	border-top-style: <?php echo $stextboxesOptions['border_style']; ?>;  
	border-right-style: <?php echo $stextboxesOptions['border_style']; ?>;  
	border-left-style: <?php echo $stextboxesOptions['border_style']; ?>;  
	margin-top: <?php echo $stextboxesOptions['top_margin']; ?>px;  
	margin-right: <?php echo $stextboxesOptions['right_margin']; ?>px;  
	margin-bottom: 0px;  
	margin-left: <?php echo $stextboxesOptions['left_margin']; ?>px;
	padding-left: 5px;
}	

.stb-alert-body_box, 
.stb-download-body_box, 
.stb-info-body_box, 
.stb-warning-body_box, 
.stb-black-body_box, 
.stb-grey-body_box {  
	border-left-style: <?php echo $stextboxesOptions['border_style']; ?>;  
	border-right-style: <?php echo $stextboxesOptions['border_style']; ?>;  
	border-bottom-style: <?php echo $stextboxesOptions['border_style']; ?>;  
	margin-top: 0px;  margin-right: <?php echo $stextboxesOptions['right_margin']; ?>px;  
	margin-bottom: <?php echo $stextboxesOptions['bottom_margin']; ?>px;  
	margin-left: <?php echo $stextboxesOptions['left_margin']; ?>px;
}
.stb-custom_box {
	color: #<?php echo $stextboxesOptions['cb_color']; ?>;
	background-color: #<?php echo $stextboxesOptions['cb_background']; ?>;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(<?php echo (($stextboxesOptions['bigImg'] === 'true') ? $stextboxesOptions['cb_bigImg'] :  $stextboxesOptions['cb_image']); ?>);
	<?php } ?>
	background-repeat: no-repeat;
	margin-top: <?php echo $stextboxesOptions['top_margin']; ?>px;
  margin-right: <?php echo $stextboxesOptions['right_margin']; ?>px;
  margin-bottom: <?php echo $stextboxesOptions['bottom_margin']; ?>px;
  margin-left: <?php echo $stextboxesOptions['left_margin']; ?>px;
	border-top-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-right-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-bottom-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-left-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-top-style: <?php echo $stextboxesOptions['border_style']; ?>;
	border-bottom-style: <?php echo $stextboxesOptions['border_style']; ?>;
  border-right-style: <?php echo $stextboxesOptions['border_style']; ?>;
  border-left-style: <?php echo $stextboxesOptions['border_style']; ?>;
	<?php if ($stextboxesOptions['showImg'] === 'true') { ?>
	padding-left: <?php echo (($stextboxesOptions['bigImg'] === 'true') ? '50' : '25' ); ?>px;
	min-height: <?php echo (($stextboxesOptions['bigImg'] === 'true') ? '40' : '20');?>px;
	<?php } else { ?>
	padding-left: 5px; 
	<?php } ?>
}
.stb-custom-caption_box {
	color: #<?php echo $stextboxesOptions['cb_caption_color']; ?>;
	font-weight: bold;
	border-top-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-right-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-bottom-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-left-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-top-style: <?php echo $stextboxesOptions['border_style']; ?>;";
  border-right-style: <?php echo $stextboxesOptions['border_style']; ?>;
  border-left-style: <?php echo $stextboxesOptions['border_style']; ?>;
	background-color: #<?php echo $stextboxesOptions['cb_caption_background']; ?>;
	<?php if ($stextboxesOptions['showImg'] === 'true') {?>
	background-image: url(<?php echo $stextboxesOptions['cb_image']; ?>);
	<?php } ?>
	background-repeat: no-repeat;
	margin-top: <?php echo $stextboxesOptions['top_margin']; ?>px;
  margin-right: <?php echo $stextboxesOptions['right_margin']; ?>px;
  margin-bottom: 0px;
  margin-left: <?php echo $stextboxesOptions['left_margin']; ?>px;
	padding-left: <?php echo (($stextboxesOptions['showImg'] === 'true') ? '25' : '5' ); ?>px;
}
.stb-custom-body_box {
	color: #<?php echo $stextboxesOptions['cb_color']; ?>;
	border-top-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-right-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-bottom-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-left-color: #<?php echo $stextboxesOptions['cb_border_color']; ?>;
	border-bottom-style: <?php echo $stextboxesOptions['border_style']; ?>;
  border-right-style: <?php echo $stextboxesOptions['border_style']; ?>;
  border-left-style: <?php echo $stextboxesOptions['border_style']; ?>;
	background-color: #<?php echo $stextboxesOptions['cb_background']; ?>;
	margin-top: 0px;
  margin-right: <?php echo $stextboxesOptions['right_margin']; ?>px;
  margin-bottom: <?php echo $stextboxesOptions['bottom_margin']; ?>px;
  margin-left: <?php echo $stextboxesOptions['left_margin']; ?>px;
}