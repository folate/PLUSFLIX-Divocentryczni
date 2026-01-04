<?php

/** @var \App\Model\Movie $movie */
/** @var \App\Model\Comment[] $comments */
/** @var array $platformsData (tablica asocjacyjna platform i linków) */
/** @var \App\Service\Router $router */

$title = "{$movie->getTitle()} ({$movie->getYear()})";
$bodyClass = 'show';

ob_start(); ?>
    
    <div class="movie-header">
        <h1><?= $movie->getTitle() ?></h1>
        <?php if ($movie->getImagePath()): ?>
            <img src="/uploads/<?= $movie->getImagePath() ?>" alt="Plakat <?= $movie->getTitle() ?>">
        <?php endif; ?>
    </div>

    <article>
        <p><strong>Rok produkcji:</strong> <?= $movie->getYear() ?></p>
        <p><strong>Czas trwania:</strong> <?= $movie->getDuration() ?> min</p>
        <p><strong>Opis:</strong> <?= $movie->getDescription() ?></p>
    </article>

    <div class="platforms">
        <h3>Gdzie obejrzeć?</h3>
        <ul>
            <?php if (!empty($platformsData)): ?>
                <?php foreach ($platformsData as $platform): ?>
                    <li>
                        <a href="<?= $platform['url'] ?>" target="_blank">
                            <?= $platform['name'] ?> (<?= $platform['details'] ?>)
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Brak informacji o dostępności.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="actions">
        <a href="<?= $router->generatePath('favorite-toggle', ['id' => $movie->getId()]) ?>" class="btn">
            Dodaj/Usuń z Ulubionych
        </a>
    </div>

    <div class="rating-section">
        <h3>Oceń film</h3>
        <form action="<?= $router->generatePath('rating-add') ?>" method="post">
            <input type="hidden" name="movie_id" value="<?= $movie->getId() ?>">
            <select name="rating">
                <?php for($i=1; $i<=10; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <input type="submit" value="Zagłosuj">
        </form>
    </div>

    <div class="comments-section">
        <h3>Komentarze</h3>
        
        <form action="<?= $router->generatePath('comment-add') ?>" method="post">
            <input type="hidden" name="movie_id" value="<?= $movie->getId() ?>">
            <label>Nick: <input type="text" name="nick" required></label><br>
            <label>Treść: <textarea name="content" required></textarea></label><br>
            <input type="submit" value="Dodaj komentarz">
        </form>

        <ul class="comments-list">
            <?php foreach ($comments as $comment): ?>
                <li>
                    <strong><?= $comment->getNick() ?></strong> (<?= $comment->getCreatedAt() ?>):
                    <p><?= $comment->getContent() ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <a href="<?= $router->generatePath('movie-index') ?>">Powrót do listy</a>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';