<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEdificioFieldException.php';

final class EdificioAltura
{
    private const FIELD = 'altura';
    private const MAX_VALUE = 1000.0;

    private float $value;

    public function __construct(float $value)
    {
        if ($value <= 0) {
            throw InvalidEdificioFieldException::becauseValueMustBePositive(self::FIELD);
        }

        if ($value > self::MAX_VALUE) {
            throw InvalidEdificioFieldException::becauseValueExceedsMaximum(self::FIELD, self::MAX_VALUE);
        }

        $this->value = round($value, 2);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function equals(EdificioAltura $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
