<?php

//Carrega o autoload
require_once __DIR__.'/../vendor/autoload.php';
// Carrega o arquivo .env, gerando a superglobal $_ENV para acessar dados de .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use User\MyFinance\core\Router;
use User\MyFinance\core\Request;
use User\MyFinance\core\Response;
use User\MyFinance\controllers\Controller;
use User\MyFinance\controllers\UserController;

// Criando instâncias
$request = new Request();
$response = new Response();
$controller = new Controller();
$userController = new UserController();
$router = new Router($request, $response, $controller,$userController);

//Registro de possiveis rotas a serem acessadas 
$router->registerGet('/', function() use ($controller) {
    echo $controller->renderView('login');
});

// Se acessar a path = /login o Controller renderiza a view
$router->registerGet('/login', function() use ($controller) {
    echo $controller->renderView('login');
});




$router->registerGet('/register', function() use ($userController) {
    // Agora o router chama o método showRegisterForm do UserController
    echo $userController->showRegisterForm();
});
    
// Resolver a rota
$router->resolve();

?>