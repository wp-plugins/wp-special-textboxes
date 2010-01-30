=== Special Text Boxes ===
Contributors: minimus
Donate link: http://simplelib.co.cc/
Tags: content, performance, text, code, php, widget
Requires at least: 2.6
Tested up to: 2.9.1
Stable tag: 3.4.40

Highlights any portion of text as text in the colored boxes.

== Description ==

Adds little style sheet file and short code to blog for highlighting some portion of text in post as colored boxes. That may be warning, alert, info and download portion of post�s text.

__WARNING!!!__ __Special Text widget__ works only under __Wordpress 2.8+__ !

Available languages:

  * English
  * Russian
  * Italian by [Gianni Diurno](http://gidibao.net/)
  * Belarus by [Fat Cower](http://www.fatcow.com)
  * Uzbek by [Alisher Safarov](http://www.comfi.com)
  * Polish by [Daniel Fruzynski](http://www.poradnik-webmastera.com)
  * Arabic language by [مدونة رسين](http://www.r-sn.com/wp/)

If you have created your own language pack, or have an update of an existing one, you can send __.po__ and __.mo files__ to me so that I can bundle it into __Special Text Boxes__.
  
Real examples of outputs you can see on the [plugin page](http://simplelib.co.cc/?p=11)

== Installation ==

1. Upload plugin dir to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use short codes in the text of post to highlight any portion of it.

== Frequently Asked Questions ==

= How to insert special text box to post's text? =

Use short codes: 

`[stextbox id="ValidID"]Highlighted text here[/stextbox]`

or (for captioned textbox)

`[stextbox id="ValidID" caption="CaptionText"]Highlighted text here[/stextbox]`

were
 
__ValidID__ may be: _alert_, _info_, _download_, _grey_, _black_, _warning_, _custom_

__CaptionText__ may be: _any text you needed_.

= How to insert special text box to theme file (not to post)? =

Use function __stbHighlightText__: 

`<?php if(function_exists('stbHighlightText')) stbHighlightText('Test of function stbHighlightText.', 'warning'); ?>` 

defined as 

`function stbHighlightText( $content = null, $id = 'warning', $caption = '', $atts = null )`

= Can I use Special Text widget with Wordpress 2.7? =

No! _Special Text widget_ wrote with using _Wordpress Widget Factory technology_ and this one can work only under Wordpress 2.8 and higher!

More about Special Text Boxes usage and customising read on the [plugin page](http://simplelib.co.cc/?p=11)

== Screenshots ==

1. Examples of special textboxes
2. Special Text Boxes Admin Page
3. Special Text Boxes Custom Box Editor
4. Insertion dialog. Basic Settings
5. Insertion dialog. Extended Settings
6. Special Text widget. Admin Page


== Changelog ==

= 3.4.40 =
* Font size parameters are added
* Bug of caption size is eliminated
* Language pack is updated. Arabic language by [مدونة رسين](http://www.r-sn.com/wp/) is added. 
* Support of text direction is added.
* Codes are optimised
= 3.3.35 =
* Collapsing/Expanding mode of captioned Special Text Boxes was extended
* PHP codes was optimised
* JS codes was optimised
= 3.2.32 =
* Collapsing/Expanding of captioned Special Text Boxes was added
* Codes was optimised
= 3.1.29 =
* Some admin page improvements was added
* Codes was optimised
= 3.0.27 =
* Special Text widget was added
* Special Text Box Float Mode was added
= 2.0.25 =
* Polish language pack by [Daniel Fruzynski](http://www.poradnik-webmastera.com) added
* Italian language pack updated
= 2.0.23 =
* Uzbek language pack by [Alisher Safarov](http://www.comfi.com) added
* Wordpress 2.8.4 compatibility tested
= 2.0.22 =
* Direct output codes optimised
* Italian language pack updated
= 2.0.20 =
* Plugin style sheet optimised
* Big icons for simple (non-captioned) boxes added
* Short Codes Insert Dialog added
* Output function added
* Plugin codes optimised
= 1.2.13 =
* Belarus language by [Fat Cower](http://www.fatcow.com) added
* Wordpress 2.8.1 compatibility tested
= 1.2.12 =
* Italian language by [Gianni Diurno](http://gidibao.net/) added
= 1.2.11 =
* custom box added
* custom editor added
* customising "on the fly" added
* Wordpress 2.8 compatibility checked
= 1.1.7 =
* black box margins bug fixed
= 1.1.6 =
* codes and variables cleanup
	* admin page codes optimised
	* activation codes optimised for future upgrades
* margin settings added
= 1.0.1 =
* Initial upload

== Upgrade Notice ==

= 3.4.40 =
Font size parameters are added
Bug of caption size is eliminated
Language pack is updated. Arabic language by [مدونة رسين](http://www.r-sn.com/wp/) is added.
Support of text direction is added.
Codes are optimised
= 3.3.35 =
Collapsing/Expanding mode of captioned Special Text Boxes was extended
PHP codes was optimised
JS codes was optimised
= 3.2.32 =
Collapsing/Expanding of captioned Special Text Boxes was added
Codes was optimised
= 3.1.29 =
Some admin page improvements was added
Codes was optimised
= 3.0.27 =
Special Text widget was added
Special Text Box Float Mode was added
= 2.0.25 =
Polish language pack by [Daniel Fruzynski](http://www.poradnik-webmastera.com) added
Italian language pack updated
= 2.0.23 =
Uzbek language pack by [Alisher Safarov](http://www.comfi.com) added
Wordpress 2.8.4 compatibility tested
= 2.0.22 =
Direct output codes optimised
Italian language pack updated
= 2.0.20 =
Plugin style sheet optimised
Big icons for simple (non-captioned) boxes added
Short Codes Insert Dialog added
Output function added
Plugin codes optimised
= 1.2.13 =
Belarus language by [Fat Cower](http://www.fatcow.com) added
Wordpress 2.8.1 compatibility tested
= 1.2.12 =
Italian language by [Gianni Diurno](http://gidibao.net/) added
= 1.2.11 =
custom box added
custom editor added
customising "on the fly" added
Wordpress 2.8 compatibility checked
= 1.1.7 =
black box margins bug fixed
= 1.1.6 =
codes and variables cleanup
admin page codes optimised
activation codes optimised for future upgrades
margin settings added
= 1.0.1 =
Initial upload
	
== Other Notes ==

This plugin is using jQuery ColorPicker plugin by [Stefan Petre](http://www.eyecon.ro)