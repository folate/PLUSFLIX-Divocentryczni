<?php

/** @var \App\Service\Router $router */

$title = 'Dodaj Kategorię';
$bodyClass = 'edit';

ob_start(); ?>
    <h1>Dodaj nową kategorię</h1>
    
    <form action="<?= $router->generatePath('admin-category-create') ?>" method="post" class="edit-form">
        <div class="form-group">
            <label for="name">Nazwa kategorii</label>
            <input type="text" id="name" name="category[name]" required>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Zapisz">
        </div>
    </form>

    <a href="<?= $router->generatePath('admin-category-index') ?>">Powrót do listy</a>

<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';