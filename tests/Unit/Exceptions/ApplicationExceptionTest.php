<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\Exceptions;

use OnrampLab\CleanArchitecture\Exceptions\ApplicationException;
use OnrampLab\CleanArchitecture\Tests\TestCase;

class FakeApplicationException extends ApplicationException
{
    public function getTitle(): string
    {
        return 'Title';
    }
}

/**
*  @author OnrampLab
*/
class ApplicationExceptionTest extends TestCase
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
        $exception = new FakeApplicationException('Message');

        $this->assertEquals('Title', $exception->getTitle());
        $this->assertEquals('Message', $exception->getDetail());
    }
}
