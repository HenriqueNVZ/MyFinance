<?php
    namespace User\MyFinance\controllers;
    use User\MyFinance\Models\DashboardModel;
    use User\MyFinance\core\Response;


    //addExpense pega os dados e chama createExpense, create expense chama a validação e caso tudo de certo chama create e adiciona no banco
    class DashboardController extends Controller{
        
        protected $dashboardModel;
        public function __construct(DashboardModel $dashboardModel) {
            $this->dashboardModel = $dashboardModel;
        }

        // Método principal para exibir a página do dashboard
        public function index(){
            //Lógica de busca de dados do modelo
            session_start();
            $UserId = $_SESSION['user_id'] ?? false;
            if(!$UserId){
                //Se o usuario não estiver logado é redirecionado para login
                header("Location: /login");
                exit;
            }
            //Busca dados do usuario
            $expenses = $this->dashboardModel->getExpensesByUserId($UserId);
            //renderizar a view com os dados, array transformado em variavel
            echo $this->renderView('dashboard',['expenses' => $expenses]);
        }

        // Método para processar a adição de um novo gasto (POST)
        public function addExpense(){
            // Lógica para pegar os dados do formulário e chamar o model
            session_start();
            //Pegar o user id
            $UserId = $_SESSION['user_id'] ?? false;
            //Caso não possua um usuario logado é redirecionado para login
            if(!$UserId){
                header("Location: /login");
            }
            //Pega os dados do formulario de novo gasto
            $dataExpense = $_POST;
            //Adiciona no array dos dados a informação de qual é o id do usuario
            $dataExpense['user_id'] = $UserId;
            //expense guarda o retorno de createExpense - array associativo com o resultado da operação  
            $expense = $this->dashboardModel->createExpense($dataExpense);
            if(isset($expense['success'])){
                header("Location: /dashboard");
                exit;
            }else{
                return $this->renderView('dashboard', ['errors' => $expense['errors'], 'formData' => $dataExpense]);
            }
        }
    }
?>