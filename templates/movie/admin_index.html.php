<?php

/** @var \App\Model\Movie[] $movies */
/** @var \App\Service\Router $router */

$title = 'Panel Administratora - Filmy';
$bodyClass = 'admin';

ob_start(); ?>
    <h1>Zarządzanie Filmami</h1>

    <div class="admin-controls">
        <a href="<?= $router->generatePath('admin-movie-create') ?>" class="button">Dodaj nowy film</a>
        <a href="<?= $router->generatePath('admin-dashboard') ?>">Wróć do Panelu</a>
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Rok</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?= $movie->getId() ?></td>
                    <td><?= $movie->getTitle() ?></td>
                    <td><?= $movie->getYear() ?></td>
                    <td>
                        <a href="<?= $router->generatePath('admin-movie-edit', ['id' => $movie->getId()]) ?>">Edytuj</a> |
                        <form action="<?= $router->generatePath('admin-movie-delete') ?>" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $movie->getId() ?>">
                            <input type="submit" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć ten film?');">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';