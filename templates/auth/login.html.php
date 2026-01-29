<?php
$title = 'Logowanie Administratora';
ob_start(); ?>
    <div class="auth-container">
        <div class="auth-box">
            <h1>Panel Administratora</h1>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="<?= $router->generatePath('admin-login') ?>" method="post">
                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" id="login" name="login" placeholder="Wpisz login" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="password" placeholder="Wpisz hasło" required>
                </div>
                
                <button type="submit" class="btn-submit">Zaloguj się</button>
            </form>

            <div class="auth-footer">
                <a href="<?= $router->generatePath('movie-index') ?>">&larr; Powrót do strony głównej</a>
            </div>
        </div>
    </div>
<?php $content = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';