<?php

/** @var \App\Model\Platform[] $platforms */
/** @var \App\Service\Router $router */

$title = 'Zarządzanie Platformami';
$bodyClass = 'admin';

ob_start(); ?>
    <h1>Platformy Streamingowe</h1>

    <div class="admin-controls">
        <a href="<?= $router->generatePath('admin-platform-create') ?>" class="button">Dodaj platformę</a>
        <a href="<?= $router->generatePath('admin-dashboard') ?>">Wróć do Panelu</a>
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Nazwa</th>
                <th>URL</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($platforms as $platform): ?>
                <tr>
                    <td>
                        <?php if($platform->getLogoPath()): ?>
                            <img src="/uploads/<?= $platform->getLogoPath() ?>" alt="Logo" style="height: 30px;">
                        <?php endif; ?>
                    </td>
                    <td><?= $platform->getName() ?></td>
                    <td><?= $platform->getUrl() ?></td>
                    <td>
                        <a href="<?= $router->generatePath('admin-platform-edit', ['id' => $platform->getId()]) ?>">Edytuj</a> |
                        <form action="<?= $router->generatePath('admin-platform-delete') ?>" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $platform->getId() ?>">
                            <input type="submit" value="Usuń" onclick="return confirm('Usunąć platformę?');">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';