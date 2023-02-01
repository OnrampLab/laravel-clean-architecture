<?php

namespace OnrampLab\CleanArchitecture\Exceptions;

use Illuminate\Http\Response;
use Throwable;

class CustomDomainException extends DomainException
{
    protected string $title;

    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        string $title,
        string $detail,
        array $context = [],
        int $code = Response::HTTP_BAD_REQUEST,
        ?Throwable $previous = null
    ) {
        parent::__construct($detail, $context, $code, $previous);

        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDetail(): string
    {
        return $this->getMessage();
    }
}
