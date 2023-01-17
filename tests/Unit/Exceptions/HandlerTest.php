<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\Exceptions;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use OnrampLab\CleanArchitecture\Exceptions\CustomDomainException;
use OnrampLab\CleanArchitecture\Exceptions\Handler;
use OnrampLab\CleanArchitecture\Exceptions\InternalServerException;
use OnrampLab\CleanArchitecture\Exceptions\UseCaseException;
use OnrampLab\CleanArchitecture\Tests\TestCase;
use OnrampLab\CleanArchitecture\Tests\Unit\Exceptions\FakeDomainException;

/**
*  @author OnrampLab
*/
class HandlerTest extends TestCase
{
    public function setUp(): void
    {
      parent::setUp();
    }

    /**
     * @test
     */
    public function handleUseCaseExceptionWithException()
    {
        Log::spy();
        $originalException = new Exception('An Exception');
        $internalServerException = new InternalServerException(
            $originalException->getMessage(),
            [],
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $originalException
        );
        $exception = new UseCaseException('Unable To Do Something', [], $internalServerException);

        $this->app->bind(ExceptionHandler::class, function ($app) {
            return $app->make(Handler::class);
        });

        Route::get('test-route', fn () => throw $exception);

        Log::shouldReceive('error')->once()->withArgs(function ($message, $context) {
            $firstError = $context['errors'][0];
            $secondError = $context['errors'][1];

            return $message = 'Unable To Do Something'
                && $context['detail'] === 'An Exception'
                && $firstError['title'] === 'Unable To Do Something'
                && $firstError['detail'] === 'An Exception'
                && $secondError['title'] === 'Unknown Error'
                && $secondError['detail'] === 'An Exception';
        });

        $this->getJson('test-route')
            ->assertStatus(500)
            ->assertExactJson([
                'errors' => [
                    [
                        'title' => "Unknown Error",
                        'detail' => "An Exception",
                        'status' => 500,
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function handleUseCaseExceptionWithModelNotFoundException()
    {
        Log::spy();
        $originalException = new ModelNotFoundException('An Model Not Found Exception');
        $internalServerException = new InternalServerException(
            $originalException->getMessage(),
            [],
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $originalException
        );
        $exception = new UseCaseException('Do Something', [], $internalServerException);

        $this->app->bind(ExceptionHandler::class, function ($app) {
            return $app->make(Handler::class);
        });

        Route::get('test-route', fn () => throw $exception);

        Log::shouldNotReceive('error');

        $this->getJson('test-route')
            ->assertStatus(404)
            ->assertExactJson([
                'errors' => [
                    [
                        'title' => "Resource Not Found",
                        'detail' => "An Model Not Found Exception",
                        'status' => 404,
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function handleUseCaseExceptionWithValidationException()
    {
        Log::spy();
        $originalException = ValidationException::withMessages(['setting_id' => "cannot found setting id: 1 with campaign id: 2"]);
        $customDomainException = new CustomDomainException(
            title: 'Model Not Found',
            detail: $originalException->getMessage(),
            previous: $originalException
        );
        $exception = new UseCaseException('Do Something', [], $customDomainException);

        $this->app->bind(ExceptionHandler::class, function ($app) {
            return $app->make(Handler::class);
        });

        Route::get('test-route', fn () => throw $exception);

        Log::shouldNotReceive('error');

        $this->getJson('test-route')
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    [
                        'title' => "Invalid Attribute",
                        'detail' => "cannot found setting id: 1 with campaign id: 2",
                        'status' => 422,
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function handleUseCaseExceptionWithDomainException()
    {
        Log::spy();
        $fakeDomainException = new FakeDomainException(
            message: 'A fake message'
        );
        $exception = new UseCaseException('Unable To Do Something', [], $fakeDomainException);

        $this->app->bind(ExceptionHandler::class, function ($app) {
            return $app->make(Handler::class);
        });

        Route::get('test-route', fn () => throw $exception);

        Log::shouldReceive('warning')->once()->withArgs(function ($message, $context) {

            $firstError = $context['errors'][0];
            return $message = 'Unable To Do Something'
                && $context['detail'] === 'A fake message'
                && $firstError['title'] === 'Unable To Do Something'
                && $firstError['detail'] === 'A fake message';
        });

        $this->getJson('test-route')
            ->assertStatus(400)
            ->assertExactJson([
                'errors' => [
                    [
                        'title' => "Fake Domain Exception",
                        'detail' => "A fake message",
                        'status' => 400,
                    ],
                ],
            ]);
    }
}
