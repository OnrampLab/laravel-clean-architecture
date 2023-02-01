<?php

namespace OnrampLab\CleanArchitecture\Exceptions;

use Illuminate\Http\Request;
use OnrampLab\LaravelExceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /** @var array<class-string> $errorReport */
    protected array $errorReport = [
        InternalServerException::class,
    ];

    /** @var array<class-string> $warningReport */
    protected array $warningReport = [
        DomainException::class,
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception): Response
    {
        $exception = $this->getRawException($exception);

        return parent::render($request, $exception);
    }

    protected function isInstanceOfException(Throwable $exception, string $exceptionClassName): bool
    {
        $exception = $this->getRawException($exception);

        return parent::isInstanceOfException($exception, $exceptionClassName);
    }

    /**
     * Determine if the exception is in the "do not report" list.
     */
    protected function shouldntReport(Throwable $exception): bool
    {
        $exception = $this->getRawException($exception);

        return parent::shouldntReport($exception);
    }

    private function getRawException(Throwable $exception): Throwable
    {
        if ($exception instanceof UseCaseException && $exception->getPrevious()) {
            $exception = $exception->getPrevious();

            if ($exception instanceof GeneralException && $exception->getPrevious()) {
                $exception = $exception->getPrevious();
            }
        }

        return $exception;
    }
}
