<?php

/**
 * @author minimus
 * @copyright 2009
 */

$wpconfig = realpath("../../../../wp-config.php");
if (!file_exists($wpconfig))  {
	echo "Could not found wp-config.php. Error in path :\n\n".$wpconfig ;	
	die;	
}
require_once($wpconfig);
require_once(ABSPATH.'/wp-admin/admin.php');

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php _e('Insert Special Text Box', 'wp-special-textboxes'); ?></title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/editable_selects.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/wp-special-textboxes/js/wstb-dialog.js"></script>
	<base target="_self" />
</head>

<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
  <form name="wstb" onsubmit="insertWSTBCode();return false;" action="#">
    <div class="tabs">
      <ul>
        <li id="basic_tab" class="current"><span><a href="javascript:mcTabs.displayTab('basic_tab','basic_panel');" onmousedown="return false;"><?php _e("Basic Settings", 'wp-special-textboxes'); ?></a></span></li>
        <li id="extended_tab"><span><a href="javascript:mcTabs.displayTab('extended_tab','extended_panel');" onmousedown="return false;"><?php _e("Extended Settings", 'wp-special-textboxes'); ?></a></span></li>
      </ul>
    </div>
    <div class="panel_wrapper" style="height: 150px;">
      <div id="basic_panel" class="panel current">
		    <table border="0" cellpadding="4" cellspacing="0">
		      <tr>
			      <td nowrap="nowrap"><label for="wstb_id"><?php _e('Text Box ID', 'wp-special-textboxes').':'; ?></label></td>
			      <td nowrap="nowrap">
				      <select id="wstb_id" name="wstb_id" style="width: 320px">
				        <option value="alert"><?php _e('Alert', 'wp-special-textboxes'); ?></option>
				        <option value="download"><?php _e('Download', 'wp-special-textboxes'); ?></option>
				        <option value="info"><?php _e('Info', 'wp-special-textboxes'); ?></option>
				        <option value="black"><?php _e('Black', 'wp-special-textboxes'); ?></option>
				        <option value="grey"><?php _e('Grey', 'wp-special-textboxes'); ?></option>
				        <option value="custom"><?php _e('Custom', 'wp-special-textboxes'); ?></option>
				      </select>
				    </td>
		      </tr>
		      <tr>
			      <td nowrap="nowrap"><label for="wstb_caption"><?php _e('Caption', 'wp-special-textboxes').':'; ?></label></td>
			      <td><input id="wstb_caption" name="wstb_caption" style="width: 320px"/></td>
		      </tr>		  
		    </table>
		    <table border="0" cellpadding="4" cellspacing="0">
				  <tr>
					  <td>&nbsp;<br /><strong><?php _e('Floating Mode Settings', 'wp-special-textboxes'); ?></strong></td>
					</tr>
				</table>
		    <table border="0" cellpadding="4" cellspacing="0">
 					<tr>
						<td><input id="wstb_float" name="wstb_float" class="checkbox" type="checkbox" /></td>
						<td><label for="wstb_float"><?php _e('Float Mode', 'wp-special-textboxes'); ?></label></td>
					</tr>
				</table>
				<table border="0" cellpadding="4" cellspacing="0">
		      <tr>
			      <td nowrap="nowrap"><label for="wstb_align"><?php _e('Box Alignment', 'wp-special-textboxes').':'; ?></label></td>
			      <td nowrap="nowrap">
				      <select id="wstb_align" name="wstb_align" style="width: 120px">
				        <option value="left"><?php _e('Left', 'wp-special-textboxes'); ?></option>
				        <option value="right"><?php _e('Right', 'wp-special-textboxes'); ?></option>
				      </select>
				    </td>
		      </tr>
		      <tr>
			      <td nowrap="nowrap"><label for="wstb_width"><?php _e('Box Width (in pixels)', 'wp-special-textboxes').':'; ?></label></td>
			      <td><input id="wstb_width" name="wstb_width" style="width: 120px"/></td>
		      </tr>		  
		    </table>
      </div>
      <div id="extended_panel" class="panel">
        <table border="0" width="100%">
          <tr>
            <td><label for="wstb_fcolor"><?php _e('Text color', 'wp-special-textboxes').': '; ?></label></td>
            <td colspan="2">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><input id="wstb_fcolor" name="wstb_fcolor" type="text" value="" size="9" onchange="updateColor('wstb_fcolor_pick','wstb_fcolor');" /></td>
                  <td id="wstb_fcolor_pickcontainer">&nbsp;</td>
                </tr>
              </table>
            </td>
            <td><label for="wstb_cfcolor"><?php _e('Caption Text color', 'wp-special-textboxes').': '; ?></label></td>
            <td colspan="2">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><input id="wstb_cfcolor" name="wstb_cfcolor" type="text" value="" size="9" onchange="updateColor('wstb_cfcolor_pick','wstb_cfcolor');" /></td>
                  <td id="wstb_cfcolor_pickcontainer">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><label for="wstb_bgcolor"><?php _e('Color', 'wp-special-textboxes').': '; ?></label></td>
            <td colspan="2">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><input id="wstb_bgcolor" name="wstb_bgcolor" type="text" value="" size="9" onchange="updateColor('wstb_bgcolor_pick','wstb_bgcolor');" /></td>
                  <td id="wstb_bgcolor_pickcontainer">&nbsp;</td>
                </tr>
              </table>
            </td>
            <td><label for="wstb_cbgcolor"><?php _e('Caption color', 'wp-special-textboxes').': '; ?></label></td>
            <td colspan="2">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><input id="wstb_cbgcolor" name="wstb_cbgcolor" type="text" value="" size="9" onchange="updateColor('wstb_cbgcolor_pick','wstb_cbgcolor');" /></td>
                  <td id="wstb_cbgcolor_pickcontainer">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><label for="wstb_bcolor"><?php _e('Border color', 'wp-special-textboxes').': '; ?></label></td>
            <td colspan="2">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><input id="wstb_bcolor" name="wstb_bcolor" type="text" value="" size="9" onchange="updateColor('wstb_bcolor_pick','wstb_bcolor');" /></td>
                  <td id="wstb_bcolor_pickcontainer">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td nowrap="nowrap"><label for="wstb_image_url"><?php _e('Image URL', 'wp-special-textboxes').':'; ?></label></td>
			      <td><input id="wstb_image_url" name="wstb_image_url" style="width: 290px"/></td>
		      </tr>
        </table>
        <table border="0" cellpadding="4" cellspacing="0">
 					<tr>
						<td><input id="wstb_big_image" name="wstb_big_image" class="checkbox" type="checkbox" /></td>
						<td><label for="wstb_big_image"><?php _e('This is big image (or, if URL not entered, big standard image)', 'wp-special-textboxes'); ?></label></td>
					</tr>
					<tr>
						<td><input id="wstb_noimage" name="wstb_noimage" class="checkbox" type="checkbox" /></td>
						<td><label for="wstb_noimage"><?php _e('Do not show image', 'wp-special-textboxes'); ?></label></td>
					</tr>
        </table>
      </div>
		</div>
		<div class="mceActionPanel">
		  <div style="float: left">
        <input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'wp-special-textboxes'); ?>" onclick="tinyMCEPopup.close();" />
      </div>
      <div style="float: right">
        <input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'wp-special-textboxes'); ?>" onclick="insertWSTBCode();" />
      </div>
    </div>
  </form>
