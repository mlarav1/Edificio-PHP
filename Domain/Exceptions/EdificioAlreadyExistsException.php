<?php

declare(strict_types=1);

final class EdificioAlreadyExistsException extends DomainException
{
    public static function becauseNameAlreadyExistsInCity(string $nombre, string $ciudad): self
    {
        return new self(sprintf('Ya existe un edificio llamado "%s" en la ciudad %s.', $nombre, $ciudad));
    }
}
