<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OnrampLab\CleanArchitecture\Exceptions\UseCaseException;
use OnrampLab\CleanArchitecture\Facades\UseCaseFacade;
use OnrampLab\CleanArchitecture\UseCase;
use OnrampLab\CleanArchitecture\Tests\TestCase;
use OnrampLab\CleanArchitecture\Tests\Unit\Exceptions\FakeGeneralException;
use OnrampLab\CleanArchitecture\ValidationAttributes\UnsignedInteger;

class DoSomethingUseCase extends UseCase
{
    #[UnsignedInteger]
    public int $value;

    public function handle(): string
    {
        return 'test';
    }
}

/**
*  Corresponding class to test UseCase class
*
*  For each class in your library, there should be a corresponding unit test
*
*  @author OnrampLab
*/
class UseCaseTest extends TestCase
{
    public function setUp(): void
    {
      parent::setUp();
    }

    /**
     * @test
     */
    public function performWorks()
    {
        $result = DoSomethingUseCase::perform(['value' => 1]);

        $this->assertEquals('test', $result);
    }

    /**
     * @test
     */
    public function performWorksByFakingFacade()
    {
        UseCaseFacade::fake();

        $result = DoSomethingUseCase::perform(['value' => 1]);

        UseCaseFacade::assertPerformed(DoSomethingUseCase::class);
    }

    /**
     * @test
     */
    public function performNotExecutionByFakingFacade()
    {
        UseCaseFacade::fake();
        UseCaseFacade::assertNotPerformed(DoSomethingUseCase::class);
    }

    /**
     * @test
     */
    public function performShouldRethrowUseCaseExceptionWhenCatchingGeneralException()
    {
        UseCaseFacade::fake();
        UseCaseFacade::shouldPerform(DoSomethingUseCase::class)
            ->once()
            ->andThrow(new FakeGeneralException('Error message'));

        try {
            $result = DoSomethingUseCase::perform(['value' => 1]);
        } catch (UseCaseException $e) {
            $this->assertEquals('Unable To Do Something', $e->getTitle());
            $this->assertEquals('Error message', $e->getMessage());
        }
    }

    /**
     * @test
     */
    public function performShouldRethrowUseCaseExceptionWhenCatchingModelNotFoundException()
    {
        UseCaseFacade::fake();
        UseCaseFacade::shouldPerform(DoSomethingUseCase::class)
            ->once()
            ->andThrow(new ModelNotFoundException('Error message'));

        try {
            $result = DoSomethingUseCase::perform(['value' => 1]);
        } catch (UseCaseException $e) {
            $internalServerException = $e->getPrevious();
            $modelNotFoundException = $internalServerException->getPrevious();

            $this->assertEquals('Unable To Do Something', $e->getTitle());
            $this->assertEquals('Error message', $e->getDetail());
            $this->assertEquals('Unknown Error', $internalServerException->getTitle());
            $this->assertEquals('Error message', $internalServerException->getDetail());
            $this->assertEquals('Error message', $modelNotFoundException->getMessage());
        }
    }

    /**
     * @test
     */
    public function performShouldRethrowUseCaseExceptionWhenCatchingValidationException()
    {
        try {
            $result = DoSomethingUseCase::perform(['value' => -1]);
        } catch (UseCaseException $e) {
            $internalServerException = $e->getPrevious();
            $validationException = $internalServerException->getPrevious();

            $this->assertEquals('Unable To Do Something', $e->getTitle());
            $this->assertEquals('The value field must be at least 0.', $e->getDetail());
            $this->assertEquals('Unknown Error', $internalServerException->getTitle());
            $this->assertEquals('The value field must be at least 0.', $internalServerException->getDetail());
            $this->assertEquals('The value field must be at least 0.', $validationException->getMessage());
        }
    }

    /**
     * @test
     */
    public function performShouldRethrowUseCaseExceptionWhenCatchingException()
    {
        UseCaseFacade::fake();
        UseCaseFacade::shouldPerform(DoSomethingUseCase::class)
            ->once()
            ->andThrow(new Exception('Error message'));

        try {
            $result = DoSomethingUseCase::perform(['value' => 1]);
        } catch (UseCaseException $e) {
            $internalServerException = $e->getPrevious();
            $rawException = $internalServerException->getPrevious();

            $this->assertEquals('Unable To Do Something', $e->getTitle());
            $this->assertEquals('Error message', $e->getDetail());
            $this->assertEquals('Error message', $internalServerException->getDetail());
            $this->assertEquals('Error message', $rawException->getMessage());
        }
    }
}
