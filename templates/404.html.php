<?php $title = '404 - Strona nie znaleziona'; ?>
<?php ob_start(); ?>
<style>
    .error-container {
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        min-height: 60vh; 
        text-align: center; 
        padding: 20px;
    }
    .error-code {
        font-size: 8rem; 
        margin: 0; 
        font-weight: bold;
        background: linear-gradient(45deg, #e50914, #b20710);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }
    .error-title {
        font-size: 2rem; 
        margin: 20px 0;
        font-weight: 500;
    }
    .error-message {
        font-size: 1.2rem; 
        margin-bottom: 40px; 
        color: #999;
        max-width: 600px;
    }
    .error-btn {
        background-color: #e50914;
        color: white;
        padding: 12px 30px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 1.1rem;
        transition: background-color 0.3s;
        border: none;
        cursor: pointer;
    }
    .error-btn:hover {
        background-color: #b20710;
        color: white;
    }
</style>

<div class="container error-container">
    <h1 class="error-code">404</h1>
    <h2 class="error-title">Ups! Coś poszło nie tak.</h2>
    <p class="error-message">
        Strona, której szukasz, nie istnieje. Mogła zostać usunięta, zmieniono jej nazwę lub jest tymczasowo niedostępna.
    </p>
    <a href="<?= $router->generatePath('movie-index') ?>" class="error-btn">
        Powrót na stronę główną
    </a>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/base.html.php'; ?>
