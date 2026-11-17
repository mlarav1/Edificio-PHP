<?php

declare(strict_types=1);

/**
 * Pruebas ejecutables sin framework ni base de datos:
 *   php tests/EdificioCrudlTest.php
 * Usan un repositorio en memoria que implementa los puertos de salida,
 * demostrando que dominio y aplicacion no dependen de la infraestructura.
 */

require_once __DIR__ . '/../Common/ClassLoader.php';
require_once __DIR__ . '/../Application/Services/CreateEdificioService.php';
require_once __DIR__ . '/../Application/Services/UpdateEdificioService.php';
require_once __DIR__ . '/../Application/Services/GetEdificioByIdService.php';
require_once __DIR__ . '/../Application/Services/GetAllEdificiosService.php';
require_once __DIR__ . '/../Application/Services/DeleteEdificioService.php';

final class InMemoryEdificioRepository implements
    SaveEdificioPort,
    UpdateEdificioPort,
    GetEdificioByIdPort,
    GetEdificioByNombreAndCiudadPort,
    GetAllEdificiosPort,
    DeleteEdificioPort
{
    /** @var array<string, EdificioModel> */
    private array $items = array();

    public function save(EdificioModel $edificio): EdificioModel
    {
        $this->items[$edificio->id()->value()] = $edificio;
        return $edificio;
    }

    public function update(EdificioModel $edificio): EdificioModel
    {
        $this->items[$edificio->id()->value()] = $edificio;
        return $edificio;
    }

    public function getById(EdificioId $edificioId): ?EdificioModel
    {
        return $this->items[$edificioId->value()] ?? null;
    }

    public function getByNombreAndCiudad(EdificioNombre $nombre, EdificioUbicacion $ubicacion): ?EdificioModel
    {
        foreach ($this->items as $item) {
            if ($item->nombre()->equals($nombre) && $item->ubicacion()->ciudad() === $ubicacion->ciudad()) {
                return $item;
            }
        }
        return null;
    }

    public function getAll(): array
    {
        return array_values($this->items);
    }

    public function delete(EdificioId $edificioId): void
    {
        unset($this->items[$edificioId->value()]);
    }
}

$failures = 0;
$total = 0;

function check(string $name, bool $condition): void
{
    global $failures, $total;
    $total++;
    if ($condition) {
        echo "  [OK]   $name\n";
        return;
    }
    $failures++;
    echo "  [FAIL] $name\n";
}

function expectException(string $name, string $class, callable $fn): void
{
    try {
        $fn();
        check($name . ' (no lanzo excepcion)', false);
    } catch (Throwable $e) {
        check($name . ' -> ' . $e->getMessage(), $e instanceof $class);
    }
}

function createCommand(array $o = array()): CreateEdificioCommand
{
    $d = array_merge(array(
        'id' => 'ed-1', 'nombre' => 'Torre Mirador', 'm2' => 12500.5, 'altura' => 90.0, 'pisos' => 30,
        'apts' => 120, 'ofi' => 10, 'parq' => 'Parqueadero Norte', 'piscinas' => 1,
        'pais' => 'Colombia', 'depto' => 'Bolivar', 'ciudad' => 'Cartagena',
        'ascensor' => true, 'admin' => 450000.0, 'zona' => true,
    ), $o);

    return new CreateEdificioCommand(
        $d['id'], $d['nombre'], $d['m2'], $d['altura'], $d['pisos'], $d['apts'], $d['ofi'], $d['parq'],
        $d['piscinas'], $d['pais'], $d['depto'], $d['ciudad'], $d['ascensor'], $d['admin'], $d['zona']
    );
}

$repo = new InMemoryEdificioRepository();
$create = new CreateEdificioService($repo, $repo);
$update = new UpdateEdificioService($repo, $repo, $repo);
$getById = new GetEdificioByIdService($repo);
$getAll = new GetAllEdificiosService($repo);
$delete = new DeleteEdificioService($repo, $repo);

echo "CREATE\n";
$created = $create->execute(createCommand());
check('crea un edificio', $created->nombre()->value() === 'Torre Mirador');
check('calcula total de unidades', $created->totalUnidades() === 130);
expectException('rechaza nombre duplicado en la misma ciudad', EdificioAlreadyExistsException::class, fn() => $create->execute(createCommand(array('id' => 'ed-2'))));
$create->execute(createCommand(array('id' => 'ed-3', 'ciudad' => 'Barranquilla')));
check('permite mismo nombre en otra ciudad', count($getAll->execute(new GetAllEdificiosQuery())) === 2);

echo "VALIDACIONES\n";
expectException('nombre vacio', InvalidEdificioFieldException::class, fn() => $create->execute(createCommand(array('id' => 'x', 'nombre' => '  '))));
expectException('metros cuadrados <= 0', InvalidEdificioFieldException::class, fn() => $create->execute(createCommand(array('id' => 'x', 'nombre' => 'Otro', 'm2' => 0.0))));
expectException('pisos < 1', InvalidEdificioFieldException::class, fn() => $create->execute(createCommand(array('id' => 'x', 'nombre' => 'Otro', 'pisos' => 0))));
expectException('piscinas negativas', InvalidEdificioFieldException::class, fn() => $create->execute(createCommand(array('id' => 'x', 'nombre' => 'Otro', 'piscinas' => -1))));
expectException('valor administracion negativo', InvalidEdificioFieldException::class, fn() => $create->execute(createCommand(array('id' => 'x', 'nombre' => 'Otro', 'admin' => -5.0))));
expectException('sin apartamentos ni oficinas', InvalidEdificioFieldException::class, fn() => $create->execute(createCommand(array('id' => 'x', 'nombre' => 'Otro', 'apts' => 0, 'ofi' => 0))));
expectException('altura inconsistente con pisos', InvalidEdificioFieldException::class, fn() => $create->execute(createCommand(array('id' => 'x', 'nombre' => 'Otro', 'altura' => 10.0, 'pisos' => 30))));
expectException('ciudad vacia', InvalidEdificioFieldException::class, fn() => $create->execute(createCommand(array('id' => 'x', 'nombre' => 'Otro', 'ciudad' => ''))));

echo "READ\n";
check('consulta por id', $getById->execute(new GetEdificioByIdQuery('ed-1'))->id()->value() === 'ed-1');
expectException('id inexistente', EdificioNotFoundException::class, fn() => $getById->execute(new GetEdificioByIdQuery('nope')));

echo "UPDATE\n";
$updated = $update->execute(new UpdateEdificioCommand(
    'ed-1', 'Torre Mirador II', 13000.0, 95.0, 31, 125, 10, 'Parqueadero Norte', 2,
    'Colombia', 'Bolivar', 'Cartagena', false, 500000.0, false
));
check('actualiza nombre y pisos', $updated->nombre()->value() === 'Torre Mirador II' && $updated->numPisos()->value() === 31);
check('actualiza booleanos', $updated->tieneAscensor() === false && $updated->tieneZonaSocial() === false);
expectException('actualiza inexistente', EdificioNotFoundException::class, fn() => $update->execute(new UpdateEdificioCommand(
    'nope', 'Torre Nueva', 100.0, 30.0, 5, 10, 0, 'Parqueadero', 0, 'Colombia', 'Bolivar', 'Cartagena', true, 0.0, false
)));
expectException('actualiza a nombre duplicado', EdificioAlreadyExistsException::class, fn() => $update->execute(new UpdateEdificioCommand(
    'ed-3', 'Torre Mirador II', 100.0, 30.0, 5, 10, 0, 'Parqueadero', 0, 'Colombia', 'Bolivar', 'Cartagena', true, 0.0, false
)));

echo "DELETE\n";
$delete->execute(new DeleteEdificioCommand('ed-1'));
check('elimina edificio', count($getAll->execute(new GetAllEdificiosQuery())) === 1);
expectException('elimina inexistente', EdificioNotFoundException::class, fn() => $delete->execute(new DeleteEdificioCommand('ed-1')));

echo "\n$total pruebas, $failures fallos\n";
exit($failures === 0 ? 0 : 1);