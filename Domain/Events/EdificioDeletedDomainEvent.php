<?php

declare(strict_types=1);

require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../ValueObjects/EdificioId.php';

final class EdificioDeletedDomainEvent extends DomainEvent
{
    private EdificioId $edificioId;

    public function __construct(EdificioId $edificioId)
    {
        parent::__construct('edificio.deleted');
        $this->edificioId = $edificioId;
    }

    public function edificioId(): EdificioId
    {
        return $this->edificioId;
    }

    public function payload(): array
    {
        return array(
            'id' => $this->edificioId->value(),
        );
    }
}
