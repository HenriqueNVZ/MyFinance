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
use User\MyFinance\controllers\LoginController;
use User\MyFinance\controllers\DashboardController;
use User\MyFinance\models\DashboardModel;
use User\MyFinance\Models\UserModel;

// Criando instâncias
$request = new Request();
$response = new Response();
$controller = new Controller();
$userController = new UserController();
$loginController = new LoginController();
$dashboardModel = new DashboardModel($response);
$userModel = new UserModel($response);
$dashboardController = new DashboardController($dashboardModel);
$router = new Router($request,$response,$controller,$userController,$loginController,$dashboardController);

// ROTAS GET: Apenas exibe as páginas
// Rota para exibir o formulário de login
$router->registerGet('/', function() use ($loginController) {
    echo $loginController->showLoginForm();
});

// Rota para exibir o formulário de login
$router->registerGet('/login', function() use ($loginController) {
    echo $loginController->showLoginForm();
});

//Rota para exibir o formulario de cadastro
$router->registerGet('/register', function() use ($userController) {
    echo $userController->showRegisterForm();
});

// Rota para exibir o dashboard (a ser protegida com sessão)
$router->registerGet('/dashboard', function() use ($dashboardController) {
    echo $dashboardController->index();
});

//Rota para exibir o modal e editar o gasto
$router->registerGet('/updateExpense{id}', function($id) use ($dashboardController) {
    echo $dashboardController->showEditeExpenseForm($id);
});

// ROTAS POST: Para processar formulários
//Rota para processar o formulario de login ao clicar em "Entrar"
$router->registerPost('/login', function() use ($loginController) {
    echo $loginController->login();
});

// Rota para processar o formulário de cadastro
$router->registerPost('/register', function() use ($userController) {
    echo $userController->registerUser();
});

$router->registerPost('/dashboard', function() use ($dashboardController) {
    echo $dashboardController->addExpense();
});

//Rota para adicionar um gasto no banco de dados
$router->registerPost('/addExpense', function() use ($dashboardController) {
    echo $dashboardController->addExpense();
});


// Resolve a rota
$router->resolve();


?>