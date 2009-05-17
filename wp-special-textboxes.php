<?php
/*
Plugin Name: wp-special-textboxes
Plugin URI: http://simplelib.co.cc/?p=11
Description: Adds simple colored text boxes to highlight some portion of post text. Use it for highlights warnings, alerts, infos and downloads in your blog posts. Visit <a href="http://simplelib.co.cc/">SimpleLib blog</a> for more details.
Version: 1.1.7
Author: minimus
Author URI: http://blogovod.co.cc
*/

/*  Copyright 2009, minimus  (email : minimus.blogovod@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists("SpecialTextBoxes")) {
	class SpecialTextBoxes {
		var $adminOptionsName = "SpecialTextBoxesAdminOptions";
		var $stextboxesInitOptions = array( 
			'rounded_corners' => 'true', 
			'text_shadow' => 'false', 
			'box_shadow' => 'false', 
			'border_style' => 'solid',
			'top_margin' => '10',
			'left_margin' => '10',
			'right_margin' => '10',
			'bottom_margin' => '10' );
		
		function SpecialTextBoxes() { //constructor
			//load language
			$plugin_dir = basename(dirname(__FILE__));
			if (function_exists( 'load_plugin_textdomain' ))
				load_plugin_textdomain( 'wp-special-textboxes', 'wp-content/plugins/' . $plugin_dir, $plugin_dir );
			
			//Actions and Shortcodes
			add_action('admin_menu', array(&$this, 'regAdminPage'));
			add_action('wp_head', array(&$this, 'addHeaderCSS'), 1);
			add_action('activate_wp-special-textboxes/wp-special-textboxes.php',  array(&$this, 'init'));
			add_shortcode('stextbox', array(&$this, 'doShortcode'));
			add_shortcode('sgreybox', array(&$this, 'doShortcodeGrey'));
		}
		
		function init() {
			$this->getAdminOptions();
		}
		
		//Returns an array of admin options
		function getAdminOptions() {
			$stextboxesAdminOptions = $this->stextboxesInitOptions;
			$stextboxesOptions = get_option($this->adminOptionsName);
			if (!empty($stextboxesOptions)) {
				foreach ($stextboxesOptions as $key => $option)
					$stextboxesAdminOptions[$key] = $option;
			}
			update_option($this->adminOptionsName, $stextboxesAdminOptions);
			return $stextboxesAdminOptions;
		}
		
		function addHeaderCSS() {
			$stextboxesOptions = $this->getAdminOptions();
			echo "\n".'<!-- Start Of Script Generated By wp-special-textboxes -->'."\n";
			echo '<style>'."\n";
			echo ".alert_box { border: 1px {$stextboxesOptions['border_style']} #FF4F4A; }"."\n";
			echo ".download_box { border: 1px {$stextboxesOptions['border_style']} #65ADFE; }"."\n";
			echo ".grey_box { border: 1px {$stextboxesOptions['border_style']} #BBBBBB; }"."\n";
			echo ".info_box { border: 1px {$stextboxesOptions['border_style']} #7AD975; }"."\n";
			echo ".warning_box { border: 1px {$stextboxesOptions['border_style']} #FE9A05; }"."\n";
			echo ".black_box { border: 1px {$stextboxesOptions['border_style']} #6E6E6E; }"."\n";
			echo ".black-caption_box { border: 1px {$stextboxesOptions['border_style']} #6E6E6E; }"."\n";
			echo ".black-body_box { border: 1px {$stextboxesOptions['border_style']} #000000; }"."\n";
			echo ".alert_box, .download_box, .grey_box, .info_box, .warning_box, .black_box {\n  margin-top: {$stextboxesOptions['top_margin']}px;\n  margin-right: {$stextboxesOptions['right_margin']}px;\n  margin-bottom: {$stextboxesOptions['bottom_margin']}px;\n  margin-left: {$stextboxesOptions['left_margin']}px;\n}"."\n";
			echo ".alert-caption_box, .download-caption_box, .info-caption_box, .warning-caption_box, .grey-caption_box, .black-caption_box {\n  border-top-style: {$stextboxesOptions['border_style']};\n  border-right-style: {$stextboxesOptions['border_style']};\n  border-left-style: {$stextboxesOptions['border_style']};\n  margin-top: {$stextboxesOptions['top_margin']}px;\n  margin-right: {$stextboxesOptions['right_margin']}px;\n  margin-bottom: 0px;\n  margin-left: {$stextboxesOptions['left_margin']}px;\n}"."\n";
			echo ".alert-body_box, .download-body_box, .info-body_box, .warning-body_box, .grey-body_box, .black-body_box {\n  border-left-style: {$stextboxesOptions['border_style']};\n  border-right-style: {$stextboxesOptions['border_style']};\n  border-bottom-style: {$stextboxesOptions['border_style']};\n  margin-top: 0px;\n  margin-right: {$stextboxesOptions['right_margin']}px;\n  margin-bottom: {$stextboxesOptions['bottom_margin']}px;\n  margin-left: {$stextboxesOptions['left_margin']}px;\n}"."\n";
			echo '</style>'."\n";
			if(@file_exists(TEMPLATEPATH.'/wp-special-textboxes.css')) {
				echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/wp-special-textboxes.css" type="text/css" media="screen" />'."\n";	
			} else {
				echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/wp-special-textboxes/css/wp-special-textboxes.css" type="text/css" media="screen" />'."\n";
			}
			if ($stextboxesOptions['rounded_corners'] == "true") {
				if(@file_exists(TEMPLATEPATH.'/wp-special-textboxes-corners.css')) {
					echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/wp-special-textboxes-corners.css" type="text/css" media="screen" />'."\n";	
				} else {
					echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/wp-special-textboxes/css/wp-special-textboxes-corners.css" type="text/css" media="screen" />'."\n";
				}
			}	
			if ($stextboxesOptions['text_shadow'] == "true") {
				if(@file_exists(TEMPLATEPATH.'/wp-special-textboxes-textshadow.css')) {
					echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/wp-special-textboxes-textshadow.css" type="text/css" media="screen" />'."\n";	
				} else {
					echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/wp-special-textboxes/css/wp-special-textboxes-textshadow.css" type="text/css" media="screen" />'."\n";
				}
			}
			if ($stextboxesOptions['box_shadow'] == "true") {
				if(@file_exists(TEMPLATEPATH.'/wp-special-textboxes-boxshadow.css')) {
					echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/wp-special-textboxes-boxshadow.css" type="text/css" media="screen" />'."\n";	
				} else {
					echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/wp-special-textboxes/css/wp-special-textboxes-boxshadow.css" type="text/css" media="screen" />'."\n";
				}
			}
			echo '<!-- End Of Script Generated By wp-special-textboxes -->'."\n\n";
		}
		
		function doShortcode( $atts, $content = null ) {
			$stextbox_classes = array( 'alert', 'download', 'info', 'warning', 'black' );
			extract( shortcode_atts( array(
				'id' => 'warning',
				'caption' => ''), 
				$atts ) );
			if ( $caption === '') {
				if ( in_array( $id, $stextbox_classes ) ) {
					return "<div class='{$id}_box'>" . do_shortcode($content) . "</div>";
				} elseif ( $id === 'grey' ) {
					return "<div class='{$id}_box'>{$content}</div>";
				} else { 
					return do_shortcode($content);	
				}
			} else {
				if ( in_array( $id, $stextbox_classes ) ) {
					return "<div class='{$id}-caption_box'>" . $caption . "</div><div class='{$id}-body_box'>" . do_shortcode($content) . "</div>";
				} elseif ( $id === 'grey' ) {
					return "<div class='{$id}-caption_box'>{$caption}</div><div class='{$id}-body_box'>{$content}</div>";
				} else { 
					return do_shortcode($content);	
				}
			}   
		}
		
		function doShortcodeGrey( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'caption' => '',
				), $atts ) );
			if ( $caption === '' ) {
				return "<div class='grey_box'>{$content}</div>";
			} else { 
				return "<div class='grey-caption_box'>{$caption}</div><div class='grey-body_box'>{$content}</div>";	
			}
		}
		
		function regAdminPage() {
			if (function_exists('add_options_page')) {
				add_options_page(__('Special Text Boxes', 'wp-special-textboxes'), __('Special Text Boxes', 'wp-special-textboxes'), 8, basename(__FILE__), array(&$this, 'printAdminPage'));
			}
		} 
		
		//Prints out the admin page
		function printAdminPage() {
			$stextboxesOptions = $this->getAdminOptions();
			$options = array (
				array(	
					"name" => __('Basic Settings', 'wp-special-textboxes'),
					"disp" => "startSection" ),
							
				array(	
					"name" => __("Select border style for Special Text Boxes", "wp-special-textboxes"),
					"desc" => __('Selecting "None" will disable Special Text Boxes border.', 'wp-special-textboxes'),
					"id" => "border_style",
					"disp" => "select",
					"options" => array( 'solid', 'dashed', 'dotted', 'none' )),
					
				array(	
					"name" => __("Define top margin for Special Text Boxes", "wp-special-textboxes"),
					"desc" => __("This is a gap between top edge of Special Text Box and text above.", 'wp-special-textboxes'),
					"id" => "top_margin",
					"disp" => "text"),
					
				array(	
					"name" => __("Define left margin for Special Text Boxes", "wp-special-textboxes"),
					"desc" => __("This is a gap between left edge of Special Text Box and left edge of post area.", 'wp-special-textboxes'),
					"id" => "left_margin",
					"disp" => "text"),
					
				array(	
					"name" => __("Define right margin for Special Text Boxes", "wp-special-textboxes"),
					"desc" => __("This is a gap between right edge of Special Text Box and right edge of post area.", 'wp-special-textboxes'),
					"id" => "right_margin",
					"disp" => "text"),
					
				array(	
					"name" => __("Define bottom margin for Special Text Boxes", "wp-special-textboxes"),
					"desc" => __("This is a gap between bottom edge of Special Text Box and text below.", 'wp-special-textboxes'),
					"id" => "bottom_margin",
					"disp" => "text"),
					
				array(
					"disp" => "endSection" ),
					
				array(	
					"name" => __('Extended Settings', 'wp-special-textboxes'),
					"desc" => __('Parameters below add elements of CSS3 standard to Style Sheet. Not all browsers can interpret this elements properly, but including this elements to HTML page not crash browser.', 'wp-special-textboxes'),
					"disp" => "startSection" ),
				
				array(	
					"name" => __("Allow rounded corners for Special Text Boxes?", "wp-special-textboxes"),
					"desc" => __('Selecting "No" will disable Special Text Boxes rounded corners.', 'wp-special-textboxes'),
					"id" => "rounded_corners",
					"disp" => "radio",
					"options" => array( 'true' => __("Yes", "wp-special-textboxes"), 'false' => __("No", "wp-special-textboxes"))),
				
				array(	
					"name" => __("Allow box shadow for Special Text Boxes?", "wp-special-textboxes"),
					"desc" => __('Selecting "No" will disable Special Text Boxes shadow.', 'wp-special-textboxes'),
					"id" => "box_shadow",
					"disp" => "radio",
					"options" => array( 'true' => __("Yes", "wp-special-textboxes"), 'false' => __("No", "wp-special-textboxes"))),
				
				array(	
					"name" => __('Allow text shadow for Special Text Boxes?', 'wp-special-textboxes'),
					"desc" => __('Selecting "No" will disable Special Text Boxes text shadow.', 'wp-special-textboxes'),
					"id" => "text_shadow",
					"disp" => "radio",
					"options" => array( 'true' => __("Yes", "wp-special-textboxes"), 'false' => __("No", "wp-special-textboxes"))),
					
				array(
					"disp" => "endSection" )
			);
			
			if (isset($_POST['update_specialTextBoxesSettings'])) {
				foreach ($options as $value) {
					if (isset($_POST[$value['id']])) 
						$stextboxesOptions[$value['id']] = $_POST[$value['id']];
				}
				update_option($this->adminOptionsName, $stextboxesOptions);
				?>
<div class="updated"><p><strong><?php _e("Special Text Boxes Settings Updated.", "wp-special-textboxes");?></strong></p></div>        
				<?php
			} ?>
<div class=wrap>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<div id="icon-options-general" class="icon32"></div>
<h2><?php _e("Special Text Boxes Settings", "wp-special-textboxes"); ?></h2>
			<?php foreach ($options as $value) {
				switch ( $value['disp'] ) {
					case 'startSection':
						?>
<div id="poststuff" class="ui-sortable">
<div class="postbox opened">
<h3><?php echo $value['name']; ?></h3>
	<div class="inside">
						<?php
						if (!is_null($value['desc'])) echo '<p>'.$value['desc'].'</p>';
						break;
						
					case 'endSection':
						?>
</div>
</div>
</div>
						<?php
						break;
						
					case 'text':
						?>
<p><strong><?php echo $value['name']; ?></strong>
<br/><?php echo $value['desc']; ?></p>
<p><input type="text" style="height: 22px; font-size: 11px; width: 55px" value="<?php echo $stextboxesOptions[$value['id']] ?>" name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" /></p>
						<?php
						break;
						
					case 'radio':
						?>
<p><strong><?php echo $value['name']; ?></strong>
<br/><?php echo $value['desc']; ?></p><p>				
						<?php
						foreach ($value['options'] as $key => $option) { ?>
<label for="<?php echo $value['id'].'_'.$key; ?>"><input type="radio" id="<?php echo $value['id'].'_'.$key; ?>" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php if ($stextboxesOptions[$value['id']] == $key) { echo 'checked="checked"'; }?> /> <?php echo $option;?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php }
						?>
</p>			
						<?php 
						break;
						
					case 'select':
						?>
<p><strong><?php echo $value['name']; ?></strong>
<br/><?php echo $value['desc']; ?></p>
<p><select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
						<?php foreach ($value['options'] as $option) { ?>
<option value="<?php echo $option; ?>" <?php if ( $stextboxesOptions[$value['id']] == $option) { echo ' selected="selected"'; }?> ><?php echo $option; ?></option>
						<?php } ?>
</select></p>
						<?php
						break;
					
					default:
						
						break;
				}
			}
			?>

<div class="submit">
	<input type="submit" class='button-primary' name="update_specialTextBoxesSettings" value="<?php _e('Update Settings', 'wp-special-textboxes') ?>" />
</div>
</form>
</div>      
      <?php
		} // End of function printAdminPage
	} // End of class SpecialTextBoxes
} // End of If

if (class_exists("SpecialTextBoxes")) {
	$minimus_special_textboxes = new SpecialTextBoxes();
}
?>