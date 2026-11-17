<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/UpdateEdificioCommand.php';
require_once __DIR__ . '/../../../Domain/Models/EdificioModel.php';

interface UpdateEdificioUseCase
{
    public function execute(UpdateEdificioCommand $command): EdificioModel;
}