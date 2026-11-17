<?php
/**
 * Campos compartidos por create.php y edit.php.
 *
 * @var array<string, mixed>  $values  Valores actuales del formulario
 * @var array<string, string> $errors  Errores de validacion por campo
 */
$esc = static fn(mixed $v): string => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

$textFields = array(
    array('nombre', 'Nombre', 'text'),
    array('nombreParqueadero', 'Nombre del parqueadero', 'text'),
    array('pais', 'País', 'text'),
    array('departamento', 'Departamento', 'text'),
    array('ciudad', 'Ciudad', 'text'),
);
$numberFields = array(
    array('metrosCuadrados', 'Metros cuadrados', '0.01', '0.01'),
    array('altura', 'Altura (metros)', '0.01', '0.01'),
    array('numPisos', 'Número de pisos', '1', '1'),
    array('numApartamentos', 'Número de apartamentos', '1', '0'),
    array('numOficinas', 'Número de oficinas', '1', '0'),
    array('numPiscinas', 'Número de piscinas', '1', '0'),
    array('valorAdministracion', 'Valor de administración', '0.01', '0'),
);
?>

<?php foreach ($textFields as [$name, $label, $type]): ?>
    <div class="form-group">
        <label for="<?= $esc($name) ?>"><?= $esc($label) ?></label><br>
        <input type="<?= $esc($type) ?>" id="<?= $esc($name) ?>" name="<?= $esc($name) ?>"
            value="<?= $esc($values[$name] ?? '') ?>">
        <?php if (!empty($errors[$name])): ?>
            <div class="field-error"><?= $esc($errors[$name]) ?></div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php foreach ($numberFields as [$name, $label, $step, $min]): ?>
    <div class="form-group">
        <label for="<?= $esc($name) ?>"><?= $esc($label) ?></label><br>
        <input type="number" id="<?= $esc($name) ?>" name="<?= $esc($name) ?>"
            step="<?= $esc($step) ?>" min="<?= $esc($min) ?>"
            value="<?= $esc($values[$name] ?? '') ?>">
        <?php if (!empty($errors[$name])): ?>
            <div class="field-error"><?= $esc($errors[$name]) ?></div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<div class="form-group">
    <label>
        <input type="checkbox" name="tieneAscensor" value="1" <?= !empty($values['tieneAscensor']) ? 'checked' : '' ?>>
        Tiene ascensor
    </label>
</div>

<div class="form-group">
    <label>
        <input type="checkbox" name="tieneZonaSocial" value="1" <?= !empty($values['tieneZonaSocial']) ? 'checked' : '' ?>>
        Tiene zona social
    </label>
</div>