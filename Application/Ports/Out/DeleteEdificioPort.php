<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/ValueObjects/EdificioId.php';

interface DeleteEdificioPort
{
    public function delete(EdificioId $edificioId): void;
}