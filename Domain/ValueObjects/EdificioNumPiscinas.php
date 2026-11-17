<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEdificioFieldException.php';

final class EdificioNumPiscinas
{
    private const FIELD = 'numPiscinas';
    private const MAX_VALUE = 50;

    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw InvalidEdificioFieldException::becauseValueMustNotBeNegative(self::FIELD);
        }

        if ($value > self::MAX_VALUE) {
            throw InvalidEdificioFieldException::becauseValueExceedsMaximum(self::FIELD, self::MAX_VALUE);
        }

        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(EdificioNumPiscinas $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
