<?php
    namespace User\MyFinance\models;
    use User\MyFinance\Core\Response;
    use PDO;
    use PDOException;
    use User\MyFinance\core\Database;
    use User\MyFinance\Controllers\DashboardController;

    class DashboardModel extends BaseModel{
        protected $pdo;
        protected $tableName = "gastos";
        public $dashboardController;

        public function __construct(Response $response, DashboardController $dashboardController) {
            parent::__construct($response);
            $this->pdo = Database::getInstance()->getConnection();
            $this->dashboardController = $dashboardController;
        }

        // Método para pegar todos os gastos de um usuário
        public function getExpensesByUserId($userId){
            //lógica de busca no banco de dados
            $query = ("SELECT * FROM {$this->tableName} WHERE user_id = :user_id ");
            try{
            $stmt = $this->pdo->prepare($query);
            //Protege contra ataques de injeção SQL,garantindo que o id seja um int(numero inteiro)
            $stmt->bindParam(":user_id",$userId,pdo::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(pdo::FETCH_ASSOC);
            }catch(PDOException $e){
                echo "Erro na consulta: " . $e->getMessage();
                return false;
            }
        }


        //Valida os dados para criar um novo gasto
        public function validateExpenseData($dataExpense){
            $errors = [];
            if(empty($dataExpense['valor']) || $dataExpense['valor'] < 0){
                $errors = ['valor' => "O valor deve ser preenchido e maior que 0!" ];
            }

            if(empty($dataExpense['categoria'])){
                $errors = ['categoria' => "A categoria é obrigatória!" ];

            }
            if(empty($dataExpense['date'])){
                $errors = ['data' => "A data é obrigatória!"];

            }
            return $errors;

        }



        //cria um novo gasto
        public function createExpense(array $dataExpense){
            // A lógica de validação e criação de gastos irá aqui.
            $errors = $this->validateExpenseData($dataExpense);
            if(!empty($errors)){
                return ['errors' => $errors];
            }

            $created = $this->create($dataExpense);

            if($created){
                return ['success' => true];
            }
            return ['errors' => ['Falha ao salvar o gasto.']];



        


        }






    }

?>