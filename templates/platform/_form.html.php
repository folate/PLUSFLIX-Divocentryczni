<?php
    /** @var $platform ?\App\Model\Platform */
?>

<div class="form-group">
    <label for="name">Nazwa platformy</label>
    <input type="text" id="name" name="platform[name]" value="<?= $platform ? $platform->getName() : '' ?>" required>
</div>

<div class="form-group">
    <label for="url">Adres strony głównej (URL)</label>
    <input type="text" id="url" name="platform[url]" value="<?= $platform ? $platform->getUrl() : '' ?>">
</div>

<div class="form-group">
    <label for="logo_path">Nazwa pliku logo (np. netflix.png)</label>
    <input type="text" id="logo_path" name="platform[logo_path]" value="<?= $platform ? $platform->getLogoPath() : '' ?>">
</div>

<div class="form-group">
    <input type="submit" value="Zapisz">
</div>