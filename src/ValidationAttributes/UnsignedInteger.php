<?php

namespace OnrampLab\CleanArchitecture\ValidationAttributes;

use Attribute;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Support\Validation\ValidationRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class UnsignedInteger extends ValidationRule
{
    public function getRules(): array
    {
        return [
            new IntegerType(),
            new Min(0),
        ];
    }
}
