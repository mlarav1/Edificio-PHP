<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Lista de edificios</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert-success">
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (empty($edificios)): ?>
    <p>No hay edificios registrados todavía.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>Pisos</th>
                <th>Unidades</th>
                <th>m²</th>
                <th>Ascensor</th>
                <th>Administración</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($edificios as $edificio): ?>
                <tr>
                    <td><?= htmlspecialchars($edificio->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($edificio->getCiudad(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= $edificio->getNumPisos() ?></td>
                    <td><?= $edificio->getTotalUnidades() ?></td>
                    <td><?= number_format($edificio->getMetrosCuadrados(), 2, ',', '.') ?></td>
                    <td><?= $edificio->getTieneAscensor() ? 'Sí' : 'No' ?></td>
                    <td>$ <?= number_format($edificio->getValorAdministracion(), 2, ',', '.') ?></td>
                    <td class="col-actions">
                        <a class="btn btn-sm" href="?route=edificios.show&amp;id=<?= urlencode($edificio->getId()) ?>">Ver</a>
                        <a class="btn btn-warning btn-sm"
                            href="?route=edificios.edit&amp;id=<?= urlencode($edificio->getId()) ?>">Editar</a>
                        <form method="POST" action="?route=edificios.delete" style="display:inline;"
                            onsubmit="return confirmDelete(this);"
                            data-entity="el edificio"
                            data-name="<?= htmlspecialchars($edificio->getNombre(), ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($edificio->getId(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>