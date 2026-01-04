<?php
    /** @var $movie ?\App\Model\Movie */
    /** @var \App\Model\Category[] $categories */
?>

<div class="form-group">
    <label for="title">Tytuł</label>
    <input type="text" id="title" name="movie[title]" value="<?= $movie ? $movie->getTitle() : '' ?>" required>
</div>

<div class="form-group">
    <label for="year">Rok produkcji</label>
    <input type="number" id="year" name="movie[year]" value="<?= $movie ? $movie->getYear() : '' ?>" required>
</div>

<div class="form-group">
    <label for="duration">Czas trwania (minuty)</label>
    <input type="number" id="duration" name="movie[duration]" value="<?= $movie ? $movie->getDuration() : '' ?>" required>
</div>

<div class="form-group">
    <label for="category">Kategoria</label>
    <select id="category" name="movie[cat_id]">
        <option value="">-- Wybierz kategorię --</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category->getId() ?>" <?= ($movie && $movie->getCatId() == $category->getId()) ? 'selected' : '' ?>>
                <?= $category->getName() ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="description">Opis</label>
    <textarea id="description" name="movie[description]" rows="5"><?= $movie ? $movie->getDescription() : '' ?></textarea>
</div>

<div class="form-group">
    <label for="image_path">Nazwa pliku obrazka (np. poster.jpg)</label>
    <input type="text" id="image_path" name="movie[image_path]" value="<?= $movie ? $movie->getImagePath() : '' ?>">
</div>

<div class="form-group">
    <input type="submit" value="Zapisz">
</div>