<?php

require_once __DIR__.'../vendor/autoload.php';

use User\MyFinance\Core\Router;
use User\MyFinance\Core\Request;
use User\MyFinance\Core\Response;
use User\MyFinance\Controllers\Controller;

// Criando instâncias
$request = new Request();
$response = new Response();
$router = new Router($request, $response, $controller);


$router->registerGet('/', function() use ($controller) {
    echo $controller->renderView('login');
});

// Se acessar a path = /login o Controller renderiza a view
$router->registerGet('/login', function() use ($controller) {
    echo $controller->renderView('login');
});


$router->registerGet('/register', function() use ($controller) {
    echo $controller->renderView('login');
});
    
// Resolver a rota
$router->resolve();

?>