<?php
if (!class_exists("SpecialTextBoxes")) {
  class SpecialTextBoxes {
    //var $adminOptionsName = "SpecialTextBoxesAdminOptions";
    var $stbInitOptions = array(
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
      'langDirect' => 'ltr' 
    );
    
    function __construct() {
      define('STB_VERSION', '3.8.55');
      define('STB_DIR', basename(dirname(__FILE__)));
      define('STB_DOMAIN', 'wp-special-textboxes');
      define('STB_OPTIONS', 'SpecialTextBoxesAdminOptions');
      define('STB_URL', WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__), "", plugin_basename( __FILE__ ) ));
      
      if (function_exists( 'load_plugin_textdomain' ))
        load_plugin_textdomain( STB_DOMAIN, false, STB_DIR );
      
     
      add_action('wp_head', array(&$this, 'addHeaderCSS'), 1);
      add_action('template_redirect', array(&$this, 'headerScripts'));
      add_shortcode('stextbox', array(&$this, 'doShortcode'));
      add_shortcode('stb', array(&$this, 'doShortcode'));
      add_shortcode('sgreybox', array(&$this, 'doShortcodeGrey'));
    }
    
    function getAdminOptions() {
      $stbAdminOptions = $this->stbInitOptions;
      $stbOptions = get_option(STB_OPTIONS);
      if (!empty($stbOptions)) {
        foreach ($stbOptions as $key => $option) 
          $stbAdminOptions[$key] = $option;        
      }
      if ( $stbAdminOptions['cb_image'] === '' )
        $stbAdminOptions['cb_image'] = STB_URL.'images/heart.png';
      if ( $stbAdminOptions['cb_bigImg'] === '' )
        $stbAdminOptions['cb_bigImg'] = STB_URL.'images/heart-b.png';
      return $stbAdminOptions;
    }
    
    function addHeaderCSS() {
      wp_enqueue_style('stbCSS', STB_URL.'css/wp-special-textboxes.css.php', false, STB_VERSION);
    }
    
    function headerScripts() {
      wp_enqueue_script('jquery');
      wp_enqueue_script('jquery-ui-effects', STB_URL.'js/jquery-ui-1.7.2.custom.min.js', array('jquery'), '1.7.2');
      wp_enqueue_script('wstbLayout', STB_URL.'js/wstb.js.php', array('jquery'), STB_VERSION);
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
        
        $toolImg = ($stbOptions['collapsing'] === 'true') ? '<div id="stb-tool" class="stb-tool" style="float:'.(($stbOptions['langDirect'] === 'ltr')?'right':'left').'; padding:0px; margin:0px auto"><img id="stb-toolimg" style="border: none; background-color: transparent; padding: 0px; margin: 0px auto;" src="'.STB_URL.(($collapsed) ? 'images/show.png" title="'.__('Show', STB_DOMAIN) : 'images/hide.png" title="'.__('Hide', STB_DOMAIN)).'" /></div>'  : '';
        
        // Image logic
        if ($atts['caption'] === '') {
          if ($atts['image'] === '') {
            if ($needResizing & ($stbOptions['showImg'] === 'true')) {
              if (!in_array($atts['id'], array('custom', 'grey'))) {
                $styleBody .= ( $atts['big'] === 'true' ) ? "background-image: url(".STB_URL.'images/'."{$atts['id']}-b.png); " : "background-image: url(".STB_URL.'images/'."{$atts['id']}.png); ";
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
    
    function highlightText( $content = null, $id = 'warning', $caption = '', $atts = null ) {
      return $this->drawTextBox( $content, $id, $caption, $atts );
    }
  }
}

if (!class_exists('special_text') && class_exists('WP_Widget')) {
  class special_text extends WP_Widget {
    function special_text() {
      $widget_ops = array( 'classname' => 'special_text', 'description' => __('Arbitrary text or PHP in colored block.', STB_DOMAIN));
      $control_ops = array( 'width' => 350, 'height' => 450, 'id_base' => 'special_text' );
      $this->WP_Widget( 'special_text', __('Special Text', STB_DOMAIN), $widget_ops, $control_ops );
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
      
      if($box_id !== 'none') {
        $before_title = '<div class="stb-'.$box_id.'-caption_box" style="margin-left: 0px; margin-right: 0px" >';
        $after_title = '</div>'.( !empty($title) ? '<div class="stb-'.$box_id.'-body_box" style="margin-left: 0px; margin-right: 0px" >' : '' );
        $before_widget = '<div class="stb-container">'.( empty($title) ? '<div class="stb-'.$box_id.'_box" style="margin-left: 0px; margin-right: 0px" >' : '' );
        $after_widget = '</div></div>';
      }
      
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
        'alert'    => __('Alert', STB_DOMAIN),
        'download' => __('Download', STB_DOMAIN),
        'info'     => __('Info', STB_DOMAIN),
        'warning'  => __('Warning', STB_DOMAIN),
        'black'    => __('Black', STB_DOMAIN),
        'custom'   => __('Custom', STB_DOMAIN),
        'none'     => __('Theme Style', STB_DOMAIN)
      );
      
      $instance = wp_parse_args((array) $instance, 
        array(
          'title'       => '', 
          'box_id'      => 'warning', 
          'parse'       => false, 
          'text'        => '', 
          'show_all'    => true, 
          'show_home'   => false, 
          'show_cat'    => false, 
          'show_arc'    => false, 
          'show_single' => false,
          'show_tag'    => false,
          'show_author' => false
        )
      );
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
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', STB_DOMAIN); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

    <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea><br />&nbsp;

    <p><label for="<?php echo $this->get_field_id('box_id'); ?>"><?php _e('ID of Box:', STB_DOMAIN) ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id('box_id'); ?>" name="<?php echo $this->get_field_name('box_id'); ?>" >
    <?php 
    foreach ($ids as $key => $option) echo '<option value='.$key.(($instance['box_id'] === $key) ? ' selected' : '' ).'>'.$option.'</option>';?> 
    </select></p>
    
    <p><input id="<?php echo $this->get_field_id('parse'); ?>" name="<?php echo $this->get_field_name('parse'); ?>" type="checkbox" <?php checked($instance['parse']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('parse'); ?>"><?php _e('Evaluate as PHP code.', STB_DOMAIN); ?></label></p>
    
    <p><input id="<?php echo $this->get_field_id('show_all'); ?>" name="<?php echo $this->get_field_name('show_all'); ?>" type="checkbox" <?php checked($instance['show_all']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_all'); ?>"><?php _e('Show on all pages of blog', STB_DOMAIN); ?></label></p>
    
    <p><?php _e('Show only on', STB_DOMAIN) ?>:<br />
    <input id="<?php echo $this->get_field_id('show_home'); ?>" name="<?php echo $this->get_field_name('show_home'); ?>" type="checkbox" <?php checked($instance['show_home']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_home'); ?>"><?php _e('Home Page', STB_DOMAIN); ?></label><br />
    <input id="<?php echo $this->get_field_id('show_single'); ?>" name="<?php echo $this->get_field_name('show_single'); ?>" type="checkbox" <?php checked($instance['show_single']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_single'); ?>"><?php _e('Single Post Pages', STB_DOMAIN); ?></label><br />
    <input id="<?php echo $this->get_field_id('show_arc'); ?>" name="<?php echo $this->get_field_name('show_arc'); ?>" type="checkbox" <?php checked($instance['show_arc']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_arc'); ?>"><?php _e('Archive Pages', STB_DOMAIN); ?></label><br />
    <input id="<?php echo $this->get_field_id('show_cat'); ?>" name="<?php echo $this->get_field_name('show_cat'); ?>" type="checkbox" <?php checked($instance['show_cat']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_cat'); ?>"><?php _e('Category Archive Pages', STB_DOMAIN); ?></label><br />
    <input id="<?php echo $this->get_field_id('show_tag'); ?>" name="<?php echo $this->get_field_name('show_tag'); ?>" type="checkbox" <?php checked($instance['show_tag']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_tag'); ?>"><?php _e('Tag Archive Pages', STB_DOMAIN); ?></label><br />
    <input id="<?php echo $this->get_field_id('show_author'); ?>" name="<?php echo $this->get_field_name('show_author'); ?>" type="checkbox" <?php checked($instance['show_author']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('show_author'); ?>"><?php _e('Author Archive Pages', STB_DOMAIN); ?></label><br /></p>
<?php
    }
  } // End of class special_text
} // End of if
?>
