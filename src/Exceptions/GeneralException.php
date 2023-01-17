<?php

namespace OnrampLab\CleanArchitecture\Exceptions;

use Exception;
use Illuminate\Http\Response;
use OnrampLab\LaravelExceptions\Contracts\ApplicationException;
use Throwable;

abstract class GeneralException extends Exception implements ApplicationException
{
    protected string $title;

    /**
     * @var array<string, mixed>
     */
    protected array $context = [];

    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        string $message,
        array $context = [],
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->context = $context;
    }

    abstract public function getTitle(): string;

    public function getDetail(): string
    {
        if ($this->getPrevious() !== null) {
            return $this->getPrevious()->getMessage();
        }

        return $this->getMessage();
    }

    /**
     * @return array<string, mixed>
     */
    public function context(): array
    {
        return $this->context;
    }
}
