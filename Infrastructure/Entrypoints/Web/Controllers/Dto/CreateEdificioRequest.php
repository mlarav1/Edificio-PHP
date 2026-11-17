<?php

declare(strict_types=1);

final class CreateEdificioWebRequest
{
    private string $id;
    private string $nombre;
    private string $metrosCuadrados;
    private string $altura;
    private string $numPisos;
    private string $numApartamentos;
    private string $numOficinas;
    private string $nombreParqueadero;
    private string $numPiscinas;
    private string $pais;
    private string $departamento;
    private string $ciudad;
    private bool $tieneAscensor;
    private string $valorAdministracion;
    private bool $tieneZonaSocial;

    public function __construct(
        string $id,
        string $nombre,
        string $metrosCuadrados,
        string $altura,
        string $numPisos,
        string $numApartamentos,
        string $numOficinas,
        string $nombreParqueadero,
        string $numPiscinas,
        string $pais,
        string $departamento,
        string $ciudad,
        bool $tieneAscensor,
        string $valorAdministracion,
        bool $tieneZonaSocial
    ) {
        $this->id = trim($id);
        $this->nombre = trim($nombre);
        $this->metrosCuadrados = trim($metrosCuadrados);
        $this->altura = trim($altura);
        $this->numPisos = trim($numPisos);
        $this->numApartamentos = trim($numApartamentos);
        $this->numOficinas = trim($numOficinas);
        $this->nombreParqueadero = trim($nombreParqueadero);
        $this->numPiscinas = trim($numPiscinas);
        $this->pais = trim($pais);
        $this->departamento = trim($departamento);
        $this->ciudad = trim($ciudad);
        $this->tieneAscensor = $tieneAscensor;
        $this->valorAdministracion = trim($valorAdministracion);
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

    public function getMetrosCuadrados(): string
    {
        return $this->metrosCuadrados;
    }

    public function getAltura(): string
    {
        return $this->altura;
    }

    public function getNumPisos(): string
    {
        return $this->numPisos;
    }

    public function getNumApartamentos(): string
    {
        return $this->numApartamentos;
    }

    public function getNumOficinas(): string
    {
        return $this->numOficinas;
    }

    public function getNombreParqueadero(): string
    {
        return $this->nombreParqueadero;
    }

    public function getNumPiscinas(): string
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

    public function getValorAdministracion(): string
    {
        return $this->valorAdministracion;
    }

    public function getTieneZonaSocial(): bool
    {
        return $this->tieneZonaSocial;
    }
}
