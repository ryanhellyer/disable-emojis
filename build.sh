#!/bin/bash
set -euo pipefail

if [ $# -eq 1 ]; then
    CHOICE="$1"
else
    echo "Select build mode:"
    echo "  1) Dev - build scoped deps into vendor/"
    echo "  2) Prod - build scoped deps, create zip, cleanup"
    read -rp "Choice [1-2]: " CHOICE
fi

case "$CHOICE" in
    1|dev) MODE="dev" ;;
    2|prod) MODE="prod" ;;
    *) echo "Invalid choice"; exit 1 ;;
esac

echo "=== Mode: $MODE ==="

echo "=== Ensuring dependencies are installed ==="
rm -rf vendor
composer install

echo "=== Generating README.md ==="
composer generate-readme

echo "=== Cleaning build directory ==="
rm -rf build

if [ "$MODE" = "prod" ]; then
    echo "=== Removing vendor directory ==="
    rm -rf vendor

    echo "=== Installing production dependencies ==="
    composer install --no-dev
fi

echo "=== Running PHP-Scoper ==="
PHP_SCOPER="$(command -v php-scoper || echo '/usr/local/bin/php-scoper')"
$PHP_SCOPER add-prefix --output-dir=build --force

echo "=== Replacing vendor files with scoped versions ==="
rm -rf vendor/psr/container
rm -rf vendor/inpsyde/modularity
cp -r build/psr/container vendor/psr/container
cp -r build/inpsyde/modularity vendor/inpsyde/modularity

echo "=== Generating autoloader ==="
COMPOSER_INIT=$(grep -oP 'ComposerAutoloaderInit\w+' vendor/autoload.php | head -1)

cat > vendor/autoload.php << 'AUTOLOAD'
<?php

require_once __DIR__ . '/composer/autoload_real.php';
AUTOLOAD
echo "\\${COMPOSER_INIT}::getLoader();" >> vendor/autoload.php
cat >> vendor/autoload.php << 'AUTOLOAD'

spl_autoload_register(static function (string $class): void {
    $prefixes = [
        'RyanHellyer\\DisableEmojis\\Vendor\\Psr\\Container\\' => __DIR__ . '/psr/container/src/',
        'RyanHellyer\\DisableEmojis\\Vendor\\Inpsyde\\Modularity\\' => __DIR__ . '/inpsyde/modularity/src/',
    ];
    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }
        $file = $baseDir . str_replace('\\', '/', substr($class, $len)) . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});
AUTOLOAD

echo "=== Cleaning up build directory ==="
rm -rf build

if [ "$MODE" = "prod" ]; then
    echo "=== Creating production zip ==="

    PLUGIN_DIR="build/plugin"
    mkdir -p "$PLUGIN_DIR"

    cp disable-emojis.php "$PLUGIN_DIR/"
    cp readme.txt "$PLUGIN_DIR/" 2>/dev/null || true
    cp license.txt "$PLUGIN_DIR/" 2>/dev/null || true
    cp -r src "$PLUGIN_DIR/"
    cp -r vendor "$PLUGIN_DIR/"

    cd "$PLUGIN_DIR"
    zip -r ../../disable-emojis.zip . -x ".*"
    cd ../../

    echo "=== Cleaning up ==="
    rm -rf build

    echo "=== Production zip created: disable-emojis.zip ==="
else
    echo "=== Dev build complete ==="
    echo "vendor/ now has scoped dependencies."
    echo "Run 'composer install' to restore original dev dependencies."
fi
