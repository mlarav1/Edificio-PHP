<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/CreateEdificioCommand.php';
require_once __DIR__ . '/../../../Domain/Models/EdificioModel.php';

interface CreateEdificioUseCase
{
    public function execute(CreateEdificioCommand $command): EdificioModel;
}