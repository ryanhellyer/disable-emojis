=== Disable Emojis (GDPR friendly) ===
Contributors: ryanhellyer
Tags: emojis, gdpr, disable, performance
Donate link: https://geek.hellyer.kiwi/donate/
Requires at least: 4.8
Tested up to: 7.0
Stable tag: 1.7.8
License: GPLv2 or later

Disable the WordPress emoji functionality to improve performance and privacy.

== Description ==

This plugin disables the WordPress emoji functionality, removing unnecessary code bloat that adds support for emojis in older browsers.

= What it does =

* Removes the emoji detection script from `wp_head` and the admin
* Removes emoji styles from `wp_print_styles` and admin
* Removes emoji DNS prefetching, preventing connections to `s.w.org`
* Removes the `wpemoji` TinyMCE plugin
* Strips emoji CDN hostname from DNS prefetch hints

= Performance & Privacy =

Emojis will still display in modern browsers that have built-in support. This plugin simply removes the extra HTTP requests and JavaScript overhead for browsers that don't need it. Additionally, it prevents DNS prefetching to WordPress.org's emoji CDN, improving privacy.

Note: Emoticons like `:)` will continue to work as expected.

= GDPR compliancy =

This plugin does not send any data to external servers. It disables DNS prefetching of emojis within WordPress, which should ensure improved privacy. To determine if your site is GDPR compliant, please seek legal advice. I have done my best to ensure the plugin is 100% GDPR compliant, but I am not a lawyer so cannot guarantee anything.

== Installation ==

= Standard installation =

1. Upload the `disable-emojis` folder to `/wp-content/plugins/`, or install via the WordPress plugin installer
2. Activate the plugin through the Plugins screen in WordPress
3. Done! Emoji bloat is automatically removed.

= Composer installation =

If your site uses Composer for dependency management:

```
composer require ryanhellyer/disable-emojiis
```

The plugin uses PSR-4 autoloading with the `RyanHellyer\DisableEmojis` namespace and the Inpsyde Modularity library.

Visit the <a href="https://geek.hellyer.kiwi/plugins/disable-emojis/">Disable Emojis plugin page</a> for more information.

== Frequently Asked Questions ==

= Will this break emojis on my site? =

No. Modern browsers have built-in emoji support. This plugin only removes the JavaScript and CSS that WordPress adds to support emojis in very old browsers.

= Will emoticons still work? =

Yes. Text-based emoticons like `:)` and `:D` will continue to work as they always have.

= Is this plugin GDPR compliant? =

This plugin does not connect to any external servers or send any data. It removes the DNS prefetch to WordPress.org's emoji CDN. See the GDPR section above for details.

== Changelog ==

= 1.8 =
* Refactored to use modern PSR-4 autoloading and namespacing.

= 1.7.8 =
* Confirmed support for newer WordPress versions.

= 1.7.7 =
* Confirmed support for newer WordPress versions.

= 1.7.6 =
* Confirmed support for newer WordPress versions.

= 1.7.5 =
* Added Composer support.

= 1.7.4 =
* Fixing typos.

= 1.7.3 =
* Version bump.

= 1.7.2 =
* Subtle improvement to code cleanliness.
* Improved documentation regarding GDPR issues.

= 1.7.1 =
* Added GDPR friendly label.

= 1.7 =
* Removed DNS prefetch URL again.
* Using simple string check rather than relying on internal WordPress filters.

= 1.6 =
* Removed DNS prefetch URL. Props to Aaron Queen.

= 1.5.3 =
* Catering to new DNS prefetch URL in version 4.7 of core.

= 1.5.2 =
* Improved documentation.
* Removed redundant DNS prefetching.

= 1.5.1 =
* Updating documentation.

= 1.5 =
* Catering for invalid plugin array.

= 1.4 =
* Updating to use Otto's code.

= 1.3 =
* Removing extraneous styles.

= 1.2 =
* Bug fix.

= 1.1 =
* Updating to work with latest beta.

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.7.8 =
Compatible with the latest version of WordPress.
