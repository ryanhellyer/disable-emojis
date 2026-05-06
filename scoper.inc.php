<?php

use Isolated\Symfony\Component\Finder\Finder;

return [
    'prefix' => 'RyanHellyer\\DisableEmojis\\Vendor',
    'finders' => [
        Finder::create()
            ->files()
            ->in('vendor/psr/container')
            ->name('*.php'),
        Finder::create()
            ->files()
            ->in('vendor/inpsyde/modularity')
            ->name('*.php'),
    ],
    'exclude-namespaces' => [
        'Composer',
    ],
];
