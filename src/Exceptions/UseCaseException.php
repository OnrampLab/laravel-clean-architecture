<?php

namespace OnrampLab\CleanArchitecture\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class UseCaseException extends ApplicationException implements HttpExceptionInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function __construct(string $title, array $context, Throwable $previous)
    {
        parent::__construct($previous->getMessage(), $context, $previous->getCode(), $previous);

        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
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
