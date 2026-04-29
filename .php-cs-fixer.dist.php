<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(['src', '.'])
    ->files()
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreVCSIgnored(true)
    ->ignoreDotFiles(true);

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'single_quote' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'blank_line_after_opening_tag' => false,
    ])
    ->setFinder($finder);
