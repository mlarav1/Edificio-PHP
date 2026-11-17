<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/CreateEdificioRequest.php';
require_once __DIR__ . '/../Dto/UpdateEdificioRequest.php';
require_once __DIR__ . '/../Dto/EdificioResponse.php';

require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/CreateEdificioCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/UpdateEdificioCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/DeleteEdificioCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetEdificioByIdQuery.php';

require_once __DIR__ . '/../../../../../Domain/Models/EdificioModel.php';

final class EdificioWebMapper
{
    public function fromCreateRequestToCommand(CreateEdificioWebRequest $request): CreateEdificioCommand
    {
        return new CreateEdificioCommand(
            $request->getId(),
            $request->getNombre(),
            self::toFloat($request->getMetrosCuadrados()),
            self::toFloat($request->getAltura()),
            (int) $request->getNumPisos(),
            (int) $request->getNumApartamentos(),
            (int) $request->getNumOficinas(),
            $request->getNombreParqueadero(),
            (int) $request->getNumPiscinas(),
            $request->getPais(),
            $request->getDepartamento(),
            $request->getCiudad(),
            $request->getTieneAscensor(),
            self::toFloat($request->getValorAdministracion()),
            $request->getTieneZonaSocial()
        );
    }

    public function fromUpdateRequestToCommand(UpdateEdificioWebRequest $request): UpdateEdificioCommand
    {
        return new UpdateEdificioCommand(
            $request->getId(),
            $request->getNombre(),
            self::toFloat($request->getMetrosCuadrados()),
            self::toFloat($request->getAltura()),
            (int) $request->getNumPisos(),
            (int) $request->getNumApartamentos(),
            (int) $request->getNumOficinas(),
            $request->getNombreParqueadero(),
            (int) $request->getNumPiscinas(),
            $request->getPais(),
            $request->getDepartamento(),
            $request->getCiudad(),
            $request->getTieneAscensor(),
            self::toFloat($request->getValorAdministracion()),
            $request->getTieneZonaSocial()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetEdificioByIdQuery
    {
        return new GetEdificioByIdQuery($id);
    }

    public function fromIdToDeleteCommand(string $id): DeleteEdificioCommand
    {
        return new DeleteEdificioCommand($id);
    }

    public function fromModelToResponse(EdificioModel $edificio): EdificioResponse
    {
        return new EdificioResponse(
            $edificio->id()->value(),
            $edificio->nombre()->value(),
            $edificio->metrosCuadrados()->value(),
            $edificio->altura()->value(),
            $edificio->numPisos()->value(),
            $edificio->numApartamentos()->value(),
            $edificio->numOficinas()->value(),
            $edificio->nombreParqueadero()->value(),
            $edificio->numPiscinas()->value(),
            $edificio->ubicacion()->pais(),
            $edificio->ubicacion()->departamento(),
            $edificio->ubicacion()->ciudad(),
            $edificio->tieneAscensor(),
            $edificio->valorAdministracion()->value(),
            $edificio->tieneZonaSocial()
        );
    }

    /**
     * @param EdificioModel[] $edificios
     * @return EdificioResponse[]
     */
    public function fromModelsToResponses(array $edificios): array
    {
        $responses = array();

        foreach ($edificios as $edificio) {
            $responses[] = $this->fromModelToResponse($edificio);
        }

        return $responses;
    }

    private static function toFloat(string $value): float
    {
        return (float) str_replace(',', '.', trim($value));
    }
}