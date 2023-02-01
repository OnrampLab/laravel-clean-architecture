<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\Exceptions;

use Exception;
use Illuminate\Http\Response;
use OnrampLab\CleanArchitecture\Exceptions\UseCaseException;
use OnrampLab\CleanArchitecture\Tests\TestCase;

/**
*  @author OnrampLab
*/
class UseCaseExceptionTest extends TestCase
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
        $previousException = new Exception('An Exception', 401);
        $exception = new UseCaseException('Do Something', [], $previousException);

        $this->assertEquals('Do Something', $exception->getTitle());
        $this->assertEquals('An Exception', $exception->getDetail());
        $this->assertEquals(401, $exception->getStatusCode());
    }
}
