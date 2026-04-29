<?php

declare(strict_types=1);

use WPReadme2Markdown\Converter;

require_once __DIR__ . '/../vendor/autoload.php';

$readme = file_get_contents(__DIR__ . '/../readme.txt');
if ($readme === false) {
    fwrite(STDERR, "Error: could not read readme.txt\n");
    exit(1);
}

$markdown = Converter::convert($readme);

// Remove metadata label lines left by the converter (e.g. "**Contributors:** ryanhellyer \")
$markdown = preg_replace('/^\*\*[^*]+:\*\* .*$/m', '', $markdown);

// Remove Upgrade Notice section
$markdown = preg_replace('/\n*## Upgrade Notice\n.*?(?=\n## |$)/s', '', $markdown);

// Remove duplicate Architecture and Quality sections from Description subsections
$markdown = preg_replace('/\n*### Architecture\n.*?(?=\n### |\n## )/s', '', $markdown);
$markdown = preg_replace('/\n*### Quality\n.*?(?=\n## )/s', '', $markdown);

// Convert indented code blocks (4 spaces) to fenced code blocks
$lines = explode("\n", $markdown);
$result = [];
$inCode = false;

foreach ($lines as $i => $line) {
    $trimmed = ltrim($line);

    // Line starting with 4+ spaces that isn't empty and isn't a list item
    if (preg_match('/^(?:    |\t)(.+)$/', $line, $m) && !in_array(trim($line), ['', '-']) && !preg_match('/^\s*[\*\-\d]\.?\s/', $trimmed)) {
        if (!$inCode) {
            $result[] = '```';
            $inCode = true;
        }
        $result[] = $m[1];
    } else {
        if ($inCode) {
            // End code block only on blank line (not if we're continuing regular content)
            // Actually, end on any non-indented line
            if ($trimmed !== '') {
                $result[] = '```';
                $inCode = false;
                $result[] = $line;
            } else {
                // Empty line inside code block - end it
                $result[] = '```';
                $result[] = '';
                $inCode = false;
            }
        } else {
            $result[] = $line;
        }
    }
}

// Close any open code block
if ($inCode) {
    $result[] = '```';
}

$markdown = implode("\n", $result);

// Convert version format: "1.8 (2026-04-30)" → "1.8 — 2026-04-30"
$markdown = preg_replace('/^(### \d[\d.]+\w*) \((\d{4}(?:-\d{2}-\d{2})?)\)/m', '$1 — $2', $markdown);

// Collapse multiple blank lines
$markdown = preg_replace("/\n{3,}/", "\n\n", $markdown);

// Build the final README.md with GitHub-specific sections
$header = '# Disable Emojis (GDPR friendly)

[![PHP](https://img.shields.io/badge/PHP-%E2%89%A57.4-777BB4?logo=php&logoColor=white)](https://php.net) [![WordPress](https://img.shields.io/badge/WordPress-%E2%89%A55.0-21759B?logo=wordpress&logoColor=white)](https://wordpress.org) [![PHPStan](https://img.shields.io/badge/PHPStan-level%206-brightgreen)](https://phpstan.org) [![PSR-12](https://img.shields.io/badge/coding%20standard-PSR--12-ff69b4)](https://www.php-fig.org/psr/psr-12/) [![License](https://img.shields.io/badge/license-GPL--2.0--or--later-blue)](LICENSE)

';

$architecture = '## Architecture

The plugin uses:

- **PSR-4 autoloading** — classes in `src/` are autoloaded via Composer under the `RyanHellyer\DisableEmojis` namespace.
- **Inpsyde Modularity** — the plugin is structured as a module implementing `ExecutableModule`, bootstrapped via the library\'s `Package` class.

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

';

$quality = '## Quality

| Tool | Command | Purpose |
|---|---|---|
| PHP_CodeSniffer | `composer phpcs` | Sniffs for PSR-12 violations |
| PHP_CodeSniffer | `composer phpcbf` | Auto-fixes PSR-12 violations |
| PHP-CS-Fixer | `composer cs` | Dry-run style check |
| PHP-CS-Fixer | `composer cs:fix` | Auto-fixes style issues |
| PHPStan | `composer phpstan` | Static analysis at level 6 |

All code uses `declare(strict_types=1)` and follows PSR-12.

';

$contributing = '## Contributing

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

';

// Insert architecture after the first section (Description/Features)
// and quality/contributing before FAQ
$parts = explode("\n## ", $markdown, 2);

$body = $parts[0] . "\n\n";

// Add architecture after the initial content (before Installation)
$body .= $architecture;

// Find position of Installation, FAQ, Changelog sections and reorder
$sections = [];
$current = 'description';
$content = [];

foreach (explode("\n## ", $parts[1] ?? '') as $section) {
    $lines = explode("\n", $section, 2);
    $title = trim($lines[0]);
    $text = $lines[1] ?? '';
    $sections[$title] = $text;
}

// Build in the order we want
$ordered = ['Installation', 'Frequently Asked Questions'];

foreach ($ordered as $name) {
    if (isset($sections[$name])) {
        $body .= "## {$name}\n{$sections[$name]}\n\n";
        unset($sections[$name]);
    }
}

// Insert quality and contributing before remaining sections (Changelog)
$body .= $quality;
$body .= $contributing;

// Remaining sections: Changelog, License
foreach ($sections as $title => $text) {
    $body .= "## {$title}\n{$text}\n\n";
}

$body = trim($body) . "\n";

file_put_contents(__DIR__ . '/../README.md', $body);
echo "README.md generated from readme.txt.\n";
