<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\Exceptions;

use Illuminate\Http\Response;
use OnrampLab\CleanArchitecture\Exceptions\InternalServerException;
use OnrampLab\CleanArchitecture\Tests\TestCase;

/**
*  @author OnrampLab
*/
class InternalServerExceptionTest extends TestCase
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
        $exception = new InternalServerException('Message');

        $this->assertEquals('Unknown Error', $exception->getTitle());
        $this->assertEquals('Message', $exception->getDetail());
    }
}
