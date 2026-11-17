<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<?php
$esc = static fn(mixed $v): string => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$yesNo = static fn(bool $v): string => $v ? 'Sí' : 'No';

$rows = array(
    'ID' => $edificio->getId(),
    'Nombre' => $edificio->getNombre(),
    'Metros cuadrados' => number_format($edificio->getMetrosCuadrados(), 2, ',', '.') . ' m²',
    'Altura' => number_format($edificio->getAltura(), 2, ',', '.') . ' m',
    'Número de pisos' => $edificio->getNumPisos(),
    'Número de apartamentos' => $edificio->getNumApartamentos(),
    'Número de oficinas' => $edificio->getNumOficinas(),
    'Nombre del parqueadero' => $edificio->getNombreParqueadero(),
    'Número de piscinas' => $edificio->getNumPiscinas(),
    'País' => $edificio->getPais(),
    'Departamento' => $edificio->getDepartamento(),
    'Ciudad' => $edificio->getCiudad(),
    'Tiene ascensor' => $yesNo($edificio->getTieneAscensor()),
    'Valor de administración' => '$ ' . number_format($edificio->getValorAdministracion(), 2, ',', '.'),
    'Tiene zona social' => $yesNo($edificio->getTieneZonaSocial()),
);
?>

<h1>Detalle de edificio</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= $esc($message) ?></div>
<?php endif; ?>

<table class="detail-table">
    <?php foreach ($rows as $label => $value): ?>
        <tr>
            <th><?= $esc($label) ?></th>
            <td><?= $esc($value) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p style="margin-top: 16px;">
    <a class="btn btn-warning" href="?route=edificios.edit&amp;id=<?= urlencode($edificio->getId()) ?>">Editar</a>
    &nbsp;
    <a class="btn" href="?route=edificios.index">Volver al listado</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>