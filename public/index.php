<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';
session_start();
$config = new \App\Service\Config();
$templating = new \App\Service\Templating();
$router = new \App\Service\Router();
$action = $_REQUEST['action'] ?? null;
// Authentication Check for Admin Routes
if ($action && strpos($action, 'admin-') === 0 && $action !== 'admin-login' && $action !== 'admin-logout') {
    if (empty($_SESSION['admin_logged'])) {
        $controller = new \App\Controller\AuthController();
        // Redirect to login or render login view directly
        // Better to let index handle the route change or call login action
        // Setting action to admin-login to fall through switch
        $action = 'admin-login'; 
        // Note: admin-login action in switch will handle rendering login page
    }
}

switch ($action) {
    case 'movie-index':
    case null:
        $controller = new \App\Controller\MovieController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'movie-show':
        $controller = new \App\Controller\MovieController();
        $view = $controller->showAction($templating, $router);
        break;
    case 'favorite-toggle':
        $controller = new \App\Controller\FavoriteController();
        $view = $controller->toggleAction($router);
        break;
    case 'favorite-index':
        $controller = new \App\Controller\FavoriteController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'rating-add':
        $controller = new \App\Controller\RatingController();
        $view = $controller->addAction($_POST, $router);
        break;
    case 'comment-add':
        $controller = new \App\Controller\CommentController();
        $view = $controller->addAction($_POST, $router);
        break;
    case 'admin-login':
        $controller = new \App\Controller\AuthController();
        $view = $controller->loginAction($templating, $router);
        break;
    case 'admin-logout':
        $controller = new \App\Controller\AuthController();
        $view = $controller->logoutAction($router);
        break;
    case 'admin-dashboard':
        $controller = new \App\Controller\AdminController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'admin-movie-index':
        $controller = new \App\Controller\MovieController();
        $view = $controller->adminIndexAction($templating, $router);
        break;
    case 'admin-movie-create':
        $controller = new \App\Controller\MovieController();
        $view = $controller->createAction($_POST, $templating, $router);
        break;
    case 'admin-movie-edit':
        $controller = new \App\Controller\MovieController();
        $view = $controller->editAction($templating, $router);
        break;
    case 'admin-movie-delete':
        $controller = new \App\Controller\MovieController();
        $view = $controller->deleteAction($router);
        break;
    case 'admin-platform-index':
        $controller = new \App\Controller\PlatformController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'admin-platform-create':
        $controller = new \App\Controller\PlatformController();
        $view = $controller->createAction($_POST, $templating, $router);
        break;
    case 'admin-platform-edit':
        $controller = new \App\Controller\PlatformController();
        $view = $controller->editAction($templating, $router);
        break;
    case 'admin-platform-delete':
        $controller = new \App\Controller\PlatformController();
        $view = $controller->deleteAction($router);
        break;
    case 'admin-category-index':
        $controller = new \App\Controller\CategoryController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'admin-category-create':
        $controller = new \App\Controller\CategoryController();
        $view = $controller->createAction($_POST, $templating, $router);
        break;
    case 'admin-category-delete':
        $controller = new \App\Controller\CategoryController();
        $view = $controller->deleteAction($router);
        break;
    case 'admin-comment-delete':
        $controller = new \App\Controller\CommentController();
        $view = $controller->deleteAction($router);
        break;
    case 'admin-rating-delete':
        $controller = new \App\Controller\RatingController();
        $view = $controller->deleteAction($router);
        break;
    case 'info':
        $controller = new \App\Controller\InfoController();
        $view = $controller->infoAction();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        $view = $templating->render('404.html.php', ['router' => $router]);
        break;
}
if ($view) {
    echo $view;
}