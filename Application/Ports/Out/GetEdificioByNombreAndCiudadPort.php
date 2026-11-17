<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/EdificioModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/EdificioNombre.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/EdificioUbicacion.php';

interface GetEdificioByNombreAndCiudadPort
{
    public function getByNombreAndCiudad(EdificioNombre $nombre, EdificioUbicacion $ubicacion): ?EdificioModel;
}