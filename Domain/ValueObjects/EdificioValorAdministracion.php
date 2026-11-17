<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEdificioFieldException.php';

final class EdificioValorAdministracion
{
    private const FIELD = 'valorAdministracion';
    private const MAX_VALUE = 9999999999.99;

    private float $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw InvalidEdificioFieldException::becauseValueMustNotBeNegative(self::FIELD);
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

    public function equals(EdificioValorAdministracion $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return number_format($this->value, 2, '.', '');
    }
}
