<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetEdificioByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/EdificioModel.php';

interface GetEdificioByIdUseCase
{
    public function execute(GetEdificioByIdQuery $query): EdificioModel;
}