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
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }            
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

        public function showEditExpenseForm($id){

            
            $expenseData = $this->dashboardModel->findById($id);
            if(!$expenseData){
                //Se nao houver dados do gasto retorna para dashboard
                header('Location: /dashboard');
                exit;
            }
            $allUserExpenses = $this->dashboardModel->getExpensesByUserId($_SESSION['user_id']);

            return $this->renderView('dashboard', [
                'expenses' => $allUserExpenses,
                'expense_to_edit' => $expenseData, //variavel que será usada na view
                'errors' => [],
                'formData' => $expenseData // Usamos os dados do gasto para preencher o formulário
            ]);
        }
        //Recebe a requisição POST com os dados editados de gasto, chama o Modelo para atualizar e redireciona o usuário para o dashboard.
        public function updateExpense($id){
            
            $DataEditExpense = $_POST;

            $DataEditExpense['id'] = $id;
            // 1. Chama um novo método no modelo para lidar com a validação e atualização
            $result = $this->dashboardModel->updateExpenseData($DataEditExpense);
            if(isset($result['success'])) {
                // 2. Se for um sucesso, redireciona o usuário
                header('Location: /dashboard');
                exit;
            } else {
                // 3. Se falhar, renderiza o formulário de edição novamente com os erros
                // A view de edição será recarregada com as mensagens de erro
                return $this->showEditExpenseForm($id, $result['errors'], $DataEditExpense);
            }
        }
    }
?>