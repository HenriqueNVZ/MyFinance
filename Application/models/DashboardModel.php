<?php
    namespace User\MyFinance\models;
    use User\MyFinance\Core\Response;
    use PDO;
    use PDOException;
    use User\MyFinance\core\Database;

    class DashboardModel extends BaseModel{
        protected $pdo;
        protected $tableName = "gastos";

        public function __construct(Response $response) {
            parent::__construct($response);
            $this->pdo = Database::getInstance()->getConnection();
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

            $dataToSave = [
                'user_id' => $dataExpense['user_id'],
                'valor' => $dataExpense['valor'],
                'categoria' => $dataExpense['categoria'],
                'descricao' => $dataExpense['description'], 
                'data_gasto' => $dataExpense['date']
            ];

            $created = $this->create($dataToSave);

            if($created){
                return ['success' => true];
            }
            return ['errors' => ['Falha ao salvar o gasto.']];
        }

        public function updateExpenseData($DataEditExpense){
    
            // 1. Mapeamento e separação do ID (para a cláusula WHERE)
            // O ID é necessário para a validação (checagem de posse) e para o update
            $id = $DataEditExpense['id'];

            // CRIA O ARRAY COM AS CHAVES CORRETAS DO BANCO DE DADOS (descricao, data_gasto)
            $mappedData = [
                'valor'      => $DataEditExpense['valor'] ?? null,
                'categoria'  => $DataEditExpense['categoria'] ?? null,
                'descricao'  => $DataEditExpense['description'] ?? null,
                'data_gasto' => $DataEditExpense['date'] ?? null
            ];

            // 2. Chama a função de validação de dados no ARRAY MAPEADO
            // A validação é feita nos dados que serão salvos no banco.
            $errors = $this->validateExpenseData($DataEditExpense);
            
            // Se a validação retornar algum erro, retorna o array de erros detalhados
            if (!empty($errors)){
                return ['errors' => $errors]; 
            }
            
            // 3. O array a ser atualizado NÃO PODE conter o ID do WHERE
            // O array para o update é o array mapeado sem o ID.
            $dataToUpdate = $mappedData;
            
            // 4. Chamamos o método update que herdamos do BaseModel
            // Passamos o ID e os dados a serem alterados (que têm as chaves corretas)
            $updateSuccessful = $this->update($id, $dataToUpdate);
            
            // 5. Verifica o sucesso da operação no banco de dados
            if($updateSuccessful){
                return ['success' => true];
            } else {
                return ['errors' => ['database' => 'Falha ao atualizar os dados. Tente novamente.']];
            }
}

    }
?>