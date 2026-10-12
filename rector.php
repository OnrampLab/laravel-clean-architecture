<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\FuncCall\IntvalToTypeCastRector;
use Rector\Config\RectorConfig;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->skip([
        ClosureToArrowFunctionRector::class => [
            __DIR__ . '/src/Infrastructure/UseCasePerformerFake.php',
        ],
        IntvalToTypeCastRector::class => [
            __DIR__ . '/src/Domain/ValueObjects/ID.php',
        ],
    ]);

    $rectorConfig->cacheDirectory('./build/cache/rector');

    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
    ]);
};
