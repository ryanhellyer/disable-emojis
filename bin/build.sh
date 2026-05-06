#!/bin/bash
set -euo pipefail

echo "Select build mode:"
echo "  1) Dev - build scoped deps, keep vendor/ intact"
echo "  2) Prod - remove vendor/, install prod deps, build scoped deps, create zip"
read -rp "Choice [1-2]: " CHOICE

case "$CHOICE" in
    1) MODE="dev" ;;
    2) MODE="prod" ;;
    *) echo "Invalid choice"; exit 1 ;;
esac

echo "=== Mode: $MODE ==="
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

echo "=== Generating autoloader ==="
mkdir -p build/vendor
mv build/psr build/vendor/
mv build/inpsyde build/vendor/

cat > build/vendor/autoload.php << 'AUTOLOAD'
<?php

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

if [ "$MODE" = "dev" ]; then
    echo "=== Dev build complete ==="
    echo "Scoped deps at: build/vendor/"
    echo "Run tests: ./vendor/bin/phpunit"
elif [ "$MODE" = "prod" ]; then
    echo "=== Creating production zip ==="

    PLUGIN_DIR="build/plugin"
    mkdir -p "$PLUGIN_DIR"

    cp disable-emojis.php "$PLUGIN_DIR/"
    cp readme.txt "$PLUGIN_DIR/" 2>/dev/null || true
    cp license.txt "$PLUGIN_DIR/" 2>/dev/null || true
    cp -r src "$PLUGIN_DIR/"
    cp -r build/vendor "$PLUGIN_DIR/"

    cd "$PLUGIN_DIR"
    zip -r ../../disable-emojis.zip . -x ".*"
    cd ../../

    echo "=== Removing vendor directory ==="
    rm -rf vendor

    echo "=== Production zip created: disable-emojis.zip ==="
    echo "vendor/ was removed. Run 'composer install' to restore dev dependencies."
fi
