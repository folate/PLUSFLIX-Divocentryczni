<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();

$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

$action = $_REQUEST['action'] ?? null;
switch ($action) {
    case 'movie-index':
    case null:
        $controller = new \App\Controller\MovieController();
        $view = $controller->indexAction();
        break;
        
    case 'movie-show':
        $controller = new \App\Controller\MovieController();
        $view = $controller->showAction();
        break;

    case 'favorite-toggle':
        $controller = new \App\Controller\FavoriteController();
        $view = $controller->toggleAction();
        break;

    case 'favorite-index':
        $controller = new \App\Controller\FavoriteController();
        $view = $controller->indexAction();
        break;

    case 'rating-add':
        $controller = new \App\Controller\RatingController();
        $view = $controller->addAction();
        break;

    case 'comment-add':
        $controller = new \App\Controller\CommentController();
        $view = $controller->addAction();
        break;
	
    case 'info':
        $controller = new \App\Controller\InfoController();
        $view = $controller->infoAction();
        break;
    default:
        $view = 'Not found';
        break;
}

if ($view) {
    echo $view;
}
