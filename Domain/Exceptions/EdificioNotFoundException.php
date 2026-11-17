<?php

declare(strict_types=1);

final class EdificioNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound(string $id): self
    {
        return new self(sprintf('No se encontró el edificio con id %s.', $id));
    }
}
