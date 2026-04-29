# Disable Emojis (GDPR friendly)

Disable the WordPress emoji functionality to improve performance and privacy.


## Architecture

The plugin uses:

- **PSR-4 autoloading** — classes in `src/` are autoloaded via Composer under the `RyanHellyer\DisableEmojis` namespace.
- **Inpsyde Modularity** — the plugin is structured as a module implementing `ExecutableModule`, bootstrapped via the library's `Package` class.

```
├── .github/workflows/ci.yml     # GitHub Actions CI
├── bin/generate-readme.php       # README generator
├── composer.json
├── disable-emojis.php            # Plugin entry point, boots Modularity Package
├── phpcs.xml.dist                # PHP_CodeSniffer configuration
├── phpstan.neon                  # PHPStan configuration
├── readme.txt                    # WordPress.org plugin readme
├── README.md
├── src/
│   └── EmojiModule.php           # Module implementing ExecutableModule
└── tests/
    ├── EmojiModuleTest.php       # Unit tests
    └── bootstrap.php             # WordPress function stubs
```

## Installation

### Standard installation

1. Upload the `disable-emojis` folder to `/wp-content/plugins/`, or install via the WordPress plugin installer
2. Activate the plugin through the Plugins screen in WordPress
3. Done! Emoji bloat is automatically removed.

### Composer installation

If your site uses Composer for dependency management:

```
composer require ryanhellyer/disable-emojiis
```

Visit the [Disable Emojis plugin page](https://geek.hellyer.kiwi/plugins/disable-emojis/) for more information.


## Frequently Asked Questions

### Will this break emojis on my site?

No. Modern browsers have built-in emoji support. This plugin only removes the JavaScript and CSS that WordPress adds for very old browsers.

### Will emoticons still work?

Yes. Text-based emoticons like `:)` and `:D` will continue to work as they always have.

### Is this plugin GDPR compliant?

It does not connect to any external servers or send any data. It removes the DNS prefetch to WordPress.org's emoji CDN. See the GDPR section above for details.


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

5. Run `composer generate-readme` to regenerate this file
6. Submit a pull request

## Description

This plugin disables the WordPress emoji functionality, removing unnecessary code bloat that adds support for emojis in older browsers.

### What it does

* Removes the emoji detection script from `wp_head` and the admin
* Removes emoji styles from `wp_print_styles` and admin
* Removes emoji DNS prefetching, preventing connections to `s.w.org`
* Removes the `wpemoji` TinyMCE plugin
* Strips emoji CDN hostname from DNS prefetch hints

### Performance & Privacy

Emojis will still display in modern browsers that have built-in support. This plugin simply removes the extra HTTP requests and JavaScript overhead for browsers that don't need it. Additionally, it prevents DNS prefetching to WordPress.org's emoji CDN, improving privacy.

Note: Emoticons like `:)` will continue to work as expected.

### Requirements

* PHP 7.4+
* WordPress 5.0+

### GDPR compliancy

This plugin does not send any data to external servers. It disables DNS prefetching of emojis within WordPress, which should ensure improved privacy. To determine if your site is GDPR compliant, please seek legal advice. I have done my best to ensure the plugin is 100% GDPR compliant, but I am not a lawyer so cannot guarantee anything.

## Changelog

### 1.8 — 2026-04-30

* Refactor for modern PHP standards

### 1.7.8 — 2026-04-29

* Confirmed support for newer WordPress versions.

### 1.7.7 — 2024

* Confirmed support for newer WordPress versions.

### 1.7.6 — 2023-06-28

* Confirmed support for newer WordPress versions.

### 1.7.5 — 2023-05-19

* Added Composer support.

### 1.7.4 — 2018-07-05

* Fixing typos.

### 1.7.3 — 2018-07-05

* Version bump.

### 1.7.2 — 2018-07-05

* Subtle improvement to code cleanliness.
* Improved documentation regarding GDPR issues.

### 1.7.1 — 2018-06-13

* Added GDPR friendly label.

### 1.7 — 2017-08-04

* Removed DNS prefetch URL again.
* Using simple string check rather than relying on internal WordPress filters.

### 1.6 — 2017-07-19

* Removed DNS prefetch URL. Props to Aaron Queen.

### 1.5.3 — 2016-12-19

* Catering to new DNS prefetch URL in version 4.7 of core.

### 1.5.2 — 2016-08-23

* Improved documentation.
* Removed redundant DNS prefetching.

### 1.5.1 — 2016-08-23

* Updating documentation.

### 1.5 — 2017-08-04

* Catering for invalid plugin array.

### 1.4 — 2018-06-13

* Updating to use Otto's code.

### 1.3 — 2018-05-04

* Removing extraneous styles.

### 1.2 — 2016-08-23

* Bug fix.

### 1.1 — 2016-08-23

* Updating to work with latest beta.

### 1.0 — 2015-03-22

* Initial release.
