<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteEdificioUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteEdificioPort.php';
require_once __DIR__ . '/../Ports/Out/GetEdificioByIdPort.php';
require_once __DIR__ . '/Mappers/EdificioApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/EdificioNotFoundException.php';

final class DeleteEdificioService implements DeleteEdificioUseCase
{
    private DeleteEdificioPort $deleteEdificioPort;
    private GetEdificioByIdPort $getEdificioByIdPort;

    public function __construct(
        DeleteEdificioPort $deleteEdificioPort,
        GetEdificioByIdPort $getEdificioByIdPort
    ) {
        $this->deleteEdificioPort = $deleteEdificioPort;
        $this->getEdificioByIdPort = $getEdificioByIdPort;
    }

    public function execute(DeleteEdificioCommand $command): void
    {
        $edificioId = EdificioApplicationMapper::fromDeleteCommandToEdificioId($command);

        if ($this->getEdificioByIdPort->getById($edificioId) === null) {
            throw EdificioNotFoundException::becauseIdWasNotFound($edificioId->value());
        }

        $this->deleteEdificioPort->delete($edificioId);
    }
}