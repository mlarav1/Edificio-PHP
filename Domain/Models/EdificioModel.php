<?php

declare(strict_types=1);

require_once __DIR__ . '/../ValueObjects/EdificioId.php';
require_once __DIR__ . '/../ValueObjects/EdificioNombre.php';
require_once __DIR__ . '/../ValueObjects/EdificioMetrosCuadrados.php';
require_once __DIR__ . '/../ValueObjects/EdificioAltura.php';
require_once __DIR__ . '/../ValueObjects/EdificioNumPisos.php';
require_once __DIR__ . '/../ValueObjects/EdificioNumApartamentos.php';
require_once __DIR__ . '/../ValueObjects/EdificioNumOficinas.php';
require_once __DIR__ . '/../ValueObjects/EdificioNombreParqueadero.php';
require_once __DIR__ . '/../ValueObjects/EdificioNumPiscinas.php';
require_once __DIR__ . '/../ValueObjects/EdificioUbicacion.php';
require_once __DIR__ . '/../ValueObjects/EdificioValorAdministracion.php';
require_once __DIR__ . '/../Exceptions/InvalidEdificioFieldException.php';

final class EdificioModel
{
    /** Altura minima razonable por piso, en metros. */
    private const MIN_HEIGHT_PER_FLOOR = 2.0;

    private EdificioId $id;
    private EdificioNombre $nombre;
    private EdificioMetrosCuadrados $metrosCuadrados;
    private EdificioAltura $altura;
    private EdificioNumPisos $numPisos;
    private EdificioNumApartamentos $numApartamentos;
    private EdificioNumOficinas $numOficinas;
    private EdificioNombreParqueadero $nombreParqueadero;
    private EdificioNumPiscinas $numPiscinas;
    private EdificioUbicacion $ubicacion;
    private bool $tieneAscensor;
    private EdificioValorAdministracion $valorAdministracion;
    private bool $tieneZonaSocial;

    public function __construct(
        EdificioId $id,
        EdificioNombre $nombre,
        EdificioMetrosCuadrados $metrosCuadrados,
        EdificioAltura $altura,
        EdificioNumPisos $numPisos,
        EdificioNumApartamentos $numApartamentos,
        EdificioNumOficinas $numOficinas,
        EdificioNombreParqueadero $nombreParqueadero,
        EdificioNumPiscinas $numPiscinas,
        EdificioUbicacion $ubicacion,
        bool $tieneAscensor,
        EdificioValorAdministracion $valorAdministracion,
        bool $tieneZonaSocial
    ) {
        self::ensureHasUnits($numApartamentos, $numOficinas);
        self::ensureHeightIsConsistent($altura, $numPisos);

        $this->id = $id;
        $this->nombre = $nombre;
        $this->metrosCuadrados = $metrosCuadrados;
        $this->altura = $altura;
        $this->numPisos = $numPisos;
        $this->numApartamentos = $numApartamentos;
        $this->numOficinas = $numOficinas;
        $this->nombreParqueadero = $nombreParqueadero;
        $this->numPiscinas = $numPiscinas;
        $this->ubicacion = $ubicacion;
        $this->tieneAscensor = $tieneAscensor;
        $this->valorAdministracion = $valorAdministracion;
        $this->tieneZonaSocial = $tieneZonaSocial;
    }

    public static function create(
        EdificioId $id,
        EdificioNombre $nombre,
        EdificioMetrosCuadrados $metrosCuadrados,
        EdificioAltura $altura,
        EdificioNumPisos $numPisos,
        EdificioNumApartamentos $numApartamentos,
        EdificioNumOficinas $numOficinas,
        EdificioNombreParqueadero $nombreParqueadero,
        EdificioNumPiscinas $numPiscinas,
        EdificioUbicacion $ubicacion,
        bool $tieneAscensor,
        EdificioValorAdministracion $valorAdministracion,
        bool $tieneZonaSocial
    ): self {
        return new self(
            $id,
            $nombre,
            $metrosCuadrados,
            $altura,
            $numPisos,
            $numApartamentos,
            $numOficinas,
            $nombreParqueadero,
            $numPiscinas,
            $ubicacion,
            $tieneAscensor,
            $valorAdministracion,
            $tieneZonaSocial
        );
    }

    public function id(): EdificioId
    {
        return $this->id;
    }

    public function nombre(): EdificioNombre
    {
        return $this->nombre;
    }

    public function metrosCuadrados(): EdificioMetrosCuadrados
    {
        return $this->metrosCuadrados;
    }

    public function altura(): EdificioAltura
    {
        return $this->altura;
    }

    public function numPisos(): EdificioNumPisos
    {
        return $this->numPisos;
    }

    public function numApartamentos(): EdificioNumApartamentos
    {
        return $this->numApartamentos;
    }

    public function numOficinas(): EdificioNumOficinas
    {
        return $this->numOficinas;
    }

    public function nombreParqueadero(): EdificioNombreParqueadero
    {
        return $this->nombreParqueadero;
    }

    public function numPiscinas(): EdificioNumPiscinas
    {
        return $this->numPiscinas;
    }

    public function ubicacion(): EdificioUbicacion
    {
        return $this->ubicacion;
    }

    public function tieneAscensor(): bool
    {
        return $this->tieneAscensor;
    }

    public function valorAdministracion(): EdificioValorAdministracion
    {
        return $this->valorAdministracion;
    }

    public function tieneZonaSocial(): bool
    {
        return $this->tieneZonaSocial;
    }

    public function totalUnidades(): int
    {
        return $this->numApartamentos->value() + $this->numOficinas->value();
    }

    public function alturaPorPiso(): float
    {
        return round($this->altura->value() / $this->numPisos->value(), 2);
    }

    /**
     * @return array<string, string|int|float|bool>
     */
    public function toArray(): array
    {
        return array(
            'id' => $this->id->value(),
            'nombre' => $this->nombre->value(),
            'metrosCuadrados' => $this->metrosCuadrados->value(),
            'altura' => $this->altura->value(),
            'numPisos' => $this->numPisos->value(),
            'numApartamentos' => $this->numApartamentos->value(),
            'numOficinas' => $this->numOficinas->value(),
            'nombreParqueadero' => $this->nombreParqueadero->value(),
            'numPiscinas' => $this->numPiscinas->value(),
            'pais' => $this->ubicacion->pais(),
            'departamento' => $this->ubicacion->departamento(),
            'ciudad' => $this->ubicacion->ciudad(),
            'tieneAscensor' => $this->tieneAscensor,
            'valorAdministracion' => $this->valorAdministracion->value(),
            'tieneZonaSocial' => $this->tieneZonaSocial,
        );
    }

    private static function ensureHasUnits(
        EdificioNumApartamentos $numApartamentos,
        EdificioNumOficinas $numOficinas
    ): void {
        if ($numApartamentos->value() + $numOficinas->value() === 0) {
            throw InvalidEdificioFieldException::becauseBuildingHasNoUnits();
        }
    }

    private static function ensureHeightIsConsistent(EdificioAltura $altura, EdificioNumPisos $numPisos): void
    {
        if ($altura->value() / $numPisos->value() < self::MIN_HEIGHT_PER_FLOOR) {
            throw InvalidEdificioFieldException::becauseHeightIsInconsistentWithFloors(self::MIN_HEIGHT_PER_FLOOR);
        }
    }
}
