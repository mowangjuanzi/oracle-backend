<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withSkip([
        __DIR__ . '/bootstrap/cache',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets(php84: true)
    ->withSets([
        LaravelSetList::LARAVEL_110,
    ])
    ->withRules([

    ]);
