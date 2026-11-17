<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateEdificioUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveEdificioPort.php';
require_once __DIR__ . '/../Ports/Out/GetEdificioByNombreAndCiudadPort.php';
require_once __DIR__ . '/Mappers/EdificioApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/EdificioAlreadyExistsException.php';

final class CreateEdificioService implements CreateEdificioUseCase
{
    private SaveEdificioPort $saveEdificioPort;
    private GetEdificioByNombreAndCiudadPort $getEdificioByNombreAndCiudadPort;

    public function __construct(
        SaveEdificioPort $saveEdificioPort,
        GetEdificioByNombreAndCiudadPort $getEdificioByNombreAndCiudadPort
    ) {
        $this->saveEdificioPort = $saveEdificioPort;
        $this->getEdificioByNombreAndCiudadPort = $getEdificioByNombreAndCiudadPort;
    }

    public function execute(CreateEdificioCommand $command): EdificioModel
    {
        $edificio = EdificioApplicationMapper::fromCreateCommandToModel($command);

        $existing = $this->getEdificioByNombreAndCiudadPort->getByNombreAndCiudad(
            $edificio->nombre(),
            $edificio->ubicacion()
        );

        if ($existing !== null) {
            throw EdificioAlreadyExistsException::becauseNameAlreadyExistsInCity(
                $edificio->nombre()->value(),
                $edificio->ubicacion()->ciudad()
            );
        }

        return $this->saveEdificioPort->save($edificio);
    }
}