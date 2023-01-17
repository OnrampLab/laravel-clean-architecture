<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\Exceptions;

use OnrampLab\CleanArchitecture\Exceptions\GeneralException;

class FakeGeneralException extends GeneralException
{
    public function getTitle(): string
    {
        return 'Fake General Exception';
    }
}
