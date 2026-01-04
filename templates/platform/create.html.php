<?php
/** @var \App\Service\Router $router */
$title = 'Dodaj Platformę';
$bodyClass = 'edit';

ob_start(); ?>
    <h1>Dodaj nową platformę</h1>
    <form action="<?= $router->generatePath('admin-platform-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
    </form>
    <a href="<?= $router->generatePath('admin-platform-index') ?>">Powrót do listy</a>
<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';