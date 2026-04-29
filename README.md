# Disable Emojis (GDPR friendly)

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php)](https://php.net)
[![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-21759B?logo=wordpress)](https://wordpress.org)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%206-brightgreen)](https://phpstan.org)
[![PSR-12](https://img.shields.io/badge/coding%20standard-PSR--12-ff69b4)](https://www.php-fig.org/psr/psr-12/)
[![License](https://img.shields.io/badge/license-GPL--2.0--or--later-blue)](LICENSE)

A WordPress plugin that disables the emoji functionality, removing unnecessary code bloat and preventing connections to WordPress.org's emoji CDN.

## Features

- Removes emoji detection script from `wp_head` and admin
- Removes emoji styles from `wp_print_styles` and admin
- Removes emoji DNS prefetching, preventing connections to `s.w.org`
- Removes the `wpemoji` TinyMCE plugin
- Strips emoji CDN hostname from DNS prefetch hints
- 100% GDPR friendly — no external data sent

Emojis still display in modern browsers with built-in support. Only the extra HTTP requests and JavaScript for older browsers are removed.

## Installation

### WordPress admin

Search for "Disable Emojis" in the plugin installer, or upload the folder to `/wp-content/plugins/` and activate.

### Composer

```bash
composer require ryanhellyer/disable-emojiis
```

## Architecture

The plugin uses:

- **PSR-4 autoloading** — classes in `src/` are autoloaded via Composer under the `RyanHellyer\DisableEmojis` namespace.
- **Inpsyde Modularity** — the plugin is structured as a module implementing `ExecutableModule`, bootstrapped via the library's `Package` class.

```
├── composer.json
├── disable-emojis.php          # Plugin entry point, boots Modularity Package
├── src/
│   └── EmojiModule.php         # Module implementing ExecutableModule
├── readme.txt
└── vendor/                     # Composer dependencies
```

## Frequently Asked Questions

### Will this break emojis on my site?

No. Modern browsers have built-in emoji support. This plugin only removes the JavaScript and CSS that WordPress adds for very old browsers.

### Will emoticons still work?

Yes. Text-based emoticons like `:)` and `:D` work as they always have.

### Is this plugin GDPR compliant?

It does not connect to any external servers or send any data. It removes the DNS prefetch to WordPress.org's emoji CDN.

## Changelog

### 1.7.8
Confirmed support for newer WordPress versions.

### 1.7.5
Added Composer support.

Earlier versions listed in `readme.txt`.

## License

GPL-2.0-or-later
