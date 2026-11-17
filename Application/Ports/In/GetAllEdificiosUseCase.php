<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetAllEdificiosQuery.php';
require_once __DIR__ . '/../../../Domain/Models/EdificioModel.php';

interface GetAllEdificiosUseCase
{
    /**
     * @return EdificioModel[]
     */
    public function execute(GetAllEdificiosQuery $query): array;
}