<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEdificioFieldException.php';

final class EdificioNombreParqueadero
{
    private const FIELD = 'nombreParqueadero';
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 100;

    private string $value;

    public function __construct(string $value)
    {
        $normalizedValue = trim($value);

        if ($normalizedValue === '') {
            throw InvalidEdificioFieldException::becauseValueIsEmpty(self::FIELD);
        }

        if (mb_strlen($normalizedValue) < self::MIN_LENGTH) {
            throw InvalidEdificioFieldException::becauseLengthIsTooShort(self::FIELD, self::MIN_LENGTH);
        }

        if (mb_strlen($normalizedValue) > self::MAX_LENGTH) {
            throw InvalidEdificioFieldException::becauseLengthIsTooLong(self::FIELD, self::MAX_LENGTH);
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(EdificioNombreParqueadero $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
