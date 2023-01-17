<?php

namespace OnrampLab\CleanArchitecture\Exceptions;

use Illuminate\Http\Response;
use InvalidArgumentException;
use Throwable;

class InternalServerException extends ApplicationException
{
    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        string $message,
        array $context = [],
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $context, $code, $previous);

        if ($code < Response::HTTP_INTERNAL_SERVER_ERROR) {
            throw new InvalidArgumentException('Wrong HTTP status code for InternalServerException');
        }
    }

    public function getTitle(): string
    {
        return 'Unknown Error';
    }
}
