<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/EdificioModel.php';

interface SaveEdificioPort
{
    public function save(EdificioModel $edificio): EdificioModel;
}