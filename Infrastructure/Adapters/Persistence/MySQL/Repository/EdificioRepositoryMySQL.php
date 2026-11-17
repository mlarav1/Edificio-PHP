<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SaveEdificioPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/UpdateEdificioPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetEdificioByIdPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetEdificioByNombreAndCiudadPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAllEdificiosPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/DeleteEdificioPort.php';

require_once __DIR__ . '/../Mapper/EdificioPersistenceMapper.php';
require_once __DIR__ . '/../../../../../Domain/Models/EdificioModel.php';

final class EdificioRepositoryMySQL implements
    SaveEdificioPort,
    UpdateEdificioPort,
    GetEdificioByIdPort,
    GetEdificioByNombreAndCiudadPort,
    GetAllEdificiosPort,
    DeleteEdificioPort
{
    private const SELECT_COLUMNS = '
        id,
        nombre,
        metros_cuadrados,
        altura,
        num_pisos,
        num_apartamentos,
        num_oficinas,
        nombre_parqueadero,
        num_piscinas,
        pais,
        departamento,
        ciudad,
        tiene_ascensor,
        valor_administracion,
        tiene_zona_social,
        created_at,
        updated_at
    ';

    private PDO $pdo;
    private EdificioPersistenceMapper $mapper;

    public function __construct(PDO $pdo, EdificioPersistenceMapper $mapper)
    {
        $this->pdo = $pdo;
        $this->mapper = $mapper;
    }

    public function save(EdificioModel $edificio): EdificioModel
    {
        $dto = $this->mapper->fromModelToDto($edificio);

        $sql = '
            INSERT INTO edificios (
                id, nombre, metros_cuadrados, altura, num_pisos, num_apartamentos,
                num_oficinas, nombre_parqueadero, num_piscinas, pais, departamento,
                ciudad, tiene_ascensor, valor_administracion, tiene_zona_social,
                created_at, updated_at
            ) VALUES (
                :id, :nombre, :metros_cuadrados, :altura, :num_pisos, :num_apartamentos,
                :num_oficinas, :nombre_parqueadero, :num_piscinas, :pais, :departamento,
                :ciudad, :tiene_ascensor, :valor_administracion, :tiene_zona_social,
                NOW(), NOW()
            )
        ';

        $this->pdo->prepare($sql)->execute($this->bindParameters($dto));

        $saved = $this->getById(new EdificioId($dto->id()));

        if ($saved === null) {
            throw new RuntimeException('El edificio no pudo recuperarse despues de guardarlo.');
        }

        return $saved;
    }

    public function update(EdificioModel $edificio): EdificioModel
    {
        $dto = $this->mapper->fromModelToDto($edificio);

        $sql = '
            UPDATE edificios
               SET nombre = :nombre,
                   metros_cuadrados = :metros_cuadrados,
                   altura = :altura,
                   num_pisos = :num_pisos,
                   num_apartamentos = :num_apartamentos,
                   num_oficinas = :num_oficinas,
                   nombre_parqueadero = :nombre_parqueadero,
                   num_piscinas = :num_piscinas,
                   pais = :pais,
                   departamento = :departamento,
                   ciudad = :ciudad,
                   tiene_ascensor = :tiene_ascensor,
                   valor_administracion = :valor_administracion,
                   tiene_zona_social = :tiene_zona_social,
                   updated_at = NOW()
             WHERE id = :id
        ';

        $this->pdo->prepare($sql)->execute($this->bindParameters($dto));

        $updated = $this->getById(new EdificioId($dto->id()));

        if ($updated === null) {
            throw new RuntimeException('El edificio no pudo recuperarse despues de actualizarlo.');
        }

        return $updated;
    }

    public function getById(EdificioId $edificioId): ?EdificioModel
    {
        $statement = $this->pdo->prepare(
            'SELECT ' . self::SELECT_COLUMNS . ' FROM edificios WHERE id = :id LIMIT 1'
        );
        $statement->execute(array(':id' => $edificioId->value()));

        $row = $statement->fetch();

        return $row === false ? null : $this->mapper->fromRowToModel($row);
    }

    public function getByNombreAndCiudad(EdificioNombre $nombre, EdificioUbicacion $ubicacion): ?EdificioModel
    {
        $statement = $this->pdo->prepare(
            'SELECT ' . self::SELECT_COLUMNS . ' FROM edificios WHERE nombre = :nombre AND ciudad = :ciudad LIMIT 1'
        );
        $statement->execute(array(
            ':nombre' => $nombre->value(),
            ':ciudad' => $ubicacion->ciudad(),
        ));

        $row = $statement->fetch();

        return $row === false ? null : $this->mapper->fromRowToModel($row);
    }

    /**
     * @return EdificioModel[]
     */
    public function getAll(): array
    {
        $statement = $this->pdo->query(
            'SELECT ' . self::SELECT_COLUMNS . ' FROM edificios ORDER BY nombre ASC'
        );

        return $this->mapper->fromRowsToModels($statement->fetchAll());
    }

    public function delete(EdificioId $edificioId): void
    {
        $statement = $this->pdo->prepare('DELETE FROM edificios WHERE id = :id');
        $statement->execute(array(':id' => $edificioId->value()));
    }

    /**
     * @return array<string, string|int|float>
     */
    private function bindParameters(EdificioPersistenceDto $dto): array
    {
        return array(
            ':id' => $dto->id(),
            ':nombre' => $dto->nombre(),
            ':metros_cuadrados' => $dto->metrosCuadrados(),
            ':altura' => $dto->altura(),
            ':num_pisos' => $dto->numPisos(),
            ':num_apartamentos' => $dto->numApartamentos(),
            ':num_oficinas' => $dto->numOficinas(),
            ':nombre_parqueadero' => $dto->nombreParqueadero(),
            ':num_piscinas' => $dto->numPiscinas(),
            ':pais' => $dto->pais(),
            ':departamento' => $dto->departamento(),
            ':ciudad' => $dto->ciudad(),
            ':tiene_ascensor' => $dto->tieneAscensor() ? 1 : 0,
            ':valor_administracion' => $dto->valorAdministracion(),
            ':tiene_zona_social' => $dto->tieneZonaSocial() ? 1 : 0,
        );
    }
}