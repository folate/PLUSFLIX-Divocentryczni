<?php
/** @var \App\Model\Movie[] $favoriteMovies */
/** @var \App\Service\Router $router */

$title = 'Moje Ulubione Filmy';
$bodyClass = 'favorites';

ob_start(); ?>
    <h1>Twoje ulubione filmy</h1>
    
    <?php if (empty($favoriteMovies)): ?>
        <p>Nie masz jeszcze żadnych ulubionych filmów. <a href="<?= $router->generatePath('movie-index') ?>">Przeglądaj bazę</a>.</p>
    <?php else: ?>
        <ul class="index-list">
            <?php foreach ($favoriteMovies as $movie): ?>
                <li>
                    <h3><?= $movie->getTitle() ?></h3>
                    <div class="actions">
                        <a href="<?= $router->generatePath('movie-show', ['id' => $movie->getId()]) ?>">Zobacz szczegóły</a>
                        
                        <a href="<?= $router->generatePath('favorite-toggle', ['id' => $movie->getId()]) ?>" style="color: red; margin-left: 10px;">
                            Usuń z listy
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="<?= $router->generatePath('movie-index') ?>">Powrót do listy filmów</a></p>

<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';