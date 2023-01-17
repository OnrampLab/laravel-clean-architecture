<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\Exceptions;

use OnrampLab\CleanArchitecture\Tests\TestCase;

/**
*  @author OnrampLab
*/
class GeneralExceptionTest extends TestCase
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
        $exception = new FakeGeneralException('Message');

        $this->assertEquals('Fake General Exception', $exception->getTitle());
        $this->assertEquals('Message', $exception->getDetail());
    }
}
