<?php

namespace OnrampLab\CleanArchitecture;

use Illuminate\Support\Arr;
use Mockery;
use Mockery\ExpectationInterface;
use Mockery\HigherOrderMessage;
use Mockery\MockInterface;
use PHPUnit\Framework\Assert as PHPUnit;

class UseCasePerformerFake
{
    protected UseCasePerformer $performer;

    /** @var array<string, mixed> $map */
    protected array $map = [];

    /** @var array<string, mixed> $map */
    protected array $useCasesToFake = [];

    /**
     * Create a new use case fake instance.
     */
    public function __construct(UseCasePerformer $performer, array|string $useCasesToFake = [])
    {
        $this->performer = $performer;

        $this->useCasesToFake = Arr::wrap($useCasesToFake);
    }
    public function perform(UseCase $useCase): mixed
    {
        $className = $useCase::class;

        $this->map[$className] = $useCase;

        $facadeMock = data_get($this->useCasesToFake, $className);

        if ($facadeMock) {
            return $facadeMock->perform($useCase);
        }

        return [];
    }

    /**
     * Initiate a mock expectation on the facade.
     */
    public function shouldPerform(
        string $command,
        callable|null $callback = null
    ): ExpectationInterface|HigherOrderMessage {
        /** @var MockInterface $mock */
        $mock = Mockery::mock(UseCasePerformer::class);

        $this->useCasesToFake[$command] = $mock;

        return $mock->shouldReceive('perform');
    }

    /**
     * Assert if an use case was performed based on a truth-test callback.
     */
    public function assertPerformed(string $command, callable|null $callback = null): void
    {
        PHPUnit::assertTrue(
            $this->performed($command, $callback)
        );
    }

    protected function performed(string $command, callable|null $callback): bool
    {
        $performedUseCase = data_get($this->map, $command);

        if (is_null($performedUseCase)) {
            return false;
        }

        if (is_null($callback)) {
            return true;
        }

        return $callback($performedUseCase);
    }
}
