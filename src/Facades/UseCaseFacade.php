<?php

namespace OnrampLab\CleanArchitecture\Facades;

use Illuminate\Support\Facades\Facade;
use OnrampLab\CleanArchitecture\UseCasePerformerFake;

/**
 * @method static void perform(\OnrampLab\CleanArchitecture\UseCase $useCase)
 * @method static void shouldPerform(string|\Closure $command)
 * @method static void assertPerformed(string|\Closure $command, callable|int $callback = null)
 */
class UseCaseFacade extends Facade
{
    /**
     * @param array<string, mixed> $useCasesToFake
     */
    public static function fake(array $useCasesToFake = []): UseCasePerformerFake
    {
        $fake = new UseCasePerformerFake(static::getFacadeRoot(), $useCasesToFake);

        static::swap($fake);

        return $fake;
    }

    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'use-case';
    }
}
