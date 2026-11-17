<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateEdificioUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateEdificioPort.php';
require_once __DIR__ . '/../Ports/Out/GetEdificioByIdPort.php';
require_once __DIR__ . '/../Ports/Out/GetEdificioByNombreAndCiudadPort.php';
require_once __DIR__ . '/Mappers/EdificioApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/EdificioAlreadyExistsException.php';
require_once __DIR__ . '/../../Domain/Exceptions/EdificioNotFoundException.php';

final class UpdateEdificioService implements UpdateEdificioUseCase
{
    private UpdateEdificioPort $updateEdificioPort;
    private GetEdificioByIdPort $getEdificioByIdPort;
    private GetEdificioByNombreAndCiudadPort $getEdificioByNombreAndCiudadPort;

    public function __construct(
        UpdateEdificioPort $updateEdificioPort,
        GetEdificioByIdPort $getEdificioByIdPort,
        GetEdificioByNombreAndCiudadPort $getEdificioByNombreAndCiudadPort
    ) {
        $this->updateEdificioPort = $updateEdificioPort;
        $this->getEdificioByIdPort = $getEdificioByIdPort;
        $this->getEdificioByNombreAndCiudadPort = $getEdificioByNombreAndCiudadPort;
    }

    public function execute(UpdateEdificioCommand $command): EdificioModel
    {
        $edificioToUpdate = EdificioApplicationMapper::fromUpdateCommandToModel($command);

        $current = $this->getEdificioByIdPort->getById($edificioToUpdate->id());

        if ($current === null) {
            throw EdificioNotFoundException::becauseIdWasNotFound($edificioToUpdate->id()->value());
        }

        $sameNameAndCity = $this->getEdificioByNombreAndCiudadPort->getByNombreAndCiudad(
            $edificioToUpdate->nombre(),
            $edificioToUpdate->ubicacion()
        );

        if ($sameNameAndCity !== null && !$sameNameAndCity->id()->equals($edificioToUpdate->id())) {
            throw EdificioAlreadyExistsException::becauseNameAlreadyExistsInCity(
                $edificioToUpdate->nombre()->value(),
                $edificioToUpdate->ubicacion()->ciudad()
            );
        }

        return $this->updateEdificioPort->update($edificioToUpdate);
    }
}