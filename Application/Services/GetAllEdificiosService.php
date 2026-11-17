<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAllEdificiosUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAllEdificiosPort.php';

final class GetAllEdificiosService implements GetAllEdificiosUseCase
{
    private GetAllEdificiosPort $getAllEdificiosPort;

    public function __construct(GetAllEdificiosPort $getAllEdificiosPort)
    {
        $this->getAllEdificiosPort = $getAllEdificiosPort;
    }

    /**
     * @return EdificioModel[]
     */
    public function execute(GetAllEdificiosQuery $query): array
    {
        return $this->getAllEdificiosPort->getAll();
    }
}