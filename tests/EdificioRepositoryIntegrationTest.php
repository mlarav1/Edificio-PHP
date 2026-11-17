<?php

declare(strict_types=1);

/**
 * Prueba de integracion del adaptador MySQL (requiere BD con el esquema cargado):
 *   php tests/EdificioRepositoryIntegrationTest.php
 * Lee la conexion de las variables DB_* (o del archivo .env).
 */

require_once __DIR__ . '/../Common/DependencyInjection.php';

DependencyInjection::boot();

$repository = DependencyInjection::getEdificioRepository();
$id = 'it-' . bin2hex(random_bytes(6));

$failures = 0;
$check = static function (string $name, bool $ok) use (&$failures): void {
    echo ($ok ? '  [OK]   ' : '  [FAIL] ') . $name . "\n";
    if (!$ok) {
        $failures++;
    }
};

$build = static fn(string $nombre, int $pisos): EdificioModel => new EdificioModel(
    new EdificioId($id),
    new EdificioNombre($nombre),
    new EdificioMetrosCuadrados(5400.75),
    new EdificioAltura(60.0),
    new EdificioNumPisos($pisos),
    new EdificioNumApartamentos(48),
    new EdificioNumOficinas(4),
    new EdificioNombreParqueadero('Sotano 1'),
    new EdificioNumPiscinas(1),
    new EdificioUbicacion('Colombia', 'Bolivar', 'Cartagena'),
    true,
    new EdificioValorAdministracion(380000.5),
    true
);

try {
    echo "REPOSITORIO MYSQL\n";

    $saved = $repository->save($build('Edificio Integracion', 15));
    $check('save + getById', $saved->nombre()->value() === 'Edificio Integracion');
    $check('decimales se conservan', $saved->metrosCuadrados()->value() === 5400.75 && $saved->valorAdministracion()->value() === 380000.5);
    $check('booleanos se conservan', $saved->tieneAscensor() === true && $saved->tieneZonaSocial() === true);

    $byName = $repository->getByNombreAndCiudad(new EdificioNombre('edificio integracion'), new EdificioUbicacion('Colombia', 'Bolivar', 'Cartagena'));
    $check('getByNombreAndCiudad (sin distinguir mayusculas)', $byName !== null && $byName->id()->value() === $id);

    $updated = $repository->update($build('Edificio Integracion Editado', 20));
    $check('update', $updated->nombre()->value() === 'Edificio Integracion Editado' && $updated->numPisos()->value() === 20);

    $check('getAll incluye el edificio', count(array_filter($repository->getAll(), static fn(EdificioModel $e): bool => $e->id()->value() === $id)) === 1);
} finally {
    $repository->delete(new EdificioId($id));
}

$check('delete', $repository->getById(new EdificioId($id)) === null);

echo $failures === 0 ? "\nTodas las pruebas pasaron\n" : "\n$failures fallos\n";
exit($failures === 0 ? 0 : 1);