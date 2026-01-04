<?php

/** @var \App\Model\Movie $movie */
/** @var \App\Model\Category[] $categories */
/** @var \App\Service\Router $router */

$title = 'Dodaj Film';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Dodaj nowy film</h1>
    <form action="<?= $router->generatePath('admin-movie-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="admin-movie-create">
    </form>

    <a href="<?= $router->generatePath('admin-movie-index') ?>">Powrót do listy</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';