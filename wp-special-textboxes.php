<?php
/*
Plugin Name: Special Text Boxes
Plugin URI: http://www.simplelib.com/?p=11
Description: Adds simple colored text boxes to highlight some portion of post text. Use it for highlights warnings, alerts, infos and downloads in your blog posts. Visit <a href="http://simplelib.co.cc/">SimpleLib blog</a> for more details.
Version: 3.7.51
Author: minimus
Author URI: http://blogcoding.ru
*/

/*  Copyright 2009 - 2010, minimus  (email : minimus@simplelib.com)

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
			'cb_image' => '',
			'cb_bigImg' => '',
			'bigImg' => 'false',
			'showImg' => 'true',
			'collapsing' => 'false',
			'collapsed' => 'false',
			'fontSize' => '0',
			'captionFontSize' => '0',
			'cb_fontSize' => '0',
			'cb_captionFontSize' => '0',
			'langDirect' => 'ltr' );
		//var $plugin_page;
		var $version = '3.7.51';
		
		function SpecialTextBoxes() { //constructor
			//load language
			$plugin_dir = basename(dirname(__FILE__));
			if (function_exists( 'load_plugin_textdomain' ))
				load_plugin_textdomain( 'wp-special-textboxes', false, $plugin_dir );
			
			//Actions and Shortcodes
			add_action('admin_menu', array(&$this, 'regAdminPage'));
			add_action('wp_head', array(&$this, 'addHeaderCSS'), 1);
			add_action('activate_wp-special-textboxes/wp-special-textboxes.php',  array(&$this, 'onActivate'));
			add_action('deactivate_wp-special-textboxes/wp-special-textboxes.php', array(&$this, 'onDeactivate'));
			add_filter('tiny_mce_version', array(&$this, 'tinyMCEVersion') );
			add_action('template_redirect', array(&$this, 'headerScripts'));
			add_action('init', array(&$this, 'addButtons'));
			add_shortcode('stextbox', array(&$this, 'doShortcode'));
			add_shortcode('stb', array(&$this, 'doShortcode'));
			add_shortcode('sgreybox', array(&$this, 'doShortcodeGrey'));
		}
		
		function onActivate() {
			$stextboxesAdminOptions = $this->getAdminOptions();
			update_option($this->adminOptionsName, $stextboxesAdminOptions);
		}
		
		function onDeactivate() {
			delete_option($this->adminOptionsName);
		}
		
		//Returns an array of admin options
		function getAdminOptions() {
			$stextboxesAdminOptions = $this->stextboxesInitOptions;
			$stextboxesOptions = get_option($this->adminOptionsName);
			if (!empty($stextboxesOptions)) {
				foreach ($stextboxesOptions as $key => $option) 
					$stextboxesAdminOptions[$key] = $option;				
			}
			if ( $stextboxesAdminOptions['cb_image'] === '' )
				$stextboxesAdminOptions['cb_image'] = WP_PLUGIN_URL.'/wp-special-textboxes/images/heart.png';
			if ( $stextboxesAdminOptions['cb_bigImg'] === '' )
				$stextboxesAdminOptions['cb_bigImg'] = WP_PLUGIN_URL.'/wp-special-textboxes/images/heart-b.png';
			return $stextboxesAdminOptions;
		}
		
		function addAdminHeaderCSS() {
			wp_register_style('ColorPickerCSS', WP_PLUGIN_URL.'/wp-special-textboxes/css/colorpicker.css');
			wp_register_style('stbCSS', WP_PLUGIN_URL.'/wp-special-textboxes/css/wp-special-textboxes.css.php');
			wp_enqueue_style('stbCSS');
			wp_enqueue_style('ColorPickerCSS');
		}
		
		function headerScripts() {
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-effects', WP_PLUGIN_URL.'/wp-special-textboxes/js/jquery-ui-1.7.2.custom.min.js', array('jquery'), '1.7.2');
			wp_enqueue_script('wstbLayout', WP_PLUGIN_URL.'/wp-special-textboxes/js/wstb.js.php', array('jquery'), $this->version);
		}
		
		function adminHeaderScripts() {
			wp_register_script('ColorPicker', WP_PLUGIN_URL.'/wp-special-textboxes/js/colorpicker.js');
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-effects', WP_PLUGIN_URL.'/wp-special-textboxes/js/jquery-ui-1.7.2.custom.min.js', array('jquery'), '1.7.2');
			wp_enqueue_script('ColorPicker');
			wp_enqueue_script('wstbAdminLayout', WP_PLUGIN_URL.'/wp-special-textboxes/js/wstb.admin.js.php', array('jquery'), $this->version);
		}
		
		function addHeaderCSS() {
			wp_register_style('stbCSS', WP_PLUGIN_URL.'/wp-special-textboxes/css/wp-special-textboxes.css.php');
			wp_enqueue_style('stbCSS');
		}
		
		function extendedStyleLogic($atts = null) {
			if ( is_null($atts) ) return '';
			
			$stbOptions = $this->getAdminOptions();
			$bstyle = '';
			$cstyle = '';
			$styleStart = 'style="';
			$styleBody = '';
			$styleCaption = '';
			$styleEnd = '"';
			$floatStart = '';
			$floatEnd = '';
			$collapsed = ($stbOptions['collapsing'] === 'true') && (($atts['collapsed'] === 'true') || (($stbOptions['collapsed'] === 'true') && ($atts['collapsed'] !== 'false')));
			
			if ( is_array($atts) ) {
				$needResizing = ( ( $atts['big'] !== '' ) & ( $atts['big'] !==  $stbOptions['bigImg'] ) );
				
				// Float Mode
				if (( $atts['float'] === 'true' ) && in_array($atts['align'], array('left', 'right')) ) {
				  $floatStart = "<div style='float:{$atts['align']}; width:{$atts['width']}px;' >";
				  $floatEnd = '</div>';
		    }
				
				// Body style 
			  $styleBody .= ( $atts['color'] === '' ) ? '' : "color:#{$atts['color']}; ";
			  $styleBody .= ( $atts['bcolor'] === '' ) ? '' : "border-top-color: #{$atts['bcolor']}; border-left-color: #{$atts['bcolor']}; border-right-color: #{$atts['bcolor']}; border-bottom-color: #{$atts['bcolor']}; ";
			  $styleBody .= ( $atts['bgcolor'] === '' ) ? '' : "background-color: #{$atts['bgcolor']}; ";
			
			  // Caption style
			  $styleCaption .= ( $atts['ccolor'] === '' ) ? '' : "color:#{$atts['ccolor']}; ";
			  $styleCaption .= ( $atts['bcolor'] === '' ) ? '' : "border-top-color: #{$atts['bcolor']}; border-left-color: #{$atts['bcolor']}; border-right-color: #{$atts['bcolor']}; border-bottom-color: #{$atts['bcolor']}; ";
			  $styleCaption .= ( $atts['cbgcolor'] === '' ) ? '' : "background-color: #{$atts['cbgcolor']}; ";
				
				// Tool Image
				
				$toolImg = ($stbOptions['collapsing'] === 'true') ? '<div id="stb-tool" class="stb-tool" style="float:'.(($stbOptions['langDirect'] === 'ltr')?'right':'left').'; padding:0px; margin:0px auto"><img id="stb-toolimg" style="border: none; background-color: transparent; padding: 0px; margin: 0px auto;" src="'.WP_PLUGIN_URL.(($collapsed) ? '/wp-special-textboxes/images/show.png" title="'.__('Show', 'wp-special-textboxes') : '/wp-special-textboxes/images/hide.png" title="'.__('Hide', 'wp-special-textboxes')).'" /></div>'  : '';
			  
			  // Image logic
			  if ($atts['caption'] === '') {
				  if ($atts['image'] === '') {
				  	if ($needResizing & ($stbOptions['showImg'] === 'true')) {
				  		if (!in_array($atts['id'], array('custom', 'grey'))) {
				  		  $styleBody .= ( $atts['big'] === 'true' ) ? "background-image: url(".WP_PLUGIN_URL.'/wp-special-textboxes/images/'."{$atts['id']}-b.png); " : "background-image: url(".WP_PLUGIN_URL.'/wp-special-textboxes/images/'."{$atts['id']}.png); ";
				  		  $styleBody .= ( $atts['big'] === 'true' ) ? 'min-height: 40px; padding-'.(($stbOptions['langDirect'] === 'ltr')?'left':'right').': 50px; ' : 'min-height: 20px; padding-'.(($stbOptions['langDirect'] === 'ltr')?'left':'right').': 25px; ';
		  		    } elseif ($atts['id'] === 'custom') {
		  		    	$styleBody .= ( $atts['big'] === 'true' ) ? "background-image: url({$stbOptions['cb_bigImg']}); " : "background-image: url({$stbOptions['cb_image']}); ";
		  		    	$styleBody .= ( $atts['big'] === 'true' ) ? 'min-height: 40px; padding-'.(($stbOptions['langDirect'] === 'ltr')?'left':'right').': 50px; ' : 'min-height: 20px; padding-'.(($stbOptions['langDirect'] === 'ltr')?'left':'right').': 25px; ';
		  		    } else {
		  		    	$styleBody .= 'min-height: 20px; padding-'.(($stbOptions['langDirect'] === 'ltr')?'left':'right').': 5px; ';
		  		    }							
				  	}
				  } elseif ($atts['image'] === 'null') {
				  	$styleBody .= 'background-image: url(none); min-height: 20px; padding-'.(($stbOptions['langDirect'] === 'ltr')?'left':'right').': 5px; ';
				  } else {
				  	$styleBody .= "background-image: url({$atts['image']}); ";
				  	if ($needResizing | ($stbOptions['showImg'] === 'false')) $styleBody .= ( $atts['big'] === 'true' ) ? 'min-height: 40px; padding-'.(($stbOptions['langDirect'] === 'ltr')?'left':'right').': 50px; ' : 'min-height: 20px; padding-'.(($stbOptions['langDirect'] === 'ltr')?'left':'right').': 25px; ';
				  }
				} else {
					if ( $collapsed ) {
						$styleBody .= 'display: none; ';
						$styleCaption .= '-webkit-border-bottom-left-radius: 5px; -webkit-border-bottom-right-radius: 5px; -moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; ';
					}					 
					if ( $atts['image'] !== '' )
					  $styleCaption .= ( $image === 'null' ) ? "background-image: url(none); padding-".(($stbOptions['langDirect'] === 'ltr')?'left':'right').": 5px; " : "background-image: url({$atts['image']}); padding-".(($stbOptions['langDirect'] === 'ltr')?'left':'right').": 25px; ";
				}
				
				return array('body' => ( $styleBody !== '' ) ? $styleStart.$styleBody.$styleEnd : '', 
				             'caption' => ( $styleCaption !== '' ) ? $styleStart.$styleCaption.$styleEnd : '',
										 'floatStart' => $floatStart,
										 'floatEnd' => $floatEnd,
										 'toolImg' => $toolImg);
			}
			else return '';
		}
		
		function drawTextBox( $content = null, $id = 'warning', $caption = '', $atts = null ) {
			$stextbox_classes = array( 'alert', 'download', 'info', 'warning', 'black', 'custom' );
			$style = array('body' => '', 'caption' => '', 'floatStart' => '', 'floatEnd' => '');
			$cntStart = '<div id="stb-container" class="stb-container">';
			$cntEnd = '</div>';
			
			if (!is_null($atts) & is_array($atts)) {
				$style = $this->extendedStyleLogic(
				  shortcode_atts( array( 
							'id' => $id, 
							'caption' => $caption, 
							'color' => '', 
							'ccolor' => '', 
							'bcolor' => '', 
							'bgcolor' => '', 
							'cbgcolor' => '', 
							'image' => '', 
							'big' => '',
							'float' => 'false',
							'align' => 'left',
							'width' => '200',
							'collapsed' => '' ), 
						 $atts)
			  );
			}
			if ( $caption === '') {
				if ( in_array( $id, $stextbox_classes ) ) {
					return $style['floatStart']."<div class='stb-{$id}_box' {$style['body']}>" . do_shortcode($content) . "</div>".$style['floatEnd'];
				} elseif ( $id === 'grey' ) {
					return $style['floatStart']."<div class='stb-{$id}_box' {$style['body']}>{$content}</div>".$style['floatEnd'];
				} else { 
					return do_shortcode($content);	
				}
			} else {
				if ( in_array( $id, $stextbox_classes ) ) {
					return $style['floatStart']. $cntStart ."<div class='stb-{$id}-caption_box stb_caption' {$style['caption']}>" . $caption . $style['toolImg'] . "</div><div class='stb-{$id}-body_box stb_body' {$style['body']}>" . do_shortcode($content) . "</div>". $cntEnd .$style['floatEnd'];
				} elseif ( $id === 'grey' ) {
					return $style['floatStart']."<div class='stb-{$id}-caption_box' {$style['caption']}>{$caption}</div><div class='stb-{$id}-body_box' {$style['body']}>{$content}</div>".$style['floatEnd'];
				} else { 
					return do_shortcode($content);	
				}
			}
		}
		
		function doShortcode( $atts, $content = null ) {
			$attributes = shortcode_atts( array(
				'id' => 'warning',
				'caption' => '',
				'color' => '',
				'ccolor' => '',
				'bcolor' => '',
				'bgcolor' => '',
				'cbgcolor' => '',
				'image' => '',
				'big' => '',
			  'float' => 'false',
			  'align' => 'left',
			  'width' => '200',
				'collapsed' => ''), 
				$atts );

			return $this->drawTextBox( $content, $attributes['id'], $attributes['caption'], $attributes );   
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
		
		function getSamples2() {
			$stextboxesOptions = $this->getAdminOptions();
			$sampleBox = "<div style='color:#{$stextboxesOptions['cb_color']}; border-top-color: #{$stextboxesOptions['cb_border_color']};
				border-left-color: #{$stextboxesOptions['cb_border_color']}; border-right-color: #{$stextboxesOptions['cb_border_color']};
				border-bottom-color: #{$stextboxesOptions['cb_border_color']}; background-color: #{$stextboxesOptions['cb_background']};
				background-image: url({$stextboxesOptions['cb_image']}); background-repeat: no-repeat; margin-top: {$stextboxesOptions['top_margin']}px;
				margin-right: {$stextboxesOptions['right_margin']}px;  margin-bottom: {$stextboxesOptions['bottom_margin']}px;
				margin-left: {$stextboxesOptions['left_margin']}px; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 25px;
				border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-width: 1px;
				border-top-style: {$stextboxesOptions['border_style']}; border-bottom-style: {$stextboxesOptions['border_style']};
				border-right-style: {$stextboxesOptions['border_style']};
				border-left-style: {$stextboxesOptions['border_style']};"
				.(($stextboxesOptions['rounded_corners'] === 'true') ? '	-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;' : '')
				.(($stextboxesOptions['text_shadow'] === 'true') ? 'text-shadow: 1px 1px 2px #888;' : '')
				.(($stextboxesOptions['box_shadow'] === 'true') ? '-webkit-box-shadow: 3px 3px 3px #888; -moz-box-shadow: 3px 3px 3px #888; box-shadow: 3px 3px 3px #888;' : '')." min-height: 20px;'>"
				.__("This is example of Custom Special Text Box with small image. You must save options to view changes.", "wp-special-textboxes")."</div>";
			$sampleBoxBI = "<div style='color:#{$stextboxesOptions['cb_color']}; border-top-color: #{$stextboxesOptions['cb_border_color']};
				border-left-color: #{$stextboxesOptions['cb_border_color']}; border-right-color: #{$stextboxesOptions['cb_border_color']};
				border-bottom-color: #{$stextboxesOptions['cb_border_color']}; background-color: #{$stextboxesOptions['cb_background']};
				background-image: url({$stextboxesOptions['cb_bigImg']}); background-repeat: no-repeat; margin-top: {$stextboxesOptions['top_margin']}px;
				margin-right: {$stextboxesOptions['right_margin']}px;  margin-bottom: {$stextboxesOptions['bottom_margin']}px;
				margin-left: {$stextboxesOptions['left_margin']}px; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 50px;
				border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-width: 1px;
				border-top-style: {$stextboxesOptions['border_style']}; border-bottom-style: {$stextboxesOptions['border_style']};
				border-right-style: {$stextboxesOptions['border_style']};
				border-left-style: {$stextboxesOptions['border_style']};"
				.(($stextboxesOptions['rounded_corners'] === 'true') ? '	-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;' : '')
				.(($stextboxesOptions['text_shadow'] === 'true') ? 'text-shadow: 1px 1px 2px #888;' : '')
				.(($stextboxesOptions['box_shadow'] === 'true') ? '-webkit-box-shadow: 3px 3px 3px #888; -moz-box-shadow: 3px 3px 3px #888; box-shadow: 3px 3px 3px #888;' : '')
				." min-height: 40px; '>".__("This is example of Custom Special Text Box with big image. You must save options to view changes.", "wp-special-textboxes")."</div>";
			$sampleCaptionedBox = "<div id='stb-container' class='stb-container'><div id='caption' style='"
				.((($stextboxesOptions['collapsed'] === 'true') && ($stextboxesOptions['collapsing'] === 'true')) ? '-webkit-border-bottom-left-radius: 5px; -webkit-border-bottom-right-radius: 5px; -moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; ' : '')
				."color:#{$stextboxesOptions['cb_caption_color']}; font-weight: bold; border-top-color: #{$stextboxesOptions['cb_border_color']};
				border-right-color: #{$stextboxesOptions['cb_border_color']}; border-bottom-color: #{$stextboxesOptions['cb_border_color']};
				border-left-color: #{$stextboxesOptions['cb_border_color']}; border-top-style: {$stextboxesOptions['border_style']};
				border-right-style: {$stextboxesOptions['border_style']}; border-left-style: {$stextboxesOptions['border_style']};
				background-color: #{$stextboxesOptions['cb_caption_background']}; background-image: url({$stextboxesOptions['cb_image']});
				background-repeat: no-repeat; margin-top: {$stextboxesOptions['top_margin']}px; margin-right: {$stextboxesOptions['right_margin']}px;
				margin-bottom: 0px; margin-left: {$stextboxesOptions['left_margin']}px; border-top-width: 1px; border-right-width: 1px;
				border-bottom-width: 0px; border-left-width: 1px; padding-top: 5px; padding-right: 5px; padding-bottom: 7px; padding-left: 25px; "
				.(($stextboxesOptions['rounded_corners'] === 'true') ? '-webkit-border-top-left-radius: 5px; -webkit-border-top-right-radius: 5px; -moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px; border-top-left-radius: 5px; border-top-right-radius: 5px;' : '')
				.(($stextboxesOptions['text_shadow'] === 'true') ? 'text-shadow: 1px 1px 2px #888;' : '')
				.(($stextboxesOptions['box_shadow'] === 'true') ? '-webkit-box-shadow: 3px 3px 3px #888; -moz-box-shadow: 3px 3px 3px #888; box-shadow: 3px 3px 3px #888;' : '')."'>"
				.__("This is caption", "wp-special-textboxes")
				.(($stextboxesOptions['collapsing'] === 'true') ? '<div id="stb-tool" class="stb-tool" style="float:right; padding:0px; margin:0px auto"><img id="stb-toolimg" style="border: none; background-color: transparent;" src="'
				.WP_PLUGIN_URL.(($stextboxesOptions['collapsed'] === 'true') ? '/wp-special-textboxes/images/show.png" title="'
				.__('Show', 'wp-special-textboxes') : '/wp-special-textboxes/images/hide.png" title="'
				.__('Hide', 'wp-special-textboxes')).'" /></div>' : '')."</div><div id='body' style='"
				.((($stextboxesOptions['collapsed'] === 'true') && ($stextboxesOptions['collapsing'] === 'true')) ? 'display: none; ' : '')
				."color:#{$stextboxesOptions['cb_color']}; border-top-color: #{$stextboxesOptions['cb_border_color']};
				border-right-color: #{$stextboxesOptions['cb_border_color']}; border-bottom-color: #{$stextboxesOptions['cb_border_color']};
				border-left-color: #{$stextboxesOptions['cb_border_color']}; border-bottom-style: {$stextboxesOptions['border_style']};
				border-right-style: {$stextboxesOptions['border_style']}; border-left-style: {$stextboxesOptions['border_style']};
				background-color: #{$stextboxesOptions['cb_background']}; margin-top: 0px; margin-right: {$stextboxesOptions['right_margin']}px;
				margin-bottom: {$stextboxesOptions['bottom_margin']}px; margin-left: {$stextboxesOptions['left_margin']}px; border-top-width: 0px;
				border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px;padding-top: 5px; padding-right: 5px; padding-bottom: 5px;
				padding-left: 5px; "
				.(($stextboxesOptions['rounded_corners'] === 'true') ? '-webkit-border-bottom-left-radius: 5px; -webkit-border-bottom-right-radius: 5px; -moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;' : '')
				.(($stextboxesOptions['text_shadow'] === 'true') ? 'text-shadow: 1px 1px 2px #888;' : '')
				.(($stextboxesOptions['box_shadow'] === 'true') ? '-webkit-box-shadow: 3px 3px 3px #888; -moz-box-shadow: 3px 3px 3px #888; box-shadow: 3px 3px 3px #888;' : '')."'>"
				.__("This is example of Captioned Custom Special Text Box. You must save options to view changes.", "wp-special-textboxes")."</div></div>";
			return $sampleBox.$sampleBoxBI.$sampleCaptionedBox;
		}
		
		function getSamples() {
			$stbOptions = $this->getAdminOptions();
			$sampleBox = "<div class='stb-custom_box' >".__("This is example of Custom Special Text Box. You must save options to view changes.", "wp-special-textboxes").'</div>';
			$sampleCaptionedBox = "<div id='stb-container' class='stb-container'><div id='caption' class='stb-custom-caption_box' >".__("This is caption", "wp-special-textboxes");
			$sampleCaptionedBox .= "<div id='stb-tool' class='stb-tool' style='float:".(($stbOptions['langDirect'] === 'ltr')?'right':'left')."; padding:0px; margin:0px auto'><img id='stb-toolimg' style='border: none; background-color: transparent;' src='".WP_PLUGIN_URL.(($stbOptions['collapsed'] === 'true') ? "/wp-special-textboxes/images/show.png' title='".__('Show', 'wp-special-textboxes') : "/wp-special-textboxes/images/hide.png' title='".__('Hide', 'wp-special-textboxes'))."' /></div></div>";
			$sampleCaptionedBox .= "<div id='body' class='stb-custom-body_box' >".__("This is example of Captioned Custom Special Text Box. You must save options to view changes.", "wp-special-textboxes")."</div></div>";
			return $sampleBox.$sampleCaptionedBox;
		}
		
		function regAdminPage() {
			if (function_exists('add_options_page')) {
				$plugin_page = add_options_page(__('Special Text Boxes', 'wp-special-textboxes'), __('Special Text Boxes', 'wp-special-textboxes'), 8, basename(__FILE__), array(&$this, 'printAdminPage'));
				//add_action('admin_head-'.$plugin_page, array(&$this, 'addAdminHeaderCSS'));
				add_action('admin_print_scripts-'.$plugin_page, array(&$this, 'adminHeaderScripts'));
				add_action('admin_print_styles-'.$plugin_page, array(&$this, 'addAdminHeaderCSS'));
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
					"name" => __("Define font size for Special Text Boxes", "wp-special-textboxes"),
					"desc" => __("This is font size in pixels.", 'wp-special-textboxes').' '.__("Set this parameter to value 0 for theme default font size.", 'wp-special-textboxes'),
					"id" => "fontSize",
					"disp" => "text"),
				
				array(	
					"name" => __("Define caption font size for Special Text Boxes", "wp-special-textboxes"),
					"desc" => __("This is caption font size in pixels.", 'wp-special-textboxes').' '.__("Set this parameter to value 0 for theme default font size.", 'wp-special-textboxes'),
					"id" => "captionFontSize",
					"disp" => "text"),
				
				array(	
					"name" => __('Allow Big Image for Simple (non-captioned) Special Text Boxes?', 'wp-special-textboxes'),
					"desc" => __('Selecting "Yes" will allow big icons for simple (non-captioned) Special Text Boxes.', 'wp-special-textboxes'),
					"id" => "bigImg",
					"disp" => "radio",
					"options" => array( 'true' => __("Yes", "wp-special-textboxes"), 'false' => __("No", "wp-special-textboxes"))),
				
				array(	
					"name" => __('Define language direction', 'wp-special-textboxes'),
					"desc" => __('Selecting "Left-to-Right" will set Left-to-Right language direction for Special Text Boxes and visa versa.', 'wp-special-textboxes'),
					"id" => "langDirect",
					"disp" => "radio",
					"options" => array( 'ltr' => __("Left-to-Right", "wp-special-textboxes"), 'rtl' => __("Right-to-Left", "wp-special-textboxes"))),
				
				array(	
					"name" => __('Allow icon images for Special Text Boxes?', 'wp-special-textboxes'),
					"desc" => __('Selecting "Yes" will allow displaying icon images in Special Text Boxes.', 'wp-special-textboxes'),
					"id" => "showImg",
					"disp" => "radio",
					"options" => array( 'true' => __("Yes", "wp-special-textboxes"), 'false' => __("No", "wp-special-textboxes"))),
					
				array(	
					"name" => __('Allow collapsing/expanding captioned Special Text Boxes?', 'wp-special-textboxes'),
					"desc" => __('Selecting "Yes" will allow displaying show/hide button in captioned Special Text Boxes.', 'wp-special-textboxes'),
					"id" => "collapsing",
					"disp" => "radio",
					"options" => array( 'true' => __("Yes", "wp-special-textboxes"), 'false' => __("No", "wp-special-textboxes"))),
					
				array(	
					"name" => __('Allow "collapsed on load" captioned Special Text Boxes?', 'wp-special-textboxes'),
					"desc" => __('Selecting "Yes" will allow displaying collapsed captioned Special Text Boxes after page loading.', 'wp-special-textboxes'),
					"id" => "collapsed",
					"disp" => "radio",
					"options" => array( 'true' => __("Yes", "wp-special-textboxes"), 'false' => __("No", "wp-special-textboxes"))),
					
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
					"name" => __("Define font size for Custom Special Text Box", "wp-special-textboxes"),
					"desc" => __("This is font size in pixels.", 'wp-special-textboxes').' '.__("Set this parameter to value 0 for theme default font size.", 'wp-special-textboxes'),
					"id" => "cb_fontSize",
					"disp" => "text"),
				
				array(	
					"name" => __("Define caption font size for Custom Special Text Box", "wp-special-textboxes"),
					"desc" => __("This is caption font size in pixels.", 'wp-special-textboxes').' '.__("Set this parameter to value 0 for theme default font size.", 'wp-special-textboxes'),
					"id" => "cb_captionFontSize",
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
					"name" => __("Define big image for simple (non-captioned) Custom Special Text Box", "wp-special-textboxes"),
					"desc" => __("This is big image for simple (non-captioned) Custom Special Text Box (Full URL). 50x50 pixels, transparent background PNG image recommended.", 'wp-special-textboxes'),
					"id" => "cb_bigImg",
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
<p><?php echo __('Plugin version', 'wp-special-textboxes').': <strong>'.$this->version.'</strong>'; ?></p>
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
		
		function addButtons() {
			// Don't bother doing this stuff if the current user lacks permissions
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
        return;
      
      // Add only in Rich Editor mode
      if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", array(&$this, "addTinyMCEPlugin"));
        add_filter('mce_buttons', array(&$this, 'registerButton'));
      }
		}
		
		function registerButton( $buttons ) {
			array_push($buttons, "separator", "wstb");
      return $buttons;
		}
		
		function addTinyMCEPlugin( $plugin_array ) {
			$plugin_array['wstb'] = plugins_url('wp-special-textboxes/js/editor_plugin.js');
      return $plugin_array;
		}
		
		function tinyMCEVersion( $version ) {
			return ++$version;
		}
		
		function highlightText( $content = null, $id = 'warning', $caption = '', $atts = null ) {
			return $this->drawTextBox( $content, $id, $caption, $atts );
		}
	} // End of class SpecialTextBoxes
} // End of If

if (!class_exists('special_text') && class_exists('WP_Widget')) {
	class special_text extends WP_Widget {
		function special_text() {
			$widget_ops = array( 'classname' => 'special_text', 'description' => __('Arbitrary text or PHP in colored block.', 'wp-special-textboxes'));
			$control_ops = array( 'width' => 350, 'height' => 450, 'id_base' => 'special_text' );
			$this->WP_Widget( 'special_text', __('Special Text', 'wp-special-textboxes'), $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
			$box_id = empty($instance['box_id']) ? 'warning' : $instance['box_id'];
			$parse = $instance['parse'];
			$text = $instance['text'];
			$showAll = $instance['show_all'];
			$canShow = (((is_home() || is_front_page()) && $instance['show_home']) || 
						(is_category() && $instance['show_cat']) ||
						(is_archive() && $instance['show_arc']) ||
						(is_single() && $instance['show_single']) ||
						(is_tag() && $instance['show_tag']) ||
						(is_author() && $instance['show_author']));
			
			$before_title = '<div class="stb-'.$box_id.'-caption_box" style="margin-left: 0px; margin-right: 0px" >';
			$after_title = '</div>'.( !empty($title) ? '<div class="stb-'.$box_id.'-body_box" style="margin-left: 0px; margin-right: 0px" >' : '' );
			$before_widget = '<div class="stb-container">'.( empty($title) ? '<div class="stb-'.$box_id.'_box" style="margin-left: 0px; margin-right: 0px" >' : '' );
			$after_widget = '</div></div>';
			
			if ( $showAll || $canShow ) {
			  echo $before_widget;
		    if ( !empty( $title ) ) echo $before_title . $title . $after_title;
			  echo ($parse ? eval("?>".$text."<?") : $text);
		    echo $after_widget;
		  }
		}
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['box_id'] = $new_instance['box_id'];
			$instance['parse'] = isset($new_instance['parse']);
			$instance['text'] = $new_instance['text'];
			$instance['show_all'] = isset($new_instance['show_all']);
			$instance['show_home'] = isset($new_instance['show_home']);
			$instance['show_single'] = isset($new_instance['show_single']);
			$instance['show_arc'] = isset($new_instance['show_arc']);
			$instance['show_cat'] = isset($new_instance['show_cat']);
			$instance['show_tag'] = isset($new_instance['show_tag']);
			$instance['show_author'] = isset($new_instance['show_author']);
			return $instance;
		}
		
		function form( $instance ) {
			$ids = array( 
			  'alert'    => __('Alert', 'wp-special-textboxes'),
			  'download' => __('Download', 'wp-special-textboxes'),
			  'info'     => __('Info', 'wp-special-textboxes'),
			  'warning'  => __('Warning', 'wp-special-textboxes'),
			  'black'    => __('Black', 'wp-special-textboxes'),
			  'custom'   => __('Custom', 'wp-special-textboxes')
			);
			
			$instance = wp_parse_args((array) $instance, 
			  array('title'       => '', 
				      'box_id'      => 'warning', 
							'parse'       => false, 
							'text'        => '', 
							'show_all'    => true, 
							'show_home'   => false, 
							'show_cat'    => false, 
							'show_arc'    => false, 
							'show_single' => false,
							'show_tag'    => false,
							'show_author' => false));
			$title = strip_tags($instance['title']);
			$box_id = $instance['box_id'];
			$parse = $instance['parse'];
			$text = format_to_edit($instance['text']);
			$show_all = $instance['show_all'];
			$show_home = $instance['show_home'];
			$show_single = $instance['show_single'];
			$show_arc = $instance['show_arc'];
			$show_cat = $instance['show_cat'];
			$show_tag = $instance['show_tag'];
			$show_author = $instance['show_author'];
			?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-special-textboxes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea><br />&nbsp;

		<p><label for="<?php echo $this->get_field_id('box_id'); ?>"><?php _e('ID of Box:', 'wp-special-textboxes') ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('box_id'); ?>" name="<?php echo $this->get_field_name('box_id'); ?>" >
		<?php 
		foreach ($ids as $key => $option) echo '<option value='.$key.(($instance['box_id'] === $key) ? ' selected' : '' ).'>'.$option.'</option>';?> 
		</select></p>
		
		<p><input id="<?php echo $this->get_field_id('parse'); ?>" name="<?php echo $this->get_field_name('parse'); ?>" type="checkbox" <?php checked($instance['parse']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('parse'); ?>"><?php _e('Evaluate as PHP code.', 'wp-special-textboxes'); ?></label></p>
		
		<p><input id="<?php echo $this->get_field_id('show_all'); ?>" name="<?php echo $this->get_field_name('show_all'); ?>" type="checkbox" <?php checked($instance['show_all']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_all'); ?>"><?php _e('Show on all pages of blog', 'wp-special-textboxes'); ?></label></p>
		
		<p><?php _e('Show only on', 'wp-special-textboxes') ?>:<br />
		<input id="<?php echo $this->get_field_id('show_home'); ?>" name="<?php echo $this->get_field_name('show_home'); ?>" type="checkbox" <?php checked($instance['show_home']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_home'); ?>"><?php _e('Home Page', 'wp-special-textboxes'); ?></label><br />
		<input id="<?php echo $this->get_field_id('show_single'); ?>" name="<?php echo $this->get_field_name('show_single'); ?>" type="checkbox" <?php checked($instance['show_single']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_single'); ?>"><?php _e('Single Post Pages', 'wp-special-textboxes'); ?></label><br />
		<input id="<?php echo $this->get_field_id('show_arc'); ?>" name="<?php echo $this->get_field_name('show_arc'); ?>" type="checkbox" <?php checked($instance['show_arc']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_arc'); ?>"><?php _e('Archive Pages', 'wp-special-textboxes'); ?></label><br />
		<input id="<?php echo $this->get_field_id('show_cat'); ?>" name="<?php echo $this->get_field_name('show_cat'); ?>" type="checkbox" <?php checked($instance['show_cat']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_cat'); ?>"><?php _e('Category Archive Pages', 'wp-special-textboxes'); ?></label><br />
		<input id="<?php echo $this->get_field_id('show_tag'); ?>" name="<?php echo $this->get_field_name('show_tag'); ?>" type="checkbox" <?php checked($instance['show_tag']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_tag'); ?>"><?php _e('Tag Archive Pages', 'wp-special-textboxes'); ?></label><br />
		<input id="<?php echo $this->get_field_id('show_author'); ?>" name="<?php echo $this->get_field_name('show_author'); ?>" type="checkbox" <?php checked($instance['show_author']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_author'); ?>"><?php _e('Author Archive Pages', 'wp-special-textboxes'); ?></label><br /></p>
<?php
		}
	} // End of class special_text
} // End of if

if (class_exists("SpecialTextBoxes")) {
	$stbObject = new SpecialTextBoxes();
	function stbHighlightText( $content = null, $id = 'warning', $caption = '', $atts = null ) {
		$stb = new SpecialTextBoxes();	
	  echo $stb->highlightText( $content, $id, $caption, $atts );
	}
}

if (class_exists("special_text")) {
	add_action('widgets_init', create_function('', 'return register_widget("special_text");'));
}
?>