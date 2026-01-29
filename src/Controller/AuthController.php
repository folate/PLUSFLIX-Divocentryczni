<?php
namespace App\Controller;
use App\Model\Admin;
use App\Service\Router;
use App\Service\Templating;
class AuthController
{
    public function loginAction(Templating $templating, Router $router): ?string
    {
        if (!empty($_SESSION['admin_logged'])) {
            $router->redirect($router->generatePath('admin-dashboard'));
            return null;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            $admin = Admin::findByLogin($login);
            if ($admin && password_verify($password, $admin->getPassword())) {
                session_regenerate_id();
                $_SESSION['admin_logged'] = true;
                $_SESSION['admin_id'] = $admin->getId();
                $router->redirect($router->generatePath('admin-dashboard'));
                return null;
            } else {
                $error = "Błędny login lub hasło";
                return $templating->render('auth/login.html.php', [
                    'router' => $router,
                    'error' => $error
                ]);
            }
        }
        return $templating->render('auth/login.html.php', [
            'router' => $router,
            'error' => null
        ]);
    }
    public function logoutAction(Router $router): ?string
    {
        session_destroy(); 
        $path = $router->generatePath('movie-index'); 
        $router->redirect($path);
        return null;
    }
}