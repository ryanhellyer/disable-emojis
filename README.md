# Disable Emojis (GDPR friendly)

[![PHP](https://img.shields.io/badge/PHP-%E2%89%A57.4-777BB4?logo=php&logoColor=white)](https://php.net)
[![WordPress](https://img.shields.io/badge/WordPress-%E2%89%A55.0-21759B?logo=wordpress&logoColor=white)](https://wordpress.org)
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

## Requirements

- PHP 7.4+
- WordPress 5.0+

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
├── .php-cs-fixer.dist.php       # PHP-CS-Fixer configuration
├── composer.json
├── disable-emojis.php           # Plugin entry point, boots Modularity Package
├── phpcs.xml.dist               # PHP_CodeSniffer configuration
├── phpstan.neon                 # PHPStan configuration
├── readme.txt                   # WordPress.org plugin readme
├── README.md
└── src/
    └── EmojiModule.php          # Module implementing ExecutableModule
```

## Quality

| Tool | Command | Purpose |
|---|---|---|
| PHP_CodeSniffer | `composer phpcs` | Sniffs for PSR-12 violations |
| PHP_CodeSniffer | `composer phpcbf` | Auto-fixes PSR-12 violations |
| PHP-CS-Fixer | `composer cs` | Dry-run style check |
| PHP-CS-Fixer | `composer cs:fix` | Auto-fixes style issues |
| PHPStan | `composer phpstan` | Static analysis at level 6 |

All code uses `declare(strict_types=1)` and follows PSR-12.

## Contributing

1. Clone the repository
2. Run `composer install`
3. Make your changes in `src/`
4. Run the quality tooling:
   ```bash
   composer phpcs
   composer phpstan
   ```
5. Submit a pull request

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
