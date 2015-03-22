=== Unique Headers ===
Contributors: ryanhellyer
Tags: custom-header, header, headers, images, page, post, plugin, image, images, categories, gallery, media, header-image, header-images, taxonomy, tag, category, posts, pages, taxonomies, post, page, unique, custom
Donate link: https://geek.hellyer.kiwi/donate/
Requires at least: 4.1
Tested up to: 4.2
Stable tag: 1.3.11



Adds the ability to use unique custom header images on individual pages, posts or categories or tags.

== Description ==

= Features =
The <a href="https://geek.hellyer.kiwi/products/unique-headers/">Unique Headers Plugin</a> adds a custom header image box to the post/page edit screen. You can use this to upload a unique header image for that post, or use another image from your WordPress media library. When you view that page on the front-end of your site, the default header image for your site will be replaced by the unique header you selected.

To use this functionality with categories or tags, you will also need to install the excellent <a href="http://wordpress.org/extend/plugins/taxonomy-metadata/">Taxonomy Metadata plugin</a>.

= Requirements =
You must use a theme which utilizes the built-in custom header functionality of WordPress. If your theme implement it's own header functionality, then this plugin will not work with it.

= Language support =
The plugin includes translations for the following languages:
1. Spanish - provided by <a href="http://westoresolutions.com/">Mariano J. Ponce</a>
2. German - provided by <a href="http://www.graphicana.de/">Tobias Klotz</a>


== Installation ==

After you've downloaded and extracted the files:

1. Upload the complete 'unique-headers' folder to the '/wp-content/plugins/' directory OR install via the plugin installer
2. Activate the plugin through the 'Plugins' menu in WordPress
3. If you need custom headers on taxonomy, category or tags pages, then also install and activate the <a href="http://wordpress.org/extend/plugins/taxonomy-metadata/">Taxonomy Metadata plugin</a>.
4. And yer done!

Now you will see a new custom header image uploader whilst editing your site.

Visit the <a href="https://geek.hellyer.kiwi/products/unique-headers/">Unique Headers Plugin</a> for more information.


== Frequently Asked Questions ==

= I can't change the image on my categories/tags, what's wrong? =
You need to install the <a href="http://wordpress.org/extend/plugins/taxonomy-metadata/">Taxonomy Metadata plugin</a>. WordPress does not support
the taxonomy meta data which this plugin needs to use to store the custom header image URL. As soon as you install that plugin, the category/tag image
functionality should begin working.

= Your plugin doesn't work =
Actually, it does work ;) The problem is likely with your theme. Some themes have "custom headers", but don't use the built-in WordPress custom header system and will not work with the Unique Headers plugin because of this. It is not possible to predict how other custom header systems work, and so those can not be supported by this plugin. To test if this is the problem, simply switch to one of the default themes which come with WordPress and see if the plugin works with those, if it does, then your theme is at fault.

= My theme doesn't work with your plugin, how do I fix it? =
This is a complex question and not something I can teach in a short FAQ. I recommend hiring a professional WordPress developer for assistance, or asking the developer of your theme to add support for the built-in WordPress custom header system.

This is because WordPress does not provide a place for us to store data connected to a taxonomy such as a category or post tag. The Taxonomy Metadata plugin works around this problem by implement taxonomy meta. Future versions of WordPress are likely to include taxonomy meta baked in, and when this happens, the Unique Headers plugin will be updated to use that new functionality.

= Does it work with custom post-types? =
Not out of the box, but you can modify the following code to add support to suit your own requirements. You can can add this code to either your theme or to a custom plugin. You will need to modify the post-type to suit your own requirements. Some knowledge of PHP coding is necessary for this step.

`
<?php

/*
 * Add support for a post-type called "some-post-type"
 *
 * @param   array   $post_types   The currently supported post-types
 * @return  array   $post_types   The modified list of supported post-types
 */
function unique_headers_add_post_type( $post_types ) {
	$post_types[] = 'some-post-type';

	return $post_types;
}
add_filter( 'unique_headers_post_types', 'unique_headers_add_post_type' );

?>
`

= Does it work with taxonomies? =
As with custom post-types, not out of the box. You can however modify the following code to add support to suit your own requirements. You can can add this code to either your theme or to a custom plugin. You will need to modify the taxonomy to suit your own requirements. Some knowledge of PHP coding is necessary for this step.

`
<?php

/*
 * Add support for a taxonomy called "some-taxonomy"
 *
 * @param   array   $taxonomies   The currently supported taxonomies
 * @return  array   $taxonomies   The modified list of supported taxonomies
 */
function unique_headers_add_taxonomy( $taxonomies ) {
	$taxonomies[] = 'some-taxonomy';
	return $taxonomies;
}
add_filter( 'unique_headers_taxonomies', 'unique_headers_add_taxonomy' );

?>
`

= Where's the plugin settings page? =

There isn't one.


= Other plugins work out the width and height of the header and serve the correct sized header. Why doesn't your plugin do that? =

I prefer to allow you to set the width and height yourself by opening a correct sized image. This allows you to provide over-resolution images to cater for "retina screen" and zoomed in users. Plus, it allows you to control the compression and image quality yourself. Neither route is better in my opinion. If you require this functionality, please let me know though, as if most people prefer the other route, then I may change how the plugin works. I suspect most people won't care either way though.


= Does it work in older versions of WordPress? =

Probably, but I only actively support the latest version of WordPress. Support for older versions is purely by accident.


= I need custom functionality. Can we pay you to build it for us? =

No, I'm too busy. Having said that, if you are willing to pay me a small fortune then I could <a href="https://ryan.hellyer.kiwi/contact/">probably be persuaded</a>. I'm also open to suggestions for improvements, so feel free to send me ideas and if you are lucky, it may be added for free :)



== Screenshots ==

1. The new meta box as added to the posts/pages screen
2. The custom header image uploader for adding new header images
3. The new meta box for categories and tags. This view is only seen when using the <a href="http://wordpress.org/extend/plugins/taxonomy-metadata/">Taxonomy Metadata plugin</a>


== Changelog ==

Version 1.3.11: Moved instantiation and localization code into a class.
Version 1.3.10: Added Deutsch (German) language translation.
Version 1.3.9: Fixing error which caused header images to disappear on upgrading (data was still available just not accessed correctly).<br />
Version 1.3.8: Modification translation system to work with changes on WordPress.org.<br />
Version 1.3.7: Addition of Spanish translation<br />
Version 1.3.1: Adjustment to match post meta key to other plugins, for compatibilty reasons.<br />
Version 1.3: Total rewrite to use custom built in system for media uploads. Also adapted taxonomies to use ID's and added support for extra post-types and taxonomies.<br />
Version 1.2: Converted to use the class from the Multiple Featured Images plugin<br />
Version 1.1: Added support for tags <br />
Version 1.0.4: Added support for displaying a category specific image on the single post pages<br />
Version 1.0.3: Correction for $new_url for categories<br />
Version 1.0.2: Bug fix to allow default header to display when no category specified<br />
Version 1.0.1: Bug fixes for post/page thumbnails<br />
Version 1.0: Initial release<br />


= Credits =

Thanks to the following for help with the development of this plugin:<br />
* <a href="http://onmytodd.org">Todd</a> - Assistance with implementing support for tags<br />
* <a href="http://westoresolutions.com/">Mariano J. Ponce</a> - Spanish translation<br />
* <a href="http://www.graphicana.de/">Tobias Klotz</a> - Deutsch (German) language translation.
* <a href="http://nakri.co.uk/">Nadia Tokerud</a> - Proof-reading of Norsk Bokmål (Norwegian) translation (coming soon)<br />
* <a href="http://bjornjohansen.no/">Bjørn Johansen</a> - Proof-reading of Norwegian Bokmål translation (coming soon)<br />
* <a href="https://www.facebook.com/kaljam/">Karl Olofsson</a> - Proof-reading of Swedish translation (coming soon)<br />
* <a href="http://www.jennybeaumont.com/">Jenny Beaumont</a> - French translation (coming soon)<br />

