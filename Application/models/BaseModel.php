<?php
    namespace User\MyFinance\models;
    use User\MyFinance\core\Database;
    use User\MyFinance\core\Response;
    use PDO;
    use PDOException;
    
        class BaseModel{

        protected $pdo;
        protected $tableName;

        public function __construct(Response $response) {
            $this->pdo = Database::getInstance()->getConnection();
         
        }
        
        //Esta função acessa todos os dados de uma tablea
        public function findAll(){
            $query = ("SELECT * FROM {$this->tableName}");
            try{
                //Preparando a query SQL - protege contra injeções SQL
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();
                //retorna o array dos dados
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }catch(PDOException $e){
                echo "Erro na consulta: " . $e->getMessage();
                return false;
            }
        }
          
        //Esta função busca um dado por id
        public function findById($id){
            
            $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
            try{
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id",$id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
                
            }catch(PDOException $e){
                echo "Erro na consulta: " . $e->getMessage();
                return false;
            }

        }

        //CRUD(exeto read)

        //Esta função cria um novo usuario
        public function create(array $data){
            //Pego o array dos dados extraio apenas as chaves
            $columnField = implode(",",array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $query = ("INSERT INTO {$this->tableName}($columnField) VALUES ($placeholders) ");
            
            try{
                $stmt = $this->pdo->prepare($query);
                // foreach($data as $key => &$value){
                //     $stmt->bindParam(":$key", $value); 
                // }                
                return $stmt->execute($data);
                
            }catch(PDOException $e){
                echo "Erro na consulta: " . $e->getMessage();
                return false;
            }
        }

        //Esta função atualiza dados
       public function update(int $id, array $data) {
        $setClause = '';
        // 1. O array $data contém os campos a serem atualizados (valor, categoria, etc.)
        foreach($data as $key => $value){
            // Note: Não precisamos do &value e bindParam aqui.
            // A chave no SET é o nome da coluna, e o placeholder é :nome_da_coluna
            $setClause .= " {$key} = :{$key},";
        }
        // remove a ultima virgula
        $setClause = rtrim($setClause, ', ');
        
        // 2. A query agora usa :id no WHERE
        $query = "UPDATE {$this->tableName} SET {$setClause} WHERE id = :id";
        
        // 3. O array de dados que será enviado ao execute
        // Ele é a união dos dados a serem alterados e do ID
        $dataToExecute = array_merge($data, ['id' => $id]);
        
        try{
            $stmt = $this->pdo->prepare($query);
            
            // CORREÇÃO CRÍTICA: Passamos o array completo, que inclui o 'id' no final.
            $stmt->execute($dataToExecute);
            
            // O execute() retorna true ou false, que será retornado
            return true; 
        }catch(PDOException $e){
            // Exibe a mensagem de erro detalhada do SQL para debug
            echo "Erro na atualização de dados: " . $e->getMessage();
            return false;
        }
}
        //Esta função apaga os dados de um usuario
        public function deleteExpenseData(int $id, int $userId) {
            $query = "DELETE FROM {$this->tableName} WHERE id = :id AND user_id = :user_id";

            try {
                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);

                return $stmt->execute(); 
            } catch (PDOException $e) {
                echo "Erro ao excluir dados: " . $e->getMessage();
                return false;
            }
        }

        
    }
?>