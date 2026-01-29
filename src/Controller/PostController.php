<?php
namespace App\Controller;
use App\Exception\NotFoundException;
use App\Model\Post; 
use App\Service\Router;
use App\Service\Templating;
class PostController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $posts = []; 
        $html = $templating->render('post/index.html.php', [
            'posts' => $posts,
            'router' => $router,
        ]);
        return $html;
    }
    public function showAction(int $postId, Templating $templating, Router $router): ?string
    {
        return "Widok posta $postId";
    }
}