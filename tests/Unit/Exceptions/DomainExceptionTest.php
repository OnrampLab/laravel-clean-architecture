<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\Exceptions;

use Illuminate\Http\Response;
use OnrampLab\CleanArchitecture\Tests\TestCase;

/**
*  @author OnrampLab
*/
class DomainExceptionTest extends TestCase
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
        $exception = new FakeDomainException('Message');

        $this->assertEquals('Fake Domain Exception', $exception->getTitle());
        $this->assertEquals('Message', $exception->getDetail());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $exception->getStatusCode());
    }
}
