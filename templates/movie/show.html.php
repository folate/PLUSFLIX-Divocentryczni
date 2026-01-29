<?php 
$title = $movie->getTitle();
$isDetailsPage = true;
ob_start(); ?>

<div class="movie-show-container">
    <!-- Top Section: Poster + Info -->
    <div class="movie-hero">
        <div class="hero-poster">
            <?php if ($movie->getImagePath()): ?>
                <img src="<?= htmlspecialchars($movie->getImagePath()) ?>" 
                     alt="<?= htmlspecialchars($movie->getTitle()) ?>" 
                     onerror="this.src='images/bez_plakatu.png';">
            <?php else: ?>
                <div class="no-poster">Brak</div>
            <?php endif; ?>
        </div>
        
    <div class="hero-info">
            <a href="<?= $router->generatePath('favorite-toggle', ['id' => $movie->getId()]) ?>" 
               class="favorite-btn" 
               title="<?= $isFavorite ? 'Usuń z ulubionych' : 'Dodaj do ulubionych' ?>">
               <?= $isFavorite ? '❤️' : '🤍' ?>
            </a>

            <div class="hero-header">
                <h1 class="movie-title"><?= htmlspecialchars($movie->getTitle()) ?></h1>
            </div>
            
            <div class="hero-description">
                <?= nl2br(htmlspecialchars($movie->getDescription())) ?>
            </div>
            
            <div class="hero-meta">
                <div class="meta-duration" title="Czas trwania">
                    🕒 <strong><?= $movie->getDuration() ?> min</strong>
                </div>
                <div class="meta-year" title="Rok produkcji">
                    📅 <strong><?= $movie->getYear() ?></strong>
                </div>
                <div class="meta-rating" title="Średnia ocena">
                    ⭐ <strong><?= number_format($avgRating, 1) ?> / 10</strong>
                </div>
            </div>

            <div class="hero-actions-bottom">
                 <button onclick="openModal()" class="btn-add-review">Dodaj recenzję</button>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Split Content -->
    <div class="content-split">
        <!-- Left Column: Platforms (1/4) -->
        <div class="platforms-section">
            <h3>Gdzie obejrzeć?</h3>
            <div class="platform-list">
                <?php foreach ($platforms as $platform): ?>
                    <a href="<?= htmlspecialchars($platform->getUrl()) ?>" target="_blank" class="platform-item">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <?php if ($platform->getLogoPath()): ?>
                                <img src="<?= htmlspecialchars($platform->getLogoPath()) ?>" alt="Logo">
                            <?php endif; ?>
                            <span><?= htmlspecialchars($platform->getName()) ?></span>
                        </div>
                        <?php if ($platform->getDetails()): ?>
                            <span class="platform-details"><?= htmlspecialchars($platform->getDetails()) ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
                <?php if (empty($platforms)): ?>
                    <p style="color: #777; font-style: italic;">Brak informacji o dostępności.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Reviews (3/4) -->
        <div class="reviews-section">
            <h3>Opinie użytkowników</h3>
            <div class="reviews-list">
                <?php if (empty($comments)): ?>
                    <p style="color: #777; font-style: italic; text-align:center; padding: 20px;">
                        Jeszcze nikt nie ocenił tego filmu. Bądź pierwszy!
                    </p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <?php $rating = $comment->getUserRating(); ?>
                        <div class="review-item">
                            <div class="review-header">
                                <span class="nick"><?= htmlspecialchars($comment->getNick()) ?></span>
                                <span class="date"><?= date('d.m.Y', strtotime($comment->getCreatedAt() ?? 'now')) ?></span>
                            </div>
                            <div class="review-content">
                                "<?= htmlspecialchars($comment->getContent()) ?>"
                            </div>
                            <div class="review-rating">
                                <?php 
                                for ($i = 0; $i < $rating; $i++) echo '★';
                                for ($i = $rating; $i < 10; $i++) echo '<span class="empty-star">★</span>';
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding review -->
<div id="commentModal" class="modal-overlay">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h3>Twoja opinia</h3>
        <form action="<?= $router->generatePath('comment-add') ?>" method="post">
            <input type="hidden" name="movie_id" value="<?= $movie->getId() ?>">
            
            <div class="form-group">
                <label>Twój nick</label>
                <input type="text" name="nick" placeholder="Podpisz się..." required>
            </div>
            
            <div class="form-group">
                <label>Ocena</label>
                <div class="star-rating-input">
                    <input type="radio" name="rating" id="star10" value="10"><label for="star10" title="Arcydzieło">★</label>
                    <input type="radio" name="rating" id="star9" value="9"><label for="star9" title="Rewelacyjny">★</label>
                    <input type="radio" name="rating" id="star8" value="8"><label for="star8" title="Bardzo dobry">★</label>
                    <input type="radio" name="rating" id="star7" value="7"><label for="star7" title="Dobry">★</label>
                    <input type="radio" name="rating" id="star6" value="6"><label for="star6" title="Niezły">★</label>
                    <input type="radio" name="rating" id="star5" value="5"><label for="star5" title="Średni">★</label>
                    <input type="radio" name="rating" id="star4" value="4"><label for="star4" title="Ujdzie">★</label>
                    <input type="radio" name="rating" id="star3" value="3"><label for="star3" title="Słaby">★</label>
                    <input type="radio" name="rating" id="star2" value="2"><label for="star2" title="Bardzo słaby">★</label>
                    <input type="radio" name="rating" id="star1" value="1" required><label for="star1" title="Nieporozumienie">★</label>
                </div>
            </div>
            
            <div class="form-group">
                <label>Komentarz</label>
                <textarea name="content" rows="4" placeholder="Napisz kilka słów o filmie..." required></textarea>
            </div>
            
            <a href="/assets/Regulamin_Oceniania.pdf" target="_blank" class="rules-link">
                Regulamin Oceniania
            </a>
            
            <button type="submit" class="btn-submit-review">Dodaj opinię</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('commentModal').style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
    
    function closeModal() {
        document.getElementById('commentModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    window.onclick = function(event) {
        if (event.target == document.getElementById('commentModal')) {
            closeModal();
        }
    }
    
    // Key press to close
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeModal();
        }
    });
</script>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../base.html.php'; ?>