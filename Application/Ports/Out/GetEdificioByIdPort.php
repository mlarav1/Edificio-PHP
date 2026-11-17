<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/EdificioModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/EdificioId.php';

interface GetEdificioByIdPort
{
    public function getById(EdificioId $edificioId): ?EdificioModel;
}