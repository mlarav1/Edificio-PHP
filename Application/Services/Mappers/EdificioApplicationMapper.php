<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/Commands/CreateEdificioCommand.php';
require_once __DIR__ . '/../Dto/Commands/UpdateEdificioCommand.php';
require_once __DIR__ . '/../Dto/Commands/DeleteEdificioCommand.php';
require_once __DIR__ . '/../Dto/Queries/GetEdificioByIdQuery.php';

require_once __DIR__ . '/../../../Domain/Models/EdificioModel.php';

final class EdificioApplicationMapper
{
    public static function fromCreateCommandToModel(CreateEdificioCommand $command): EdificioModel
    {
        return new EdificioModel(
            new EdificioId($command->getId()),
            new EdificioNombre($command->getNombre()),
            new EdificioMetrosCuadrados($command->getMetrosCuadrados()),
            new EdificioAltura($command->getAltura()),
            new EdificioNumPisos($command->getNumPisos()),
            new EdificioNumApartamentos($command->getNumApartamentos()),
            new EdificioNumOficinas($command->getNumOficinas()),
            new EdificioNombreParqueadero($command->getNombreParqueadero()),
            new EdificioNumPiscinas($command->getNumPiscinas()),
            new EdificioUbicacion($command->getPais(), $command->getDepartamento(), $command->getCiudad()),
            $command->getTieneAscensor(),
            new EdificioValorAdministracion($command->getValorAdministracion()),
            $command->getTieneZonaSocial()
        );
    }

    public static function fromUpdateCommandToModel(UpdateEdificioCommand $command): EdificioModel
    {
        return new EdificioModel(
            new EdificioId($command->getId()),
            new EdificioNombre($command->getNombre()),
            new EdificioMetrosCuadrados($command->getMetrosCuadrados()),
            new EdificioAltura($command->getAltura()),
            new EdificioNumPisos($command->getNumPisos()),
            new EdificioNumApartamentos($command->getNumApartamentos()),
            new EdificioNumOficinas($command->getNumOficinas()),
            new EdificioNombreParqueadero($command->getNombreParqueadero()),
            new EdificioNumPiscinas($command->getNumPiscinas()),
            new EdificioUbicacion($command->getPais(), $command->getDepartamento(), $command->getCiudad()),
            $command->getTieneAscensor(),
            new EdificioValorAdministracion($command->getValorAdministracion()),
            $command->getTieneZonaSocial()
        );
    }

    public static function fromGetByIdQueryToEdificioId(GetEdificioByIdQuery $query): EdificioId
    {
        return new EdificioId($query->getId());
    }

    public static function fromDeleteCommandToEdificioId(DeleteEdificioCommand $command): EdificioId
    {
        return new EdificioId($command->getId());
    }
}