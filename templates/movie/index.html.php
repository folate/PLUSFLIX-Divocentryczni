<?php

/** @var \App\Model\Movie[] $movies */
/** @var \App\Model\Category[] $categories */
/** @var \App\Service\Router $router */

$title = 'Lista Filmów - Plusflix';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Baza Filmów</h1>

    <div class="search-bar">
        <form action="<?= $router->generatePath('movie-index') ?>" method="get">
            <input type="text" name="search" placeholder="Szukaj po tytule..." value="<?= $_GET['search'] ?? '' ?>">
            
            <select name="category_id">
                <option value="">Wszystkie kategorie</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->getId() ?>" <?= (isset($_GET['category_id']) && $_GET['category_id'] == $category->getId()) ? 'selected' : '' ?>>
                        <?= $category->getName() ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <input type="submit" value="Szukaj">
        </form>
    </div>


	<div class="sort-bar" style="margin: 20px 0;">
        Sortuj według:
        <a href="<?= $router->generatePath('movie-index', array_merge($_GET, ['sort' => 'date_desc'])) ?>">Najnowsze</a> |
        <a href="<?= $router->generatePath('movie-index', array_merge($_GET, ['sort' => 'rating_desc'])) ?>">Najwyżej oceniane</a>
    </div>
    <ul class="index-list">
        <?php if (empty($movies)): ?>
            <li>Nie znaleziono filmów spełniających kryteria.</li>
        <?php else: ?>
            <?php foreach ($movies as $movie): ?>
                <li>
                    <?php if ($movie->getImagePath()): ?>
                        <img src="/uploads/<?= $movie->getImagePath() ?>" alt="<?= $movie->getTitle() ?>" style="max-width: 150px;">
                    <?php endif; ?>
                    
                    <h3><?= $movie->getTitle() ?> (<?= $movie->getYear() ?>)</h3>
                    
                    <ul class="action-list">
                        <li><a href="<?= $router->generatePath('movie-show', ['id' => $movie->getId()]) ?>">Szczegóły</a></li>
                    </ul>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';