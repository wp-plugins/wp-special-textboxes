<?php
if(!class_exists('StbBlock')) {
  class StbBlock {
    private $data = array(
      'content' => null,
      'id' => 'warning',
      'caption' => '',
      'atts' => array(),
      'idNum' => 0
    );
    
    public $block = '';
    
    public function __construct($content = null, $id = 'warning', $caption = '', $atts = null) {
      $this->data['content'] = $content;
      $this->data['id'] = $id;
      $this->data['caption'] = $caption;
      $this->data['atts'] = $atts;
      $this->data['idNum'] = rand(1, 9999);
      
      $this->block = $this->buildBlock($this->data);
    }
    
    private function getSettings() {
      $settings = get_option(STB_OPTIONS, '');
      return $settings;
    }
    
    private function extendedStyleLogic($atts = null, $idNum = 0) {
      if(is_null($atts)) return '';
      
      $settings = $this->getSettings();
      
      $styleStart = 'style="';
      $styleBody = '';
      $styleCaption = '';
      $styleEnd = '"';
      $floatStart = '';
      $floatEnd = '';
      
      if($atts['collapsing'] === 'default') $collapsing = ($settings['collapsing'] === 'true');
      else $collapsing = ($atts['collapsing'] === 'true'); 
      $collapsed = ($settings['collapsing'] === 'true') && (($atts['collapsed'] === 'true') || (($settings['collapsed'] === 'true') && ($atts['collapsed'] !== 'false')));
      
      if ( is_array($atts) ) {
        $needResizing = ( ( $atts['big'] !== '' ) & ( $atts['big'] !==  $settings['bigImg'] ) );
        
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
        
        $toolImg = ($collapsing) ? '<div id="stb-tool-'.$idNum.'" class="stb-tool" style="float:'.(($settings['langDirect'] === 'ltr')?'right':'left').'; padding:0px; margin:0px auto"><img id="stb-toolimg-'.$idNum.'" style="border: none; background-color: transparent; padding: 0px; margin: 0px auto;" src="'.STB_URL.(($collapsed) ? 'images/show.png" title="'.__('Show', STB_DOMAIN) : 'images/hide.png" title="'.__('Hide', STB_DOMAIN)).'" /></div>'  : '';
        
        // Image logic
        if ($atts['caption'] === '') {
          if ($atts['image'] === '') {
            if ($needResizing & ($settings['showImg'] === 'true')) {
              if (!in_array($atts['id'], array('custom', 'grey'))) {
                $styleBody .= ( $atts['big'] === 'true' ) ? "background-image: url(".STB_URL.'images/'."{$atts['id']}-b.png); " : "background-image: url(".STB_URL.'images/'."{$atts['id']}.png); ";
                $styleBody .= ( $atts['big'] === 'true' ) ? 'min-height: 40px; padding-'.(($settings['langDirect'] === 'ltr')?'left':'right').': 50px; ' : 'min-height: 20px; padding-'.(($settings['langDirect'] === 'ltr')?'left':'right').': 25px; ';
              } elseif ($atts['id'] === 'custom') {
                $styleBody .= ( $atts['big'] === 'true' ) ? "background-image: url({$settings['cb_bigImg']}); " : "background-image: url({$settings['cb_image']}); ";
                $styleBody .= ( $atts['big'] === 'true' ) ? 'min-height: 40px; padding-'.(($settings['langDirect'] === 'ltr')?'left':'right').': 50px; ' : 'min-height: 20px; padding-'.(($settings['langDirect'] === 'ltr')?'left':'right').': 25px; ';
              } else {
                $styleBody .= 'min-height: 20px; padding-'.(($settings['langDirect'] === 'ltr')?'left':'right').': 5px; ';
              }              
            }
          } elseif ($atts['image'] === 'null') {
            $styleBody .= 'background-image: url(none); min-height: 20px; padding-'.(($settings['langDirect'] === 'ltr')?'left':'right').': 5px; ';
          } else {
            $styleBody .= "background-image: url({$atts['image']}); ";
            if ($needResizing | ($settings['showImg'] === 'false')) $styleBody .= ( $atts['big'] === 'true' ) ? 'min-height: 40px; padding-'.(($settings['langDirect'] === 'ltr')?'left':'right').': 50px; ' : 'min-height: 20px; padding-'.(($settings['langDirect'] === 'ltr')?'left':'right').': 25px; ';
          }
          if(($atts['mtop'] !== '') || ($atts['mleft'] !== '') || ($atts['mbottom'] !== '') || ($atts['mright'] !== '')) {
            $mTop = ($atts['mtop'] !== '') ? $atts['mtop'] : $settings['top_margin'];
            $mLeft = ($atts['mleft'] !== '') ? $atts['mleft'] : $settings['left_margin'];
            $mBottom = ($atts['mbottom'] !== '') ? $atts['mbottom'] : $settings['bottom_margin'];
            $mRight = ($atts['mright'] !== '') ? $atts['mright'] : $settings['right_margin'];
            $styleBody .= "margin: {$mTop}px {$mRight}px {$mBottom}px {$mLeft}px; ";
          }
        } else {          
          if ( $collapsed ) {
            $styleBody .= 'display: none; ';
            $styleCaption .= '-webkit-border-bottom-left-radius: 5px; -webkit-border-bottom-right-radius: 5px; -moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; ';
            if(($atts['mtop'] !== '') || ($atts['mleft'] !== '') || ($atts['mbottom'] !== '') || ($atts['mright'] !== '')) {
              $mTop = ($atts['mtop'] !== '') ? $atts['mtop'] : $settings['top_margin'];
              $mLeft = ($atts['mleft'] !== '') ? $atts['mleft'] : $settings['left_margin'];
              $mBottom = ($atts['mbottom'] !== '') ? $atts['mbottom'] : $settings['bottom_margin'];
              $mRight = ($atts['mright'] !== '') ? $atts['mright'] : $settings['right_margin'];
              $styleBody .= "margin: 0px {$mRight}px {$mBottom}px {$mLeft}px; ";
              $styleCaption .= "margin: {$mTop}px {$mRight}px {$mBottom}px {$mLeft}px; ";
            }
          } else {
            if(($atts['mtop'] !== '') || ($atts['mleft'] !== '') || ($atts['mbottom'] !== '') || ($atts['mright'] !== '')) {
              $mTop = ($atts['mtop'] !== '') ? $atts['mtop'] : $settings['top_margin'];
              $mLeft = ($atts['mleft'] !== '') ? $atts['mleft'] : $settings['left_margin'];
              $mBottom = ($atts['mbottom'] !== '') ? $atts['mbottom'] : $settings['bottom_margin'];
              $mRight = ($atts['mright'] !== '') ? $atts['mright'] : $settings['right_margin'];
              $styleBody .= "margin: 0px {$mRight}px {$mBottom}px {$mLeft}px; ";
              $styleCaption .= "margin: {$mTop}px {$mRight}px 0px {$mLeft}px; ";
            }
          }           
          if ( $atts['image'] !== '' )
            $styleCaption .= ( $image === 'null' ) ? "background-image: url(none); padding-".(($settings['langDirect'] === 'ltr')?'left':'right').": 5px; " : "background-image: url({$atts['image']}); padding-".(($settings['langDirect'] === 'ltr')?'left':'right').": 25px; ";
        }
        
        return array('body' => ( $styleBody !== '' ) ? $styleStart.$styleBody.$styleEnd : '', 
                     'caption' => ( $styleCaption !== '' ) ? $styleStart.$styleCaption.$styleEnd : '',
                     'floatStart' => $floatStart,
                     'floatEnd' => $floatEnd,
                     'toolImg' => $toolImg);
      }
      else return '';
    }
    
    private function buildBlock($data) {
      $content = $data['content'];
      $id = $data['id'];
      $caption = $data['caption'];
      $atts = $data['atts'];
      $idNum = $data['idNum'];
      
      $stextbox_classes = array( 'alert', 'download', 'info', 'warning', 'black', 'custom' );
      $block = array('body' => '', 'caption' => '', 'floatStart' => '', 'floatEnd' => '');
      $cntStart = "<div id='stb-container-{$idNum}' class='stb-container'>";
      $cntEnd = '</div>';
      
      if (!is_null($atts) && is_array($atts)) {
        $block = $this->extendedStyleLogic(
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
              'collapsed' => '',
              'mtop' => '',
              'mleft' => '',
              'mbottom' => '',
              'mright' => '',
              'collapsing' => 'default' ), 
             $atts),
        $idNum);
      } else return do_shortcode($content);
      if ( $caption === '') {
        if ( in_array( $id, $stextbox_classes ) ) {
          return $block['floatStart']."<div id='stb-box-{$idNum}' class='stb-{$id}_box' {$block['body']}>" . do_shortcode($content) . "</div>".$block['floatEnd'];
        } elseif ( $id === 'grey' ) {
          return $block['floatStart']."<div id='stb-box-{$idNum}' class='stb-{$id}_box' {$block['body']}>{$content}</div>".$block['floatEnd'];
        } else { 
          return do_shortcode($content);  
        }
      } else {
        if ( in_array( $id, $stextbox_classes ) ) {
          return $block['floatStart']. $cntStart ."<div id='stb-caption-box-{$idNum}' class='stb-{$id}-caption_box stb_caption' {$block['caption']}>" . $caption . $block['toolImg'] . "</div><div id='stb-body-box-{$idNum}' class='stb-{$id}-body_box stb_body' {$block['body']}>" . do_shortcode($content) . "</div>". $cntEnd .$block['floatEnd'];
        } elseif ( $id === 'grey' ) {
          return $block['floatStart']."<div id='stb-caption-box-{$idNum}' class='stb-{$id}-caption_box' {$block['caption']}>{$caption}</div><div id='stb-body-box-{$idNum}' class='stb-{$id}-body_box' {$block['body']}>{$content}</div>".$block['floatEnd'];
        } else { 
          return do_shortcode($content);  
        }
      }
    }
  }
}
?>
