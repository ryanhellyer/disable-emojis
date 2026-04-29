<?php

/**
 * WordPress function stubs for unit tests.
 */

declare(strict_types=1);

if (! function_exists('add_action')) {
    function add_action(
        string $hook,
        string|callable $callback,
        int $priority = 10,
        int $acceptedArgs = 1
    ): void {
    }
}

if (! function_exists('add_filter')) {
    function add_filter(
        string $hook,
        string|callable $callback,
        int $priority = 10,
        int $acceptedArgs = 1
    ): void {
    }
}

if (! function_exists('remove_action')) {
    function remove_action(
        string $hook,
        string|callable $callback,
        int $priority = 10
    ): void {
    }
}

if (! function_exists('remove_filter')) {
    function remove_filter(
        string $hook,
        string|callable $callback,
        int $priority = 10
    ): void {
    }
}

if (! function_exists('apply_filters')) {
    function apply_filters(string $hook, mixed ...$args): mixed
    {
        return $args[0] ?? null;
    }
}

require_once __DIR__ . '/../vendor/autoload.php';
