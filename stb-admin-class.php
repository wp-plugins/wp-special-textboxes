<?php
include_once('stb-class.php');
if(!class_exists('SpecialTextBoxesAdmin') && class_exists('SpecialTextBoxes')) {
  class SpecialTextBoxesAdmin extends SpecialTextBoxes {
    public $settings;
    
    public function __construct() {
      parent::__construct();
      
      add_action('activate_wp-special-textboxes/wp-special-textboxes.php',  array(&$this, 'onActivate'));
      add_action('deactivate_wp-special-textboxes/wp-special-textboxes.php', array(&$this, 'onDeactivate'));
      add_action('admin_init', array(&$this, 'initSettings'));
      add_action('admin_menu', array(&$this, 'regAdminPage'));
      add_filter('tiny_mce_version', array(&$this, 'tinyMCEVersion'));
      add_action('init', array(&$this, 'addButtons'));
      
      $this->settings = parent::getAdminOptions();
    }
    
    public function onActivate() {
      $stbAdminOptions = $this->getAdminOptions();
      update_option(STB_OPTIONS, $stbAdminOptions);
    }
    
    public function onDeactivate() {
      delete_option(STB_OPTIONS);
    }
    
    public function addAdminHeaderCSS() {
      wp_enqueue_style('stbAdminCSS', STB_URL.'css/stb-admin.css', false, STB_VERSION);
      wp_enqueue_style('stbCSS', STB_URL.'css/wp-special-textboxes.css.php', false, STB_VERSION);
      wp_enqueue_style('ColorPickerCSS', STB_URL.'css/colorpicker.css');
    }
    
    public function adminHeaderScripts() {
      wp_enqueue_script('jquery');
      wp_enqueue_script('jquery-ui-effects', STB_URL.'js/jquery-ui-1.7.2.custom.min.js', array('jquery'), '1.7.2');
      wp_enqueue_script('ColorPicker', STB_URL.'js/colorpicker.js');
      wp_enqueue_script('wstbAdminLayout', STB_URL.'js/wstb.admin.js.php', array('jquery'), STB_VERSION);
    }
    
    private function getSamples() {
      $stbOptions = $this->getAdminOptions();
      $sampleBox = "<div class='stb-custom_box' >".__("This is example of Custom Special Text Box. You must save options to view changes.", STB_DOMAIN).'</div>';
      $sampleCaptionedBox = "<div id='stb-container' class='stb-container'><div id='caption' class='stb-custom-caption_box' >".__("This is caption", STB_DOMAIN);
      $sampleCaptionedBox .= "<div id='stb-tool' class='stb-tool' style='float:".(($stbOptions['langDirect'] === 'ltr')?'right':'left')."; padding:0px; margin:0px auto'><img id='stb-toolimg' style='border: none; background-color: transparent;' src='".WP_PLUGIN_URL.(($stbOptions['collapsed'] === 'true') ? "/wp-special-textboxes/images/show.png' title='".__('Show', STB_DOMAIN) : "/wp-special-textboxes/images/hide.png' title='".__('Hide', STB_DOMAIN))."' /></div></div>";
      $sampleCaptionedBox .= "<div id='body' class='stb-custom-body_box' >".__("This is example of Captioned Custom Special Text Box. You must save options to view changes.", STB_DOMAIN)."</div></div>";
      return $sampleBox.$sampleCaptionedBox;
    }
    
    public function regAdminPage() {
      if (function_exists('add_options_page')) {
        $plugin_page = add_options_page(__('Special Text Boxes', STB_DOMAIN), __('Special Text Boxes', STB_DOMAIN), 8, 'stb-settings', array(&$this, 'stbAdminPage'));
        add_action('admin_print_scripts-'.$plugin_page, array(&$this, 'adminHeaderScripts'));
        add_action('admin_print_styles-'.$plugin_page, array(&$this, 'addAdminHeaderCSS'));
      }
    }
    
    public function initSettings() {
      register_setting('stbOptions', STB_OPTIONS);
      
      add_settings_section('basicSection', __('Basic Settings', STB_DOMAIN), array(&$this, 'drawBasicSection'), 'stb-settings');
      add_settings_section('extendedSection', __('Extended Settings', STB_DOMAIN), array(&$this, 'drawExtendedSection'), 'stb-settings');
      add_settings_section('editorSection', __('Custom Box Editor', STB_DOMAIN), array(&$this, 'drawEditorSection'), 'stb-settings');
      
      add_settings_field('border_style', __("Select border style for Special Text Boxes", STB_DOMAIN), array(&$this, 'drawSelectOption'), 'stb-settings', 'basicSection', array('optionName' => 'border_style', 'description' => __('Selecting "None" will disable Special Text Boxes border.', STB_DOMAIN), "options" => array( 'solid' => __('Solid', STB_DOMAIN), 'dashed' => __('Dashed', STB_DOMAIN), 'dotted' => __('Dotted', STB_DOMAIN), 'none' => __('None', STB_DOMAIN) )));
      add_settings_field('top_margin', __("Define top margin for Special Text Boxes", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'basicSection', array('optionName' => 'top_margin', 'description' => __("This is a gap between top edge of Special Text Box and text above.", STB_DOMAIN)));
      add_settings_field('left_margin', __("Define left margin for Special Text Boxes", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'basicSection', array('optionName' => 'left_margin', 'description' => __("This is a gap between left edge of Special Text Box and left edge of post area.", STB_DOMAIN)));
      add_settings_field('right_margin', __("Define right margin for Special Text Boxes", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'basicSection', array('optionName' => 'right_margin', 'description' => __("This is a gap between right edge of Special Text Box and right edge of post area.", STB_DOMAIN)));
      add_settings_field('bottom_margin', __("Define bottom margin for Special Text Boxes", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'basicSection', array('optionName' => 'bottom_margin', 'description' => __("This is a gap between bottom edge of Special Text Box and text below.", STB_DOMAIN)));
      add_settings_field('fontSize', __("Define font size for Special Text Boxes", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'basicSection', array('optionName' => 'fontSize', 'description' => __("This is font size in pixels.", STB_DOMAIN).' '.__("Set this parameter to value 0 for theme default font size.", STB_DOMAIN)));
      add_settings_field('captionFontSize', __("Define caption font size for Special Text Boxes", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'basicSection', array('optionName' => 'captionFontSize', 'description' => __("This is caption font size in pixels.", STB_DOMAIN).' '.__("Set this parameter to value 0 for theme default font size.", STB_DOMAIN)));
      add_settings_field('bigImg', __('Allow Big Image for Simple (non-captioned) Special Text Boxes?', STB_DOMAIN), array(&$this, 'drawRadioOption'), 'stb-settings', 'basicSection', array('optionName' => 'bigImg', 'description' => __('Selecting "Yes" will allow big icons for simple (non-captioned) Special Text Boxes.', STB_DOMAIN), 'options' => array( 'true' => __("Yes", STB_DOMAIN), 'false' => __("No", STB_DOMAIN))));
      add_settings_field('langDirect', __('Define language direction', STB_DOMAIN), array(&$this, 'drawRadioOption'), 'stb-settings', 'basicSection', array('optionName' => 'langDirect', 'description' => __('Selecting "Left-to-Right" will set Left-to-Right language direction for Special Text Boxes and visa versa.', STB_DOMAIN), 'options' => array( 'ltr' => __('Left-to-Right', STB_DOMAIN), 'rtl' => __('Right-to-Left', STB_DOMAIN))));
      add_settings_field('showImg', __('Allow icon images for Special Text Boxes?', STB_DOMAIN), array(&$this, 'drawRadioOption'), 'stb-settings', 'basicSection', array('optionName' => 'showImg', 'description' => __('Selecting "Yes" will allow displaying icon images in Special Text Boxes.', STB_DOMAIN), "options" => array( 'true' => __("Yes", STB_DOMAIN), 'false' => __("No", STB_DOMAIN))));
      add_settings_field('collapsing', __('Allow collapsing/expanding captioned Special Text Boxes?', STB_DOMAIN), array(&$this, 'drawRadioOption'), 'stb-settings', 'basicSection', array('optionName' => 'collapsing', 'description' => __('Selecting "Yes" will allow displaying show/hide button in captioned Special Text Boxes.', STB_DOMAIN), 'options' => array( 'true' => __('Yes', STB_DOMAIN), 'false' => __('No', STB_DOMAIN))));
      add_settings_field('collapsed', __('Allow "collapsed on load" captioned Special Text Boxes?', STB_DOMAIN), array(&$this, 'drawRadioOption'), 'stb-settings', 'basicSection', array('optionName' => 'collapsed', 'description' => __('Selecting "Yes" will allow displaying collapsed captioned Special Text Boxes after page loading.', STB_DOMAIN), 'options' => array( 'true' => __('Yes', STB_DOMAIN), 'false' => __('No', STB_DOMAIN))));
      
      add_settings_field('rounded_corners', __("Allow rounded corners for Special Text Boxes?", STB_DOMAIN), array(&$this, 'drawRadioOption'), 'stb-settings', 'extendedSection', array('optionName' => 'rounded_corners', 'description' => __('Selecting "No" will disable Special Text Boxes rounded corners.', STB_DOMAIN), 'options' => array( 'true' => __('Yes', STB_DOMAIN), 'false' => __('No', STB_DOMAIN))));
      add_settings_field('box_shadow', __("Allow box shadow for Special Text Boxes?", STB_DOMAIN), array(&$this, 'drawRadioOption'), 'stb-settings', 'extendedSection', array('optionName' => 'box_shadow', 'description' => __('Selecting "No" will disable Special Text Boxes shadow.', STB_DOMAIN), 'options' => array( 'true' => __('Yes', STB_DOMAIN), 'false' => __('No', STB_DOMAIN))));
      add_settings_field('text_shadow', __('Allow text shadow for Special Text Boxes?', STB_DOMAIN), array(&$this, 'drawRadioOption'), 'stb-settings', 'extendedSection', array('optionName' => 'text_shadow', 'description' => __('Selecting "No" will disable Special Text Boxes text shadow.', STB_DOMAIN), 'options' => array( 'true' => __('Yes', STB_DOMAIN), 'false' => __('No', STB_DOMAIN))));
      
      add_settings_field('cb_color', __("Define font color for Custom Special Text Box", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'editorSection', array('optionName' => 'cb_color', 'description' => __("This is a font color of Custom Special Text Box (Six Hex Digits).", STB_DOMAIN)));
      add_settings_field('cb_caption_color', __("Define caption font color for Custom Special Text Box", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'editorSection', array('optionName' => 'cb_caption_color', 'description' => __("This is a font color of Custom Special Text Box caption (Six Hex Digits).", STB_DOMAIN)));
      add_settings_field('cb_fontSize', __("Define font size for Custom Special Text Box", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'editorSection', array('optionName' => 'cb_fontSize', 'description' => __("This is font size in pixels.", STB_DOMAIN).' '.__("Set this parameter to value 0 for theme default font size.", STB_DOMAIN)));
      add_settings_field('cb_captionFontSize', __("Define caption font size for Custom Special Text Box", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'editorSection', array('optionName' => 'cb_captionFontSize', 'description' => __("This is caption font size in pixels.", STB_DOMAIN).' '.__("Set this parameter to value 0 for theme default font size.", STB_DOMAIN)));
      add_settings_field('cb_background', __("Define background color for Custom Special Text Box", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'editorSection', array('optionName' => 'cb_background', 'description' => __("This is a background color of Custom Special Text Box (Six Hex Digits).", STB_DOMAIN)));
      add_settings_field('cb_caption_background', __("Define background color for Custom Special Text Box caption", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'editorSection', array('optionName' => 'cb_caption_background', 'description' => __("This is a background color of Custom Special Text Box caption (Six Hex Digits).", STB_DOMAIN)));
      add_settings_field('cb_border_color', __("Define border color for Custom Special Text Box", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'editorSection', array('optionName' => 'cb_border_color', 'description' => __("This is a border color of Custom Special Text Box (Six Hex Digits).", STB_DOMAIN)));
      add_settings_field('cb_image', __("Define image for Custom Special Text Box", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'editorSection', array('optionName' => 'cb_image', 'description' => __("This is an image of Custom Special Text Box (Full URL). 25x25 pixels, transparent background PNG image recommended.", STB_DOMAIN), 'width' => 100));
      add_settings_field('cb_bigImg', __("Define big image for simple (non-captioned) Custom Special Text Box", STB_DOMAIN), array(&$this, 'drawTextOption'), 'stb-settings', 'editorSection', array('optionName' => 'cb_bigImg', 'description' => __("This is big image for simple (non-captioned) Custom Special Text Box (Full URL). 50x50 pixels, transparent background PNG image recommended.", STB_DOMAIN), 'width' => 100));
    }
    
    public function doSettingsSections($page) {
      global $wp_settings_sections, $wp_settings_fields;

      if ( !isset($wp_settings_sections) || !isset($wp_settings_sections[$page]) )
        return;

      $i = 0;
      
      echo '<div class="dashboard-widgets-wrap">';
      echo '<div id="dashboard-widgets" class="metabox-holder">';
      foreach ( (array) $wp_settings_sections[$page] as $section ) {
        if($i == 0) {
          echo '<div class="postbox-container" style="width: 49%;">';
          echo '<div id="normal-sortables" class="meta-box-sortables ui-sortable">';
        }
        elseif($i == 2) {
          echo '<div class="postbox-container" style="width: 49%;">';
          echo '<div id="side-sortables" class="meta-box-sortables ui-sortable">';
        }
        echo "<div id='{$section['id']}' class='postbox'>"; 
        echo "<h3 class='hndle'>{$section['title']}</h3>\n";
        echo '<div class="inside">';
        call_user_func($section['callback'], $section);
        if ( !isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section['id']]) )
          continue;
        $this->doSettingsFields($page, $section['id']);
        echo '</div>';
        echo '</div>';
        if($i > 0) {
          echo '</div>';
          echo '</div>';
        }
        
        $i++;
      }
      echo '</div></div>';
    }
    
    public function doSettingsFields($page, $section) {
      global $wp_settings_fields;

      if ( !isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section]) )
        return;

      foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
        echo '<p>';
        if ( !empty($field['args']['checkbox']) ) {
          call_user_func($field['callback'], $field['args']);
          echo '<label for="' . $field['args']['label_for'] . '">' . $field['title'] . '</label>';
          echo '</p>';
        }
        else {
          if ( !empty($field['args']['label_for']) )
            echo '<label for="' . $field['args']['label_for'] . '">' . $field['title'] . '</label>';
          else
            echo '<strong>' . $field['title'] . '</strong><br/>';
          echo '</p>';
          echo '<p>';
          call_user_func($field['callback'], $field['args']);
          echo '</p>';
        }
        if(!empty($field['args']['description'])) echo '<p>' . $field['args']['description'] . '</p>';
      }
    }
    
    public function drawBasicSection() {
      echo '';
    }
    
    public function drawExtendedSection() {
      echo '<p>'.__('Parameters below add elements of CSS3 standard to Style Sheet. Not all browsers can interpret this elements properly, but including this elements to HTML page not crash browser.', STB_DOMAIN).'</p>';
    }
    
    public function drawEditorSection() {
      echo '<p>'.__('Use parameters below for customising custom Special Text Box.', STB_DOMAIN).'</p>';
      echo $this->getSamples();
    }
    
    public function drawSelectOption( $args ) {
      $optionName = $args['optionName'];
      $options = $args['options'];
      ?>
        <select id="<?php echo $optionName; ?>"
          name="<?php echo STB_OPTIONS.'['.$optionName.']'; ?>">
          <?php foreach($options as $key => $option) { ?>
            <option value="<?php echo $key; ?>" 
              <?php selected($key, $this->settings[$optionName]); ?> ><?php echo $option; ?>
            </option>
          <?php } ?>
        </select>
      <?php
    }
    
    public function drawRadioOption( $args ) {
      $optionName = $args['optionName'];
      $options = $args['options'];
      foreach ($options as $key => $option) {
      ?>
        <label for="<?php echo $optionName.'_'.$key; ?>">
          <input type="radio" 
            id="<?php echo $optionName.'_'.$key; ?>" 
            name="<?php echo STB_OPTIONS.'['.$optionName.']'; ?>" 
            value="<?php echo $key; ?>" <?php checked($key, $this->settings[$optionName]); ?> /> 
          <?php echo $option;?>
        </label>&nbsp;&nbsp;&nbsp;&nbsp;
      <?php
      }
    }
    
    public function drawTextOption( $args ) {
      $optionName = $args['optionName'];
      $width = $args['width'];
      ?>
        <input id="<?php echo $optionName; ?>"
          name="<?php echo STB_OPTIONS.'['.$optionName.']'; ?>"
          type="text"
          value="<?php echo $this->settings[$optionName]; ?>" 
          style="height: 22px; font-size: 11px; <?php if(!empty($width)) echo 'width: '.$width.'%;' ?>" />
      <?php
    }

    public function drawCheckboxOption( $args ) {
      $optionName = $args['optionName'];
      ?>
        <input id="<?php echo $optionName; ?>"
          <?php checked('1', $this->settings[$optionName]); ?>
          name="<?php echo STB_OPTIONS.'['.$optionName.']'; ?>"
          type="checkbox"
          value="1" />
      <?php
    }
    
    public function stbAdminPage() {
      $this->settings = parent::getAdminOptions();
      ?>
      <div class="wrap">
        <?php screen_icon("options-general"); ?>
        <h2><?php echo _e("Special Text Boxes Settings", STB_DOMAIN); ?></h2>
        <p><?php echo __('Plugin version', STB_DOMAIN).': <strong>'.STB_VERSION.'</strong>'; ?></p>
        <?php
        if(isset($_GET['updated'])) $updated = $_GET['updated'];
        if($updated === 'true') {
        ?>
        <!--<div class="updated"><p><strong><?php _e("Special Text Boxes Settings Updated.", STB_DOMAIN); ?></strong></p></div>-->
        <?php } else { ?>
        <div class="clear"></div>
        <?php } ?>
        <form action="options.php" method="post">
          <?php settings_fields('stbOptions'); ?>
          <?php $this->doSettingsSections('stb-settings'); ?>
          <p class="submit">
            <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
          </p>
        </form>
      </div>
      <?php
    }
    
    public function addButtons() {
      // Don't bother doing this stuff if the current user lacks permissions
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
        return;
      
      // Add only in Rich Editor mode
      if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", array(&$this, "addTinyMCEPlugin"));
        add_filter('mce_buttons', array(&$this, 'registerButton'));
      }
    }
    
    public function registerButton( $buttons ) {
      array_push($buttons, "separator", "wstb");
      return $buttons;
    }
    
    public function addTinyMCEPlugin( $plugin_array ) {
      $plugin_array['wstb'] = plugins_url('wp-special-textboxes/js/editor_plugin.js');
      return $plugin_array;
    }
    
    public function tinyMCEVersion( $version ) {
      return ++$version;
    }
  }
}
?>
