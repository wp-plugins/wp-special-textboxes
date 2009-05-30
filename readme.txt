=== wp-special-textboxes ===
Contributors: minimus
Donate link: http://simplelib.co.cc/
Tags: content, performance, text
Requires at least: 2.6
Tested up to: 2.8
Stable tag: 1.2.10

Highlights any portion of text as text in the colored boxes.

== Description ==

wp-special-textboxes is very simple, very little and very usefull Wordpress plugin (for me and, I hope, for you). It adds little style sheet file and short code to blog for highlighting some portion of text in post as colored boxes. That may be warning, alert, info and download portion of post’s text.

Available languages:

  * English
  * Russian

If you have created your own language pack, or have an update of an existing one, you can send __.po__ and __.mo files__ to me so that I can bundle it into __wp-special-textboxes__.

= Version History =

* 1.0.1
	* Initial upload
* 1.1.6
	* codes and variables cleanup
		* admin page codes optimised
		* activation codes optimised for future upgrades
	* margin settings added
* 1.1.7
	* black box margins bug fixed
* 1.2.10
	* custom box added
	* custom editor added
	* customising "on the fly" added
	* Wordpress 2.8 compatibility checked
  
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
 
__ValidID__ may be: _alert_, _info_, _download_, _grey_, _black_, _custom_

__CaptionText__ may be: _any text you needed_.

== Screenshots ==

1. Examples of special textboxes
2. wp-special-textboxes Admin Page
3. wp-special-textboxes Custom Box Editor