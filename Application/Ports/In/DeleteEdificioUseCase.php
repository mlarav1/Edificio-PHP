<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/DeleteEdificioCommand.php';

interface DeleteEdificioUseCase
{
    public function execute(DeleteEdificioCommand $command): void;
}