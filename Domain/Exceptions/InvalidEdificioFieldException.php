<?php

declare(strict_types=1);

final class InvalidEdificioFieldException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(string $field): self
    {
        return new self(sprintf('El campo "%s" del edificio no puede estar vacío.', $field));
    }

    public static function becauseLengthIsTooShort(string $field, int $minLength): self
    {
        return new self(sprintf('El campo "%s" del edificio debe tener al menos %d caracteres.', $field, $minLength));
    }

    public static function becauseLengthIsTooLong(string $field, int $maxLength): self
    {
        return new self(sprintf('El campo "%s" del edificio no puede superar %d caracteres.', $field, $maxLength));
    }

    public static function becauseValueMustBePositive(string $field): self
    {
        return new self(sprintf('El campo "%s" del edificio debe ser mayor que cero.', $field));
    }

    public static function becauseValueMustNotBeNegative(string $field): self
    {
        return new self(sprintf('El campo "%s" del edificio no puede ser negativo.', $field));
    }

    public static function becauseValueExceedsMaximum(string $field, float|int $maximum): self
    {
        return new self(sprintf('El campo "%s" del edificio no puede ser mayor que %s.', $field, (string) $maximum));
    }

    public static function becauseBuildingHasNoUnits(): self
    {
        return new self('El edificio debe tener al menos un apartamento o una oficina.');
    }

    public static function becauseHeightIsInconsistentWithFloors(float $minimumHeightPerFloor): self
    {
        return new self(sprintf(
            'La altura del edificio es inconsistente con su número de pisos (mínimo %.1f m por piso).',
            $minimumHeightPerFloor
        ));
    }
}
