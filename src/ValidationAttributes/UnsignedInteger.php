<?php

namespace OnrampLab\CleanArchitecture\ValidationAttributes;

use Attribute;
use Spatie\LaravelData\Attributes\Validation\CustomValidationAttribute;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Support\Validation\ValidationPath;
use Spatie\LaravelData\Support\Validation\ValidationRule;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class UnsignedInteger extends CustomValidationAttribute
{
    /**
     * @return array<object|string>|object|string
     */
    public function getRules(ValidationPath $path): array|object|string
    {
        return [
            new IntegerType(),
            new Min(0),
        ];
    }
}
