<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidEdificioFieldException.php';

/**
 * Agrupa pais, departamento y ciudad: tres atributos de negocio que solo
 * tienen sentido juntos (ubicacion geografica del edificio).
 */
final class EdificioUbicacion
{
    private const MIN_LENGTH = 2;
    private const MAX_LENGTH = 100;

    private string $pais;
    private string $departamento;
    private string $ciudad;

    public function __construct(string $pais, string $departamento, string $ciudad)
    {
        $this->pais = self::normalize('pais', $pais);
        $this->departamento = self::normalize('departamento', $departamento);
        $this->ciudad = self::normalize('ciudad', $ciudad);
    }

    public function pais(): string
    {
        return $this->pais;
    }

    public function departamento(): string
    {
        return $this->departamento;
    }

    public function ciudad(): string
    {
        return $this->ciudad;
    }

    public function equals(EdificioUbicacion $other): bool
    {
        return $this->pais === $other->pais()
            && $this->departamento === $other->departamento()
            && $this->ciudad === $other->ciudad();
    }

    public function __toString(): string
    {
        return $this->ciudad . ', ' . $this->departamento . ', ' . $this->pais;
    }

    private static function normalize(string $field, string $value): string
    {
        $normalizedValue = trim($value);

        if ($normalizedValue === '') {
            throw InvalidEdificioFieldException::becauseValueIsEmpty($field);
        }

        if (mb_strlen($normalizedValue) < self::MIN_LENGTH) {
            throw InvalidEdificioFieldException::becauseLengthIsTooShort($field, self::MIN_LENGTH);
        }

        if (mb_strlen($normalizedValue) > self::MAX_LENGTH) {
            throw InvalidEdificioFieldException::becauseLengthIsTooLong($field, self::MAX_LENGTH);
        }

        return $normalizedValue;
    }
}
