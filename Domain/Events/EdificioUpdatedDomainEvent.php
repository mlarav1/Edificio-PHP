<?php

declare(strict_types=1);

require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../Models/EdificioModel.php';

final class EdificioUpdatedDomainEvent extends DomainEvent
{
    private EdificioModel $edificio;

    public function __construct(EdificioModel $edificio)
    {
        parent::__construct('edificio.updated');
        $this->edificio = $edificio;
    }

    public function edificio(): EdificioModel
    {
        return $this->edificio;
    }

    public function payload(): array
    {
        return $this->edificio->toArray();
    }
}
