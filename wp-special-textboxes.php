<?php
/*
Plugin Name: wp-special-textboxes
Plugin URI: http://simplelib.co.cc/?p=11
Description: Adds simple colored text boxes to highlight some portion of post text. Use it for highlights warnings, alerts, infos and downloads in your blog posts. Visit <a href="http://simplelib.co.cc/">SimpleLib blog</a> for more details.
Version: 1.2.11
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
			'bottom_margin' => '10',
			'cb_color' => '000000',
			'cb_caption_color' => 'ffffff',
			'cb_background' => 'f7cdf5',
			'cb_caption_background' => 'f844ee',
			'cb_border_color' => 'f844ee',
			'cb_image' => '' );
		
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
			if ( $stextboxesAdminOptions[$key] === '' )
				$stextboxesAdminOptions[$key] = WP_PLUGIN_URL.'/wp-special-textboxes/images/heart.png';
			update_option($this->adminOptionsName, $stextboxesAdminOptions);
			return $stextboxesAdminOptions;
		}
		
		function addHeaderCSS() {
			$stextboxesOptions = $this->getAdminOptions();
			echo "\n".'<!-- Start Of Script Generated By wp-special-textboxes -->'."\n";
			echo '<style>'."\n";
			echo ".stb-alert_box { border: 1px {$stextboxesOptions['border_style']} #FF4F4A; }"."\n";
			echo ".stb-download_box { border: 1px {$stextboxesOptions['border_style']} #65ADFE; }"."\n";
			echo ".stb-grey_box { border: 1px {$stextboxesOptions['border_style']} #BBBBBB; }"."\n";
			echo ".stb-info_box { border: 1px {$stextboxesOptions['border_style']} #7AD975; }"."\n";
			echo ".stb-warning_box { border: 1px {$stextboxesOptions['border_style']} #FE9A05; }"."\n";
			echo ".stb-black_box { border: 1px {$stextboxesOptions['border_style']} #6E6E6E; }"."\n";
			echo ".stb-black-caption_box { border: 1px {$stextboxesOptions['border_style']} #6E6E6E; }"."\n";
			echo ".black-body_box { border: 1px {$stextboxesOptions['border_style']} #000000; }"."\n";
			echo ".stb-alert_box, .stb-download_box, .stb-grey_box, .stb-info_box, .stb-warning_box, .stb-black_box {\n  margin-top: {$stextboxesOptions['top_margin']}px;\n  margin-right: {$stextboxesOptions['right_margin']}px;\n  margin-bottom: {$stextboxesOptions['bottom_margin']}px;\n  margin-left: {$stextboxesOptions['left_margin']}px;\n}"."\n";
			echo ".stb-alert-caption_box, .stb-download-caption_box, .stb-info-caption_box, .stb-warning-caption_box, .stb-grey-caption_box, .stb-black-caption_box {\n  border-top-style: {$stextboxesOptions['border_style']};\n  border-right-style: {$stextboxesOptions['border_style']};\n  border-left-style: {$stextboxesOptions['border_style']};\n  margin-top: {$stextboxesOptions['top_margin']}px;\n  margin-right: {$stextboxesOptions['right_margin']}px;\n  margin-bottom: 0px;\n  margin-left: {$stextboxesOptions['left_margin']}px;\n}"."\n";			
			echo ".stb-alert-body_box, .stb-download-body_box, .stb-info-body_box, .stb-warning-body_box, .stb-black-body_box, .stb-grey-body_box {\n  border-left-style: {$stextboxesOptions['border_style']};\n  border-right-style: {$stextboxesOptions['border_style']};\n  border-bottom-style: {$stextboxesOptions['border_style']};\n  margin-top: 0px;\n  margin-right: {$stextboxesOptions['right_margin']}px;\n  margin-bottom: {$stextboxesOptions['bottom_margin']}px;\n  margin-left: {$stextboxesOptions['left_margin']}px;\n}"."\n";			
			echo ".stb-custom_box {"."\n";
			echo "	color: #{$stextboxesOptions['cb_color']};"."\n";
			echo "	background-color: #{$stextboxesOptions['cb_background']};"."\n";
			echo "	background-image: url({$stextboxesOptions['cb_image']});"."\n";
			echo "	background-repeat: no-repeat;"."\n";
			echo "	margin-top: {$stextboxesOptions['top_margin']}px;"."\n";
			echo "  margin-right: {$stextboxesOptions['right_margin']}px;"."\n";
			echo "  margin-bottom: {$stextboxesOptions['bottom_margin']}px;"."\n";
			echo "  margin-left: {$stextboxesOptions['left_margin']}px;"."\n";
			echo "	border-top-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-right-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-bottom-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-left-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-top-style: {$stextboxesOptions['border_style']};\n";
			echo "	border-bottom-style: {$stextboxesOptions['border_style']};\n";
			echo "  border-right-style: {$stextboxesOptions['border_style']};\n";
			echo "  border-left-style: {$stextboxesOptions['border_style']};\n";
			echo "}"."\n";
			echo ".stb-custom-caption_box {"."\n";
			echo "	color: #{$stextboxesOptions['cb_caption_color']};"."\n";
			echo "	font-weight: bold;"."\n";
			echo "	border-top-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-right-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-bottom-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-left-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-top-style: {$stextboxesOptions['border_style']};\n";
			echo "  border-right-style: {$stextboxesOptions['border_style']};\n";
			echo "  border-left-style: {$stextboxesOptions['border_style']};\n";
			echo "	background-color: #{$stextboxesOptions['cb_caption_background']};"."\n";
			echo "	background-image: url({$stextboxesOptions['cb_image']});"."\n";
			echo "	background-repeat: no-repeat;"."\n";
			echo "	margin-top: {$stextboxesOptions['top_margin']}px;"."\n";
			echo "  margin-right: {$stextboxesOptions['right_margin']}px;"."\n";
			echo "  margin-bottom: 0px;"."\n";
			echo "  margin-left: {$stextboxesOptions['left_margin']}px;"."\n";
			echo "}"."\n";
			echo ".stb-custom-body_box {"."\n";
			echo "	color: #{$stextboxesOptions['cb_color']};"."\n";
			echo "	border-top-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-right-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-bottom-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-left-color: #{$stextboxesOptions['cb_border_color']};"."\n";
			echo "	border-bottom-style: {$stextboxesOptions['border_style']};\n";
			echo "  border-right-style: {$stextboxesOptions['border_style']};\n";
			echo "  border-left-style: {$stextboxesOptions['border_style']};\n";
			echo "	background-color: #{$stextboxesOptions['cb_background']};"."\n";
			echo "	margin-top: 0px;"."\n";
			echo "  margin-right: {$stextboxesOptions['right_margin']}px;"."\n";
			echo "  margin-bottom: {$stextboxesOptions['bottom_margin']}px;"."\n";
			echo "  margin-left: {$stextboxesOptions['left_margin']}px;"."\n";
			echo "}"."\n";
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
			$stextbox_classes = array( 'alert', 'download', 'info', 'warning', 'black', 'custom' );
			$bstyle = '';
			$cstyle = '';
			$styleStart = 'style="';
			$styleBody = '';
			$styleCaption = '';
			$styleEnd = '"';
			
			extract( shortcode_atts( array(
				'id' => 'warning',
				'caption' => '',
				'color' => '',
				'ccolor' => '',
				'bcolor' => '',
				'bgcolor' => '',
				'cbgcolor' => '',
				'image' => ''), 
				$atts ) );
			// Body style
			$styleBody .= ( $color === '' ) ? '' : "color:#{$color}; ";
			$styleBody .= ( $bcolor === '' ) ? '' : "border-top-color: #{$bcolor}; border-left-color: #{$bcolor}; border-right-color: #{$bcolor}; border-bottom-color: #{$bcolor}; ";
			$styleBody .= ( $bgcolor === '' ) ? '' : "background-color: #{$bgcolor}; ";
			// Caption style
			$styleCaption .= ( $ccolor === '' ) ? '' : "color:#{$ccolor}; ";
			$styleCaption .= ( $bcolor === '' ) ? '' : "border-top-color: #{$bcolor}; border-left-color: #{$bcolor}; border-right-color: #{$bcolor}; border-bottom-color: #{$bcolor}; ";
			$styleCaption .= ( $cbgcolor === '' ) ? '' : "background-color: #{$cbgcolor}; ";
			// Final preparing
			if ( $caption === '' ) $styleBody .= ( $image === '' ) ? '' : "background-image: url({$image}); ";
			else $styleCaption .= ( $image === '' ) ? '' : "background-image: url({$image}); ";
			if ( $styleBody !== '' ) $bstyle = $styleStart.$styleBody.$styleEnd;
			if ( $styleCaption !== '' ) $cstyle = $styleStart.$styleCaption.$styleEnd;
			if ( $caption === '') {
				if ( in_array( $id, $stextbox_classes ) ) {
					return "<div class='stb-{$id}_box' {$bstyle}>" . do_shortcode($content) . "</div>";
				} elseif ( $id === 'grey' ) {
					return "<div class='stb-{$id}_box' {$bstyle}>{$content}</div>";
				} else { 
					return do_shortcode($content);	
				}
			} else {
				if ( in_array( $id, $stextbox_classes ) ) {
					return "<div class='stb-{$id}-caption_box' {$cstyle}>" . $caption . "</div><div class='stb-{$id}-body_box' {$bstyle}>" . do_shortcode($content) . "</div>";
				} elseif ( $id === 'grey' ) {
					return "<div class='stb-{$id}-caption_box' {$cstyle}>{$caption}</div><div class='stb-{$id}-body_box' {$bstyle}>{$content}</div>";
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
				return "<div class='stb-grey_box'>{$content}</div>";
			} else { 
				return "<div class='stb-grey-caption_box'>{$caption}</div><div class='stb-grey-body_box'>{$content}</div>";	
			}
		}
		
		function getSamples() {
			$stextboxesOptions = $this->getAdminOptions();
			$sampleBox = "<div style='color:#{$stextboxesOptions['cb_color']}; border-top-color: #{$stextboxesOptions['cb_border_color']}; border-left-color: #{$stextboxesOptions['cb_border_color']}; border-right-color: #{$stextboxesOptions['cb_border_color']}; border-bottom-color: #{$stextboxesOptions['cb_border_color']}; background-color: #{$stextboxesOptions['cb_background']}; background-image: url({$stextboxesOptions['cb_image']}); background-repeat: no-repeat; margin-top: {$stextboxesOptions['top_margin']}px;  margin-right: {$stextboxesOptions['right_margin']}px;  margin-bottom: {$stextboxesOptions['bottom_margin']}px;  margin-left: {$stextboxesOptions['left_margin']}px; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 25px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-width: 1px; border-top-style: {$stextboxesOptions['border_style']}; border-bottom-style: {$stextboxesOptions['border_style']}; border-right-style: {$stextboxesOptions['border_style']}; border-left-style: {$stextboxesOptions['border_style']};".(($stextboxesOptions['rounded_corners'] === 'true') ? '	-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;' : '').(($stextboxesOptions['text_shadow'] === 'true') ? 'text-shadow: 1px 1px 2px #888;' : '').(($stextboxesOptions['box_shadow'] === 'true') ? '-webkit-box-shadow: 3px 3px 3px #888; -moz-box-shadow: 3px 3px 3px #888; box-shadow: 3px 3px 3px #888;' : '')."'>".__("This is example of Custom Special Text Box. You must save options to view changes.", "wp-special-textboxes")."</div>";
			$sampleCaptionedBox = "<div style='color:#{$stextboxesOptions['cb_caption_color']}; font-weight: bold; border-top-color: #{$stextboxesOptions['cb_border_color']}; border-right-color: #{$stextboxesOptions['cb_border_color']}; border-bottom-color: #{$stextboxesOptions['cb_border_color']}; border-left-color: #{$stextboxesOptions['cb_border_color']}; border-top-style: {$stextboxesOptions['border_style']}; border-right-style: {$stextboxesOptions['border_style']}; border-left-style: {$stextboxesOptions['border_style']}; background-color: #{$stextboxesOptions['cb_caption_background']}; background-image: url({$stextboxesOptions['cb_image']}); background-repeat: no-repeat; margin-top: {$stextboxesOptions['top_margin']}px; margin-right: {$stextboxesOptions['right_margin']}px; margin-bottom: 0px; margin-left: {$stextboxesOptions['left_margin']}px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 0px; border-left-width: 1px; padding-top: 5px; padding-right: 5px; padding-bottom: 7px; padding-left: 25px; ".(($stextboxesOptions['rounded_corners'] === 'true') ? '-webkit-border-top-left-radius: 5px; -webkit-border-top-right-radius: 5px; -moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;' : '').(($stextboxesOptions['text_shadow'] === 'true') ? 'text-shadow: 1px 1px 2px #888;' : '').(($stextboxesOptions['box_shadow'] === 'true') ? '-webkit-box-shadow: 3px 3px 3px #888; -moz-box-shadow: 3px 3px 3px #888; box-shadow: 3px 3px 3px #888;' : '')."'>".__("This is caption", "wp-special-textboxes")."</div><div style='color:#{$stextboxesOptions['cb_color']}; border-top-color: #{$stextboxesOptions['cb_border_color']}; border-right-color: #{$stextboxesOptions['cb_border_color']}; border-bottom-color: #{$stextboxesOptions['cb_border_color']}; border-left-color: #{$stextboxesOptions['cb_border_color']}; border-bottom-style: {$stextboxesOptions['border_style']}; border-right-style: {$stextboxesOptions['border_style']}; border-left-style: {$stextboxesOptions['border_style']}; background-color: #{$stextboxesOptions['cb_background']}; margin-top: 0px; margin-right: {$stextboxesOptions['right_margin']}px; margin-bottom: {$stextboxesOptions['bottom_margin']}px; margin-left: {$stextboxesOptions['left_margin']}px; border-top-width: 0px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px;padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px; ".(($stextboxesOptions['rounded_corners'] === 'true') ? '-webkit-border-bottom-left-radius: 5px;
	-webkit-border-bottom-right-radius: 5px; -moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;' : '').(($stextboxesOptions['text_shadow'] === 'true') ? 'text-shadow: 1px 1px 2px #888;' : '').(($stextboxesOptions['box_shadow'] === 'true') ? '-webkit-box-shadow: 3px 3px 3px #888; -moz-box-shadow: 3px 3px 3px #888; box-shadow: 3px 3px 3px #888;' : '')."'>".__("This is example of Captioned Custom Special Text Box. You must save options to view changes.", "wp-special-textboxes")."</div>";
			return $sampleBox.$sampleCaptionedBox;
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
					"disp" => "startColumn",
					"options" => "49"),
						
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
					"disp" => "endSection" ),
					
				array(
					"disp" => "endColumn"),
						
				array(
					"disp" => "columnGap",
					"options" => "2"),
					
				array(
					"disp" => "startColumn",
					"options" => "49"),
				
				array(	
					"name" => __('Custom Box Editor', 'wp-special-textboxes'),
					"desc" => __('Use parameters below for customising custom Special Text Box.', 'wp-special-textboxes'),
					"disp" => "startSection" ),
					
				array(	
					"name" => __("Define font color for Custom Special Text Box", "wp-special-textboxes"),
					"desc" => __("This is a font color of Custom Special Text Box (Six Hex Digits).", 'wp-special-textboxes'),
					"id" => "cb_color",
					"disp" => "text"),
					
				array(	
					"name" => __("Define caption font color for Custom Special Text Box", "wp-special-textboxes"),
					"desc" => __("This is a font color of Custom Special Text Box caption (Six Hex Digits).", 'wp-special-textboxes'),
					"id" => "cb_caption_color",
					"disp" => "text"),
					
				array(	
					"name" => __("Define background color for Custom Special Text Box", "wp-special-textboxes"),
					"desc" => __("This is a background color of Custom Special Text Box (Six Hex Digits).", 'wp-special-textboxes'),
					"id" => "cb_background",
					"disp" => "text"),
					
				array(	
					"name" => __("Define background color for Custom Special Text Box caption", "wp-special-textboxes"),
					"desc" => __("This is a background color of Custom Special Text Box caption (Six Hex Digits).", 'wp-special-textboxes'),
					"id" => "cb_caption_background",
					"disp" => "text"),
					
				array(	
					"name" => __("Define border color for Custom Special Text Box", "wp-special-textboxes"),
					"desc" => __("This is a border color of Custom Special Text Box (Six Hex Digits).", 'wp-special-textboxes'),
					"id" => "cb_border_color",
					"disp" => "text"),
					
				array(	
					"name" => __("Define image for Custom Special Text Box", "wp-special-textboxes"),
					"desc" => __("This is an image of Custom Special Text Box (Full URL). 25x25 pixels, transparent background PNG image recommended.", 'wp-special-textboxes'),
					"id" => "cb_image",
					"disp" => "text",
					"textLength" => '450'),
					
				array(
					"disp" => "endSection" ),
					
				array(
					"disp" => "endColumn")
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
			}
			 ?>
<div class=wrap>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<div id="icon-options-general" class="icon32"></div>
<h2><?php _e("Special Text Boxes Settings", "wp-special-textboxes"); ?></h2>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
			<?php foreach ($options as $value) {
				switch ( $value['disp'] ) {
					case 'startSection':
						?>
<div id="poststuff" class="ui-sortable">
<div class="postbox opened">
<h3><?php echo $value['name']; ?></h3>
	<div class="inside">
						<?php
						if (!is_null($value['desc'])) {
							if ($value['name'] === __('Custom Box Editor', 'wp-special-textboxes')) echo '<p>'.$value['desc'].$this->getSamples().'</p>';
							else echo '<p>'.$value['desc'].'</p>';
						}
						break;
						
					case 'endSection':
						?>
</div>
</div>
</div>
						<?php
						break;
						
					case 'startColumn':
						?>
<td width="<?php echo $value['options'].'%';?>" valign="top">						
						<?php
						break;
						
					case 'endColumn':
						?>
</td>						
						<?php
						break;
						
					case 'columnGap':
						?>
<td width="<?php echo $value['options'].'%';?>" valign="top">&nbsp;</td>						
						<?php
						break;
						
					case 'text':
						if ( is_null($value['textLength']) ) $textLengs = '55';
						else $textLengs = $value['textLength'];
						?>
<p><strong><?php echo $value['name']; ?></strong>
<br/><?php echo $value['desc']; ?></p>
<p><input type="text" style="height: 22px; font-size: 11px; width: <?php echo $textLengs;?>px" value="<?php echo $stextboxesOptions[$value['id']] ?>" name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" /></p>
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
</tr>
</table>
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