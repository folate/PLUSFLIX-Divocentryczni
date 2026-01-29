<?php
namespace App\Controller;
use App\Model\Category;
use App\Service\Router;
use App\Service\Templating;
class CategoryController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $categories = Category::findAll();
        $movies = \App\Model\Movie::findAll();
        $platforms = \App\Model\Platform::findAll();
        $comments = \App\Model\Comment::findAll();

        $html = $templating->render('category/index.html.php', [
            'categories' => $categories,
            'router' => $router,
            'moviesCount' => count($movies),
            'categoriesCount' => count($categories),
            'platformsCount' => count($platforms),
            'commentsCount' => count($comments)
        ]);
        return $html;
    }
    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $data = $requestPost['category'] ?? [];
            $category = new Category();
            $category->setName($data['name'] ?? '');
            $category->save();
            $router->redirect($router->generatePath('admin-category-index'));
            return null;
        }
        $html = $templating->render('category/create.html.php', [
            'router' => $router,
        ]);
        return $html;
    }
    public function deleteAction(Router $router): ?string
    {
        $id = $_POST['id'] ?? null;
        $category = Category::find($id);
        if ($category) {
            $category->delete();
        }
        $router->redirect($router->generatePath('admin-category-index'));
        return null;
    }
}