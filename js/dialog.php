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
	<title><?php _e('Insert Special Text Box', STB_DOMAIN); ?></title>
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
        <li id="basic_tab" class="current"><span><a href="javascript:mcTabs.displayTab('basic_tab','basic_panel');" onmousedown="return false;"><?php _e("Basic Settings", STB_DOMAIN); ?></a></span></li>
        <li id="extended_tab"><span><a href="javascript:mcTabs.displayTab('extended_tab','extended_panel');" onmousedown="return false;"><?php _e("Extended Settings", STB_DOMAIN); ?></a></span></li>
      </ul>
    </div>
    <div class="panel_wrapper" style="height: 240px;">
      <div id="basic_panel" class="panel current">
		    <table border="0" cellpadding="4" cellspacing="0">
		      <tr>
			      <td nowrap="nowrap"><label for="wstb_id"><?php _e('Text Box ID', STB_DOMAIN).':'; ?></label></td>
			      <td nowrap="nowrap">
				      <select id="wstb_id" name="wstb_id" style="width: 320px">
				        <option value="alert"><?php _e('Alert', STB_DOMAIN); ?></option>
				        <option value="download"><?php _e('Download', STB_DOMAIN); ?></option>
				        <option value="info"><?php _e('Info', STB_DOMAIN); ?></option>
				        <option value="black"><?php _e('Black', STB_DOMAIN); ?></option>
				        <option value="grey"><?php _e('Grey', STB_DOMAIN); ?></option>
								<option value="warning"><?php _e('Warning', STB_DOMAIN); ?></option>
				        <option value="custom"><?php _e('Custom', STB_DOMAIN); ?></option>
				      </select>
				    </td>
		      </tr>
		      <tr>
			      <td nowrap="nowrap"><label for="wstb_caption"><?php _e('Caption', STB_DOMAIN).':'; ?></label></td>
			      <td><input id="wstb_caption" name="wstb_caption" style="width: 320px"/></td>
		      </tr>		  
		    </table>
        <table border="0" cellpadding="4" cellspacing="0">
          <tr><td><?php _e('Block Collapsing (for captioned box only)', STB_DOMAIN); ?></td></tr>
           <tr>            
            <td><label for="wstb_collapsing_yes"><input type="radio" id="wstb_collapsing_yes" name="wstb_collapsing" class="radio" value="yes" /><?php _e('Yes', STB_DOMAIN); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wstb_collapsing_no"><input type="radio" id="wstb_collapsing_no" name="wstb_collapsing" class="radio" value="no" /><?php _e('No', STB_DOMAIN); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wstb_collapsing_default"><input type="radio" id="wstb_collapsing_default" name="wstb_collapsing" class="radio" value="default" checked="checked" /><?php _e('Default', STB_DOMAIN); ?></label></td>
          </tr>
        </table>
		    <table border="0" cellpadding="4" cellspacing="0">
		    	<tr><td><?php _e('Collapsed on Load (for captioned box only)', STB_DOMAIN); ?></td></tr>
 					<tr>						
						<td><label for="wstb_collapsed_yes"><input type="radio" id="wstb_collapsed_yes" name="wstb_collapsed" class="radio" value="yes" /><?php _e('Yes', STB_DOMAIN); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wstb_collapsed_no"><input type="radio" id="wstb_collapsed_no" name="wstb_collapsed" class="radio" value="no" /><?php _e('No', STB_DOMAIN); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wstb_collapsed_default"><input type="radio" id="wstb_collapsed_default" name="wstb_collapsed" class="radio" value="default" checked="checked" /><?php _e('Default', STB_DOMAIN); ?></label></td>
					</tr>
				</table>
		    <table border="0" cellpadding="4" cellspacing="0">
				  <tr>
					  <td>&nbsp;<br /><strong><?php _e('Floating Mode Settings', STB_DOMAIN); ?></strong></td>
					</tr>
				</table>
		    <table border="0" cellpadding="4" cellspacing="0">
 					<tr>
						<td><input id="wstb_float" name="wstb_float" class="checkbox" type="checkbox" /></td>
						<td><label for="wstb_float"><?php _e('Float Mode', STB_DOMAIN); ?></label></td>
					</tr>
				</table>
				<table border="0" cellpadding="4" cellspacing="0">
		      <tr>
			      <td nowrap="nowrap"><label for="wstb_align"><?php _e('Box Alignment', STB_DOMAIN).':'; ?></label></td>
			      <td nowrap="nowrap">
				      <select id="wstb_align" name="wstb_align" style="width: 120px">
				        <option value="left"><?php _e('Left', STB_DOMAIN); ?></option>
				        <option value="right"><?php _e('Right', STB_DOMAIN); ?></option>
				      </select>
				    </td>
		      </tr>
		      <tr>
			      <td nowrap="nowrap"><label for="wstb_width"><?php _e('Box Width (in pixels)', STB_DOMAIN).':'; ?></label></td>
			      <td><input id="wstb_width" name="wstb_width" style="width: 120px"/></td>
		      </tr>		  
		    </table>
      </div>
      <div id="extended_panel" class="panel">
        <table border="0" width="100%">
          <tr>
            <td><label for="wstb_fcolor"><?php _e('Text color', STB_DOMAIN).': '; ?></label></td>
            <td colspan="2">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><input id="wstb_fcolor" name="wstb_fcolor" type="text" value="" size="9" onchange="updateColor('wstb_fcolor_pick','wstb_fcolor');" /></td>
                  <td id="wstb_fcolor_pickcontainer">&nbsp;</td>
                </tr>
              </table>
            </td>
            <td><label for="wstb_cfcolor"><?php _e('Caption Text color', STB_DOMAIN).': '; ?></label></td>
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
            <td><label for="wstb_bgcolor"><?php _e('Color', STB_DOMAIN).': '; ?></label></td>
            <td colspan="2">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><input id="wstb_bgcolor" name="wstb_bgcolor" type="text" value="" size="9" onchange="updateColor('wstb_bgcolor_pick','wstb_bgcolor');" /></td>
                  <td id="wstb_bgcolor_pickcontainer">&nbsp;</td>
                </tr>
              </table>
            </td>
            <td><label for="wstb_cbgcolor"><?php _e('Caption color', STB_DOMAIN).': '; ?></label></td>
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
            <td><label for="wstb_bcolor"><?php _e('Border color', STB_DOMAIN).': '; ?></label></td>
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
            <td nowrap="nowrap"><label for="wstb_image_url"><?php _e('Image URL', STB_DOMAIN).':'; ?></label></td>
			      <td><input id="wstb_image_url" name="wstb_image_url" style="width: 290px"/></td>
		      </tr>
        </table>
        <table border="0" cellpadding="4" cellspacing="0">
 					<tr>
						<td><input id="wstb_big_image" name="wstb_big_image" class="checkbox" type="checkbox" /></td>
						<td><label for="wstb_big_image"><?php _e('This is big image (or, if URL not entered, big standard image)', STB_DOMAIN); ?></label></td>
					</tr>
					<tr>
						<td><input id="wstb_noimage" name="wstb_noimage" class="checkbox" type="checkbox" /></td>
						<td><label for="wstb_noimage"><?php _e('Do not show image', STB_DOMAIN); ?></label></td>
					</tr>
        </table>
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td><?php echo __('Margins', STB_DOMAIN).':'; ?></td>
          </tr>
          <tr>
            <td><label for='wstb_left_margin'><?php echo __('Left Margin', STB_DOMAIN).': '; ?></label></td>
            <td><input type='text' name='wstb_left_margin' id='wstb_left_margin' style='width: 60px;'></td>
            <td><label for='wstb_right_margin'><?php echo __('Right Margin', STB_DOMAIN).': '; ?></label></td>
            <td><input type='text' name='wstb_right_margin' id='wstb_right_margin' style='width: 60px;'></td>
          </tr>
          <tr>
            <td><label for='wstb_top_margin'><?php echo __('Top Margin', STB_DOMAIN).': '; ?></label></td>
            <td><input type='text' name='wstb_top_margin' id='wstb_top_margin' style='width: 60px;'></td>
            <td><label for='wstb_bottom_margin'><?php echo __('Bottom Margin', STB_DOMAIN).': '; ?></label></td>
            <td><input type='text' name='wstb_bottom_margin' id='wstb_bottom_margin' style='width: 60px;'></td>
          </tr>
        </table>
      </div>
		</div>
		<div class="mceActionPanel">
		  <div style="float: left">
        <input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", STB_DOMAIN); ?>" onclick="tinyMCEPopup.close();" />
      </div>
      <div style="float: right">
        <input type="submit" id="insert" name="insert" value="<?php _e("Insert", STB_DOMAIN); ?>" onclick="insertWSTBCode();" />
      </div>
    </div>
  </form>
