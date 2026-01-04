<?php
/** @var array $stats (np. ['movies_count' => 10, 'avg_rating' => 7.5]) */
/** @var \App\Model\Comment[] $latestComments */
/** @var \App\Service\Router $router */

$title = 'Dashboard Administratora';
$bodyClass = 'admin';

ob_start(); ?>
    <h1>Pulpit Administratora</h1>
    
    <div class="admin-menu" style="margin-bottom: 30px; padding: 20px; background: #eee;">
        <h3>Szybkie akcje:</h3>
        <ul class="action-list">
            <li><a href="<?= $router->generatePath('admin-movie-index') ?>">Zarządzaj Filmami</a></li>
            <li><a href="<?= $router->generatePath('admin-category-index') ?>">Zarządzaj Kategoriami</a></li>
            <li><a href="<?= $router->generatePath('admin-platform-index') ?>">Zarządzaj Platformami</a></li>
            <li><a href="<?= $router->generatePath('admin-logout') ?>" style="color: red;">Wyloguj</a></li>
        </ul>
    </div>

    <div class="stats-grid" style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div class="stat-box" style="border: 1px solid #ccc; padding: 15px; flex: 1;">
            <h4>Liczba filmów</h4>
            <p style="font-size: 2em;"><?= $stats['movies_count'] ?? 0 ?></p>
        </div>
        <div class="stat-box" style="border: 1px solid #ccc; padding: 15px; flex: 1;">
            <h4>Liczba kategorii</h4>
            <p style="font-size: 2em;"><?= $stats['categories_count'] ?? 0 ?></p>
        </div>
        <div class="stat-box" style="border: 1px solid #ccc; padding: 15px; flex: 1;">
            <h4>Średnia ocen</h4>
            <p style="font-size: 2em;"><?= number_format($stats['avg_rating'] ?? 0, 2) ?></p>
        </div>
    </div>

    <div class="moderation-section">
        <h3>Ostatnie komentarze (Moderacja)</h3>
        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Nick</th>
                    <th>Film (ID)</th>
                    <th>Treść</th>
                    <th>Akcja</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($latestComments)): ?>
                    <?php foreach ($latestComments as $comment): ?>
                    <tr>
                        <td><?= $comment->getCreatedAt() ?></td>
                        <td><?= $comment->getNick() ?></td>
                        <td><?= $comment->getMovieId() ?></td>
                        <td><?= htmlspecialchars($comment->getContent()) ?></td>
                        <td>
                            <form action="<?= $router->generatePath('admin-comment-delete') ?>" method="post">
                                <input type="hidden" name="id" value="<?= $comment->getId() ?>">
                                <input type="submit" value="Usuń (Spam)" style="background: red; color: white; border: none; padding: 5px;">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">Brak nowych komentarzy.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';