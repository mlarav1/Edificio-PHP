<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/EdificioPersistenceDto.php';
require_once __DIR__ . '/../Entity/EdificioEntity.php';

require_once __DIR__ . '/../../../../../Domain/Models/EdificioModel.php';

final class EdificioPersistenceMapper
{
    public function fromModelToDto(EdificioModel $edificio): EdificioPersistenceDto
    {
        return new EdificioPersistenceDto(
            $edificio->id()->value(),
            $edificio->nombre()->value(),
            $edificio->metrosCuadrados()->value(),
            $edificio->altura()->value(),
            $edificio->numPisos()->value(),
            $edificio->numApartamentos()->value(),
            $edificio->numOficinas()->value(),
            $edificio->nombreParqueadero()->value(),
            $edificio->numPiscinas()->value(),
            $edificio->ubicacion()->pais(),
            $edificio->ubicacion()->departamento(),
            $edificio->ubicacion()->ciudad(),
            $edificio->tieneAscensor(),
            $edificio->valorAdministracion()->value(),
            $edificio->tieneZonaSocial()
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToEntity(array $row): EdificioEntity
    {
        return new EdificioEntity(
            (string) $row['id'],
            (string) $row['nombre'],
            (float) $row['metros_cuadrados'],
            (float) $row['altura'],
            (int) $row['num_pisos'],
            (int) $row['num_apartamentos'],
            (int) $row['num_oficinas'],
            (string) $row['nombre_parqueadero'],
            (int) $row['num_piscinas'],
            (string) $row['pais'],
            (string) $row['departamento'],
            (string) $row['ciudad'],
            (bool) $row['tiene_ascensor'],
            (float) $row['valor_administracion'],
            (bool) $row['tiene_zona_social'],
            isset($row['created_at']) ? (string) $row['created_at'] : null,
            isset($row['updated_at']) ? (string) $row['updated_at'] : null
        );
    }

    public function fromEntityToModel(EdificioEntity $entity): EdificioModel
    {
        return new EdificioModel(
            new EdificioId($entity->id()),
            new EdificioNombre($entity->nombre()),
            new EdificioMetrosCuadrados($entity->metrosCuadrados()),
            new EdificioAltura($entity->altura()),
            new EdificioNumPisos($entity->numPisos()),
            new EdificioNumApartamentos($entity->numApartamentos()),
            new EdificioNumOficinas($entity->numOficinas()),
            new EdificioNombreParqueadero($entity->nombreParqueadero()),
            new EdificioNumPiscinas($entity->numPiscinas()),
            new EdificioUbicacion($entity->pais(), $entity->departamento(), $entity->ciudad()),
            $entity->tieneAscensor(),
            new EdificioValorAdministracion($entity->valorAdministracion()),
            $entity->tieneZonaSocial()
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToModel(array $row): EdificioModel
    {
        return $this->fromEntityToModel($this->fromRowToEntity($row));
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return EdificioModel[]
     */
    public function fromRowsToModels(array $rows): array
    {
        $models = array();

        foreach ($rows as $row) {
            $models[] = $this->fromRowToModel($row);
        }

        return $models;
    }
}