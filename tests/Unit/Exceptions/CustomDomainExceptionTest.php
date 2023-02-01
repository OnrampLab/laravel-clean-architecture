<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\Exceptions;

use OnrampLab\CleanArchitecture\Exceptions\CustomDomainException;
use OnrampLab\CleanArchitecture\Tests\TestCase;


/**
*  @author OnrampLab
*/
class CustomDomainExceptionTest extends TestCase
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
        $exception = new CustomDomainException('Title', 'Message');

        $this->assertEquals('Title', $exception->getTitle());
        $this->assertEquals('Message', $exception->getDetail());
    }
}
