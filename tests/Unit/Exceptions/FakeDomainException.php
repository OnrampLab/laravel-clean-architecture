<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\Exceptions;

use OnrampLab\CleanArchitecture\Exceptions\DomainException;

class FakeDomainException extends DomainException
{
    public function getTitle(): string
    {
        return 'Fake Domain Exception';
    }
}
