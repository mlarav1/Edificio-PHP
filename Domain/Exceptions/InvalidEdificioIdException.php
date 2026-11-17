<?php

declare(strict_types=1);

final class InvalidEdificioIdException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El identificador del edificio no puede estar vacío.');
    }

    public static function becauseLengthIsTooLong(int $maxLength): self
    {
        return new self(sprintf('El identificador del edificio no puede superar %d caracteres.', $maxLength));
    }
}
