<?php
/** @var \App\Model\Platform $platform */
/** @var \App\Service\Router $router */
$title = 'Edytuj Platformę';
$bodyClass = 'edit';

ob_start(); ?>
    <h1>Edycja platformy</h1>
    <form action="<?= $router->generatePath('admin-platform-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="id" value="<?= $platform->getId() ?>">
    </form>
    <a href="<?= $router->generatePath('admin-platform-index') ?>">Powrót do listy</a>
<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';