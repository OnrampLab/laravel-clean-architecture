<?php

namespace OnrampLab\CleanArchitecture\Domain\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;
use Stringable;

/**
 * @template T
 */
final readonly class ID implements Stringable, JsonSerializable
{
    private const UUID_REGEX = "/^[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/i";

    private function __construct(
        private int|string $value
    ) {
    }

    /**
     * @return self<T>
     */
    public static function create(int|string $value): self
    {
        if (is_int($value)) {
            if (!self::isPositiveInteger($value)) {
                throw new InvalidArgumentException('ID must greater than 0');
            }

            return new self($value);
        }

        if (! self::isValidIntegerString($value) && ! self::isValidUUIDString($value)) {
            throw new InvalidArgumentException('ID must be positive integer or UUID');
        }

        if (self::isValidIntegerString($value) && ! self::isPositiveInteger((int) $value)) {
            throw new InvalidArgumentException('ID must greater than 0');
        }

        return new self($value);
    }

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    private static function isPositiveInteger(int $value): bool
    {
        return $value > 0;
    }

    private static function isValidIntegerString(string $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return intval($value) == $value;
    }

    private static function isValidUUIDString(string $value): bool
    {
        return preg_match(self::UUID_REGEX, $value) === 1;
    }
}
