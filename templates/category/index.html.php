<?php

/** @var \App\Model\Category[] $categories */
/** @var \App\Service\Router $router */

$title = 'Zarządzanie Kategoriami';
$bodyClass = 'admin';

ob_start(); ?>
    <h1>Kategorie Filmowe</h1>

    <div class="admin-controls">
        <a href="<?= $router->generatePath('admin-category-create') ?>" class="button">Dodaj nową kategorię</a>
        <a href="<?= $router->generatePath('admin-dashboard') ?>">Wróć do Panelu</a>
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa Kategorii</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category->getId() ?></td>
                    <td><?= $category->getName() ?></td>
                    <td>
                        <form action="<?= $router->generatePath('admin-category-delete') ?>" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $category->getId() ?>">
                            <input type="submit" value="Usuń" onclick="return confirm('Czy na pewno usunąć kategorię? Upewnij się, że nie ma przypisanych filmów.');">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';