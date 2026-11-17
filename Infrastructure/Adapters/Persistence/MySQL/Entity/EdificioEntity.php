<?php

declare(strict_types=1);

final class EdificioEntity
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
    private ?string $createdAt;
    private ?string $updatedAt;

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
        bool $tieneZonaSocial,
        ?string $createdAt = null,
        ?string $updatedAt = null
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
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function metrosCuadrados(): float
    {
        return $this->metrosCuadrados;
    }

    public function altura(): float
    {
        return $this->altura;
    }

    public function numPisos(): int
    {
        return $this->numPisos;
    }

    public function numApartamentos(): int
    {
        return $this->numApartamentos;
    }

    public function numOficinas(): int
    {
        return $this->numOficinas;
    }

    public function nombreParqueadero(): string
    {
        return $this->nombreParqueadero;
    }

    public function numPiscinas(): int
    {
        return $this->numPiscinas;
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

    public function tieneAscensor(): bool
    {
        return $this->tieneAscensor;
    }

    public function valorAdministracion(): float
    {
        return $this->valorAdministracion;
    }

    public function tieneZonaSocial(): bool
    {
        return $this->tieneZonaSocial;
    }

    public function createdAt(): ?string
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?string
    {
        return $this->updatedAt;
    }
}
