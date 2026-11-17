<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEdificioFieldException.php';

final class EdificioMetrosCuadrados
{
    private const FIELD = 'metrosCuadrados';
    private const MAX_VALUE = 10000000.0;

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

    public function equals(EdificioMetrosCuadrados $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
