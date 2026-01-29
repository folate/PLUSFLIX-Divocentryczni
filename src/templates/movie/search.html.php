<?php 
$title = 'Wyniki wyszukiwania - Plusflix';
$isDetailsPage = true;
ob_start(); 
function buildSortLink($router, $params, $sortType) {
    unset($params['action']); 
    
    if (isset($params['sort']) && $params['sort'] === $sortType) {
        unset($params['sort']);
    } else {
        $params['sort'] = $sortType;
    }
    
    $baseUrl = $router->generatePath('movie-index');
    $query = http_build_query($params);
    
    if (empty($query)) {
        return $baseUrl;
    }
    
    $separator = (strpos($baseUrl, '?') !== false) ? '&' : '?';
    return $baseUrl . $separator . $query;
}
?>
<div class="search-container">
    <!-- Active Filters Summary -->
    <?php if (!empty($currentParams['category']) || !empty($currentParams['platform']) || !empty($currentParams['q'])): ?>
        <div class="active-filters-summary">
            <span class="summary-label">Aktywne filtry:</span>
            <?php if (!empty($currentParams['q'])): ?>
                <span class="active-chip">Szukasz: "<?= htmlspecialchars($currentParams['q']) ?>" <a href="<?= $router->generatePath('movie-index', array_diff_key($currentParams, ['q' => ''])) ?>" class="remove-filter">&times;</a></span>
            <?php endif; ?>
            <?php 
                if (!empty($currentParams['category'])) {
                    foreach ($categories as $c) {
                        if ($c->getId() == $currentParams['category']) {
                            echo '<span class="active-chip">Kategoria: ' . htmlspecialchars($c->getName()) . ' <a href="' . $router->generatePath('movie-index', array_diff_key($currentParams, ['category' => ''])) . '" class="remove-filter">&times;</a></span>';
                        }
                    }
                }
                if (!empty($currentParams['platform'])) {
                    foreach ($platforms as $p) {
                        if ($p->getId() == $currentParams['platform']) {
                            echo '<span class="active-chip">Platforma: ' . htmlspecialchars($p->getName()) . ' <a href="' . $router->generatePath('movie-index', array_diff_key($currentParams, ['platform' => ''])) . '" class="remove-filter">&times;</a></span>';
                        }
                    }
                }
            ?>
            <a href="<?= $router->generatePath('movie-index') ?>" class="clear-all-btn">Wyczyść wszystko</a>
        </div>
    <?php endif; ?>

    <!-- Filters Section -->
    <div class="search-filters">
        <div class="filters-group">
            <h3>Kategorie</h3>
            <div class="carousel" data-carousel="filters-categories">
                <div class="carousel-controls">
                    <button class="carousel-btn prev" data-target="filters-categories" aria-label="Przewiń w lewo">&#8249;</button>
                    <button class="carousel-btn next" data-target="filters-categories" aria-label="Przewiń w prawo">&#8250;</button>
                </div>
                <div class="search-tags-container">
                    <?php 
                    // Toggle Logic
                    $buildCategoryLink = function($catId) use ($router, $currentParams) {
                        $params = $currentParams;
                        unset($params['action']);
                        
                        if (isset($params['category']) && $params['category'] == $catId) {
                            unset($params['category']); // Toggle off
                        } else {
                            $params['category'] = $catId; // Set new
                        }
                        return $router->generatePath('movie-index', $params);
                    };
                    
                    $activeCat = $currentParams['category'] ?? null;
                    ?>
                    
                    <?php foreach ($categories as $category): ?>
                        <a href="<?= $buildCategoryLink($category->getId()) ?>" 
                           class="filter-tag <?= $activeCat == $category->getId() ? 'active' : '' ?>">
                            <?= htmlspecialchars($category->getName()) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="filters-group">
            <h3>Platformy</h3>
            <div class="carousel" data-carousel="filters-platforms">
                <div class="carousel-controls">
                    <button class="carousel-btn prev" data-target="filters-platforms" aria-label="Przewiń w lewo">&#8249;</button>
                    <button class="carousel-btn next" data-target="filters-platforms" aria-label="Przewiń w prawo">&#8250;</button>
                </div>
                <div class="search-tags-container">
                    <?php 
                    $buildPlatformLink = function($platId) use ($router, $currentParams) {
                        $params = $currentParams;
                        unset($params['action']); 
                        
                        if (isset($params['platform']) && $params['platform'] == $platId) {
                            unset($params['platform']); // Toggle off
                        } else {
                            $params['platform'] = $platId;
                        }
                        return $router->generatePath('movie-index', $params);
                    };

                    $activePlatform = $currentParams['platform'] ?? null; 
                    ?>
                    
                    <?php foreach ($platforms as $platform): ?>
                        <a href="<?= $buildPlatformLink($platform->getId()) ?>" 
                           class="filter-tag <?= $activePlatform == $platform->getId() ? 'active' : '' ?>">
                            <?php if ($platform->getLogoPath()): ?>
                                <img src="<?= htmlspecialchars($platform->getLogoPath()) ?>" class="platform-logo" alt="">
                            <?php endif; ?>
                            <?= htmlspecialchars($platform->getName()) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const carousels = document.querySelectorAll('[data-carousel^="filters"]');

            function updateCarouselState(wrapper) {
                const scroller = wrapper.querySelector('.search-tags-container');
                if (!scroller) return;

                const maxScroll = scroller.scrollWidth - scroller.clientWidth;
                const current = scroller.scrollLeft;
                wrapper.classList.remove('at-start', 'at-end', 'middle');

                if (maxScroll <= 2) {
                    wrapper.classList.add('at-start', 'at-end'); // enough space, hide both
                    return;
                }

                if (current <= 2) {
                    wrapper.classList.add('at-start');
                } else if (current >= maxScroll - 2) {
                    wrapper.classList.add('at-end');
                } else {
                    wrapper.classList.add('middle');
                }
            }

            carousels.forEach(function(wrapper) {
                const scroller = wrapper.querySelector('.search-tags-container');
                if (!scroller) return;

                updateCarouselState(wrapper);
                scroller.addEventListener('scroll', function() {
                    updateCarouselState(wrapper);
                });
                
                // Recalculate on resize
                window.addEventListener('resize', () => {
                    updateCarouselState(wrapper);
                });
            });

            document.querySelectorAll('.carousel-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const target = this.dataset.target;
                    const wrapper = document.querySelector('[data-carousel="' + target + '"]');
                    if (!wrapper) return;
                    const scroller = wrapper.querySelector('.search-tags-container');
                    
                    const direction = this.classList.contains('next') ? 1 : -1;
                    const distance = 200; // Scroll amount for filters
                    scroller.scrollBy({ left: distance * direction, behavior: 'smooth' });
                });
            });
        });
    </script>

    <div class="search-header">
        <div class="stats">
            <span class="found-text">Znaleziono: <strong><?= $count ?></strong> filmów</span>
        </div>
        <div class="controls">
            <div class="avg-rating">
                <span>Średnia ocen:</span> ⭐ <strong><?= $totalAvg ?></strong>
            </div>
            <div class="sort-group">
                <a href="<?= buildSortLink($router, $currentParams, 'best') ?>" class="sort-btn <?= ($currentParams['sort'] ?? '') === 'best' ? 'active' : '' ?>">🏆 Najlepsze</a>
                <a href="<?= buildSortLink($router, $currentParams, 'newest') ?>" class="sort-btn <?= ($currentParams['sort'] ?? '') === 'newest' ? 'active' : '' ?>">🆕 Najnowsze</a>
            </div>
        </div>
    </div>
    
    <div class="search-results">
        <?php if (empty($results)): ?>
            <div class="empty-state" style="text-align:center; padding: 4rem;">
                <h3>Brak wyników</h3>
                <p style="color: grey;">Spróbuj zmienić kryteria wyszukiwania.</p>
                <a href="<?= $router->generatePath('movie-index') ?>" class="button" style="margin-top:1rem; display:inline-block; padding: 0.5rem 1rem; background: #e50914; color: white; border-radius: 5px; text-decoration: none;">Wróć</a>
            </div>
        <?php else: ?>
            <?php foreach ($results as $item): 
                $movie = $item['movie'];
                $platforms = $item['platforms'];
                $rating = $item['avg_rating'];
                $isFav = in_array($movie->getId(), $_SESSION['favorites'] ?? []);
            ?>
                <div class="search-card">
                    <div class="card-poster"> <!-- Changed from <a> to <div>, click handled by stretched-link -->
                        <?php if ($movie->getImagePath()): ?>
                            <img src="<?= htmlspecialchars($movie->getImagePath()) ?>" 
                            alt="<?= htmlspecialchars($movie->getTitle()) ?>" 
                            onerror="this.src='images/bez_plakatu.png';">
                        <?php else: ?>
                            <div class="no-img">Brak</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-content">
                        <div class="card-header">
                            <h2 class="card-title">
                                <a href="<?= $router->generatePath('movie-show', ['id' => $movie->getId()]) ?>" class="stretched-link"><?= htmlspecialchars($movie->getTitle()) ?></a>
                            </h2>
                            <a href="<?= $router->generatePath('favorite-toggle', ['id' => $movie->getId()]) ?>" 
                               class="card-fav-btn <?= $isFav ? 'active' : '' ?>"
                               title="<?= $isFav ? 'Usuń z ulubionych' : 'Dodaj do ulubionych' ?>">
                                <?= $isFav ? '❤️' : '🤍' ?>
                            </a>
                        </div>
                        
                        <div class="card-meta">
                            <span class="meta-item">
                                📅 <?= $movie->getYear() ?>
                            </span>
                            <span style="opacity: 0.3;">|</span>
                            <span class="meta-item">
                                ⏳ <?= $movie->getDuration() ?> min
                            </span>
                        </div>
                        
                         <!-- Description is not explicitly requested in the 'strict' layout but is good to have. 
                              The user's layout description: "Cover left... next to it Top: Title... Under Title: Year, Duration... Rating bottom left... Icons bottom right".
                              I'll omit the description text to strictly follow the "example search result" description provided. 
                              Usually less is more if they gave a specific layout.
                              However, if there is a big empty space between "Year/Duration" and "Rating/Icons" (since card is full height), it might look empty.
                              I will include description but keep it truncated.
                         -->
                        <!-- <div class="card-description">
                            <?= mb_strimwidth(htmlspecialchars($movie->getDescription()), 0, 150, "...") ?>
                        </div> -->
                        
                        <!-- Actually, the user's description seems to define the elements present. "Cover... Title... Year... Duration... Rating... Fav Button... Platform Icons". 
                             It does NOT mention description. Given strict instructions "example search result should look like this", I will REMOVE the description to be safe.
                             The layout will be: Title top, Meta below it. Then whitespace. Then Rating/Icons at bottom.
                        -->
                        
                        <div class="card-footer" style="margin-top: auto;">
                            <div class="card-rating">
                                <span class="stars">⭐</span> <?= number_format($rating, 1) ?>/10
                            </div>
                            
                            <div class="card-platforms">
                                <?php foreach ($platforms as $platform): ?>
                                    <?php if ($platform->getLogoPath()): ?>
                                        <div class="platform-icon" title="<?= htmlspecialchars($platform->getName()) ?>">
                                            <img src="<?= htmlspecialchars($platform->getLogoPath()) ?>" alt="<?= htmlspecialchars($platform->getName()) ?>">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../base.html.php'; ?>