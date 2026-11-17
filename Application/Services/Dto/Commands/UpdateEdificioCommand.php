<?php

declare(strict_types=1);

final class UpdateEdificioCommand
{
    private string $id;
    private string $nombre;
    private float $metrosCuadrados;
    private float $altura;
    private int $numPisos;
    private int $numApartamentos;
    private int $numOficinas;
    private string $nombreParqueadero;
    private int $numPiscinas;
    private string $pais;
    private string $departamento;
    private string $ciudad;
    private bool $tieneAscensor;
    private float $valorAdministracion;
    private bool $tieneZonaSocial;

    public function __construct(
        string $id,
        string $nombre,
        float $metrosCuadrados,
        float $altura,
        int $numPisos,
        int $numApartamentos,
        int $numOficinas,
        string $nombreParqueadero,
        int $numPiscinas,
        string $pais,
        string $departamento,
        string $ciudad,
        bool $tieneAscensor,
        float $valorAdministracion,
        bool $tieneZonaSocial
    ) {
        $this->id = trim($id);
        $this->nombre = trim($nombre);
        $this->metrosCuadrados = $metrosCuadrados;
        $this->altura = $altura;
        $this->numPisos = $numPisos;
        $this->numApartamentos = $numApartamentos;
        $this->numOficinas = $numOficinas;
        $this->nombreParqueadero = trim($nombreParqueadero);
        $this->numPiscinas = $numPiscinas;
        $this->pais = trim($pais);
        $this->departamento = trim($departamento);
        $this->ciudad = trim($ciudad);
        $this->tieneAscensor = $tieneAscensor;
        $this->valorAdministracion = $valorAdministracion;
        $this->tieneZonaSocial = $tieneZonaSocial;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getMetrosCuadrados(): float
    {
        return $this->metrosCuadrados;
    }

    public function getAltura(): float
    {
        return $this->altura;
    }

    public function getNumPisos(): int
    {
        return $this->numPisos;
    }

    public function getNumApartamentos(): int
    {
        return $this->numApartamentos;
    }

    public function getNumOficinas(): int
    {
        return $this->numOficinas;
    }

    public function getNombreParqueadero(): string
    {
        return $this->nombreParqueadero;
    }

    public function getNumPiscinas(): int
    {
        return $this->numPiscinas;
    }

    public function getPais(): string
    {
        return $this->pais;
    }

    public function getDepartamento(): string
    {
        return $this->departamento;
    }

    public function getCiudad(): string
    {
        return $this->ciudad;
    }

    public function getTieneAscensor(): bool
    {
        return $this->tieneAscensor;
    }

    public function getValorAdministracion(): float
    {
        return $this->valorAdministracion;
    }

    public function getTieneZonaSocial(): bool
    {
        return $this->tieneZonaSocial;
    }
}
