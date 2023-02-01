<?php

namespace OnrampLab\CleanArchitecture\Exceptions;

use Illuminate\Http\Response;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

abstract class DomainException extends GeneralException implements HttpExceptionInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        string $message,
        array $context = [],
        int $code = Response::HTTP_BAD_REQUEST,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $context, $code, $previous);

        if ($code < Response::HTTP_BAD_REQUEST || $code >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            throw new InvalidArgumentException('Wrong HTTP status code for DomainException');
        }
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    /**
     * @return array<string, mixed>
     */
    public function getHeaders(): array
    {
        return [];
    }
}
