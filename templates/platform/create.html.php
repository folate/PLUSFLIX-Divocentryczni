<?php
$title = 'Dodaj Platformę';
ob_start(); ?>
    <div class="edit">
        <h1>Dodaj nową platformę</h1>
        <a href="<?= $router->generatePath('admin-platform-index') ?>" class="back-link">&larr; Powrót do listy</a>

        <form action="<?= $router->generatePath('admin-platform-create') ?>" method="post" enctype="multipart/form-data" class="edit-form">
            <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
            <input type="hidden" name="action" value="admin-platform-create">
        </form>
    </div>
<?php $content = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';