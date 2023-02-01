<?php

namespace OnrampLab\CleanArchitecture\Tests\Unit\ValidationAttributes;

use Illuminate\Validation\ValidationException;
use OnrampLab\CleanArchitecture\Tests\TestCase;
use OnrampLab\CleanArchitecture\ValidationAttributes\UnsignedInteger;
use Spatie\LaravelData\Data;

class DTO extends Data
{
    #[UnsignedInteger]
    public int $value;
}

/**
*  @author OnrampLab
*/
class UnsignedIntegerTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function performWorks($value, $expectedException)
    {
        if ($expectedException) {
            $this->expectException(ValidationException::class);
        }

        $object = DTO::validateAndCreate([
            'value' => $value,
        ]);

        $this->assertEquals($value, $object->value);
    }

    private function dataProvider()
    {
        return [
            ['-1', true],
            [-1, true],
            ['0', true],
            [0, true],
            ['1', false],
            [1, false],
        ];
    }
}
