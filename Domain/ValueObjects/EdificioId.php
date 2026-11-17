<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEdificioIdException.php';

final class EdificioId
{
    private const MAX_LENGTH = 36;

    private string $value;

    public function __construct(string $value)
    {
        $normalizedValue = trim($value);

        if ($normalizedValue === '') {
            throw InvalidEdificioIdException::becauseValueIsEmpty();
        }

        if (strlen($normalizedValue) > self::MAX_LENGTH) {
            throw InvalidEdificioIdException::becauseLengthIsTooLong(self::MAX_LENGTH);
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(EdificioId $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
