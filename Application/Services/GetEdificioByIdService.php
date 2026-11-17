<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetEdificioByIdUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetEdificioByIdPort.php';
require_once __DIR__ . '/Mappers/EdificioApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/EdificioNotFoundException.php';

final class GetEdificioByIdService implements GetEdificioByIdUseCase
{
    private GetEdificioByIdPort $getEdificioByIdPort;

    public function __construct(GetEdificioByIdPort $getEdificioByIdPort)
    {
        $this->getEdificioByIdPort = $getEdificioByIdPort;
    }

    public function execute(GetEdificioByIdQuery $query): EdificioModel
    {
        $edificioId = EdificioApplicationMapper::fromGetByIdQueryToEdificioId($query);
        $edificio = $this->getEdificioByIdPort->getById($edificioId);

        if ($edificio === null) {
            throw EdificioNotFoundException::becauseIdWasNotFound($edificioId->value());
        }

        return $edificio;
    }
}