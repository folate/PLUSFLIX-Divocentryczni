<?php

/** @var \App\Model\Movie $movie */
/** @var \App\Model\Category[] $categories */
/** @var \App\Service\Router $router */

$title = "Edycja Filmu: {$movie->getTitle()}";
$bodyClass = "edit";

ob_start(); ?>
    <h1>Edycja filmu</h1>
    <form action="<?= $router->generatePath('admin-movie-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="admin-movie-edit">
        <input type="hidden" name="id" value="<?= $movie->getId() ?>">
    </form>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('admin-movie-index') ?>">Powrót do listy</a>
        </li>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';