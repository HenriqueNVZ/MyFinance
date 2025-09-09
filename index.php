<?php
// Carregando os arquivos manualmente (sem autoload)
require_once 'core/Request.php';
require_once 'core/Response.php';
require_once 'controllers/LoginController.php';
require_once 'core/Router.php';

// Criando instâncias
$request = new Request();
$response = new Response();
$loginController = new LoginController();
$router = new Router($request, $response, $loginController);


$router->registerGet('/', function() use ($loginController) {
    echo $loginController->renderView('login');
});

// Se acessar a path = /login o LoginController renderiza a view
$router->registerGet('/login', function() use ($loginController) {
    echo $loginController->renderView('login');
});
    
// Resolver a rota
$router->resolve();
?>